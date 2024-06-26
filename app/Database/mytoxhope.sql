-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2024 at 06:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mytoxhope`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(10) NOT NULL,
  `registration_no` varchar(250) NOT NULL,
  `company_name` varchar(400) NOT NULL,
  `full_name` varchar(400) NOT NULL,
  `email` varchar(400) NOT NULL,
  `password` varchar(400) NOT NULL,
  `repeat_password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `registration_no`, `company_name`, `full_name`, `email`, `password`, `repeat_password`, `created_at`, `updated_at`) VALUES
(1, 'A-12345', 'Unilever (Malaysia) Holdings Sdn. Bhd.', 'John Doe', 'john@doe.com', '$2y$10$hf7xPcNGgT0ePiogWq2qF.RL9tH9Six.8gmZyk4xHpPB73grmsFRS', '$2y$10$R9iwuiJzPRU14qcA0rFOoOLHSwIc2Ufw0SrgfyvupJm0wB1D2eW72', '2024-06-06 03:51:30', '2024-06-06 03:51:30');

-- --------------------------------------------------------

--
-- Table structure for table `groups_users`
--

CREATE TABLE `groups_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups_users`
--

INSERT INTO `groups_users` (`id`, `user_id`, `group`, `created_at`) VALUES
(9, 24, 'user', '2024-06-11 08:11:40'),
(10, 25, 'user', '2024-06-11 08:13:07'),
(11, 26, 'user', '2024-06-12 03:28:05'),
(16, 31, 'user', '2024-06-20 08:28:50'),
(17, 32, 'user', '2024-06-20 08:31:49'),
(18, 33, 'superadmin', '2024-06-21 06:17:17'),
(19, 33, 'admin', '2024-06-21 06:17:17');

-- --------------------------------------------------------

--
-- Table structure for table `identities`
--

CREATE TABLE `identities` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `secret` varchar(255) NOT NULL,
  `secret2` varchar(255) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text DEFAULT NULL,
  `force_reset` tinyint(1) NOT NULL DEFAULT 0,
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `identities`
--

INSERT INTO `identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
(9, 24, 'email_password', NULL, 'user@one.com', '$2y$12$LlUTiITVAYrw4Ra//xeqTOfH/abiPlYfO3lLsuYpvlaIvS9MbE2v6', NULL, NULL, 0, '2024-06-25 04:06:11', '2024-06-11 08:11:40', '2024-06-25 04:06:11'),
(10, 25, 'email_password', NULL, 'user@two.com', '$2y$12$y4QdhZctvdburrRN1EGr2eM2d2cqNCKydmpty0uqEqkWHsfTP2blq', NULL, NULL, 0, '2024-06-19 02:51:00', '2024-06-11 08:13:07', '2024-06-19 02:51:00'),
(11, 26, 'email_password', NULL, 'user@three.com', '$2y$12$eKYB9My0zudDLxBF5LGk/udGffRuMFYovGxy7/xuNa964qsQfpkxu', NULL, NULL, 0, '2024-06-13 07:43:43', '2024-06-12 03:28:04', '2024-06-13 07:43:43'),
(16, 31, 'email_password', NULL, 'user@four.com', '$2y$12$Bq023K/V8L0hAxYLBSOIIOQCuejNsDyG5r3w4A9pZ5w.l9oY5mbJu', NULL, NULL, 0, NULL, '2024-06-20 08:28:50', '2024-06-20 08:28:50'),
(17, 32, 'email_password', NULL, 'user@five.com', '$2y$12$GydbvuFi0V1XzeI00cbES.hpek0PIgA9fq7tR2yqbIaAOzmFm3/Pe', NULL, NULL, 0, NULL, '2024-06-20 08:31:49', '2024-06-20 08:31:49'),
(18, 33, 'email_password', NULL, 'admin@example.com', '$2y$12$GYmKppZNsrOvyiNLJn0aqePxQJdG0A5IndffGUQ7J1aWShH5iQX6W', NULL, NULL, 0, '2024-06-25 04:06:41', '2024-06-21 06:17:16', '2024-06-25 04:06:41');

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`id`, `ip_address`, `user_agent`, `id_type`, `identifier`, `user_id`, `date`, `success`) VALUES
(17, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', 33, '2024-06-21 08:22:52', 1),
(18, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 24, '2024-06-21 08:45:52', 1),
(19, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', NULL, '2024-06-25 02:12:48', 0),
(20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', NULL, '2024-06-25 02:13:02', 0),
(21, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', 33, '2024-06-25 02:14:15', 1),
(22, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'user@one.com', 24, '2024-06-25 04:06:11', 1),
(23, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', 33, '2024-06-25 04:06:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2020-12-28-223112', 'CodeIgniter\\Shield\\Database\\Migrations\\CreateAuthTables', 'default', 'CodeIgniter\\Shield', 1717748291, 1),
(2, '2021-07-04-041948', 'CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable', 'default', 'CodeIgniter\\Settings', 1717748291, 1),
(3, '2021-11-14-143905', 'CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn', 'default', 'CodeIgniter\\Settings', 1717748291, 1),
(4, '2024-06-11-062833', 'App\\Database\\Migrations\\AddCompRegNoToUsersTable', 'default', 'App', 1718087919, 2);

-- --------------------------------------------------------

--
-- Table structure for table `permissions_users`
--

CREATE TABLE `permissions_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `permission` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `product_image` varchar(250) NOT NULL,
  `type_poison` varchar(250) NOT NULL,
  `active_ing` varchar(250) NOT NULL,
  `inactive_ing` varchar(250) NOT NULL,
  `brand_name` varchar(250) NOT NULL,
  `msds` varchar(250) NOT NULL,
  `subtype_household` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `product_name`, `product_image`, `type_poison`, `active_ing`, `inactive_ing`, `brand_name`, `msds`, `subtype_household`, `created_at`, `updated_at`) VALUES
