-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 22, 2023 at 07:22 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app-product`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', NULL, NULL),
(2, 'Books', NULL, NULL),
(3, 'Clothing', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_03_21_033040_create_categories_table', 1),
(3, '2023_03_21_033108_create_products_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_image` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_slug`, `product_image`, `category_id`, `created_at`, `updated_at`) VALUES
(3, 'The Great Gatsby', NULL, '../uploads/95250405_915537415573541_3800027161868369920_n.jpg', 2, NULL, NULL),
(4, ' Kill a Mockingbird', NULL, '../uploads/95250405_915537415573541_3800027161868369920_n.jpg', 1, '2023-03-21 23:21:34', NULL),
(5, 'T-shirt', NULL, '../uploads/95250405_915537415573541_3800027161868369920_n.jpg', 3, NULL, NULL),
(6, 'Jeans', NULL, '../uploads/95250405_915537415573541_3800027161868369920_n.jpg', 3, NULL, NULL),
(80, 'Bảo hiểm', NULL, 'http://localhost/Products/uploads/95250405_915537415573541_3800027161868369920_n.jpg', 1, NULL, NULL),
(81, 'Bảo hiểm nhân thọ', NULL, NULL, 1, NULL, NULL),
(83, 'Bảo hiểm phi nhân thọ', NULL, NULL, 1, NULL, NULL),
(88, 'Nước bí đao', NULL, '306084344_1554813911645885_7854597132863210594_n.jpg', 2, '2023-03-21 23:21:53', NULL),
(95, 'Apple iPhone 13', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-21 23:25:46', NULL),
(96, 'Samsung Galaxy S21', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-21 23:25:59', NULL),
(97, 'Sony PlayStation 5', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-21 23:26:09', NULL),
(98, 'Xbox Series X', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-21 23:26:19', NULL),
(99, 'Nintendo Switch OLED', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-21 23:26:30', NULL),
(100, 'HP Spectre x360', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-21 23:26:41', NULL),
(101, 'Dell XPS 13', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-21 23:26:52', NULL),
(102, 'Lenovo Yoga C940', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-21 23:27:01', NULL),
(103, 'Logitech G Pro Wireless Gaming Mouse', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-21 23:27:12', NULL),
(104, 'Bose QuietComfort 35 II Wireless Headphones', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-21 23:27:24', NULL),
(105, 'Philips Hue A19 Smart LED Bulb', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-21 23:27:35', NULL),
(106, 'Nest Learning', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 2, '2023-03-21 23:40:12', NULL),
(107, 'Ring Video Doorbell 4', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-21 23:27:54', NULL),
(108, 'Arlo Pro 5 Security', NULL, 'http://localhost/Products/uploads/288375674_1479372652523345_5089503766807067226_n.jpg', 1, '2023-03-22 00:11:01', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
