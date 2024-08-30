-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2024 at 05:10 AM
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
(57, 9, 8, 42, 123, '2024-08-18 01:47:24', '2024-08-18 01:47:24');

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
(27, 8, 'roland12', 'dadssa', '\"Teves, Vito, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25732354, 123.79582294, 12, 10000.00, '\"[\\\"1723110744_66b495585d449.jpg\\\",\\\"1723110744_66b495586009d.jpg\\\",\\\"1723110744_66b4955860459.jpg\\\"]\"', 'dorm', 0, '2024-08-04 20:50:17', '2024-08-14 20:53:57'),
(28, 8, 'lando', 'dasdsa', '\"Tubod, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25918163, 123.79865443, 12, 1200.00, '\"[\\\"1722833844_66b05bb489012.jpg\\\",\\\"1722833844_66b05bb48bfbb.jpg\\\",\\\"1722833844_66b05bb48c2bb.jpg\\\"]\"', 'dorm', 1, '2024-08-04 20:57:24', '2024-08-09 20:50:15'),
(29, 8, 'oli house', 'new house', '\"Teves, Vito, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25521206, 123.79410364, 2, 1200.00, '\"[\\\"1722834497_66b05e4173457.PNG\\\",\\\"1722834497_66b05e41760b5.PNG\\\",\\\"1722834497_66b05e417632d.PNG\\\"]\"', 'dorm', 0, '2024-08-04 21:08:17', '2024-08-14 18:39:20'),
(30, 8, 'oli house1', 'new house', '\"Poblacion Ward II, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24372536, 123.79625195, 2, 1200.00, '\"[\\\"1722834513_66b05e513b18f.PNG\\\",\\\"1722834513_66b05e513d205.PNG\\\",\\\"1722834513_66b05e513d500.PNG\\\"]\"', 'dorm', 0, '2024-08-04 21:08:33', '2024-08-09 20:31:20'),
(31, 8, 'oli house2', 'new house', '\"Escala at Corona Del Mar, Pooc, Cebu, Central Visayas, 6045, Pilipinas\"', 10.23831971, 123.82036251, 2, 1200.00, '\"[\\\"1722834526_66b05e5eafdbe.PNG\\\",\\\"1722834526_66b05e5eb2117.PNG\\\",\\\"1722834526_66b05e5eb237e.PNG\\\"]\"', 'dorm', 0, '2024-08-04 21:08:46', '2024-08-04 21:08:46'),
(32, 8, 'oli house4', 'new house', '\"Poblacion Ward II, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24262734, 123.79153281, 2, 1200.00, '\"[\\\"1722834547_66b05e739470d.PNG\\\",\\\"1722834547_66b05e7396ab2.PNG\\\",\\\"1722834547_66b05e7396d0f.PNG\\\"]\"', 'dorm', 0, '2024-08-04 21:09:07', '2024-08-04 21:09:07'),
(33, 8, 'oli house4', 'new house', '\"Linao, Pakigne, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25518391, 123.80474642, 2, 1200.00, '\"[\\\"1722834578_66b05e923dadd.PNG\\\",\\\"1722834578_66b05e924041b.PNG\\\",\\\"1722834578_66b05e924066b.PNG\\\"]\"', 'dorm', 0, '2024-08-04 21:09:38', '2024-08-04 21:09:38'),
(34, 8, 'oli house5', 'new house', '\"Vito Elementary School, Vito-Cadulawan Road, Teves, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25360732, 123.79316306, 2, 1200.00, '\"[\\\"1722834592_66b05ea0b7b38.PNG\\\",\\\"1722834592_66b05ea0ba1e1.PNG\\\",\\\"1722834592_66b05ea0ba446.PNG\\\"]\"', 'dorm', 0, '2024-08-04 21:09:52', '2024-08-04 21:09:52'),
(35, 8, 'oli house6', 'new house', '\"Poblacion Ward II, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24296519, 123.79530813, 2, 1200.00, '\"[\\\"1722834611_66b05eb3bf252.PNG\\\",\\\"1722834611_66b05eb3c159e.PNG\\\",\\\"1722834611_66b05eb3c1881.PNG\\\"]\"', 'dorm', 0, '2024-08-04 21:10:11', '2024-08-04 21:10:11'),
(36, 8, 'oli house7', 'new house', '\"Bacay Elementary School, A. Apostol Street, Tulay, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas\"', 10.23806632, 123.79307726, 2, 1200.00, '\"[\\\"1722834641_66b05ed14a50f.PNG\\\",\\\"1722834641_66b05ed14cb89.PNG\\\",\\\"1722834641_66b05ed14ce6c.PNG\\\"]\"', 'dorm', 0, '2024-08-04 21:10:41', '2024-08-04 21:10:41'),
(37, 8, 'oli house8', 'new house', '\"Lower Tiber, Poblacion Ward I, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas\"', 10.24307783, 123.79890595, 2, 1200.00, '\"[\\\"1722834681_66b05ef976159.jpg\\\",\\\"1722834681_66b05ef978417.jpg\\\",\\\"1722834681_66b05ef9786a5.jpg\\\"]\"', 'dorm', 0, '2024-08-04 21:11:21', '2024-08-04 21:11:21'),
(38, 8, 'roland44', 'ewqewqe', '\"Cantibjang, Pakigne, Cebu, Central Visayas, 6046, Pilipinas\"', 10.25495868, 123.80433083, 1, 1200.00, '\"[\\\"1723109725_66b4915da05e6.jpg\\\",\\\"1723109726_66b4915e0c582.jpg\\\",\\\"1723174819_66b58fa34a237.jpg\\\"]\"', 'dorm', 0, '2024-08-08 01:35:26', '2024-08-08 19:40:40'),
(42, 8, 'shane house', 'cool', '\"Hickory Street, Springwoods Country Homes Subdivision, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas\"', 10.24093808, 123.79084639, 5, 10000.00, '\"[\\\"1723695736_66bd827819a2d.jpg\\\",\\\"1723695736_66bd82781c48f.jpg\\\",\\\"1723695736_66bd82781c72b.jpg\\\"]\"', 'dorm', 0, '2024-08-14 20:22:16', '2024-08-14 20:22:16');

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
(111, 28, 8, 52, NULL, NULL, 'ok bro', 0, '2024-08-05 21:13:19', '2024-08-05 21:13:19'),
(112, 27, 9, 53, NULL, NULL, 'I am interested in your dorm.', 1, '2024-08-06 23:20:54', '2024-08-29 17:27:03'),
(113, 32, 10, 54, NULL, NULL, 'I am interested in your dorm.', 1, '2024-08-09 20:57:43', '2024-08-27 19:24:36'),
(114, 27, 9, 53, NULL, NULL, 'dsadsa', 1, '2024-08-18 00:40:04', '2024-08-29 17:27:03'),
(122, NULL, 9, NULL, 6, 1, 'I am interested in your dorm.', 0, '2024-08-18 09:45:25', '2024-08-18 09:45:25'),
(123, 42, 9, 57, NULL, NULL, 'I am interested in your dorm.', 1, '2024-08-18 01:47:24', '2024-08-27 19:44:59'),
(124, 28, 8, 52, NULL, NULL, 'bogo', 0, '2024-08-18 02:42:50', '2024-08-18 02:42:50'),
(125, NULL, 9, NULL, 7, 3, 'I am interested in your dorm.', 0, '2024-08-18 10:49:59', '2024-08-18 10:49:59'),
(126, 42, 9, 57, NULL, NULL, 'fdsfds', 1, '2024-08-18 03:21:31', '2024-08-27 19:44:59'),
(127, NULL, 9, NULL, 7, 3, 'yawa', 0, '2024-08-18 11:48:41', '2024-08-18 11:48:41'),
(128, 42, 9, 57, NULL, NULL, 'dsadsa', 1, '2024-08-18 04:00:30', '2024-08-27 19:44:59'),
(129, 42, 9, 57, NULL, NULL, 'dasdsad', 1, '2024-08-18 04:00:37', '2024-08-27 19:44:59'),
(130, 27, 9, 53, NULL, NULL, 'ccvcv', 1, '2024-08-18 04:35:44', '2024-08-29 17:27:03'),
(131, 27, 9, 53, NULL, NULL, 'ddd', 1, '2024-08-18 05:00:31', '2024-08-29 17:27:03'),
(132, 27, 9, 53, NULL, NULL, 'dsada', 1, '2024-08-18 05:01:11', '2024-08-29 17:27:03'),
(133, NULL, 9, NULL, 8, 4, 'I am interested in your dorm.', 0, '2024-08-18 13:01:48', '2024-08-18 13:01:48'),
(134, 42, 9, 57, NULL, NULL, 'dasdas', 1, '2024-08-18 05:07:32', '2024-08-27 19:44:59'),
(143, NULL, 9, NULL, 8, 4, 'dasdsad', 0, '2024-08-18 05:16:20', '2024-08-18 05:16:20'),
(144, NULL, 9, NULL, 8, 4, 'dsadas', 0, '2024-08-18 05:16:58', '2024-08-18 05:16:58'),
(145, NULL, 9, NULL, 8, 4, 'hahah', 0, '2024-08-18 05:19:06', '2024-08-18 05:19:06'),
(146, 27, 9, 53, NULL, NULL, 'gaga', 1, '2024-08-18 05:19:16', '2024-08-29 17:27:03'),
(147, NULL, 9, NULL, 7, 3, 'dadad', 0, '2024-08-18 05:21:53', '2024-08-18 05:21:53'),
(148, NULL, 9, NULL, 7, 3, 'yow', 0, '2024-08-18 05:22:30', '2024-08-18 05:22:30'),
(150, NULL, 8, NULL, 6, 1, 'dasdas', 0, '2024-08-20 00:19:11', '2024-08-20 00:19:11'),
(151, NULL, 8, NULL, 6, 1, 'dsad', 0, '2024-08-20 00:30:16', '2024-08-20 00:30:16'),
(152, NULL, 8, NULL, 6, 1, 'dsa', 0, '2024-08-20 00:33:12', '2024-08-20 00:33:12'),
(153, NULL, 8, NULL, 6, 1, 'http://127.0.0.1:8000/rent-form/6?expires=1724146879&signature=bf83a73033e7a8190d811e75aac52f5a440352e3ca76ef6560606540ba6224a8', 0, '2024-08-20 00:41:19', '2024-08-20 00:41:19'),
(154, NULL, 8, NULL, 6, 1, 'http://127.0.0.1:8000/rent-form/6?expires=1724146881&signature=e7f23ba92f0b2a0536eb8a4ee6b2b3ed03b18effdfd68f276b3b91ff096bd895', 0, '2024-08-20 00:41:21', '2024-08-20 00:41:21'),
(155, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/8?expires=1724146927&signature=2d83f99f7d71b07a0d48469c70cdea35e2675a91a892634994dffdc4b679ccac', 0, '2024-08-20 00:42:07', '2024-08-20 00:42:07'),
(156, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/8?expires=1724147322&signature=0c7859adc8c3da04b7b6fd5fc0ed9db31ff6be64791260544e90c9ef449fb615', 0, '2024-08-20 00:48:42', '2024-08-20 00:48:42'),
(157, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/8?expires=1724147328&signature=f828526695e5aeab4e91cff59a60ecb31fb4222af2d61ec88b299c68f7bdcd35', 0, '2024-08-20 00:48:48', '2024-08-20 00:48:48'),
(158, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/8?expires=1724147431&signature=ef5c75c63c850fda6be17ea1ab5093aa0091e6b654647ec27c95a345c6df5232', 0, '2024-08-20 00:50:31', '2024-08-20 00:50:31'),
(159, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724147468&signature=8c31aece378d175cf3b33fd977f4c5c0e79c64be4ed1e4692dcd21f2e094283a', 0, '2024-08-20 00:51:08', '2024-08-20 00:51:08'),
(160, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724209271&signature=47efb05e9c3c203816678cbd64d23f44b44de7ac7a4859fd8bd80daf788edd85', 0, '2024-08-20 18:01:11', '2024-08-20 18:01:11'),
(161, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724304997&signature=a86c3ec960fe79795ffbc88bc0b137e83e1c41a971e9657ce3e9fd3b7cea7b12', 0, '2024-08-21 20:36:37', '2024-08-21 20:36:37'),
(162, NULL, 8, NULL, 8, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724305707&signature=3cabe6ec6be973f51fa304a6345912ca8407f6042dc96a9ef69fe4a71d23f229', 0, '2024-08-21 20:48:27', '2024-08-21 20:48:27'),
(163, NULL, 8, NULL, 7, 3, 'http://127.0.0.1:8000/rent-form/3?expires=1724305729&signature=82b8fc4812a3406b3cf1eb727c529bec051826512d155f17bf4c718341a9a8cd', 0, '2024-08-21 20:48:49', '2024-08-21 20:48:49'),
(164, NULL, 9, NULL, 8, 4, 'dsad', 0, '2024-08-21 21:19:02', '2024-08-21 21:19:02'),
(165, NULL, 9, NULL, 8, 4, '`', 0, '2024-08-21 21:19:59', '2024-08-21 21:19:59'),
(166, NULL, 9, NULL, 8, 4, 'ss', 0, '2024-08-21 21:20:18', '2024-08-21 21:20:18'),
(167, NULL, 10, NULL, 9, 4, 'I am interested in your dorm.', 0, '2024-08-22 05:22:14', '2024-08-22 05:22:14'),
(168, NULL, 10, NULL, 9, 4, 's', 0, '2024-08-21 21:22:23', '2024-08-21 21:22:23'),
(169, NULL, 8, NULL, 9, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724308372&signature=7b3b84879a33831108c2d1b679c3ed2795757f6b658826b357b6901faea3cf85', 0, '2024-08-21 21:32:52', '2024-08-21 21:32:52'),
(170, NULL, 10, NULL, 10, 3, 'I am interested in your dorm.', 0, '2024-08-22 05:45:47', '2024-08-22 05:45:47'),
(172, NULL, 8, NULL, 9, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724312181&signature=fa7115914c5394ce1a65021c743079c4ff8917dd0986fa13a4cbf378261a1239', 0, '2024-08-21 22:36:21', '2024-08-21 22:36:21'),
(173, NULL, 8, NULL, 9, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724312364&signature=f3125433834659d15fc4721e147d48365083f2bb3280d61a71d7e26d0477a34b', 0, '2024-08-21 22:39:24', '2024-08-21 22:39:24'),
(174, NULL, 8, NULL, 9, 4, 'http://127.0.0.1:8000/rent-form/4?expires=1724312515&signature=1d38912edd38147bcc51b1e231de8c60598b8e4c12f8fafec0ffdedd3f9d482a', 0, '2024-08-21 22:41:55', '2024-08-21 22:41:55'),
(175, NULL, 8, NULL, 7, 3, 'http://127.0.0.1:8000/rent-form/3?expires=1724664763&signature=39b53538c56e90a114a41f8674612420099032fd003a102fdadec9a88225cb83', 0, '2024-08-26 00:32:43', '2024-08-26 00:32:43'),
(176, NULL, 8, NULL, 10, 3, 'http://127.0.0.1:8000/rent-form/3?expires=1724664803&signature=fa46b39cb776ebe65f1f2a6df75f778c185170d7666ec496893ed3a32bff427d', 1, '2024-08-26 00:33:23', '2024-08-29 17:32:37'),
(177, NULL, 10, NULL, 11, 1, 'I am interested in your dorm.', 0, '2024-08-26 08:36:31', '2024-08-26 08:36:31'),
(178, NULL, 8, NULL, 11, 1, 'http://127.0.0.1:8000/rent-form/1?expires=1724665002&signature=b154f8fdd1aa357b99a4694a8c6efcea4c5288c2736433fadeb6e2d2532b0132', 0, '2024-08-26 00:36:42', '2024-08-26 00:36:42'),
(180, NULL, 9, NULL, 13, 5, 'I am interested in your dorm.', 1, '2024-08-27 03:32:05', '2024-08-27 19:48:33'),
(181, NULL, 8, NULL, 6, 1, 'dsad', 0, '2024-08-27 19:26:16', '2024-08-27 19:26:16'),
(182, 42, 8, 57, NULL, NULL, 'dsad', 1, '2024-08-27 19:26:38', '2024-08-27 19:47:32'),
(183, 42, 8, 57, NULL, NULL, 'bogo', 1, '2024-08-27 19:29:09', '2024-08-27 19:47:32'),
(184, NULL, 8, NULL, 13, 5, 'ok bro', 1, '2024-08-27 19:36:29', '2024-08-27 19:49:14'),
(185, NULL, 9, NULL, 13, 5, 'no bro', 1, '2024-08-27 19:39:04', '2024-08-27 19:48:33'),
(186, 42, 8, 57, NULL, NULL, 'hey', 1, '2024-08-27 19:43:57', '2024-08-27 19:47:32'),
(187, 42, 8, 57, NULL, NULL, 'hey', 1, '2024-08-27 19:44:29', '2024-08-27 19:47:32'),
(188, NULL, 8, NULL, 13, 5, 'heyo', 1, '2024-08-27 19:47:48', '2024-08-27 19:49:14'),
(189, NULL, 8, NULL, 13, 5, 'hey', 1, '2024-08-27 19:48:20', '2024-08-27 19:49:14'),
(190, NULL, 9, NULL, 13, 5, 'hoy', 0, '2024-08-27 19:49:06', '2024-08-27 19:49:06');

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
(25, '2024_08_27_053132_updatee_notifications_table', 15);

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
(1, 8, 'New Inquiry', 'yawa', 1, '2024-08-26 19:32:05', '2024-08-29 18:06:28', 3, 10),
(2, 10, 'Form Response', 'Rent Form approved', 1, '2024-08-29 17:59:12', '2024-08-29 17:59:48', 3, 8),
(3, 10, 'Form Response', 'Rent Form rejected', 1, '2024-08-29 18:07:25', '2024-08-29 18:42:51', 3, 8);

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
-- Table structure for table `rent_forms`
--

CREATE TABLE `rent_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `dorm_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `duration` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rent_forms`
--

INSERT INTO `rent_forms` (`id`, `user_id`, `room_id`, `dorm_id`, `start_date`, `duration`, `status`, `created_at`, `updated_at`) VALUES
(3, 10, 3, 42, '2024-08-24', 3, 'rejected', '2024-08-21 21:42:01', '2024-08-29 18:07:25'),
(4, 10, 4, 42, '2024-08-24', 12, 'pending', '2024-08-21 21:47:33', '2024-08-21 21:47:33'),
(5, 10, 4, 42, '2024-08-31', 12, 'pending', '2024-08-21 21:57:52', '2024-08-21 21:57:52'),
(6, 10, 4, 42, '2024-08-31', 2, 'approved', '2024-08-21 21:59:13', '2024-08-21 21:59:13'),
(7, 8, 1, 42, '2024-08-31', 2, 'pending', '2024-08-26 00:51:57', '2024-08-26 00:51:57'),
(8, 9, 3, 42, '2024-08-31', 6, 'pending', '2024-08-26 00:53:26', '2024-08-26 00:53:26');

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
(13, 9, 8, 5, 180, '2024-08-27 03:32:05', '2024-08-27 03:32:05');

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
(5, 42, 'Room 5', NULL, NULL, NULL, NULL, 1, '2024-08-14 20:22:16', '2024-08-14 20:22:16');

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
('7vaTu4JINuJstg4pw2MfJRgqYYjFAWNBdFN0e1BK', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoid3ZYQ1Jjam1BQWFmdUVLMUpZZHhyRGJEMVZNRE5IMnlDejk3T2RiRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yb29tLWNoYXRzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2NoYXRyb29tcyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjg7fQ==', 1724986329);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT 0,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `phone`, `address`, `dob`, `gender`, `profile_picture`, `remember_token`, `created_at`, `updated_at`, `active_status`, `role`) VALUES
(8, 'roland', 'rshan0418@gmail.com', 'roland', '$2y$12$.51GKwRYtnbfx3wBOdZwaeJ/kxWQSrvmCfVHpVk2iXetzIQKotEV2', '12314134', 'Tres De Mayo', '2024-03-09', 'male', '1721374668.png', NULL, '2024-07-18 23:37:48', '2024-07-18 23:37:48', 0, 'owner'),
(9, 'dsads', 'russellcandilasa@gmail.com', 'rolando', '$2y$12$qJHoOqgn0jsnSk0QcV1qr.B/qc6Fnv7F2q.FsOMyfgUF5DHWHQcSK', '12314134', 'Tres De Mayo', '2024-07-20', 'male', NULL, NULL, '2024-07-28 03:30:53', '2024-07-28 03:30:53', 0, 'tenant'),
(10, 'rolanda', 'dsa@f.vo', 'dsadsa', '$2y$12$r0hZYWws2BeT2pzsNlwaAOHufzxu/t7vxho7AJMGfnbbSV3k27GPm', '12314134', 'Tres De Mayo', '2024-07-13', 'female', '1722227103.jpg', NULL, '2024-07-28 20:25:03', '2024-07-28 20:25:03', 0, 'tenant'),
(11, 'shane', 'dsa@f.vos', 'shane', '$2y$12$pfMTqwcBEoo7aXzeCe6HKeLT6vhdM4Bi0Xzqbpm0Y84flDKHNwxkm', '12314134', 'Tres De Mayo', '2024-03-07', 'other', '1723266283.png', NULL, '2024-08-09 21:04:44', '2024-08-09 21:04:44', 0, 'tenant'),
(13, 'rolands', 'rshan0418@gmail.coms', 'rolands', '$2y$12$4AL119LT4Dvr6TOP.4Euy.2ZR/nx0KVUPGuSV76JoHjAH9drGRSzS', '12314134', 'Tres De Mayo', '2024-07-30', 'other', NULL, NULL, '2024-08-09 22:30:36', '2024-08-09 22:30:36', 0, 'tenant'),
(14, 'shaner', 'lopezrolandshane@gmail.com', 'shaner', '$2y$12$KWBaHsB1eLFlGJ.2D.LF2O8u4qpNORuowbKP1xj0zcedchtSRZ81a', '12314134', 'Tres De Mayo', '2024-08-23', 'other', '1723435002.jpg', NULL, '2024-08-11 19:56:43', '2024-08-11 19:56:43', 0, 'owner'),
(15, 'Roland Shane Lopez', 'rshan0418@gmail.com1', 'roland1', '$2y$12$vsj0gadv4qSAiBF7BkUA9OkSnRbv2D8zg65pXsdDwvz5sbsMX/F8O', '12314134', 'Tres De Mayo', '2024-08-31', 'female', '1724471642.jpg', NULL, '2024-08-23 19:54:03', '2024-08-23 19:54:03', 0, 'tenant');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatrooms`
--
ALTER TABLE `chatrooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `dorms`
--
ALTER TABLE `dorms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rent_forms`
--
ALTER TABLE `rent_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roomchats`
--
ALTER TABLE `roomchats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
-- Constraints for table `rent_forms`
--
ALTER TABLE `rent_forms`
  ADD CONSTRAINT `rent_forms_dorm_id_foreign` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rent_forms_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rent_forms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
