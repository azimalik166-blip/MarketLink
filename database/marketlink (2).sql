-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2026 at 12:26 PM
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
-- Database: `marketlink`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(80) NOT NULL,
  `description` varchar(500) NOT NULL,
  `entity_type` varchar(255) DEFAULT NULL,
  `entity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `entity_type`, `entity_id`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 2, 'product.updated', 'Updated product Fresh Tomatoes', 'Product', 1, '127.0.0.1', '2026-09-26 12:52:59', '2026-09-26 12:52:59'),
(2, 2, 'product.updated', 'Updated product Fresh Tomatoes', 'Product', 1, '127.0.0.1', '2026-09-26 13:28:37', '2026-09-26 13:28:37'),
(3, 2, 'product.updated', 'Updated product Seasonal Mangoes', 'Product', 3, '127.0.0.1', '2026-09-26 16:07:56', '2026-09-26 16:07:56'),
(4, 2, 'product.updated', 'Updated product Fresh Tomatoes', 'Product', 1, '127.0.0.1', '2026-09-26 16:18:47', '2026-09-26 16:18:47'),
(5, 2, 'product.updated', 'Updated product Fresh Tomatoes', 'Product', 1, '127.0.0.1', '2026-09-26 16:20:17', '2026-09-26 16:20:17'),
(6, 2, 'product.updated', 'Updated product Fresh Tomatoes', 'Product', 1, '127.0.0.1', '2026-09-26 16:20:29', '2026-09-26 16:20:29'),
(7, 2, 'product.updated', 'Updated product Fresh Tomatoes', 'Product', 1, '127.0.0.1', '2026-09-26 16:20:38', '2026-09-26 16:20:38'),
(8, 2, 'product.deleted', 'Removed product Fresh Tomatoes', 'Product', 1, '127.0.0.1', '2026-09-26 16:21:18', '2026-09-26 16:21:18'),
(9, 2, 'product.created', 'Added product Fresh Tomatoes', 'Product', 7, '127.0.0.1', '2026-09-26 16:21:40', '2026-09-26 16:21:40'),
(10, 2, 'product.created', 'Added product aalu', 'Product', 8, '127.0.0.1', '2026-09-26 17:15:41', '2026-09-26 17:15:41'),
(11, 2, 'product.deleted', 'Removed product aalu', 'Product', 8, '127.0.0.1', '2026-09-26 17:16:06', '2026-09-26 17:16:06'),
(12, 2, 'order.status', 'Farmer moved order ML-260926091100-5ZFZ to accepted', 'Order', 10, '127.0.0.1', '2026-09-26 17:26:12', '2026-09-26 17:26:12'),
(13, 2, 'order.status', 'Farmer moved order ML-260926091100-5ZFZ to ready', 'Order', 10, '127.0.0.1', '2026-09-26 18:06:26', '2026-09-26 18:06:26'),
(14, 2, 'order.status', 'Farmer moved order ML-260926091100-5ZFZ to completed', 'Order', 10, '127.0.0.1', '2026-09-26 18:06:33', '2026-09-26 18:06:33'),
(15, 2, 'product.updated', 'Updated product Seasonal Mangoes', 'Product', 3, '127.0.0.1', '2026-09-26 19:47:00', '2026-09-26 19:47:00'),
(16, 3, 'order.cancelled', 'Customer cancelled order ML-260927084818-S5F6', 'Order', 11, '127.0.0.1', '2026-09-27 15:48:29', '2026-09-27 15:48:29'),
(17, 3, 'order.cancelled', 'Customer cancelled order ML-260927084818-JXLL', 'Order', 12, '127.0.0.1', '2026-09-27 15:48:32', '2026-09-27 15:48:32'),
(18, 3, 'order.cancelled', 'Customer cancelled order ML-260927090719-MGLC', 'Order', 13, '127.0.0.1', '2026-09-27 16:07:27', '2026-09-27 16:07:27'),
(19, 3, 'order.cancelled', 'Customer cancelled order ML-260927090719-1KNR', 'Order', 14, '127.0.0.1', '2026-09-27 16:07:38', '2026-09-27 16:07:38'),
(20, 3, 'order.cancelled', 'Customer cancelled order ML-260927093309-PSED', 'Order', 17, '127.0.0.1', '2026-09-27 16:33:27', '2026-09-27 16:33:27'),
(21, 3, 'order.cancelled', 'Customer cancelled order ML-260927091948-0CEK', 'Order', 15, '127.0.0.1', '2026-09-27 16:33:31', '2026-09-27 16:33:31'),
(22, 3, 'order.cancelled', 'Customer cancelled order ML-260927091948-QJEW', 'Order', 16, '127.0.0.1', '2026-09-27 16:33:38', '2026-09-27 16:33:38'),
(23, 3, 'order.cancelled', 'Customer cancelled order ML-260927095216-AHEF', 'Order', 18, '127.0.0.1', '2026-09-27 16:52:22', '2026-09-27 16:52:22'),
(24, 3, 'order.cancelled', 'Customer cancelled order ML-260927100521-GGFT', 'Order', 20, '127.0.0.1', '2026-09-27 17:05:30', '2026-09-27 17:05:30'),
(25, 3, 'order.cancelled', 'Customer cancelled order ML-260927100521-JPQJ', 'Order', 19, '127.0.0.1', '2026-09-27 17:05:35', '2026-09-27 17:05:35'),
(26, 3, 'order.cancelled', 'Customer cancelled order ML-260927100643-74IY', 'Order', 21, '127.0.0.1', '2026-09-27 17:08:33', '2026-09-27 17:08:33'),
(27, 3, 'order.cancelled', 'Customer cancelled order ML-260927101621-RCSG', 'Order', 22, '127.0.0.1', '2026-09-27 17:16:26', '2026-09-27 17:16:26'),
(28, 3, 'order.cancelled', 'Customer cancelled order ML-260927101621-W7HH', 'Order', 23, '127.0.0.1', '2026-09-27 17:16:34', '2026-09-27 17:16:34'),
(29, 3, 'order.cancelled', 'Customer cancelled order ML-260927103359-FTWS', 'Order', 24, '127.0.0.1', '2026-09-27 17:34:04', '2026-09-27 17:34:04'),
(30, 3, 'order.cancelled', 'Customer cancelled order ML-260927103910-OPZS', 'Order', 25, '127.0.0.1', '2026-09-27 17:39:21', '2026-09-27 17:39:21'),
(31, 3, 'order.cancelled', 'Customer cancelled order ML-260927104504-O2K7', 'Order', 26, '127.0.0.1', '2026-09-27 17:45:11', '2026-09-27 17:45:11'),
(32, 3, 'order.cancelled', 'Customer cancelled order ML-260927110117-SIEK', 'Order', 27, '127.0.0.1', '2026-09-27 18:01:23', '2026-09-27 18:01:23'),
(33, 1, 'admin.user.status', 'Changed Farmer ahtizaz status to active', 'User', 6, '127.0.0.1', '2026-09-27 18:03:16', '2026-09-27 18:03:16'),
(34, 1, 'admin.user.status', 'Changed Farmer ahtizaz status to suspended', 'User', 6, '127.0.0.1', '2026-09-27 18:03:20', '2026-09-27 18:03:20'),
(35, 2, 'product.updated', 'Updated product Fresh Spinach', 'Product', 9, '127.0.0.1', '2026-09-27 19:58:03', '2026-09-27 19:58:03'),
(36, 2, 'product.updated', 'Updated product Crunchy Carrots', 'Product', 10, '127.0.0.1', '2026-09-27 19:58:58', '2026-09-27 19:58:58'),
(37, 2, 'product.updated', 'Updated product Golden Potatoes', 'Product', 11, '127.0.0.1', '2026-09-27 19:59:35', '2026-09-27 19:59:35'),
(38, 3, 'order.updated', 'Customer modified order ML-260928092655-NYCG', 'Order', 28, '127.0.0.1', '2026-09-28 16:27:21', '2026-09-28 16:27:21'),
(39, 2, 'order.status', 'Farmer moved order ML-260928092655-NYCG to accepted', 'Order', 28, '127.0.0.1', '2026-09-28 16:29:50', '2026-09-28 16:29:50'),
(40, 2, 'order.status', 'Farmer moved order ML-260928092655-NYCG to ready', 'Order', 28, '127.0.0.1', '2026-09-28 16:29:57', '2026-09-28 16:29:57'),
(41, 2, 'order.status', 'Farmer moved order ML-260928092655-NYCG to completed', 'Order', 28, '127.0.0.1', '2026-09-28 16:30:03', '2026-09-28 16:30:03'),
(42, 3, 'order.cancelled', 'Customer cancelled order ML-260928093833-348W', 'Order', 29, '127.0.0.1', '2026-09-28 16:38:46', '2026-09-28 16:38:46'),
(43, 2, 'product.updated', 'Updated product Red Radish', 'Product', 21, '127.0.0.1', '2026-09-28 16:42:55', '2026-09-28 16:42:55'),
(44, 1, 'admin.user.status', 'Changed Farmer ahtizaz status to active', 'User', 6, '127.0.0.1', '2026-09-28 16:45:24', '2026-09-28 16:45:24'),
(45, 1, 'admin.user.status', 'Changed Farmer ahtizaz status to suspended', 'User', 6, '127.0.0.1', '2026-09-28 16:45:27', '2026-09-28 16:45:27'),
(46, 1, 'admin.user.status', 'Changed Farmer ahtizaz status to active', 'User', 6, '127.0.0.1', '2026-09-28 16:45:32', '2026-09-28 16:45:32'),
(47, 1, 'admin.user.status', 'Changed Farmer ahtizaz status to suspended', 'User', 6, '127.0.0.1', '2026-09-28 16:45:35', '2026-09-28 16:45:35'),
(48, 1, 'admin.user.status', 'Changed Azi Malik status to suspended', 'User', 4, '127.0.0.1', '2026-09-28 16:48:48', '2026-09-28 16:48:48'),
(49, 1, 'admin.user.status', 'Changed Azi Malik status to active', 'User', 4, '127.0.0.1', '2026-09-28 16:49:27', '2026-09-28 16:49:27');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Vegetables', 'vegetables', '2026-09-25 14:03:02', '2026-09-25 14:03:02'),
(2, 'Fruits', 'fruits', '2026-09-25 14:03:02', '2026-09-25 14:03:02'),
(3, 'Dairy', 'dairy', '2026-09-25 14:03:02', '2026-09-25 14:03:02'),
(4, 'Baked Goods', 'baked-goods', '2026-09-25 14:03:02', '2026-09-25 14:03:02'),
(5, 'Herbs', 'herbs', '2026-09-25 14:03:02', '2026-09-25 14:03:02'),
(6, 'Organic Pantry', 'organic-pantry', '2026-09-25 14:03:02', '2026-09-25 14:03:02');

-- --------------------------------------------------------

--
-- Table structure for table `farmer_profiles`
--

CREATE TABLE `farmer_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `stall_name` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `operating_days` varchar(255) DEFAULT NULL,
  `pickup_windows` varchar(255) DEFAULT NULL,
  `order_cutoff_time` time DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `approval_status` enum('pending','approved','suspended') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `farmer_profiles`
