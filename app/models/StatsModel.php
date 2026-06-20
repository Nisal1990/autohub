<?php
/**
 * AutoHub LK — Stats Model
 */

class StatsModel extends Model
{
    public function getSiteStats(): array
    {
        return [
            'total_vehicles' => $this->count("SELECT COUNT(*) FROM vehicle_listings WHERE status='approved'"),
            'total_parts'    => $this->count("SELECT COUNT(*) FROM spare_part_listings WHERE status='approved'"),
            'total_services' => $this->count("SELECT COUNT(*) FROM service_providers WHERE status='approved'"),
            'total_users'    => $this->count("SELECT COUNT(*) FROM users WHERE role='user'"),
        ];
    }

    public function getAdminDashboardStats(): array
    {
        return [
            'total_users'             => $this->count("SELECT COUNT(*) FROM users WHERE role='user'"),
            'active_users'            => $this->count("SELECT COUNT(*) FROM users WHERE role='user' AND status='active'"),
            'suspended_users'         => $this->count("SELECT COUNT(*) FROM users WHERE role='user' AND status='suspended'"),
            'total_vehicles'          => $this->count('SELECT COUNT(*) FROM vehicle_listings'),
            'pending_vehicles'        => $this->count("SELECT COUNT(*) FROM vehicle_listings WHERE status='pending'"),
            'approved_vehicles'       => $this->count("SELECT COUNT(*) FROM vehicle_listings WHERE status='approved'"),
            'rejected_vehicles'       => $this->count("SELECT COUNT(*) FROM vehicle_listings WHERE status='rejected'"),
            'total_parts'             => $this->count('SELECT COUNT(*) FROM spare_part_listings'),
            'pending_parts'           => $this->count("SELECT COUNT(*) FROM spare_part_listings WHERE status='pending'"),
            'approved_parts'          => $this->count("SELECT COUNT(*) FROM spare_part_listings WHERE status='approved'"),
            'total_providers'         => $this->count('SELECT COUNT(*) FROM service_providers'),
            'pending_providers'       => $this->count("SELECT COUNT(*) FROM service_providers WHERE status='pending'"),
            'total_inquiries'         => $this->count('SELECT COUNT(*) FROM inquiries'),
            'unread_inquiries'        => $this->count("SELECT COUNT(*) FROM inquiries WHERE is_read=0"),
            'active_promotions'       => $this->count("SELECT COUNT(*) FROM promotions WHERE status='active' AND end_date >= CURDATE()"),
        ];
    }

    public function getRecentActivity(int $limit = 10): array
    {
        // Combine latest listings from all 3 categories
        $sql = "
            (SELECT 'vehicle' AS type, CONCAT(m.name,' ',vm.name) AS title, vl.status, vl.created_at
             FROM vehicle_listings vl
             JOIN manufacturers m ON m.id=vl.manufacturer_id
             JOIN vehicle_models vm ON vm.id=vl.model_id
             ORDER BY vl.created_at DESC LIMIT $limit)
            UNION ALL
            (SELECT 'part', sp.part_name, sp.status, sp.created_at FROM spare_part_listings sp ORDER BY sp.created_at DESC LIMIT $limit)
            UNION ALL
            (SELECT 'service', svp.business_name, svp.status, svp.created_at FROM service_providers svp ORDER BY svp.created_at DESC LIMIT $limit)
            ORDER BY created_at DESC LIMIT $limit
        ";
        return $this->fetchAll($sql);
    }

    public function getListingsByDistrict(): array
    {
        return $this->fetchAll(
            "SELECT COALESCE(v.district, p.district) AS district,
                    COALESCE(v.vehicle_count, 0) AS vehicle_count,
                    COALESCE(p.part_count, 0)    AS part_count
             FROM
               (SELECT district, COUNT(*) AS vehicle_count FROM vehicle_listings WHERE status='approved' AND district!='' GROUP BY district) v
             LEFT JOIN
               (SELECT district, COUNT(*) AS part_count FROM spare_part_listings WHERE status='approved' AND district!='' GROUP BY district) p
             ON v.district = p.district
             ORDER BY (COALESCE(v.vehicle_count,0)+COALESCE(p.part_count,0)) DESC LIMIT 15"
        );
    }

    public function getListingsTrend(): array
    {
        // Returns daily counts for the last 30 days
        return $this->fetchAll(
            "SELECT days.day,
                    COALESCE(v.vehicles, 0) AS vehicles,
                    COALESCE(p.parts,    0) AS parts
             FROM (
               SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL seq.n DAY), '%Y-%m-%d') AS day
               FROM (SELECT 0 n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
                    UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
                    UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14
                    UNION SELECT 15 UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19
                    UNION SELECT 20 UNION SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24
                    UNION SELECT 25 UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29) seq
             ) days
             LEFT JOIN (SELECT DATE(created_at) AS d, COUNT(*) AS vehicles FROM vehicle_listings GROUP BY d) v ON v.d = days.day
             LEFT JOIN (SELECT DATE(created_at) AS d, COUNT(*) AS parts    FROM spare_part_listings GROUP BY d) p ON p.d = days.day
             ORDER BY days.day"
        );
    }
}
