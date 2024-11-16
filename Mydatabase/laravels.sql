-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2024 at 08:31 AM
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
  `reference` longtext DEFAULT NULL,
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
(24, 9, 39, 1000.00, '2024-11-12', 'paid', NULL, NULL, NULL, '2024-11-10 07:40:15', '2024-11-10 07:40:15'),
(25, 9, 48, 20000.00, '2024-11-16', 'paid', 'Proof_of_Payment/1qfAAKGKfKnG8iOfnycg7bAuZ.png', 'credit_card', '2024-11-04 08:31:02', '2024-11-13 00:15:01', '2024-11-15 00:31:03'),
(26, 9, 46, 48888.00, '2024-11-17', 'pending', NULL, NULL, NULL, '2024-11-15 18:04:01', '2024-11-15 18:04:01'),
(28, 63, 51, 7200.00, '2024-11-21', 'paid', 'Proof_of_Payment/x1kKDeK3ttMZ9hfCSmkuBnaBe.jpg', 'credit_card', '2024-11-15 02:57:40', '2024-11-15 18:49:01', '2024-11-15 18:57:41');

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
(27, 8, 'roland12', 'dadssa', 'Teves, Vito, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25627836, 123.79611254, 10000.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1731732691_673824d39ec1a.jpg\\\",\\\"dorm_pictures\\\\\\/1731732692_673824d4d7438.jpg\\\",\\\"dorm_pictures\\\\\\/1731732693_673824d539d28.jpg\\\"]\"', 0, 0, 0, '2024-08-04 20:50:17', '2024-11-15 20:51:45'),
(28, 8, 'lando', 'dasdsa', 'Pakigne-Tubod Road, Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25610944, 123.80160570, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1731732531_67382433ac869.jpg\\\",\\\"dorm_pictures\\\\\\/1731732532_673824349c637.jpg\\\",\\\"dorm_pictures\\\\\\/1731732533_673824352615a.jpg\\\"]\"', 0, 0, 0, '2024-08-04 20:57:24', '2024-11-15 20:48:53'),
(29, 8, 'oli house', 'new house', 'Teves, Vito, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25475809, 123.79465342, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1731732441_673823d965007.jpg\\\",\\\"dorm_pictures\\\\\\/1731732442_673823da45287.jpg\\\",\\\"dorm_pictures\\\\\\/1731732442_673823dab9ffb.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:08:17', '2024-11-15 20:49:32'),
(30, 8, 'oli house1', 'new house', 'Caballero Street, Poblacion Ward I, Calajo-an, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.24352476, 123.79688501, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1731732413_673823bdb2203.jpg\\\",\\\"dorm_pictures\\\\\\/1731732414_673823bec63d8.jpg\\\",\\\"dorm_pictures\\\\\\/1731732415_673823bf29a41.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:08:33', '2024-11-15 20:50:01'),
(31, 8, 'oli house2', 'new house', 'Abla Street, Escala at Corona Del Mar, Pooc, Minglanilla, Cebu, Central Visayas, 6045, Pilipinas', 10.24191997, 123.81902933, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1731732341_67382375d4e47.jpg\\\",\\\"dorm_pictures\\\\\\/1731732343_6738237750415.jpg\\\",\\\"dorm_pictures\\\\\\/1731732343_67382377b5b93.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:08:46', '2024-11-15 20:45:44'),
(32, 8, 'oli house4', 'new house', 'Cebu South Road, Springwoods Country Homes Subdivision, Tunghaan, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.24344030, 123.79036188, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1731732297_673823491e21f.jpg\\\",\\\"dorm_pictures\\\\\\/1731732298_6738234a78a1b.jpg\\\",\\\"dorm_pictures\\\\\\/1731732298_6738234acf7f9.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:09:07', '2024-11-15 20:44:59'),
(33, 8, 'oli house4', 'new house', 'Cantibjang, Pakigne, Cebu, Central Visayas, 6046, Pilipinas', 10.25391349, 123.80512476, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1731732817_673825512f7b6.jpg\\\",\\\"dorm_pictures\\\\\\/1731732818_673825527dee4.jpg\\\",\\\"dorm_pictures\\\\\\/1731732818_67382552d4114.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:09:38', '2024-11-15 20:53:39'),
(34, 8, 'oli house5', 'new house', 'Teves, Vito, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25281551, 123.79328012, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1731732256_67382320065ba.jpg\\\",\\\"dorm_pictures\\\\\\/1731732257_67382321880cf.jpg\\\",\\\"dorm_pictures\\\\\\/1731732258_6738232209071.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:09:52', '2024-11-15 20:44:18'),
(35, 8, 'oli house6', 'new house', '\"Poblacion Ward II, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24296519, 123.79530813, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1731732202_673822ea864cf.jpg\\\",\\\"dorm_pictures\\\\\\/1731732206_673822eecb383.jpg\\\",\\\"dorm_pictures\\\\\\/1731732207_673822ef2d6c8.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:10:11', '2024-11-15 20:43:28'),
(36, 8, 'oli house7', 'new house', 'Tulay, Calajo-an, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.23761232, 123.79242182, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730113706_671f70aa9a7dd.jpg\\\",\\\"dorm_pictures\\\\\\/1730113707_671f70ab94107.jpg\\\",\\\"dorm_pictures\\\\\\/1730113707_671f70abe48dc.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:10:41', '2024-11-15 20:42:42'),
(37, 8, 'oli house8', 'new house', 'Lower Tiber, Poblacion Ward I, Calajo-an, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.24301798, 123.79877329, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730113679_671f708f975b2.jpg\\\",\\\"dorm_pictures\\\\\\/1730113680_671f7090c4483.jpg\\\",\\\"dorm_pictures\\\\\\/1730113681_671f7091262fb.jpg\\\"]\"', 0, 0, 0, '2024-08-04 21:11:21', '2024-11-15 20:42:13'),
(38, 8, 'roland44', 'ewqewqe', 'Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25273105, 123.80246401, 1200.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730113634_671f7062789a5.jpg\\\",\\\"dorm_pictures\\\\\\/1730113636_671f706421aca.jpg\\\",\\\"dorm_pictures\\\\\\/1730113636_671f70646f810.jpg\\\"]\"', 0, 0, 0, '2024-08-08 01:35:26', '2024-11-15 20:41:41'),
(42, 8, 'shane house', 'cool', 'Tres de Mayo Street, Poblacion Ward IV, Vito, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.24546739, 123.79310846, 10000.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730113609_671f704929945.jpg\\\",\\\"dorm_pictures\\\\\\/1730113610_671f704a3fac4.jpg\\\",\\\"dorm_pictures\\\\\\/1730113610_671f704a98cc3.jpg\\\"]\"', 0, 1, 0, '2024-08-14 20:22:16', '2024-11-15 20:41:19'),
(43, 8, 'house', 'dsadsa', 'Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25425133, 123.80263567, 10000.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1730113501_671f6fdde8aba.jpg\\\",\\\"dorm_pictures\\\\\\/1730113503_671f6fdf142d3.jpg\\\",\\\"dorm_pictures\\\\\\/1730113503_671f6fdf62b6a.jpg\\\"]\"', 0, 0, 0, '2024-09-04 01:52:50', '2024-11-15 20:40:32'),
(44, 8, 'inday house', 'vbeebbe', 'Poblacion Ward IV, Vito, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.24521401, 123.79225016, 5000.00, 2, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1731732761_67382519cdeae.jpg\\\",\\\"dorm_pictures\\\\\\/1731732762_6738251ab9d2b.jpg\\\",\\\"dorm_pictures\\\\\\/1731732763_6738251b1ed07.jpg\\\"]\"', 0, 0, 0, '2024-07-31 21:26:15', '2024-11-15 20:52:43'),
(45, 8, 'sigma house', 'dsadfsadwdfgwef', '\"Pakigne-Tubod Road, Cantibjang, Pakigne, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25138321, 123.80551338, 10000.00, 3, 4, 2, '\"[\\\"dorm_pictures\\\\\\/1730165435_67203abb8e6be.jpg\\\",\\\"dorm_pictures\\\\\\/1730165457_67203ad1a29db.jpg\\\",\\\"dorm_pictures\\\\\\/1730167717_672043a504546.jpg\\\",\\\"dorm_pictures\\\\\\/1730176504_672065f84f853.jpg\\\",\\\"dorm_pictures\\\\\\/1730176514_6720660230af8.jpg\\\",\\\"dorm_pictures\\\\\\/1730176514_67206602e6f49.jpg\\\"]\"', 0, 0, 1, '2024-10-19 22:46:29', '2024-11-11 18:34:02'),
(46, 43, 'rolando house', 'dsadasdasdi;ohefgjirfgbjkl', '\"Poblacion Ward III, Pakigne, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25118869, 123.80209143, 400.00, 3, 12, 12, '\"[\\\"dorm_pictures\\\\\\/1730111654_671f68a63a93c.jpg\\\",\\\"dorm_pictures\\\\\\/1730111655_671f68a7df5e3.jpg\\\",\\\"dorm_pictures\\\\\\/1730111656_671f68a856f7c.jpg\\\"]\"', 0, 0, 1, '2024-10-28 02:34:16', '2024-11-15 21:11:05'),
(47, 8, 'tqtqtqt', 'rtioijfgjklgfgfkl', 'Cebu South Road, Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25221373, 123.80712032, 12222.00, 12, 3, 2, '\"[\\\"dorm_pictures\\\\\\/1731382231_6732cbd730855.jpg\\\",\\\"dorm_pictures\\\\\\/1731382236_6732cbdc30bdc.jpg\\\",\\\"dorm_pictures\\\\\\/1731382236_6732cbdc96a1e.jpg\\\"]\"', 1, 1, 0, '2024-11-11 19:30:36', '2024-11-15 20:54:24'),
(48, 62, 'olis house', 'nice housedsaddasdadadadadasdasdasdasdce housedsaddasdadadadadasdasdasdasdce housedsaddasdadadadadasdasdasdasdce housedsaddasdadadadadasdasdasdasd', 'Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25053508, 123.80311847, 1200.00, 2, 4, 3, '\"[\\\"dorm_pictures\\\\\\/1731719073_6737efa1200ef.jpg\\\",\\\"dorm_pictures\\\\\\/1731719074_6737efa28e7ca.jpg\\\",\\\"dorm_pictures\\\\\\/1731719075_6737efa30a314.jpg\\\"]\"', 0, 0, 0, '2024-11-15 17:04:35', '2024-11-15 19:31:57');

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
(37, 10, 43, '2024-11-07 00:15:57', '2024-11-07 00:15:57'),
(38, 63, 48, '2024-11-15 19:41:26', '2024-11-15 19:41:26');

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
(201, 14, 'Cancel Response', 'Booking Cancellation Rejected', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-07 21:27:07', '2024-11-14 22:37:51', 45, 8),
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
(222, 8, 'Form Submit', '<strong>Someone Booked</strong> <br> <pSomeone Booked your Property</p><br> <p>Date: 2024-11-12 06:52:12</p>', 1, 'http://127.0.0.1:8000/managetenant', '2024-11-11 22:52:12', '2024-11-13 00:09:07', 47, 9),
(223, 14, 'Cancel Response', 'Booking Cancellation Rejected', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-11 23:07:06', '2024-11-14 22:38:54', 43, 8),
(224, 9, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: bogo ka on tqtqtqt</p><br><p>Date: 2024-11-12 07:07:35</p>', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-11 23:07:35', '2024-11-11 23:07:41', 47, 8),
(225, 9, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at tqtqtqt has been successfully approved.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-12 07:08:38</p><p>We look forward to hosting you!</p>', 1, 'http://127.0.0.1:8000/user/rent-forms', '2024-11-11 23:08:38', '2024-11-11 23:08:48', 47, 8),
(226, 9, 'upcoming_stay', '<p>Your stay at tqtqtqt starts in 1 days! Please be prepared for your check-in.</p>', 0, NULL, '2024-11-11 23:09:06', '2024-11-11 23:09:06', 47, 8),
(228, 8, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation house</p><br> <p>Date: 2024-11-13 08:08:57</p>', 1, 'http://localhost:8000/managetenant', '2024-11-13 00:08:57', '2024-11-14 18:10:41', 43, 9),
(229, 9, 'upcoming_stay', '<p>Your stay at tqtqtqt starts in 1 days! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-13 00:12:37', '2024-11-13 00:13:40', 47, 8),
(230, 9, 'upcoming_stay', '<p>Your stay at house starts in 1 days! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-13 00:13:18', '2024-11-13 00:13:25', 43, 8),
(232, 9, 'Bills', '<strong>Payment Reminder</strong><br><p>The owner has sent a notification regarding your upcoming payment.</p><br><p>Date: 2024-11-15 02:43:54</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-14 18:43:54', '2024-11-14 18:44:17', 43, 8),
(233, 9, 'Bills', '<strong>Payment Reminder</strong><br><p>The owner has sent a notification regarding your upcoming payment.</p><br><p>Date: 2024-11-15 02:46:42</p>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-14 18:46:42', '2024-11-14 18:46:42', 43, 8),
(234, 9, 'Bills', '<strong>Payment Reminder</strong><br><p>The owner has sent a notification regarding your upcoming payment.</p><br><p>Date: 2024-11-15 02:49:00</p>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-14 18:49:00', '2024-11-14 18:49:00', 43, 8),
(235, 9, 'Bills', '<strong>Payment Reminder</strong><br><p>The owner has sent a notification regarding your upcoming payment.</p><br><p>Date: 2024-11-15 02:52:08</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-14 18:52:08', '2024-11-14 18:52:11', 43, 8),
(236, 9, 'Bills', '<strong>Payment Reminder</strong><br><p>The owner has sent a notification regarding your upcoming payment.</p><br><p>Date: 2024-11-15 02:55:56</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-14 18:55:56', '2024-11-14 18:56:05', 43, 8),
(237, 9, 'Cancel Response', 'Booking Cancellation Rejected', 1, 'http://localhost:8000/user/rent-forms', '2024-11-14 19:00:24', '2024-11-14 19:00:36', 47, 8),
(238, 9, 'upcoming_stay', '<p>Your stay at tqtqtqt starts in -1 days! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-14 19:00:52', '2024-11-14 19:01:00', 47, 8),
(239, 8, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Found a better place on house</p><br><p>Date: 2024-11-15 03:27:22</p>', 1, 'http://localhost:8000/managetenant', '2024-11-14 19:27:22', '2024-11-14 19:27:50', 43, 9),
(240, 9, 'Cancel Response', '<strong>Booking Cancellation Rejected</strong> - Unfortunately, your request to cancel has been declined.<br>\n                            <small>Sent on 2024-11-15 03:28:11</small> <span style=\"color: gray;\">[Booking Update]</span>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-14 19:28:11', '2024-11-14 19:28:26', 43, 8),
(241, 8, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: dili ko ani on house</p><br><p>Date: 2024-11-15 03:31:57</p>', 1, 'http://localhost:8000/managetenant', '2024-11-14 19:31:57', '2024-11-14 19:32:05', 43, 9),
(242, 9, 'Cancellation Response', '<strong>Booking Cancellation Rejected</strong> - Unfortunately, your request to cancel has been declined.<br>\n                            <small>Sent on 2024-11-15 03:34:04', 1, 'http://localhost:8000/user/rent-forms', '2024-11-14 19:34:04', '2024-11-14 19:34:35', 43, 8),
(243, 8, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Financial reasons on house</p><br><p>Date: 2024-11-15 03:34:19</p>', 1, 'http://localhost:8000/managetenant', '2024-11-14 19:34:19', '2024-11-14 19:34:23', 43, 9),
(244, 9, 'Cancellation Response', '<strong>Booking Cancellation Rejected</strong> - Unfortunately, your request to cancel has been declined.<br>\n                            <small>Sent on 2024-11-15 03:34:47', 0, 'http://localhost:8000/user/rent-forms', '2024-11-14 19:34:47', '2024-11-14 19:34:47', 43, 8),
(245, 8, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Financial reasons on house</p><br><p>Date: 2024-11-15 03:36:47</p>', 1, 'http://localhost:8000/managetenant', '2024-11-14 19:36:47', '2024-11-14 19:36:50', 43, 9),
(246, 9, 'Cancellation Response', '<strong>Booking Cancellation Rejected</strong> <p> - Unfortunately, your request to cancel has been declined.<p/> <br>\n                            <small>Sent on 2024-11-15 03:37:04', 0, 'http://localhost:8000/user/rent-forms', '2024-11-14 19:37:04', '2024-11-14 19:37:04', 43, 8),
(247, 8, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Financial reasons on house</p><br><p>Date: 2024-11-15 03:39:05</p>', 1, 'http://localhost:8000/managetenant', '2024-11-14 19:39:05', '2024-11-14 19:39:10', 43, 9),
(255, 8, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Financial reasons on house</p><br><p>Date: 2024-11-15 04:26:34</p>', 1, 'http://localhost:8000/managetenant', '2024-11-14 20:26:34', '2024-11-14 20:26:39', 43, 9),
(256, 9, 'Cancellation Response', '<strong>Booking Cancellation Rejected</strong><p>Unfortunately, your request to cancel has been declined.</p><br>\n                           <small>Sent on 2024-11-15 04:26:44</small>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-14 20:26:44', '2024-11-14 20:26:44', 43, 8),
(257, 8, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Personal reasons on house</p><br><p>Sent on 2024-11-15 04:28:17</p>', 1, 'http://localhost:8000/managetenant', '2024-11-14 20:28:17', '2024-11-14 20:28:24', 43, 9),
(258, 9, 'Cancellation Response', '<strong>Booking Cancellation Rejected</strong><p>Unfortunately, your request to cancel has been declined.</p><br>\n                           <p>Sent on 2024-11-15 04:28:30</p>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-14 20:28:30', '2024-11-14 20:28:30', 43, 8),
(259, 8, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Financial reasons on house</p><br><p>Sent on 2024-11-15 04:31:44</p>', 1, 'http://localhost:8000/managetenant', '2024-11-14 20:31:44', '2024-11-14 20:31:49', 43, 9),
(260, 9, 'Cancellation Response', '<strong>Booking Cancellation Rejected</strong><br><p>Unfortunately, your request to cancel has been declined.</p><br>\n                           <p>Sent on 2024-11-15 04:31:58</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-14 20:31:58', '2024-11-14 23:26:59', 43, 8),
(261, 8, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Personal reasons on house</p><br><p>Sent on 2024-11-15 04:33:47</p>', 1, 'http://localhost:8000/managetenant', '2024-11-14 20:33:47', '2024-11-14 20:33:52', 43, 9),
(262, 9, 'Cancellation Response', '<strong>Booking Cancellation Rejected</strong><br><p>Unfortunately, your request to cancel has been declined.</p><br>\n                           <p>Sent on 2024-11-15 04:33:57</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-14 20:33:57', '2024-11-14 23:22:59', 43, 8),
(263, 8, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Found a better place on house</p><br><p>Sent on 2024-11-15 04:36:42</p>', 1, 'http://localhost:8000/managetenant', '2024-11-14 20:36:42', '2024-11-14 20:36:47', 43, 9),
(264, 9, 'Cancellation Response', '<strong>Booking Cancellation Rejected</strong><br><p>Unfortunately, your request to cancel has been declined.</p><br><p>Sent on2024-11-15 04:36:51</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-14 20:36:51', '2024-11-14 20:36:57', 43, 8),
(265, 8, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Personal reasons on house</p><br><p>Sent on 2024-11-15 04:38:00</p>', 1, 'http://localhost:8000/managetenant', '2024-11-14 20:38:00', '2024-11-14 20:38:06', 43, 9),
(266, 9, 'Cancellation Response', '<strong>Booking Cancellation Approved</strong><br><p>Your request to cancel has been processed successfully.</p><br><p>Sent on2024-11-15 04:38:17</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-14 20:38:17', '2024-11-14 23:22:50', 43, 8),
(269, 9, 'warning', '<strong>Complaint Response:</strong> <br> <p> We have reviewed your report, and after careful consideration, we have determined that the complaint is invalid. The property remains active.</p>', 1, NULL, '2024-11-14 23:23:19', '2024-11-14 23:23:45', NULL, 14),
(270, 9, 'warning', '<strong>Complaint Review - Action Taken:</strong> <br> <p> Your report has been reviewed, and a warning has been issued to the user for the following reason: <strong>bayut ang user</strong></p> <p>Please monitor the situation to ensure compliance.</p>', 1, NULL, '2024-11-14 23:24:11', '2024-11-14 23:27:13', NULL, 14),
(271, 8, 'warning', '<strong>Warning Notification:</strong> <br> <p> You have been issued a warning due to the following reason: <strong>bayut ang user</strong></p> <p>Please take immediate action to rectify the situation. Continued violations may lead to further actions.</p>', 1, NULL, '2024-11-14 23:24:11', '2024-11-14 23:27:36', NULL, 14),
(272, 9, 'warning', '<strong>Complaint Response:</strong> <br> <p> We have reviewed your report and have deactivated the property due to the following reason: <strong>gago ang tag iya</strong></p>', 0, NULL, '2024-11-14 23:34:43', '2024-11-14 23:34:43', NULL, 14),
(273, 8, 'warning', '<strong>Action Taken on Your Property:</strong> <br> <p> Your property has been deactivated due to the following reason: <strong>gago ang tag iya</strong></p>', 1, NULL, '2024-11-14 23:34:45', '2024-11-14 23:34:54', NULL, 14),
(274, 9, 'warning', '<strong>Complaint Review - Action Taken:</strong> <br> <p> Your report has been reviewed, and a warning has been issued to the user for the following reason: <strong>bayut ang user</strong></p> <p>Please monitor the situation to ensure compliance.</p>', 0, NULL, '2024-11-14 23:37:50', '2024-11-14 23:37:50', NULL, 14),
(275, 8, 'warning', '<strong>Warning Notification:</strong> <br> <p> You have been issued a warning due to the following reason: <strong>bayut ang user</strong></p> <p>Please take immediate action to rectify the situation. Continued violations may lead to further actions.</p> <br><strong>You have 1 remaining Strike</strong>', 1, NULL, '2024-11-14 23:37:51', '2024-11-14 23:38:03', NULL, 14),
(276, 9, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at <strong>tqtqtqt</strong> has been successfully approved.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-15 08:01:14</p><p>We look forward to hosting you!</p>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-15 00:01:14', '2024-11-15 00:01:14', 47, 8),
(277, 9, 'Cancellation Response', '<strong>Booking Cancellation Rejected</strong><br><p>Unfortunately, your request to cancel has been declined.</p><br><p>Sent on2024-11-15 08:02:55</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-15 00:02:55', '2024-11-15 00:26:45', 47, 8),
(278, 9, 'Bills', '<strong>Payment Reminder</strong><br>\n           <p>Your Payment has been marked paid. You paid <strong>₱0.00</strong> \n           on <strong>house</strong></p><br>\n           <p>Paid on: <strong>2024-11-16 08:28:11</strong></p>\n           <p>Mode of Payment: <strong>e_wallet</strong></p>\n           <br><p>Sent on: 2024-11-15 08:28:15</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-15 00:28:15', '2024-11-15 00:29:34', 43, 8),
(279, 9, 'Bills', '<strong>Payment Reminder</strong><br><p>Your Payment has been marked paid. You paid <strong>₱20,000.00</strong> on <strong>house</strong></p><br><p>Paid on: <strong>2024-11-04 08:31:02</strong></p><p>Mode of Payment: <strong>credit_card</strong></p><br><p>Sent on: 2024-11-15 08:31:03</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-15 00:31:03', '2024-11-15 00:31:10', 43, 8),
(287, 14, 'Bills', '<strong>User Verification Pending</strong><br><p>A user has registered as an owner and is awaiting verification. Please review their application.</p><p><strong>User:</strong> shane lopez</p><p><strong>Email:</strong> nokielopez@gmail.com</p><p><strong>Registered on:</strong> 2024-11-16 00:59:11</p><br><p>Sent on: 2024-11-16 01:01:03</p>', 1, 'http://localhost:8000/managepage/user', '2024-11-15 17:01:03', '2024-11-15 17:01:13', NULL, 62),
(288, 62, 'verification', '<strong>Account Verified</strong><br><p>Your account has been verified. You can now proceed to post or list accommodations for rent.</p><br><p>Sent on 2024-11-16 01:01:53</p>', 1, NULL, '2024-11-15 17:01:53', '2024-11-15 17:02:09', NULL, 14),
(289, 62, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation <strong>olis house</strong></p><br> <p>Date: 2024-11-16 01:09:42</p>', 1, 'http://localhost:8000/managetenant', '2024-11-15 17:09:42', '2024-11-15 17:09:46', 48, 63),
(290, 62, 'Booking Cancellation', '<strong>Booking Cancellation</strong><br><p>Booking Cancelled due to: Personal reasons on <strong>olis house</strong></p><br><p>Sent on2024-11-16 01:10:20</p>', 1, 'http://localhost:8000/managetenant', '2024-11-15 17:10:20', '2024-11-15 17:10:25', 48, 63),
(291, 62, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation <strong>olis house</strong></p><br> <p>Date: 2024-11-16 01:11:38</p>', 1, 'http://localhost:8000/managetenant', '2024-11-15 17:11:38', '2024-11-15 17:11:43', 48, 63),
(292, 63, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: youre a dirty little nigger on olis house</p><br><p>Date: 2024-11-16 01:12:49</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-15 17:12:49', '2024-11-15 17:12:53', 48, 62),
(293, 62, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation <strong>olis house</strong></p><br> <p>Date: 2024-11-16 01:13:18</p>', 1, 'http://localhost:8000/managetenant', '2024-11-15 17:13:18', '2024-11-15 17:13:23', 48, 63),
(294, 63, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at <strong>olis house</strong> has been successfully approved.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-16 01:13:50</p><p>We look forward to hosting you!</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-15 17:13:50', '2024-11-15 17:13:53', 48, 62),
(295, 63, 'upcoming_stay', '<p>Your stay at olis house starts in 1 days! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-15 17:16:29', '2024-11-15 17:16:34', 48, 62),
(296, 62, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Personal reasons on <strong>olis house</strong></p><br><p>Sent on 2024-11-16 02:03:30</p>', 1, 'http://localhost:8000/managetenant', '2024-11-15 18:03:30', '2024-11-15 18:03:37', 48, 63),
(297, 63, 'Cancellation Response', '<strong>Booking Cancellation Rejected</strong><br><p>Unfortunately, your request for cancellation has been declined.</p><br><p>Sent on2024-11-16 02:03:44</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-15 18:03:44', '2024-11-15 18:03:49', 48, 62),
(298, 9, 'Booking Start', '<strong>Booking started</strong><br><p>Your booking for <strong>tqtqtqt</strong> has started successfully.</p><br><p>Bill Amount: <strong>₱0.00</strong></p><p>Billing Date: <strong>2024-11-17</strong></p><br><p>Date: 2024-11-16 02:04:01</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-15 18:04:01', '2024-11-15 22:38:00', 47, 14),
(299, 63, 'Booking Start', '<strong>Booking started</strong><br><p>Your booking for <strong>olis house</strong> has started successfully.</p><br><p>Bill Amount: <strong>₱0.00</strong></p><p>Billing Date: <strong>2024-11-23</strong></p><br><p>Date: 2024-11-16 02:04:02</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-15 18:04:02', '2024-11-15 18:05:22', 48, 14),
(300, 63, 'upcoming_stay', '<p>Your stay at olis house starts in 2 days! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-15 18:32:14', '2024-11-15 18:32:17', 48, 62),
(301, 63, 'upcoming_stay', '<p>Your stay at olis house starts in 2 days! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-15 18:35:56', '2024-11-15 18:36:03', 48, 62),
(302, 63, 'upcoming_stay', '<p>Your stay at olis house starts in 2 days! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-15 18:38:05', '2024-11-15 18:38:34', 48, 62),
(303, 63, 'upcoming_stay', '<p>Your stay at olis house starts in 1.8898022762153 days! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-15 18:38:41', '2024-11-15 18:41:50', 48, 62),
(304, 63, 'upcoming_stay', '<p>Your stay at olis house starts in 1 day! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-15 18:41:59', '2024-11-15 18:42:07', 48, 62),
(305, 63, 'upcoming_stay', '<p>Your stay at olis house starts in 0 day! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-15 18:42:21', '2024-11-15 18:44:24', 48, 62),
(306, 63, 'upcoming_stay', '<p>Your stay at olis house starts in 0 day! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-15 18:44:33', '2024-11-15 18:44:40', 48, 62),
(307, 63, 'upcoming_stay', '<p>Your stay at olis house starts in 21 hours! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-15 18:45:13', '2024-11-15 18:45:19', 48, 62),
(308, 63, 'upcoming_stay', '<p>Your stay at olis house starts in 1 day! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-15 18:45:41', '2024-11-15 18:45:44', 48, 62),
(309, 63, 'upcoming_stay', '<p>Your stay at olis house starts today! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-15 18:47:56', '2024-11-15 18:48:02', 48, 62),
(310, 63, 'Booking Start', '<strong>Booking started</strong><br><p>Your booking for <strong>olis house</strong> has started successfully.</p><br><p>Bill Amount: <strong>₱7,200.00</strong></p><p>Billing Date: <strong>2024-11-21</strong></p><br><p>Sent on: 2024-11-16 02:49:01</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-15 18:49:01', '2024-11-15 18:49:06', 48, 14),
(311, 63, 'Bills', '<strong>Payment Reminder</strong><br><p>Your Payment has been marked paid. You paid <strong>₱7,200.00</strong> on <strong>olis house</strong></p><br><p>Paid on: <strong>2024-11-15 02:57:40</strong></p><p>Mode of Payment: <strong>credit_card</strong></p><br><p>Sent on: 2024-11-16 02:57:41</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-15 18:57:41', '2024-11-15 18:57:44', 48, 62),
(312, 63, 'review', '<strong>Your rent has ended</strong> <br> <p>Your rent has ended on Olis housePlease leave a review for the Accomodation.</p><br><p>Sent on: 2024-11-16 03:03:01</p>', 1, 'http://localhost:8000/my-reviews', '2024-11-15 19:03:01', '2024-11-15 19:04:04', 48, 14),
(313, 63, 'warning', '<strong>Warning issued:</strong> <br> <p>Your review contains inappropriate words.</p> <br><strong>You have 2 remaining Strike(s)</strong>', 1, NULL, '2024-11-15 19:05:11', '2024-11-15 19:05:19', NULL, 63),
(314, 63, 'warning', '<strong>Complaint Response:</strong> <br> <p> We have reviewed your report, and after careful consideration, we have determined that the complaint is invalid. The property remains active.</p>', 1, NULL, '2024-11-15 19:07:49', '2024-11-15 19:08:01', NULL, 14),
(315, 14, 'Reported', '<strong>Report Complaint</strong><p>A user has reported a complaint regarding the accommodation: <strong>olis house</strong>. Please review the report and take the necessary actions.</p>', 1, 'http://localhost:8000/reports/fetch', '2024-11-15 19:17:10', '2024-11-15 19:17:16', NULL, 63),
(316, 63, 'warning', '<strong>Complaint Response:</strong> <br> <p> We have reviewed your report, and after careful consideration, we have determined that the complaint is invalid. The property remains active.</p>', 1, NULL, '2024-11-15 19:18:38', '2024-11-15 19:18:41', NULL, 14),
(317, 14, 'Reported', '<strong>Report Complaint</strong><p>A user has reported a complaint regarding the accommodation: <strong>olis house</strong>. Please review the report and take the necessary actions.</p>', 1, 'http://localhost:8000/reports', '2024-11-15 19:18:51', '2024-11-15 19:19:24', NULL, 63),
(318, 63, 'warning', '<strong>Complaint Response:</strong> <br> <p> We have reviewed your report and have deactivated the property due to the following reason: <strong>Illegal Activities</strong></p>', 1, NULL, '2024-11-15 19:24:33', '2024-11-15 19:24:38', NULL, 14),
(319, 62, 'warning', '<strong>Action Taken on Your Property:</strong> <br> <p> Your property has been deactivated due to the following reason: <strong>Illegal Activities</strong></p>', 1, NULL, '2024-11-15 19:24:34', '2024-11-15 19:25:08', NULL, 14),
(320, 14, 'Reported', '<strong>Report Complaint</strong><p>A user has reported a complaint regarding a user: <strong>shane lopez</strong>. Please review the report and take the necessary actions.</p>', 1, 'http://localhost:8000/reports', '2024-11-15 19:33:45', '2024-11-15 19:33:48', NULL, 63),
(321, 63, 'warning', '<strong>Complaint Response:</strong> <br> <p> We have reviewed your complaint and, after careful consideration, we have determined that it is invalid. However, the reported user will be placed under observation for further monitoring. No immediate action has been taken, but we will continue to monitor the situation.</p>', 1, NULL, '2024-11-15 19:34:04', '2024-11-15 19:34:13', NULL, 14),
(322, 14, 'Reported', '<strong>Report Complaint</strong><p>A user has reported a complaint regarding a user: <strong>shane lopez</strong>. Please review the report and take the necessary actions.</p>', 1, 'http://localhost:8000/reports', '2024-11-15 19:34:39', '2024-11-15 19:34:43', NULL, 63),
(323, 63, 'warning', '<strong>Complaint Review - Action Taken:</strong> <br> <p> Your report has been reviewed, and a warning has been issued to the user for the following reason: <strong>Inappropriate Content</strong></p> <p>Please monitor the situation to ensure compliance.</p>', 1, NULL, '2024-11-15 19:34:50', '2024-11-15 19:34:55', NULL, 14),
(324, 62, 'warning', '<strong>Warning Notification:</strong> <br> <p> You have been issued a warning due to the following reason: <strong>Inappropriate Content</strong></p> <p>Please take immediate action to rectify the situation. Continued violations may lead to further actions.</p> <br><strong>You have 2 remaining Strike</strong>', 1, NULL, '2024-11-15 19:34:51', '2024-11-15 19:35:06', NULL, 14),
(325, 43, 'warning', '<strong>Accomodation Deactivated</strong> <br> <p> Your Accomodation has been Deactivated due to:Misleading information</p>', 1, NULL, '2024-11-15 21:11:04', '2024-11-15 21:12:11', 46, 14);

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
(18, 9, 45, '2024-10-19 23:25:28', '2024-10-19 23:25:28'),
(19, 9, 36, '2024-11-12 18:07:39', '2024-11-12 18:07:39'),
(20, 9, 46, '2024-11-12 18:50:08', '2024-11-12 18:50:08'),
(21, 63, 48, '2024-11-15 17:09:16', '2024-11-15 17:09:16'),
(22, 63, 43, '2024-11-15 19:41:40', '2024-11-15 19:41:40'),
(23, 9, 48, '2024-11-15 21:59:06', '2024-11-15 21:59:06'),
(24, 9, 31, '2024-11-15 22:34:05', '2024-11-15 22:34:05'),
(25, 46, 48, '2024-11-15 23:14:00', '2024-11-15 23:14:00');

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
(38, 9, 42, '2024-11-06', '2024-11-11', 1, 40000.00, 'completed', NULL, '2024-11-04 21:54:45', '2024-11-05 21:16:01'),
(39, 14, 45, '2024-11-09', '2024-11-16', 2, 3000.00, 'completed', NULL, '2024-11-07 07:30:55', '2024-11-07 21:27:08'),
(40, 14, 43, '2024-11-09', '2024-11-08', 2, 40000.00, 'completed', NULL, '2024-11-07 00:29:06', '2024-11-11 23:07:07'),
(41, 10, 43, '2024-11-09', '2024-11-07', 2, 20000.00, 'cancelled', NULL, '2024-11-07 00:50:27', '2024-11-07 20:45:01'),
(43, 9, 43, '2024-11-10', '2024-11-12', 2, 20000.00, 'cancelled', 'Issue with booking process', '2024-11-07 21:30:06', '2024-11-07 21:33:15'),
(44, 10, 46, '2024-11-12', '2024-11-16', 2, 1600.00, 'cancelled', 'Change of plans', '2024-11-09 20:30:18', '2024-11-09 20:35:22'),
(45, 9, 42, '2024-11-16', '2024-11-17', 2, 10000.00, 'pending', NULL, '2024-11-09 20:36:44', '2024-11-09 20:36:59'),
(46, 9, 47, '2024-11-13', '2024-11-17', 6, 48888.00, 'active', 'dsadasd', '2024-11-11 22:42:13', '2024-11-15 18:04:01'),
(47, 9, 47, '2024-11-14', '2024-11-18', 5, 61110.00, 'cancelled', NULL, '2024-11-11 22:52:12', '2024-11-14 19:00:25'),
(48, 9, 43, '2024-11-20', '2024-11-20', 2, 20000.00, 'active', 'Personal reasons', '2024-11-13 00:08:57', '2024-11-14 20:38:18'),
(49, 63, 48, '2024-11-18', '2024-11-22', 2, 4800.00, 'cancelled', 'Personal reasons', '2024-11-15 17:09:42', '2024-11-15 17:10:21'),
(50, 63, 48, '2024-11-18', '2024-11-23', 1, 7200.00, 'rejected', 'youre a dirty little nigger', '2024-11-15 17:11:38', '2024-11-15 17:12:49'),
(51, 63, 48, '2024-11-16', '2024-11-16', 2, 7200.00, 'completed', NULL, '2024-11-15 17:13:18', '2024-11-15 19:03:01');

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
(15, 8, 8, 'property', 45, 'dsadasd', 'valid', '2024-11-06 04:07:40', '2024-11-06 04:08:34'),
(16, 9, 8, 'user', NULL, 'bayut ang user', 'valid', '2024-11-14 23:18:53', '2024-11-14 23:37:51'),
(17, 9, 8, 'property', 43, 'gago ang tag iya', 'valid', '2024-11-14 23:19:23', '2024-11-14 23:34:45'),
(18, 63, 62, 'property', 48, 'dili ko ani', 'invalid', '2024-11-15 19:07:18', '2024-11-15 19:07:49'),
(19, 63, 62, 'property', 48, 'Unsafe Conditions', 'invalid', '2024-11-15 19:17:10', '2024-11-15 19:18:38'),
(20, 63, 62, 'property', 48, 'Illegal Activities', 'valid', '2024-11-15 19:18:51', '2024-11-15 19:24:34'),
(21, 63, 62, 'user', NULL, 'bakla', 'invalid', '2024-11-15 19:33:45', '2024-11-15 19:34:05'),
(22, 63, 62, 'user', NULL, 'Inappropriate Content', 'valid', '2024-11-15 19:34:39', '2024-11-15 19:34:51');

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
(1, 9, 44, 2, 'hoy boks', '2024-10-16 23:52:41', '2024-11-13 01:38:50'),
(3, 9, 44, 4, 'bogo', '2024-10-17 20:26:45', '2024-10-17 20:28:52'),
(4, 9, 43, 5, 'dasdasdasd', '2024-10-20 05:56:29', '2024-10-20 05:56:35'),
(5, 9, 34, 5, 'ghnthnfng', '2024-10-24 10:13:53', '2024-10-24 10:13:53'),
(8, 9, 43, NULL, NULL, '2024-11-07 20:45:01', '2024-11-07 20:45:01'),
(9, 10, 43, NULL, NULL, '2024-11-07 20:45:01', '2024-11-07 20:45:01'),
(10, 63, 48, 5, 'sorry man', '2024-11-15 19:03:01', '2024-11-15 19:05:33');

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
('43wLgidpKJfyHRije9bSRcIO6SH3u1YGh06bKnou', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicUVPeWFmejdVcVVNM25oUnYwUG5RYlRYMTJsdFlNUmZSb3puSjh6RiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ub3RpZmljYXRpb25zIjt9fQ==', 1731742268),
('gVkrZQZx8c0q5ibWkPFOM5ociZ3d8hXLQIVcXn60', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNjJnTmN3clhOQ2lRNmZNZjRCOWQ2QUZscGVUVXRRaHh2WVlWamc2ViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NToic3RhdGUiO3M6NDA6Im9vWkpYc3FKbkREYjd2aDNpSUdUSHFZRlZHNVZSNElKT0t1UlZTWm8iO30=', 1731733943),
('n29iDINssBYu2cUXsyvPDmiLYcOEXiHaSWe3Vb02', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ0RWSFlraG5rZ3R2d2FBN0dGR2RtM0Z1WDFDdG1NVWhRMzZXTHBZZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1731740570);

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
(8, 'roland', 'rshan0418@gmail.com1', 'roland', '$2y$12$KAoWHQSf1WZlzzR9rz5mYuNJEUMifBnkXIG4E8oGzi5kHzP4uenvG', '12314134', 0, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', 'dasda12', NULL, '2024-07-18 23:37:48', '2024-11-15 21:11:24', 0, 1, 'owner', 3, NULL, NULL, '2024-11-06 03:33:15'),
(9, 'dsads', 'russellcandilasa@gmail.com', 'rolando', '$2y$12$qJHoOqgn0jsnSk0QcV1qr.B/qc6Fnv7F2q.FsOMyfgUF5DHWHQcSK', '12314134', 0, NULL, 'profile-pictures/oPswQC2EERKWtfY7WXfz3QkrmMVhy0NptwkcyliS.jpg', NULL, NULL, '2024-07-28 03:30:53', '2024-11-15 22:38:31', 0, 0, 'tenant', 1, NULL, NULL, '2024-10-04 04:28:19'),
(10, 'rolanda', 'dsa@f.vo', 'dsadsa', '$2y$12$r0hZYWws2BeT2pzsNlwaAOHufzxu/t7vxho7AJMGfnbbSV3k27GPm', '12314134', 0, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-07-28 20:25:03', '2024-10-31 04:49:15', 0, 0, 'tenant', 3, NULL, NULL, '2024-10-04 05:35:18'),
(11, 'shane', 'dsa@f.vos', 'shane', '$2y$12$pfMTqwcBEoo7aXzeCe6HKeLT6vhdM4Bi0Xzqbpm0Y84flDKHNwxkm', '12314134', 0, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-08-09 21:04:44', '2024-09-15 21:14:21', 1, 0, 'tenant', 3, NULL, 0, NULL),
(13, 'rolands', 'rshan0418@gmail.coms', 'rolands', '$2y$12$4AL119LT4Dvr6TOP.4Euy.2ZR/nx0KVUPGuSV76JoHjAH9drGRSzS', '12314134', 0, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-08-09 22:30:36', '2024-11-01 20:19:59', 1, 0, 'tenant', 3, NULL, 730137, NULL),
(14, 'Lopez Roland Shane', 'lopezrolandshane@gmail.com', 'shaner', '$2y$12$KWBaHsB1eLFlGJ.2D.LF2O8u4qpNORuowbKP1xj0zcedchtSRZ81a', '12314134', 0, '107236937285983559710', 'profile-pictures/NsqtYbR4bm9qTg7FvyIID8MApPz7MhofeBfoJ5WS.jpg', 'dsadsadad', NULL, '2024-08-11 19:56:43', '2024-11-15 06:09:28', 0, 0, 'admin', 3, NULL, 796437, '2024-11-07 04:19:18'),
(22, 'Roland Shane Lopez', NULL, NULL, NULL, '090909090909', 1037565838296943, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-09-24 21:46:08', '2024-10-03 20:05:49', 0, 0, 'tenant', 3, NULL, NULL, '2024-10-04 04:05:49'),
(39, 'Roland  Lopez', 'rshan0418@gmail.com3', 'roland3', '$2y$12$hjICAtBMCq5irLmPaoVTW.G3TTUMG0wfLyM64D1VlbmEQVGrfKUFe', '12314134', NULL, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-10-27 20:43:48', '2024-10-27 20:45:43', 0, 0, 'tenant', 3, NULL, NULL, '2024-10-28 04:45:43'),
(42, 'shane lopez', 'rshan0418@gmail.com4', 'roland4', '$2y$12$fEgxFdQZneJ/TRzyafjlx.kgYZXU7HXbkHLQug5P5vepPrrixuWx2', '12314134', NULL, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-10-27 22:29:17', '2024-10-27 22:29:27', 0, 0, 'owner', 3, NULL, NULL, '2024-10-28 06:29:27'),
(43, 'Roland 1 Lopez', 'rshan0418@gmail.com13', 'roland13', '$2y$12$EAFOVb2bXUDBFt/U68D30uJpUllirWCQb1.Oc.4Y.P8bNYfLTZHYa', '12314134', NULL, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-10-28 01:19:17', '2024-10-28 01:46:02', 0, 1, 'owner', 3, NULL, NULL, '2024-10-28 09:46:02'),
(44, 'shane123', 'russellcandilasa@gmail.com3', 'dsa123', '$2y$12$2.tr.8.H7mEitAEFjQxTfONReN0Y3RTUefBkRjE2nRoAb1F6Es.l6', '12314134', NULL, NULL, 'profile-pictures/01w6PArURzOfWpw70McAuGauQ9NejVsvudYkZy4S.jpg', NULL, NULL, '2024-10-28 01:22:09', '2024-10-28 01:22:33', 0, 0, 'tenant', 3, NULL, NULL, '2024-10-28 09:22:33'),
(46, 'Roland Shane Lopez123', 'rshan0418@gmail.com123', 'roland123', '$2y$12$jKhK6Wog27HePLSvpU9mNOXzK6p0ZHpofVTkEwj5mTdjZrSr25E66', '12314134', NULL, NULL, 'profile-pictures/9vwqyU7bvRHMR6GyCMt3LghKLgOAuINYu5fjR3jV.jpg', 'Tres De Mayo', NULL, '2024-11-03 23:01:11', '2024-11-15 23:14:20', 0, 0, 'tenant', 3, NULL, NULL, '2024-11-16 07:13:18'),
(51, 'Ro Shan', 'rshan0418@gmail.com', NULL, NULL, '090909090909', NULL, '107895499310321282475', 'profile_picture/0RUVxlvDG8p1m4EcyW2LlW1fG.jpg', 'Tres De Mayo', NULL, '2024-11-06 20:25:44', '2024-11-06 20:26:12', 0, 0, 'owner', 3, NULL, NULL, '2024-11-07 04:25:44'),
(53, 'Roland Shane Lopez65', 'rshan0418@gmail.com41', 'roland41', '$2y$12$4jL5CcPlmIDa8veDnyGDe.jZq9sLz.9KFyPY0vltqlKzh/AO9FK7S', '12314134', NULL, NULL, 'profile_picture/atIIuo2wOwszhr1zlgGsAge5u.png', 'purok 3 tres de mayo', NULL, '2024-11-06 22:13:53', '2024-11-06 22:14:15', 0, 0, 'tenant', 3, NULL, NULL, '2024-11-07 06:14:15'),
(60, 'Suzette Villareal', 'suzettevillareal5@gmail.com', NULL, NULL, NULL, NULL, '106474133351444271009', NULL, NULL, NULL, '2024-11-15 01:51:18', '2024-11-15 01:51:18', 0, 0, NULL, 3, NULL, NULL, '2024-11-15 09:51:18'),
(62, 'shane lopez', 'nokielopez@gmail.com', NULL, NULL, '090909090909', NULL, '106648757521862198329', 'profile_picture/BK1dAV20OhbN4iy2L0N5OyvLT.jpg', 'Tres De Mayo', NULL, '2024-11-15 16:59:11', '2024-11-15 19:39:05', 0, 0, 'owner', 3, NULL, NULL, '2024-11-16 00:59:11'),
(63, 'Roland Shane Lopez12355', NULL, NULL, NULL, '090909090909', NULL, NULL, 'profile_picture/eFirTtA3ht7ck0qvmIhngBSV0.jpg', 'Tres De Mayo', NULL, '2024-11-15 17:07:28', '2024-11-15 19:05:11', 0, 0, 'tenant', 2, NULL, NULL, '2024-11-16 01:08:57'),
(64, 'deagmo', 'degamo@gmail.com', 'degamo', '$2y$12$5THbLAMpvk07m80Q0la2xuCOncotIHj0WMkheHgIVN3KcaOEgwDCa', '2131321', NULL, NULL, 'profile_picture/F6tEF12asN9e5kD0EKF8ogm9b.jpg', 'Tres De Mayo', NULL, '2024-11-15 23:24:48', '2024-11-15 23:25:20', 0, 0, 'tenant', 3, NULL, NULL, '2024-11-16 07:25:20'),
(65, 'Roland Shane Lopez', 'rshan0418@gmail.com6666', NULL, NULL, '090909090909', 1071441051576088, NULL, 'profile_picture/AvQj0P4CW3LcULMmj1uQ0wpZc.jpg', 'Tres De Mayo', NULL, '2024-11-15 23:28:06', '2024-11-15 23:30:51', 0, 0, 'tenant', 3, NULL, 542861, NULL);

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
(10, 51, 'owner_documents/valid_id/8FogOHXdtOiviiSJYoCyRmSta.jpg', 'owner_documents/business_permit/YF1YNcITFeMsHw0fcA26tC7IC.jpg', 'approved', NULL, '2024-11-06 20:26:13', '2024-11-06 20:26:44'),
(20, 62, 'owner_documents/valid_id/JsVJXuGo5q4sB5VfXjvIzeMhB.jpg', 'owner_documents/business_permit/mEtw3EjTgsnkd0PtU9o6Wop5e.jpg', 'approved', NULL, '2024-11-15 17:01:03', '2024-11-15 17:01:53');

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
  ADD KEY `rent_forms_dorm_id_foreign` (`dorm_id`),
  ADD KEY `rent_forms_user_id_foreign` (`user_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `curse_words`
--
ALTER TABLE `curse_words`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `dorms`
--
ALTER TABLE `dorms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=326;

--
-- AUTO_INCREMENT for table `property_views`
--
ALTER TABLE `property_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `rent_forms`
--
ALTER TABLE `rent_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
-- Constraints for table `dorms`
--
ALTER TABLE `dorms`
  ADD CONSTRAINT `dorms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_dorm_id_foreign` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `rent_forms_dorm_id_foreign` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rent_forms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `verifications`
--
ALTER TABLE `verifications`
  ADD CONSTRAINT `verification_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
