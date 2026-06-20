-- ============================================================
-- AutoHub LK — Seed Data
-- Run AFTER schema.sql
-- ============================================================

USE `autohub_lk`;

-- ─── DEFAULT ADMIN USER ──────────────────────────────────────────────────────
-- Password: Admin@1234  (bcrypt, cost 12)
INSERT IGNORE INTO `users` (`name`,`email`,`phone`,`password_hash`,`role`,`district`,`city`,`status`) VALUES
('Site Admin','admin@autohub.lk','0771234567',
 '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin','Colombo','Colombo','active');

-- ─── DISTRICTS (all 25 Sri Lankan districts) ──────────────────────────────────
INSERT IGNORE INTO `districts` (`name`) VALUES
('Ampara'),('Anuradhapura'),('Badulla'),('Batticaloa'),('Colombo'),
('Galle'),('Gampaha'),('Hambantota'),('Jaffna'),('Kalutara'),
('Kandy'),('Kegalle'),('Kilinochchi'),('Kurunegala'),('Mannar'),
('Matale'),('Matara'),('Monaragala'),('Mullaitivu'),('Nuwara Eliya'),
('Polonnaruwa'),('Puttalam'),('Ratnapura'),('Trincomalee'),('Vavuniya');

-- ─── CITIES (major towns per district) ────────────────────────────────────────
-- Colombo
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Colombo'),'Colombo 01'),
((SELECT id FROM districts WHERE name='Colombo'),'Colombo 02'),
((SELECT id FROM districts WHERE name='Colombo'),'Colombo 03'),
((SELECT id FROM districts WHERE name='Colombo'),'Colombo 04'),
((SELECT id FROM districts WHERE name='Colombo'),'Colombo 05'),
((SELECT id FROM districts WHERE name='Colombo'),'Colombo 06'),
((SELECT id FROM districts WHERE name='Colombo'),'Colombo 07'),
((SELECT id FROM districts WHERE name='Colombo'),'Colombo 08'),
((SELECT id FROM districts WHERE name='Colombo'),'Colombo 09'),
((SELECT id FROM districts WHERE name='Colombo'),'Colombo 10'),
((SELECT id FROM districts WHERE name='Colombo'),'Dehiwala'),
((SELECT id FROM districts WHERE name='Colombo'),'Kotte'),
((SELECT id FROM districts WHERE name='Colombo'),'Maharagama'),
((SELECT id FROM districts WHERE name='Colombo'),'Moratuwa'),
((SELECT id FROM districts WHERE name='Colombo'),'Mount Lavinia'),
((SELECT id FROM districts WHERE name='Colombo'),'Nugegoda'),
((SELECT id FROM districts WHERE name='Colombo'),'Piliyandala'),
((SELECT id FROM districts WHERE name='Colombo'),'Rajagiriya'),
((SELECT id FROM districts WHERE name='Colombo'),'Ratmalana'),
((SELECT id FROM districts WHERE name='Colombo'),'Wellampitiya');

-- Gampaha
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Gampaha'),'Gampaha'),
((SELECT id FROM districts WHERE name='Gampaha'),'Negombo'),
((SELECT id FROM districts WHERE name='Gampaha'),'Wattala'),
((SELECT id FROM districts WHERE name='Gampaha'),'Kadawatha'),
((SELECT id FROM districts WHERE name='Gampaha'),'Kiribathgoda'),
((SELECT id FROM districts WHERE name='Gampaha'),'Ja-Ela'),
((SELECT id FROM districts WHERE name='Gampaha'),'Kelaniya'),
((SELECT id FROM districts WHERE name='Gampaha'),'Ragama'),
((SELECT id FROM districts WHERE name='Gampaha'),'Minuwangoda'),
((SELECT id FROM districts WHERE name='Gampaha'),'Divulapitiya');

