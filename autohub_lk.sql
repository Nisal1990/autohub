-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2026 at 08:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autohub_lk`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `district_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `district_id`, `name`) VALUES
(1, 5, 'Colombo 01'),
(2, 5, 'Colombo 02'),
(3, 5, 'Colombo 03'),
(4, 5, 'Colombo 04'),
(5, 5, 'Colombo 05'),
(6, 5, 'Colombo 06'),
(7, 5, 'Colombo 07'),
(8, 5, 'Colombo 08'),
(9, 5, 'Colombo 09'),
(10, 5, 'Colombo 10'),
(11, 5, 'Dehiwala'),
(12, 5, 'Kotte'),
(13, 5, 'Maharagama'),
(14, 5, 'Moratuwa'),
(15, 5, 'Mount Lavinia'),
(16, 5, 'Nugegoda'),
(17, 5, 'Piliyandala'),
(18, 5, 'Rajagiriya'),
(19, 5, 'Ratmalana'),
(20, 5, 'Wellampitiya'),
(21, 7, 'Gampaha'),
(22, 7, 'Negombo'),
(23, 7, 'Wattala'),
(24, 7, 'Kadawatha'),
(25, 7, 'Kiribathgoda'),
(26, 7, 'Ja-Ela'),
(27, 7, 'Kelaniya'),
(28, 7, 'Ragama'),
(29, 7, 'Minuwangoda'),
(30, 7, 'Divulapitiya'),
(31, 10, 'Kalutara'),
(32, 10, 'Panadura'),
(33, 10, 'Horana'),
(34, 10, 'Matugama'),
(35, 10, 'Aluthgama'),
(36, 10, 'Beruwala'),
(37, 10, 'Bandaragama'),
(38, 11, 'Kandy'),
(39, 11, 'Peradeniya'),
(40, 11, 'Katugastota'),
(41, 11, 'Digana'),
(42, 11, 'Kundasale'),
(43, 11, 'Gampola'),
(44, 11, 'Nawalapitiya'),
(45, 6, 'Galle'),
(46, 6, 'Ambalangoda'),
(47, 6, 'Hikkaduwa'),
(48, 6, 'Elpitiya'),
(49, 6, 'Karandeniya'),
(50, 6, 'Baddegama'),
(51, 17, 'Matara'),
(52, 17, 'Weligama'),
(53, 17, 'Akuressa'),
(54, 17, 'Dikwella'),
(55, 17, 'Hakmana'),
(56, 14, 'Kurunegala'),
(57, 14, 'Kuliyapitiya'),
(58, 14, 'Narammala'),
(59, 14, 'Mawathagama'),
(60, 14, 'Pannala'),
(61, 14, 'Nikaweratiya'),
(62, 2, 'Anuradhapura'),
(63, 2, 'Medawachchiya'),
(64, 2, 'Mihintale'),
(65, 2, 'Kekirawa'),
(66, 23, 'Ratnapura'),
(67, 23, 'Embilipitiya'),
(68, 23, 'Balangoda'),
(69, 23, 'Pelmadulla'),
(70, 9, 'Jaffna'),
(71, 9, 'Chavakachcheri'),
(72, 9, 'Point Pedro'),
(73, 9, 'Nallur'),
(74, 3, 'Badulla'),
(75, 3, 'Bandarawela'),
(76, 3, 'Haputale'),
(77, 3, 'Ella'),
(78, 3, 'Mahiyanganaya'),
(79, 24, 'Trincomalee'),
(80, 24, 'Kinniya'),
(81, 24, 'Mutur'),
(82, 4, 'Batticaloa'),
(83, 4, 'Kalmunai'),
(84, 4, 'Valaichchenai'),
(85, 1, 'Ampara'),
(86, 1, 'Kalmunai'),
(87, 1, 'Akkaraipattu'),
(88, 8, 'Hambantota'),
(89, 8, 'Tangalle'),
(90, 8, 'Tissamaharama'),
(91, 8, 'Weeraketiya'),
(92, 20, 'Nuwara Eliya'),
(93, 20, 'Hatton'),
(94, 20, 'Ginigathena'),
(95, 20, 'Ragala'),
(96, 22, 'Puttalam'),
(97, 22, 'Chilaw'),
(98, 22, 'Wennappuwa'),
(99, 22, 'Marawila'),
(100, 12, 'Kegalle'),
(101, 12, 'Mawanella'),
(102, 12, 'Warakapola'),
(103, 12, 'Rambukkana'),
(104, 21, 'Polonnaruwa'),
(105, 21, 'Medirigiriya'),
(106, 21, 'Hingurakgoda'),
(107, 16, 'Matale'),
(108, 16, 'Dambulla'),
(109, 16, 'Sigiriya'),
(110, 16, 'Rattota'),
(111, 18, 'Monaragala'),
(112, 18, 'Wellawaya'),
(113, 18, 'Bibile'),
(114, 25, 'Vavuniya'),
(115, 25, 'Cheddikulam'),
(116, 15, 'Mannar'),
(117, 15, 'Murunkan'),
(118, 13, 'Kilinochchi'),
(119, 13, 'Pallai'),
(120, 19, 'Mullaitivu'),
(121, 19, 'Oddusuddan');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`) VALUES
(1, 'Ampara'),
(2, 'Anuradhapura'),
(3, 'Badulla'),
(4, 'Batticaloa'),
(5, 'Colombo'),
(6, 'Galle'),
(7, 'Gampaha'),
(8, 'Hambantota'),
(9, 'Jaffna'),
(10, 'Kalutara'),
(11, 'Kandy'),
(12, 'Kegalle'),
(13, 'Kilinochchi'),
(14, 'Kurunegala'),
(15, 'Mannar'),
(16, 'Matale'),
(17, 'Matara'),
(18, 'Monaragala'),
(19, 'Mullaitivu'),
(20, 'Nuwara Eliya'),
(21, 'Polonnaruwa'),
(22, 'Puttalam'),
(23, 'Ratnapura'),
(24, 'Trincomalee'),
(25, 'Vavuniya');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(10) UNSIGNED NOT NULL,
  `listing_type` enum('vehicle','part','service','contact') NOT NULL,
  `listing_id` int(10) UNSIGNED DEFAULT NULL,
  `sender_name` varchar(120) NOT NULL,
  `sender_phone` varchar(20) NOT NULL DEFAULT '',
  `sender_email` varchar(180) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `name`) VALUES
(26, 'Ashok Leyland'),
(16, 'Audi'),
(29, 'BAIC'),
(20, 'Bajaj'),
(14, 'BMW'),
(30, 'Chery'),
(9, 'Daihatsu'),
(28, 'DFSK'),
(12, 'Ford'),
(22, 'Hero'),
(2, 'Honda'),
(10, 'Hyundai'),
(8, 'Isuzu'),
(11, 'Kia'),
(25, 'KTM'),
(19, 'Mahindra'),
(4, 'Mazda'),
(15, 'Mercedes-Benz'),
(27, 'Micro'),
(5, 'Mitsubishi'),
(3, 'Nissan'),
(17, 'Perodua'),
(24, 'Royal Enfield'),
(7, 'Subaru'),
(6, 'Suzuki'),
(18, 'Tata'),
(1, 'Toyota'),
(21, 'TVS'),
(13, 'Volkswagen'),
(23, 'Yamaha');

-- --------------------------------------------------------

--
-- Table structure for table `part_categories`
--

CREATE TABLE `part_categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `part_categories`
--

