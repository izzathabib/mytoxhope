-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table mytoxhope.company
CREATE TABLE IF NOT EXISTS `company` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `comp_reg_no` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comp_name` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comp_email` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comp_admin` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `KEY` (`user_id`),
  CONSTRAINT `FK_company_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mytoxhope.company: ~4 rows (approximately)
INSERT INTO `company` (`id`, `user_id`, `comp_reg_no`, `comp_name`, `comp_email`, `comp_admin`, `status`, `created_at`, `updated_at`) VALUES
	(1, 73, 'A-001', 'Satu Sdn Bhd', 'user@one.com', 'User One', 'verified', '2024-07-04 04:56:55', '2024-07-04 04:56:55'),
	(2, 75, 'PRN123', 'Pusat Racun Negara', 'admin@prn.com', 'Admin PRN', 'verified', '2024-07-05 08:50:52', '2024-07-05 08:50:52'),
	(3, 76, 'A-002', 'Dua Sdn Bhd', 'user@two.com', 'User Dua', 'verified', '2024-07-05 08:52:55', '2024-07-05 08:52:55'),
	(30, 112, 'A-003', 'Tiga Sdn Bhd', 'user@three.com', 'userthree', 'unverified', '2024-07-17 07:58:58', '2024-07-17 07:58:58');

-- Dumping structure for table mytoxhope.groups_users
CREATE TABLE IF NOT EXISTS `groups_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groups_users_user_id_foreign` (`user_id`),
  CONSTRAINT `groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mytoxhope.groups_users: ~4 rows (approximately)
INSERT INTO `groups_users` (`id`, `user_id`, `group`, `created_at`) VALUES
	(47, 73, 'admin', '2024-07-04 04:56:55'),
	(49, 75, 'superadmin', '2024-07-05 08:47:18'),
	(50, 76, 'admin', '2024-07-05 08:52:55'),
	(81, 112, 'admin', '2024-07-17 07:58:58');

-- Dumping structure for table mytoxhope.identities
CREATE TABLE IF NOT EXISTS `identities` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `secret` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `secret2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text COLLATE utf8mb4_general_ci,
  `force_reset` tinyint(1) NOT NULL DEFAULT '0',
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_secret` (`type`,`secret`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mytoxhope.identities: ~4 rows (approximately)
INSERT INTO `identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
	(47, 73, 'email_password', NULL, 'user@one.com', '$2y$12$JVRQBckOti1cORe7t1eXIO5pC/hb84t/JRMAWVYtHrgZKYrX5SK7O', NULL, NULL, 0, '2024-07-17 03:59:03', '2024-07-04 04:56:54', '2024-07-17 03:59:03'),
	(49, 75, 'email_password', NULL, 'admin@prn.com', '$2y$12$fJI1qRk14/ezpamSlD11Q.fI6o96ZAhaCTZa6pHUFHi53SJY681X2', NULL, NULL, 0, '2024-07-17 08:02:37', '2024-07-05 08:47:18', '2024-07-17 08:02:37'),
	(50, 76, 'email_password', NULL, 'user@two.com', '$2y$12$6ZUAupYw8GOoa1TjyEfIn.rjmb/WcEbMkv/g6nN2JnvN3412QjJqS', NULL, NULL, 0, '2024-07-17 04:34:42', '2024-07-05 08:52:54', '2024-07-17 04:34:42'),
	(79, 112, 'email_password', NULL, 'user@three.com', '$2y$12$fdYTXyb79FXQ26kNbdb6nuY5eFWe2L79c8s9/6z2OBID5y/LnIbVW', NULL, NULL, 0, NULL, '2024-07-17 07:58:57', '2024-07-17 07:58:57');