-- Kalutara
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Kalutara'),'Kalutara'),
((SELECT id FROM districts WHERE name='Kalutara'),'Panadura'),
((SELECT id FROM districts WHERE name='Kalutara'),'Horana'),
((SELECT id FROM districts WHERE name='Kalutara'),'Matugama'),
((SELECT id FROM districts WHERE name='Kalutara'),'Aluthgama'),
((SELECT id FROM districts WHERE name='Kalutara'),'Beruwala'),
((SELECT id FROM districts WHERE name='Kalutara'),'Bandaragama');

-- Kandy
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Kandy'),'Kandy'),
((SELECT id FROM districts WHERE name='Kandy'),'Peradeniya'),
((SELECT id FROM districts WHERE name='Kandy'),'Katugastota'),
((SELECT id FROM districts WHERE name='Kandy'),'Digana'),
((SELECT id FROM districts WHERE name='Kandy'),'Kundasale'),
((SELECT id FROM districts WHERE name='Kandy'),'Gampola'),
((SELECT id FROM districts WHERE name='Kandy'),'Nawalapitiya');

-- Galle
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Galle'),'Galle'),
((SELECT id FROM districts WHERE name='Galle'),'Ambalangoda'),
((SELECT id FROM districts WHERE name='Galle'),'Hikkaduwa'),
((SELECT id FROM districts WHERE name='Galle'),'Elpitiya'),
((SELECT id FROM districts WHERE name='Galle'),'Karandeniya'),
((SELECT id FROM districts WHERE name='Galle'),'Baddegama');

-- Matara
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Matara'),'Matara'),
((SELECT id FROM districts WHERE name='Matara'),'Weligama'),
((SELECT id FROM districts WHERE name='Matara'),'Akuressa'),
((SELECT id FROM districts WHERE name='Matara'),'Dikwella'),
((SELECT id FROM districts WHERE name='Matara'),'Hakmana');

-- Kurunegala
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Kurunegala'),'Kurunegala'),
((SELECT id FROM districts WHERE name='Kurunegala'),'Kuliyapitiya'),
((SELECT id FROM districts WHERE name='Kurunegala'),'Narammala'),
((SELECT id FROM districts WHERE name='Kurunegala'),'Mawathagama'),
((SELECT id FROM districts WHERE name='Kurunegala'),'Pannala'),
((SELECT id FROM districts WHERE name='Kurunegala'),'Nikaweratiya');

-- Anuradhapura
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Anuradhapura'),'Anuradhapura'),
((SELECT id FROM districts WHERE name='Anuradhapura'),'Medawachchiya'),
((SELECT id FROM districts WHERE name='Anuradhapura'),'Mihintale'),
((SELECT id FROM districts WHERE name='Anuradhapura'),'Kekirawa');

-- Ratnapura
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Ratnapura'),'Ratnapura'),
((SELECT id FROM districts WHERE name='Ratnapura'),'Embilipitiya'),
((SELECT id FROM districts WHERE name='Ratnapura'),'Balangoda'),
((SELECT id FROM districts WHERE name='Ratnapura'),'Pelmadulla');

-- Jaffna
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Jaffna'),'Jaffna'),
((SELECT id FROM districts WHERE name='Jaffna'),'Chavakachcheri'),
((SELECT id FROM districts WHERE name='Jaffna'),'Point Pedro'),
((SELECT id FROM districts WHERE name='Jaffna'),'Nallur');

-- Badulla
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Badulla'),'Badulla'),
((SELECT id FROM districts WHERE name='Badulla'),'Bandarawela'),
((SELECT id FROM districts WHERE name='Badulla'),'Haputale'),
((SELECT id FROM districts WHERE name='Badulla'),'Ella'),
((SELECT id FROM districts WHERE name='Badulla'),'Mahiyanganaya');

-- Trincomalee
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Trincomalee'),'Trincomalee'),
((SELECT id FROM districts WHERE name='Trincomalee'),'Kinniya'),
((SELECT id FROM districts WHERE name='Trincomalee'),'Mutur');