INSERT INTO `part_categories` (`id`, `name`) VALUES
(8, 'Air Conditioning'),
(2, 'Body & Exterior'),
(5, 'Brakes'),
(9, 'Cooling & Radiator'),
(3, 'Electrical & Lighting'),
(1, 'Engine & Drivetrain'),
(10, 'Exhaust & Emission'),
(12, 'Fuel System'),
(6, 'Interior & Accessories'),
(13, 'Other'),
(4, 'Suspension & Steering'),
(11, 'Transmission & Clutch'),
(7, 'Tyres & Wheels');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(10) UNSIGNED NOT NULL,
  `listing_type` enum('vehicle','part','service') NOT NULL,
  `listing_id` int(10) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','expired') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `category_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(160) NOT NULL,
  `description` text DEFAULT NULL,
  `base_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_addons`
--

CREATE TABLE `service_addons` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `addon_name` varchar(160) NOT NULL,
  `addon_price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`) VALUES
(3, 'AC Repair & Gas Refill'),
(6, 'Battery Service'),
(4, 'Body Repair & Painting'),
(11, 'Brake Service'),
(9, 'Electrical & Wiring'),
(7, 'Engine Tuning & Overhaul'),
(1, 'Full Vehicle Service'),
(10, 'Interior Cleaning & Detailing'),
(2, 'Oil & Filter Change'),
(16, 'Other'),
(12, 'Suspension & Steering Repair'),
(14, 'Towing & Recovery'),
(5, 'Tyre Service & Alignment'),
(15, 'Vehicle Inspection & Diagnosis'),
(8, 'Wheel Alignment & Balancing'),
(13, 'Windscreen & Glass');