--

INSERT INTO `farmer_profiles` (`id`, `user_id`, `stall_name`, `bio`, `operating_days`, `pickup_windows`, `order_cutoff_time`, `address`, `latitude`, `longitude`, `approval_status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Green Valley Organics', 'Fresh seasonal produce from local growers.', 'Saturday, Sunday', '09:00 AM - 02:00 PM', NULL, 'Auto Bhan Road, Hyderabad', 25.39600000, 68.35780000, 'approved', '2026-09-25 14:03:01', '2026-09-25 17:23:11'),
(2, 6, 'Farmer ahtizaz Market Stall', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'suspended', '2026-09-26 11:21:25', '2026-09-28 16:45:35'),
(3, 7, 'Farmer ahtizaz Market Stall', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'approved', '2026-09-26 11:21:59', '2026-09-26 11:22:44');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `farmer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `farmer_id`, `product_id`, `created_at`, `updated_at`) VALUES
(9, 3, NULL, 9, '2026-09-28 16:37:58', '2026-09-28 16:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `markets`
--

CREATE TABLE `markets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `days` varchar(255) DEFAULT NULL,
  `hours` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `map_provider` varchar(255) NOT NULL DEFAULT 'OpenStreetMap',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `markets`
--

INSERT INTO `markets` (`id`, `name`, `address`, `days`, `hours`, `latitude`, `longitude`, `map_provider`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Green Saturday Market', 'Auto Bhan Road, Hyderabad', 'Saturday', '08:00 AM - 03:00 PM', 25.39600000, 68.35780000, 'OpenStreetMap', 1, '2026-09-25 14:03:02', '2026-09-25 14:03:02'),
(2, 'Community Farmers Market', 'Latifabad Unit 7, Hyderabad', 'Sunday', '09:00 AM - 02:00 PM', 25.36700000, 68.35300000, 'OpenStreetMap', 1, '2026-09-25 14:03:02', '2026-09-25 14:03:02');

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
(2, '0001_01_02_000000_create_markets_table', 1),
(3, '0001_01_03_000000_create_farmer_profiles_table', 1),
(4, '0001_01_04_000000_create_categories_table', 1),
(5, '0001_01_05_000000_create_products_table', 1),
(6, '0001_01_06_000000_create_orders_table', 1),
(7, '0001_01_07_000000_create_order_items_table', 1),
(8, '0001_01_08_000000_create_favorites_table', 1),
(9, '0001_01_09_000000_create_reviews_table', 1),
(10, '0001_01_10_000000_create_notifications_table', 1),
(11, '0001_01_11_000000_create_announcements_table', 1),
(12, '0001_01_12_000000_create_sessions_table', 1),
(13, '2026_09_25_120000_create_pickup_slots_table', 2),
(14, '2026_09_25_130000_create_cart_items_table', 3),
(15, '2026_09_25_140000_create_password_reset_tokens_table', 4),
(16, '2026_09_25_150000_create_password_reset_otps_table', 5),
(17, '2026_09_25_140000_add_marketlink_advanced_fields', 6),
(18, '2026_09_25_141000_create_weekly_stock_templates_table', 6),
(19, '2026_09_25_142000_create_saved_markets_table', 6),
(20, '2026_09_25_143000_create_activity_logs_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'info',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'New pre-order', 'Order ML-260925071358-VEXS is waiting for review.', 'order', '2026-09-25 17:21:21', '2026-09-25 14:13:58', '2026-09-25 17:21:21'),
(2, 3, 'Order update', 'Order ML-260925071358-VEXS has been accepted.', 'order', '2026-09-26 20:03:05', '2026-09-25 14:29:01', '2026-09-26 20:03:05'),
(3, 3, 'Order update', 'Order ML-260925071358-VEXS has been ready for pickup.', 'order', '2026-09-26 20:03:05', '2026-09-25 14:29:48', '2026-09-26 20:03:05'),
(4, 3, 'Order update', 'Order ML-260925071358-VEXS has been completed.', 'order', '2026-09-26 20:03:05', '2026-09-25 14:29:52', '2026-09-26 20:03:05'),
(5, 2, 'New pre-order', 'Order ML-260925073534-XUXI is waiting for your approval.', 'order', '2026-09-25 17:21:21', '2026-09-25 14:35:34', '2026-09-25 17:21:21'),
(6, 3, 'Order update', 'Order ML-260925073534-XUXI has been accepted.', 'order', '2026-09-26 20:03:05', '2026-09-25 14:35:55', '2026-09-26 20:03:05'),
(7, 3, 'Order update', 'Order ML-260925073534-XUXI has been ready for pickup.', 'order', '2026-09-26 20:03:05', '2026-09-25 14:36:00', '2026-09-26 20:03:05'),
(8, 3, 'Order update', 'Order ML-260925073534-XUXI has been completed.', 'order', '2026-09-26 20:03:05', '2026-09-25 14:36:04', '2026-09-26 20:03:05'),
(9, 2, 'New pre-order', 'Order ML-260925102747-ISTC is waiting for your approval.', 'order', '2026-09-25 19:30:56', '2026-09-25 17:27:47', '2026-09-25 19:30:56'),
(10, 2, 'New pre-order', 'Order ML-260925102754-HI5O is waiting for your approval.', 'order', '2026-09-25 19:30:56', '2026-09-25 17:27:54', '2026-09-25 19:30:56'),
(11, 2, 'New pre-order', 'Order ML-260925103342-PC6M is waiting for your approval.', 'order', '2026-09-25 19:30:56', '2026-09-25 17:33:42', '2026-09-25 19:30:56'),
(12, 2, 'New pre-order', 'Order ML-260925103843-FM2F is waiting for your approval.', 'order', '2026-09-25 19:30:56', '2026-09-25 17:38:43', '2026-09-25 19:30:56'),
(13, 2, 'Order cancelled', 'Customer cancelled order ML-260925103843-FM2F. Stock has been released.', 'order', '2026-09-25 19:30:53', '2026-09-25 17:39:05', '2026-09-25 19:30:53'),
(14, 2, 'New pre-order', 'Order ML-260925104906-A76M is waiting for your approval.', 'order', '2026-09-25 19:30:56', '2026-09-25 17:49:06', '2026-09-25 19:30:56'),
(15, 3, 'Order update', 'Order ML-260925104906-A76M has been accepted.', 'order', '2026-09-26 20:03:05', '2026-09-25 17:50:04', '2026-09-26 20:03:05'),
(16, 3, 'Order update', 'Order ML-260925103342-PC6M has been accepted.', 'order', '2026-09-26 20:03:05', '2026-09-25 17:50:09', '2026-09-26 20:03:05'),
(17, 3, 'Order update', 'Order ML-260925103342-PC6M has been ready for pickup.', 'order', '2026-09-26 20:03:05', '2026-09-25 17:50:11', '2026-09-26 20:03:05'),
(18, 3, 'Order update', 'Order ML-260925102754-HI5O has been accepted.', 'order', '2026-09-26 20:03:05', '2026-09-25 17:50:12', '2026-09-26 20:03:05'),
(19, 3, 'Order update', 'Order ML-260925104906-A76M has been ready for pickup.', 'order', '2026-09-26 20:03:05', '2026-09-25 17:50:15', '2026-09-26 20:03:05'),
(20, 3, 'Order update', 'Order ML-260925104906-A76M has been completed.', 'order', '2026-09-26 20:03:05', '2026-09-25 17:50:17', '2026-09-26 20:03:05'),
(21, 3, 'Order update', 'Order ML-260925103342-PC6M has been completed.', 'order', '2026-09-26 20:03:05', '2026-09-25 17:50:18', '2026-09-26 20:03:05'),
(22, 3, 'Order update', 'Order ML-260925102754-HI5O has been ready for pickup.', 'order', '2026-09-26 20:03:05', '2026-09-25 17:50:19', '2026-09-26 20:03:05'),
(23, 3, 'Order update', 'Order ML-260925102754-HI5O has been completed.', 'order', '2026-09-26 20:03:05', '2026-09-25 17:50:23', '2026-09-26 20:03:05'),
(24, 3, 'Order update', 'Order ML-260925102747-ISTC has been accepted.', 'order', '2026-09-26 20:03:05', '2026-09-25 17:50:28', '2026-09-26 20:03:05'),
(25, 3, 'Order update', 'Order ML-260925102747-ISTC has been cancelled by the farmer.', 'order', '2026-09-26 20:03:05', '2026-09-25 17:50:47', '2026-09-26 20:03:05'),
(26, 2, 'New customer review', 'A customer rated Seasonal Mangoes 5/5.', 'review', '2026-09-25 19:30:56', '2026-09-25 18:14:05', '2026-09-25 19:30:56'),
(27, 2, 'New customer review', 'A customer rated Seasonal Mangoes 4/5.', 'review', '2026-09-25 19:30:56', '2026-09-25 18:19:46', '2026-09-25 19:30:56'),
(28, 3, 'Farmer replied to your review', 'The farmer replied to your review on Seasonal Mangoes.', 'review', '2026-09-26 20:03:05', '2026-09-25 18:24:28', '2026-09-26 20:03:05'),
(29, 2, 'New cart pre-order', 'Order ML-260925125118-4GDO is waiting for your approval.', 'order', '2026-09-26 12:31:22', '2026-09-25 19:51:18', '2026-09-26 12:31:22'),
(30, 2, 'Order cancelled', 'Customer cancelled order ML-260925125118-4GDO. Stock has been released.', 'order', '2026-09-26 12:31:22', '2026-09-25 19:51:31', '2026-09-26 12:31:22'),
(31, 2, 'New cart pre-order', 'Order ML-260925131726-GNBY is waiting for your approval.', 'order', '2026-09-26 12:31:22', '2026-09-25 20:17:26', '2026-09-26 12:31:22'),
(32, 2, 'Order cancelled', 'Customer cancelled order ML-260925131726-GNBY. Stock has been released.', 'order', '2026-09-26 12:31:22', '2026-09-25 20:17:47', '2026-09-26 12:31:22'),
(33, 2, 'New cart pre-order', 'Order ML-260926091100-5ZFZ is waiting for your approval.', 'order', '2026-09-26 17:38:52', '2026-09-26 16:11:00', '2026-09-26 17:38:52'),
(34, 3, 'Order update', 'Order ML-260926091100-5ZFZ has been accepted.', 'order', '2026-09-26 20:03:05', '2026-09-26 17:26:08', '2026-09-26 20:03:05'),
(35, 3, 'Order update', 'Order ML-260926091100-5ZFZ has been ready for pickup.', 'order', '2026-09-26 20:03:05', '2026-09-26 18:06:22', '2026-09-26 20:03:05'),
(36, 3, 'Order update', 'Order ML-260926091100-5ZFZ has been completed.', 'order', '2026-09-26 20:03:05', '2026-09-26 18:06:30', '2026-09-26 20:03:05'),
(37, 2, 'New cart pre-order', 'Order ML-260927084818-S5F6 is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 15:48:18', '2026-09-27 19:01:40'),
(38, 2, 'New cart pre-order', 'Order ML-260927084818-JXLL is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 15:48:18', '2026-09-27 19:01:40'),
(39, 2, 'Order cancelled', 'Customer cancelled order ML-260927084818-S5F6. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 15:48:25', '2026-09-27 19:01:40'),
(40, 2, 'Order cancelled', 'Customer cancelled order ML-260927084818-JXLL. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 15:48:29', '2026-09-27 19:01:40'),
(41, 2, 'New cart pre-order', 'Order ML-260927090719-MGLC is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 16:07:19', '2026-09-27 19:01:40'),
(42, 2, 'New cart pre-order', 'Order ML-260927090719-1KNR is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 16:07:19', '2026-09-27 19:01:40'),
(43, 2, 'Order cancelled', 'Customer cancelled order ML-260927090719-MGLC. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 16:07:23', '2026-09-27 19:01:40'),
(44, 2, 'Order cancelled', 'Customer cancelled order ML-260927090719-1KNR. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 16:07:34', '2026-09-27 19:01:40'),
(45, 2, 'New cart pre-order', 'Order ML-260927091948-0CEK is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 16:19:48', '2026-09-27 19:01:40'),
(46, 2, 'New cart pre-order', 'Order ML-260927091948-QJEW is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 16:19:48', '2026-09-27 19:01:40'),
(47, 2, 'New cart pre-order', 'Order ML-260927093309-PSED is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 16:33:09', '2026-09-27 19:01:40'),
(48, 2, 'Order cancelled', 'Customer cancelled order ML-260927093309-PSED. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 16:33:24', '2026-09-27 19:01:40'),
(49, 2, 'Order cancelled', 'Customer cancelled order ML-260927091948-0CEK. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 16:33:28', '2026-09-27 19:01:40'),
(50, 2, 'Order cancelled', 'Customer cancelled order ML-260927091948-QJEW. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 16:33:35', '2026-09-27 19:01:40'),
(51, 2, 'New cart pre-order', 'Order ML-260927095216-AHEF is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 16:52:16', '2026-09-27 19:01:40'),
(52, 2, 'Order cancelled', 'Customer cancelled order ML-260927095216-AHEF. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 16:52:19', '2026-09-27 19:01:40'),
(53, 2, 'New cart pre-order', 'Order ML-260927100521-JPQJ is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:05:21', '2026-09-27 19:01:40'),
(54, 2, 'New cart pre-order', 'Order ML-260927100521-GGFT is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:05:21', '2026-09-27 19:01:40'),
(55, 2, 'Order cancelled', 'Customer cancelled order ML-260927100521-GGFT. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:05:26', '2026-09-27 19:01:40'),
(56, 2, 'Order cancelled', 'Customer cancelled order ML-260927100521-JPQJ. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:05:32', '2026-09-27 19:01:40'),
(57, 2, 'New cart pre-order', 'Order ML-260927100643-74IY is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:06:43', '2026-09-27 19:01:40'),
(58, 2, 'Order cancelled', 'Customer cancelled order ML-260927100643-74IY. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:08:30', '2026-09-27 19:01:40'),
(59, 2, 'New cart pre-order', 'Order ML-260927101621-RCSG is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:16:21', '2026-09-27 19:01:40'),
(60, 2, 'New cart pre-order', 'Order ML-260927101621-W7HH is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:16:21', '2026-09-27 19:01:40'),
(61, 2, 'Order cancelled', 'Customer cancelled order ML-260927101621-RCSG. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:16:23', '2026-09-27 19:01:40'),
(62, 2, 'Order cancelled', 'Customer cancelled order ML-260927101621-W7HH. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:16:31', '2026-09-27 19:01:40'),
(63, 2, 'New cart pre-order', 'Order ML-260927103359-FTWS is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:33:59', '2026-09-27 19:01:40'),
(64, 2, 'Order cancelled', 'Customer cancelled order ML-260927103359-FTWS. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:34:01', '2026-09-27 19:01:40'),
(65, 2, 'New cart pre-order', 'Order ML-260927103910-OPZS is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:39:11', '2026-09-27 19:01:40'),
(66, 2, 'Order cancelled', 'Customer cancelled order ML-260927103910-OPZS. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:39:18', '2026-09-27 19:01:40'),
(67, 2, 'New cart pre-order', 'Order ML-260927104504-O2K7 is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:45:04', '2026-09-27 19:01:40'),
(68, 2, 'Order cancelled', 'Customer cancelled order ML-260927104504-O2K7. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 17:45:08', '2026-09-27 19:01:40'),
(69, 2, 'New cart pre-order', 'Order ML-260927110117-SIEK is waiting for your approval.', 'order', '2026-09-27 19:01:40', '2026-09-27 18:01:17', '2026-09-27 19:01:40'),
(70, 2, 'Order cancelled', 'Customer cancelled order ML-260927110117-SIEK. Stock has been released.', 'order', '2026-09-27 19:01:40', '2026-09-27 18:01:20', '2026-09-27 19:01:40'),
(71, 2, 'New cart pre-order', 'Order ML-260928092655-NYCG is waiting for your approval.', 'order', '2026-09-28 16:44:42', '2026-09-28 16:26:55', '2026-09-28 16:44:42'),
(72, 2, 'Order updated', 'Customer updated order ML-260928092655-NYCG.', 'order', '2026-09-28 16:44:42', '2026-09-28 16:27:16', '2026-09-28 16:44:42'),
(73, 3, 'Order update', 'Order ML-260928092655-NYCG has been accepted.', 'order', '2026-09-28 16:36:37', '2026-09-28 16:29:47', '2026-09-28 16:36:37'),
(74, 3, 'Order update', 'Order ML-260928092655-NYCG has been ready for pickup.', 'order', '2026-09-28 16:36:37', '2026-09-28 16:29:54', '2026-09-28 16:36:37'),
(75, 3, 'Order update', 'Order ML-260928092655-NYCG has been completed.', 'order', '2026-09-28 16:36:37', '2026-09-28 16:29:59', '2026-09-28 16:36:37'),
(76, 2, 'New customer review', 'A customer rated Golden Potatoes 4/5.', 'review', '2026-09-28 16:44:42', '2026-09-28 16:37:31', '2026-09-28 16:44:42'),
(77, 2, 'New cart pre-order', 'Order ML-260928093833-348W is waiting for your approval.', 'order', '2026-09-28 16:44:42', '2026-09-28 16:38:33', '2026-09-28 16:44:42'),
(78, 2, 'Order cancelled', 'Customer cancelled order ML-260928093833-348W. Stock has been released.', 'order', '2026-09-28 16:44:42', '2026-09-28 16:38:43', '2026-09-28 16:44:42'),
(79, 3, 'Farmer replied to your review', 'The farmer replied to your review on Golden Potatoes.', 'review', NULL, '2026-09-28 16:44:29', '2026-09-28 16:44:29'),
(80, 3, 'Farmer replied to your review', 'The farmer replied to your review on Golden Potatoes.', 'review', NULL, '2026-09-28 16:44:33', '2026-09-28 16:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `farmer_id` bigint(20) UNSIGNED NOT NULL,
  `market_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pickup_date` date NOT NULL,
  `pickup_slot` varchar(255) NOT NULL,
  `status` enum('placed','accepted','ready','completed','cancelled','declined') NOT NULL DEFAULT 'placed',
  `total_amount` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `placed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `farmer_id`, `market_id`, `pickup_date`, `pickup_slot`, `status`, `total_amount`, `notes`, `placed_at`, `created_at`, `updated_at`) VALUES