(6, 25, 'Pencuci Pinggan', 'O9TXYT0.jpg', 'List 2', 'Bahan aktif', '          Bahan tidak aktif', 'Sunlight', 'O9TXYT0.jpg', 'List 2', '2024-06-19 03:00:26', '2024-06-19 03:00:26');

-- --------------------------------------------------------

--
-- Table structure for table `remember_tokens`
--

CREATE TABLE `remember_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(9) NOT NULL,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(31) NOT NULL DEFAULT 'string',
  `context` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token_logins`
--

CREATE TABLE `token_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `comp_reg_no` varchar(64) NOT NULL,
  `comp_name` varchar(200) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `status`, `status_message`, `active`, `last_active`, `created_at`, `updated_at`, `deleted_at`, `comp_reg_no`, `comp_name`, `name`) VALUES
(24, NULL, NULL, 1, NULL, '2024-06-11 08:11:40', '2024-06-11 08:11:40', NULL, 'A-001', 'Satu Sdn Bhd', 'userone'),
(25, NULL, NULL, 1, NULL, '2024-06-11 08:13:07', '2024-06-11 08:13:07', NULL, 'A-002', 'Dua Sdn Bhd', 'usertwo'),
(26, NULL, NULL, 1, NULL, '2024-06-12 03:28:03', '2024-06-12 03:28:05', NULL, 'A-003', 'Tiga Sdn Bhd', 'userthree'),
(31, NULL, NULL, 1, NULL, '2024-06-20 08:28:50', '2024-06-20 08:28:50', NULL, 'A-004', 'Empat Sdn Bhd', 'userfour'),
(32, NULL, NULL, 1, NULL, '2024-06-20 08:31:48', '2024-06-20 08:31:49', NULL, 'A-005', 'Lima Sdn Bhd', 'userfive'),
(33, NULL, NULL, 1, NULL, '2024-06-21 06:17:15', '2024-06-21 06:17:17', NULL, 'A-006', 'Enam Sdn Bhd', 'adminone');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups_users`
--
ALTER TABLE `groups_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `identities`
--
ALTER TABLE `identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_secret` (`type`,`secret`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions_users`
--
ALTER TABLE `permissions_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `remember_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `token_logins`
--
ALTER TABLE `token_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups_users`
--
ALTER TABLE `groups_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `identities`
--
ALTER TABLE `identities`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions_users`
--
ALTER TABLE `permissions_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `token_logins`
--
ALTER TABLE `token_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groups_users`
--
ALTER TABLE `groups_users`
  ADD CONSTRAINT `groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `identities`
--
ALTER TABLE `identities`
  ADD CONSTRAINT `identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions_users`
--
ALTER TABLE `permissions_users`
  ADD CONSTRAINT `permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD CONSTRAINT `remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
