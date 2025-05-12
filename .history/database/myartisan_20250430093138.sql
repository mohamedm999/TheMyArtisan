-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 30, 2025 at 08:31 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myartisan`
--

-- --------------------------------------------------------

--
-- Table structure for table `artisan_category`
--

DROP TABLE IF EXISTS `artisan_category`;
CREATE TABLE IF NOT EXISTS `artisan_category` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `artisan_profile_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artisan_category_artisan_profile_id_category_id_unique` (`artisan_profile_id`,`category_id`),
  KEY `artisan_category_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artisan_category`
--

INSERT INTO `artisan_category` (`id`, `artisan_profile_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 4, 9, NULL, NULL),
(2, 6, 1, NULL, NULL),
(3, 7, 5, NULL, NULL),
(4, 9, 1, NULL, NULL),
(5, 10, 1, NULL, NULL),
(6, 11, 1, NULL, NULL),
(7, 15, 1, NULL, NULL),
(8, 19, 5, NULL, NULL),
(9, 20, 1, NULL, NULL),
(10, 21, 1, NULL, NULL),
(11, 22, 1, NULL, NULL),
(12, 22, 2, NULL, NULL),
(13, 23, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `artisan_profiles`
--

DROP TABLE IF EXISTS `artisan_profiles`;
CREATE TABLE IF NOT EXISTS `artisan_profiles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `profession` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_me` text COLLATE utf8mb4_unicode_ci,
  `skills` json DEFAULT NULL,
  `experience_years` int UNSIGNED DEFAULT NULL,
  `hourly_rate` decimal(8,2) DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` bigint UNSIGNED DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint UNSIGNED DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_coordinates` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `availability_hours` json DEFAULT NULL,
  `business_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_registration_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insurance_details` text COLLATE utf8mb4_unicode_ci,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `profile_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','active','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artisan_profiles_user_id_unique` (`user_id`),
  KEY `artisan_profiles_city_id_foreign` (`city_id`),
  KEY `artisan_profiles_country_id_foreign` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artisan_profiles`
--

INSERT INTO `artisan_profiles` (`id`, `user_id`, `profession`, `about_me`, `skills`, `experience_years`, `hourly_rate`, `phone`, `address`, `city`, `city_id`, `country`, `country_id`, `state`, `postal_code`, `location_coordinates`, `availability_hours`, `business_name`, `business_registration_number`, `insurance_details`, `is_verified`, `profile_photo`, `cover_photo`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/2lAnHLnhmIb8iaCY0LAlGeiwgOovt8IDpir09wZj.jpg', NULL, 'approved', '2025-03-31 00:59:36', '2025-03-31 01:01:10'),
(2, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/Em79rdzHj7chJYagSJPe3ztpaceZ4ogPLNH7nIWc.jpg', NULL, 'approved', '2025-04-01 15:39:46', '2025-04-04 16:02:06'),
(3, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'rejected', '2025-04-01 15:40:04', '2025-04-01 15:40:17'),
(4, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/6lCFrZoYPwaj3BQNYiq3UahTAFPxNRqL3SwiVzeV.jpg', NULL, 'approved', '2025-04-03 19:56:17', '2025-04-03 21:00:07'),
(5, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'rejected', '2025-04-03 19:58:41', '2025-04-03 21:00:49'),
(6, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Marrakech', 3, 'Morocco', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/McjrUFVJYO4Ex4ln47QNnNNMTEyMG7SXNSKBAURv.jpg', NULL, 'approved', '2025-04-04 15:45:17', '2025-04-04 15:48:44'),
(7, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/hEXY7kMYjIAqhB5i7AAhdOt7Bfr1U1pp8dbz11Jj.jpg', NULL, 'approved', '2025-04-04 16:01:19', '2025-04-04 16:02:52'),
(8, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/8zUnQnQ07OyMdzgdmp8h6XwxbsrLf6G4lJLsq2u2.jpg', NULL, 'approved', '2025-04-08 08:38:55', '2025-04-09 13:49:11'),
(9, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Marrakech', 3, 'Morocco', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/uthsOU3Um86t9FB32uFVWUL32xGXC98el3W4aMot.jpg', NULL, 'approved', '2025-04-09 06:59:53', '2025-04-09 07:02:45'),
(10, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/9bQXpbvPr34wB7ggm26a5bAfLj3QL4YkQtXiSfKk.jpg', NULL, 'approved', '2025-04-09 07:16:26', '2025-04-09 07:20:09'),
(11, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/1GnD5HvEtGAyNH3hVAi1Z8OfOWFlW9neF2gXYyKC.jpg', NULL, 'approved', '2025-04-09 13:44:10', '2025-04-09 13:52:12'),
(12, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/8Y05uj3Yhjap3S5CsBmcgUaljqfqIowLd3y4J7QO.jpg', NULL, 'approved', '2025-04-14 13:43:37', '2025-04-14 14:15:13'),
(13, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'pending', '2025-04-14 14:14:55', '2025-04-14 14:14:55'),
(14, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'approved', '2025-04-22 08:29:17', '2025-04-22 08:59:44'),
(15, 33, 'Numquam incididunt s', 'Provident sit nost', '[\"Ut magnam sint quia\"]', 1979, 38.00, '+1 (305) 597-5532', 'Sunt veniam dolor d', 'Marrakech', 3, 'Morocco', 1, 'Eligendi sed et labo', 'Incididunt repudiand', NULL, NULL, 'Dara Woods', '779', 'Consequat Officiis', 0, 'profile-photos/bgSPOhAwmTidIooTwgQ8p1pweU9DWYcaybVOdKOn.jpg', NULL, 'approved', '2025-04-22 08:41:25', '2025-04-22 08:54:26'),
(16, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'pending', '2025-04-22 08:52:38', '2025-04-22 08:52:38'),
(17, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'pending', '2025-04-22 08:52:38', '2025-04-22 08:52:38'),
(18, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'pending', '2025-04-22 08:52:38', '2025-04-22 08:52:38'),
(19, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/wRMEQ0bT2kyRVbaud1BGj3IDeiS8ORTWWwsF7in5.jpg', NULL, 'approved', '2025-04-22 10:51:46', '2025-04-22 10:53:47'),
(20, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/bCgLUptFDQIyiXZbLu17JITVZJWEVkQLPP9ibKsc.jpg', NULL, 'approved', '2025-04-22 17:12:44', '2025-04-22 17:15:39'),
(21, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/dxoLPDd1lZkIBS8I5Go7xhXIhwPEPT2BznySA1Gy.jpg', NULL, 'pending', '2025-04-23 07:29:21', '2025-04-23 07:30:09'),
(22, 41, NULL, NULL, NULL, NULL, NULL, '+1 (987) 672-5268', 'Consequatur tempori', 'Essaouira', 11, 'Morocco', 1, 'Assumenda quis ex qu', 'Molestiae maxime in', NULL, NULL, NULL, NULL, NULL, 0, 'profile-photos/FpQCjYtWOLkFUNUdk5rYS04LuzJeFrxuHkOqZtRr.jpg', NULL, 'approved', '2025-04-24 15:57:55', '2025-04-24 16:02:41'),
(23, 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'approved', '2025-04-29 12:03:16', '2025-04-29 12:33:27');

-- --------------------------------------------------------

--
-- Table structure for table `availabilities`
--

DROP TABLE IF EXISTS `availabilities`;
CREATE TABLE IF NOT EXISTS `availabilities` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `artisan_profile_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('available','booked','unavailable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `booking_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `availabilities_artisan_profile_id_foreign` (`artisan_profile_id`),
  KEY `availabilities_booking_id_foreign` (`booking_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `availabilities`
--

INSERT INTO `availabilities` (`id`, `artisan_profile_id`, `date`, `start_time`, `end_time`, `status`, `booking_id`, `created_at`, `updated_at`) VALUES
(2, 9, '2025-04-09', '10:14:00', '11:00:00', 'available', NULL, '2025-04-09 07:01:56', '2025-04-09 07:01:56'),
(3, 20, '2025-04-23', '10:14:00', '12:14:00', 'available', NULL, '2025-04-22 17:16:56', '2025-04-22 17:16:56'),
(4, 23, '2025-04-29', '14:07:00', '14:59:00', 'available', NULL, '2025-04-29 12:03:48', '2025-04-29 12:03:48');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `artisan_profile_id` bigint UNSIGNED NOT NULL,
  `client_profile_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `booking_date` datetime NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookings_artisan_profile_id_foreign` (`artisan_profile_id`),
  KEY `bookings_client_profile_id_foreign` (`client_profile_id`),
  KEY `bookings_service_id_foreign` (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `artisan_profile_id`, `client_profile_id`, `service_id`, `booking_date`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2025-03-31 01:02:00', 'completed', 'Amet soluta sunt de', '2025-03-31 01:02:50', '2025-03-31 01:03:12'),
(2, 1, 3, 1, '2025-04-03 21:02:00', 'pending', NULL, '2025-04-03 21:02:06', '2025-04-03 21:02:06'),
(3, 4, 3, 2, '2025-04-03 21:17:00', 'pending', NULL, '2025-04-03 21:17:08', '2025-04-03 21:17:08'),
(4, 6, 4, 3, '2025-04-04 15:50:00', 'completed', NULL, '2025-04-04 15:50:25', '2025-04-04 15:50:40'),
(5, 7, 4, 4, '2025-04-04 16:03:00', 'completed', NULL, '2025-04-04 16:03:20', '2025-04-04 16:03:38'),
(6, 9, 5, 5, '2025-04-09 09:04:00', 'completed', NULL, '2025-04-09 07:04:12', '2025-04-09 07:12:26'),
(7, 11, 7, 7, '2025-04-09 15:52:00', 'pending', NULL, '2025-04-09 13:52:43', '2025-04-09 13:52:43'),
(8, 12, 9, 8, '2025-04-14 16:16:00', 'completed', NULL, '2025-04-14 14:16:39', '2025-04-14 14:17:00'),
(9, 12, 9, 8, '2025-04-14 16:28:00', 'completed', NULL, '2025-04-14 14:28:44', '2025-04-14 14:29:06'),
(10, 12, 9, 8, '2025-04-14 16:32:00', 'completed', NULL, '2025-04-14 14:32:48', '2025-04-14 14:33:22'),
(11, 15, 12, 9, '2025-04-22 10:56:00', 'completed', NULL, '2025-04-22 08:56:14', '2025-04-22 08:56:31'),
(12, 15, 12, 9, '2025-04-22 11:10:00', 'completed', NULL, '2025-04-22 09:10:22', '2025-04-22 09:10:37'),
(13, 19, 13, 10, '2025-04-22 12:54:00', 'completed', NULL, '2025-04-22 10:54:24', '2025-04-22 10:54:48'),
(14, 20, 14, 11, '2025-04-22 19:17:00', 'completed', NULL, '2025-04-22 17:17:55', '2025-04-22 17:18:34');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `image`, `parent_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Zellige & Tileworkk', 'zellige-tileworkk', 'Traditional Moroccan mosaic tile craftsmanship', NULL, 'zellige_tilework.jpg', NULL, 1, '2025-03-31 00:58:55', '2025-04-29 12:47:02'),
(2, 'Woodworking & Cedar Craft', 'woodworking-cedar-craft', 'Hand-carved wooden furniture and decor', NULL, 'woodworking_cedar_craft.jpg', NULL, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(3, 'Metal Engraving & Brasswork', 'metal-engraving-brasswork', 'Engraved brass and copper crafts', NULL, 'metal_engraving_brasswork.jpg', NULL, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(4, 'Leatherwork & Tannery', 'leatherwork-tannery', 'Handmade leather goods from Fez tanneries', NULL, 'leatherwork_tannery.jpg', NULL, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(5, 'Pottery & Ceramics', 'pottery-ceramics', 'Safi pottery and hand-painted ceramics', NULL, 'pottery_ceramics.jpg', NULL, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(6, 'Weaving & Textiles', 'weaving-textiles', 'Handwoven Berber rugs and silk embroidery', NULL, 'weaving_textiles.jpg', NULL, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(7, 'Jewelry & Silverwork', 'jewelry-silverwork', 'Traditional Amazigh silver jewelry', NULL, 'jewelry_silverwork.jpg', NULL, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(8, 'Plaster & Gypsum Art', 'plaster-gypsum-art', 'Intricate Moroccan plaster and gypsum carvings', NULL, 'plaster_gypsum_art.jpg', NULL, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(9, 'wicker basket (chriite)', 'wicker-basket-chriite', NULL, NULL, '1743471901.jpg', NULL, 1, '2025-04-01 01:45:01', '2025-04-01 01:45:01');

-- --------------------------------------------------------

--
-- Table structure for table `certifications`
--

DROP TABLE IF EXISTS `certifications`;
CREATE TABLE IF NOT EXISTS `certifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `artisan_profile_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issuer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid_until` date DEFAULT NULL,
  `credential_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credential_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `certifications_artisan_profile_id_foreign` (`artisan_profile_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certifications`
--

INSERT INTO `certifications` (`id`, `artisan_profile_id`, `name`, `issuer`, `valid_until`, `credential_id`, `credential_url`, `description`, `created_at`, `updated_at`) VALUES
(1, 4, 'Karly Peterson', 'Fletcher and Brock Plc', '1995-02-07', NULL, NULL, NULL, '2025-04-03 19:56:36', '2025-04-03 19:56:36'),
(2, 9, 'Doris Murray', 'Pacheco and Moore Inc', '1983-08-09', NULL, NULL, NULL, '2025-04-09 07:01:07', '2025-04-09 07:01:07'),
(3, 15, 'Dominique Calderon', 'Mathews and Patterson Co', '1996-08-31', NULL, NULL, NULL, '2025-04-22 08:42:20', '2025-04-22 08:42:20'),
(4, 20, 'Barry Oneal', 'Sanford and Miles Plc', '2019-06-08', NULL, NULL, NULL, '2025-04-22 17:13:49', '2025-04-22 17:13:49'),
(5, 21, 'Dylan Flowers', 'Whitfield Everett Plc', '1977-01-11', NULL, NULL, NULL, '2025-04-23 07:30:59', '2025-04-23 07:30:59'),
(6, 22, 'Quinlan Sheppard', 'Larsen and Byers Trading', '2005-09-12', NULL, NULL, NULL, '2025-04-24 15:59:43', '2025-04-24 15:59:43');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cities_name_country_id_unique` (`name`,`country_id`),
  KEY `cities_country_id_foreign` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `country_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Casablanca', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(2, 'Rabat', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(3, 'Marrakech', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(4, 'Fez', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(5, 'Tangier', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(6, 'Agadir', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(7, 'Meknes', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(8, 'Oujda', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(9, 'Kenitra', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(10, 'Tetouan', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(11, 'Essaouira', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(12, 'Chefchaouen', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(13, 'El Jadida', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(14, 'Taroudant', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(15, 'Ouarzazate', 1, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(16, 'Paris', 2, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(17, 'Lyon', 2, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(18, 'Marseille', 2, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(19, 'Toulouse', 2, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(20, 'Nice', 2, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(21, 'Nantes', 2, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(22, 'Strasbourg', 2, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(23, 'Montpellier', 2, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(24, 'Bordeaux', 2, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(25, 'Lille', 2, 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `client_points`
--

DROP TABLE IF EXISTS `client_points`;
CREATE TABLE IF NOT EXISTS `client_points` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `points_balance` int NOT NULL DEFAULT '0',
  `lifetime_points` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_points_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_points`
--

INSERT INTO `client_points` (`id`, `user_id`, `points_balance`, `lifetime_points`, `created_at`, `updated_at`) VALUES
(1, 24, 0, 0, '2025-04-13 18:27:22', '2025-04-13 18:27:22'),
(2, 25, 191, 227, '2025-04-14 12:25:54', '2025-04-22 08:53:22'),
(3, 18, 0, 0, '2025-04-14 13:31:37', '2025-04-14 13:31:37'),
(4, 34, 50, 50, '2025-04-22 08:56:53', '2025-04-22 09:11:00'),
(5, 36, 17, 125, '2025-04-22 10:55:05', '2025-04-22 12:43:50'),
(6, 38, 122, 189, '2025-04-22 17:19:05', '2025-04-22 17:24:55'),
(7, 42, 73, 73, '2025-04-29 14:24:31', '2025-04-29 14:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `client_profiles`
--

DROP TABLE IF EXISTS `client_profiles`;
CREATE TABLE IF NOT EXISTS `client_profiles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferences` json DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_profiles_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_profiles`
--

INSERT INTO `client_profiles` (`id`, `user_id`, `phone`, `address`, `city`, `state`, `postal_code`, `profile_photo`, `preferences`, `bio`, `created_at`, `updated_at`) VALUES
(1, 3, NULL, NULL, NULL, NULL, NULL, 'clients/1743382914_client_profile.jpg', NULL, NULL, '2025-03-31 01:01:54', '2025-03-31 01:01:54'),
(2, 4, NULL, NULL, NULL, NULL, NULL, 'clients/1743468515_client_profile.jpg', NULL, NULL, '2025-04-01 00:48:35', '2025-04-01 00:48:35'),
(3, 10, NULL, NULL, NULL, NULL, NULL, 'clients/1743710138_client_profile.jpg', NULL, NULL, '2025-04-03 19:55:38', '2025-04-03 19:55:38'),
(4, 11, NULL, NULL, NULL, NULL, NULL, 'clients/1743781626_client_profile.jpg', NULL, NULL, '2025-04-04 15:47:06', '2025-04-04 15:47:06'),
(5, 18, NULL, NULL, NULL, NULL, NULL, 'clients/1744185580_client_profile.jpg', NULL, NULL, '2025-04-09 06:59:40', '2025-04-09 06:59:40'),
(6, 20, NULL, NULL, NULL, NULL, NULL, 'clients/1744186717_client_profile.jpg', NULL, NULL, '2025-04-09 07:18:37', '2025-04-09 07:18:37'),
(7, 21, NULL, NULL, NULL, NULL, NULL, 'clients/1744210094_client_profile.jpg', NULL, NULL, '2025-04-09 13:48:14', '2025-04-09 13:48:14'),
(8, 24, NULL, NULL, NULL, NULL, NULL, 'clients/1744572320_client_profile.jpg', NULL, NULL, '2025-04-13 18:25:20', '2025-04-13 18:25:20'),
(9, 25, NULL, NULL, NULL, NULL, NULL, 'clients/1744637138_client_profile.jpg', NULL, NULL, '2025-04-14 12:25:38', '2025-04-14 12:25:38'),
(10, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-22 08:24:41', '2025-04-22 08:24:41'),
(11, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-22 08:25:51', '2025-04-22 08:25:51'),
(12, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Id accusamus in anim', '2025-04-22 08:51:38', '2025-04-22 08:51:46'),
(13, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Voluptate odio quia', '2025-04-22 10:53:10', '2025-04-22 10:53:21'),
(14, 38, '+1 (487) 448-9805', 'Veniam nisi et quas', 'Quo occaecat et reic', 'Pariatur Sunt dolo', 'Nisi a rerum aliqua', NULL, NULL, NULL, '2025-04-22 17:14:43', '2025-04-22 17:14:55'),
(15, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ut necessitatibus te', '2025-04-23 07:32:10', '2025-04-23 07:32:18'),
(16, 42, '+1 (519) 372-8284', 'Vel quo alias odit i', 'Ut deleniti placeat', 'Doloremque enim exce', 'In maiores maiores a', NULL, NULL, 'Repellendus Quam el', '2025-04-24 16:01:00', '2025-04-24 16:01:37'),
(17, 44, NULL, NULL, NULL, NULL, NULL, 'clients/1746001750_client_profile.jpg', NULL, NULL, '2025-04-30 07:09:40', '2025-04-30 07:29:11'),
(18, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-30 07:29:40', '2025-04-30 07:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
CREATE TABLE IF NOT EXISTS `conversations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint UNSIGNED NOT NULL,
  `artisan_id` bigint UNSIGNED NOT NULL,
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `conversations_client_id_artisan_id_unique` (`client_id`,`artisan_id`),
  KEY `conversations_artisan_id_foreign` (`artisan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries_code_unique` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Morocco', 'MAR', 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(2, 'France', 'FRA', 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(3, 'Spain', 'ESP', 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(4, 'United Kingdom', 'GBR', 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(5, 'United States', 'USA', 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(6, 'Germany', 'DEU', 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(7, 'Italy', 'ITA', 1, '2025-03-31 00:58:55', '2025-03-31 00:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_conversation_id_foreign` (`conversation_id`),
  KEY `messages_sender_id_foreign` (`sender_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_01_01_000000_create_roles_table', 1),
(7, '2023_01_02_000000_create_role_user_table', 1),
(8, '2023_01_03_000000_create_categories_table', 1),
(9, '2023_01_04_000000_create_artisan_profiles_table', 1),
(10, '2023_01_05_000000_create_client_profiles_table', 1),
(11, '2023_01_06_000000_create_work_experiences_table', 1),
(12, '2023_01_07_000000_create_certifications_table', 1),
(13, '2023_01_08_000000_create_services_table', 1),
(14, '2023_01_09_000000_create_bookings_table', 1),
(15, '2023_01_10_000000_create_availabilities_table', 1),
(16, '2023_01_11_000000_create_settings_table', 1),
(17, '2023_06_15_100000_create_saved_artisans_table', 1),
(18, '2023_07_01_000000_create_artisan_category_table', 1),
(19, '2023_07_20_000000_create_countries_table', 1),
(20, '2023_07_20_000001_create_cities_table', 1),
(21, '2023_07_20_000002_add_city_and_country_ids_to_artisan_profiles', 1),
(22, 'xxxx_xx_xx_xxxxxx_create_reviews_table', 1),
(23, 'xxxx_xx_xx_create_conversations_table', 2),
(24, 'xxxx_xx_xx_create_messages_table', 2),
(25, '2025_04_13_183929_create_client_points_table', 3),
(26, '2025_04_13_184648_create_store_products_table', 3),
(27, '2025_04_13_184717_create_point_transactions_table', 3),
(28, '2025_04_13_184753_create_product_orders_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `point_transactions`
--

DROP TABLE IF EXISTS `point_transactions`;
CREATE TABLE IF NOT EXISTS `point_transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `points` int NOT NULL,
  `type` enum('earned','spent','expired','refunded','adjusted') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionable_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `point_transactions_user_id_foreign` (`user_id`),
  KEY `point_transactions_transactionable_type_transactionable_id_index` (`transactionable_type`,`transactionable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `point_transactions`
--

INSERT INTO `point_transactions` (`id`, `user_id`, `points`, `type`, `description`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES
(1, 25, 25, 'earned', 'Points earned for writing review #6', 'App\\Models\\Review', 6, '2025-04-14 14:29:40', '2025-04-14 14:29:40'),
(2, 25, 25, 'earned', 'Points earned for writing review #7', 'App\\Models\\Review', 7, '2025-04-14 14:33:52', '2025-04-14 14:33:52'),
(3, 25, -36, 'spent', 'Purchase of Cheryl Pacheco (x1)', 'App\\Models\\ProductOrder', 1, '2025-04-14 14:34:32', '2025-04-14 14:34:32'),
(4, 25, 177, 'earned', 'i want to', 'App\\Models\\User', 1, '2025-04-22 08:53:22', '2025-04-22 08:53:22'),
(5, 34, 25, 'earned', 'Points earned for writing review #8', 'App\\Models\\Review', 8, '2025-04-22 08:56:53', '2025-04-22 08:56:53'),
(6, 34, 25, 'earned', 'Points earned for writing review #9', 'App\\Models\\Review', 9, '2025-04-22 09:11:00', '2025-04-22 09:11:00'),
(7, 36, 25, 'earned', 'Points earned for writing review #10', 'App\\Models\\Review', 10, '2025-04-22 10:55:05', '2025-04-22 10:55:05'),
(8, 36, 100, 'earned', 'i just want', 'App\\Models\\User', 1, '2025-04-22 10:56:41', '2025-04-22 10:56:41'),
(9, 36, -36, 'spent', 'Purchase of Cheryl Pacheco (x1)', 'App\\Models\\ProductOrder', 2, '2025-04-22 10:56:56', '2025-04-22 10:56:56'),
(10, 36, -72, 'spent', 'Purchase of Cheryl Pacheco (x2)', 'App\\Models\\ProductOrder', 3, '2025-04-22 12:43:50', '2025-04-22 12:43:50'),
(11, 38, 25, 'earned', 'Points earned for writing review #11', 'App\\Models\\Review', 11, '2025-04-22 17:19:05', '2025-04-22 17:19:05'),
(12, 38, 17, 'earned', 'ghiiir nghiit', 'App\\Models\\User', 1, '2025-04-22 17:23:39', '2025-04-22 17:23:39'),
(13, 38, 147, 'earned', 'ghiiir nghiit 3awtani', 'App\\Models\\User', 1, '2025-04-22 17:24:23', '2025-04-22 17:24:23'),
(14, 38, -67, 'spent', 'Purchase of Daphne Michael (x1)', 'App\\Models\\ProductOrder', 4, '2025-04-22 17:24:55', '2025-04-22 17:24:55'),
(15, 42, 73, 'earned', 'Est hic in mollitia', 'App\\Models\\User', 1, '2025-04-29 14:24:31', '2025-04-29 14:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `product_orders`
--

DROP TABLE IF EXISTS `product_orders`;
CREATE TABLE IF NOT EXISTS `product_orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `store_product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `points_spent` int NOT NULL,
  `status` enum('pending','completed','cancelled','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `delivery_details` text COLLATE utf8mb4_unicode_ci,
  `tracking_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redeemed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_orders_user_id_foreign` (`user_id`),
  KEY `product_orders_store_product_id_foreign` (`store_product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_orders`
--

INSERT INTO `product_orders` (`id`, `user_id`, `store_product_id`, `quantity`, `points_spent`, `status`, `delivery_details`, `tracking_number`, `redeemed_at`, `created_at`, `updated_at`) VALUES
(1, 25, 2, 1, 36, 'pending', '\"Voluptas laudantium\"', NULL, NULL, '2025-04-14 14:34:32', '2025-04-14 14:34:32'),
(2, 36, 2, 1, 36, 'pending', '\"hfjkfjgrrg\"', NULL, NULL, '2025-04-22 10:56:56', '2025-04-22 10:56:56'),
(3, 36, 2, 2, 72, 'pending', '\"hygujj\"', NULL, NULL, '2025-04-22 12:43:50', '2025-04-22 12:43:50'),
(4, 38, 1, 1, 67, 'pending', '\"grdbcjfyugyi\"', NULL, NULL, '2025-04-22 17:24:55', '2025-04-22 17:24:55');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_profile_id` bigint UNSIGNED DEFAULT NULL,
  `artisan_profile_id` bigint UNSIGNED DEFAULT NULL,
  `booking_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `rating` tinyint UNSIGNED NOT NULL COMMENT 'Rating from 1-5',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `response` text COLLATE utf8mb4_unicode_ci,
  `response_date` timestamp NULL DEFAULT NULL,
  `reported` tinyint(1) NOT NULL DEFAULT '0',
  `report_reason` text COLLATE utf8mb4_unicode_ci,
  `report_date` timestamp NULL DEFAULT NULL,
  `status` enum('published','pending','rejected','hidden') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `is_verified_purchase` tinyint(1) NOT NULL DEFAULT '1',
  `helpful_count` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_artisan_profile_id_foreign` (`artisan_profile_id`),
  KEY `reviews_booking_id_foreign` (`booking_id`),
  KEY `reviews_service_id_foreign` (`service_id`),
  KEY `reviews_index` (`client_profile_id`,`artisan_profile_id`,`booking_id`,`service_id`,`rating`,`reported`,`status`,`is_verified_purchase`,`is_featured`),
  KEY `reviews_reported_index` (`reported`),
  KEY `reviews_status_index` (`status`),
  KEY `reviews_is_featured_index` (`is_featured`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `client_profile_id`, `artisan_profile_id`, `booking_id`, `service_id`, `rating`, `comment`, `response`, `response_date`, `reported`, `report_reason`, `report_date`, `status`, `is_verified_purchase`, `helpful_count`, `is_featured`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 'nice joboo', NULL, NULL, 0, NULL, NULL, 'published', 1, 0, 0, NULL, '2025-03-31 01:04:25', '2025-03-31 01:04:25'),
(2, 4, 6, 4, 3, 1, 'nice jooob', NULL, NULL, 0, NULL, NULL, 'published', 1, 0, 0, NULL, '2025-04-04 15:51:22', '2025-04-04 15:51:22'),
(3, 4, 7, 5, 4, 2, 'nicee joooob', 'oh tnank you', '2025-04-04 16:10:00', 0, NULL, NULL, 'published', 1, 0, 0, NULL, '2025-04-04 16:04:06', '2025-04-04 16:10:00'),
(4, 5, 9, 6, 5, 1, 'niiiiice job', 'shoookran bro', '2025-04-09 07:13:20', 0, NULL, NULL, 'published', 1, 0, 0, NULL, '2025-04-09 07:12:55', '2025-04-09 07:13:20'),
(5, 9, 12, 8, 8, 2, 'niiiiice job', NULL, NULL, 0, NULL, NULL, 'published', 1, 0, 0, NULL, '2025-04-14 14:17:30', '2025-04-14 14:17:30'),
(6, 9, 12, 9, 8, 5, 'niiiice joob', NULL, NULL, 0, NULL, NULL, 'published', 1, 0, 0, NULL, '2025-04-14 14:29:40', '2025-04-14 14:29:40'),
(7, 9, 12, 10, 8, 4, 'nice job broo', NULL, NULL, 0, NULL, NULL, 'published', 1, 0, 0, NULL, '2025-04-14 14:33:52', '2025-04-14 14:33:52'),
(8, 12, 15, 11, 9, 5, 'niiiiiiiiiiiice', NULL, NULL, 0, NULL, NULL, 'published', 1, 0, 0, NULL, '2025-04-22 08:56:53', '2025-04-22 08:56:53'),
(9, 12, 15, 12, 9, 4, 'nikiiiiiiiijn', NULL, NULL, 0, NULL, NULL, 'published', 1, 0, 0, NULL, '2025-04-22 09:11:00', '2025-04-22 09:11:00'),
(10, 13, 19, 13, 10, 3, 'niceeee work', NULL, NULL, 0, NULL, NULL, 'published', 1, 0, 0, NULL, '2025-04-22 10:55:05', '2025-04-22 10:55:05'),
(11, 14, 20, 14, 11, 3, 'khdmaaaa mzyana', 'lhfdaaaak', '2025-04-22 17:19:33', 0, NULL, NULL, 'published', 1, 0, 0, NULL, '2025-04-22 17:19:05', '2025-04-22 17:19:33');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', 'Platform administrator with full access', '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(2, 'artisan', 'Artisan', 'Artisan who provides services', '2025-03-31 00:58:55', '2025-03-31 00:58:55'),
(3, 'client', 'Client', 'Client who seeks services', '2025-03-31 00:58:55', '2025-03-31 00:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_user_user_id_role_id_unique` (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 2, NULL, NULL),
(3, 3, 3, NULL, NULL),
(4, 4, 3, NULL, NULL),
(5, 5, 2, NULL, NULL),
(6, 6, 2, NULL, NULL),
(7, 7, 2, NULL, NULL),
(8, 8, 3, NULL, NULL),
(9, 9, 2, NULL, NULL),
(10, 10, 3, NULL, NULL),
(11, 11, 3, NULL, NULL),
(12, 12, 2, NULL, NULL),
(13, 13, 2, NULL, NULL),
(14, 14, 3, NULL, NULL),
(15, 15, 3, NULL, NULL),
(16, 16, 2, NULL, NULL),
(17, 17, 2, NULL, NULL),
(18, 18, 3, NULL, NULL),
(19, 19, 2, NULL, NULL),
(20, 20, 3, NULL, NULL),
(21, 21, 3, NULL, NULL),
(22, 22, 2, NULL, NULL),
(23, 23, 2, NULL, NULL),
(24, 24, 3, NULL, NULL),
(25, 25, 3, NULL, NULL),
(26, 26, 2, NULL, NULL),
(27, 27, 2, NULL, NULL),
(28, 28, 3, NULL, NULL),
(29, 29, 2, NULL, NULL),
(30, 30, 3, NULL, NULL),
(31, 31, 2, NULL, NULL),
(32, 32, 2, NULL, NULL),
(33, 33, 2, NULL, NULL),
(34, 34, 3, NULL, NULL),
(35, 35, 2, NULL, NULL),
(36, 36, 3, NULL, NULL),
(37, 37, 2, NULL, NULL),
(38, 38, 3, NULL, NULL),
(39, 39, 2, NULL, NULL),
(40, 40, 3, NULL, NULL),
(41, 41, 2, NULL, NULL),
(42, 42, 3, NULL, NULL),
(43, 43, 2, NULL, NULL),
(44, 44, 3, NULL, NULL),
(45, 45, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `saved_artisans`
--

DROP TABLE IF EXISTS `saved_artisans`;
CREATE TABLE IF NOT EXISTS `saved_artisans` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `artisan_profile_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `saved_artisans_user_id_artisan_profile_id_unique` (`user_id`,`artisan_profile_id`),
  KEY `saved_artisans_artisan_profile_id_foreign` (`artisan_profile_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saved_artisans`
--

INSERT INTO `saved_artisans` (`id`, `user_id`, `artisan_profile_id`, `created_at`, `updated_at`) VALUES
(1, 36, 1, '2025-04-22 13:36:32', '2025-04-22 13:36:32'),
(2, 38, 20, '2025-04-22 17:20:03', '2025-04-22 17:20:03'),
(3, 38, 1, '2025-04-22 17:21:05', '2025-04-22 17:21:05');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `artisan_profile_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `duration` int DEFAULT NULL COMMENT 'Duration in minutes',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`),
  KEY `services_artisan_profile_id_foreign` (`artisan_profile_id`),
  KEY `services_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `artisan_profile_id`, `name`, `slug`, `image`, `description`, `price`, `duration`, `is_active`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ashely Tyler', 'ashely-tyler-67e9e8f82eb3d', 'services/1743382776_2Uzxl7fjna.jpg', 'Eveniet qui nulla a', 454.00, 62, 1, 5, '2025-03-31 00:59:36', '2025-03-31 00:59:36'),
(2, 4, 'Germane Yates', 'germane-yates-67eee805d757a', 'services/1743710213_BU56bhXHkQ.jfif', 'Consequat Voluptate', 870.00, 44, 1, 6, '2025-04-03 19:56:53', '2025-04-03 19:56:53'),
(3, 6, 'Daniel Merritt', 'daniel-merritt-67efffa038c23', 'services/1743781792_hA1JDgh4oG.jpg', 'Neque fugiat atque', 377.00, 14, 1, 9, '2025-04-04 15:49:52', '2025-04-04 15:49:52'),
(4, 7, 'Jonah Tanner', 'jonah-tanner-67f002686e16a', 'services/1743782504_fzrgieG2ed.jfif', 'Tenetur omnis in ab', 318.00, 79, 1, 3, '2025-04-04 16:01:44', '2025-04-04 16:01:44'),
(5, 9, 'Hedley Cotton', 'hedley-cotton-67f629574d9c0', 'services/1744185687_PACwUMZzJK.jfif', 'Officiis sed velit e', 777.00, 82, 1, 7, '2025-04-09 07:01:27', '2025-04-09 07:01:27'),
(6, 10, 'Gil Ford', 'gil-ford-67f62d10227dc', 'services/1744186640_ZGx0Et3hpW.jfif', 'Ullam voluptatum nih', 701.00, 4, 1, 7, '2025-04-09 07:17:20', '2025-04-09 07:17:20'),
(7, 11, 'Shad Vega', 'shad-vega-67f68990ac081', 'services/1744210320_eFICxIx6hU.jfif', 'Et labore vitae mole', 20.00, 92, 1, 8, '2025-04-09 13:52:00', '2025-04-09 13:52:00'),
(8, 12, 'Andrew Kelly', 'andrew-kelly-67fd26b8c017f', 'services/1744643768_U02ZEkzrGs.jpg', 'Et quaerat placeat', 775.00, 81, 1, 9, '2025-04-14 14:16:08', '2025-04-14 14:16:08'),
(9, 15, 'Kenyon Melendez', 'kenyon-melendez-6807677de142b', 'services/1745315709_Q5jdoK1d9U.jpg', 'Odit laboris consect', 12.00, 74, 1, 2, '2025-04-22 08:55:09', '2025-04-22 08:55:09'),
(10, 19, 'Alexis Webster', 'alexis-webster-6807830a0bf1f', 'services/1745322762_f4gS5ed7Bk.jpg', 'Duis sit voluptates', 82.00, 80, 0, 4, '2025-04-22 10:52:42', '2025-04-22 10:52:42'),
(11, 20, 'Kalia Shaw', 'kalia-shaw-6807dc7cf205b', 'services/1745345660_hNHJzR016x.jpg', 'Itaque at excepteur', 950.00, 55, 1, 6, '2025-04-22 17:14:21', '2025-04-22 17:14:21'),
(13, 21, 'Ginger Phelps', 'ginger-phelps-6808a561eacaf', 'services/1745397089_C4tTKvZv4V.jpg', 'Dolorum quia omnis o', 724.00, 17, 1, 9, '2025-04-23 07:31:29', '2025-04-23 07:31:29'),
(14, 22, 'Raja Jensen', 'raja-jensen-680a6e13e3251', 'services/1745514003_K0DiJfJCCd.jpg', 'Non culpa sit et cul', 503.00, 58, 1, 5, '2025-04-24 16:00:03', '2025-04-24 16:00:03'),
(15, 23, 'Tanya Hopper', 'tanya-hopper-6810cf4ab3c4c', 'services/1745932106_KTDxcDL4T4.jpg', 'Et consequat Dolor', 827.00, 31, 1, 1, '2025-04-29 12:08:26', '2025-04-29 12:08:26');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'MyArtisan', NULL, NULL),
(2, 'contact_email', 'contact@myartisan.com', NULL, NULL),
(3, 'site_description', 'Your trusted platform for finding quality artisans and services.', NULL, NULL),
(4, 'commission_rate', '10', NULL, NULL),
(5, 'tax_rate', '20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_products`
--

DROP TABLE IF EXISTS `store_products`;
CREATE TABLE IF NOT EXISTS `store_products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `points_cost` int NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `stock` int NOT NULL DEFAULT '-1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_products`
--

INSERT INTO `store_products` (`id`, `name`, `description`, `points_cost`, `image`, `category`, `is_featured`, `is_available`, `stock`, `created_at`, `updated_at`) VALUES
(1, 'Daphne Michael', 'Commodo tem', 67, 'products/9VKfcVKDqoDulL8ggJtMULkDKxTR7xppwuFE53nn.jpg', 'Esse magna aliqua', 0, 1, 3, '2025-04-14 13:59:07', '2025-04-22 17:24:55'),
(2, 'Cheryl Pacheco', 'Est dolorum consequ', 36, 'products/a12ABhuJS9rXsgY9Auils0YpwwouoJ9zOpEo5Aw1.jpg', 'Necessitatibus ut in', 0, 1, 83, '2025-04-14 14:30:41', '2025-04-29 13:35:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive','suspended','pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `email_verified_at`, `status`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'mohamed', 'moukhtari', 'mohamed1@gmail.com', NULL, 'active', '$2y$10$Ee3DBTtPHz4yEqg5Z/5b6OQZGXz1D9uXDY3GdONR73tba/KwoMBOC', 'wsQaYGFGSgtVauToKhGgVyjJj3BznW2Bxbl6MLm3lXHiGMds2bw51VamiIcy', '2025-03-31 00:59:02', '2025-03-31 00:59:02'),
(2, 'Robert', 'Montoya', 'nalu@mailinator.com', NULL, 'active', '$2y$10$4PAZksjjh/NDAtA6h/tkh.AJkebQ18CQyjKQGYpeSp4HNe9rGwuWK', NULL, '2025-03-31 00:59:19', '2025-03-31 00:59:19'),
(3, 'Ruth', 'Watson', 'divyr@mailinator.com', NULL, 'active', '$2y$10$qsfy8P2u9JSG91DCYd1jPO4qoy1AEtsctt3c48Y2liiqF0m/Igkpy', NULL, '2025-03-31 01:00:46', '2025-03-31 01:00:46'),
(4, 'Hanae', 'Pratt', 'dewe@mailinator.com', NULL, 'active', '$2y$10$kxEGv6A7W9w5nqmL6dMHp.nQ1XaMDHmlSoIUc73ni8hdeUsdfyaOq', NULL, '2025-04-01 00:48:14', '2025-04-01 00:48:14'),
(5, 'Leroy', 'Delacruz', 'ladoka@mailinator.com', NULL, 'active', '$2y$10$ExdxVRfKVKHqsSAM4PYe0.nglylhjjo8v0vMhS1neTAB6euJP7QJS', NULL, '2025-04-01 01:45:32', '2025-04-01 01:45:32'),
(6, 'Aretha', 'Roberson', 'zerokenil@mailinator.com', NULL, 'active', '$2y$10$CN6oD34aVp.xLBwdAuqAUu8NiQHRLwFKMgNR/VA1/lqo2uAhJBxvq', NULL, '2025-04-01 15:00:02', '2025-04-01 15:00:02'),
(7, 'Serina', 'Browning', 'xytocazid@mailinator.com', NULL, 'active', '$2y$10$.lQ7IrFhCi11ez4F/kEChe/lZr0F3CJ6J4thjotVKvBxllczlfge6', NULL, '2025-04-01 16:19:27', '2025-04-01 16:19:27'),
(8, 'Gail', 'Wallace', 'pekyqamy@mailinator.com', NULL, 'active', '$2y$10$OUVCY/CRnfJfpPRS3/zOLOkeB324mNA1TKe5s4DQCmlbizoGkd8B.', NULL, '2025-04-01 16:19:54', '2025-04-01 16:19:54'),
(9, 'Garth', 'Sutton', 'jedifa@mailinator.com', NULL, 'active', '$2y$10$ED88ucGItdNsuz3.GJSYBuge4.pjkTAPoyXqXHQSLjdB1zHFrTIIi', NULL, '2025-04-03 19:55:05', '2025-04-03 19:55:05'),
(10, 'Perry', 'Roberts', 'libi@mailinator.com', NULL, 'active', '$2y$10$mf8op9PMxsK6ZQcuL8q8DOsr./vW.3moEs1B/Cs1M3O5nZ1sa22cy', NULL, '2025-04-03 19:55:30', '2025-04-03 19:55:30'),
(11, 'Garrett', 'Matthews', 'losu@mailinator.com', NULL, 'active', '$2y$10$eGXqsbqNPdKVnu3lXooxoeGPsqxvUGhxTBy9Ww3ammtIiGOfPepRi', NULL, '2025-04-04 15:41:16', '2025-04-04 15:41:16'),
(12, 'Jeremy', 'Rice', 'puninesa@mailinator.com', NULL, 'active', '$2y$10$aktFXgI54Tiw5i0LYTdcG.qlAuJQRLehMTuT3Ya2/rVf4wOtlBT1i', NULL, '2025-04-04 15:41:29', '2025-04-04 15:41:29'),
(13, 'Nasim', 'Mills', 'cinekino@mailinator.com', NULL, 'active', '$2y$10$fucRCMQ/oQNlSElvbjQdEOLvvKuut9Xu0TSxmYhQKBrJu47.OFFjK', NULL, '2025-04-04 16:01:10', '2025-04-04 16:01:10'),
(14, 'Suki', 'Duran', 'kumihazul@mailinator.com', NULL, 'active', '$2y$10$qG7Rd8hmfJr7oM8ZPrhPceJ27ieZEftbO6CpQ.3Ri0HARIzNmEa4G', NULL, '2025-04-08 08:30:24', '2025-04-08 08:30:24'),
(15, 'Channing', 'Fitzpatrick', 'jova@mailinator.com', NULL, 'active', '$2y$10$BreivY.zn0KXD0N3CArRaeBqluT0GF5TIIPXUjHBTCXYvieHs8UKO', NULL, '2025-04-08 08:36:27', '2025-04-08 08:36:27'),
(16, 'Maryam', 'Gomez', 'peqyberot@mailinator.com', NULL, 'active', '$2y$10$IAsigEK1TXtoBFl7HLhb5OQLD95azYM.qMFott3XS8sSox7tykm6C', NULL, '2025-04-08 08:36:48', '2025-04-08 08:36:48'),
(17, 'Hilda', 'Conway', 'tywipigece@mailinator.com', NULL, 'active', '$2y$10$l6IgcUZrp34hB.Pp.eE3P.lbxCDsgmi5lWVIZS0M78Q9CARkusa4W', NULL, '2025-04-09 06:58:29', '2025-04-09 06:58:29'),
(18, 'Suki', 'Foreman', 'revapuny@mailinator.com', NULL, 'active', '$2y$10$PbyM7xpSdZIyg.BjMk5W1uDrO0FrGE6C8wR9EyZ8LLGithAlqxnpm', NULL, '2025-04-09 06:59:27', '2025-04-09 06:59:27'),
(19, 'Chastity', 'Mejia', 'tasywyby@mailinator.com', NULL, 'active', '$2y$10$0VIA30CBOyarJP2qM/e0v.nO3IMopJYo8PbA8Ic5Foeft/v5ZqP/2', NULL, '2025-04-09 07:16:16', '2025-04-09 07:16:16'),
(20, 'Hadley', 'Richard', 'miwufewuf@mailinator.com', NULL, 'active', '$2y$10$3dWOMUJ64KorEmnmxt8Suu5uPxw8ez8QjXmsJVf5jD4L.ZZe6Xxhe', NULL, '2025-04-09 07:18:28', '2025-04-09 07:18:28'),
(21, 'Fay', 'Thornton', 'recaq@mailinator.com', NULL, 'active', '$2y$10$o7xRV15tXAxgMGwUopNGT.Ovk8IX.v.diRTEt60XFXE0kOXG6oGiu', NULL, '2025-04-09 13:38:57', '2025-04-09 13:38:57'),
(22, 'Asher', 'Barrera', 'gywe@mailinator.com', NULL, 'active', '$2y$10$MpnoeLpICJJb9dOpnRGSJulJrUyZkbSzUailEl5ErD05fYZCZKY7.', NULL, '2025-04-09 13:43:30', '2025-04-09 13:43:30'),
(23, 'Reagan', 'Reynolds', 'tytahugace@mailinator.com', NULL, 'active', '$2y$10$F1vhTvUSNu3t14KhsN439ejVY5yOgMiOg8HmWoF5Wzd6jGPlI1SaC', NULL, '2025-04-13 18:24:44', '2025-04-13 18:24:44'),
(24, 'Breanna', 'Horton', 'qelamokek@mailinator.com', NULL, 'active', '$2y$10$mDW76MeE6.GALS/XGwQDluvQ5E4SZsVIcOnCcpYRucsjJdFIvY9xu', NULL, '2025-04-13 18:25:02', '2025-04-13 18:25:02'),
(25, 'Naomi', 'Slater', 'gefosure@mailinator.com', NULL, 'active', '$2y$10$KzLsHnPTm6.PvX5uJV/HI.EdFcQ3ExV/VSnbAv4lCaMS087rBKPE2', NULL, '2025-04-14 12:25:29', '2025-04-14 12:25:29'),
(26, 'Lamar', 'Wise', 'mywuqufoz@mailinator.com', NULL, 'active', '$2y$10$OpjO8ZMp7dGvVDkRdMfR0OCQf711ag2UOw29lB41n/Mlacos3Rya2', NULL, '2025-04-14 13:43:19', '2025-04-14 13:43:19'),
(27, 'Josephine', 'Sellers', 'liqyxuleba@mailinator.com', NULL, 'active', '$2y$10$ZDUr8WgB4sCFwMEyckMcJeyVsFjVIRws5X3yPzvMtELYLUb8TD.EO', NULL, '2025-04-22 08:24:22', '2025-04-22 08:24:22'),
(28, 'Rinah', 'Cruz', 'befo@mailinator.com', NULL, 'active', '$2y$10$QEjnXg3ofdGAk4ZTMZo.quMgTZalBKzkKJPNZlXy1hbN9e6V/SfLi', NULL, '2025-04-22 08:24:41', '2025-04-22 08:24:41'),
(29, 'Coby', 'Horne', 'hubipefeg@mailinator.com', NULL, 'active', '$2y$10$HTcr9ELXHKxtK2t6eTTP8epolzXh/zKTm1K5nZu4yChnmAmmUjb3u', NULL, '2025-04-22 08:24:54', '2025-04-22 08:24:54'),
(30, 'Bert', 'French', 'revazy@mailinator.com', NULL, 'active', '$2y$10$PfTnGPEyLHSglKbXQAoiL.cXCP7tlkcocXH7r32pYeqPRCNgzDImm', NULL, '2025-04-22 08:25:51', '2025-04-22 08:25:51'),
(31, 'Ariana', 'Soto', 'husipohad@mailinator.com', NULL, 'active', '$2y$10$C7muUxiig1KIFwdV9GIIv.MZB2iUcsVZyCfhlqyCm/OiZO5LQxdWi', NULL, '2025-04-22 08:26:08', '2025-04-22 08:26:08'),
(32, 'Kadeem', 'Rose', 'wyhe@mailinator.com', NULL, 'active', '$2y$10$pfwK2E7HABRfhKM36t9w4u5x9SOJSvi.eKXwBx7pM84Q3Ky6yMdIi', NULL, '2025-04-22 08:29:17', '2025-04-22 08:29:17'),
(33, 'Mira', 'Gregory', 'winyqepujy@mailinator.com', NULL, 'active', '$2y$10$blBR6DsvVoXg9UMR4rATQeNOp8ql60ozVoh4WGE5Y53opbcEX.NDW', NULL, '2025-04-22 08:41:25', '2025-04-22 08:41:25'),
(34, 'Rosalyn', 'Blackburn', 'bapa@mailinator.com', NULL, 'active', '$2y$10$MGPOaitHss4Q8ulQMsveOuVTRkxNQXODDmAMLUMayDSmogve3Xa6q', NULL, '2025-04-22 08:51:38', '2025-04-22 08:51:46'),
(35, 'Anne', 'Mckenzie', 'xaqamevuqe@mailinator.com', NULL, 'active', '$2y$10$Q4elCjWEDNg/FnUI.ZwUYu7KxvJi45abo/PEaRlkhA.I66Gy56Cea', NULL, '2025-04-22 10:51:46', '2025-04-22 10:51:46'),
(36, 'Christian', 'Simon', 'dowydet@mailinator.com', NULL, 'active', '$2y$10$QXpNmrJX8MBahwOiAWKWte.tb6bJnR8sqfH6iBItmj11tRrwOlYy6', NULL, '2025-04-22 10:53:10', '2025-04-22 10:53:21'),
(37, 'Rhonda', 'Mcdonald', 'tupef@mailinator.com', NULL, 'active', '$2y$10$OPOwWoe/5rBA4pr./8E2Z.qgwvp2rR.SVq9gD/sjiFsfWo/7mE5We', NULL, '2025-04-22 17:12:44', '2025-04-22 17:12:44'),
(38, 'Adrian', 'Bennett', 'laverybyq@mailinator.com', NULL, 'active', '$2y$10$yyVrCE/UovzeZRaHb4/ZH.G8Vt4LMVJD9djNE5IuuPZIBR3s9rBsm', NULL, '2025-04-22 17:14:43', '2025-04-22 17:14:43'),
(39, 'Vanna', 'Hale', 'texuhaqisa@mailinator.com', NULL, 'active', '$2y$10$SLUHvVz8oTzKKVxaFaB2PuD/6uVRV4vAfjczriQC3dRjSlBn9bV2S', NULL, '2025-04-23 07:29:21', '2025-04-23 07:29:21'),
(40, 'Oliver', 'Burnett', 'hudorelome@mailinator.com', NULL, 'active', '$2y$10$aUDHiUqITrV6NVsuCbrW4eioMrZoZlCluAuoICmTumF1lDNxmRr5C', NULL, '2025-04-23 07:32:10', '2025-04-23 07:32:18'),
(41, 'Laura', 'Rose', 'zofa@mailinator.com', NULL, 'active', '$2y$10$v9WKy9XFNOC8N0uOxjk73uNuM0q5cmbI/cv73t262k/1U2BcTA31S', NULL, '2025-04-24 15:57:55', '2025-04-24 15:57:55'),
(42, 'Iola', 'Blanchard', 'diquny@mailinator.com', NULL, 'active', '$2y$10$vbVPYplnW9ykvK8toc2i6OmlUgt3.qXeFBv1ZOLADwKyB.Kf4uH6a', NULL, '2025-04-24 16:01:00', '2025-04-24 16:01:10'),
(43, 'Chastity', 'Avila', 'xifodo@mailinator.com', NULL, 'active', '$2y$10$1qP0vVEeTc2Hatu3Lg5iNOKIIFwDi3F0ML8TcQiH0hcl1Ep2SEkFy', NULL, '2025-04-29 12:03:16', '2025-04-29 12:03:16'),
(44, 'Jamalia', 'Martinez', 'zykecu@mailinator.com', NULL, 'active', '$2y$10$awKOzL3oT/3FY3EN12BoPeUxj3UfBMo7o0O.BXe6AjWfd29MZAmkm', NULL, '2025-04-30 07:09:40', '2025-04-30 07:09:40'),
(45, 'Ramona', 'Paul', 'dagyr@mailinator.com', NULL, 'active', '$2y$10$f1p10BtjJnp6MJjzU/Kys.PHtCre6x.ZlJg0X6R1pJFCz.DSpYgGm', NULL, '2025-04-30 07:29:40', '2025-04-30 07:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `work_experiences`
--

DROP TABLE IF EXISTS `work_experiences`;
CREATE TABLE IF NOT EXISTS `work_experiences` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `artisan_profile_id` bigint UNSIGNED NOT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `work_experiences_artisan_profile_id_foreign` (`artisan_profile_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_experiences`
--

INSERT INTO `work_experiences` (`id`, `artisan_profile_id`, `position`, `company_name`, `start_date`, `end_date`, `is_current`, `description`, `created_at`, `updated_at`) VALUES
(1, 4, 'Holly Singleton', 'Hays Moran Trading', '2019-08-12', NULL, 1, 'Fugit consectetur d', '2025-04-03 19:56:29', '2025-04-03 19:56:29'),
(2, 9, 'Savannah Ortega', 'Bridges Pope Inc', '2014-01-01', NULL, 1, 'Exercitation eum et', '2025-04-09 07:00:59', '2025-04-09 07:00:59'),
(3, 15, 'Meredith Hansen', 'Saunders and Gilbert Co', '2016-03-05', NULL, 1, 'Dolorem sint culpa', '2025-04-22 08:42:15', '2025-04-22 08:42:15'),
(4, 19, 'Josiah Kramer', 'Kane and Boyle Plc', '1970-06-19', '1998-04-27', 0, 'Aliquid nesciunt po', '2025-04-22 10:52:25', '2025-04-22 10:52:25'),
(5, 20, 'Beverly Thompson', 'Velez Larson Co', '1975-03-07', NULL, 1, 'Quia Nam proident q', '2025-04-22 17:13:42', '2025-04-22 17:13:42'),
(6, 21, 'Isaiah Lynch', 'Evans and Hendricks Trading', '1997-03-19', NULL, 1, 'Animi provident el', '2025-04-23 07:30:53', '2025-04-23 07:30:53'),
(7, 22, 'Breanna Crosby', 'Rosario and Landry Inc', '2021-05-02', NULL, 1, 'Nihil est nulla opti', '2025-04-24 15:59:37', '2025-04-24 15:59:37');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
