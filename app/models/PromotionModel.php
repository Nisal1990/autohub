<?php
/**
 * AutoHub LK — Promotion Model
 */

class PromotionModel extends Model
{
    public function getActive(string $type = '', int $limit = 20): array
    {
        $where = "p.status='active' AND p.end_date >= CURDATE()";
        $params = [];
        if ($type) { $where .= ' AND p.listing_type=?'; $params[] = $type; }
        $params[] = $limit;
        return $this->fetchAll(
            "SELECT p.* FROM promotions p WHERE $where ORDER BY p.start_date DESC LIMIT ?",
            $params
        );
    }

    public function add(string $type, int $listingId, string $start, string $end): void
    {
        // Expire any existing active promotion for this listing
        $this->execute(
            "UPDATE promotions SET status='expired' WHERE listing_type=? AND listing_id=?",
            [$type, $listingId]
        );
        // Mark the listing as featured
        $table = match($type) {
            'vehicle' => 'vehicle_listings',
            'part'    => 'spare_part_listings',
            default   => null,
        };
        if ($table) {
            $this->execute("UPDATE $table SET featured=1 WHERE id=?", [$listingId]);
        }
        $this->execute(
            "INSERT INTO promotions (listing_type,listing_id,start_date,end_date,status) VALUES (?,?,?,?,'active')",
            [$type, $listingId, $start, $end]
        );
    }

    public function remove(int $id): void
    {
        $promo = $this->fetchOne('SELECT * FROM promotions WHERE id=?', [$id]);
        if ($promo) {
            $this->execute("UPDATE promotions SET status='expired' WHERE id=?", [$id]);
            // Remove featured flag
            $table = match($promo['listing_type']) {
                'vehicle' => 'vehicle_listings',
                'part'    => 'spare_part_listings',
                default   => null,
            };
            if ($table) {
                $this->execute("UPDATE $table SET featured=0 WHERE id=?", [$promo['listing_id']]);
            }
        }
    }

    public function adminList(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        return $this->fetchAll(
            "SELECT * FROM promotions ORDER BY created_at DESC LIMIT ? OFFSET ?",
            [$perPage, $offset]
        );
    }

    public function adminCount(): int { return $this->count('SELECT COUNT(*) FROM promotions'); }

    // Auto-expire promotions past end date
    public function expireOld(): void
    {
        $expired = $this->fetchAll("SELECT * FROM promotions WHERE status='active' AND end_date < CURDATE()");
        foreach ($expired as $p) {
            $this->execute("UPDATE promotions SET status='expired' WHERE id=?", [$p['id']]);
            $table = match($p['listing_type']) { 'vehicle'=>'vehicle_listings','part'=>'spare_part_listings',default=>null };
            if ($table) $this->execute("UPDATE $table SET featured=0 WHERE id=?", [$p['listing_id']]);
        }
    }
}
