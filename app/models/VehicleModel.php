<?php
/**
 * AutoHub LK — Vehicle Model
 */

class VehicleModel extends Model
{
    // ─── Public Browse ────────────────────────────────────────────────────────

    public function search(array $filters, int $page, int $perPage): array
    {
        [$where, $params] = $this->buildFilters($filters);
        $offset = ($page - 1) * $perPage;
        $order  = $this->buildOrder($filters['sort'] ?? '');

        $sql = "SELECT vl.*, m.name AS manufacturer_name, vm.name AS model_name,
                       vi.image_path AS primary_image
                FROM vehicle_listings vl
                JOIN manufacturers m  ON m.id  = vl.manufacturer_id
                JOIN vehicle_models vm ON vm.id = vl.model_id
                LEFT JOIN vehicle_images vi ON vi.listing_id = vl.id AND vi.is_primary = 1
                WHERE vl.status = 'approved' $where
                ORDER BY vl.featured DESC, $order
                LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;
        return $this->fetchAll($sql, $params);
    }

    public function countSearch(array $filters): int
    {
        [$where, $params] = $this->buildFilters($filters);
        return $this->count(
            "SELECT COUNT(*) FROM vehicle_listings vl WHERE vl.status = 'approved' $where",
            $params
        );
    }

    public function findById(int $id): array|false
    {
        return $this->fetchOne(
            "SELECT vl.*, m.name AS manufacturer_name, vm.name AS model_name,
                    u.name AS owner_name, u.email AS owner_email
             FROM vehicle_listings vl
             JOIN manufacturers m   ON m.id  = vl.manufacturer_id
             JOIN vehicle_models vm ON vm.id = vl.model_id
             JOIN users u           ON u.id  = vl.user_id
             WHERE vl.id = ?",
            [$id]
        );
    }

    public function getImages(int $listingId): array
    {
        return $this->fetchAll(
            'SELECT * FROM vehicle_images WHERE listing_id = ? ORDER BY is_primary DESC, sort_order',
            [$listingId]
        );
    }

    public function getFeatured(int $limit = 8): array
    {
        return $this->fetchAll(
            "SELECT vl.*, m.name AS manufacturer_name, vm.name AS model_name,
                    vi.image_path AS primary_image
             FROM vehicle_listings vl
             JOIN manufacturers m  ON m.id  = vl.manufacturer_id
             JOIN vehicle_models vm ON vm.id = vl.model_id
             LEFT JOIN vehicle_images vi ON vi.listing_id = vl.id AND vi.is_primary = 1
             WHERE vl.status='approved' AND vl.featured=1
             ORDER BY vl.updated_at DESC LIMIT ?",
            [$limit]
        );
    }

    public function getLatest(int $limit = 6): array
    {
        return $this->fetchAll(
            "SELECT vl.*, m.name AS manufacturer_name, vm.name AS model_name,
                    vi.image_path AS primary_image
             FROM vehicle_listings vl
             JOIN manufacturers m  ON m.id  = vl.manufacturer_id
             JOIN vehicle_models vm ON vm.id = vl.model_id
             LEFT JOIN vehicle_images vi ON vi.listing_id = vl.id AND vi.is_primary = 1
             WHERE vl.status='approved'
             ORDER BY vl.created_at DESC LIMIT ?",
            [$limit]
        );
    }

    // ─── Dashboard ────────────────────────────────────────────────────────────

    public function getByUser(int $userId, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        return $this->fetchAll(
            "SELECT vl.*, m.name AS manufacturer_name, vm.name AS model_name,
                    vi.image_path AS primary_image
             FROM vehicle_listings vl
             JOIN manufacturers m  ON m.id  = vl.manufacturer_id
             JOIN vehicle_models vm ON vm.id = vl.model_id
             LEFT JOIN vehicle_images vi ON vi.listing_id = vl.id AND vi.is_primary = 1
             WHERE vl.user_id = ?
             ORDER BY vl.created_at DESC LIMIT ? OFFSET ?",
            [$userId, $perPage, $offset]
        );
    }

