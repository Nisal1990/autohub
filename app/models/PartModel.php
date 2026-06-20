<?php
/**
 * AutoHub LK — Spare Part Model
 */

class PartModel extends Model
{
    public function search(array $filters, int $page, int $perPage): array
    {
        [$where, $params] = $this->buildFilters($filters);
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT sp.*, pc.name AS category_name,
                       spi.image_path AS primary_image
                FROM spare_part_listings sp
                JOIN part_categories pc ON pc.id = sp.category_id
                LEFT JOIN spare_part_images spi ON spi.listing_id = sp.id AND spi.is_primary = 1
                WHERE sp.status = 'approved' $where
                ORDER BY sp.featured DESC, sp.created_at DESC
                LIMIT ? OFFSET ?";
        $params[] = $perPage; $params[] = $offset;
        return $this->fetchAll($sql, $params);
    }

    public function countSearch(array $filters): int
    {
        [$where, $params] = $this->buildFilters($filters);
        return $this->count(
            "SELECT COUNT(*) FROM spare_part_listings sp
             JOIN part_categories pc ON pc.id=sp.category_id
             WHERE sp.status='approved' $where",
            $params
        );
    }

    public function findById(int $id): array|false
    {
        return $this->fetchOne(
            "SELECT sp.*, pc.name AS category_name,
                    u.name AS seller_user_name, u.email AS seller_email
             FROM spare_part_listings sp
             JOIN part_categories pc ON pc.id=sp.category_id
             JOIN users u ON u.id=sp.user_id
             WHERE sp.id=?",
            [$id]
        );
    }

    public function getImages(int $listingId): array
    {
        return $this->fetchAll(
            'SELECT * FROM spare_part_images WHERE listing_id=? ORDER BY is_primary DESC',
            [$listingId]
        );
    }

    public function getLatest(int $limit = 6): array
    {
        return $this->fetchAll(
            "SELECT sp.*, pc.name AS category_name, spi.image_path AS primary_image
             FROM spare_part_listings sp
             JOIN part_categories pc ON pc.id=sp.category_id
             LEFT JOIN spare_part_images spi ON spi.listing_id=sp.id AND spi.is_primary=1
             WHERE sp.status='approved'
             ORDER BY sp.created_at DESC LIMIT ?",
            [$limit]
        );
    }

    public function getFeatured(int $limit = 6): array
    {
        return $this->fetchAll(
            "SELECT sp.*, pc.name AS category_name, spi.image_path AS primary_image
             FROM spare_part_listings sp
             JOIN part_categories pc ON pc.id=sp.category_id
             LEFT JOIN spare_part_images spi ON spi.listing_id=sp.id AND spi.is_primary=1
             WHERE sp.status='approved' AND sp.featured=1
             ORDER BY sp.updated_at DESC LIMIT ?",
            [$limit]
        );
    }

    public function getByUser(int $userId, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        return $this->fetchAll(
            "SELECT sp.*, pc.name AS category_name, spi.image_path AS primary_image
             FROM spare_part_listings sp
             JOIN part_categories pc ON pc.id=sp.category_id
             LEFT JOIN spare_part_images spi ON spi.listing_id=sp.id AND spi.is_primary=1
             WHERE sp.user_id=?
             ORDER BY sp.created_at DESC LIMIT ? OFFSET ?",
            [$userId, $perPage, $offset]
        );
    }

    public function countByUser(int $userId): int
    {
        return $this->count('SELECT COUNT(*) FROM spare_part_listings WHERE user_id=?', [$userId]);
    }

