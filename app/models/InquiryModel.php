<?php
/**
 * AutoHub LK — Inquiry Model
 */

class InquiryModel extends Model
{
    public function create(array $data): int
    {
        $this->execute(
            'INSERT INTO inquiries (listing_type,listing_id,sender_name,sender_phone,sender_email,message)
             VALUES (?,?,?,?,?,?)',
            [
                $data['listing_type'],
                $data['listing_id'] ?? null,
                $data['sender_name'],
                $data['sender_phone'] ?? '',
                $data['sender_email'] ?? '',
                $data['message'],
            ]
        );
        return (int) $this->lastInsertId();
    }

    public function getForListing(string $type, int $listingId): array
    {
        return $this->fetchAll(
            'SELECT * FROM inquiries WHERE listing_type=? AND listing_id=? ORDER BY created_at DESC',
            [$type, $listingId]
        );
    }

    // Get all inquiries for listings owned by a user
    public function getForUser(int $userId): array
    {
        return $this->fetchAll(
            "SELECT i.*,
                CASE i.listing_type
                    WHEN 'vehicle' THEN CONCAT(m.name,' ',vm.name)
                    WHEN 'part'    THEN sp.part_name
                    WHEN 'service' THEN sv.business_name
                END AS listing_title
             FROM inquiries i
             LEFT JOIN vehicle_listings vl ON i.listing_type='vehicle' AND vl.id=i.listing_id AND vl.user_id=?
             LEFT JOIN spare_part_listings sp ON i.listing_type='part' AND sp.id=i.listing_id AND sp.user_id=?
             LEFT JOIN service_providers sv ON i.listing_type='service' AND sv.id=i.listing_id AND sv.user_id=?
             LEFT JOIN manufacturers m ON m.id=vl.manufacturer_id
             LEFT JOIN vehicle_models vm ON vm.id=vl.model_id
             WHERE (vl.user_id=? OR sp.user_id=? OR sv.user_id=?)
             ORDER BY i.created_at DESC",
            [$userId, $userId, $userId, $userId, $userId, $userId]
        );
    }

    public function adminList(int $page, int $perPage, string $type = ''): array
    {
        $offset = ($page - 1) * $perPage;
        $where = '1=1'; $params = [];
        if ($type) { $where .= ' AND listing_type=?'; $params[] = $type; }
        $params[] = $perPage; $params[] = $offset;
        return $this->fetchAll(
            "SELECT * FROM inquiries WHERE $where ORDER BY created_at DESC LIMIT ? OFFSET ?",
            $params
        );
    }

    public function adminCount(string $type = ''): int
    {
        $where = '1=1'; $params = [];
        if ($type) { $where .= ' AND listing_type=?'; $params[] = $type; }
        return $this->count("SELECT COUNT(*) FROM inquiries WHERE $where", $params);
    }

    public function findById(int $id): array|false { return $this->fetchOne('SELECT * FROM inquiries WHERE id=?', [$id]); }
    public function markRead(int $id): void { $this->execute('UPDATE inquiries SET is_read=1 WHERE id=?', [$id]); }
    public function delete(int $id): void { $this->execute('DELETE FROM inquiries WHERE id=?', [$id]); }
    public function countUnread(): int { return $this->count("SELECT COUNT(*) FROM inquiries WHERE is_read=0"); }
}
