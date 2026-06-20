<?php
/**
 * AutoHub LK — Service Model (providers, services, add-ons)
 */

class ServiceModel extends Model
{
    // ─── Provider Browse ─────────────────────────────────────────────────────

    public function searchProviders(array $filters, int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        $where = "sp.status='approved'"; $params = [];
        if (!empty($filters['category_id'])) {
            $where .= " AND EXISTS (SELECT 1 FROM services s WHERE s.provider_id=sp.id AND s.category_id=? AND s.status='approved')";
            $params[] = $filters['category_id'];
        }
        if (!empty($filters['district'])) { $where .= ' AND sp.district=?'; $params[] = $filters['district']; }
        if (!empty($filters['q']))        { $where .= ' AND (sp.business_name LIKE ? OR sp.description LIKE ?)'; $like="%{$filters['q']}%"; $params[]=$like; $params[]=$like; }
        $params[] = $perPage; $params[] = $offset;
        return $this->fetchAll(
            "SELECT sp.*, u.name AS owner_name,
                    (SELECT MIN(s.base_price) FROM services s WHERE s.provider_id=sp.id AND s.status='approved') AS min_price
             FROM service_providers sp
             JOIN users u ON u.id=sp.user_id
             WHERE $where
             ORDER BY sp.created_at DESC LIMIT ? OFFSET ?",
            $params
        );
    }

    public function countProviders(array $filters): int
    {
        $where = "sp.status='approved'"; $params = [];
        if (!empty($filters['category_id'])) {
            $where .= " AND EXISTS (SELECT 1 FROM services s WHERE s.provider_id=sp.id AND s.category_id=? AND s.status='approved')";
            $params[] = $filters['category_id'];
        }
        if (!empty($filters['district'])) { $where .= ' AND sp.district=?'; $params[] = $filters['district']; }
        if (!empty($filters['q']))        { $where .= ' AND (sp.business_name LIKE ? OR sp.description LIKE ?)'; $like="%{$filters['q']}%"; $params[]=$like; $params[]=$like; }
        return $this->count("SELECT COUNT(*) FROM service_providers sp WHERE $where", $params);
    }

    public function findProviderById(int $id): array|false
    {
        return $this->fetchOne(
            "SELECT sp.*, u.name AS owner_name, u.email AS owner_email
             FROM service_providers sp
             JOIN users u ON u.id=sp.user_id
             WHERE sp.id=?",
            [$id]
        );
    }

    public function findProviderByUser(int $userId): array|false
    {
        return $this->fetchOne('SELECT * FROM service_providers WHERE user_id=?', [$userId]);
    }

    public function getLatestProviders(int $limit = 6): array
    {
        return $this->fetchAll(
            "SELECT sp.* FROM service_providers sp WHERE sp.status='approved' ORDER BY sp.created_at DESC LIMIT ?",
            [$limit]
        );
    }

    // ─── Services ─────────────────────────────────────────────────────────────

    public function getServicesForProvider(int $providerId, bool $approvedOnly = true): array
    {
        $statusClause = $approvedOnly ? "AND s.status='approved'" : '';
        return $this->fetchAll(
            "SELECT s.*, sc.name AS category_name
             FROM services s
             JOIN service_categories sc ON sc.id=s.category_id
             WHERE s.provider_id=? $statusClause
             ORDER BY sc.name, s.name",
            [$providerId]
        );
    }

    public function getAddons(int $serviceId): array
    {
        return $this->fetchAll('SELECT * FROM service_addons WHERE service_id=? ORDER BY addon_name', [$serviceId]);
    }

    public function findServiceById(int $id): array|false
    {
        return $this->fetchOne('SELECT s.*,sc.name AS category_name FROM services s JOIN service_categories sc ON sc.id=s.category_id WHERE s.id=?', [$id]);
    }

    // ─── Dashboard — Provider ─────────────────────────────────────────────────

