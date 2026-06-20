<?php
/**
 * AutoHub LK — Lookup Model (manufacturers, models, categories, districts, cities)
 */

class LookupModel extends Model
{
    // Manufacturers
    public function getAllManufacturers(): array { return $this->fetchAll('SELECT * FROM manufacturers ORDER BY name'); }
    public function createManufacturer(string $name): void { $this->execute('INSERT IGNORE INTO manufacturers (name) VALUES (?)', [$name]); }
    public function deleteManufacturer(int $id): void { $this->execute('DELETE FROM manufacturers WHERE id=?', [$id]); }

    // Models
    public function getModelsByMake(int $makeId): array { return $this->fetchAll('SELECT * FROM vehicle_models WHERE manufacturer_id=? ORDER BY name', [$makeId]); }
    public function getAllModels(): array { return $this->fetchAll('SELECT vm.*,m.name AS manufacturer_name FROM vehicle_models vm JOIN manufacturers m ON m.id=vm.manufacturer_id ORDER BY m.name,vm.name'); }
    public function createModel(int $makeId, string $name): void { $this->execute('INSERT IGNORE INTO vehicle_models (manufacturer_id,name) VALUES (?,?)', [$makeId, $name]); }
    public function deleteModel(int $id): void { $this->execute('DELETE FROM vehicle_models WHERE id=?', [$id]); }

    // Part categories
    public function getAllPartCategories(): array { return $this->fetchAll('SELECT * FROM part_categories ORDER BY name'); }
    public function createPartCategory(string $name): void { $this->execute('INSERT IGNORE INTO part_categories (name) VALUES (?)', [$name]); }
    public function deletePartCategory(int $id): void { $this->execute('DELETE FROM part_categories WHERE id=?', [$id]); }

    // Service categories
    public function getAllServiceCategories(): array { return $this->fetchAll('SELECT * FROM service_categories ORDER BY name'); }
    public function createServiceCategory(string $name): void { $this->execute('INSERT IGNORE INTO service_categories (name) VALUES (?)', [$name]); }
    public function deleteServiceCategory(int $id): void { $this->execute('DELETE FROM service_categories WHERE id=?', [$id]); }

    // Districts
    public function getAllDistricts(): array { return $this->fetchAll('SELECT * FROM districts ORDER BY name'); }
    public function createDistrict(string $name): void { $this->execute('INSERT IGNORE INTO districts (name) VALUES (?)', [$name]); }

    // Cities
    public function getCitiesByDistrict(string $districtName): array
    {
        return $this->fetchAll(
            'SELECT c.* FROM cities c JOIN districts d ON d.id=c.district_id WHERE d.name=? ORDER BY c.name',
            [$districtName]
        );
    }
    public function getCitiesByDistrictId(int $districtId): array { return $this->fetchAll('SELECT * FROM cities WHERE district_id=? ORDER BY name', [$districtId]); }
    public function createCity(int $districtId, string $name): void { $this->execute('INSERT INTO cities (district_id,name) VALUES (?,?)', [$districtId, $name]); }
    public function deleteCity(int $id): void { $this->execute('DELETE FROM cities WHERE id=?', [$id]); }
    public function getAllCities(): array { return $this->fetchAll('SELECT c.*,d.name AS district_name FROM cities c JOIN districts d ON d.id=c.district_id ORDER BY d.name,c.name'); }
}