(1, 'ML-260925071358-VEXS', 3, 2, 1, '2026-09-26', '11:00 AM - 12:00 PM', 'completed', 1280.00, NULL, '2026-09-25 14:13:58', '2026-09-25 14:13:58', '2026-09-25 14:29:52'),
(2, 'ML-260925073534-XUXI', 3, 2, 2, '2026-09-26', '09:00 AM - 10:00 AM', 'completed', 240.00, NULL, '2026-09-25 14:35:34', '2026-09-25 14:35:34', '2026-09-25 14:36:04'),
(3, 'ML-260925102747-ISTC', 3, 2, 2, '2026-09-26', '09:00 AM - 10:00 AM', 'cancelled', 1120.00, NULL, '2026-09-25 17:27:47', '2026-09-25 17:27:47', '2026-09-25 17:50:47'),
(4, 'ML-260925102754-HI5O', 3, 2, 2, '2026-09-26', '09:00 AM - 10:00 AM', 'completed', 1120.00, NULL, '2026-09-25 17:27:54', '2026-09-25 17:27:54', '2026-09-25 17:50:23'),
(5, 'ML-260925103342-PC6M', 3, 2, 1, '2026-09-30', '09:00 AM - 10:00 AM', 'completed', 320.00, NULL, '2026-09-25 17:33:42', '2026-09-25 17:33:42', '2026-09-25 17:50:18'),
(6, 'ML-260925103843-FM2F', 3, 2, 1, '2026-09-29', '09:00 AM - 10:00 AM', 'cancelled', 320.00, NULL, '2026-09-25 17:38:43', '2026-09-25 17:38:43', '2026-09-25 17:39:05'),
(7, 'ML-260925104906-A76M', 3, 2, 1, '2026-09-26', '09:00 AM - 10:00 AM', 'completed', 3840.00, NULL, '2026-09-25 17:49:06', '2026-09-25 17:49:06', '2026-09-25 17:50:16'),
(8, 'ML-260925125118-4GDO', 3, 2, 1, '2026-09-28', '09:00 AM - 10:00 AM', 'cancelled', 180.00, NULL, '2026-09-25 19:51:18', '2026-09-25 19:51:18', '2026-09-25 19:51:31'),
(9, 'ML-260925131726-GNBY', 3, 2, 1, '2026-10-08', '09:00 AM - 10:00 AM', 'cancelled', 360.00, NULL, '2026-09-25 20:17:26', '2026-09-25 20:17:26', '2026-09-25 20:17:47'),
(10, 'ML-260926091100-5ZFZ', 3, 2, 2, '2026-10-09', '10:00 AM - 11:00 AM', 'completed', 200.00, 'mhgjkgjgfjf', '2026-09-26 16:11:00', '2026-09-26 16:11:00', '2026-09-26 18:06:30'),
(11, 'ML-260927084818-S5F6', 3, 2, 2, '2026-10-04', '09:00 AM - 10:00 AM', 'cancelled', 110.00, NULL, '2026-09-27 15:48:18', '2026-09-27 15:48:18', '2026-09-27 15:48:25'),
(12, 'ML-260927084818-JXLL', 3, 2, 1, '2026-10-03', '10:00 AM - 11:00 AM', 'cancelled', 95.00, NULL, '2026-09-27 15:48:18', '2026-09-27 15:48:18', '2026-09-27 15:48:29'),
(13, 'ML-260927090719-MGLC', 3, 2, 2, '2026-10-04', '09:00 AM - 10:00 AM', 'cancelled', 110.00, NULL, '2026-09-27 16:07:19', '2026-09-27 16:07:19', '2026-09-27 16:07:23'),
(14, 'ML-260927090719-1KNR', 3, 2, 1, '2026-09-27', '09:00 AM - 10:00 AM', 'cancelled', 60.00, NULL, '2026-09-27 16:07:19', '2026-09-27 16:07:19', '2026-09-27 16:07:34'),
(15, 'ML-260927091948-0CEK', 3, 2, 1, '2026-10-05', 'Any time', 'cancelled', 95.00, NULL, '2026-09-27 16:19:48', '2026-09-27 16:19:48', '2026-09-27 16:33:28'),
(16, 'ML-260927091948-QJEW', 3, 2, 2, '2026-10-21', 'Any time', 'cancelled', 220.00, NULL, '2026-09-27 16:19:48', '2026-09-27 16:19:48', '2026-09-27 16:33:35'),
(17, 'ML-260927093309-PSED', 3, 2, 1, '2026-09-29', '02:35 AM', 'cancelled', 60.00, 'fresh ho', '2026-09-27 16:33:09', '2026-09-27 16:33:09', '2026-09-27 16:33:24'),
(18, 'ML-260927095216-AHEF', 3, 2, 1, '2026-09-29', '04:52 AM', 'cancelled', 60.00, NULL, '2026-09-27 16:52:16', '2026-09-27 16:52:16', '2026-09-27 16:52:19'),
(19, 'ML-260927100521-JPQJ', 3, 2, 2, '2026-09-29', '03:08 AM', 'cancelled', 110.00, NULL, '2026-09-27 17:05:21', '2026-09-27 17:05:21', '2026-09-27 17:05:32'),
(20, 'ML-260927100521-GGFT', 3, 2, 1, '2026-09-30', '04:06 AM', 'cancelled', 60.00, NULL, '2026-09-27 17:05:21', '2026-09-27 17:05:21', '2026-09-27 17:05:26'),
(21, 'ML-260927100643-74IY', 3, 2, 1, '2026-10-01', '06:06 AM', 'cancelled', 60.00, NULL, '2026-09-27 17:06:43', '2026-09-27 17:06:43', '2026-09-27 17:08:30'),
(22, 'ML-260927101621-RCSG', 3, 2, 1, '2026-10-12', '10:00 AM', 'cancelled', 95.00, NULL, '2026-09-27 17:16:21', '2026-09-27 17:16:21', '2026-09-27 17:16:23'),
(23, 'ML-260927101621-W7HH', 3, 2, 2, '2026-12-12', '10:00 AM', 'cancelled', 110.00, NULL, '2026-09-27 17:16:21', '2026-09-27 17:16:21', '2026-09-27 17:16:31'),
(24, 'ML-260927103359-FTWS', 3, 2, 1, '2026-09-29', '05:35 AM', 'cancelled', 95.00, NULL, '2026-09-27 17:33:59', '2026-09-27 17:33:59', '2026-09-27 17:34:01'),
(25, 'ML-260927103910-OPZS', 3, 2, 1, '2026-09-30', '05:39 AM', 'cancelled', 60.00, NULL, '2026-09-27 17:39:10', '2026-09-27 17:39:10', '2026-09-27 17:39:18'),
(26, 'ML-260927104504-O2K7', 3, 2, 1, '2026-09-30', '03:50 AM', 'cancelled', 420.00, NULL, '2026-09-27 17:45:04', '2026-09-27 17:45:04', '2026-09-27 17:45:08'),
(27, 'ML-260927110117-SIEK', 3, 2, 1, '2026-10-02', '07:01 AM', 'cancelled', 200.00, NULL, '2026-09-27 18:01:17', '2026-09-27 18:01:17', '2026-09-27 18:01:20'),
(28, 'ML-260928092655-NYCG', 3, 2, 1, '2026-10-02', '11:00 AM - 12:00 PM', 'completed', 95.00, 'making fresh', '2026-09-28 16:26:55', '2026-09-28 16:26:55', '2026-09-28 16:29:59'),
(29, 'ML-260928093833-348W', 3, 2, 1, '2026-09-29', '02:39 PM', 'cancelled', 335.00, 'make fresh', '2026-09-28 16:38:33', '2026-09-28 16:38:33', '2026-09-28 16:38:43');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `line_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `line_total`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 4, 320.00, 1280.00, '2026-09-25 14:13:58', '2026-09-25 14:13:58'),
(2, 2, 6, 4, 60.00, 240.00, '2026-09-25 14:35:34', '2026-09-25 14:35:34'),
(3, 3, 2, 8, 140.00, 1120.00, '2026-09-25 17:27:47', '2026-09-25 17:27:47'),
(4, 4, 2, 8, 140.00, 1120.00, '2026-09-25 17:27:54', '2026-09-25 17:27:54'),
(5, 5, 3, 1, 320.00, 320.00, '2026-09-25 17:33:42', '2026-09-25 17:33:42'),
(6, 6, 3, 1, 320.00, 320.00, '2026-09-25 17:38:43', '2026-09-25 17:38:43'),
(7, 7, 3, 12, 320.00, 3840.00, '2026-09-25 17:49:06', '2026-09-25 17:49:06'),
(10, 10, 6, 1, 60.00, 60.00, '2026-09-26 16:11:00', '2026-09-26 16:11:00'),
(11, 10, 2, 1, 140.00, 140.00, '2026-09-26 16:11:00', '2026-09-26 16:11:00'),
(12, 11, 10, 1, 110.00, 110.00, '2026-09-27 15:48:18', '2026-09-27 15:48:18'),
(13, 12, 11, 1, 95.00, 95.00, '2026-09-27 15:48:18', '2026-09-27 15:48:18'),
(14, 13, 10, 1, 110.00, 110.00, '2026-09-27 16:07:19', '2026-09-27 16:07:19'),
(15, 14, 9, 1, 60.00, 60.00, '2026-09-27 16:07:19', '2026-09-27 16:07:19'),
(16, 15, 11, 1, 95.00, 95.00, '2026-09-27 16:19:48', '2026-09-27 16:19:48'),
(17, 16, 10, 2, 110.00, 220.00, '2026-09-27 16:19:48', '2026-09-27 16:19:48'),
(18, 17, 9, 1, 60.00, 60.00, '2026-09-27 16:33:09', '2026-09-27 16:33:09'),
(19, 18, 9, 1, 60.00, 60.00, '2026-09-27 16:52:16', '2026-09-27 16:52:16'),
(20, 19, 10, 1, 110.00, 110.00, '2026-09-27 17:05:21', '2026-09-27 17:05:21'),
(21, 20, 9, 1, 60.00, 60.00, '2026-09-27 17:05:21', '2026-09-27 17:05:21'),
(22, 21, 9, 1, 60.00, 60.00, '2026-09-27 17:06:43', '2026-09-27 17:06:43'),
(23, 22, 11, 1, 95.00, 95.00, '2026-09-27 17:16:21', '2026-09-27 17:16:21'),
(24, 23, 10, 1, 110.00, 110.00, '2026-09-27 17:16:21', '2026-09-27 17:16:21'),
(25, 24, 11, 1, 95.00, 95.00, '2026-09-27 17:33:59', '2026-09-27 17:33:59'),
(26, 25, 9, 1, 60.00, 60.00, '2026-09-27 17:39:11', '2026-09-27 17:39:11'),
(27, 26, 21, 1, 100.00, 100.00, '2026-09-27 17:45:04', '2026-09-27 17:45:04'),
(28, 26, 25, 2, 160.00, 320.00, '2026-09-27 17:45:04', '2026-09-27 17:45:04'),
(29, 27, 21, 2, 100.00, 200.00, '2026-09-27 18:01:17', '2026-09-27 18:01:17'),
(30, 28, 11, 1, 95.00, 95.00, '2026-09-28 16:26:55', '2026-09-28 16:26:55'),
(31, 29, 9, 4, 60.00, 240.00, '2026-09-28 16:38:33', '2026-09-28 16:38:33'),
(32, 29, 11, 1, 95.00, 95.00, '2026-09-28 16:38:33', '2026-09-28 16:38:33');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_otps`
--