    public function countByUser(int $userId): int
    {
        return $this->count('SELECT COUNT(*) FROM vehicle_listings WHERE user_id = ?', [$userId]);
    }

    public function create(array $data): int
    {
        $this->execute(
            "INSERT INTO vehicle_listings
               (user_id,manufacturer_id,model_id,model_year,price,mileage,
                fuel_type,transmission,condition_type,body_type,description,
                district,city,seller_name,seller_phone,show_email,status)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'pending')",
            [
                $data['user_id'], $data['manufacturer_id'], $data['model_id'],
                $data['model_year'], $data['price'], $data['mileage'],
                $data['fuel_type'], $data['transmission'], $data['condition_type'],
                $data['body_type'], $data['description'],
                $data['district'], $data['city'],
                $data['seller_name'], $data['seller_phone'], $data['show_email'] ?? 0,
            ]
        );
        return (int) $this->lastInsertId();
    }

    public function update(int $id, int $userId, array $data): void
    {
        $this->execute(
            "UPDATE vehicle_listings SET
               manufacturer_id=?,model_id=?,model_year=?,price=?,mileage=?,
               fuel_type=?,transmission=?,condition_type=?,body_type=?,
               description=?,district=?,city=?,seller_name=?,seller_phone=?,
               show_email=?,status='pending'
             WHERE id=? AND user_id=?",
            [
                $data['manufacturer_id'], $data['model_id'], $data['model_year'],
                $data['price'], $data['mileage'], $data['fuel_type'],
                $data['transmission'], $data['condition_type'], $data['body_type'],
                $data['description'], $data['district'], $data['city'],
                $data['seller_name'], $data['seller_phone'], $data['show_email'] ?? 0,
                $id, $userId,
            ]
        );
    }

    public function markSold(int $id, int $userId): void
    {
        $this->execute(
            "UPDATE vehicle_listings SET status='sold' WHERE id=? AND user_id=?",
            [$id, $userId]
        );
    }

    public function delete(int $id, int $userId): void
    {
        $this->execute(
            'DELETE FROM vehicle_listings WHERE id=? AND user_id=?',
            [$id, $userId]
        );
    }

    // ─── Images ──────────────────────────────────────────────────────────────

    public function addImage(int $listingId, string $path, bool $isPrimary = false): void
    {
        $this->execute(
            'INSERT INTO vehicle_images (listing_id,image_path,is_primary) VALUES (?,?,?)',
            [$listingId, $path, $isPrimary ? 1 : 0]
        );
    }

    public function deleteImage(int $imageId, int $listingId): string|false
    {
        $img = $this->fetchOne(
            'SELECT image_path FROM vehicle_images WHERE id=? AND listing_id=?',
            [$imageId, $listingId]
        );
        if ($img) {
            $this->execute('DELETE FROM vehicle_images WHERE id=?', [$imageId]);
            return $img['image_path'];
        }
        return false;
    }

    public function setPrimaryImage(int $listingId, int $imageId): void
    {
        $this->execute('UPDATE vehicle_images SET is_primary=0 WHERE listing_id=?', [$listingId]);
        $this->execute('UPDATE vehicle_images SET is_primary=1 WHERE id=? AND listing_id=?', [$imageId, $listingId]);
    }

    // ─── Admin ────────────────────────────────────────────────────────────────

    public function adminList(int $page, int $perPage, string $status = '', string $search = ''): array
    {
        $offset = ($page - 1) * $perPage;
        $where  = '1=1';
        $params = [];
        if ($status) { $where .= ' AND vl.status=?'; $params[] = $status; }
        if ($search) { $where .= ' AND (m.name LIKE ? OR vm.name LIKE ?)'; $params[] = "%$search%"; $params[] = "%$search%"; }
        $params[] = $perPage; $params[] = $offset;
        return $this->fetchAll(
            "SELECT vl.*,m.name AS manufacturer_name,vm.name AS model_name,u.name AS user_name
             FROM vehicle_listings vl
             JOIN manufacturers m ON m.id=vl.manufacturer_id
             JOIN vehicle_models vm ON vm.id=vl.model_id
             JOIN users u ON u.id=vl.user_id
             WHERE $where ORDER BY vl.created_at DESC LIMIT ? OFFSET ?",
            $params
        );
    }

    public function adminCount(string $status = '', string $search = ''): int
    {
        $where = '1=1'; $params = [];
        if ($status) { $where .= ' AND vl.status=?'; $params[] = $status; }
        if ($search) { $where .= ' AND (m.name LIKE ? OR vm.name LIKE ?)'; $params[] = "%$search%"; $params[] = "%$search%"; }
        return $this->count(
            "SELECT COUNT(*) FROM vehicle_listings vl
             JOIN manufacturers m ON m.id=vl.manufacturer_id
             JOIN vehicle_models vm ON vm.id=vl.model_id
             WHERE $where",
            $params
        );
    }

    public function approve(int $id): void
    {
        $this->execute("UPDATE vehicle_listings SET status='approved',rejection_reason=NULL WHERE id=?", [$id]);
    }

    public function reject(int $id, string $reason): void
    {
        $this->execute("UPDATE vehicle_listings SET status='rejected',rejection_reason=? WHERE id=?", [$reason, $id]);
    }

    public function setFeatured(int $id, int $val): void
    {
        $this->execute('UPDATE vehicle_listings SET featured=? WHERE id=?', [$val, $id]);
    }

    public function adminDelete(int $id): void
    {
        $this->execute('DELETE FROM vehicle_listings WHERE id=?', [$id]);
    }

    // ─── Private Helpers ─────────────────────────────────────────────────────

    private function buildFilters(array $f): array
    {
        $where = ''; $params = [];
        if (!empty($f['manufacturer_id'])) { $where .= ' AND vl.manufacturer_id=?'; $params[] = $f['manufacturer_id']; }
        if (!empty($f['model_id']))        { $where .= ' AND vl.model_id=?';         $params[] = $f['model_id']; }
        if (!empty($f['year_from']))       { $where .= ' AND vl.model_year>=?';       $params[] = $f['year_from']; }
        if (!empty($f['year_to']))         { $where .= ' AND vl.model_year<=?';       $params[] = $f['year_to']; }
        if (!empty($f['price_min']))       { $where .= ' AND vl.price>=?';            $params[] = $f['price_min']; }
        if (!empty($f['price_max']))       { $where .= ' AND vl.price<=?';            $params[] = $f['price_max']; }
        if (!empty($f['district']))        { $where .= ' AND vl.district=?';          $params[] = $f['district']; }
        if (!empty($f['fuel_type']))       { $where .= ' AND vl.fuel_type=?';         $params[] = $f['fuel_type']; }
        if (!empty($f['transmission']))    { $where .= ' AND vl.transmission=?';      $params[] = $f['transmission']; }
        if (!empty($f['condition_type']))  { $where .= ' AND vl.condition_type=?';    $params[] = $f['condition_type']; }
        if (!empty($f['body_type']))       { $where .= ' AND vl.body_type=?';         $params[] = $f['body_type']; }
        if (!empty($f['q']))               { $like="%{$f['q']}%"; $where .= ' AND (m.name LIKE ? OR vm.name LIKE ? OR vl.description LIKE ?)'; $params[]=$like; $params[]=$like; $params[]=$like; }
        return [$where, $params];
    }

    private function buildOrder(string $sort): string
    {
        return match($sort) {
            'price_asc'  => 'vl.price ASC',
            'price_desc' => 'vl.price DESC',
            'year_desc'  => 'vl.model_year DESC',
            default      => 'vl.created_at DESC',
        };
    }
}
