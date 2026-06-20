-- AutoHub LK — Demo Listings (uses hardcoded IDs from seed.sql)
-- Manufacturers: Toyota=1, Honda=2, Nissan=3, Suzuki=6
-- Models: Corolla=1, Prius=5, Vezel=21, Civic=19, Fit=20, Alto=52, Swift=53, X-Trail=32
-- Part Categories: Engine=1, Body=2, Electrical=3, Suspension=4, Brakes=5, Interior=6, Tyres=7, AC=8, Cooling=9
-- Service Categories: Full Service=1, Oil Change=2, AC Repair=3, Body Repair=4, Tyre/Align=5, Battery=6, Engine Tuning=7, Wheel Align=8, Electrical=9

USE autohub_lk;

-- ─── Demo Users ───────────────────────────────────────────────────────────────
-- Password for all demo users: demo1234
INSERT IGNORE INTO users (name, email, phone, password_hash, role, district, city, status)
VALUES
  ('Kamal Silva',    'kamal@autohub.lk',   '0771234567',
   '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uXa6g7/Xi',
   'user', 'Colombo', 'Nugegoda', 'active'),
  ('Lanka Parts',    'parts@autohub.lk',   '0112222222',
   '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uXa6g7/Xi',
   'user', 'Gampaha', 'Wattala', 'active'),
  ('Colombo Motors', 'motors@autohub.lk',  '0113333333',
   '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uXa6g7/Xi',
   'user', 'Kandy', 'Kandy', 'active');

SET @u1 = (SELECT id FROM users WHERE email='kamal@autohub.lk');
SET @u2 = (SELECT id FROM users WHERE email='parts@autohub.lk');
SET @u3 = (SELECT id FROM users WHERE email='motors@autohub.lk');

-- ─── Vehicle Listings ─────────────────────────────────────────────────────────
INSERT INTO vehicle_listings
  (user_id, manufacturer_id, model_id, model_year, price, mileage,
   fuel_type, transmission, condition_type, body_type, description,
   district, city, seller_name, seller_phone, show_email, status, featured)