CREATE TABLE `password_reset_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp_hash` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('azimalik166@gmail.com', '$2y$12$gCN9B8Q4wHLrukjA.icIou/Ku1VRAa8MU8jIbZu637mOat95opXUu', '2026-09-26 11:53:50'),
('hafizazanhafizazan88@gmail.com', '$2y$12$AUDsvKWoWxj/pa6PAlAr2.4FTV.O/SIMF0wvrfn0tUBVIpau8JS8G', '2026-09-25 20:57:04');

-- --------------------------------------------------------

--
-- Table structure for table `pickup_slots`
--

CREATE TABLE `pickup_slots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `farmer_id` bigint(20) UNSIGNED NOT NULL,
  `market_id` bigint(20) UNSIGNED DEFAULT NULL,
  `slot_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `capacity` int(10) UNSIGNED NOT NULL DEFAULT 5,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pickup_slots`
--

INSERT INTO `pickup_slots` (`id`, `farmer_id`, `market_id`, `slot_date`, `start_time`, `end_time`, `capacity`, `is_active`, `created_at`, `updated_at`) VALUES
(92, 2, 1, '2026-09-26', '09:00:00', '10:00:00', 10, 1, '2026-09-26 21:36:32', '2026-09-26 21:36:32'),
(93, 2, 1, '2026-09-26', '10:00:00', '11:00:00', 10, 1, '2026-09-26 21:36:32', '2026-09-26 21:36:32'),
(94, 2, 1, '2026-09-26', '11:00:00', '12:00:00', 10, 1, '2026-09-26 21:36:32', '2026-09-26 21:36:32'),
(117, 2, 1, '2026-09-27', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(118, 2, 1, '2026-09-27', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(119, 2, 1, '2026-09-27', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(120, 2, 1, '2026-09-28', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(121, 2, 1, '2026-09-28', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(122, 2, 1, '2026-09-28', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(123, 2, 1, '2026-09-29', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(124, 2, 1, '2026-09-29', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(125, 2, 1, '2026-09-29', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(126, 2, 1, '2026-09-30', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(127, 2, 1, '2026-09-30', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(128, 2, 1, '2026-09-30', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(129, 2, 1, '2026-10-01', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(130, 2, 1, '2026-10-01', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(131, 2, 1, '2026-10-01', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(132, 2, 1, '2026-10-02', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(133, 2, 1, '2026-10-02', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(134, 2, 1, '2026-10-02', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(135, 2, 1, '2026-10-03', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(136, 2, 1, '2026-10-03', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(137, 2, 1, '2026-10-03', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(138, 2, 1, '2026-10-04', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(139, 2, 1, '2026-10-04', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(140, 2, 1, '2026-10-04', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(141, 2, 1, '2026-10-05', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(142, 2, 1, '2026-10-05', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(143, 2, 1, '2026-10-05', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(144, 2, 1, '2026-10-06', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(145, 2, 1, '2026-10-06', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(146, 2, 1, '2026-10-06', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(147, 2, 1, '2026-10-07', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(148, 2, 1, '2026-10-07', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(149, 2, 1, '2026-10-07', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(150, 2, 1, '2026-10-08', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(151, 2, 1, '2026-10-08', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(152, 2, 1, '2026-10-08', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(153, 2, 1, '2026-10-09', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(154, 2, 1, '2026-10-09', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(155, 2, 1, '2026-10-09', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(156, 2, 1, '2026-10-10', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(157, 2, 1, '2026-10-10', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(158, 2, 1, '2026-10-10', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(159, 2, 1, '2026-10-11', '09:00:00', '10:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(160, 2, 1, '2026-10-11', '10:00:00', '11:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53'),
(161, 2, 1, '2026-10-11', '11:00:00', '12:00:00', 10, 1, '2026-09-27 16:09:53', '2026-09-27 16:09:53');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `farmer_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `market_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `unit` varchar(50) NOT NULL DEFAULT 'unit',
  `stock_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `market_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `image`, `is_available`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 2, 'Crisp Cucumbers', 'crisp-cucumbers', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 140.00, 'kg', 25, 'images/Crisp Cucumbers.jfif', 1, '2026-09-25 14:03:02', '2026-09-28 15:57:55'),
(3, 2, 2, 1, 'Seasonal Mangoes', 'seasonal-mangoes', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 320.00, 'kg', 18, 'images/Seasonal Mangoes.jfif', 1, '2026-09-25 14:03:02', '2026-09-28 15:57:55'),
(4, 2, 3, 1, 'Farm Eggs', 'farm-eggs', 'Fresh Dairy stock from Green Valley Organics, prepared for local market pickup.', 360.00, 'dozen', 18, 'images/Farm Eggs.jfif', 1, '2026-09-25 14:03:02', '2026-09-28 15:57:55'),
(5, 2, 4, 1, 'Sourdough Loaf', 'sourdough-loaf', 'Fresh Baked Goods stock from Green Valley Organics, prepared for local market pickup.', 280.00, 'loaf', 18, 'images/Sourdough Loaf.jpg', 1, '2026-09-25 14:03:02', '2026-09-28 15:57:55'),
(6, 2, 5, 1, 'Fresh Coriander', 'fresh-coriander', 'Fresh Herbs stock from Green Valley Organics, prepared for local market pickup.', 60.00, 'bunch', 18, 'images/Fresh Coriander.webp', 1, '2026-09-25 14:03:02', '2026-09-28 15:57:55'),
(7, 2, 1, 1, 'Fresh Tomatoes', 'fresh-tomatoes-6ab78ea4bd6fa', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 180.00, 'kg', 18, 'images/FRESH TOMATOES.jfif', 1, '2026-09-26 16:21:40', '2026-09-28 15:57:55'),
(9, 2, 1, 1, 'Fresh Spinach', 'fresh-spinach-vegetables-3', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 60.00, 'bunch', 32, 'images/Fresh Spinach.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 16:38:43'),
(10, 2, 1, 2, 'Crunchy Carrots', 'crunchy-carrots-vegetables-4', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 110.00, 'kg', 39, 'images/CRUNCHY CARROTS.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(11, 2, 1, 1, 'Golden Potatoes', 'golden-potatoes-vegetables-5', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 95.00, 'kg', 45, 'images/Golden Potatoes.jpg', 1, '2026-09-26 19:57:29', '2026-09-28 16:38:43'),
(12, 2, 1, 2, 'Red Onions', 'red-onions-vegetables-6', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 105.00, 'kg', 53, 'images/Red Onions.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(13, 2, 1, 1, 'Fresh Cauliflower', 'fresh-cauliflower-vegetables-7', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 120.00, 'kg', 60, 'images/Fresh Cauliflower.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(14, 2, 1, 2, 'Green Cabbage', 'green-cabbage-vegetables-8', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 90.00, 'kg', 67, 'images/Green Cabbage.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(15, 2, 1, 1, 'Green Capsicum', 'green-capsicum-vegetables-9', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 220.00, 'kg', 74, 'images/Green Capsicum.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(16, 2, 1, 2, 'Fresh Green Chilies', 'fresh-green-chilies-vegetables-10', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 180.00, 'kg', 23, 'images/Fresh Green Chilies.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(17, 2, 1, 1, 'Tender Eggplant', 'tender-eggplant-vegetables-11', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 130.00, 'kg', 30, 'images/Tender Eggplant.jpg', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(18, 2, 1, 2, 'Okra', 'okra-vegetables-12', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 170.00, 'kg', 37, 'images/Okra.jpg', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(19, 2, 1, 1, 'Green Peas', 'green-peas-vegetables-13', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 240.00, 'kg', 44, 'images/Green Peas.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(20, 2, 1, 2, 'Fresh Beetroot', 'fresh-beetroot-vegetables-14', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 150.00, 'kg', 51, 'images/Fresh Beetroot.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(21, 2, 1, 1, 'Red Radish', 'red-radish-vegetables-15', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 100.00, 'kg', 58, 'images/Red Radish.webp', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(22, 2, 1, 2, 'Fresh Turnip', 'fresh-turnip-vegetables-16', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 95.00, 'kg', 65, 'images/Fresh Turnip.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(23, 2, 1, 1, 'Organic Pumpkin', 'organic-pumpkin-vegetables-17', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 90.00, 'kg', 72, 'images/Organic Pumpkin.webp', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(24, 2, 1, 2, 'Bottle Gourd', 'bottle-gourd-vegetables-18', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 100.00, 'kg', 21, 'images/Bottle Gourd.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(25, 2, 1, 1, 'Bitter Gourd', 'bitter-gourd-vegetables-19', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 160.00, 'kg', 28, 'images/Bitter Gourd.jpg', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(26, 2, 1, 2, 'Ridge Gourd', 'ridge-gourd-vegetables-20', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 140.00, 'kg', 35, 'images/Ridge Gourd.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(27, 2, 1, 1, 'Fresh Lettuce', 'fresh-lettuce-vegetables-21', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 120.00, 'head', 42, 'images/Fresh Lettuce.webp', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(28, 2, 1, 2, 'Broccoli', 'broccoli-vegetables-22', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 260.00, 'kg', 49, 'images/Broccoli.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(29, 2, 1, 1, 'Sweet Corn', 'sweet-corn-vegetables-23', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 130.00, 'kg', 56, 'images/Sweet Corn.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(30, 2, 1, 2, 'Fresh Garlic', 'fresh-garlic-vegetables-24', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 420.00, 'kg', 63, 'images/Fresh Garlic.jpg', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(31, 2, 1, 1, 'Fresh Ginger', 'fresh-ginger-vegetables-25', 'Fresh Vegetables stock from Green Valley Organics, prepared for local market pickup.', 360.00, 'kg', 70, 'images/Fresh Ginger.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(32, 2, 2, 2, 'Sweet Bananas', 'sweet-bananas-fruits-2', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 180.00, 'dozen', 25, 'images/Sweet Bananas.jpg', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(33, 2, 2, 1, 'Red Apples', 'red-apples-fruits-3', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 360.00, 'kg', 32, 'images/Red Apples.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(34, 2, 2, 2, 'Kinnow Oranges', 'kinnow-oranges-fruits-4', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 220.00, 'kg', 39, 'images/Kinnow Oranges.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(35, 2, 2, 1, 'Fresh Guava', 'fresh-guava-fruits-5', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 240.00, 'kg', 46, 'images/Fresh Guava.jpg', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(36, 2, 2, 2, 'Ripe Papaya', 'ripe-papaya-fruits-6', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 190.00, 'kg', 53, 'images/Ripe Papaya.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(37, 2, 2, 1, 'Watermelon', 'watermelon-fruits-7', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 120.00, 'kg', 60, 'images/Watermelon.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(38, 2, 2, 2, 'Sweet Muskmelon', 'sweet-muskmelon-fruits-8', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 180.00, 'kg', 67, 'images/Sweet Muskmelon.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(39, 2, 2, 1, 'Pomegranates', 'pomegranates-fruits-9', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 520.00, 'kg', 74, 'images/Pomegranates.jpg', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(40, 2, 2, 2, 'Seedless Grapes', 'seedless-grapes-fruits-10', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 480.00, 'kg', 23, 'images/Seedless Grapes.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(41, 2, 2, 1, 'Fresh Strawberries', 'fresh-strawberries-fruits-11', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 650.00, 'box', 30, 'images/Fresh Strawberries.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(42, 2, 2, 2, 'Juicy Peaches', 'juicy-peaches-fruits-12', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 480.00, 'kg', 37, 'images/Juicy Peaches.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(43, 2, 2, 1, 'Fresh Plums', 'fresh-plums-fruits-13', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 420.00, 'kg', 44, 'images/Fresh Plums.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(44, 2, 2, 2, 'Green Pears', 'green-pears-fruits-14', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 390.00, 'kg', 51, 'images/Green Pears.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(45, 2, 2, 1, 'Fresh Kiwi', 'fresh-kiwi-fruits-15', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 850.00, 'kg', 58, 'images/Fresh Kiwi.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(46, 2, 2, 2, 'Pineapple', 'pineapple-fruits-16', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 420.00, 'piece', 65, 'images/Pineapple.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(47, 2, 2, 1, 'Fresh Coconut', 'fresh-coconut-fruits-17', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 260.00, 'piece', 72, 'images/Fresh Coconut.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(48, 2, 2, 2, 'Fresh Lemons', 'fresh-lemons-fruits-18', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 180.00, 'kg', 21, 'images/Fresh Lemons.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(49, 2, 2, 1, 'Fresh Limes', 'fresh-limes-fruits-19', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 240.00, 'kg', 28, 'images/Fresh Limes.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(50, 2, 2, 2, 'Dragon Fruit', 'dragon-fruit-fruits-20', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 950.00, 'kg', 35, 'images/Dragon Fruit.jpg', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(51, 2, 2, 1, 'Creamy Avocado', 'creamy-avocado-fruits-21', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 900.00, 'kg', 42, 'images/Creamy Avocado.jfif', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55'),
(52, 2, 2, 2, 'Premium Dates', 'premium-dates-fruits-22', 'Fresh Fruits stock from Green Valley Organics, prepared for local market pickup.', 650.00, 'kg', 49, 'images/Premium Dates.jpg', 1, '2026-09-26 19:57:29', '2026-09-28 15:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `farmer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `farmer_reply` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `customer_id`, `farmer_id`, `product_id`, `rating`, `comment`, `farmer_reply`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 3, 4, 'best awesome', 'tHANK yoU', '2026-09-25 18:14:05', '2026-09-25 18:24:28'),
(2, 3, 2, 11, 4, 'good', 'tHANK yoU', '2026-09-28 16:37:31', '2026-09-28 16:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `saved_markets`
--

CREATE TABLE `saved_markets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `market_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saved_markets`
--

INSERT INTO `saved_markets` (`id`, `customer_id`, `market_id`, `created_at`, `updated_at`) VALUES
(1, 3, 2, '2026-09-28 16:40:57', '2026-09-28 16:40:57');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('qhQe4XWBeNCSnNc3fqEJ4OYlxmfb5uD2NmjOWAHI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWEoxM0NlQmRNUUpUNmlDME5kRnIwVVV3eUFlWkp5SjJLaGdWZEJWZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mYXJtZXJzLzIiO3M6NToicm91dGUiO3M6MTI6ImZhcm1lcnMuc2hvdyI7fX0=', 1790590358),
('xXCCHQvK2g1mzdYEN37ZtUnA8cFQrkKHxidMtnIG', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.139.1 Chrome/150.0.7871.250 Electron/43.6.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0F6bjJzU2RCSWN3SXB1V0hCUWtKTHc0Z3laUWpuYmFMcHlZNnE2SyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9sb2NhbGhvc3QvTWFya2V0TGluay9wdWJsaWMvaW5kZXgucGhwIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1790587198),
('yB4hKNHvT3u2QNupbYpb7yNw5nSKsNia4Szq4Iu9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.139.1 Chrome/150.0.7871.250 Electron/43.6.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUs5QTJQcklEczV5YW5MVkdXWENZeUpuWXRWN1RHcFJvUEVKMExVbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mYXJtZXJzLzIiO3M6NToicm91dGUiO3M6MTI6ImZhcm1lcnMuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790591066);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` enum('customer','farmer','admin') NOT NULL DEFAULT 'customer',
  `status` enum('active','pending','suspended') NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `role`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'MarketLink Admin', 'admin@marketlink.local', '03000000000', 'MarketLink HQ', 'admin', 'active', NULL, '$2y$12$7W5LoMDyboL.dAQ9f7Bol.Bg8P3zrIuCF1bqXjnc368Av79lC/T6.', NULL, '2026-09-25 14:03:01', '2026-09-25 14:03:01'),