-- --------------------------------------------------------

--
-- Table structure for table `service_providers`
--

CREATE TABLE `service_providers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `business_name` varchar(160) NOT NULL,
  `address` varchar(255) NOT NULL DEFAULT '',
  `district` varchar(80) NOT NULL DEFAULT '',
  `city` varchar(80) NOT NULL DEFAULT '',
  `contact_phone` varchar(20) NOT NULL DEFAULT '',
  `working_hours` varchar(100) NOT NULL DEFAULT '',
  `description` text DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spare_part_images`
--

CREATE TABLE `spare_part_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `listing_id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spare_part_listings`
--

CREATE TABLE `spare_part_listings` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `part_name` varchar(160) NOT NULL,
  `part_number` varchar(80) NOT NULL DEFAULT '',
  `compatible_make` varchar(80) NOT NULL DEFAULT '',
  `compatible_model` varchar(100) NOT NULL DEFAULT '',
  `compatible_year_from` year(4) DEFAULT NULL,
  `compatible_year_to` year(4) DEFAULT NULL,
  `category_id` smallint(5) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `condition_type` enum('New','Used','Reconditioned') NOT NULL DEFAULT 'New',
  `stock_qty` smallint(5) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `district` varchar(80) NOT NULL DEFAULT '',
  `city` varchar(80) NOT NULL DEFAULT '',
  `seller_name` varchar(120) NOT NULL DEFAULT '',
  `seller_phone` varchar(20) NOT NULL DEFAULT '',
  `status` enum('pending','approved','rejected','sold_out') NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(180) NOT NULL,
  `phone` varchar(20) NOT NULL DEFAULT '',
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `district` varchar(80) NOT NULL DEFAULT '',
  `city` varchar(80) NOT NULL DEFAULT '',
  `status` enum('active','suspended') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password_hash`, `role`, `district`, `city`, `status`, `created_at`) VALUES
(1, 'Site Admin', 'admin@autohub.lk', '0771234567', '\\.97b0YN1Dyp/RuD0jR4emqAKP/dZs29giawlc79LHMr5uWWfnVS', 'admin', 'Colombo', 'Colombo', 'active', '2026-06-20 11:30:03'),
(2, 'Demo User', 'demo@autohub.lk', '0771111111', '$2y$12$6G5nRMNJqkUy8Q2jUHcXLuXfAJZU.RfJijD4nkiEPl0F2X9JQmiBi', 'user', 'Colombo', 'Nugegoda', 'active', '2026-06-20 11:42:37'),
(3, 'Lanka Parts', 'parts@autohub.lk', '0112222222', '$2y$12$6G5nRMNJqkUy8Q2jUHcXLuXfAJZU.RfJijD4nkiEPl0F2X9JQmiBi', 'user', 'Gampaha', 'Wattala', 'active', '2026-06-20 11:42:37'),
(4, 'Colombo Motors', 'motors@autohub.lk', '0113333333', '$2y$12$6G5nRMNJqkUy8Q2jUHcXLuXfAJZU.RfJijD4nkiEPl0F2X9JQmiBi', 'user', 'Kandy', 'Kandy', 'active', '2026-06-20 11:42:37'),
(5, 'Nisal Senadheera', 'nisalsenadheera1990@gmail.com', '0753560350', '$2y$12$S40mUEYiXua6.e.2fvUyieGcT9dPMIqIEZC4HqkVhbs5XkoUAXsvG', 'user', 'Colombo', 'kottawa', 'active', '2026-06-20 11:49:18');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_images`
--

CREATE TABLE `vehicle_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `listing_id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_images`
--