    public function createProvider(array $data): int
    {
        $this->execute(
            "INSERT INTO service_providers (user_id,business_name,address,district,city,contact_phone,working_hours,description,logo_path,status)
             VALUES (?,?,?,?,?,?,?,?,?,'pending')",
            [
                $data['user_id'], $data['business_name'], $data['address'],
                $data['district'], $data['city'], $data['contact_phone'],
                $data['working_hours'], $data['description'], $data['logo_path'] ?? null,
            ]
        );
        return (int) $this->lastInsertId();
    }

    public function updateProvider(int $id, array $data): void
    {
        $logoSql = isset($data['logo_path']) ? ',logo_path=?' : '';
        $params  = [$data['business_name'], $data['address'], $data['district'], $data['city'],
                    $data['contact_phone'], $data['working_hours'], $data['description']];
        if (isset($data['logo_path'])) $params[] = $data['logo_path'];
        $params[] = $id;
        $this->execute("UPDATE service_providers SET business_name=?,address=?,district=?,city=?,contact_phone=?,working_hours=?,description=?$logoSql WHERE id=?", $params);
    }

    // ─── Dashboard — Services ─────────────────────────────────────────────────

    public function createService(array $data): int
    {
        $this->execute(
            "INSERT INTO services (provider_id,category_id,name,description,base_price,status)
             VALUES (?,?,?,?,?,'pending')",
            [$data['provider_id'], $data['category_id'], $data['name'], $data['description'], $data['base_price']]
        );
        return (int) $this->lastInsertId();
    }

    public function updateService(int $id, array $data): void
    {
        $this->execute(
            "UPDATE services SET category_id=?,name=?,description=?,base_price=?,status='pending' WHERE id=?",
            [$data['category_id'], $data['name'], $data['description'], $data['base_price'], $id]
        );
    }

    public function deleteService(int $id, int $providerId): void
    {
        $this->execute('DELETE FROM services WHERE id=? AND provider_id=?', [$id, $providerId]);
    }

    // ─── Add-ons ─────────────────────────────────────────────────────────────

    public function addAddon(int $serviceId, string $name, float $price): void
    {
        $this->execute('INSERT INTO service_addons (service_id,addon_name,addon_price) VALUES (?,?,?)', [$serviceId, $name, $price]);
    }

    public function deleteAddon(int $addonId): void
    {
        $this->execute('DELETE FROM service_addons WHERE id=?', [$addonId]);
    }

    // ─── Admin ────────────────────────────────────────────────────────────────

    public function adminListProviders(int $page, int $perPage, string $status = ''): array
    {
        $offset = ($page - 1) * $perPage;
        $where = '1=1'; $params = [];
        if ($status) { $where .= ' AND sp.status=?'; $params[] = $status; }
        $params[] = $perPage; $params[] = $offset;
        return $this->fetchAll(
            "SELECT sp.*,u.name AS user_name,u.email AS user_email
             FROM service_providers sp JOIN users u ON u.id=sp.user_id
             WHERE $where ORDER BY sp.created_at DESC LIMIT ? OFFSET ?",
            $params
        );
    }

    public function adminCountProviders(string $status = ''): int
    {
        $where = '1=1'; $params = [];
        if ($status) { $where .= ' AND sp.status=?'; $params[] = $status; }
        return $this->count("SELECT COUNT(*) FROM service_providers sp WHERE $where", $params);
    }

    public function approveProvider(int $id): void { $this->execute("UPDATE service_providers SET status='approved' WHERE id=?", [$id]); }
    public function rejectProvider(int $id, string $reason): void { $this->execute("UPDATE service_providers SET status='rejected' WHERE id=?", [$id]); }
    public function adminDeleteProvider(int $id): void { $this->execute('DELETE FROM service_providers WHERE id=?', [$id]); }

    public function approveService(int $id): void { $this->execute("UPDATE services SET status='approved',rejection_reason=NULL WHERE id=?", [$id]); }
    public function rejectService(int $id, string $reason): void { $this->execute("UPDATE services SET status='rejected',rejection_reason=? WHERE id=?", [$reason, $id]); }
    public function adminDeleteService(int $id): void { $this->execute('DELETE FROM services WHERE id=?', [$id]); }
}