(2, 'Green Valley Farms', 'farmer@marketlink.local', '03111111111', 'Hyderabad', 'farmer', 'active', NULL, '$2y$12$.KDBLhlbqzfPGMfaiSBy2Opr1CZhLu52rphFFKBUKQhpb4mFckbOi', NULL, '2026-09-25 14:03:01', '2026-09-25 17:23:11'),
(3, 'furqan Customer', 'customer@marketlink.local', '03222222222', 'Hyderabad', 'customer', 'active', NULL, '$2y$12$A8KD3uJ4cQJBfOBdjm23f.pJp1wNu1sa.R0o7hESzf48WVNRsfUVi', NULL, '2026-09-25 14:03:02', '2026-09-25 19:58:17'),
(4, 'Azi Malik', 'azimalik166@gmail.com', '03701053600', 'BALDIA TOWN', 'customer', 'active', NULL, '$2y$12$1PBYJ1G7BRKjAC71ZLAiZudu0R1Y4UhSwYWLnUmjVhxhcqpi/nBhq', 'AP6PRPGnFV0D512keZ1fWEhfyXteqO5fBu5wSNdy0x2s31W9QRED80u33ZHA', '2026-09-25 20:50:57', '2026-09-28 16:49:27'),
(5, 'new', 'hafizazanhafizazan88@gmail.com', '03701053600', 'BALDIA TOWN', 'customer', 'active', NULL, '$2y$12$pvQvo.rKqlMptMt0uL5LbO1QrW65Sddu2tmjQ9sQe4/hLmkNcwhGS', NULL, '2026-09-25 20:56:52', '2026-09-26 11:19:42'),
(6, 'Farmer ahtizaz', 'azimalik591@gmail.com', '03222222222', 'farmer@marketlink.local', 'farmer', 'suspended', NULL, '$2y$12$elneqhb/XSwy51TgvIYQHOCUM8SFJKMVEXWchFfngHig5CKD23cWq', 'qTBiRkWT8nA6jwL3hkToFhM2SsLSx6jltfVSss5Iv32R3VXTjkOMVlOFi6GN', '2026-09-26 11:21:25', '2026-09-28 16:45:35'),
(7, 'Farmer ahtizaz', 'furqanmehmood123@gmail.com', '03222222222', 'farmer@marketlink.local', 'farmer', 'active', NULL, '$2y$12$io0HmZbfM5LzI1W62bQFDObgmRwlluYC.MgjikztSS5ef5qY/wK1C', 'zAclY3AGv4KumxfpnWw6JFFFKMDMURVEQMuZePmfx0KuePRbZQOxUZyJ5x5i', '2026-09-26 11:21:59', '2026-09-26 11:22:44');