    public function create(array $data): int
    {
        $this->execute(
            "INSERT INTO spare_part_listings
               (user_id,part_name,part_number,compatible_make,compatible_model,
                compatible_year_from,compatible_year_to,category_id,price,
                condition_type,stock_qty,description,district,city,seller_name,seller_phone,status)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'pending')",
            [
                $data['user_id'], $data['part_name'], $data['part_number'],
                $data['compatible_make'], $data['compatible_model'],
                $data['compatible_year_from'] ?: null, $data['compatible_year_to'] ?: null,
                $data['category_id'], $data['price'], $data['condition_type'],
                $data['stock_qty'] ?: null, $data['description'],
                $data['district'], $data['city'], $data['seller_name'], $data['seller_phone'],
            ]
        );
        return (int) $this->lastInsertId();
    }

    public function update(int $id, int $userId, array $data): void
    {
        $this->execute(
            "UPDATE spare_part_listings SET
               part_name=?,part_number=?,compatible_make=?,compatible_model=?,
               compatible_year_from=?,compatible_year_to=?,category_id=?,price=?,
               condition_type=?,stock_qty=?,description=?,district=?,city=?,
               seller_name=?,seller_phone=?,status='pending'
             WHERE id=? AND user_id=?",
            [
                $data['part_name'], $data['part_number'],
                $data['compatible_make'], $data['compatible_model'],
                $data['compatible_year_from'] ?: null, $data['compatible_year_to'] ?: null,
                $data['category_id'], $data['price'], $data['condition_type'],
                $data['stock_qty'] ?: null, $data['description'],
                $data['district'], $data['city'], $data['seller_name'], $data['seller_phone'],
                $id, $userId,
            ]
        );
    }

    public function delete(int $id, int $userId): void
    {
        $this->execute('DELETE FROM spare_part_listings WHERE id=? AND user_id=?', [$id, $userId]);
    }

    public function addImage(int $listingId, string $path, bool $isPrimary = false): void
    {
        $this->execute(
            'INSERT INTO spare_part_images (listing_id,image_path,is_primary) VALUES (?,?,?)',
            [$listingId, $path, $isPrimary ? 1 : 0]
        );
    }

    public function deleteImage(int $imageId, int $listingId): string|false
    {
        $img = $this->fetchOne('SELECT image_path FROM spare_part_images WHERE id=? AND listing_id=?', [$imageId, $listingId]);
        if ($img) { $this->execute('DELETE FROM spare_part_images WHERE id=?', [$imageId]); return $img['image_path']; }
        return false;
    }

    // Admin
    public function adminList(int $page, int $perPage, string $status = '', string $search = ''): array
    {
        $offset = ($page - 1) * $perPage;
        $where = '1=1'; $params = [];
        if ($status) { $where .= ' AND sp.status=?'; $params[] = $status; }
        if ($search) { $where .= ' AND (sp.part_name LIKE ? OR sp.part_number LIKE ?)'; $params[] = "%$search%"; $params[] = "%$search%"; }
        $params[] = $perPage; $params[] = $offset;
        return $this->fetchAll(
            "SELECT sp.*,pc.name AS category_name,u.name AS user_name
             FROM spare_part_listings sp
             JOIN part_categories pc ON pc.id=sp.category_id
             JOIN users u ON u.id=sp.user_id
             WHERE $where ORDER BY sp.created_at DESC LIMIT ? OFFSET ?",
            $params
        );
    }

    public function adminCount(string $status = '', string $search = ''): int
    {
        $where = '1=1'; $params = [];
        if ($status) { $where .= ' AND sp.status=?'; $params[] = $status; }
        if ($search) { $where .= ' AND (sp.part_name LIKE ? OR sp.part_number LIKE ?)'; $params[] = "%$search%"; $params[] = "%$search%"; }
        return $this->count("SELECT COUNT(*) FROM spare_part_listings sp WHERE $where", $params);
    }

    public function approve(int $id): void { $this->execute("UPDATE spare_part_listings SET status='approved',rejection_reason=NULL WHERE id=?", [$id]); }
    public function reject(int $id, string $reason): void { $this->execute("UPDATE spare_part_listings SET status='rejected',rejection_reason=? WHERE id=?", [$reason, $id]); }
    public function setFeatured(int $id, int $val): void { $this->execute('UPDATE spare_part_listings SET featured=? WHERE id=?', [$val, $id]); }
    public function adminDelete(int $id): void { $this->execute('DELETE FROM spare_part_listings WHERE id=?', [$id]); }

    private function buildFilters(array $f): array
    {
        $where = ''; $params = [];
        if (!empty($f['category_id']))   { $where .= ' AND sp.category_id=?';      $params[] = $f['category_id']; }
        if (!empty($f['compatible_make'])){ $where .= ' AND sp.compatible_make LIKE ?'; $params[] = "%{$f['compatible_make']}%"; }
        if (!empty($f['condition_type'])){ $where .= ' AND sp.condition_type=?';    $params[] = $f['condition_type']; }
        if (!empty($f['price_min']))     { $where .= ' AND sp.price>=?';            $params[] = $f['price_min']; }
        if (!empty($f['price_max']))     { $where .= ' AND sp.price<=?';            $params[] = $f['price_max']; }
        if (!empty($f['district']))      { $where .= ' AND sp.district=?';          $params[] = $f['district']; }
        if (!empty($f['q']))             { $where .= ' AND (sp.part_name LIKE ? OR sp.part_number LIKE ? OR sp.description LIKE ?)'; $like="%{$f['q']}%"; $params[]=$like; $params[]=$like; $params[]=$like; }
        return [$where, $params];
    }
}