-- Batticaloa
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Batticaloa'),'Batticaloa'),
((SELECT id FROM districts WHERE name='Batticaloa'),'Kalmunai'),
((SELECT id FROM districts WHERE name='Batticaloa'),'Valaichchenai');

-- Ampara
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Ampara'),'Ampara'),
((SELECT id FROM districts WHERE name='Ampara'),'Kalmunai'),
((SELECT id FROM districts WHERE name='Ampara'),'Akkaraipattu');

-- Hambantota
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Hambantota'),'Hambantota'),
((SELECT id FROM districts WHERE name='Hambantota'),'Tangalle'),
((SELECT id FROM districts WHERE name='Hambantota'),'Tissamaharama'),
((SELECT id FROM districts WHERE name='Hambantota'),'Weeraketiya');

-- Nuwara Eliya
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Nuwara Eliya'),'Nuwara Eliya'),
((SELECT id FROM districts WHERE name='Nuwara Eliya'),'Hatton'),
((SELECT id FROM districts WHERE name='Nuwara Eliya'),'Ginigathena'),
((SELECT id FROM districts WHERE name='Nuwara Eliya'),'Ragala');

-- Puttalam
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Puttalam'),'Puttalam'),
((SELECT id FROM districts WHERE name='Puttalam'),'Chilaw'),
((SELECT id FROM districts WHERE name='Puttalam'),'Wennappuwa'),
((SELECT id FROM districts WHERE name='Puttalam'),'Marawila');

-- Kegalle
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Kegalle'),'Kegalle'),
((SELECT id FROM districts WHERE name='Kegalle'),'Mawanella'),
((SELECT id FROM districts WHERE name='Kegalle'),'Warakapola'),
((SELECT id FROM districts WHERE name='Kegalle'),'Rambukkana');

-- Polonnaruwa
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Polonnaruwa'),'Polonnaruwa'),
((SELECT id FROM districts WHERE name='Polonnaruwa'),'Medirigiriya'),
((SELECT id FROM districts WHERE name='Polonnaruwa'),'Hingurakgoda');

-- Matale
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Matale'),'Matale'),
((SELECT id FROM districts WHERE name='Matale'),'Dambulla'),
((SELECT id FROM districts WHERE name='Matale'),'Sigiriya'),
((SELECT id FROM districts WHERE name='Matale'),'Rattota');

-- Monaragala
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Monaragala'),'Monaragala'),
((SELECT id FROM districts WHERE name='Monaragala'),'Wellawaya'),
((SELECT id FROM districts WHERE name='Monaragala'),'Bibile');

-- Vavuniya
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Vavuniya'),'Vavuniya'),
((SELECT id FROM districts WHERE name='Vavuniya'),'Cheddikulam');

-- Mannar
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Mannar'),'Mannar'),
((SELECT id FROM districts WHERE name='Mannar'),'Murunkan');

-- Kilinochchi
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Kilinochchi'),'Kilinochchi'),
((SELECT id FROM districts WHERE name='Kilinochchi'),'Pallai');

-- Mullaitivu
INSERT IGNORE INTO `cities` (`district_id`,`name`) VALUES
((SELECT id FROM districts WHERE name='Mullaitivu'),'Mullaitivu'),
((SELECT id FROM districts WHERE name='Mullaitivu'),'Oddusuddan');

-- ─── VEHICLE MANUFACTURERS ────────────────────────────────────────────────────
INSERT IGNORE INTO `manufacturers` (`name`) VALUES
('Toyota'),('Honda'),('Nissan'),('Mazda'),('Mitsubishi'),
('Suzuki'),('Subaru'),('Isuzu'),('Daihatsu'),('Hyundai'),
('Kia'),('Ford'),('Volkswagen'),('BMW'),('Mercedes-Benz'),
('Audi'),('Perodua'),('Tata'),('Mahindra'),('Bajaj'),
('TVS'),('Hero'),('Yamaha'),('Royal Enfield'),('KTM'),
('Ashok Leyland'),('Micro'),('DFSK'),('BAIC'),('Chery');