-- --------------------------------------------------------

--
-- Table structure for table `weekly_stock_templates`
--

CREATE TABLE `weekly_stock_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `farmer_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `market_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `target_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_entity_type_entity_id_index` (`entity_type`,`entity_id`),
  ADD KEY `activity_logs_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`),
  ADD KEY `cart_items_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `farmer_profiles`
--
ALTER TABLE `farmer_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `farmer_profiles_user_id_unique` (`user_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_farmer_id_product_id_unique` (`user_id`,`farmer_id`,`product_id`),
  ADD KEY `favorites_farmer_id_foreign` (`farmer_id`),
  ADD KEY `favorites_product_id_foreign` (`product_id`);

--
-- Indexes for table `markets`
--
ALTER TABLE `markets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_farmer_id_foreign` (`farmer_id`),
  ADD KEY `orders_market_id_foreign` (`market_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_otps`
--
ALTER TABLE `password_reset_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_reset_otps_email_verified_at_index` (`email`,`verified_at`),
  ADD KEY `password_reset_otps_email_index` (`email`),
  ADD KEY `password_reset_otps_expires_at_index` (`expires_at`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pickup_slots`
--
ALTER TABLE `pickup_slots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pickup_slots_farmer_id_slot_date_start_time_end_time_unique` (`farmer_id`,`slot_date`,`start_time`,`end_time`),
  ADD KEY `pickup_slots_market_id_foreign` (`market_id`),
  ADD KEY `pickup_slots_farmer_id_slot_date_is_active_index` (`farmer_id`,`slot_date`,`is_active`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_farmer_id_foreign` (`farmer_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_market_id_foreign` (`market_id`),
  ADD KEY `products_name_category_id_market_id_index` (`name`,`category_id`,`market_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_customer_id_product_id_unique` (`customer_id`,`product_id`),
  ADD KEY `reviews_farmer_id_foreign` (`farmer_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `saved_markets`
--
ALTER TABLE `saved_markets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `saved_markets_customer_id_market_id_unique` (`customer_id`,`market_id`),
  ADD KEY `saved_markets_market_id_foreign` (`market_id`);

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
-- Indexes for table `weekly_stock_templates`
--
ALTER TABLE `weekly_stock_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weekly_stock_templates_category_id_foreign` (`category_id`),
  ADD KEY `weekly_stock_templates_market_id_foreign` (`market_id`),
  ADD KEY `weekly_stock_templates_farmer_id_is_active_index` (`farmer_id`,`is_active`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `farmer_profiles`
--
ALTER TABLE `farmer_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `markets`
--
ALTER TABLE `markets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `password_reset_otps`
--
ALTER TABLE `password_reset_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pickup_slots`
--
ALTER TABLE `pickup_slots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `saved_markets`
--
ALTER TABLE `saved_markets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `weekly_stock_templates`
--
ALTER TABLE `weekly_stock_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `farmer_profiles`
--
ALTER TABLE `farmer_profiles`
  ADD CONSTRAINT `farmer_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_market_id_foreign` FOREIGN KEY (`market_id`) REFERENCES `markets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pickup_slots`
--
ALTER TABLE `pickup_slots`
  ADD CONSTRAINT `pickup_slots_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pickup_slots_market_id_foreign` FOREIGN KEY (`market_id`) REFERENCES `markets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_market_id_foreign` FOREIGN KEY (`market_id`) REFERENCES `markets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `saved_markets`
--
ALTER TABLE `saved_markets`
  ADD CONSTRAINT `saved_markets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_markets_market_id_foreign` FOREIGN KEY (`market_id`) REFERENCES `markets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `weekly_stock_templates`
--
ALTER TABLE `weekly_stock_templates`
  ADD CONSTRAINT `weekly_stock_templates_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `weekly_stock_templates_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `weekly_stock_templates_market_id_foreign` FOREIGN KEY (`market_id`) REFERENCES `markets` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
