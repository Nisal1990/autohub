-- ============================================================
-- AutoHub LK — Database Schema
-- MySQL 8.x / MariaDB compatible
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';

CREATE DATABASE IF NOT EXISTS `autohub_lk`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `autohub_lk`;

-- ─── USERS ────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `users` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(120) NOT NULL,
  `email`         VARCHAR(180) NOT NULL,
  `phone`         VARCHAR(20)  NOT NULL DEFAULT '',
  `password_hash` VARCHAR(255) NOT NULL,
  `role`          ENUM('user','admin') NOT NULL DEFAULT 'user',
  `district`      VARCHAR(80)  NOT NULL DEFAULT '',
  `city`          VARCHAR(80)  NOT NULL DEFAULT '',
  `status`        ENUM('active','suspended') NOT NULL DEFAULT 'active',
  `created_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── LOOKUP: DISTRICTS ────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `districts` (
  `id`   SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_districts_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── LOOKUP: CITIES ───────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `cities` (
  `id`          SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `district_id` SMALLINT UNSIGNED NOT NULL,
  `name`        VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_cities_district` (`district_id`),
  CONSTRAINT `fk_cities_district` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── VEHICLE MANUFACTURERS ────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `manufacturers` (
  `id`   SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_manufacturers_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── VEHICLE MODELS ───────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `vehicle_models` (
  `id`              SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `manufacturer_id` SMALLINT UNSIGNED NOT NULL,
  `name`            VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_models_manufacturer` (`manufacturer_id`),
  CONSTRAINT `fk_models_manufacturer` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── VEHICLE LISTINGS ─────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `vehicle_listings` (
  `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`         INT UNSIGNED NOT NULL,
  `manufacturer_id` SMALLINT UNSIGNED NOT NULL,
  `model_id`        SMALLINT UNSIGNED NOT NULL,
  `model_year`      YEAR         NOT NULL,
  `price`           DECIMAL(12,2) NOT NULL,
  `mileage`         INT UNSIGNED NOT NULL DEFAULT 0,
  `fuel_type`       ENUM('Petrol','Diesel','Hybrid','Electric','Other') NOT NULL DEFAULT 'Petrol',
  `transmission`    ENUM('Manual','Automatic','CVT') NOT NULL DEFAULT 'Manual',
  `condition_type`  ENUM('New','Used','Reconditioned') NOT NULL DEFAULT 'Used',
  `body_type`       ENUM('Car','Van','SUV','Pickup','Motorcycle','Three-wheeler','Lorry','Bus','Other') NOT NULL DEFAULT 'Car',
  `description`     TEXT,
  `district`        VARCHAR(80)  NOT NULL DEFAULT '',
  `city`            VARCHAR(80)  NOT NULL DEFAULT '',
  `seller_name`     VARCHAR(120) NOT NULL DEFAULT '',
  `seller_phone`    VARCHAR(20)  NOT NULL DEFAULT '',
  `show_email`      TINYINT(1)   NOT NULL DEFAULT 0,
  `status`          ENUM('pending','approved','rejected','sold','expired') NOT NULL DEFAULT 'pending',
  `rejection_reason`TEXT,
  `featured`        TINYINT(1)   NOT NULL DEFAULT 0,
  `created_at`      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_vl_user`   (`user_id`),
  KEY `idx_vl_status` (`status`),
  KEY `idx_vl_featured`(`featured`),
  KEY `idx_vl_make_model`(`manufacturer_id`,`model_id`),
  KEY `idx_vl_district`(`district`),
  CONSTRAINT `fk_vl_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_vl_manufacturer` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`),
  CONSTRAINT `fk_vl_model` FOREIGN KEY (`model_id`) REFERENCES `vehicle_models` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── VEHICLE IMAGES ───────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `vehicle_images` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `listing_id` INT UNSIGNED NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `is_primary` TINYINT(1)   NOT NULL DEFAULT 0,
  `sort_order` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_vi_listing` (`listing_id`),
  CONSTRAINT `fk_vi_listing` FOREIGN KEY (`listing_id`) REFERENCES `vehicle_listings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── PART CATEGORIES ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `part_categories` (
  `id`   SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_part_cat_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── SPARE PART LISTINGS ─────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `spare_part_listings` (
  `id`                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`             INT UNSIGNED NOT NULL,
  `part_name`           VARCHAR(160) NOT NULL,
  `part_number`         VARCHAR(80)  NOT NULL DEFAULT '',
  `compatible_make`     VARCHAR(80)  NOT NULL DEFAULT '',
  `compatible_model`    VARCHAR(100) NOT NULL DEFAULT '',
  `compatible_year_from`YEAR,
  `compatible_year_to`  YEAR,
  `category_id`         SMALLINT UNSIGNED NOT NULL,
  `price`               DECIMAL(10,2) NOT NULL,
  `condition_type`      ENUM('New','Used','Reconditioned') NOT NULL DEFAULT 'New',
  `stock_qty`           SMALLINT UNSIGNED,
  `description`         TEXT,
  `district`            VARCHAR(80)  NOT NULL DEFAULT '',
  `city`                VARCHAR(80)  NOT NULL DEFAULT '',
  `seller_name`         VARCHAR(120) NOT NULL DEFAULT '',
  `seller_phone`        VARCHAR(20)  NOT NULL DEFAULT '',
  `status`              ENUM('pending','approved','rejected','sold_out') NOT NULL DEFAULT 'pending',
  `rejection_reason`    TEXT,
  `featured`            TINYINT(1)   NOT NULL DEFAULT 0,
  `created_at`          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_spl_user`    (`user_id`),
  KEY `idx_spl_status`  (`status`),
  KEY `idx_spl_cat`     (`category_id`),
  KEY `idx_spl_district`(`district`),
  KEY `idx_spl_partnum` (`part_number`),
  CONSTRAINT `fk_spl_user`     FOREIGN KEY (`user_id`)     REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_spl_category` FOREIGN KEY (`category_id`) REFERENCES `part_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── SPARE PART IMAGES ────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `spare_part_images` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `listing_id` INT UNSIGNED NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `is_primary` TINYINT(1)   NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_spi_listing` (`listing_id`),
  CONSTRAINT `fk_spi_listing` FOREIGN KEY (`listing_id`) REFERENCES `spare_part_listings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── SERVICE CATEGORIES ───────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `service_categories` (
  `id`   SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_svc_cat_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── SERVICE PROVIDERS ────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `service_providers` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`       INT UNSIGNED NOT NULL,
  `business_name` VARCHAR(160) NOT NULL,
  `address`       VARCHAR(255) NOT NULL DEFAULT '',
  `district`      VARCHAR(80)  NOT NULL DEFAULT '',
  `city`          VARCHAR(80)  NOT NULL DEFAULT '',
  `contact_phone` VARCHAR(20)  NOT NULL DEFAULT '',
  `working_hours` VARCHAR(100) NOT NULL DEFAULT '',
  `description`   TEXT,
  `logo_path`     VARCHAR(255),
  `status`        ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_sp_user` (`user_id`),
  CONSTRAINT `fk_sp_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── SERVICES (items under a provider) ────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `services` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `provider_id` INT UNSIGNED NOT NULL,
  `category_id` SMALLINT UNSIGNED NOT NULL,
  `name`        VARCHAR(160) NOT NULL,
  `description` TEXT,
  `base_price`  DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `status`      ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `rejection_reason` TEXT,
  `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_svc_provider` (`provider_id`),
  KEY `idx_svc_category` (`category_id`),
  CONSTRAINT `fk_svc_provider` FOREIGN KEY (`provider_id`) REFERENCES `service_providers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_svc_category` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── SERVICE ADD-ONS ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `service_addons` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_id`  INT UNSIGNED NOT NULL,
  `addon_name`  VARCHAR(160) NOT NULL,
  `addon_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `idx_addon_service` (`service_id`),
  CONSTRAINT `fk_addon_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── INQUIRIES ────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `listing_type` ENUM('vehicle','part','service','contact') NOT NULL,
  `listing_id`   INT UNSIGNED,
  `sender_name`  VARCHAR(120) NOT NULL,
  `sender_phone` VARCHAR(20)  NOT NULL DEFAULT '',
  `sender_email` VARCHAR(180) NOT NULL DEFAULT '',
  `message`      TEXT NOT NULL,
  `is_read`      TINYINT(1)   NOT NULL DEFAULT 0,
  `created_at`   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inq_type_id` (`listing_type`, `listing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── PROMOTIONS ───────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `promotions` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `listing_type` ENUM('vehicle','part','service') NOT NULL,
  `listing_id`   INT UNSIGNED NOT NULL,
  `start_date`   DATE NOT NULL,
  `end_date`     DATE NOT NULL,
  `status`       ENUM('active','expired') NOT NULL DEFAULT 'active',
  `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_promo_type_id` (`listing_type`,`listing_id`),
  KEY `idx_promo_status`  (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