-- ─── VEHICLE MODELS ───────────────────────────────────────────────────────────
-- Toyota
INSERT IGNORE INTO `vehicle_models` (`manufacturer_id`,`name`) VALUES
((SELECT id FROM manufacturers WHERE name='Toyota'),'Corolla'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Axio'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Premio'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Allion'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Prius'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Aqua'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Vitz'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Rush'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Raize'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Land Cruiser'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Prado'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Hilux'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Hiace'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'KDH'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Camry'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Wish'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'IST'),
((SELECT id FROM manufacturers WHERE name='Toyota'),'Fielder');

-- Honda
INSERT IGNORE INTO `vehicle_models` (`manufacturer_id`,`name`) VALUES
((SELECT id FROM manufacturers WHERE name='Honda'),'Civic'),
((SELECT id FROM manufacturers WHERE name='Honda'),'Fit'),
((SELECT id FROM manufacturers WHERE name='Honda'),'Vezel'),
((SELECT id FROM manufacturers WHERE name='Honda'),'CR-V'),
((SELECT id FROM manufacturers WHERE name='Honda'),'HR-V'),
((SELECT id FROM manufacturers WHERE name='Honda'),'WR-V'),
((SELECT id FROM manufacturers WHERE name='Honda'),'Accord'),
((SELECT id FROM manufacturers WHERE name='Honda'),'Brio'),
((SELECT id FROM manufacturers WHERE name='Honda'),'Jazz'),
((SELECT id FROM manufacturers WHERE name='Honda'),'Insight'),
((SELECT id FROM manufacturers WHERE name='Honda'),'Legend');

-- Nissan
INSERT IGNORE INTO `vehicle_models` (`manufacturer_id`,`name`) VALUES
((SELECT id FROM manufacturers WHERE name='Nissan'),'Sunny'),
((SELECT id FROM manufacturers WHERE name='Nissan'),'Tiida'),
((SELECT id FROM manufacturers WHERE name='Nissan'),'X-Trail'),
((SELECT id FROM manufacturers WHERE name='Nissan'),'Patrol'),
((SELECT id FROM manufacturers WHERE name='Nissan'),'Leaf'),
((SELECT id FROM manufacturers WHERE name='Nissan'),'Navara'),
((SELECT id FROM manufacturers WHERE name='Nissan'),'Note'),
((SELECT id FROM manufacturers WHERE name='Nissan'),'Bluebird');

-- Mazda
INSERT IGNORE INTO `vehicle_models` (`manufacturer_id`,`name`) VALUES
((SELECT id FROM manufacturers WHERE name='Mazda'),'Demio'),
((SELECT id FROM manufacturers WHERE name='Mazda'),'Axela'),
((SELECT id FROM manufacturers WHERE name='Mazda'),'Atenza'),
((SELECT id FROM manufacturers WHERE name='Mazda'),'CX-5'),
((SELECT id FROM manufacturers WHERE name='Mazda'),'CX-3'),
((SELECT id FROM manufacturers WHERE name='Mazda'),'BT-50');

-- Mitsubishi
INSERT IGNORE INTO `vehicle_models` (`manufacturer_id`,`name`) VALUES
((SELECT id FROM manufacturers WHERE name='Mitsubishi'),'Lancer'),
((SELECT id FROM manufacturers WHERE name='Mitsubishi'),'Outlander'),
((SELECT id FROM manufacturers WHERE name='Mitsubishi'),'Montero'),
((SELECT id FROM manufacturers WHERE name='Mitsubishi'),'L200'),
((SELECT id FROM manufacturers WHERE name='Mitsubishi'),'Pajero'),
((SELECT id FROM manufacturers WHERE name='Mitsubishi'),'Colt'),
((SELECT id FROM manufacturers WHERE name='Mitsubishi'),'Eclipse Cross'),
((SELECT id FROM manufacturers WHERE name='Mitsubishi'),'Delica');