-- Dumping structure for table mytoxhope.logins
CREATE TABLE IF NOT EXISTS `logins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_type_identifier` (`id_type`,`identifier`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mytoxhope.logins: ~63 rows (approximately)
INSERT INTO `logins` (`id`, `ip_address`, `user_agent`, `id_type`, `identifier`, `user_id`, `date`, `success`) VALUES
	(17, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', 33, '2024-06-21 08:22:52', 1),
	(18, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 24, '2024-06-21 08:45:52', 1),
	(19, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', NULL, '2024-06-25 02:12:48', 0),
	(20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', NULL, '2024-06-25 02:13:02', 0),
	(21, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', 33, '2024-06-25 02:14:15', 1),
	(22, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 24, '2024-06-25 04:06:11', 1),
	(23, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', 33, '2024-06-25 04:06:41', 1),
	(24, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', 33, '2024-06-26 02:31:24', 1),
	(25, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 48, '2024-07-01 06:52:18', 1),
	(26, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 48, '2024-07-01 07:02:35', 1),
	(27, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@three.com', 70, '2024-07-02 08:19:03', 1),
	(28, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 71, '2024-07-02 08:45:45', 1),
	(29, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-04 05:02:12', 1),
	(30, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-04 07:13:24', 1),
	(31, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-04 07:22:12', 1),
	(32, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-04 08:21:46', 1),
	(33, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 74, '2024-07-05 01:26:17', 1),
	(34, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-05 07:35:27', 1),
	(35, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-05 08:51:50', 1),
	(36, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-09 02:21:07', 1),
	(37, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-09 03:26:09', 1),
	(38, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-09 06:05:17', 1),
	(39, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-09 08:16:01', 1),
	(40, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-10 01:26:48', 1),
	(41, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-10 02:37:25', 1),
	(42, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-10 03:02:53', 1),
	(43, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@three.com', 107, '2024-07-10 07:59:45', 1),
	(44, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-10 08:00:25', 1),
	(45, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-10 08:01:02', 1),
	(46, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-10 08:06:38', 1),
	(47, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-10 08:07:09', 1),
	(48, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-11 02:49:07', 1),
	(49, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-11 03:12:52', 1),
	(50, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-12 03:11:23', 1),
	(51, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-12 07:41:28', 1),
	(52, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-12 07:45:10', 1),
	(53, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-12 07:46:44', 1),
	(54, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-13 04:21:44', 1),
	(55, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-15 01:17:01', 1),
	(56, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-15 02:28:18', 1),
	(57, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@three.com', 107, '2024-07-15 08:03:56', 1),
	(58, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-15 08:21:13', 1),
	(59, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', NULL, '2024-07-16 01:01:26', 0),
	(60, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-16 01:01:36', 1),
	(61, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-16 02:23:17', 1),
	(62, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-16 02:53:24', 1),
	(63, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-16 03:04:31', 1),
	(64, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-16 03:04:56', 1),
	(65, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-16 04:50:12', 1),
	(66, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-16 06:36:51', 1),
	(67, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@three.com', 107, '2024-07-16 06:48:12', 1),
	(68, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-16 06:54:33', 1),
	(69, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', NULL, '2024-07-16 08:01:48', 0),
	(70, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-16 08:01:57', 1),
	(71, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-16 08:36:36', 1),
	(72, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-16 08:51:21', 1),
	(73, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-17 02:46:25', 1),
	(74, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 73, '2024-07-17 03:59:03', 1),
	(75, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-17 03:59:31', 1),
	(76, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', NULL, '2024-07-17 04:18:12', 0),
	(77, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-17 04:18:23', 1),
	(78, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'user@two.com', 76, '2024-07-17 04:34:42', 1),
	(79, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'email_password', 'admin@prn.com', 75, '2024-07-17 08:02:37', 1);

-- Dumping structure for table mytoxhope.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mytoxhope.migrations: ~4 rows (approximately)
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '2020-12-28-223112', 'CodeIgniter\\Shield\\Database\\Migrations\\CreateAuthTables', 'default', 'CodeIgniter\\Shield', 1717748291, 1),
	(2, '2021-07-04-041948', 'CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable', 'default', 'CodeIgniter\\Settings', 1717748291, 1),
	(3, '2021-11-14-143905', 'CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn', 'default', 'CodeIgniter\\Settings', 1717748291, 1),
	(4, '2024-06-11-062833', 'App\\Database\\Migrations\\AddCompRegNoToUsersTable', 'default', 'App', 1718087919, 2);

-- Dumping structure for table mytoxhope.permissions_users
CREATE TABLE IF NOT EXISTS `permissions_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_users_user_id_foreign` (`user_id`),
  CONSTRAINT `permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mytoxhope.permissions_users: ~0 rows (approximately)

-- Dumping structure for table mytoxhope.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `product_image` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type_poison` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `active_ing` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `inactive_ing` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `brand_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `msds` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `subtype_household` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `prod_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mytoxhope.products: ~1 rows (approximately)
INSERT INTO `products` (`id`, `user_id`, `product_name`, `product_image`, `type_poison`, `active_ing`, `inactive_ing`, `brand_name`, `msds`, `subtype_household`, `prod_status`, `created_at`, `updated_at`) VALUES
	(31, 73, 'DISH DROPS Concentrated Dishwashing Liquid - 1L', 'DD_110488_1_CF_img_Product_588Wx588H.jpeg', 'List 2', '["Kalium"]', 'Aloe Vera and Shiso Extracts', 'Amway', 'MSDS.pdf', 'household', 'Discontinued', '2024-07-11 04:26:04', '2024-07-14 23:29:25');

-- Dumping structure for table mytoxhope.remember_tokens
CREATE TABLE IF NOT EXISTS `remember_tokens` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `selector` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hashedValidator` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `remember_tokens_user_id_foreign` (`user_id`),
  CONSTRAINT `remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mytoxhope.remember_tokens: ~0 rows (approximately)

-- Dumping structure for table mytoxhope.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `value` text COLLATE utf8mb4_general_ci,
  `type` varchar(31) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'string',
  `context` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mytoxhope.settings: ~0 rows (approximately)

-- Dumping structure for table mytoxhope.token_logins
CREATE TABLE IF NOT EXISTS `token_logins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_type_identifier` (`id_type`,`identifier`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mytoxhope.token_logins: ~0 rows (approximately)

-- Dumping structure for table mytoxhope.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comp_reg_no` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comp_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_message` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `UNIQUE` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mytoxhope.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `username`, `comp_reg_no`, `comp_name`, `status`, `status_message`, `active`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(73, 'User One', 'A-001', 'Satu Sdn Bhd', 'verified', NULL, 1, NULL, '2024-07-04 04:56:54', '2024-07-04 04:56:55', NULL),
	(75, 'Admin PRN', 'PRN123', 'Pusat Racun Negara', 'verified', NULL, 1, NULL, '2024-07-05 08:47:17', '2024-07-05 08:47:18', NULL),
	(76, 'User Dua', 'A-002', 'Dua Sdn Bhd', 'verified', NULL, 1, NULL, '2024-07-05 08:52:54', '2024-07-17 04:30:07', NULL),
	(112, 'userthree', 'A-003', 'Tiga Sdn Bhd', 'unverified', NULL, 1, NULL, '2024-07-17 07:58:57', '2024-07-17 07:58:58', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
