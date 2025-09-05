-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2025 at 08:40 AM
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
-- Database: `symmetrichub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `phone`, `password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', '1213131312', '$2y$12$mqoYEEE6Q4zJTEo1zy/THeVL8sWEcUkCWEWs8yayM9wbpmOrZIFai', NULL, NULL, '2025-08-05 11:43:07', '2025-08-16 03:54:49');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Zumba', 1, '2025-08-13 00:10:24', '2025-08-14 04:37:44'),
(2, 'FreeStyle', 1, '2025-08-13 04:27:02', '2025-08-13 04:27:02'),
(3, 'Hiphop', 1, '2025-08-14 04:16:24', '2025-08-14 04:16:24'),
(4, 'Classical', 1, '2025-08-14 04:36:55', '2025-08-14 04:36:55'),
(5, 'dsd', 1, '2025-08-29 07:30:36', '2025-08-29 07:30:36');

-- --------------------------------------------------------

--
-- Table structure for table `courses_prices`
--

CREATE TABLE `courses_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `duration` int(11) DEFAULT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'INR',
  `discount` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses_prices`
--

INSERT INTO `courses_prices` (`id`, `course_id`, `price`, `duration`, `currency`, `discount`, `created_at`, `updated_at`) VALUES
(1, 1, 2000.00, 3, 'INR', NULL, '2025-08-13 00:10:24', '2025-08-13 00:10:24'),
(2, 1, 5500.00, 6, 'INR', NULL, '2025-08-13 00:10:24', '2025-08-13 00:10:24'),
(3, 2, 700.00, 1, 'INR', NULL, '2025-08-13 04:27:02', '2025-08-13 04:27:02'),
(4, 2, 1200.00, 3, 'INR', NULL, '2025-08-13 04:27:02', '2025-08-13 04:27:02'),
(5, 2, 1600.00, 6, 'INR', NULL, '2025-08-13 04:27:02', '2025-08-13 04:27:02'),
(6, 2, 2300.00, 9, 'INR', NULL, '2025-08-13 04:27:02', '2025-08-13 04:27:02'),
(7, 3, 700.00, 1, 'INR', NULL, '2025-08-14 04:16:24', '2025-08-14 04:16:24'),
(8, 3, 1500.00, 2, 'INR', NULL, '2025-08-14 04:16:24', '2025-08-14 04:16:24'),
(9, 3, 2000.00, 4, 'INR', NULL, '2025-08-14 04:16:24', '2025-08-14 04:16:24'),
(10, 4, 2000.00, 3, 'INR', NULL, '2025-08-14 04:36:55', '2025-08-14 04:36:55'),
(11, 4, 4000.00, 6, 'INR', NULL, '2025-08-14 04:36:55', '2025-08-14 04:36:55'),
(12, 4, 6000.00, 9, 'INR', NULL, '2025-08-14 04:36:55', '2025-08-14 04:36:55'),
(13, 4, 8000.00, 12, 'INR', NULL, '2025-08-14 04:36:55', '2025-08-14 04:36:55'),
(15, 5, 7000.00, 8, 'INR', NULL, '2025-08-29 07:30:36', '2025-08-29 07:30:36'),
(16, 5, 9000.00, 9, 'INR', NULL, '2025-08-29 07:30:36', '2025-08-29 07:30:36'),
(17, 5, 13000.00, 11, 'INR', NULL, '2025-08-29 07:30:36', '2025-08-29 07:30:36');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `discount_duration_day` int(22) NOT NULL,
  `discount_date` date DEFAULT NULL,
  `coupon_number` varchar(255) NOT NULL,
  `percentage` tinyint(3) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `title`, `discount_duration_day`, `discount_date`, `coupon_number`, `percentage`, `description`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Summer', 15, '2025-09-02', 'summer8114', 25, 'Test', 1, '2025-09-02 07:49:18', '2025-09-03 08:16:44');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(22) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `name`, `email`, `phone`, `message`, `created_at`, `updated_at`) VALUES