-- Suzuki
INSERT IGNORE INTO `vehicle_models` (`manufacturer_id`,`name`) VALUES
((SELECT id FROM manufacturers WHERE name='Suzuki'),'Alto'),
((SELECT id FROM manufacturers WHERE name='Suzuki'),'Swift'),
((SELECT id FROM manufacturers WHERE name='Suzuki'),'Wagon R'),
((SELECT id FROM manufacturers WHERE name='Suzuki'),'Vitara'),
((SELECT id FROM manufacturers WHERE name='Suzuki'),'Jimny'),
((SELECT id FROM manufacturers WHERE name='Suzuki'),'Ciaz'),
((SELECT id FROM manufacturers WHERE name='Suzuki'),'Baleno'),
((SELECT id FROM manufacturers WHERE name='Suzuki'),'Every'),
((SELECT id FROM manufacturers WHERE name='Suzuki'),'Spacia');

-- Subaru
INSERT IGNORE INTO `vehicle_models` (`manufacturer_id`,`name`) VALUES
((SELECT id FROM manufacturers WHERE name='Subaru'),'Impreza'),
((SELECT id FROM manufacturers WHERE name='Subaru'),'Forester'),
((SELECT id FROM manufacturers WHERE name='Subaru'),'Outback'),
((SELECT id FROM manufacturers WHERE name='Subaru'),'XV');

-- Hyundai
INSERT IGNORE INTO `vehicle_models` (`manufacturer_id`,`name`) VALUES
((SELECT id FROM manufacturers WHERE name='Hyundai'),'Accent'),
((SELECT id FROM manufacturers WHERE name='Hyundai'),'Tucson'),
((SELECT id FROM manufacturers WHERE name='Hyundai'),'Santro'),
((SELECT id FROM manufacturers WHERE name='Hyundai'),'Creta'),
((SELECT id FROM manufacturers WHERE name='Hyundai'),'Ioniq');

-- Kia
INSERT IGNORE INTO `vehicle_models` (`manufacturer_id`,`name`) VALUES
((SELECT id FROM manufacturers WHERE name='Kia'),'Picanto'),
((SELECT id FROM manufacturers WHERE name='Kia'),'Sportage'),
((SELECT id FROM manufacturers WHERE name='Kia'),'Sorento'),
((SELECT id FROM manufacturers WHERE name='Kia'),'Stinger'),
((SELECT id FROM manufacturers WHERE name='Kia'),'EV6');

-- Isuzu
INSERT IGNORE INTO `vehicle_models` (`manufacturer_id`,`name`) VALUES
((SELECT id FROM manufacturers WHERE name='Isuzu'),'D-Max'),
((SELECT id FROM manufacturers WHERE name='Isuzu'),'MU-X'),
((SELECT id FROM manufacturers WHERE name='Isuzu'),'Elf');

-- ─── PART CATEGORIES ──────────────────────────────────────────────────────────
INSERT IGNORE INTO `part_categories` (`name`) VALUES
('Engine & Drivetrain'),
('Body & Exterior'),
('Electrical & Lighting'),
('Suspension & Steering'),
('Brakes'),
('Interior & Accessories'),
('Tyres & Wheels'),
('Air Conditioning'),
('Cooling & Radiator'),
('Exhaust & Emission'),
('Transmission & Clutch'),
('Fuel System'),
('Other');

-- ─── SERVICE CATEGORIES ───────────────────────────────────────────────────────
INSERT IGNORE INTO `service_categories` (`name`) VALUES
('Full Vehicle Service'),
('Oil & Filter Change'),
('AC Repair & Gas Refill'),
('Body Repair & Painting'),
('Tyre Service & Alignment'),
('Battery Service'),
('Engine Tuning & Overhaul'),
('Wheel Alignment & Balancing'),
('Electrical & Wiring'),
('Interior Cleaning & Detailing'),
('Brake Service'),
('Suspension & Steering Repair'),
('Windscreen & Glass'),
('Towing & Recovery'),
('Vehicle Inspection & Diagnosis'),
('Other');