INSERT INTO `vehicle_images` (`id`, `listing_id`, `image_path`, `is_primary`, `sort_order`) VALUES
(1, 7, 'placeholder.jpg', 1, 0),
(2, 8, 'placeholder.jpg', 1, 0),
(3, 9, 'placeholder.jpg', 1, 0),
(4, 10, 'placeholder.jpg', 1, 0),
(5, 11, 'placeholder.jpg', 1, 0),
(6, 12, 'placeholder.jpg', 1, 0),
(7, 13, 'placeholder.jpg', 1, 0),
(8, 14, 'placeholder.jpg', 1, 0),
(9, 15, 'placeholder.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_listings`
--

CREATE TABLE `vehicle_listings` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `manufacturer_id` smallint(5) UNSIGNED NOT NULL,
  `model_id` smallint(5) UNSIGNED NOT NULL,
  `model_year` year(4) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `mileage` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `fuel_type` enum('Petrol','Diesel','Hybrid','Electric','Other') NOT NULL DEFAULT 'Petrol',
  `transmission` enum('Manual','Automatic','CVT') NOT NULL DEFAULT 'Manual',
  `condition_type` enum('New','Used','Reconditioned') NOT NULL DEFAULT 'Used',
  `body_type` enum('Car','Van','SUV','Pickup','Motorcycle','Three-wheeler','Lorry','Bus','Other') NOT NULL DEFAULT 'Car',
  `description` text DEFAULT NULL,
  `district` varchar(80) NOT NULL DEFAULT '',
  `city` varchar(80) NOT NULL DEFAULT '',
  `seller_name` varchar(120) NOT NULL DEFAULT '',
  `seller_phone` varchar(20) NOT NULL DEFAULT '',
  `show_email` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','rejected','sold','expired') NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_listings`
--

INSERT INTO `vehicle_listings` (`id`, `user_id`, `manufacturer_id`, `model_id`, `model_year`, `price`, `mileage`, `fuel_type`, `transmission`, `condition_type`, `body_type`, `description`, `district`, `city`, `seller_name`, `seller_phone`, `show_email`, `status`, `rejection_reason`, `featured`, `created_at`, `updated_at`) VALUES
(7, 2, 1, 1, '2019', 4850000.00, 52000, 'Petrol', 'Automatic', 'Used', 'Car', 'Well-maintained Toyota Corolla 2019. Single owner. Full service history with Toyota dealer. New tyres fitted. Accident-free. All functions working perfectly.', 'Colombo', 'Nugegoda', 'Kamal Silva', '0771234567', 1, 'approved', NULL, 1, '2026-06-20 11:42:37', '2026-06-20 11:42:37'),
(8, 2, 2, 21, '2020', 6200000.00, 38000, 'Hybrid', 'CVT', 'Used', 'SUV', 'Honda Vezel 2020 Hybrid RS. Excellent fuel economy ??? 18km/l city. Reverse camera, Honda Sensing, sunroof. One owner from new. Mint condition.', 'Gampaha', 'Negombo', 'Priya Fernando', '0712345678', 0, 'approved', NULL, 1, '2026-06-20 11:42:37', '2026-06-20 11:42:37'),
(9, 2, 1, 5, '2018', 7500000.00, 65000, 'Hybrid', 'CVT', 'Used', 'Car', 'Toyota Prius PHV 2018. Plug-in hybrid. 35km electric range. Leather seats. Push start. Lane assist. Negotiable for quick sale.', 'Kandy', 'Peradeniya', 'Ruwan Perera', '0776543210', 1, 'approved', NULL, 0, '2026-06-20 11:42:37', '2026-06-20 11:42:37'),
(10, 2, 6, 52, '2021', 2800000.00, 18000, 'Petrol', 'Manual', 'Used', 'Car', 'Suzuki Alto 800cc 2021. Low mileage. Perfect city car. Excellent fuel economy. Easy to park. Owner migrating ??? must sell. Genuine buyer only.', 'Galle', 'Galle', 'Nimal Jayasinghe', '0703456789', 1, 'approved', NULL, 0, '2026-06-20 11:42:37', '2026-06-20 11:42:37'),
(11, 3, 3, 32, '2017', 8900000.00, 78000, 'Diesel', 'Automatic', 'Used', 'SUV', 'Nissan X-Trail T32 2017. 4WD. 7 seater. Full leather interior. Panoramic sunroof. 360?? camera. Recent service done. All features working.', 'Colombo', 'Colombo 07', 'Samantha Wijeratne', '0777654321', 1, 'approved', NULL, 0, '2026-06-20 11:42:37', '2026-06-20 11:42:37'),
(12, 3, 2, 19, '2016', 5400000.00, 88000, 'Petrol', 'Manual', 'Used', 'Car', 'Honda Civic 2016. Sporty and fuel efficient. New clutch fitted. AC cold. Kenwood head unit with Android Auto. Good tyres.', 'Matara', 'Matara', 'Chamara Gunasekara', '0765432109', 1, 'approved', NULL, 0, '2026-06-20 11:42:37', '2026-06-20 11:42:37'),
(13, 3, 2, 20, '2014', 3100000.00, 95000, 'Hybrid', 'CVT', 'Reconditioned', 'Car', 'Honda Fit GP5 2014 Hybrid. Reconditioned from Japan. 45km/l fuel economy. Very economical. Must see to appreciate.', 'Kurunegala', 'Kurunegala', 'Asanka Bandara', '0762345678', 0, 'approved', NULL, 0, '2026-06-20 11:42:37', '2026-06-20 11:42:37'),
(14, 4, 6, 53, '2023', 5900000.00, 8000, 'Petrol', 'Automatic', 'Used', 'Car', 'Suzuki Swift Sport 2023. Barely used ??? bought new, relocating. Full warranty remaining. Showroom condition. Non-negotiable price.', 'Colombo', 'Colombo 05', 'Malith Rajapaksa', '0741234567', 1, 'approved', NULL, 1, '2026-06-20 11:42:37', '2026-06-20 11:42:37'),
(15, 4, 1, 1, '2022', 9800000.00, 12000, 'Petrol', 'Automatic', 'New', 'Car', 'Toyota Corolla Cross 2022 Hybrid. Brand new registered 2022. Fully loaded ??? panoramic roof, JBL audio, Toyota Safety Sense. Full dealer warranty.', 'Colombo', 'Colombo 03', 'AutoHub Showroom', '0117654321', 1, 'approved', NULL, 1, '2026-06-20 11:42:37', '2026-06-20 11:42:37'),
(16, 4, 1, 5, '2015', 5200000.00, 110000, 'Hybrid', 'CVT', 'Used', 'Car', 'Toyota Prius 2015. High mileage but very well maintained. Fresh service done. Good tyres. Great daily driver.', 'Ratnapura', 'Ratnapura', 'Dayan Senanayake', '0752222333', 1, 'pending', NULL, 0, '2026-06-20 11:42:37', '2026-06-20 11:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_models`
--

CREATE TABLE `vehicle_models` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `manufacturer_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_models`
--

INSERT INTO `vehicle_models` (`id`, `manufacturer_id`, `name`) VALUES
(1, 1, 'Corolla'),
(2, 1, 'Axio'),
(3, 1, 'Premio'),
(4, 1, 'Allion'),
(5, 1, 'Prius'),
(6, 1, 'Aqua'),
(7, 1, 'Vitz'),
(8, 1, 'Rush'),
(9, 1, 'Raize'),
(10, 1, 'Land Cruiser'),
(11, 1, 'Prado'),
(12, 1, 'Hilux'),
(13, 1, 'Hiace'),
(14, 1, 'KDH'),
(15, 1, 'Camry'),
(16, 1, 'Wish'),
(17, 1, 'IST'),
(18, 1, 'Fielder'),
(19, 2, 'Civic'),
(20, 2, 'Fit'),
(21, 2, 'Vezel'),
(22, 2, 'CR-V'),
(23, 2, 'HR-V'),
(24, 2, 'WR-V'),
(25, 2, 'Accord'),
(26, 2, 'Brio'),
(27, 2, 'Jazz'),
(28, 2, 'Insight'),
(29, 2, 'Legend'),
(30, 3, 'Sunny'),
(31, 3, 'Tiida'),
(32, 3, 'X-Trail'),
(33, 3, 'Patrol'),
(34, 3, 'Leaf'),
(35, 3, 'Navara'),
(36, 3, 'Note'),
(37, 3, 'Bluebird'),
(38, 4, 'Demio'),
(39, 4, 'Axela'),
(40, 4, 'Atenza'),
(41, 4, 'CX-5'),
(42, 4, 'CX-3'),
(43, 4, 'BT-50'),
(44, 5, 'Lancer'),
(45, 5, 'Outlander'),
(46, 5, 'Montero'),
(47, 5, 'L200'),
(48, 5, 'Pajero'),
(49, 5, 'Colt'),
(50, 5, 'Eclipse Cross'),
(51, 5, 'Delica'),
(52, 6, 'Alto'),
(53, 6, 'Swift'),
(54, 6, 'Wagon R'),
(55, 6, 'Vitara'),
(56, 6, 'Jimny'),
(57, 6, 'Ciaz'),
(58, 6, 'Baleno'),
(59, 6, 'Every'),
(60, 6, 'Spacia'),
(61, 7, 'Impreza'),
(62, 7, 'Forester'),
(63, 7, 'Outback'),
(64, 7, 'XV'),
(65, 10, 'Accent'),
(66, 10, 'Tucson'),
(67, 10, 'Santro'),
(68, 10, 'Creta'),
(69, 10, 'Ioniq'),
(70, 11, 'Picanto'),
(71, 11, 'Sportage'),
(72, 11, 'Sorento'),
(73, 11, 'Stinger'),
(74, 11, 'EV6'),
(75, 8, 'D-Max'),
(76, 8, 'MU-X'),
(77, 8, 'Elf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cities_district` (`district_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_districts_name` (`name`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_inq_type_id` (`listing_type`,`listing_id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_manufacturers_name` (`name`);

--
-- Indexes for table `part_categories`
--
ALTER TABLE `part_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_part_cat_name` (`name`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_promo_type_id` (`listing_type`,`listing_id`),
  ADD KEY `idx_promo_status` (`status`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_svc_provider` (`provider_id`),
  ADD KEY `idx_svc_category` (`category_id`);

--
-- Indexes for table `service_addons`
--
ALTER TABLE `service_addons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_addon_service` (`service_id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_svc_cat_name` (`name`);

--
-- Indexes for table `service_providers`
--
ALTER TABLE `service_providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_sp_user` (`user_id`);

--
-- Indexes for table `spare_part_images`
--
ALTER TABLE `spare_part_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_spi_listing` (`listing_id`);

--
-- Indexes for table `spare_part_listings`
--
ALTER TABLE `spare_part_listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_spl_user` (`user_id`),
  ADD KEY `idx_spl_status` (`status`),
  ADD KEY `idx_spl_cat` (`category_id`),
  ADD KEY `idx_spl_district` (`district`),
  ADD KEY `idx_spl_partnum` (`part_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_email` (`email`);

--
-- Indexes for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vi_listing` (`listing_id`);

--
-- Indexes for table `vehicle_listings`
--
ALTER TABLE `vehicle_listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vl_user` (`user_id`),
  ADD KEY `idx_vl_status` (`status`),
  ADD KEY `idx_vl_featured` (`featured`),
  ADD KEY `idx_vl_make_model` (`manufacturer_id`,`model_id`),
  ADD KEY `idx_vl_district` (`district`),
  ADD KEY `fk_vl_model` (`model_id`);

--
-- Indexes for table `vehicle_models`
--
ALTER TABLE `vehicle_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_models_manufacturer` (`manufacturer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `part_categories`
--
ALTER TABLE `part_categories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_addons`
--
ALTER TABLE `service_addons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `service_providers`
--
ALTER TABLE `service_providers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spare_part_images`
--
ALTER TABLE `spare_part_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spare_part_listings`
--
ALTER TABLE `spare_part_listings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vehicle_listings`
--
ALTER TABLE `vehicle_listings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vehicle_models`
--
ALTER TABLE `vehicle_models`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `fk_cities_district` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_svc_category` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`),
  ADD CONSTRAINT `fk_svc_provider` FOREIGN KEY (`provider_id`) REFERENCES `service_providers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_addons`
--
ALTER TABLE `service_addons`
  ADD CONSTRAINT `fk_addon_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_providers`
--
ALTER TABLE `service_providers`
  ADD CONSTRAINT `fk_sp_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `spare_part_images`
--
ALTER TABLE `spare_part_images`
  ADD CONSTRAINT `fk_spi_listing` FOREIGN KEY (`listing_id`) REFERENCES `spare_part_listings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `spare_part_listings`
--
ALTER TABLE `spare_part_listings`
  ADD CONSTRAINT `fk_spl_category` FOREIGN KEY (`category_id`) REFERENCES `part_categories` (`id`),
  ADD CONSTRAINT `fk_spl_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  ADD CONSTRAINT `fk_vi_listing` FOREIGN KEY (`listing_id`) REFERENCES `vehicle_listings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_listings`
--
ALTER TABLE `vehicle_listings`
  ADD CONSTRAINT `fk_vl_manufacturer` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`),
  ADD CONSTRAINT `fk_vl_model` FOREIGN KEY (`model_id`) REFERENCES `vehicle_models` (`id`),
  ADD CONSTRAINT `fk_vl_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_models`
--
ALTER TABLE `vehicle_models`
  ADD CONSTRAINT `fk_models_manufacturer` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