(3, 'monika', 'mona@gmail.com', '7999753062', 'hello', '2025-08-14 09:58:05', '2025-08-14 09:58:05'),
(4, 'Sumit Singh', 'sumit@yopmail.com', '1213131312', 'Test', '2025-08-16 05:43:21', '2025-08-16 05:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_05_072841_create_users_table', 2),
(5, '2025_08_05_073558_create_plans_table', 3),
(6, '2025_08_05_073832_create_admins_table', 4),
(7, '2025_08_06_065708_create_products_table', 5),
(8, '2025_08_06_151356_create_product_prices_table', 6),
(9, '2025_08_06_152235_add_column_name_to_product_prices_table', 7),
(10, '2025_08_06_152805_add_column_name_to_product_prices_table', 8),
(11, '2025_08_06_153024_add_column_name_to_product_prices_table', 9),
(12, '2025_08_06_153208_add_column_name_to_product_prices_table', 10),
(13, '2025_08_07_053426_create_courses_table', 11),
(14, '2025_08_07_053655_create_courses_prices_table', 12),
(15, '2025_08_07_055627_add_column_name_to_courses_prices_table', 13),
(16, '2025_08_07_055556_add_column_name_to_courses_table', 14),
(17, '2025_08_30_104213_create_offers_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `referred_by` varchar(255) NOT NULL,
  `course_id` int(22) NOT NULL,
  `valid` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `user_id`, `referred_by`, `course_id`, `valid`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'self', 3, 4, 1500.00, 1, '2025-09-02 12:27:18', '2025-09-02 12:28:44'),
(2, 2, 'YIGCJQ-1', 3, 2, 1125.00, 1, '2025-09-02 12:39:14', '2025-09-02 14:13:07'),
(3, 3, 'self', 3, 2, 1500.00, 0, '2025-09-04 10:47:06', '2025-09-04 10:47:06'),
(4, 4, 'self', 2, 6, 1600.00, 0, '2025-09-04 11:02:23', '2025-09-04 11:02:23'),
(5, 5, 'self', 2, 3, 1200.00, 0, '2025-09-04 11:12:24', '2025-09-04 11:12:58'),
(6, 6, 'self', 2, 3, 1200.00, 0, '2025-09-05 05:09:52', '2025-09-05 05:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('m7Oa9uV75vAQJJZmsqveDWRCEfvmTB7PhbKvYmpV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoickJCajdad2FmNWdYNmxwSFJZOTJaUDJhdTlrc21ScGtzV01JVlZ6ZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2VyL2Rhc2hib2FyZCI7fX0=', 1754386319),
('NKDKU9m8blGb6LKhITDaVLBQpY1favlgZlQckFmc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibldZSVRtN0puRVQzVXpQWGE5TGNQcGJoWjlqZ09xa0JmRDVRMVd1SCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1754383841);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `discount_id` int(22) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `referral_id` varchar(100) DEFAULT NULL,
  `wallet` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `discount_id`, `name`, `email`, `phone`, `gender`, `referral_id`, `wallet`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 2, 'Sumit', 'sumit@yopmail.com', '1213131312', 'male', 'YIGCJQ-1', '20', 1, NULL, '$2y$12$WrvJlmlNwaHmv8D2noKrG.wo5rg6zZqG9q/zywdcoTXzz7fzBAVFy', NULL, '2025-09-02 06:57:18', '2025-09-02 08:43:07'),
(2, 2, 'Mayank', 'mayank@yopmail.com', '8888888888', 'male', 'ZAAYXY-2', '0', 0, NULL, '$2y$12$9s4svUOUwNd8pO.d8odMMOqaUFv1c7F.MsAYj3LcJgQF3eLBiwuO.', NULL, '2025-09-02 07:09:14', '2025-09-02 07:09:14'),
(3, 0, 'Sarika', 'sarika@yopmail.com', '1213131312', 'female', 'WL0OEO-3', '0', 0, NULL, '$2y$12$QRiwwnuESNxPLhpJp2Scpe6vytGUjerFZKS4peb5luQUNJRWx/hR6', NULL, '2025-09-04 05:17:06', '2025-09-04 05:17:06'),
(4, 0, 'Rajesh', 'rajesh23@yopmail.com', '1213131312', 'male', 'ZVV7KT-4', '0', 1, NULL, '$2y$12$8F9Wp188F3bfMlbUG5oVledDghT0yW12/JTRAM.OTOECDy/hdxQrq', NULL, '2025-09-04 05:32:23', '2025-09-04 05:32:23'),
(5, 0, 'Honey', 'honey@yopamail.com', '1213131312', 'male', 'QP8WE8-5', '0', 0, NULL, '$2y$12$3TzthXDePaaDddn61sFGqOhkZoHI5kt.QyEGgpc4Eyk2FgCrWRL4K', NULL, '2025-09-04 05:42:24', '2025-09-04 05:42:24'),
(6, 0, 'Divya', 'divya@yopmail.com', '1213131312', 'female', 'BILAKX-6', '0', 1, NULL, '$2y$12$65/cRfuBJmUYK92rqSTyA.U.CLmG8bxapgRMDMZpfJuLeMSL6KErK', NULL, '2025-09-04 23:39:52', '2025-09-04 23:41:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses_prices`
--
ALTER TABLE `courses_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `courses_prices`
--
ALTER TABLE `courses_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