VALUES
  -- 1: Toyota Corolla 2019 — Featured
  (@u1, 1, 1, 2019, 4850000, 52000, 'Petrol', 'Automatic', 'Used', 'Car',
   'Well-maintained Toyota Corolla 2019. Single owner, full Toyota dealer service history. New tyres fitted. Accident-free. All features working perfectly. Reason for selling: upgrading.',
   'Colombo', 'Nugegoda', 'Kamal Silva', '0771234567', 1, 'approved', 1),

  -- 2: Honda Vezel 2020 Hybrid — Featured
  (@u1, 2, 21, 2020, 6200000, 38000, 'Hybrid', 'CVT', 'Used', 'SUV',
   'Honda Vezel 2020 RS Hybrid. Excellent fuel economy 18km/l city. Honda Sensing package, reverse camera, sunroof. One owner from new. Mint condition — must see.',
   'Gampaha', 'Negombo', 'Priya Fernando', '0712345678', 0, 'approved', 1),

  -- 3: Toyota Prius 2018 PHV
  (@u1, 1, 5, 2018, 7500000, 65000, 'Hybrid', 'CVT', 'Used', 'Car',
   'Toyota Prius PHV 2018. Plug-in hybrid with 35km electric range. Leather seats, push start, lane assist. Very economical — Rs. 2/km running cost. Negotiable for genuine buyers.',
   'Kandy', 'Peradeniya', 'Ruwan Perera', '0776543210', 1, 'approved', 0),

  -- 4: Suzuki Alto 2021
  (@u2, 6, 52, 2021, 2800000, 18000, 'Petrol', 'Manual', 'Used', 'Car',
   'Suzuki Alto 800cc 2021. Low mileage — driven only 18,000km. Perfect city car, easy to park. Outstanding fuel economy. Owner migrating — genuine buyers only. Price slightly negotiable.',
   'Galle', 'Galle', 'Nimal Jayasinghe', '0703456789', 1, 'approved', 0),

  -- 5: Nissan X-Trail 2017
  (@u2, 3, 32, 2017, 8900000, 78000, 'Diesel', 'Automatic', 'Used', 'SUV',
   'Nissan X-Trail T32 2017. Full 4WD. 7-seater with 3rd row. Full leather interior, panoramic sunroof, 360° around view monitor. Recent full service done. All features perfect.',
   'Colombo', 'Colombo 07', 'Samantha Wijeratne', '0777654321', 1, 'approved', 0),

  -- 6: Honda Civic 2016
  (@u2, 2, 19, 2016, 5400000, 88000, 'Petrol', 'Manual', 'Used', 'Car',
   'Honda Civic 2016 FB7. Sporty and very fuel efficient. New clutch. AC cold. Kenwood Android Auto head unit. Rear parking sensors. Good condition overall.',
   'Matara', 'Matara', 'Chamara Gunasekara', '0765432109', 1, 'approved', 0),

  -- 7: Honda Fit GP5 2014 Hybrid
  (@u3, 2, 20, 2014, 3100000, 95000, 'Hybrid', 'CVT', 'Reconditioned', 'Car',
   'Honda Fit GP5 2014 Hybrid. Reconditioned from Japan. Excellent fuel economy — 45km/L. Full grade 4.5 condition report available. Fresh customs clearance.',
   'Kurunegala', 'Kurunegala', 'Asanka Bandara', '0762345678', 0, 'approved', 0),

  -- 8: Suzuki Swift 2023 — Featured
  (@u3, 6, 53, 2023, 5900000, 8000, 'Petrol', 'Automatic', 'Used', 'Car',
   'Suzuki Swift 2023. Barely driven — 8,000km only. Full warranty remaining until 2026. Showroom condition. Selling due to relocation. Price is firm.',
   'Colombo', 'Colombo 05', 'Malith Rajapaksa', '0741234567', 1, 'approved', 1),

  -- 9: Toyota Prius 2015
  (@u3, 1, 5, 2015, 5200000, 108000, 'Hybrid', 'CVT', 'Used', 'Car',
   'Toyota Prius 2015. High mileage but very well maintained. Fresh service done — all filters, brake pads, and coolant replaced. Great daily driver. Easy to negotiate.',
   'Ratnapura', 'Ratnapura', 'Dayan Senanayake', '0752222333', 1, 'approved', 0),

  -- 10: Pending listing (won't show on public pages)
  (@u1, 1, 1, 2022, 9800000, 5000, 'Hybrid', 'Automatic', 'Used', 'Car',
   'Toyota Corolla Cross 2022 Hybrid. Barely used. All dealer warranty remaining. Panoramic roof, JBL audio, Toyota Safety Sense.',
   'Colombo', 'Colombo 03', 'AutoHub Showroom', '0117654321', 1, 'pending', 0);

-- Vehicle images — placeholder for all approved listings
INSERT INTO vehicle_images (listing_id, image_path, is_primary, sort_order)
SELECT id, 'placeholder.jpg', 1, 0
FROM vehicle_listings
WHERE status = 'approved'
  AND id NOT IN (SELECT listing_id FROM vehicle_images);

-- ─── Spare Part Listings ──────────────────────────────────────────────────────
-- Part Categories: Engine=1, Body=2, Electrical=3, Suspension=4, Brakes=5, Tyres=7, AC=8

INSERT INTO spare_part_listings
  (user_id, category_id, part_name, part_number, compatible_make, compatible_model,
   compatible_year_from, compatible_year_to, price, condition_type, stock_qty,
   description, district, city, seller_name, seller_phone, status, featured)
VALUES
  -- 1: Brake pads — Featured
  (@u2, 5, 'Front Brake Pads — Toyota Corolla (Bosch)', 'BP-2019-COR',
   'Toyota', 'Corolla', 2015, 2022, 4500, 'New', 10,
   'Genuine Bosch brake pads for Toyota Corolla E210/E170 2015–2022. OEM quality. Set of 4 pads. Free fitting advice. Delivery available island-wide.',
   'Colombo', 'Maradana', 'Lanka Auto Parts', '0112345678', 'approved', 1),

  -- 2: Air filter
  (@u2, 1, 'High-Flow Air Filter (Universal 1.0–2.0L)', NULL,
   NULL, NULL, NULL, NULL, 1200, 'New', 50,
   'Washable & reusable high-flow performance air filter. Fits most 1.0–2.0L Japanese vehicles. 3x more airflow than stock. Easy to install.',
   'Colombo', 'Dehiwala', 'Speedy Parts', '0114567890', 'approved', 0),

  -- 3: Battery — Featured
  (@u2, 3, 'Amaron Car Battery 55Ah (Maintenance-Free)', 'BATT-55AH',
   NULL, NULL, NULL, NULL, 18500, 'New', 15,
   'Amaron ProRated 55Ah maintenance-free battery. 24-month full replacement warranty. Suits Corolla, Vezel, Civic and most Japanese vehicles. Free installation in Colombo & Gampaha.',
   'Gampaha', 'Wattala', 'PowerBat LK', '0712222333', 'approved', 1),

  -- 4: Alloy wheels
  (@u3, 7, 'OEM Honda Aqua Alloy Wheels 15" (Set of 4)', NULL,
   'Honda', 'Aqua', 2015, 2020, 65000, 'Used', 1,
   '15-inch OEM Honda alloy wheels. Removed from Aqua 2018. No scratches, good tyres still on them. Selling as complete set of 4. Bargain price.',
   'Kandy', 'Kandy', 'Suresh Motors', '0773456789', 'approved', 0),

  -- 5: Front bumper — Featured
  (@u3, 2, 'Toyota Corolla Front Bumper 2018–2022 (OEM)', NULL,
   'Toyota', 'Corolla', 2018, 2022, 22000, 'New', 3,
   'Brand new OEM Toyota Corolla E210 front bumper. Pearl white. Imported from Japan. Unused in packaging. Ready to fit.',
   'Colombo', 'Pettah', 'Japanese Auto Parts', '0771999888', 'approved', 1),

  -- 6: Oil filters
  (@u1, 1, 'Denso Oil Filter Set x5 (Toyota Compatible)', 'OF-90915',
   'Toyota', NULL, 2005, 2024, 2800, 'New', 20,
   'Genuine Denso oil filters — pack of 5. Suits most Toyota 1NZ, 2NZ, 2ZR, 3ZR engines. Bulk deal price. Each filter sold separately at Rs.700.',
   'Colombo', 'Kollupitiya', 'ProFilter LK', '0113456789', 'approved', 0),

  -- 7: Rear brake discs
  (@u1, 5, 'Rear Brake Discs — Honda Vezel 2014–2020 (Pair)', NULL,
   'Honda', 'Vezel', 2014, 2020, 12500, 'New', 8,
   'Premium quality rear brake discs for Honda Vezel / HR-V. Japanese manufacturer. Sold as a pair. Fits 2014–2020 models. Includes installation guide.',
   'Gampaha', 'Negombo', 'Speedy Parts', '0114567890', 'approved', 0),

  -- 8: AC compressor
  (@u2, 8, 'Toyota Prius AC Compressor (Recon)', NULL,
   'Toyota', 'Prius', 2012, 2019, 35000, 'Used', 2,
   'Reconditioned AC compressor for Toyota Prius ZVW30/ZVW50. 3-month warranty. Professionally rebuilt and tested. Save vs. new at Rs.85,000.',
   'Colombo', 'Nugegoda', 'CoolAir Lanka', '0772345678', 'approved', 0);

-- Spare part images
INSERT INTO spare_part_images (listing_id, image_path, is_primary, sort_order)
SELECT id, 'placeholder.jpg', 1, 0
FROM spare_part_listings
WHERE status = 'approved'
  AND id NOT IN (SELECT listing_id FROM spare_part_images);

-- ─── Service Providers ────────────────────────────────────────────────────────
-- Service Categories: Full Service=1, Oil Change=2, AC Repair=3, Body Repair=4, Tyre=5, Battery=6, Engine=7, Wheel Align=8, Electrical=9

INSERT INTO service_providers
  (user_id, business_name, address, district, city, contact_phone, working_hours, description, status)
VALUES
  (@u3, 'Colombo Auto Care',
   '12 Galle Road, Colombo 03', 'Colombo', 'Colombo 03', '0112789456',
   'Mon–Sat 8:00am–6:00pm',
   'Sri Lanka''s trusted full-service auto repair centre since 2005. Specialising in Japanese and European vehicles. Computerized diagnostics, engine rebuild, AC service, and body work. Free pick-up and drop available in Colombo.',
   'approved'),

  (@u3, 'Kandy Fast Lube',
   '45 Peradeniya Road, Kandy', 'Kandy', 'Kandy', '0812345678',
   'Mon–Fri 8:00am–5:00pm | Sat 8:00am–1:00pm',
   'Quick oil change and preventive maintenance specialists. Walk-ins always welcome. No appointment needed for standard services. Serving Kandy since 2010 with over 12,000 satisfied customers.',
   'approved'),

  (@u2, 'Galle Bay Motors',
   '7 Closenberg Road, Galle', 'Galle', 'Galle', '0912233445',
   'Daily 8:00am–7:00pm',
   'Complete auto workshop in Galle. Specialising in accident repair, spray painting, and dent removal. Certified panel beaters. Free inspection and quotation. Insurance claims welcome.',
   'approved'),

  (@u2, 'AutoElec Colombo',
   '88 Baseline Road, Colombo 09', 'Colombo', 'Colombo 09', '0114455667',
   'Mon–Sat 8:30am–5:30pm',
   'Vehicle electrical and electronics specialists. ECU diagnostics and programming, alarm systems, dashcam fitting, LED lighting upgrades. Best prices in Colombo. All car brands.',
   'approved');

SET @sp1 = (SELECT id FROM service_providers WHERE contact_phone='0112789456');
SET @sp2 = (SELECT id FROM service_providers WHERE contact_phone='0812345678');
SET @sp3 = (SELECT id FROM service_providers WHERE contact_phone='0912233445');
SET @sp4 = (SELECT id FROM service_providers WHERE contact_phone='0114455667');

-- Services — Colombo Auto Care
INSERT INTO services (provider_id, category_id, name, description, base_price, status) VALUES
  (@sp1, 15, 'Engine Diagnostic Check',
   'Full OBD2 diagnostic scan. All fault codes read and printed report provided. Takes 30 minutes.',
   1500, 'approved'),
  (@sp1, 3, 'AC Gas Recharge (R134a)',
   'Air conditioning refrigerant top-up. Includes leak detection dye and cabin filter inspection.',
   4500, 'approved'),
  (@sp1, 1, 'Full Service (Petrol)',
   'Engine oil change, oil filter, air filter, spark plug check, coolant top-up, 50-point safety inspection.',
   8500, 'approved'),
  (@sp1, 4, 'Accident Repair & Respray',
   'Full panel beating, filling, and respraying. Match guarantee. Insurance claim assistance available.',
   25000, 'approved');

-- Services — Kandy Fast Lube
INSERT INTO services (provider_id, category_id, name, description, base_price, status) VALUES
  (@sp2, 2, 'Quick Oil & Filter Change',
   'Premium synthetic or semi-synthetic oil. Filter included. Completed in 30 minutes. Walk-in welcome.',
   3500, 'approved'),
  (@sp2, 8, 'Wheel Alignment & Balancing',
   '4-wheel computerized alignment and dynamic balancing. Printout report included. All vehicle types.',
   2500, 'approved'),
  (@sp2, 5, 'Tyre Rotation',
   'Rotate all 4 tyres for even wear. Includes tyre pressure check and visual inspection.',
   1000, 'approved');

-- Services — Galle Bay Motors
INSERT INTO services (provider_id, category_id, name, description, base_price, status) VALUES
  (@sp3, 4, 'Dent Removal (per panel)',
   'Paintless dent repair (PDR) technique. Minor to medium dents removed without repainting.',
   3000, 'approved'),
  (@sp3, 4, 'Full Body Respray',
   'Complete vehicle respray with 2K enamel coat. Colour match guaranteed. 12-month warranty.',
   65000, 'approved'),
  (@sp3, 6, 'Battery Replacement Service',
   'Battery supply and fitment. All brands available. Old battery recycled responsibly. Free test.',
   500, 'approved');

-- Services — AutoElec Colombo
INSERT INTO services (provider_id, category_id, name, description, base_price, status) VALUES
  (@sp4, 9, 'ECU Diagnostics & Programming',
   'ECU fault code diagnosis, immobilizer bypass, odometer correction. All Japanese and European cars.',
   3500, 'approved'),
  (@sp4, 9, 'Dashcam & Camera Installation',
   'Front + rear dashcam, reverse camera, parking sensors fitted. Bring your device or we supply.',
   4500, 'approved'),
  (@sp4, 9, 'LED Lighting Upgrade',
   'Convert headlights, taillights, and interior to LED. Clean wiring. 6-month warranty on parts.',
   6500, 'approved');

-- Service add-ons
INSERT INTO service_addons (service_id, addon_name, addon_price)
SELECT s.id, 'Coolant Top-Up', 500      FROM services s WHERE s.name='Full Service (Petrol)' AND s.provider_id=@sp1;
INSERT INTO service_addons (service_id, addon_name, addon_price)
SELECT s.id, 'Brake Fluid Flush', 2200  FROM services s WHERE s.name='Full Service (Petrol)' AND s.provider_id=@sp1;
INSERT INTO service_addons (service_id, addon_name, addon_price)
SELECT s.id, 'Cabin Filter Replacement', 1800 FROM services s WHERE s.name='AC Gas Recharge (R134a)';
INSERT INTO service_addons (service_id, addon_name, addon_price)
SELECT s.id, 'Oil Filter Only (no oil change)', 800 FROM services s WHERE s.name='Quick Oil & Filter Change';
INSERT INTO service_addons (service_id, addon_name, addon_price)
SELECT s.id, 'Tyre Rotation', 800 FROM services s WHERE s.name='Wheel Alignment & Balancing';
INSERT INTO service_addons (service_id, addon_name, addon_price)
SELECT s.id, 'GPS Tracker Install', 2500 FROM services s WHERE s.name='Dashcam & Camera Installation';

-- ─── Sample Inquiries ─────────────────────────────────────────────────────────
SET @v1 = (SELECT MIN(id) FROM vehicle_listings WHERE status='approved');
SET @v2 = (SELECT MIN(id)+1 FROM vehicle_listings WHERE status='approved');
SET @p1 = (SELECT MIN(id) FROM spare_part_listings WHERE status='approved');

INSERT INTO inquiries (listing_type, listing_id, sender_name, sender_phone, sender_email, message, is_read)
VALUES
  ('vehicle', @v1, 'Ashan Kumara',     '0771999000', 'ashan.k@gmail.com',
   'Hi, is this vehicle still available? Can we arrange a viewing this weekend in Colombo?', 0),

  ('vehicle', @v1, 'Dilshan Mendis',   '0712888000', 'dilshan.m@yahoo.com',
   'What is the absolute lowest price? I can pay cash today. Also do you have any service records?', 1),

  ('vehicle', @v2, 'Rashmi Fernando',  '0777333444', 'rashmi.f@gmail.com',
   'Is this still available? Can I book a test drive this Sunday morning?', 0),

  ('part',    @p1, 'Nuwan Jayawardena','0763456789', 'nuwan.j@hotmail.com',
   'Do you deliver to Kandy? Also do you carry the same part for a 2014 model?', 0),

  ('contact', NULL, 'Saman Wickramasinghe', '0773212345', 'saman.wick@gmail.com',
   'I run a vehicle dealership in Colombo and would like to list multiple vehicles. Do you have business/premium packages?', 0);

-- ─── Final Summary ────────────────────────────────────────────────────────────
SELECT
  (SELECT COUNT(*) FROM vehicle_listings   WHERE status='approved') AS vehicles_approved,
  (SELECT COUNT(*) FROM spare_part_listings WHERE status='approved') AS parts_approved,
  (SELECT COUNT(*) FROM service_providers  WHERE status='approved') AS providers_approved,
  (SELECT COUNT(*) FROM services           WHERE status='approved') AS services_approved,
  (SELECT COUNT(*) FROM service_addons)                             AS addons_total,
  (SELECT COUNT(*) FROM users              WHERE role='user')       AS user_accounts,
  (SELECT COUNT(*) FROM inquiries)                                  AS inquiries_total;
