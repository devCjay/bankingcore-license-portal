-- BankCore License Portal MySQL export
-- Source: database/database.sqlite
-- Generated: 2026-08-16 13:30:41 UTC
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `license_verifications`;
DROP TABLE IF EXISTS `licenses`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `migrations`;

--
-- Table structure for `migrations`
--
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Data for `migrations`
--
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2026_08_15_000000_create_licenses_table', '2');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_08_15_000001_create_license_verifications_table', '2');

--
-- Table structure for `users`
--
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for `password_reset_tokens`
--
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for `sessions`
--
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for `cache`
--
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for `cache_locks`
--
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for `jobs`
--
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for `job_batches`
--
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for `failed_jobs`
--
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`(191), `queue`(191), `failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for `licenses`
--
CREATE TABLE `licenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `license_key` varchar(255) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL DEFAULT 'BankCore',
  `domain` varchar(255) DEFAULT NULL,
  `allowed_domains` json DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `max_activations` int unsigned NOT NULL DEFAULT '1',
  `activation_count` int unsigned NOT NULL DEFAULT '0',
  `expires_at` timestamp NULL DEFAULT NULL,
  `last_verified_at` timestamp NULL DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `licenses_license_key_unique` (`license_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for `license_verifications`
--
CREATE TABLE `license_verifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `license_id` bigint unsigned DEFAULT NULL,
  `license_key` varchar(255) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `payload` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `license_verifications_license_id_foreign` (`license_id`),
  CONSTRAINT `license_verifications_license_id_foreign` FOREIGN KEY (`license_id`) REFERENCES `licenses` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Data for `license_verifications`
--
INSERT INTO `license_verifications` (`id`, `license_id`, `license_key`, `domain`, `email`, `ip_address`, `status`, `message`, `payload`, `created_at`, `updated_at`) VALUES ('1', NULL, 'BAD-KEY', 'example.com', NULL, '127.0.0.1', 'invalid', 'License key was not found.', '{"license_key":"BAD-KEY","domain":"example.com"}', '2026-08-15 23:02:31', '2026-08-15 23:02:31');
INSERT INTO `license_verifications` (`id`, `license_id`, `license_key`, `domain`, `email`, `ip_address`, `status`, `message`, `payload`, `created_at`, `updated_at`) VALUES ('2', NULL, 'BANK-TEST-VERIFY-0001', 'bank.example.com', 'test@example.com', '127.0.0.1', 'invalid', 'License key was not found.', '{"license_key":"BANK-TEST-VERIFY-0001","domain":"bank.example.com","email":"test@example.com","product":"BankCore"}', '2026-08-15 23:02:56', '2026-08-15 23:02:56');
INSERT INTO `license_verifications` (`id`, `license_id`, `license_key`, `domain`, `email`, `ip_address`, `status`, `message`, `payload`, `created_at`, `updated_at`) VALUES ('3', NULL, 'BANK-TEST-VERIFY-0001', 'bank.example.com', 'test@example.com', '127.0.0.1', 'invalid', 'License key was not found.', '{"license_key":"BANK-TEST-VERIFY-0001","domain":"bank.example.com","email":"test@example.com","product":"BankCore"}', '2026-08-15 23:03:16', '2026-08-15 23:03:16');
INSERT INTO `license_verifications` (`id`, `license_id`, `license_key`, `domain`, `email`, `ip_address`, `status`, `message`, `payload`, `created_at`, `updated_at`) VALUES ('4', NULL, 'BANK-TEST-VERIFY-0001', 'bank.example.com', 'test@example.com', '127.0.0.1', 'invalid', 'License key was not found.', '{"license_key":"BANK-TEST-VERIFY-0001","domain":"bank.example.com","email":"test@example.com","product":"BankCore"}', '2026-08-15 23:03:35', '2026-08-15 23:03:35');

SET FOREIGN_KEY_CHECKS = 1;
