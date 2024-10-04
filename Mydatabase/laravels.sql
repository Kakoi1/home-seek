-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2024 at 05:54 AM
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
  `rooms_available` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dorms`
--

INSERT INTO `dorms` (`id`, `user_id`, `name`, `description`, `address`, `latitude`, `longitude`, `rooms_available`, `price`, `image`, `type`, `archive`, `created_at`, `updated_at`) VALUES
(27, 8, 'roland12', 'dadssa', '\"Teves, Vito, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25732354, 123.79582294, 12, 10000.00, '\"[\\\"1727333044_66f502b4b837e.jpg\\\",\\\"1727333044_66f502b4bafdc.jpg\\\",\\\"1727333044_66f502b4bb26b.jpg\\\"]\"', 'dorm', 0, '2024-08-04 20:50:17', '2024-09-25 22:44:04'),
(28, 8, 'lando', 'dasdsa', '\"Tubod, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25918163, 123.79865443, 12, 1200.00, '\"[\\\"1722833844_66b05bb489012.jpg\\\",\\\"1722833844_66b05bb48bfbb.jpg\\\",\\\"1722833844_66b05bb48c2bb.jpg\\\"]\"', 'dorm', 1, '2024-08-04 20:57:24', '2024-08-09 20:50:15'),
(29, 8, 'oli house', 'new house', '\"Teves, Vito, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25521206, 123.79410364, 2, 1200.00, '\"[\\\"1727333130_66f5030a4a224.jpg\\\",\\\"1727333130_66f5030a4d44e.jpg\\\",\\\"1727333130_66f5030a4d6d5.jpg\\\"]\"', 'dorm', 0, '2024-08-04 21:08:17', '2024-09-25 22:45:30'),
(30, 8, 'oli house1', 'new house', '\"Poblacion Ward II, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24372536, 123.79625195, 2, 1200.00, '\"[\\\"1727333432_66f5043807eff.jfif\\\",\\\"1727333432_66f504380abca.jfif\\\",\\\"1727333432_66f504380ae0f.jfif\\\"]\"', 'dorm', 0, '2024-08-04 21:08:33', '2024-09-25 22:50:32'),
(31, 8, 'oli house2', 'new house', '\"Escala at Corona Del Mar, Pooc, Cebu, Central Visayas, 6045, Pilipinas\"', 10.23831971, 123.82036251, 2, 1200.00, '\"[\\\"1727333498_66f5047a8ad95.jpg\\\",\\\"1727333498_66f5047a8d8a0.jpg\\\",\\\"1727333498_66f5047a8e0c7.jpg\\\"]\"', 'dorm', 0, '2024-08-04 21:08:46', '2024-09-25 22:51:38'),
(32, 8, 'oli house4', 'new house', '\"Poblacion Ward II, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24262734, 123.79153281, 2, 1200.00, '\"[\\\"1727333523_66f50493c7a11.jpg\\\",\\\"1727333523_66f50493ca49f.jpg\\\",\\\"1727333523_66f50493ca958.jpg\\\",\\\"1727333523_66f50493caf96.jpg\\\",\\\"1727333523_66f50493cb47b.jpg\\\"]\"', 'dorm', 0, '2024-08-04 21:09:07', '2024-09-25 22:52:03'),
(33, 8, 'oli house4', 'new house', '\"Linao, Pakigne, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25518391, 123.80474642, 2, 1200.00, '\"[\\\"1727333593_66f504d91a09c.jpg\\\",\\\"1727333593_66f504d91ceaa.jpg\\\",\\\"1727333593_66f504d91d34a.jpg\\\"]\"', 'dorm', 0, '2024-08-04 21:09:38', '2024-09-25 22:53:13'),
(34, 8, 'oli house5', 'new house', '\"Vito Elementary School, Vito-Cadulawan Road, Teves, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25360732, 123.79316306, 2, 1200.00, '\"[\\\"1727333623_66f504f7a62be.jpg\\\",\\\"1727333623_66f504f7a9496.jpg\\\",\\\"1727333623_66f504f7a9cc5.jpg\\\"]\"', 'dorm', 0, '2024-08-04 21:09:52', '2024-09-25 22:53:43'),
(35, 8, 'oli house6', 'new house', '\"Poblacion Ward II, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24296519, 123.79530813, 2, 1200.00, '\"[\\\"1727333645_66f5050d0adff.jpg\\\",\\\"1727333645_66f5050d0dc11.jpg\\\",\\\"1727333645_66f5050d0e2d6.jpg\\\"]\"', 'dorm', 0, '2024-08-04 21:10:11', '2024-09-25 22:54:05'),
(36, 8, 'oli house7', 'new house', '\"Bacay Elementary School, A. Apostol Street, Tulay, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas\"', 10.23806632, 123.79307726, 2, 1200.00, '\"[\\\"1727333672_66f5052849eab.jpg\\\",\\\"1727333672_66f505284ca51.jpg\\\",\\\"1727333672_66f505284d147.jpg\\\"]\"', 'dorm', 0, '2024-08-04 21:10:41', '2024-09-25 22:54:32'),
(37, 8, 'oli house8', 'new house', '\"Lower Tiber, Poblacion Ward I, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas\"', 10.24307783, 123.79890595, 2, 1200.00, '\"[\\\"1727333720_66f5055873ca0.jpg\\\",\\\"1727333720_66f5055876981.jpg\\\",\\\"1727333720_66f5055876f60.jpg\\\"]\"', 'dorm', 0, '2024-08-04 21:11:21', '2024-09-25 22:55:20'),
(38, 8, 'roland44', 'ewqewqe', '\"Cantibjang, Pakigne, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25495868, 123.80433083, 1, 1200.00, '\"[\\\"1727333744_66f505705a1fe.jpg\\\",\\\"1727333744_66f505705d21c.jpg\\\",\\\"1727333744_66f505705d7e7.jpg\\\"]\"', 'dorm', 0, '2024-08-08 01:35:26', '2024-09-25 22:55:44'),
(42, 8, 'shane house', 'cool', '\"Hickory Street, Springwoods Country Homes Subdivision, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24093808, 123.79084639, 5, 10000.00, '\"[\\\"1727333769_66f50589ebdb9.jpg\\\",\\\"1727333769_66f50589ef36f.jpg\\\",\\\"1727333769_66f50589f03dd.jpg\\\"]\"', 'dorm', 0, '2024-08-14 20:22:16', '2024-09-25 22:56:09'),
(43, 8, 'house', 'dsadsa', '\"Linao, Pakigne, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25690124, 123.80423160, 3, 10000.00, '\"[\\\"1727333805_66f505ad9f207.jpg\\\",\\\"1727333805_66f505ada23b3.jpg\\\",\\\"1727333805_66f505ada27e9.jpg\\\"]\"', 'apartment', 0, '2024-09-04 01:52:50', '2024-09-25 22:56:45');

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
(25, 9, 37, '2024-09-30 00:02:52', '2024-09-30 00:02:52'),
(26, 9, 43, '2024-09-30 00:06:59', '2024-09-30 00:06:59'),
(28, 9, 38, '2024-09-30 00:34:22', '2024-09-30 00:34:22');

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
(30, '2024_10_01_043924_create_rent_forms_table', 19);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `data`, `read`, `created_at`, `updated_at`, `room_id`, `sender_id`) VALUES
(29, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-09 18:09:37', '2024-09-09 18:09:37', 5, 9),
(30, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-09 18:12:49', '2024-09-09 18:12:49', 5, 9),
(31, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-09 19:21:58', '2024-09-09 19:32:52', 8, 10),
(32, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-09 19:28:11', '2024-09-09 19:28:11', 8, 10),
(33, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-09 19:39:42', '2024-09-17 17:53:46', 8, 10),
(35, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-09 20:12:13', '2024-09-09 20:12:13', 8, 10),
(36, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-09 20:14:42', '2024-09-09 20:14:42', 8, 10),
(37, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-09 20:21:34', '2024-09-09 22:12:33', 8, 10),
(38, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-09 20:25:57', '2024-09-09 20:25:57', 8, 10),
(39, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-09 20:28:25', '2024-09-09 20:28:25', 8, 10),
(40, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-09 20:30:15', '2024-09-09 20:30:15', 8, 10),
(41, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-09 20:30:34', '2024-09-09 20:30:34', 8, 10),
(42, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-09 20:34:03', '2024-09-09 20:34:03', 8, 10),
(43, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-09 20:34:24', '2024-09-25 22:36:31', 8, 10),
(44, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-09 20:35:40', '2024-09-17 17:53:39', 8, 10),
(45, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-09 20:36:22', '2024-09-09 20:36:22', 8, 10),
(46, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-09 20:38:53', '2024-09-17 17:53:33', 8, 10),
(47, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-09 20:40:20', '2024-09-09 20:40:25', 8, 10),
(48, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-09 20:49:45', '2024-09-09 20:49:57', 8, 10),
(55, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-17 19:03:08', '2024-09-30 21:47:29', 5, 8),
(56, 10, 'Form Response', 'Rent Form approved', 0, '2024-09-20 07:12:00', '2024-09-20 07:12:00', 8, 8),
(57, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 21:24:45', '2024-09-30 21:24:45', 6, 22),
(58, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 21:26:42', '2024-09-30 21:26:42', 6, 22),
(59, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 21:32:47', '2024-09-30 21:32:47', 6, 22),
(60, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 21:34:15', '2024-09-30 21:34:15', 6, 22),
(61, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 21:35:51', '2024-09-30 21:35:51', 6, 22),
(62, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 21:40:39', '2024-09-30 21:40:39', 7, 22),
(63, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 21:43:02', '2024-09-30 21:43:02', 7, 22),
(64, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-30 21:43:44', '2024-09-30 21:47:46', 7, 22),
(65, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 21:48:39', '2024-09-30 21:48:39', 6, 22),
(66, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 21:49:02', '2024-09-30 21:49:02', 6, 22),
(67, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 21:54:39', '2024-09-30 21:54:39', 6, 22),
(68, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 21:58:21', '2024-09-30 21:58:21', 6, 22),
(69, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-30 22:01:27', '2024-09-30 22:02:51', 6, 22),
(70, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-30 22:02:38', '2024-09-30 22:07:56', 6, 22),
(71, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-30 22:04:23', '2024-09-30 22:08:19', 6, 22),
(72, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-30 22:16:14', '2024-09-30 22:22:33', 6, 22),
(73, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-30 22:21:28', '2024-09-30 22:22:40', 6, 22),
(74, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 22:25:16', '2024-09-30 22:25:16', 6, 22),
(75, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-09-30 22:25:27', '2024-09-30 22:25:27', 6, 22),
(76, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-30 22:28:11', '2024-09-30 22:28:15', 6, 22),
(77, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-30 22:29:23', '2024-09-30 22:31:03', 6, 22),
(78, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 1, '2024-09-30 22:30:51', '2024-09-30 22:30:54', 6, 22),
(79, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-10-01 18:48:44', '2024-10-01 18:48:44', 6, 22),
(80, 8, 'Form Submit', 'A new rent form has been submitted for your room.', 0, '2024-10-01 19:41:03', '2024-10-01 19:41:03', 6, 22);

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
(6, 8, 43, '2024-09-30 18:53:57', '2024-09-30 18:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `rent_forms`
--

CREATE TABLE `rent_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `dorm_id` bigint(20) UNSIGNED NOT NULL,
  `term` enum('short_term','long_term') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rent_forms`
--

INSERT INTO `rent_forms` (`id`, `user_id`, `room_id`, `dorm_id`, `term`, `start_date`, `end_date`, `duration`, `status`, `created_at`, `updated_at`) VALUES
(23, 22, 6, 43, 'short_term', '2024-11-09', '2024-11-30', NULL, 'cancelled', '2024-10-01 18:48:44', '2024-10-01 19:51:47'),
(24, 22, 6, 43, 'short_term', '2024-10-05', '2024-10-25', NULL, 'cancelled', '2024-10-01 19:41:03', '2024-10-01 19:53:06');

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
(22, 38, '5', NULL, NULL, NULL, NULL, 1, '2024-09-25 21:39:14', '2024-09-25 21:39:14');

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
('aXuRRUhm30XLYsUnGTGX7HJRhetb351Demh4EyPb', 22, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicEw3WlVoSEpmN2taZzNleTZJeGpnWmNnZnZWZUZOTVZTMllSQmJ4MCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ub3RpZmljYXRpb25zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL25vdGlmaWNhdGlvbnMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyMjt9', 1727841188);

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
  `fb_username` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT 0,
  `role` varchar(255) NOT NULL DEFAULT 'tenant',
  `email_verification_code` int(15) DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `phone`, `fb_id`, `fb_username`, `profile_picture`, `remember_token`, `created_at`, `updated_at`, `active_status`, `role`, `email_verification_code`, `email_verified_at`) VALUES
(8, 'roland', 'rshan0418@gmail.com', 'roland', '$2y$12$.51GKwRYtnbfx3wBOdZwaeJ/kxWQSrvmCfVHpVk2iXetzIQKotEV2', '12314134', 0, NULL, '1721374668.png', NULL, '2024-07-18 23:37:48', '2024-07-18 23:37:48', 0, 'owner', 0, NULL),
(9, 'dsads', 'russellcandilasa@gmail.com', 'rolando', '$2y$12$qJHoOqgn0jsnSk0QcV1qr.B/qc6Fnv7F2q.FsOMyfgUF5DHWHQcSK', '12314134', 0, NULL, NULL, NULL, '2024-07-28 03:30:53', '2024-09-15 21:20:28', 0, 'tenant', 0, NULL),
(10, 'rolanda', 'dsa@f.vo', 'dsadsa', '$2y$12$r0hZYWws2BeT2pzsNlwaAOHufzxu/t7vxho7AJMGfnbbSV3k27GPm', '12314134', 0, NULL, '1722227103.jpg', NULL, '2024-07-28 20:25:03', '2024-09-15 21:19:32', 0, 'tenant', 0, NULL),
(11, 'shane', 'dsa@f.vos', 'shane', '$2y$12$pfMTqwcBEoo7aXzeCe6HKeLT6vhdM4Bi0Xzqbpm0Y84flDKHNwxkm', '12314134', 0, NULL, '1723266283.png', NULL, '2024-08-09 21:04:44', '2024-09-15 21:14:21', 0, 'tenant', 0, NULL),
(13, 'rolands', 'rshan0418@gmail.coms', 'rolands', '$2y$12$4AL119LT4Dvr6TOP.4Euy.2ZR/nx0KVUPGuSV76JoHjAH9drGRSzS', '12314134', 0, NULL, NULL, NULL, '2024-08-09 22:30:36', '2024-09-15 21:14:25', 1, 'tenant', 0, NULL),
(14, 'shaner', 'lopezrolandshane@gmail.com', 'shaner', '$2y$12$KWBaHsB1eLFlGJ.2D.LF2O8u4qpNORuowbKP1xj0zcedchtSRZ81a', '12314134', 0, NULL, '1723435002.jpg', NULL, '2024-08-11 19:56:43', '2024-08-11 19:56:43', 0, 'owner', 0, NULL),
(22, 'Roland Shane Lopez', 'nokielopez@gmail.com', NULL, NULL, '090909090909', 1037565838296943, NULL, '1727259206.jpg', NULL, '2024-09-24 21:46:08', '2024-09-25 02:14:51', 0, 'tenant', NULL, '2024-09-25 10:14:51');

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
(2, 10, '/id_documents/1726136340_66e2c014e5bc6.jpg', 'public/business_permits/1726136340_66e2c014e8abf.jpg', 'rejected', 'dsada', '2024-09-12 02:19:00', '2024-09-15 21:20:16'),
(4, 9, '1726389248_66e69c00eb630.jpg', '1726389248_66e69c00ee0ed.jpg', 'rejected', 'dsada', '2024-09-15 00:34:08', '2024-09-15 21:19:39'),
(6, 9, '1726466338_66e7c922cd643.jpg', '1726466338_66e7c922d05e8.jpg', 'approved', NULL, '2024-09-15 21:58:58', '2024-09-15 22:14:00'),
(7, 9, '1726466413_66e7c96daf25e.jpg', '1726466413_66e7c96db0ef1.jpg', 'approved', NULL, '2024-09-15 22:00:13', '2024-09-15 22:35:54'),
(8, 9, '1726466503_66e7c9c7d2270.jpg', '1726466503_66e7c9c7d4b02.jpg', 'rejected', 'dsadsadsadsdaddsadsadsadsadsdihifweuirhweuiruiweeruiwefuidufbjwadfjfuiwfuweuirweuifwuifuiwefhsfsd', '2024-09-15 22:01:43', '2024-09-15 23:02:09');

--
-- Indexes for dumped tables
--

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
  ADD KEY `notifications_room_id_foreign` (`room_id`),
  ADD KEY `notifications_sender_id_foreign` (`sender_id`);

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
  ADD KEY `rent_forms_room_id_foreign` (`room_id`),
  ADD KEY `rent_forms_dorm_id_foreign` (`dorm_id`);

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
-- AUTO_INCREMENT for table `chatrooms`
--
ALTER TABLE `chatrooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `dorms`
--
ALTER TABLE `dorms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `property_views`
--
ALTER TABLE `property_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rent_forms`
--
ALTER TABLE `rent_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `roomchats`
--
ALTER TABLE `roomchats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `notifications_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
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
  ADD CONSTRAINT `rent_forms_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `rent_forms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
