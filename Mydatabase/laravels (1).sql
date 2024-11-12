-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 08:10 AM
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
-- Database: `laravels`
--

-- --------------------------------------------------------

--
-- Table structure for table `billings`
--

CREATE TABLE `billings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rent_form_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `billing_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `reference` varchar(50) DEFAULT NULL,
  `mode` varchar(50) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billings`
--

INSERT INTO `billings` (`id`, `user_id`, `rent_form_id`, `amount`, `billing_date`, `status`, `reference`, `mode`, `paid_at`, `created_at`, `updated_at`) VALUES
(15, 9, 40, 33000.00, '2024-10-13', 'paid', NULL, NULL, '2024-11-08 04:08:52', '2024-10-20 21:21:06', '2024-11-07 20:08:52'),
(16, 10, 41, 40000.00, '2024-11-07', 'paid', NULL, NULL, '2024-11-10 04:42:29', '2024-11-05 21:16:01', '2024-11-09 20:42:29'),
(17, 14, 40, 1000.00, '2024-11-12', 'paid', NULL, NULL, '2024-11-10 12:41:03', '2024-11-10 04:41:03', '2024-11-10 04:41:03'),
(18, 9, 45, 1000.00, '2024-11-19', 'paid', '213sd', 'credit_card', '2024-11-12 05:58:29', '2024-11-10 04:50:43', '2024-11-10 21:58:29'),
(19, 9, 39, 1000.00, '2024-11-12', 'paid', NULL, NULL, NULL, '2024-11-10 07:40:15', '2024-11-10 07:40:15'),
(20, 9, 39, 1000.00, '2024-11-12', 'paid', NULL, NULL, NULL, '2024-11-10 07:40:15', '2024-11-10 07:40:15'),
(21, 9, 39, 1000.00, '2024-11-12', 'paid', NULL, NULL, NULL, '2024-11-10 07:40:15', '2024-11-10 07:40:15'),
(22, 9, 39, 1000.00, '2024-11-12', 'paid', NULL, NULL, NULL, '2024-11-10 07:40:15', '2024-11-10 07:40:15'),
(23, 9, 39, 1000.00, '2024-11-12', 'paid', NULL, NULL, NULL, '2024-11-10 07:40:15', '2024-11-10 07:40:15'),
(24, 9, 39, 1000.00, '2024-11-12', 'paid', NULL, NULL, NULL, '2024-11-10 07:40:15', '2024-11-10 07:40:15');

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
-- Table structure for table `chatrooms`
--

CREATE TABLE `chatrooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `other_user_id` bigint(20) UNSIGNED NOT NULL,
  `dorm_id` bigint(20) UNSIGNED NOT NULL,
  `message_id` bigint(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatrooms`
--

INSERT INTO `chatrooms` (`id`, `user_id`, `other_user_id`, `dorm_id`, `message_id`, `created_at`, `updated_at`) VALUES
(52, 10, 8, 28, 110, '2024-08-05 21:13:02', '2024-08-05 21:13:02'),
(53, 9, 8, 27, 112, '2024-08-06 23:20:54', '2024-08-06 23:20:54'),
(54, 10, 8, 32, 113, '2024-08-09 20:57:43', '2024-08-09 20:57:43'),
(57, 9, 8, 42, 123, '2024-08-18 01:47:24', '2024-08-18 01:47:24'),
(59, 10, 8, 37, 206, '2024-09-09 22:12:25', '2024-09-09 22:12:25'),
(60, 10, 8, 35, 207, '2024-09-09 22:13:29', '2024-09-09 22:13:29'),
(64, 10, 8, 42, 235, '2024-09-17 18:14:52', '2024-09-17 18:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `curse_words`
--

CREATE TABLE `curse_words` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `word` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `curse_words`
--

INSERT INTO `curse_words` (`id`, `word`, `created_at`, `updated_at`) VALUES
(69, 'damn', NULL, NULL),
(70, 'hell', NULL, NULL),
(71, 'crap', NULL, NULL),
(72, 'bastard', NULL, NULL),
(73, 'bitch', NULL, NULL),
(74, 'asshole', NULL, NULL),
(75, 'fool', NULL, NULL),
(76, 'idiot', NULL, NULL),
(77, 'stupid', NULL, NULL),
(78, 'dumb', NULL, NULL),
(79, 'jerk', NULL, NULL),
(80, 'loser', NULL, NULL),
(81, 'gago', NULL, NULL),
(82, 'tanga', NULL, NULL),
(83, 'bobo', NULL, NULL),
(84, 'ulol', NULL, NULL),
(85, 'tarantado', NULL, NULL),
(86, 'bwisit', NULL, NULL),
(87, 'hinayupak', NULL, NULL),
(88, 'lintik', NULL, NULL),
(89, 'putangina', NULL, NULL),
(90, 'peste', NULL, NULL),
(91, 'leche', NULL, NULL),
(92, 'yawa', NULL, NULL),
(93, 'buang', NULL, NULL),
(94, 'bakakon', NULL, NULL),
(95, 'samok', NULL, NULL),
(96, 'yawyaw', NULL, NULL),
(97, 'bahak', NULL, NULL),
(98, 'tan-awon', NULL, NULL),
(99, 'yabag', NULL, NULL),
(100, 'limbong', NULL, NULL),
(101, 'lapok', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dorms`
--

CREATE TABLE `dorms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `capacity` int(10) NOT NULL,
  `beds` int(10) NOT NULL,
  `bedroom` int(10) NOT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `availability` tinyint(1) NOT NULL DEFAULT 0,
  `flag` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dorms`
--

INSERT INTO `dorms` (`id`, `user_id`, `name`, `description`, `address`, `latitude`, `longitude`, `price`, `capacity`, `beds`, `bedroom`, `image`, `archive`, `availability`, `flag`, `created_at`, `updated_at`) VALUES
(27, 8, 'roland12', 'dadssa', '\"Teves, Vito, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25732354, 123.79582294, 10000.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730111654_671f68a63a93c.jpg\\\",\\\"dorm_pictures\\\\\\/1730111655_671f68a7df5e3.jpg\\\",\\\"dorm_pictures\\\\\\/1730111656_671f68a856f7c.jpg\\\"]\"', 0, 0, 0, '2024-08-04 20:50:17', '2024-10-22 19:41:52'),
(28, 8, 'lando', 'dasdsa', '\"Tubod, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25918163, 123.79865443, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730111654_671f68a63a93c.jpg\\\",\\\"dorm_pictures\\\\\\/1730111655_671f68a7df5e3.jpg\\\",\\\"dorm_pictures\\\\\\/1730111656_671f68a856f7c.jpg\\\"]\"', 0, 0, 0, '2024-08-04 20:57:24', '2024-08-09 20:50:15'),
(29, 8, 'oli house', 'new house', '\"Teves, Vito, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25521206, 123.79410364, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730111654_671f68a63a93c.jpg\\\",\\\"dorm_pictures\\\\\\/1730111655_671f68a7df5e3.jpg\\\",\\\"dorm_pictures\\\\\\/1730111656_671f68a856f7c.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:08:17', '2024-09-25 22:45:30'),
(30, 8, 'oli house1', 'new house', '\"Poblacion Ward II, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24372536, 123.79625195, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730111654_671f68a63a93c.jpg\\\",\\\"dorm_pictures\\\\\\/1730111655_671f68a7df5e3.jpg\\\",\\\"dorm_pictures\\\\\\/1730111656_671f68a856f7c.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:08:33', '2024-09-25 22:50:32'),
(31, 8, 'oli house2', 'new house', '\"Escala at Corona Del Mar, Pooc, Cebu, Central Visayas, 6045, Pilipinas\"', 10.23831971, 123.82036251, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730111654_671f68a63a93c.jpg\\\",\\\"dorm_pictures\\\\\\/1730111655_671f68a7df5e3.jpg\\\",\\\"dorm_pictures\\\\\\/1730111656_671f68a856f7c.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:08:46', '2024-09-25 22:51:38'),
(32, 8, 'oli house4', 'new house', '\"Poblacion Ward II, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24262734, 123.79153281, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730111654_671f68a63a93c.jpg\\\",\\\"dorm_pictures\\\\\\/1730111655_671f68a7df5e3.jpg\\\",\\\"dorm_pictures\\\\\\/1730111656_671f68a856f7c.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:09:07', '2024-09-25 22:52:03'),
(33, 8, 'oli house4', 'new house', '\"Linao, Pakigne, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25518391, 123.80474642, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730111654_671f68a63a93c.jpg\\\",\\\"dorm_pictures\\\\\\/1730111655_671f68a7df5e3.jpg\\\",\\\"dorm_pictures\\\\\\/1730111656_671f68a856f7c.jpg\\\"]\"', 1, 0, 0, '2024-08-04 21:09:38', '2024-11-11 18:33:06'),
(34, 8, 'oli house5', 'new house', '\"Vito Elementary School, Vito-Cadulawan Road, Teves, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25360732, 123.79316306, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730111654_671f68a63a93c.jpg\\\",\\\"dorm_pictures\\\\\\/1730111655_671f68a7df5e3.jpg\\\",\\\"dorm_pictures\\\\\\/1730111656_671f68a856f7c.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:09:52', '2024-09-25 22:53:43'),
(35, 8, 'oli house6', 'new house', '\"Poblacion Ward II, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24296519, 123.79530813, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730111654_671f68a63a93c.jpg\\\",\\\"dorm_pictures\\\\\\/1730111655_671f68a7df5e3.jpg\\\",\\\"dorm_pictures\\\\\\/1730111656_671f68a856f7c.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:10:11', '2024-09-25 22:54:05'),
(36, 8, 'oli house7', 'new house', '\"Bacay Elementary School, A. Apostol Street, Tulay, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas\"', 10.23806632, 123.79307726, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730113706_671f70aa9a7dd.jpg\\\",\\\"dorm_pictures\\\\\\/1730113707_671f70ab94107.jpg\\\",\\\"dorm_pictures\\\\\\/1730113707_671f70abe48dc.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:10:41', '2024-10-31 22:51:57'),
(37, 8, 'oli house8', 'new house', '\"Lower Tiber, Poblacion Ward I, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas\"', 10.24307783, 123.79890595, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730113679_671f708f975b2.jpg\\\",\\\"dorm_pictures\\\\\\/1730113680_671f7090c4483.jpg\\\",\\\"dorm_pictures\\\\\\/1730113681_671f7091262fb.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:11:21', '2024-10-31 23:01:39'),
(38, 8, 'roland44', 'ewqewqe', '\"Cantibjang, Pakigne, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25495868, 123.80433083, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730113634_671f7062789a5.jpg\\\",\\\"dorm_pictures\\\\\\/1730113636_671f706421aca.jpg\\\",\\\"dorm_pictures\\\\\\/1730113636_671f70646f810.jpg\\\"]\"', 0, 0, 0, '2024-08-08 01:35:26', '2024-10-28 03:07:17'),
(42, 8, 'shane house', 'cool', '\"Hickory Street, Springwoods Country Homes Subdivision, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24093808, 123.79084639, 10000.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730113609_671f704929945.jpg\\\",\\\"dorm_pictures\\\\\\/1730113610_671f704a3fac4.jpg\\\",\\\"dorm_pictures\\\\\\/1730113610_671f704a98cc3.jpg\\\"]\"', 0, 1, 0, '2024-08-14 20:22:16', '2024-11-09 20:36:58'),
(43, 8, 'house', 'dsadsa', '\"Linao, Pakigne, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25690124, 123.80423160, 10000.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730113501_671f6fdde8aba.jpg\\\",\\\"dorm_pictures\\\\\\/1730113503_671f6fdf142d3.jpg\\\",\\\"dorm_pictures\\\\\\/1730113503_671f6fdf62b6a.jpg\\\"]\"', 0, 0, 0, '2024-09-04 01:52:50', '2024-11-07 21:33:15'),
(44, 8, 'inday house', 'vbeebbe', '\"Poblacion Ward IV, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24614837, 123.79108429, 5000.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730111654_671f68a63a93c.jpg\\\",\\\"dorm_pictures\\\\\\/1730111655_671f68a7df5e3.jpg\\\",\\\"dorm_pictures\\\\\\/1730111656_671f68a856f7c.jpg\\\"]\"', 0, 0, 0, '2024-07-31 21:26:15', '2024-11-11 18:31:17'),
(45, 8, 'sigma house', 'dsadfsadwdfgwef', '\"Pakigne-Tubod Road, Cantibjang, Pakigne, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25138321, 123.80551338, 10000.00, 3, 4, 2, '\"[\\\"dorm_pictures\\\\\\/1730165435_67203abb8e6be.jpg\\\",\\\"dorm_pictures\\\\\\/1730165457_67203ad1a29db.jpg\\\",\\\"dorm_pictures\\\\\\/1730167717_672043a504546.jpg\\\",\\\"dorm_pictures\\\\\\/1730176504_672065f84f853.jpg\\\",\\\"dorm_pictures\\\\\\/1730176514_6720660230af8.jpg\\\",\\\"dorm_pictures\\\\\\/1730176514_67206602e6f49.jpg\\\"]\"', 0, 0, 1, '2024-10-19 22:46:29', '2024-11-11 18:34:02'),
(46, 43, 'rolando house', 'dsadasdasdi;ohefgjirfgbjkl', '\"Poblacion Ward III, Pakigne, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25118869, 123.80209143, 400.00, 3, 12, 12, '\"[\\\"dorm_pictures\\\\\\/1730111654_671f68a63a93c.jpg\\\",\\\"dorm_pictures\\\\\\/1730111655_671f68a7df5e3.jpg\\\",\\\"dorm_pictures\\\\\\/1730111656_671f68a856f7c.jpg\\\"]\"', 0, 0, 0, '2024-10-28 02:34:16', '2024-11-09 20:35:21'),
(47, 8, 'tqtqtqt', 'rtioijfgjklgfgfkl', 'Cebu South Road, Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25221373, 123.80712032, 12222.00, 12, 3, 2, '\"[\\\"dorm_pictures\\\\\\/1731382231_6732cbd730855.jpg\\\",\\\"dorm_pictures\\\\\\/1731382236_6732cbdc30bdc.jpg\\\",\\\"dorm_pictures\\\\\\/1731382236_6732cbdc96a1e.jpg\\\"]\"', 0, 1, 0, '2024-11-11 19:30:36', '2024-11-11 23:08:38');

-- --------------------------------------------------------

--
-- Table structure for table `extend_requests`
--

CREATE TABLE `extend_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` bigint(20) UNSIGNED NOT NULL,
  `new_end_date` date NOT NULL,
  `term` enum('short_term','long_term') NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `t_price` decimal(8,2) NOT NULL,
  `new_duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `dorm_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `dorm_id`, `created_at`, `updated_at`) VALUES
(19, 22, 42, '2024-09-29 23:42:09', '2024-09-29 23:42:09'),
(31, 9, 43, '2024-10-18 00:16:28', '2024-10-18 00:16:28'),
(32, 9, 44, '2024-10-18 00:16:31', '2024-10-18 00:16:31'),
(33, 9, 30, '2024-10-18 00:16:34', '2024-10-18 00:16:34'),
(34, 9, 45, '2024-10-23 01:36:17', '2024-10-23 01:36:17'),
(37, 10, 43, '2024-11-07 00:15:57', '2024-11-07 00:15:57');

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

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"afecad91-1283-4225-940f-b99ecc6b4cc1\",\"displayName\":\"App\\\\Events\\\\NotificationEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\NotificationEvent\\\":1:{s:4:\\\"data\\\";a:3:{s:8:\\\"reciever\\\";i:8;s:7:\\\"message\\\";s:49:\\\"A new rent form has been submitted for your room.\\\";s:6:\\\"sender\\\";i:10;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1725854796, 1725854796),
(2, 'default', '{\"uuid\":\"76651b5e-09c8-499d-a555-43b7a9d9de1f\",\"displayName\":\"App\\\\Events\\\\NotificationEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\NotificationEvent\\\":1:{s:4:\\\"data\\\";a:3:{s:8:\\\"reciever\\\";i:8;s:7:\\\"message\\\";s:49:\\\"A new rent form has been submitted for your room.\\\";s:6:\\\"sender\\\";i:10;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1725854955, 1725854955);

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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dorm_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `chat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rooms_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `dorm_id`, `user_id`, `room_id`, `chat_id`, `rooms_id`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(110, 28, 10, 52, NULL, NULL, 'I am interested in your dorm.', 0, '2024-08-05 21:13:02', '2024-08-05 21:13:02'),
(111, 28, 8, 52, NULL, NULL, 'ok bro', 1, '2024-08-05 21:13:19', '2024-09-09 19:08:45'),
(112, 27, 9, 53, NULL, NULL, 'I am interested in your dorm.', 1, '2024-08-06 23:20:54', '2024-09-16 20:59:22'),
(113, 32, 10, 54, NULL, NULL, 'I am interested in your dorm.', 1, '2024-08-09 20:57:43', '2024-09-16 22:19:21'),
(114, 27, 9, 53, NULL, NULL, 'dsadsa', 1, '2024-08-18 00:40:04', '2024-09-16 20:59:22'),
(122, NULL, 9, NULL, 6, 1, 'I am interested in your dorm.', 0, '2024-08-18 09:45:25', '2024-08-18 09:45:25'),
(123, 42, 9, 57, NULL, NULL, 'I am interested in your dorm.', 1, '2024-08-18 01:47:24', '2024-08-27 19:44:59'),
(124, 28, 8, 52, NULL, NULL, 'bogo', 1, '2024-08-18 02:42:50', '2024-09-09 19:08:45'),
(125, NULL, 9, NULL, 7, 3, 'I am interested in your dorm.', 0, '2024-08-18 10:49:59', '2024-08-18 10:49:59'),
(126, 42, 9, 57, NULL, NULL, 'fdsfds', 1, '2024-08-18 03:21:31', '2024-08-27 19:44:59'),
(127, NULL, 9, NULL, 7, 3, 'yawa', 0, '2024-08-18 11:48:41', '2024-08-18 11:48:41'),
(128, 42, 9, 57, NULL, NULL, 'dsadsa', 1, '2024-08-18 04:00:30', '2024-08-27 19:44:59'),
(129, 42, 9, 57, NULL, NULL, 'dasdsad', 1, '2024-08-18 04:00:37', '2024-08-27 19:44:59'),
(130, 27, 9, 53, NULL, NULL, 'ccvcv', 1, '2024-08-18 04:35:44', '2024-09-16 20:59:22'),
(131, 27, 9, 53, NULL, NULL, 'ddd', 1, '2024-08-18 05:00:31', '2024-09-16 20:59:22'),
(132, 27, 9, 53, NULL, NULL, 'dsada', 1, '2024-08-18 05:01:11', '2024-09-16 20:59:22'),
(133, NULL, 9, NULL, 8, 4, 'I am interested in your dorm.', 0, '2024-08-18 13:01:48', '2024-08-18 13:01:48'),
(134, 42, 9, 57, NULL, NULL, 'dasdas', 1, '2024-08-18 05:07:32', '2024-08-27 19:44:59'),
(143, NULL, 9, NULL, 8, 4, 'dasdsad', 0, '2024-08-18 05:16:20', '2024-08-18 05:16:20'),
(144, NULL, 9, NULL, 8, 4, 'dsadas', 0, '2024-08-18 05:16:58', '2024-08-18 05:16:58'),
(145, NULL, 9, NULL, 8, 4, 'hahah', 0, '2024-08-18 05:19:06', '2024-08-18 05:19:06'),
(146, 27, 9, 53, NULL, NULL, 'gaga', 1, '2024-08-18 05:19:16', '2024-09-16 20:59:22'),
(147, NULL, 9, NULL, 7, 3, 'dadad', 0, '2024-08-18 05:21:53', '2024-08-18 05:21:53'),
(148, NULL, 9, NULL, 7, 3, 'yow', 0, '2024-08-18 05:22:30', '2024-08-18 05:22:30'),
(150, NULL, 8, NULL, 6, 1, 'dasdas', 0, '2024-08-20 00:19:11', '2024-08-20 00:19:11'),
(151, NULL, 8, NULL, 6, 1, 'dsad', 0, '2024-08-20 00:30:16', '2024-08-20 00:30:16'),
(152, NULL, 8, NULL, 6, 1, 'dsa', 0, '2024-08-20 00:33:12', '2024-08-20 00:33:12'),
(153, NULL, 8, NULL, 6, 1, 'http://127.0.0.1:8000/rent-form/6?expires=1724146879&signature=bf83a73033e7a8190d811e75aac52f5a440352e3ca76ef6560606540ba6224a8', 0, '2024-08-20 00:41:19', '2024-08-20 00:41:19'),
(154, NULL, 8, NULL, 6, 1, 'http://127.0.0.1:8000/rent-form/6?expires=1724146881&signature=e7f23ba92f0b2a0536eb8a4ee6b2b3ed03b18effdfd68f276b3b91ff096bd895', 0, '2024-08-20 00:41:21', '2024-08-20 00:41:21'),
(155, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/8?expires=1724146927&signature=2d83f99f7d71b07a0d48469c70cdea35e2675a91a892634994dffdc4b679ccac', 1, '2024-08-20 00:42:07', '2024-09-16 21:58:31'),
(156, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/8?expires=1724147322&signature=0c7859adc8c3da04b7b6fd5fc0ed9db31ff6be64791260544e90c9ef449fb615', 1, '2024-08-20 00:48:42', '2024-09-16 21:58:31'),
(157, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/8?expires=1724147328&signature=f828526695e5aeab4e91cff59a60ecb31fb4222af2d61ec88b299c68f7bdcd35', 1, '2024-08-20 00:48:48', '2024-09-16 21:58:31'),
(158, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/8?expires=1724147431&signature=ef5c75c63c850fda6be17ea1ab5093aa0091e6b654647ec27c95a345c6df5232', 1, '2024-08-20 00:50:31', '2024-09-16 21:58:31'),
(159, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724147468&signature=8c31aece378d175cf3b33fd977f4c5c0e79c64be4ed1e4692dcd21f2e094283a', 1, '2024-08-20 00:51:08', '2024-09-16 21:58:31'),
(160, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724209271&signature=47efb05e9c3c203816678cbd64d23f44b44de7ac7a4859fd8bd80daf788edd85', 1, '2024-08-20 18:01:11', '2024-09-16 21:58:31'),
(161, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724304997&signature=a86c3ec960fe79795ffbc88bc0b137e83e1c41a971e9657ce3e9fd3b7cea7b12', 1, '2024-08-21 20:36:37', '2024-09-16 21:58:31'),
(162, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724305707&signature=3cabe6ec6be973f51fa304a6345912ca8407f6042dc96a9ef69fe4a71d23f229', 1, '2024-08-21 20:48:27', '2024-09-16 21:58:31'),
(163, NULL, 8, NULL, 7, 3, 'http://127.0.0.1:8000/rent-form/3?expires=1724305729&signature=82b8fc4812a3406b3cf1eb727c529bec051826512d155f17bf4c718341a9a8cd', 0, '2024-08-21 20:48:49', '2024-08-21 20:48:49'),
(164, NULL, 9, NULL, 8, 4, 'dsad', 0, '2024-08-21 21:19:02', '2024-08-21 21:19:02'),
(165, NULL, 9, NULL, 8, 4, '`', 0, '2024-08-21 21:19:59', '2024-08-21 21:19:59'),
(166, NULL, 9, NULL, 8, 4, 'ss', 0, '2024-08-21 21:20:18', '2024-08-21 21:20:18'),
(167, NULL, 10, NULL, 9, 4, 'I am interested in your dorm.', 0, '2024-08-22 05:22:14', '2024-08-22 05:22:14'),
(168, NULL, 10, NULL, 9, 4, 's', 0, '2024-08-21 21:22:23', '2024-08-21 21:22:23'),
(169, NULL, 8, NULL, 9, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724308372&signature=7b3b84879a33831108c2d1b679c3ed2795757f6b658826b357b6901faea3cf85', 0, '2024-08-21 21:32:52', '2024-08-21 21:32:52'),
(170, NULL, 10, NULL, 10, 3, 'I am interested in your dorm.', 1, '2024-08-22 05:45:47', '2024-09-16 22:54:19'),
(172, NULL, 8, NULL, 9, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724312181&signature=fa7115914c5394ce1a65021c743079c4ff8917dd0986fa13a4cbf378261a1239', 0, '2024-08-21 22:36:21', '2024-08-21 22:36:21'),
(173, NULL, 8, NULL, 9, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724312364&signature=f3125433834659d15fc4721e147d48365083f2bb3280d61a71d7e26d0477a34b', 0, '2024-08-21 22:39:24', '2024-08-21 22:39:24'),
(174, NULL, 8, NULL, 9, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724312515&signature=1d38912edd38147bcc51b1e231de8c60598b8e4c12f8fafec0ffdedd3f9d482a', 0, '2024-08-21 22:41:55', '2024-08-21 22:41:55'),
(175, NULL, 8, NULL, 7, 3, 'http://127.0.0.1:8000/rent-form/3?expires=1724664763&signature=39b53538c56e90a114a41f8674612420099032fd003a102fdadec9a88225cb83', 0, '2024-08-26 00:32:43', '2024-08-26 00:32:43'),
(176, NULL, 8, NULL, 10, 3, 'http://127.0.0.1:8000/rent-form/3?expires=1724664803&signature=fa46b39cb776ebe65f1f2a6df75f778c185170d7666ec496893ed3a32bff427d', 1, '2024-08-26 00:33:23', '2024-09-16 23:26:32'),
(177, NULL, 10, NULL, 11, 1, 'I am interested in your dorm.', 1, '2024-08-26 08:36:31', '2024-09-08 21:30:51'),
(178, NULL, 8, NULL, 11, 1, 'http://127.0.0.1:8000/rent-form/1?expires=1724665002&signature=b154f8fdd1aa357b99a4694a8c6efcea4c5288c2736433fadeb6e2d2532b0132', 1, '2024-08-26 00:36:42', '2024-09-08 21:56:47'),
(180, NULL, 9, NULL, 13, 5, 'I am interested in your dorm.', 1, '2024-08-27 03:32:05', '2024-09-09 17:55:47'),
(181, NULL, 8, NULL, 6, 1, 'dsad', 0, '2024-08-27 19:26:16', '2024-08-27 19:26:16'),
(182, 42, 8, 57, NULL, NULL, 'dsad', 1, '2024-08-27 19:26:38', '2024-09-16 21:59:05'),
(183, 42, 8, 57, NULL, NULL, 'bogo', 1, '2024-08-27 19:29:09', '2024-09-16 21:59:05'),
(184, NULL, 8, NULL, 13, 5, 'ok bro', 1, '2024-08-27 19:36:29', '2024-09-16 21:58:27'),
(185, NULL, 9, NULL, 13, 5, 'no bro', 1, '2024-08-27 19:39:04', '2024-09-09 17:55:47'),
(186, 42, 8, 57, NULL, NULL, 'hey', 1, '2024-08-27 19:43:57', '2024-09-16 21:59:05'),
(187, 42, 8, 57, NULL, NULL, 'hey', 1, '2024-08-27 19:44:29', '2024-09-16 21:59:05'),
(188, NULL, 8, NULL, 13, 5, 'heyo', 1, '2024-08-27 19:47:48', '2024-09-16 21:58:27'),
(189, NULL, 8, NULL, 13, 5, 'hey', 1, '2024-08-27 19:48:20', '2024-09-16 21:58:27'),
(190, NULL, 9, NULL, 13, 5, 'hoy', 1, '2024-08-27 19:49:06', '2024-09-09 17:55:47'),
(191, NULL, 8, NULL, 11, 1, 'http://127.0.0.1:8000/rent-form/1?expires=1725857976&signature=190e969b72e7c7927d49d888a125e60b2099ce8739393c7538c12c941cbd7e72', 1, '2024-09-08 19:59:36', '2024-09-08 21:56:47'),
(192, NULL, 8, NULL, 11, 1, 'http://127.0.0.1:8000/rent-form/1?expires=1725863449&signature=d7323e3f6bf9ce1fcd6125b0a62e26bf39ce4c3af2dc00fed18fab0705a01308', 1, '2024-09-08 21:30:49', '2024-09-08 21:56:47'),
(193, NULL, 9, NULL, 13, 5, 'hello', 1, '2024-09-09 17:50:32', '2024-09-09 17:55:47'),
(194, NULL, 8, NULL, 13, 5, 'http://127.0.0.1:8000/rent-form/5?expires=1725936649&signature=20b2044a4ecd228980669576f1f5296c20ecebf4fc6bd5447bfc31cad8050836', 1, '2024-09-09 17:50:49', '2024-09-16 21:58:27'),
(198, NULL, 10, NULL, 16, 8, 'I am interested in This Room.', 1, '2024-09-10 03:25:42', '2024-09-09 20:28:12'),
(199, NULL, 8, NULL, 16, 8, 'http://127.0.0.1:8000/rent-form/8?expires=1725942463&signature=6d34efcd1f11edd0c105cced34eda9054790100164dc1e77628f24e9fabb0f27', 1, '2024-09-09 19:27:43', '2024-09-09 20:51:10'),
(200, NULL, 8, NULL, 16, 8, 'http://127.0.0.1:8000/rent-form/8?expires=1725946090&signature=30c228e7a03a42febcfd60a2ff6c27e84196a5836d51dc1a2d6f2d258f19dd55', 1, '2024-09-09 20:28:10', '2024-09-09 20:51:10'),
(201, NULL, 10, NULL, 17, 7, 'I am interested in This Room.', 1, '2024-09-10 04:43:23', '2024-09-16 21:51:22'),
(202, 32, 10, 54, NULL, NULL, 'yow', 1, '2024-09-09 22:04:25', '2024-09-16 22:19:21'),
(203, NULL, 10, NULL, 17, 7, 'yow', 1, '2024-09-09 22:04:47', '2024-09-16 21:51:22'),
(204, NULL, 10, NULL, 17, 7, 'hello', 1, '2024-09-09 22:05:16', '2024-09-16 21:51:22'),
(205, NULL, 8, NULL, 17, 7, 'hello 2', 1, '2024-09-09 22:05:45', '2024-09-16 23:25:22'),
(206, 37, 10, 59, NULL, NULL, 'I am interested in your dorm.', 1, '2024-09-09 22:12:25', '2024-09-16 21:23:50'),
(207, 35, 10, 60, NULL, NULL, 'I am interested in your dorm.', 1, '2024-09-09 22:13:29', '2024-09-09 23:02:04'),
(208, 35, 10, 60, NULL, NULL, 'dsa', 1, '2024-09-09 22:13:41', '2024-09-09 23:02:04'),
(209, 35, 10, 60, NULL, NULL, 'hello', 1, '2024-09-09 22:17:20', '2024-09-09 23:02:04'),
(210, 35, 10, 60, NULL, NULL, 'hey', 1, '2024-09-09 22:17:32', '2024-09-09 23:02:04'),
(211, 35, 8, 60, NULL, NULL, 'saman', 1, '2024-09-09 22:18:04', '2024-09-09 23:01:57'),
(212, 35, 8, 60, NULL, NULL, 'yow', 1, '2024-09-09 22:52:12', '2024-09-09 23:01:57'),
(213, 35, 10, 60, NULL, NULL, 'hey', 1, '2024-09-09 22:57:36', '2024-09-09 23:02:04'),
(214, 35, 10, 60, NULL, NULL, 'hey', 1, '2024-09-09 22:58:14', '2024-09-09 23:02:04'),
(215, 35, 8, 60, NULL, NULL, 'wassup', 1, '2024-09-09 22:58:27', '2024-09-09 23:01:57'),
(216, 35, 10, 60, NULL, NULL, 'yo', 1, '2024-09-09 23:01:01', '2024-09-09 23:02:04'),
(217, 35, 10, 60, NULL, NULL, 'hey', 1, '2024-09-09 23:02:02', '2024-09-09 23:02:04'),
(218, NULL, 8, NULL, 17, 7, 'http://127.0.0.1:8000/rent-form/7?expires=1725955483&signature=2c5fcc2ea6cf45c19445f7bcfcd457454b3d848ebbdf284006bfa2b5b08ef682', 1, '2024-09-09 23:04:43', '2024-09-16 23:25:22'),
(219, NULL, 8, NULL, 17, 7, 'yow', 1, '2024-09-09 23:04:57', '2024-09-16 23:25:22'),
(220, NULL, 8, NULL, 17, 7, 'http://127.0.0.1:8000/rent-form/7?expires=1725955508&signature=c7e40dea16e3b384de14d0d8ca2eae11a34337b5a8cb005b6f238460c5706325', 1, '2024-09-09 23:05:08', '2024-09-16 23:25:22'),
(221, NULL, 8, NULL, 17, 7, 'http://127.0.0.1:8000/rent-form/7?expires=1725955682&signature=ff4ef79d62a1f6da467271d5536b4a96dcadb20c9f88aa2b495d480ecb95556b', 1, '2024-09-09 23:08:02', '2024-09-16 23:25:22'),
(222, NULL, 10, NULL, 17, 7, 'hey', 1, '2024-09-09 23:08:22', '2024-09-16 21:51:22'),
(223, NULL, 8, NULL, 17, 7, 'no❤👌', 1, '2024-09-09 23:10:11', '2024-09-16 23:25:22'),
(224, 32, 8, 54, NULL, NULL, 'das', 1, '2024-09-16 21:25:59', '2024-09-16 22:19:18'),
(225, 32, 8, 54, NULL, NULL, 'ddd', 1, '2024-09-16 21:26:38', '2024-09-16 22:19:18'),
(226, 32, 8, 54, NULL, NULL, 'heydsadasdsasdadadsasadsadsad\n\\sa\nsa\ndsa\n\nsa\nsa\ndsa\nd\nsadsa', 1, '2024-09-16 21:30:53', '2024-09-16 22:19:18'),
(227, 32, 8, 54, NULL, NULL, 'dsadasdsa', 1, '2024-09-16 21:32:16', '2024-09-16 22:19:18'),
(228, 32, 8, 54, NULL, NULL, 'sss', 1, '2024-09-16 21:54:25', '2024-09-16 22:19:18'),
(229, NULL, 8, NULL, 10, 3, 'http://127.0.0.1:8000/rent-form/3?expires=1726559463&signature=0e3523cd7fe2a4a3e25f43d7b820304d44054a170ce689e79c040158e6f8161e', 1, '2024-09-16 22:51:03', '2024-09-16 23:26:32'),
(230, NULL, 8, NULL, 10, 3, 'http://127.0.0.1:8000/rent-form/3?expires=1726559720&signature=17591196581073cf522ccbf62db64cc269a8fc7bcc90f51271e514194c2d618b', 1, '2024-09-16 22:55:20', '2024-09-16 23:26:32'),
(231, NULL, 10, NULL, 10, 3, 'hrey', 0, '2024-09-16 23:25:46', '2024-09-16 23:25:46'),
(235, 42, 10, 64, NULL, NULL, 'I am interested in your dorm.', 1, '2024-09-17 18:14:52', '2024-09-17 18:16:51'),
(236, NULL, 10, NULL, 18, 5, 'I am interested in This Room.', 1, '2024-09-18 02:17:05', '2024-09-17 19:02:36'),
(237, NULL, 10, NULL, 18, 5, 'dsa', 1, '2024-09-17 18:35:23', '2024-09-17 19:02:36'),
(238, NULL, 8, NULL, 18, 5, 'http://localhost/home-seek/public/rent-form/5?expires=1726631676&signature=868b91b37ff11058379d30d2cea061782520a47534b18c65d1b60c65c528748d', 1, '2024-09-17 18:54:36', '2024-09-17 19:02:32'),
(239, NULL, 10, NULL, 18, 5, 'dsaa', 1, '2024-09-17 18:54:53', '2024-09-17 19:02:36'),
(240, NULL, 8, NULL, 18, 5, 'dasd', 1, '2024-09-17 18:54:59', '2024-09-17 19:02:32'),
(241, NULL, 10, NULL, 18, 5, 'ddd', 1, '2024-09-17 18:55:06', '2024-09-17 19:02:36'),
(242, NULL, 8, NULL, 18, 5, 'sss', 1, '2024-09-17 18:55:14', '2024-09-17 19:02:32'),
(243, NULL, 8, NULL, 18, 5, 'http://localhost/home-seek/public/rent-form/5?expires=1726631768&signature=8b36ab255baf2ec8a5550973af2e3f4a5945f5eb70df1d170bd7cd3d563a3f5a', 1, '2024-09-17 18:56:08', '2024-09-17 19:02:32'),
(244, NULL, 10, NULL, 18, 5, 'aaa', 1, '2024-09-17 18:58:08', '2024-09-17 19:02:36'),
(245, NULL, 8, NULL, 18, 5, 'sss', 0, '2024-09-17 19:02:40', '2024-09-17 19:02:40'),
(246, NULL, 22, NULL, 19, 6, 'I am interested in This Room.', 0, '2024-10-01 02:38:32', '2024-10-01 02:38:32');

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
(5, '2024_07_16_111128_user', 3),
(7, '2024_07_19_045353_update_users_table', 4),
(9, '2024_07_19_050333_create_dorms_table', 5),
(10, '2024_07_27_102248_create_chat_rooms_table', 6),
(11, '2024_07_27_102255_create_messages_table', 6),
(12, '2024_07_28_034916_create_chat_messages_table', 7),
(13, '2024_07_28_999999_add_active_status_to_users', 8),
(14, '2024_07_28_999999_add_avatar_to_users', 8),
(15, '2024_07_28_999999_add_dark_mode_to_users', 8),
(16, '2024_07_28_999999_add_messenger_color_to_users', 8),
(17, '2024_07_28_999999_create_chatify_favorites_table', 8),
(18, '2024_07_28_999999_create_chatify_messages_table', 8),
(19, '2024_07_30_022117_add_other_user_id_to_chatrooms_table', 9),
(20, '2024_08_18_085113_create_roomchats_table', 10),
(21, '2024_08_22_045501_create_rent_forms_table', 11),
(22, '2024_08_27_031609_create_notifications_table', 12),
(23, '2024_08_27_032020_create_notifications_table', 13),
(24, '2024_08_27_052627_updatee_notifications_table', 14),
(25, '2024_08_27_053132_updatee_notifications_table', 15),
(26, '2024_09_12_094801_create_verification_request_table', 16),
(27, '2024_09_30_063148_create_favorites_table', 17),
(28, '2024_09_30_063216_create_property_views_table', 17),
(29, '2024_10_01_043735_create_rent_forms_table', 18),
(30, '2024_10_01_043924_create_rent_forms_table', 19),
(31, '2024_10_08_062402_create_extend_requests_table', 20),
(32, '2024_10_08_063031_create_extend_requests_table', 21),
(33, '2024_10_10_021057_update_extend-request_table', 22),
(34, '2024_10_10_021702_update_extend-request_table', 23),
(35, '2024_10_15_022017_create_billings_table', 24),
(36, '2024_10_17_072602_create_reviews_table', 25),
(37, '2024_10_23_060222_remove_room_from_reviews_table', 26),
(38, '2024_11_03_051518_create_reports_table', 27),
(39, '2024_11_05_141932_create_curse_words_table', 28);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `route` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dorm_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `data`, `read`, `route`, `created_at`, `updated_at`, `dorm_id`, `sender_id`) VALUES
(115, 9, 'Form Response', 'Rent Form approved', 1, '', '2024-10-20 23:00:00', '2024-10-20 23:01:45', 45, 8),
(116, 9, 'Form Response', 'Rent Form approved', 0, '', '2024-10-20 23:02:18', '2024-10-20 23:02:18', 45, 8),
(117, 9, 'Form Response', 'Rent Form approved', 0, '', '2024-10-20 23:04:30', '2024-10-20 23:04:30', 45, 8),
(118, 9, 'Form Response', 'Booking Form approved', 0, '', '2024-10-20 23:09:50', '2024-10-20 23:09:50', 45, 8),
(119, 8, 'Form Submit', 'Someone Booked your Property', 1, '', '2024-10-20 23:11:35', '2024-11-07 21:13:06', 45, 9),
(120, 9, 'Form Response', 'Booking Form rejected', 0, '', '2024-10-20 23:13:23', '2024-10-20 23:13:23', 45, 8),
(121, 8, 'Form Submit', 'Someone Booked your Property', 1, '', '2024-10-20 23:15:03', '2024-11-07 21:12:15', 45, 9),
(122, 9, 'Form Response', 'Booking Form approved', 0, '', '2024-10-20 23:15:12', '2024-10-20 23:15:12', 45, 8),
(127, 8, 'Form Submit', 'Someone Booked your Property', 1, '', '2024-10-21 20:36:43', '2024-10-21 20:36:59', 45, 9),
(130, 8, 'Booking Cancellation', 'Booking Cancellation request', 1, '', '2024-10-21 20:43:02', '2024-10-22 00:22:32', 45, 9),
(131, 9, 'Form Response', 'Booking Form rejected', 0, '', '2024-10-21 23:37:48', '2024-10-21 23:37:48', 45, 8),
(132, 9, 'Form Response', 'Booking Form approved', 1, '', '2024-10-21 23:46:00', '2024-10-23 02:32:33', 45, 8),
(133, 9, 'Form Response', 'Booking Form approved', 1, '', '2024-10-21 23:49:09', '2024-10-23 02:32:28', 45, 8),
(136, 9, 'Cancel Response', 'Booking Cancellation Rejected', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-10-22 00:22:10', '2024-10-23 02:32:45', 45, 8),
(137, 43, 'verification', 'Your Verification is Approved', 1, 'http://127.0.0.1:8000/home', '2024-10-28 02:29:07', '2024-11-09 20:32:50', NULL, 14),
(138, 8, 'verification', 'Warning! ', 1, 'http://127.0.0.1:8000/home', '2024-11-01 22:42:08', '2024-11-07 21:02:28', NULL, 14),
(139, 8, 'verification', 'Warning! ', 1, 'http://127.0.0.1:8000/home', '2024-11-01 22:43:28', '2024-11-01 22:45:16', NULL, 14),
(140, 8, 'verification', 'Warning! ', 1, 'http://127.0.0.1:8000/home', '2024-11-01 22:43:41', '2024-11-01 22:45:13', NULL, 14),
(141, 8, 'verification', 'Warning! ', 1, 'http://127.0.0.1:8000/home', '2024-11-01 22:44:03', '2024-11-01 23:08:22', NULL, 14),
(142, 8, 'warning', 'Warning issued: ', 1, 'http://127.0.0.1:8000/home', '2024-11-01 22:48:33', '2024-11-01 23:08:19', NULL, 14),
(143, 8, 'warning', 'Warning issued: ', 1, 'http://127.0.0.1:8000/home', '2024-11-01 22:48:44', '2024-11-01 23:27:47', NULL, 14),
(144, 8, 'warning', 'Warning issued: ', 1, 'http://127.0.0.1:8000/home', '2024-11-01 22:50:16', '2024-11-01 22:50:23', NULL, 14),
(145, 8, 'warning', 'Warning issued: Misleading information', 1, 'http://127.0.0.1:8000/home', '2024-11-01 22:51:42', '2024-11-01 23:36:42', NULL, 14),
(146, 8, 'warning', 'Warning issued: Inappropriate language', 1, NULL, '2024-11-01 23:10:52', '2024-11-01 23:11:35', NULL, 14),
(147, 8, 'warning', 'Warning issued: Spam activity', 1, NULL, '2024-11-01 23:14:06', '2024-11-01 23:39:03', NULL, 14),
(148, 8, 'warning', 'Warning issued: Misleading information', 1, NULL, '2024-11-01 23:14:42', '2024-11-01 23:40:30', NULL, 14),
(149, 8, 'warning', '<strong>Warning issued:</strong> <br> <p>Spam activity</p> <br><strong>You have 0 remaining</strong>', 1, NULL, '2024-11-01 23:44:36', '2024-11-07 21:11:55', NULL, 14),
(150, 8, 'warning', '<strong>Warning issued:</strong> <br> <p>Spam activity</p> <br><strong>You have 2 remaining</strong>', 1, NULL, '2024-11-01 23:48:04', '2024-11-01 23:58:23', NULL, 14),
(151, 8, 'warning', '<strong>Warning issued:</strong> <br> <p>Spam activity</p> <br><strong>You have 1 remaining</strong>', 1, NULL, '2024-11-01 23:54:58', '2024-11-01 23:58:21', NULL, 14),
(152, 8, 'warning', '<strong>Warning issued:</strong> <br> <p>Spam activity</p> <br><strong>You have 0 remaining</strong>', 1, NULL, '2024-11-01 23:56:16', '2024-11-01 23:58:17', NULL, 14),
(153, 8, 'warning', '<strong>Warning issued:</strong> <br> <p>dadasd</p> <br><strong>You have 2 remaining</strong>', 1, NULL, '2024-11-01 23:57:57', '2024-11-01 23:58:31', NULL, 14),
(154, 8, 'warning', '<strong>Warning issued:</strong> <br> <p>Spam activity</p> <br><strong>You have 1 remaining</strong>', 1, NULL, '2024-11-01 23:59:36', '2024-11-01 23:59:39', NULL, 14),
(155, 43, 'warning', '<strong>Property Deactivated due to:</strong> <br> <p>Misleading information</p>', 1, NULL, '2024-11-02 00:10:44', '2024-11-09 20:32:37', 46, 14),
(156, 8, 'warning', '<strong>Property Deactivated due to:</strong> <br> <p>Spam activity</p>', 1, NULL, '2024-11-02 00:11:06', '2024-11-02 00:11:11', 45, 14),
(157, 8, 'Form Submit', 'Someone Booked your Property', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-04 21:54:45', '2024-11-05 21:39:47', 42, 9),
(158, 9, 'warning', '<strong>Warning issued:</strong> <br> <p>Your review contains inappropriate words.</p> <br><strong>You have 2 remaining Strike(s)</strong>', 1, NULL, '2024-11-05 06:58:57', '2024-11-05 06:59:39', NULL, 9),
(159, 9, 'warning', '<strong>Warning issued:</strong> <br> <p>Your review contains inappropriate words.</p> <br><strong>You have 1 remaining Strike(s)</strong>', 1, NULL, '2024-11-05 07:00:59', '2024-11-05 07:01:07', NULL, 9),
(160, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:02', '2024-11-05 21:16:02', 45, 8),
(161, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:02', '2024-11-05 21:16:02', 42, 8),
(162, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:07', '2024-11-05 21:16:07', 45, 8),
(163, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:07', '2024-11-05 21:16:07', 42, 8),
(164, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:12', '2024-11-05 21:16:12', 45, 8),
(165, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:12', '2024-11-05 21:16:12', 42, 8),
(166, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:17', '2024-11-05 21:16:17', 45, 8),
(167, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:17', '2024-11-05 21:16:17', 42, 8),
(168, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:22', '2024-11-05 21:16:22', 45, 8),
(169, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:22', '2024-11-05 21:16:22', 42, 8),
(170, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:28', '2024-11-05 21:16:28', 45, 8),
(171, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:28', '2024-11-05 21:16:28', 42, 8),
(172, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:33', '2024-11-05 21:16:33', 45, 8),
(173, 9, 'check-in', 'Your check-in starts in 2 days!', 0, NULL, '2024-11-05 21:16:33', '2024-11-05 21:16:33', 42, 8),
(174, 8, 'warning', '<strong>Warning issued:</strong> <br> <p>no bill bayad</p> <br><strong>You have 0 remaining Strike</strong>', 0, NULL, '2024-11-05 21:52:16', '2024-11-05 21:52:16', NULL, 14),
(175, 8, 'warning', '<strong>Complaint Review - Action Taken:</strong> <br> <p> Your report has been reviewed, and a warning has been issued to the user for the following reason: <strong></strong></p> <p>Please monitor the situation to ensure compliance.</p>', 1, NULL, '2024-11-06 02:15:02', '2024-11-06 02:15:12', NULL, 14),
(176, 9, 'warning', '<strong>Warning Notification:</strong> <br> <p> You have been issued a warning due to the following reason: <strong></strong></p> <p>Please take immediate action to rectify the situation. Continued violations may lead to further actions.</p>', 1, NULL, '2024-11-06 02:15:03', '2024-11-06 02:15:28', NULL, 14),
(177, 9, 'warning', '<strong>Complaint Review - Action Taken:</strong> <br> <p> Your report has been reviewed, and a warning has been issued to the user for the following reason: <strong>dasdsadaddada</strong></p> <p>Please monitor the situation to ensure compliance.</p>', 1, NULL, '2024-11-06 02:24:10', '2024-11-06 23:41:50', NULL, 14),
(179, 8, 'warning', '<strong>Complaint Response:</strong> <br> <p> We have reviewed your report and have deactivated the property due to the following reason: <strong>dsadasd</strong></p>', 0, NULL, '2024-11-06 02:27:05', '2024-11-06 02:27:05', NULL, 14),
(180, 9, 'warning', '<strong>Action Taken on Your Property:</strong> <br> <p> Your property has been deactivated due to the following reason: <strong>dsadasd</strong></p>', 1, NULL, '2024-11-06 02:27:05', '2024-11-06 23:41:40', NULL, 14),
(181, 8, 'warning', '<strong>Complaint Response:</strong> <br> <p> We have reviewed your report and have deactivated the property due to the following reason: <strong>dsadasd</strong></p>', 0, NULL, '2024-11-06 04:08:33', '2024-11-06 04:08:33', NULL, 14),
(182, 8, 'warning', '<strong>Action Taken on Your Property:</strong> <br> <p> Your property has been deactivated due to the following reason: <strong>dsadasd</strong></p>', 0, NULL, '2024-11-06 04:08:34', '2024-11-06 04:08:34', NULL, 14),
(183, 51, 'verification', 'Your Verification is Approved', 1, 'http://localhost:8000/home', '2024-11-06 20:26:44', '2024-11-06 20:27:13', NULL, 14),
(184, 8, 'warning', '<strong>Complaint Response:</strong> <br> <p> We have reviewed your complaint and, after careful consideration, we have determined that it is invalid. However, the reported user will be placed under observation for further monitoring. No immediate action has been taken, but we will continue to monitor the situation.</p>', 1, NULL, '2024-11-06 23:53:53', '2024-11-06 23:54:01', NULL, 14),
(185, 8, 'warning', '<strong>Complaint Response:</strong> <br> <p> We have reviewed your report, and after careful consideration, we have determined that the complaint is invalid. The property remains active.</p>', 1, NULL, '2024-11-06 23:54:11', '2024-11-06 23:56:27', NULL, 14),
(186, 9, 'Bills', 'Owner is Notifying you for payment', 0, 'http://localhost:8000/user/rent-forms', '2024-11-06 23:57:18', '2024-11-06 23:57:18', 42, 8),
(187, 8, 'Form Submit', 'Someone Booked your Property', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-07 00:29:06', '2024-11-07 21:13:16', 43, 9),
(188, 8, 'Booking Cancellation', 'Booking Cancelled', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-07 00:29:52', '2024-11-07 00:35:46', 43, 9),
(189, 9, 'Cancel Response', 'Booking Cancellation Rejected', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-07 00:44:44', '2024-11-07 19:34:51', 43, 8),
(190, 8, 'Form Submit', '<strong>Someone Booked</strong> <br> <pSomeone Booked your Property</p><br> <p>Date: 2024-11-07 08:50:27</p>', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-07 00:50:27', '2024-11-07 21:04:39', 43, 10),
(191, 14, 'upcoming_stay', 'Your stay at sigma house starts in 1 days! Please be prepared for your check-in.', 0, NULL, '2024-11-07 19:31:11', '2024-11-07 19:31:11', 45, 8),
(192, 9, 'upcoming_stay', 'Your stay at house starts in 1 days! Please be prepared for your check-in.', 1, NULL, '2024-11-07 19:33:39', '2024-11-07 20:27:12', 43, 8),
(193, 8, 'warning', '<p>dsads paid you 40,000.00</p>', 1, NULL, '2024-11-07 20:18:03', '2024-11-07 21:12:03', NULL, 9),
(195, 9, 'review', '<strong>Your rent has ended</strong> <br> <p>Please leave a review for the property.</p>', 1, 'http://localhost/my-reviews', '2024-11-07 20:45:01', '2024-11-07 21:20:45', 43, 14),
(196, 10, 'review', '<strong>Your rent has ended</strong> <br> <p>Please leave a review for the property.</p>', 1, 'http://localhost/my-reviews', '2024-11-07 20:45:01', '2024-11-09 20:31:22', 43, 14),
(197, 8, 'Form Submit', '<strong>Someone Booked</strong> <br> <pSomeone Booked your Property</p><br> <p>Date: 2024-11-08 05:18:23</p>', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-07 21:18:23', '2024-11-07 21:20:25', 42, 9),
(198, 9, 'Form Response', 'Booking Form rejected', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-07 21:20:36', '2024-11-07 21:20:49', 42, 8),
(199, 9, 'Form Response', 'Booking Form approved', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-07 21:23:53', '2024-11-07 21:24:05', 42, 8),
(200, 8, 'Booking Cancellation', 'Booking Cancellation request', 0, 'http://127.0.0.1:8000/managetenant', '2024-11-07 21:24:11', '2024-11-07 21:24:11', 42, 9),
(201, 14, 'Cancel Response', 'Booking Cancellation Rejected', 0, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-07 21:27:07', '2024-11-07 21:27:07', 45, 8),
(202, 8, 'Form Submit', '<strong>Someone Booked</strong> <br> <pSomeone Booked your Property</p><br> <p>Date: 2024-11-08 05:30:06</p>', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-07 21:30:06', '2024-11-07 21:30:14', 43, 9),
(203, 9, 'Form Response', 'Booking Form rejected', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-07 21:30:28', '2024-11-07 21:30:32', 43, 8),
(204, 8, 'Booking Cancellation', 'Booking Cancellation request', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-07 21:31:17', '2024-11-07 21:31:22', 43, 9),
(205, 9, 'Cancel Response', 'Booking Cancellation Rejected', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-07 21:31:31', '2024-11-07 21:31:41', 43, 8),
(206, 8, 'Booking Cancellation', 'Booking Cancellation request', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-07 21:32:26', '2024-11-07 21:32:41', 43, 9),
(207, 9, 'Cancel Response', 'Booking Cancellation Rejected', 0, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-07 21:32:51', '2024-11-07 21:32:51', 43, 8),
(208, 8, 'Booking Cancellation', 'Booking Cancellation request', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-07 21:33:06', '2024-11-07 21:33:08', 43, 9),
(209, 9, 'Cancel Response', 'Booking Cancellation Approved', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-07 21:33:15', '2024-11-07 21:33:28', 43, 8),
(210, 43, 'Form Submit', '<strong>Someone Booked</strong> <br> <pSomeone Booked your Property</p><br> <p>Date: 2024-11-10 04:30:18</p>', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-09 20:30:18', '2024-11-09 20:32:30', 46, 10),
(211, 10, 'Form Response', 'Booking Form approved', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-09 20:30:34', '2024-11-09 20:30:39', 46, 43),
(212, 43, 'Booking Cancellation', 'Booking Cancellation request', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-09 20:33:03', '2024-11-09 20:33:07', 46, 10),
(213, 10, 'Cancel Response', 'Booking Cancellation Rejected', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-09 20:33:13', '2024-11-09 20:33:27', 46, 43),
(214, 43, 'Booking Cancellation', 'Booking Cancellation request', 0, 'http://127.0.0.1:8000/managetenant', '2024-11-09 20:34:08', '2024-11-09 20:34:08', 46, 10),
(215, 10, 'Cancel Response', 'Booking Cancellation Approved', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-09 20:35:21', '2024-11-09 20:35:43', 46, 43),
(216, 8, 'Form Submit', '<strong>Someone Booked</strong> <br> <pSomeone Booked your Property</p><br> <p>Date: 2024-11-10 04:36:44</p>', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-09 20:36:44', '2024-11-09 20:47:42', 42, 9),
(217, 9, 'Form Response', 'Booking Form approved', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-09 20:36:58', '2024-11-09 20:37:01', 42, 8),
(218, 8, 'warning', '<p>dsads paid you 40,000.00</p>', 0, NULL, '2024-11-09 20:42:29', '2024-11-09 20:42:29', NULL, 9),
(219, 9, 'upcoming_stay', '<p>Your stay at shane house starts in 6 days! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-09 20:49:33', '2024-11-09 20:49:41', 42, 8),
(220, 8, 'Form Submit', '<strong>Someone Booked</strong> <br> <pSomeone Booked your Property</p><br> <p>Date: 2024-11-12 06:42:13</p>', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-11 22:42:13', '2024-11-11 22:42:22', 47, 9),
(221, 8, 'Booking Cancellation', 'Booking Cancelled', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-11 22:44:53', '2024-11-11 22:45:06', 47, 9),
(222, 8, 'Form Submit', '<strong>Someone Booked</strong> <br> <pSomeone Booked your Property</p><br> <p>Date: 2024-11-12 06:52:12</p>', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-11 22:52:12', '2024-11-11 22:52:25', 47, 9),
(223, 14, 'Cancel Response', 'Booking Cancellation Rejected', 0, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-11 23:07:06', '2024-11-11 23:07:06', 43, 8),
(224, 9, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: bogo ka on tqtqtqt</p><br><p>Date: 2024-11-12 07:07:35</p>', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-11 23:07:35', '2024-11-11 23:07:41', 47, 8),
(225, 9, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at tqtqtqt has been successfully approved.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-12 07:08:38</p><p>We look forward to hosting you!</p>', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-11 23:08:38', '2024-11-11 23:08:48', 47, 8),
(226, 9, 'upcoming_stay', '<p>Your stay at tqtqtqt starts in 1 days! Please be prepared for your check-in.</p>', 0, NULL, '2024-11-11 23:09:06', '2024-11-11 23:09:06', 47, 8);

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
-- Table structure for table `property_views`
--

CREATE TABLE `property_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dorm_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_views`
--

INSERT INTO `property_views` (`id`, `user_id`, `dorm_id`, `created_at`, `updated_at`) VALUES
(1, 9, 43, '2024-09-30 00:30:10', '2024-09-30 00:30:10'),
(2, 9, 43, '2024-09-30 00:30:29', '2024-09-30 00:30:29'),
(3, 9, 42, '2024-09-30 00:33:51', '2024-09-30 00:33:51'),
(4, 8, 38, '2024-09-30 18:19:45', '2024-09-30 18:19:45'),
(5, 22, 43, '2024-09-30 18:38:14', '2024-09-30 18:38:14'),
(6, 8, 43, '2024-09-30 18:53:57', '2024-09-30 18:53:57'),
(7, 22, 34, '2024-10-03 00:25:40', '2024-10-03 00:25:40'),
(8, 8, 34, '2024-10-03 00:31:02', '2024-10-03 00:31:02'),
(9, 9, 34, '2024-10-03 00:36:31', '2024-10-03 00:36:31'),
(10, 9, 37, '2024-10-03 00:42:37', '2024-10-03 00:42:37'),
(11, 8, 27, '2024-10-03 21:09:45', '2024-10-03 21:09:45'),
(12, 8, 44, '2024-10-03 21:26:24', '2024-10-03 21:26:24'),
(13, 10, 44, '2024-10-03 21:35:31', '2024-10-03 21:35:31'),
(14, 9, 44, '2024-10-05 18:04:53', '2024-10-05 18:04:53'),
(15, 9, 38, '2024-10-17 01:42:28', '2024-10-17 01:42:28'),
(16, 8, 42, '2024-10-19 21:55:32', '2024-10-19 21:55:32'),
(17, 8, 45, '2024-10-19 22:51:40', '2024-10-19 22:51:40'),
(18, 9, 45, '2024-10-19 23:25:28', '2024-10-19 23:25:28');

-- --------------------------------------------------------

--
-- Table structure for table `rent_forms`
--

CREATE TABLE `rent_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `dorm_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `guest` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','active','approved','rejected','cancelled','completed') NOT NULL DEFAULT 'pending',
  `note` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rent_forms`
--

INSERT INTO `rent_forms` (`id`, `user_id`, `dorm_id`, `start_date`, `end_date`, `guest`, `total_price`, `status`, `note`, `created_at`, `updated_at`) VALUES
(34, 9, 45, '2024-11-08', '2024-11-30', 2, 30000.00, 'cancelled', 'dsada', '2024-10-20 00:08:36', '2024-10-22 00:22:11'),
(38, 9, 42, '2024-11-06', '2024-11-11', 1, 40000.00, 'cancelled', NULL, '2024-11-04 21:54:45', '2024-11-05 21:16:01'),
(39, 14, 45, '2024-11-09', '2024-11-16', 2, 3000.00, 'completed', NULL, '2024-11-07 07:30:55', '2024-11-07 21:27:08'),
(40, 14, 43, '2024-11-09', '2024-11-08', 2, 40000.00, 'approved', NULL, '2024-11-07 00:29:06', '2024-11-11 23:07:07'),
(41, 10, 43, '2024-11-09', '2024-11-07', 2, 20000.00, 'completed', NULL, '2024-11-07 00:50:27', '2024-11-07 20:45:01'),
(43, 9, 43, '2024-11-10', '2024-11-12', 2, 20000.00, 'cancelled', 'Issue with booking process', '2024-11-07 21:30:06', '2024-11-07 21:33:15'),
(44, 10, 46, '2024-11-12', '2024-11-16', 2, 1600.00, 'cancelled', 'Change of plans', '2024-11-09 20:30:18', '2024-11-09 20:35:22'),
(45, 9, 42, '2024-11-16', '2024-11-17', 2, 10000.00, 'cancelled', NULL, '2024-11-09 20:36:44', '2024-11-09 20:36:59'),
(46, 9, 47, '2024-11-13', '2024-11-17', 6, 48888.00, 'cancelled', 'Found a better place', '2024-11-11 22:42:13', '2024-11-11 22:44:54'),
(47, 9, 47, '2024-11-13', '2024-11-17', 5, 48888.00, 'approved', 'bogo ka', '2024-11-11 22:52:12', '2024-11-11 23:08:39');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reported_id` bigint(20) UNSIGNED NOT NULL,
  `reported_type` varchar(255) NOT NULL,
  `dorm_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reason` varchar(255) NOT NULL,
  `status` enum('pending','valid','invalid','') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `reported_id`, `reported_type`, `dorm_id`, `reason`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 9, 'user', 28, 'dsadasd', 'valid', '2024-11-02 23:00:07', '2024-11-06 02:27:05'),
(2, 8, 9, 'user', NULL, 'dsad', 'valid', '2024-11-02 23:03:45', '2024-11-06 02:15:04'),
(3, 8, 9, 'user', NULL, 'Inappropriate Content', 'valid', '2024-11-02 23:04:01', '2024-11-06 01:19:25'),
(4, 8, 9, 'user', NULL, 'Harassment', 'invalid', '2024-11-02 23:05:05', '2024-11-06 23:53:56'),
(14, 8, 8, 'property', 45, 'Unsafe Conditions', 'invalid', '2024-11-06 03:24:55', '2024-11-06 23:54:11'),
(15, 8, 8, 'property', 45, 'dsadasd', 'valid', '2024-11-06 04:07:40', '2024-11-06 04:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `dorm_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `dorm_id`, `rating`, `comments`, `created_at`, `updated_at`) VALUES
(1, 9, 44, 1, 'hoy boks', '2024-10-16 23:52:41', '2024-11-05 06:49:05'),
(3, 9, 44, 4, 'bogo', '2024-10-17 20:26:45', '2024-10-17 20:28:52'),
(4, 9, 43, 5, 'dasdasdasd', '2024-10-20 05:56:29', '2024-10-20 05:56:35'),
(5, 9, 34, 5, 'ghnthnfng', '2024-10-24 10:13:53', '2024-10-24 10:13:53'),
(8, 9, 43, NULL, NULL, '2024-11-07 20:45:01', '2024-11-07 20:45:01'),
(9, 10, 43, NULL, NULL, '2024-11-07 20:45:01', '2024-11-07 20:45:01');

-- --------------------------------------------------------

--
-- Table structure for table `roomchats`
--

CREATE TABLE `roomchats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `other_user_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `message_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roomchats`
--

INSERT INTO `roomchats` (`id`, `user_id`, `other_user_id`, `room_id`, `message_id`, `created_at`, `updated_at`) VALUES
(6, 9, 8, 1, 122, '2024-08-18 09:45:25', '2024-08-18 09:45:25'),
(7, 9, 8, 3, 125, '2024-08-18 10:49:59', '2024-08-18 10:49:59'),
(8, 9, 8, 4, 133, '2024-08-18 13:01:48', '2024-08-18 13:01:48'),
(9, 10, 8, 4, 167, '2024-08-22 05:22:14', '2024-08-22 05:22:14'),
(10, 10, 8, 3, 170, '2024-08-22 05:45:47', '2024-08-22 05:45:47'),
(11, 10, 8, 1, 177, '2024-08-26 08:36:31', '2024-08-26 08:36:31'),
(13, 9, 8, 5, 180, '2024-08-27 03:32:05', '2024-08-27 03:32:05'),
(16, 10, 8, 8, 198, '2024-09-10 03:25:42', '2024-09-10 03:25:42'),
(17, 10, 8, 7, 201, '2024-09-10 04:43:23', '2024-09-10 04:43:23'),
(18, 10, 8, 5, 236, '2024-09-18 02:17:05', '2024-09-18 02:17:05'),
(19, 22, 8, 6, 246, '2024-10-01 02:38:32', '2024-10-01 02:38:32');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `dorm_id` bigint(11) UNSIGNED NOT NULL,
  `number` varchar(255) DEFAULT NULL,
  `capacity` int(10) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `dorm_id`, `number`, `capacity`, `price`, `description`, `images`, `status`, `created_at`, `updated_at`) VALUES
(1, 42, 'Room 1', 2, 10000, NULL, '1723780320.jpg', 1, '2024-08-14 20:22:16', '2024-08-15 19:52:00'),
(2, 42, 'Room 2', NULL, NULL, NULL, NULL, 1, '2024-08-14 20:22:16', '2024-08-14 20:22:16'),
(3, 42, 'Room 3', 12, 10000, NULL, '1723716921.jpg', 1, '2024-08-14 20:22:16', '2024-08-15 02:15:21'),
(4, 42, 'Room 4', 6, 1000, NULL, NULL, 0, '2024-08-14 20:22:16', '2024-08-23 20:36:42'),
(5, 42, 'Room 5', NULL, NULL, NULL, NULL, 1, '2024-08-14 20:22:16', '2024-08-14 20:22:16'),
(6, 43, 'Room 1', 12, 10000, NULL, '1727316418.jpg', 1, '2024-09-04 01:52:50', '2024-09-25 18:06:58'),
(7, 43, 'Room 2', NULL, NULL, NULL, NULL, 1, '2024-09-04 01:52:50', '2024-09-04 01:52:50'),
(8, 43, 'Room 3', NULL, NULL, NULL, NULL, 1, '2024-09-04 01:52:50', '2024-09-04 01:52:50'),
(15, 38, '1', 2, 10000, NULL, '1727749976.jpg', 1, '2024-09-25 21:11:43', '2024-09-30 18:32:56'),
(16, 38, '3', NULL, NULL, NULL, NULL, 1, '2024-09-25 21:11:43', '2024-09-25 21:11:43'),
(17, 38, '5', NULL, NULL, NULL, NULL, 1, '2024-09-25 21:11:43', '2024-09-25 21:11:43'),
(18, 38, '4', NULL, NULL, NULL, NULL, 1, '2024-09-25 21:29:56', '2024-09-25 21:29:56'),
(22, 38, '5', NULL, NULL, NULL, NULL, 1, '2024-09-25 21:39:14', '2024-09-25 21:39:14'),
(25, 34, '1', 12, 12, NULL, '1727944416.jpg', 1, '2024-10-03 00:33:10', '2024-10-03 00:33:36'),
(26, 34, '3', NULL, NULL, NULL, NULL, 1, '2024-10-03 00:33:10', '2024-10-03 00:33:10'),
(27, 34, '5', NULL, NULL, NULL, NULL, 1, '2024-10-03 00:33:10', '2024-10-03 00:33:10'),
(28, 44, '1', 2, 1000, NULL, '1728020035.jpg', 1, '2024-10-03 21:26:35', '2024-10-03 21:33:55'),
(29, 44, '3', NULL, NULL, NULL, NULL, 1, '2024-10-03 21:26:35', '2024-10-03 21:26:35'),
(30, 44, '5', NULL, NULL, NULL, NULL, 1, '2024-10-03 21:26:35', '2024-10-03 21:26:35');

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
('HC9rhV6GVOv0Ljr9Ht6XzudxYzlRUHxdvTOa0Ouz', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicnRvOWJvcmw5QmZiSGJudXU3TEFObGdWSU9FS2tHN0g0RnBFV1Q2SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ub3RpZmljYXRpb25zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL25vdGlmaWNhdGlvbnMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O30=', 1731395347),
('PoSIKKtq9UpD7eTJmtMVKLj3TMsD5yeT6TCp0HjY', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV2w0aVlodEdOZjIzbGJCY1hHekxqdWVCb3VYQUxIbTE2QUV2blRRWiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL25vdGlmaWNhdGlvbnMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL25vdGlmaWNhdGlvbnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O30=', 1731395347);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `fb_id` bigint(20) DEFAULT NULL,
  `google_id` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT 0,
  `verify_status` tinyint(1) NOT NULL DEFAULT 0,
  `role` varchar(255) DEFAULT NULL,
  `strike` tinyint(4) NOT NULL DEFAULT 3,
  `note` longtext DEFAULT NULL,
  `email_verification_code` int(15) DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `phone`, `fb_id`, `google_id`, `profile_picture`, `address`, `remember_token`, `created_at`, `updated_at`, `active_status`, `verify_status`, `role`, `strike`, `note`, `email_verification_code`, `email_verified_at`) VALUES
(8, 'roland', 'rshan0418@gmail.com1', 'roland', '$2y$12$KAoWHQSf1WZlzzR9rz5mYuNJEUMifBnkXIG4E8oGzi5kHzP4uenvG', '12314134', 0, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', 'dasda12', NULL, '2024-07-18 23:37:48', '2024-11-06 23:40:14', 0, 1, 'owner', 3, 'Spam or scam', NULL, '2024-11-06 03:33:15'),
(9, 'dsads', 'russellcandilasa@gmail.com', 'rolando', '$2y$12$qJHoOqgn0jsnSk0QcV1qr.B/qc6Fnv7F2q.FsOMyfgUF5DHWHQcSK', '12314134', 0, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-07-28 03:30:53', '2024-11-05 07:00:59', 0, 0, 'tenant', 1, NULL, NULL, '2024-10-04 04:28:19'),
(10, 'rolanda', 'dsa@f.vo', 'dsadsa', '$2y$12$r0hZYWws2BeT2pzsNlwaAOHufzxu/t7vxho7AJMGfnbbSV3k27GPm', '12314134', 0, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-07-28 20:25:03', '2024-10-31 04:49:15', 0, 0, 'tenant', 3, NULL, NULL, '2024-10-04 05:35:18'),
(11, 'shane', 'dsa@f.vos', 'shane', '$2y$12$pfMTqwcBEoo7aXzeCe6HKeLT6vhdM4Bi0Xzqbpm0Y84flDKHNwxkm', '12314134', 0, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-08-09 21:04:44', '2024-09-15 21:14:21', 0, 0, 'tenant', 3, NULL, 0, NULL),
(13, 'rolands', 'rshan0418@gmail.coms', 'rolands', '$2y$12$4AL119LT4Dvr6TOP.4Euy.2ZR/nx0KVUPGuSV76JoHjAH9drGRSzS', '12314134', 0, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-08-09 22:30:36', '2024-11-01 20:19:59', 1, 0, 'tenant', 3, NULL, 730137, NULL),
(14, 'Lopez Roland Shane', 'lopezrolandshane@gmail.com', 'shaner', '$2y$12$KWBaHsB1eLFlGJ.2D.LF2O8u4qpNORuowbKP1xj0zcedchtSRZ81a', '12314134', 0, '107236937285983559710', 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-08-11 19:56:43', '2024-11-06 20:19:18', 0, 0, 'admin', 3, NULL, 796437, '2024-11-07 04:19:18'),
(22, 'Roland Shane Lopez', NULL, NULL, NULL, '090909090909', 1037565838296943, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-09-24 21:46:08', '2024-10-03 20:05:49', 0, 0, 'tenant', 3, NULL, NULL, '2024-10-04 04:05:49'),
(39, 'Roland  Lopez', 'rshan0418@gmail.com3', 'roland3', '$2y$12$hjICAtBMCq5irLmPaoVTW.G3TTUMG0wfLyM64D1VlbmEQVGrfKUFe', '12314134', NULL, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-10-27 20:43:48', '2024-10-27 20:45:43', 0, 0, 'tenant', 3, NULL, NULL, '2024-10-28 04:45:43'),
(42, 'shane lopez', 'rshan0418@gmail.com4', 'roland4', '$2y$12$fEgxFdQZneJ/TRzyafjlx.kgYZXU7HXbkHLQug5P5vepPrrixuWx2', '12314134', NULL, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-10-27 22:29:17', '2024-10-27 22:29:27', 0, 0, 'owner', 3, NULL, NULL, '2024-10-28 06:29:27'),
(43, 'Roland 1 Lopez', 'rshan0418@gmail.com13', 'roland13', '$2y$12$EAFOVb2bXUDBFt/U68D30uJpUllirWCQb1.Oc.4Y.P8bNYfLTZHYa', '12314134', NULL, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-10-28 01:19:17', '2024-10-28 01:46:02', 0, 1, 'owner', 3, NULL, NULL, '2024-10-28 09:46:02'),
(44, 'shane123', 'russellcandilasa@gmail.com3', 'dsa123', '$2y$12$2.tr.8.H7mEitAEFjQxTfONReN0Y3RTUefBkRjE2nRoAb1F6Es.l6', '12314134', NULL, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-10-28 01:22:09', '2024-10-28 01:22:33', 0, 0, 'tenant', 3, NULL, NULL, '2024-10-28 09:22:33'),
(46, 'Roland Shane Lopez123', 'rshan0418@gmail.com123', 'roland123', '$2y$12$60t3M74ElAw5RZBUcIv3Puh2lYnXOlfIRQIAxvocG91ZDsqgZgFKG', '12314134', NULL, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', 'Tres De Mayo', NULL, '2024-11-03 23:01:11', '2024-11-03 23:01:12', 0, 0, 'tenant', 3, NULL, 649363, NULL),
(51, 'Ro Shan', 'rshan0418@gmail.com', NULL, NULL, '090909090909', NULL, '107895499310321282475', 'profile_picture/0RUVxlvDG8p1m4EcyW2LlW1fG.jpg', 'Tres De Mayo', NULL, '2024-11-06 20:25:44', '2024-11-06 20:26:12', 0, 0, 'owner', 3, NULL, NULL, '2024-11-07 04:25:44'),
(52, 'Roland Shane Lopez', NULL, NULL, NULL, NULL, 1071441051576088, NULL, 'https://graph.facebook.com/v3.3/1071441051576088/picture', NULL, NULL, '2024-11-06 21:02:39', '2024-11-06 21:02:39', 0, 0, NULL, 3, NULL, NULL, NULL),
(53, 'Roland Shane Lopez65', 'rshan0418@gmail.com41', 'roland41', '$2y$12$4jL5CcPlmIDa8veDnyGDe.jZq9sLz.9KFyPY0vltqlKzh/AO9FK7S', '12314134', NULL, NULL, 'profile_picture/atIIuo2wOwszhr1zlgGsAge5u.png', 'purok 3 tres de mayo', NULL, '2024-11-06 22:13:53', '2024-11-06 22:14:15', 0, 0, 'tenant', 3, NULL, NULL, '2024-11-07 06:14:15');

-- --------------------------------------------------------

--
-- Table structure for table `verifications`
--

CREATE TABLE `verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `id_document` varchar(255) NOT NULL,
  `business_permit` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `note` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verifications`
--

INSERT INTO `verifications` (`id`, `user_id`, `id_document`, `business_permit`, `status`, `note`, `created_at`, `updated_at`) VALUES
(2, 10, 'owner_documents/valid_id/MMGf5nVJLsw2RdLcYeArMwyX6.jpg', 'owner_documents/business_permit/bJim9r1KYHlXN0J4Th5zpglrl.jpg', 'rejected', 'dsada', '2024-09-12 02:19:00', '2024-09-15 21:20:16'),
(4, 9, 'owner_documents/valid_id/MMGf5nVJLsw2RdLcYeArMwyX6.jpg', 'owner_documents/business_permit/bJim9r1KYHlXN0J4Th5zpglrl.jpg', 'rejected', 'dsada', '2024-09-15 00:34:08', '2024-09-15 21:19:39'),
(6, 9, 'owner_documents/valid_id/MMGf5nVJLsw2RdLcYeArMwyX6.jpg', 'owner_documents/business_permit/bJim9r1KYHlXN0J4Th5zpglrl.jpg', 'approved', NULL, '2024-09-15 21:58:58', '2024-09-15 22:14:00'),
(7, 9, 'owner_documents/valid_id/MMGf5nVJLsw2RdLcYeArMwyX6.jpg', 'owner_documents/business_permit/bJim9r1KYHlXN0J4Th5zpglrl.jpg', 'pending', NULL, '2024-09-15 22:00:13', '2024-09-15 22:35:54'),
(8, 9, 'owner_documents/valid_id/MMGf5nVJLsw2RdLcYeArMwyX6.jpg', 'owner_documents/business_permit/bJim9r1KYHlXN0J4Th5zpglrl.jpg', 'rejected', 'dsadsadsadsdaddsadsadsadsadsdihifweuirhweuiruiweeruiwefuidufbjwadfjfuiwfuweuirweuifwuifuiwefhsfsd', '2024-09-15 22:01:43', '2024-09-15 23:02:09'),
(9, 43, 'owner_documents/valid_id/MMGf5nVJLsw2RdLcYeArMwyX6.jpg', 'owner_documents/business_permit/bJim9r1KYHlXN0J4Th5zpglrl.jpg', 'approved', NULL, '2024-10-28 01:19:17', '2024-10-28 02:29:07'),
(10, 51, 'owner_documents/valid_id/8FogOHXdtOiviiSJYoCyRmSta.jpg', 'owner_documents/business_permit/YF1YNcITFeMsHw0fcA26tC7IC.jpg', 'approved', NULL, '2024-11-06 20:26:13', '2024-11-06 20:26:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billings`
--
ALTER TABLE `billings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billings_user_id_foreign` (`user_id`),
  ADD KEY `billings_rent_form_id_foreign` (`rent_form_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `chatrooms`
--
ALTER TABLE `chatrooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_rooms_user_id_foreign` (`user_id`),
  ADD KEY `chat_rooms_dorm_id_foreign` (`dorm_id`),
  ADD KEY `chat_rooms_message_id_foreign` (`message_id`),
  ADD KEY `chatrooms_other_user_id_foreign` (`other_user_id`);

--
-- Indexes for table `curse_words`
--
ALTER TABLE `curse_words`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `curse_words_word_unique` (`word`);

--
-- Indexes for table `dorms`
--
ALTER TABLE `dorms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dorms_user_id_foreign` (`user_id`);

--
-- Indexes for table `extend_requests`
--
ALTER TABLE `extend_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `extend_requests_form_id_foreign` (`form_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_user_id_foreign` (`user_id`),
  ADD KEY `favorites_dorm_id_foreign` (`dorm_id`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_user_id_foreign` (`user_id`),
  ADD KEY `messages_chat_room_id_foreign` (`dorm_id`),
  ADD KEY `messages_room_id_foreign` (`room_id`),
  ADD KEY `messages_rooms_id_foreign` (`rooms_id`),
  ADD KEY `messages_roomchat_foreign` (`chat_id`);

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
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_sender_id_foreign` (`sender_id`),
  ADD KEY `notifications_dorm_id_foreign` (`dorm_id`) USING BTREE;

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `property_views`
--
ALTER TABLE `property_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_views_user_id_foreign` (`user_id`),
  ADD KEY `property_views_dorm_id_foreign` (`dorm_id`);

--
-- Indexes for table `rent_forms`
--
ALTER TABLE `rent_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rent_forms_user_id_foreign` (`user_id`),
  ADD KEY `rent_forms_dorm_id_foreign` (`dorm_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_user_id_foreign` (`user_id`),
  ADD KEY `reports_dorm_id_foreign` (`dorm_id`),
  ADD KEY `reports_reported_id_foreign` (`reported_id`) USING BTREE;

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_dorm_id_foreign` (`dorm_id`);

--
-- Indexes for table `roomchats`
--
ALTER TABLE `roomchats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roomchats_user_id_foreign` (`user_id`),
  ADD KEY `roomchats_other_user_id_foreign` (`other_user_id`),
  ADD KEY `roomchats_room_id_foreign` (`room_id`),
  ADD KEY `roomchats_message_id_foreign` (`message_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `romm_foreign_key_dorm` (`dorm_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `verifications`
--
ALTER TABLE `verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verification_requests_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billings`
--
ALTER TABLE `billings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `chatrooms`
--
ALTER TABLE `chatrooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `curse_words`
--
ALTER TABLE `curse_words`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `dorms`
--
ALTER TABLE `dorms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `extend_requests`
--
ALTER TABLE `extend_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `property_views`
--
ALTER TABLE `property_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `rent_forms`
--
ALTER TABLE `rent_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roomchats`
--
ALTER TABLE `roomchats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billings`
--
ALTER TABLE `billings`
  ADD CONSTRAINT `billings_rent_form_id_foreign` FOREIGN KEY (`rent_form_id`) REFERENCES `rent_forms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `billings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chatrooms`
--
ALTER TABLE `chatrooms`
  ADD CONSTRAINT `chat_rooms_dorm_id_foreign` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_rooms_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`),
  ADD CONSTRAINT `chat_rooms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chatrooms_other_user_id_foreign` FOREIGN KEY (`other_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dorms`
--
ALTER TABLE `dorms`
  ADD CONSTRAINT `dorms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `extend_requests`
--
ALTER TABLE `extend_requests`
  ADD CONSTRAINT `extend_requests_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `rent_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_dorm_id_foreign` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_chat_room_id_foreign` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `chatrooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_roomchat_foreign` FOREIGN KEY (`chat_id`) REFERENCES `roomchats` (`id`),
  ADD CONSTRAINT `messages_rooms_id_foreign` FOREIGN KEY (`rooms_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_dorm_id_foreign` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_views`
--
ALTER TABLE `property_views`
  ADD CONSTRAINT `property_views_dorm_id_foreign` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `property_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rent_forms`
--
ALTER TABLE `rent_forms`
  ADD CONSTRAINT `rent_forms_dorm_id_foreign` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`),
  ADD CONSTRAINT `rent_forms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_dorm_id_foreign` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_reported_id_foreign` FOREIGN KEY (`reported_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_dorm_id_foreign` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roomchats`
--
ALTER TABLE `roomchats`
  ADD CONSTRAINT `roomchats_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`),
  ADD CONSTRAINT `roomchats_other_user_id_foreign` FOREIGN KEY (`other_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roomchats_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roomchats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `romm_foreign_key_dorm` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`);

--
-- Constraints for table `verifications`
--
ALTER TABLE `verifications`
  ADD CONSTRAINT `verification_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
