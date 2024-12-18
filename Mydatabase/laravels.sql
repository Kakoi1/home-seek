-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 07:36 AM
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
(29, 69, 54, 14000.00, '2024-11-30', 'paid', 'Proof_of_Payment/aazV4wQ7yh3M4bTbA6BA0npJr.jpg', 'e_wallet', '2024-11-21 04:24:53', '2024-11-20 20:14:01', '2024-11-20 20:24:54'),
(30, 71, 56, 6000.00, '2024-11-28', 'paid', NULL, 'cash', '2024-11-23 04:40:27', '2024-11-20 20:39:00', '2024-11-20 20:40:27'),
(31, 71, 58, 7000.00, '2024-11-30', 'paid', 'Proof_of_Payment/9DOlJx9sakjh1c4pKCMkTCwqW.png', 'credit_card', '2024-11-20 04:59:50', '2024-11-20 20:55:51', '2024-11-20 20:59:51'),
(32, 69, 59, 6500.00, '2024-11-28', 'paid', 'Proof_of_Payment/K8kHdX8VaQQ19rv6rmoq5L1iM.jpg', 'bank_transfer', '2024-11-20 05:07:41', '2024-11-20 21:06:00', '2024-11-20 21:07:41'),
(34, 71, 70, 8000.00, '2024-12-07', 'paid', NULL, NULL, NULL, '2024-11-27 20:58:00', '2024-11-27 20:58:00');

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
(49, 68, 'Rainy Days Guesthouse', 'A cozy, family-run guesthouse with clean, comfortable private rooms. Includes breakfast and a garden space for guests to relax.', 'Unabia Street, Poblacion Ward III, Vito, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.24793790, 123.79749656, 1200.00, 3, 4, 2, '\"[\\\"dorm_pictures\\\\\\/1732156681_673e9d090c29c.jpg\\\",\\\"dorm_pictures\\\\\\/1732156681_673e9d09929d8.jpg\\\",\\\"dorm_pictures\\\\\\/1732156681_673e9d09c8ae1.jpg\\\",\\\"dorm_pictures\\\\\\/1732156682_673e9d0a06f68.jpg\\\"]\"', 0, 0, 0, '2024-11-20 18:38:02', '2024-11-27 19:54:41'),
(50, 68, 'Guesthouse', 'A small, family-run accommodation with private rooms, often located in quieter areas. It typically offers a more homely atmosphere than a hotel. Some guesthouses may offer breakfast included.', 'Poblacion Ward II, Calajo-an, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.24244786, 123.79470706, 1000.00, 4, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1732156801_673e9d81a112b.jpg\\\",\\\"dorm_pictures\\\\\\/1732156802_673e9d8233e9d.jpg\\\",\\\"dorm_pictures\\\\\\/1732156802_673e9d82627d7.jpg\\\",\\\"dorm_pictures\\\\\\/1732156802_673e9d829209a.jpg\\\"]\"', 0, 0, 0, '2024-11-20 18:40:02', '2024-11-27 21:15:01'),
(51, 68, 'The Velvet Boutique Hotel', 'Small, stylish hotels with a unique character. They often have personalized service, artistic design, and cozy, individually designed rooms. Often located in trendy neighborhoods.', 'Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.24743113, 123.80966306, 2000.00, 3, 2, 1, '\"[\\\"dorm_pictures\\\\\\/1732158370_673ea3a232e59.jpg\\\",\\\"dorm_pictures\\\\\\/1732158370_673ea3a2b1191.jpg\\\",\\\"dorm_pictures\\\\\\/1732158370_673ea3a2ded7b.jpg\\\",\\\"dorm_pictures\\\\\\/1732158371_673ea3a322507.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:05:18', '2024-11-20 20:29:01'),
(52, 68, 'Green Haven Eco-Lodge', 'Focused on sustainability, eco-lodges often use environmentally friendly materials, renewable energy, and locally sourced goods. Located in nature-rich areas, these options offer an immersive experience in natural surroundings', 'Poblacion Ward IV, Calajo-an, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.24552018, 123.79525423, 1500.00, 4, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1732158564_673ea4642bb62.jpg\\\",\\\"dorm_pictures\\\\\\/1732158564_673ea464b0d70.jpg\\\",\\\"dorm_pictures\\\\\\/1732158564_673ea464e052d.jpg\\\",\\\"dorm_pictures\\\\\\/1732158565_673ea4651babc.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:09:25', '2024-11-20 19:13:45'),
(53, 68, 'LuxTents Glamping Retreat', 'A luxurious glamping experience with king-sized beds, private decks, and en-suite bathrooms in spacious tents, nestled in a scenic national park.', 'Poblacion Ward III, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25229819, 123.80162716, 3000.00, 4, 3, 2, '\"[\\\"dorm_pictures\\\\\\/1732158997_673ea615bf80f.jpg\\\",\\\"dorm_pictures\\\\\\/1732158998_673ea61670693.jpg\\\",\\\"dorm_pictures\\\\\\/1732158998_673ea6169b54d.jpg\\\",\\\"dorm_pictures\\\\\\/1732158998_673ea616e7307.jpg\\\",\\\"dorm_pictures\\\\\\/1732158999_673ea6171b5aa.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:16:39', '2024-11-20 20:05:22'),
(54, 68, 'Sunny Grove Cottage', 'A charming 2-bedroom cottage in a quiet neighborhood, with a garden, outdoor patio, and modern amenities. Great for short stays or weekend getaways.', 'Poblacion Ward II, Calajo-an, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.24260623, 123.79503965, 1000.00, 4, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1732159148_673ea6ac4567b.jpg\\\",\\\"dorm_pictures\\\\\\/1732159148_673ea6acc833f.jpg\\\",\\\"dorm_pictures\\\\\\/1732159149_673ea6ad04edf.jpg\\\",\\\"dorm_pictures\\\\\\/1732159149_673ea6ad387ed.jpg\\\",\\\"dorm_pictures\\\\\\/1732159149_673ea6ad74168.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:19:09', '2024-11-20 20:10:40'),
(55, 68, 'Bahay sa Lungsod', 'A modern 3-bedroom townhouse located in the heart of the city. Features include a rooftop garden, fully furnished spaces, and easy access to shopping, restaurants, and public transport.', 'Cebu South Road, Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.24892504, 123.80340278, 2500.00, 5, 4, 3, '\"[\\\"dorm_pictures\\\\\\/1732159288_673ea7380d1a5.jpg\\\",\\\"dorm_pictures\\\\\\/1732159288_673ea738906b2.jpg\\\",\\\"dorm_pictures\\\\\\/1732159288_673ea738c0471.jpg\\\",\\\"dorm_pictures\\\\\\/1732159288_673ea738eed44.jpg\\\",\\\"dorm_pictures\\\\\\/1732159289_673ea73927f75.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:21:29', '2024-11-20 19:21:29'),
(56, 70, 'Bahay ng Pagdapo', 'A lavish 6-bedroom mansion located on a hill with stunning views of the surrounding city or beach. The house includes a gourmet kitchen, infinity pool, multiple lounges, and a garden, offering luxurious comforts for guests', 'Fonte di Versailles, Calajo-an, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.23776013, 123.79665971, 5000.00, 10, 7, 6, '\"[\\\"dorm_pictures\\\\\\/1732160894_673ead7e76d3d.jpg\\\",\\\"dorm_pictures\\\\\\/1732160895_673ead7f05af3.jpg\\\",\\\"dorm_pictures\\\\\\/1732160895_673ead7f355b0.jpg\\\",\\\"dorm_pictures\\\\\\/1732160895_673ead7f69110.jpg\\\",\\\"dorm_pictures\\\\\\/1732160895_673ead7f98ac4.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:48:15', '2024-11-20 19:48:15'),
(57, 70, 'Bahay Luntian', 'A charming 2-bedroom house surrounded by greenery, with a tropical garden and a porch perfect for morning coffee. Ideal for short stays, the house offers a cozy atmosphere with modern amenities.', 'Teves, Vito, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25381847, 123.79330158, 1500.00, 4, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1732161019_673eadfb8ee69.jpg\\\",\\\"dorm_pictures\\\\\\/1732161020_673eadfc1c440.jpg\\\",\\\"dorm_pictures\\\\\\/1732161020_673eadfc4bd59.jpg\\\",\\\"dorm_pictures\\\\\\/1732161020_673eadfc7b61a.jpg\\\",\\\"dorm_pictures\\\\\\/1732161020_673eadfcaa3a6.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:50:20', '2024-11-20 19:50:20'),
(58, 70, 'Bahay Alaga', 'A 3-bedroom, pet-friendly home featuring a large, fenced backyard where pets can roam freely. It also has easy access to pet-friendly parks and walking trails.', 'Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25491645, 123.80471706, 1200.00, 4, 4, 3, '\"[\\\"dorm_pictures\\\\\\/1732161236_673eaed4c348b.jpg\\\",\\\"dorm_pictures\\\\\\/1732161237_673eaed550c5b.jpg\\\",\\\"dorm_pictures\\\\\\/1732161237_673eaed57f5d3.jpg\\\",\\\"dorm_pictures\\\\\\/1732161237_673eaed5adfaa.jpg\\\",\\\"dorm_pictures\\\\\\/1732161237_673eaed5e8f2e.jpg\\\"]\"', 0, 1, 0, '2024-11-20 19:53:58', '2024-11-20 20:50:01'),
(59, 70, 'Bahay Bagong Buhay', 'A 2-bedroom eco-friendly home made with sustainable materials, complete with a solar power system, water conservation, and organic garden. Located in a serene environment, it\'s ideal for guests seeking a sustainable, green way of living.', 'Poblacion Ward IV, Vito, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.24893032, 123.79273295, 1300.00, 3, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1732161368_673eaf5854e73.jpg\\\",\\\"dorm_pictures\\\\\\/1732161368_673eaf58d588f.jpg\\\",\\\"dorm_pictures\\\\\\/1732161369_673eaf5914ec2.jpg\\\",\\\"dorm_pictures\\\\\\/1732161369_673eaf594bce8.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:56:09', '2024-11-20 21:09:01'),
(60, 70, 'Bahay Kanto', 'A modern 2-bedroom townhouse conveniently located near key city attractions, with easy access to public transport and local markets. Features a compact but stylish living area, a small garden, and an outdoor balcony.', 'Kingswood Village, Linao, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25542321, 123.80918026, 900.00, 3, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1732161454_673eafaeba1f1.jpg\\\",\\\"dorm_pictures\\\\\\/1732161455_673eafaf4376b.jpg\\\",\\\"dorm_pictures\\\\\\/1732161455_673eafaf7a9d5.jpg\\\",\\\"dorm_pictures\\\\\\/1732161455_673eafafa85cb.jpg\\\",\\\"dorm_pictures\\\\\\/1732161455_673eafafd5ed8.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:57:36', '2024-11-26 19:51:31'),
(61, 70, 'Bahay Bahay-nga', 'A heritage-style home with traditional Filipino architecture, beautifully preserved with antique wooden floors and classic furnishings. Located in a historical district, it offers a glimpse into Filipino culture while enjoying modern amenities.', 'Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.25113686, 123.81332159, 1700.00, 5, 3, 2, '\"[\\\"dorm_pictures\\\\\\/1732161565_673eb01d0a557.jpg\\\",\\\"dorm_pictures\\\\\\/1732590337_67453b01aecfc.jpg\\\",\\\"dorm_pictures\\\\\\/1732590338_67453b02442f1.jpg\\\",\\\"dorm_pictures\\\\\\/1732590338_67453b027638c.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:59:25', '2024-11-25 19:05:39');

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
(39, 69, 54, '2024-11-20 19:23:00', '2024-11-20 19:23:00'),
(40, 69, 55, '2024-11-20 19:23:02', '2024-11-20 19:23:02');

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
(39, '2024_11_05_141932_create_curse_words_table', 28),
(40, '2024_11_23_062120_add_stripe_account_id_to_users_table', 29),
(41, '2024_11_24_012747_create_wallets_table', 30),
(42, '2024_11_24_013058_create_wallet_transactions_table', 30);

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
(326, 14, 'Bills', '<strong>User Verification Pending</strong><br><p>A user has registered as an owner and is awaiting verification. Please review their application.</p><p><strong>User:</strong> Roland Shane Lopez</p><p><strong>Email:</strong> rshan0418@gmail.com</p><p><strong>Registered on:</strong> 2024-11-21 02:15:59</p><br><p>Sent on: 2024-11-21 02:16:00</p>', 0, 'http://localhost:8000/managepage/user', '2024-11-20 18:16:00', '2024-11-20 18:16:00', NULL, 68),
(327, 68, 'verification', '<strong>Account Verified</strong><br><p>Your account has been verified. You can now proceed to post or list accommodations for rent.</p><br><p>Sent on 2024-11-21 02:26:11</p>', 1, NULL, '2024-11-20 18:26:11', '2024-11-20 19:21:46', NULL, 14),
(328, 14, 'Bills', '<strong>User Verification Pending</strong><br><p>A user has registered as an owner and is awaiting verification. Please review their application.</p><p><strong>User:</strong> Degam Jhonry</p><p><strong>Email:</strong> jhonrydegamo@gmail.com</p><p><strong>Registered on:</strong> 2024-11-21 03:34:52</p><br><p>Sent on: 2024-11-21 03:34:52</p>', 1, 'http://localhost:8000/managepage/user', '2024-11-20 19:34:52', '2024-11-20 19:35:05', NULL, 70),
(329, 70, 'verification', '<strong>Account Verified</strong><br><p>Your account has been verified. You can now proceed to post or list accommodations for rent.</p><br><p>Sent on 2024-11-21 03:35:49</p>', 1, NULL, '2024-11-20 19:35:49', '2024-11-20 20:39:57', NULL, 14),
(330, 68, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation <strong>LuxTents Glamping Retreat</strong></p><br> <p>Date: 2024-11-21 04:04:24</p>', 1, 'http://localhost:8000/managetenant', '2024-11-20 20:04:24', '2024-11-20 20:04:30', 53, 69),
(331, 69, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: we are not available on LuxTents Glamping Retreat</p><br><p>Date: 2024-11-21 04:05:22</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:05:22', '2024-11-20 20:05:29', 53, 68),
(332, 68, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation <strong>Sunny Grove Cottage</strong></p><br> <p>Date: 2024-11-21 04:06:51</p>', 1, 'http://localhost:8000/managetenant', '2024-11-20 20:06:51', '2024-11-20 20:07:27', 54, 69),
(333, 69, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at <strong>Sunny Grove Cottage</strong> has been successfully approved.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-21 04:07:54</p><p>We look forward to hosting you!</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:07:54', '2024-11-20 20:07:59', 54, 68),
(334, 68, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Financial reasons on <strong>Sunny Grove Cottage</strong></p><br><p>Sent on 2024-11-21 04:08:19</p>', 1, 'http://localhost:8000/managetenant', '2024-11-20 20:08:19', '2024-11-20 20:10:00', 54, 69),
(335, 69, 'Cancellation Response', '<strong>Booking Cancellation Rejected</strong><br><p>Unfortunately, your request for cancellation has been declined.</p><br><p>Sent on2024-11-21 04:10:08</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:10:08', '2024-11-20 20:10:13', 54, 68),
(336, 68, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Issue with booking process on <strong>Sunny Grove Cottage</strong></p><br><p>Sent on 2024-11-21 04:10:27</p>', 1, 'http://localhost:8000/managetenant', '2024-11-20 20:10:27', '2024-11-20 20:10:33', 54, 69),
(337, 69, 'Cancellation Response', '<strong>Booking Cancellation Approved</strong><br><p>Your request for cancellation has been processed successfully.</p><br><p>Sent on2024-11-21 04:10:40</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:10:40', '2024-11-20 20:10:47', 54, 68),
(338, 68, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation <strong>The Velvet Boutique Hotel</strong></p><br> <p>Date: 2024-11-21 04:11:37</p>', 1, 'http://localhost:8000/managetenant', '2024-11-20 20:11:37', '2024-11-20 20:11:41', 51, 69),
(339, 69, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at <strong>The Velvet Boutique Hotel</strong> has been successfully approved.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-21 04:12:05</p><p>We look forward to hosting you!</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:12:05', '2024-11-20 20:12:09', 51, 68),
(340, 69, 'upcoming_stay', '<p>Your stay at The Velvet Boutique Hotel starts in 1 day! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-20 20:12:19', '2024-11-20 20:12:23', 51, 68),
(341, 69, 'Booking Start', '<strong>Booking started</strong><br><p>Your booking for <strong>The Velvet Boutique Hotel</strong> has started successfully.</p><br><p>Bill Amount: <strong>₱14,000.00</strong></p><p>Billing Date: <strong>2024-11-30</strong></p><br><p>Sent on: 2024-11-21 04:14:01</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:14:01', '2024-11-20 20:14:10', 51, 14),
(342, 69, 'Bills', '<strong>Payment Reminder</strong><br><p>Your Payment has been marked paid. You paid <strong>₱14,000.00</strong> on <strong>The Velvet Boutique Hotel</strong></p><br><p>Paid on: <strong>2024-11-21 04:24:53</strong></p><p>Mode of Payment: <strong>e_wallet</strong></p><br><p>Sent on: 2024-11-21 04:24:54</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:24:54', '2024-11-20 20:25:29', 51, 68),
(343, 69, 'review', '<strong>Your rent has ended</strong> <br> <p>Your rent has ended on <strong>The Velvet Boutique Hotel</strong> Please leave a review for the Accomodation.</p><br><p>Sent on: 2024-11-21 04:29:01</p>', 1, 'http://localhost:8000/my-reviews', '2024-11-20 20:29:01', '2024-11-20 20:29:10', 51, 14),
(344, 69, 'warning', '<strong>Warning issued:</strong> <br> <p>Your review contains inappropriate words.</p> <br><strong>You have 2 remaining Strike(s)</strong>', 1, NULL, '2024-11-20 20:30:04', '2024-11-20 20:30:12', NULL, 69),
(345, 70, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation <strong>Bahay Bahay-nga</strong></p><br> <p>Date: 2024-11-21 04:34:16</p>', 1, 'http://localhost:8000/managetenant', '2024-11-20 20:34:16', '2024-11-20 20:34:21', 61, 71),
(346, 70, 'Booking Cancellation', '<strong>Booking Cancellation</strong><br><p>Booking Cancelled due to: Found a better place on <strong>Bahay Bahay-nga</strong></p><br><p>Sent on2024-11-21 04:34:38</p>', 1, 'http://localhost:8000/managetenant', '2024-11-20 20:34:38', '2024-11-20 20:34:44', 61, 71),
(347, 70, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation <strong>Bahay Alaga</strong></p><br> <p>Date: 2024-11-21 04:36:51</p>', 1, 'http://localhost:8000/managetenant', '2024-11-20 20:36:51', '2024-11-20 20:39:54', 58, 71),
(348, 71, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at <strong>Bahay Alaga</strong> has been successfully approved.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-21 04:37:03</p><p>We look forward to hosting you!</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:37:03', '2024-11-20 20:37:27', 58, 70),
(349, 71, 'upcoming_stay', '<p>Your stay at Bahay Alaga starts in 1 day! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-20 20:37:12', '2024-11-20 20:37:18', 58, 70),
(350, 71, 'upcoming_stay', '<p>Your stay at Bahay Alaga starts today! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-20 20:38:01', '2024-11-20 20:38:04', 58, 70),
(351, 71, 'Booking Start', '<strong>Booking started</strong><br><p>Your booking for <strong>Bahay Alaga</strong> has started successfully.</p><br><p>Bill Amount: <strong>₱6,000.00</strong></p><p>Billing Date: <strong>2024-11-28</strong></p><br><p>Sent on: 2024-11-21 04:39:00</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:39:00', '2024-11-20 20:39:13', 58, 14),
(352, 71, 'Bills', '<strong>Payment Reminder</strong><br><p>The owner has sent a notification regarding your upcoming payment.</p><br><p>Date: 2024-11-21 04:39:23</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:39:23', '2024-11-20 20:39:33', 58, 70),
(353, 71, 'Bills', '<strong>Payment Reminder</strong><br><p>Your Payment has been marked paid. You paid <strong>₱6,000.00</strong> on <strong>Bahay Alaga</strong></p><br><p>Paid on: <strong>2024-11-23 04:40:27</strong></p><p>Mode of Payment: <strong>cash</strong></p><br><p>Sent on: 2024-11-21 04:40:27</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:40:27', '2024-11-20 20:40:32', 58, 70),
(354, 71, 'review', '<strong>Your rent has ended</strong> <br> <p>Your rent has ended on <strong>Bahay Alaga</strong> Please leave a review for the Accomodation.</p><br><p>Sent on: 2024-11-21 04:50:01</p>', 1, 'http://localhost:8000/my-reviews', '2024-11-20 20:50:01', '2024-11-20 20:50:09', 58, 14),
(355, 70, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation <strong>Bahay Bagong Buhay</strong></p><br> <p>Date: 2024-11-21 04:52:28</p>', 1, 'http://localhost:8000/managetenant', '2024-11-20 20:52:28', '2024-11-20 20:52:35', 59, 71),
(356, 71, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at <strong>Bahay Bagong Buhay</strong> has been successfully approved.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-21 04:52:46</p><p>We look forward to hosting you!</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:52:46', '2024-11-20 20:53:14', 59, 70),
(357, 70, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Personal reasons on <strong>Bahay Bagong Buhay</strong></p><br><p>Sent on 2024-11-21 04:53:24</p>', 1, 'http://localhost:8000/managetenant', '2024-11-20 20:53:24', '2024-11-20 20:53:30', 59, 71),
(358, 71, 'Cancellation Response', '<strong>Booking Cancellation Approved</strong><br><p>Your request for cancellation has been processed successfully.</p><br><p>Sent on2024-11-21 04:53:41</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:53:41', '2024-11-20 20:53:47', 59, 70),
(359, 68, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation <strong>Guesthouse</strong></p><br> <p>Date: 2024-11-21 04:55:11</p>', 1, 'http://localhost:8000/managetenant', '2024-11-20 20:55:11', '2024-11-20 20:55:19', 50, 71),
(360, 71, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at <strong>Guesthouse</strong> has been successfully approved.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-21 04:55:29</p><p>We look forward to hosting you!</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:55:29', '2024-11-20 20:55:36', 50, 68),
(361, 71, 'Booking Start', '<strong>Booking started</strong><br><p>Your booking for <strong>Guesthouse</strong> has started successfully.</p><br><p>Bill Amount: <strong>₱7,000.00</strong></p><p>Billing Date: <strong>2024-11-30</strong></p><br><p>Sent on: 2024-11-21 04:55:51</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:55:51', '2024-11-20 20:56:04', 50, 14),
(362, 71, 'Bills', '<strong>Payment Reminder</strong><br><p>The owner has sent a notification regarding your upcoming payment.</p><br><p>Date: 2024-11-21 04:56:24</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:56:24', '2024-11-20 20:56:49', 50, 68),
(363, 71, 'Bills', '<strong>Payment Reminder</strong><br><p>Your Payment has been marked paid. You paid <strong>₱7,000.00</strong> on <strong>Guesthouse</strong></p><br><p>Paid on: <strong>2024-11-20 04:59:50</strong></p><p>Mode of Payment: <strong>credit_card</strong></p><br><p>Sent on: 2024-11-21 04:59:51</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 20:59:51', '2024-11-20 20:59:55', 50, 68),
(364, 71, 'review', '<strong>Your rent has ended</strong> <br> <p>Your rent has ended on <strong>Guesthouse</strong> Please leave a review for the Accomodation.</p><br><p>Sent on: 2024-11-21 05:01:01</p>', 1, 'http://localhost:8000/my-reviews', '2024-11-20 21:01:01', '2024-11-20 21:01:08', 50, 14),
(365, 70, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation <strong>Bahay Bagong Buhay</strong></p><br> <p>Date: 2024-11-21 05:04:26</p>', 1, 'http://localhost:8000/managetenant', '2024-11-20 21:04:26', '2024-11-20 21:04:31', 59, 69),
(366, 69, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at <strong>Bahay Bagong Buhay</strong> has been successfully approved.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-21 05:04:43</p><p>We look forward to hosting you!</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 21:04:43', '2024-11-20 21:04:51', 59, 70),
(367, 69, 'upcoming_stay', '<p>Your stay at Bahay Bagong Buhay starts today! Please be prepared for your check-in.</p>', 1, NULL, '2024-11-20 21:05:27', '2024-11-20 21:05:32', 59, 70),
(368, 69, 'Booking Start', '<strong>Booking started</strong><br><p>Your booking for <strong>Bahay Bagong Buhay</strong> has started successfully.</p><br><p>Bill Amount: <strong>₱6,500.00</strong></p><p>Billing Date: <strong>2024-11-28</strong></p><br><p>Sent on: 2024-11-21 05:06:00</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 21:06:00', '2024-11-20 21:06:09', 59, 14),
(369, 69, 'Bills', '<strong>Payment Reminder</strong><br><p>The owner has sent a notification regarding your upcoming payment.</p><br><p>Date: 2024-11-21 05:07:04</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 21:07:04', '2024-11-20 21:07:10', 59, 70),
(370, 69, 'Bills', '<strong>Payment Reminder</strong><br><p>Your Payment has been marked paid. You paid <strong>₱6,500.00</strong> on <strong>Bahay Bagong Buhay</strong></p><br><p>Paid on: <strong>2024-11-20 05:07:41</strong></p><p>Mode of Payment: <strong>bank_transfer</strong></p><br><p>Sent on: 2024-11-21 05:07:41</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-20 21:07:41', '2024-11-20 21:07:48', 59, 70),
(371, 69, 'review', '<strong>Your rent has ended</strong> <br> <p>Your rent has ended on <strong>Bahay Bagong Buhay</strong> Please leave a review for the Accomodation.</p><br><p>Sent on: 2024-11-21 05:09:01</p>', 1, 'http://localhost:8000/my-reviews', '2024-11-20 21:09:01', '2024-11-20 21:09:12', 59, 14),
(372, 69, 'warning', '<strong>Warning issued:</strong> <br> <p>Your review contains inappropriate words.</p> <br><strong>You have 1 remaining Strike(s)</strong>', 1, NULL, '2024-11-22 19:30:24', '2024-11-22 19:30:45', NULL, 69),
(373, 69, 'warning', '<strong>Warning issued:</strong> <p>Your review contains inappropriate words.</p>', 1, NULL, '2024-11-22 19:35:55', '2024-11-23 23:43:03', NULL, 70),
(374, 69, 'warning', '<strong>Warning issued:</strong> <br> <p>Your review contains inappropriate words.</p> <br><strong>You have 2 remaining Strike(s)</strong>', 1, NULL, '2024-11-22 19:40:26', '2024-11-22 19:40:33', NULL, 14),
(375, 14, 'Bills', '<strong>Cash-In Transaction</strong><br>\r\n                    <p>User <strong>Roland Shane Lopez</strong> has successfully added funds to their wallet.</p>\r\n                    <p><strong>Amount:</strong> ₱100.00</p>\r\n                    <p><strong>Date:</strong> 2024-11-25 01:39:37</p>', 0, NULL, '2024-11-24 17:39:37', '2024-11-24 17:39:37', NULL, 14),
(376, 69, 'Bills', '<strong>Cash-In Transaction</strong><br>\r\n                    <p>User <strong>Roland Shane Lopez</strong> has successfully added funds to their wallet.</p>\r\n                    <p><strong>Amount:</strong> ₱1,000.00</p>\r\n                    <p><strong>Date:</strong> 2024-11-25 01:40:50</p>', 1, NULL, '2024-11-24 17:40:50', '2024-11-24 17:41:01', NULL, 14),
(377, 69, 'Bills', '<strong>Cash-In Transaction</strong><br>\r\n                    <p>User <strong>Roland Shane Lopez</strong> has successfully added funds to their wallet.</p>\r\n                    <p><strong>Amount:</strong> ₱1,000.00</p>\r\n                    <p><strong>Date:</strong> 2024-11-25 03:05:21</p>', 1, NULL, '2024-11-24 19:05:22', '2024-11-24 19:05:31', NULL, 14),
(378, 69, 'Bills', '<strong>Cash-In Transaction</strong><br>\r\n                    <p>User <strong>Roland Shane Lopez</strong> has successfully added funds to their wallet.</p>\r\n                    <p><strong>Amount:</strong> ₱200.00</p>\r\n                    <p><strong>Date:</strong> 2024-11-26 02:12:47</p>', 0, NULL, '2024-11-25 18:12:47', '2024-11-25 18:12:47', NULL, 14),
(379, 70, 'Bills', '<strong>Cash-In Transaction</strong><br>\r\n                    <p>User <strong>Degam Jhonry</strong> has successfully added funds to their wallet.</p>\r\n                    <p><strong>Amount:</strong> ₱700.00</p>\r\n                    <p><strong>Date:</strong> 2024-11-26 05:19:27</p>', 0, NULL, '2024-11-25 21:19:27', '2024-11-25 21:19:27', NULL, 14),
(380, 70, 'Bills', '<strong>Cash-In Transaction</strong><br>\r\n                    <p>User <strong>Degam Jhonry</strong> has successfully added funds to their wallet.</p>\r\n                    <p><strong>Amount:</strong> ₱700.00</p>\r\n                    <p><strong>Date:</strong> 2024-11-26 05:35:40</p>', 0, NULL, '2024-11-25 21:35:40', '2024-11-25 21:35:40', NULL, 14),
(381, 70, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone Booked your Accomodation <strong>Bahay Kanto</strong></p><br> <p>Date: 2024-11-27 02:30:41</p>', 0, 'http://localhost:8000/managetenant', '2024-11-26 18:30:41', '2024-11-26 18:30:41', 60, 69),
(382, 70, 'Booking Cancellation', '<strong>Booking Cancellation</strong><br><p>Booking Cancelled due to: Financial reasons on <strong>Bahay Kanto</strong></p><br><p>Sent on2024-11-27 02:32:02</p>', 0, 'http://localhost:8000/managetenant', '2024-11-26 18:32:02', '2024-11-26 18:32:02', 60, 69),
(383, 70, 'Booking Cancellation', '<strong>Booking Cancellation</strong><br><p>Booking Cancelled due to: Personal reasons on <strong>Bahay Kanto</strong></p><br><p>Sent on2024-11-27 02:45:01</p>', 0, 'http://localhost:8000/managetenant', '2024-11-26 18:45:01', '2024-11-26 18:45:01', 60, 69),
(384, 70, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone booked your accommodation <strong>Bahay Kanto</strong></p><br> <p>Date: 2024-11-27 02:45:23</p>', 1, 'http://localhost:8000/managetenant', '2024-11-26 18:45:23', '2024-11-26 18:45:42', 60, 69),
(385, 69, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: dsadad on Bahay Kanto</p><br><p>Date: 2024-11-27 02:48:13</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-26 18:48:13', '2024-11-26 18:55:29', 60, 70),
(386, 70, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone booked your accommodation <strong>Bahay Kanto</strong></p><br> <p>Start Date: 2024-11-28 | End Date: 2024-11-29 | Guests: 1</p><br><p>Date: 2024-11-27 02:52:57</p>', 1, 'http://localhost:8000/managetenant', '2024-11-26 18:52:57', '2024-11-26 19:55:17', 60, 69),
(387, 70, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone booked your accommodation <strong>Bahay Kanto</strong></p><br> <p>Start Date: 2024-11-28 | End Date: 2024-11-29 | Guests: 3</p><br><p>Date: 2024-11-27 02:55:20</p>', 1, 'http://localhost:8000/managetenant', '2024-11-26 18:55:20', '2024-11-26 18:55:32', 60, 69),
(388, 69, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at <strong>Bahay Kanto</strong> has been successfully approved.</p><p>And a ₱900.00 has deducted to your wallet for payment.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-27 03:43:56</p><p>We look forward to hosting you!</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-26 19:43:56', '2024-11-26 19:44:02', 60, 70),
(389, 70, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Found a better place on <strong>Bahay Kanto</strong></p><br><p>Sent on 2024-11-27 03:51:03</p>', 1, 'http://localhost:8000/managetenant', '2024-11-26 19:51:03', '2024-11-26 19:51:09', 60, 69),
(390, 69, 'Cancellation Response', '<strong>Booking Cancellation Approved</strong><br><p>Your request for cancellation has been processed successfully.</p><br><p>And a ₱900.00 has been added to your wallet for Refund.</p><br><p>Sent on2024-11-27 03:51:31</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-26 19:51:31', '2024-11-26 19:51:36', 60, 70),
(391, 69, 'Bills', '<strong>Cash-In Transaction</strong><br>\r\n                    <p>User <strong>Roland Shane Lopez</strong> has successfully added funds to their wallet.</p>\r\n                    <p><strong>Amount:</strong> ₱1,000.00</p>\r\n                    <p><strong>Date:</strong> 2024-11-27 03:53:59</p>', 1, NULL, '2024-11-26 19:53:59', '2024-11-27 19:21:02', NULL, 14),
(392, 68, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone booked your accommodation <strong>Guesthouse</strong></p><br> <p>Date: 2024-11-27 05:14:22</p>', 1, 'http://localhost:8000/managetenant', '2024-11-26 21:14:22', '2024-11-27 19:19:48', 50, 69),
(393, 71, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: oh no on Guesthouse</p><br><p>Date: 2024-11-28 03:22:53</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-27 19:22:53', '2024-11-27 19:23:25', 50, 68),
(394, 71, 'Bills', '<strong>Cash-In Transaction</strong><br>\r\n                    <p>User <strong>shane lopez</strong> has successfully added funds to their wallet.</p>\r\n                    <p><strong>Amount:</strong> ₱10,000.00</p>\r\n                    <p><strong>Date:</strong> 2024-11-28 03:29:12</p>', 1, NULL, '2024-11-27 19:29:12', '2024-11-27 19:29:22', NULL, 14),
(395, 68, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone booked your accommodation <strong>Guesthouse</strong></p><br> <p>Date: 2024-11-28 03:38:36</p>', 1, 'http://localhost:8000/managetenant', '2024-11-27 19:38:36', '2024-11-27 19:38:41', 50, 71),
(396, 71, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: dadad on Guesthouse</p><br><p>Date: 2024-11-28 03:40:16</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-27 19:40:16', '2024-11-27 19:40:20', 50, 68),
(397, 68, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone booked your accommodation <strong>Guesthouse</strong></p><br> <p>Date: 2024-11-28 03:50:33</p>', 1, 'http://localhost:8000/managetenant', '2024-11-27 19:50:33', '2024-11-27 19:50:42', 50, 71),
(398, 71, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at <strong>Guesthouse</strong> has been successfully approved.</p><p>And a ₱8,000.00 has deducted to your wallet for payment.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-28 03:52:38</p><p>We look forward to hosting you!</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-27 19:52:38', '2024-11-27 20:47:25', 50, 68),
(399, 68, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone booked your accommodation <strong>Rainy Days Guesthouse</strong></p><br> <p>Date: 2024-11-28 03:53:09</p>', 1, 'http://localhost:8000/managetenant', '2024-11-27 19:53:09', '2024-11-27 19:53:26', 49, 69),
(400, 68, 'Booking Cancellation', '<strong>Booking Cancellation</strong><br><p>Booking Cancelled due to: Found a better place on <strong>Rainy Days Guesthouse</strong></p><br><p>Sent on2024-11-28 03:54:41</p>', 1, 'http://localhost:8000/managetenant', '2024-11-27 19:54:41', '2024-11-27 19:54:49', 49, 69),
(401, 71, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: dsad on Guesthouse</p><br><p>Date: 2024-11-28 04:18:26</p>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-27 20:18:26', '2024-11-27 20:18:26', 50, 68),
(402, 71, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: dsada on Guesthouse</p><br><p>Date: 2024-11-28 04:18:55</p>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-27 20:18:55', '2024-11-27 20:18:55', 50, 68),
(403, 71, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: dsa on Guesthouse</p><br><p>Date: 2024-11-28 04:22:25</p>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-27 20:22:25', '2024-11-27 20:22:25', 50, 68),
(404, 71, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: dasd on Guesthouse</p><br><p>Date: 2024-11-28 04:22:35</p>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-27 20:22:35', '2024-11-27 20:22:35', 50, 68),
(405, 71, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: 6 on Guesthouse</p><br><p>Date: 2024-11-28 04:38:20</p>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-27 20:38:20', '2024-11-27 20:38:20', 50, 68),
(406, 71, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: 254 on Guesthouse</p><br><p>Date: 2024-11-28 04:38:30</p>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-27 20:38:30', '2024-11-27 20:38:30', 50, 68),
(407, 71, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: dsad on Guesthouse</p><br><p>Date: 2024-11-28 04:42:23</p>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-27 20:42:23', '2024-11-27 20:42:23', 50, 68),
(408, 71, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: dsa on Guesthouse</p><br><p>Date: 2024-11-28 04:42:32</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-27 20:42:32', '2024-11-27 20:47:15', 50, 68),
(409, 68, 'Booking Cancellation', '<strong>Booking Cancellation</strong><br><p>Booking Cancelled due to: Found a better place on <strong>Guesthouse</strong></p><br><p>Sent on2024-11-28 04:48:30</p>', 0, 'http://localhost:8000/managetenant', '2024-11-27 20:48:30', '2024-11-27 20:48:30', 50, 71),
(410, 68, 'Booking Cancellation', '<strong>Booking Cancellation request</strong><br><p>Cancellation request: Found a better place on <strong>Guesthouse</strong></p><br><p>Sent on 2024-11-28 04:49:37</p>', 1, 'http://localhost:8000/managetenant', '2024-11-27 20:49:37', '2024-11-27 20:49:42', 50, 71),
(411, 69, 'Form Response', '<strong>Booking rejected</strong><br><p>Booking rejected: 42 on Guesthouse</p><br><p>Date: 2024-11-28 04:50:52</p>', 0, 'http://localhost:8000/user/rent-forms', '2024-11-27 20:50:52', '2024-11-27 20:50:52', 50, 68),
(412, 71, 'Cancellation Response', '<strong>Booking Cancellation Approved</strong><br><p>Your request for cancellation has been processed successfully.</p><br><p>And a ₱8,000.00 has been added to your wallet for Refund.</p><br><p>Sent on2024-11-28 04:51:03</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-27 20:51:03', '2024-11-27 20:51:07', 50, 68),
(413, 68, 'Form Submit', '<strong>Someone Booked</strong> <br> <p>Someone booked your accommodation <strong>Guesthouse</strong></p><br> <p>Date: 2024-11-28 04:51:53</p>', 1, 'http://localhost:8000/managetenant', '2024-11-27 20:51:53', '2024-11-27 20:54:31', 50, 71),
(414, 71, 'Form Response', '<strong>Booking Approved</strong><br><p>Congratulations! Your booking at <strong>Guesthouse</strong> has been successfully approved.</p><p>And a ₱8,000.00 has deducted to your wallet for payment.</p><p>Please prepare for your stay and let us know if you have any questions.</p><p>Date Approved: 2024-11-28 04:52:24</p><p>We look forward to hosting you!</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-27 20:52:24', '2024-11-27 20:52:27', 50, 68),
(415, 71, 'Booking Start', '<strong>Booking started</strong><br><p>Your booking for <strong>Guesthouse</strong> has started successfully.</p><br><p>Check-in Date: <strong>2024-11-28</strong></p><p>Check-out Date: <strong>2024-12-07</strong></p><br><p>Sent on: 2024-11-28 04:58:00</p>', 1, 'http://localhost:8000/user/rent-forms', '2024-11-27 20:58:00', '2024-11-27 20:58:17', 50, 14),
(416, 68, 'Earning Received', '<strong>Money Received</strong><br><p>You have received a payment of <strong>₱8,000.00</strong> for the booking of <strong>Guesthouse</strong>.</p><br><p>Booking has started.</p><br><p>Sent on: 2024-11-28 04:58:01</p>', 1, 'http://localhost:8000/managetenant', '2024-11-27 20:58:01', '2024-11-27 21:00:21', 50, 71),
(417, 71, 'review', '<strong>Your rent has ended</strong> <br> <p>Your rent has ended on <strong>Guesthouse</strong> Please leave a review for the Accomodation.</p><br><p>Sent on: 2024-11-28 05:12:01</p>', 1, 'http://localhost:8000/my-reviews', '2024-11-27 21:12:01', '2024-11-27 21:12:10', 50, 14),
(418, 71, 'review', '<strong>Your rent has ended</strong> <br> <p>Your rent has ended on <strong>Guesthouse</strong> Please leave a review for the Accomodation.</p><br><p>Sent on: 2024-11-28 05:15:01</p>', 1, 'http://localhost:8000/my-reviews', '2024-11-27 21:15:01', '2024-11-27 21:15:14', 50, 14),
(419, 68, 'booking_ended', '<strong>Booking Ended</strong> <br><p>The booking for your accommodation <strong>Guesthouse</strong> has ended.</p><br><p>Tenant: shane lopez</p><p>End Date: 2024-11-28</p><br><p>Sent on: 2024-11-28 05:15:01</p>', 1, NULL, '2024-11-27 21:15:01', '2024-11-27 21:15:07', 50, 14),
(420, 70, 'Bills', '<strong>Cash-In Transaction</strong><br>\r\n                    <p>User <strong>Degam Jhonry</strong> has successfully added funds to their wallet.</p>\r\n                    <p><strong>Amount:</strong> ₱1,000.00</p>\r\n                    <p><strong>Date:</strong> 2024-12-02 04:28:42</p>', 0, NULL, '2024-12-01 20:28:42', '2024-12-01 20:28:42', NULL, 14),
(421, 14, 'Reported', '<strong>Report Complaint</strong><p>A user has reported a complaint regarding a user: <strong>shane lopez</strong>. Please review the report and take the necessary actions.</p>', 1, 'http://localhost:8000/reports', '2024-12-02 19:58:40', '2024-12-02 19:58:45', NULL, 70),
(422, 14, 'Reported', '<strong>Report Complaint</strong><p>A user has reported a complaint regarding a user: <strong>Roland Shane Lopez</strong>. Please review the report and take the necessary actions.</p>', 1, 'http://localhost:8000/reports', '2024-12-02 19:59:20', '2024-12-02 19:59:23', NULL, 70),
(423, 69, 'rejection', 'Your cash-out request of ₱-100.00 has been rejected. Reason: Insufficient information', 1, 'http://localhost:8000/wallet/cashout', '2024-12-02 21:49:57', '2024-12-02 21:50:12', NULL, 14),
(424, 69, 'approval', 'Your cash-out request of ₱-100.00 has been approved.', 1, 'http://localhost:8000/wallet/cashout', '2024-12-02 21:50:59', '2024-12-02 21:51:03', NULL, 14),
(425, 69, 'approval', 'Your cash-out request of ₱-100.00 has been approved.', 1, 'http://localhost:8000/wallet/cashout', '2024-12-02 21:51:53', '2024-12-02 21:52:05', NULL, 14),
(426, 69, 'warning', 'Your booking for <strong>Guesthouse</strong> has been automatically cancelled due to no response within 24 hours.', 1, 'http://localhost:8000/user/rent-forms', '2024-12-02 22:28:00', '2024-12-02 22:28:06', 50, 14);

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
(27, 69, 55, '2024-11-20 19:22:09', '2024-11-20 19:22:09'),
(28, 69, 54, '2024-11-20 19:23:04', '2024-11-20 19:23:04'),
(29, 69, 58, '2024-11-20 20:01:39', '2024-11-20 20:01:39'),
(30, 69, 56, '2024-11-20 20:02:31', '2024-11-20 20:02:31'),
(31, 69, 53, '2024-11-20 20:02:40', '2024-11-20 20:02:40'),
(32, 69, 51, '2024-11-20 20:11:29', '2024-11-20 20:11:29'),
(33, 69, 61, '2024-11-20 20:23:16', '2024-11-20 20:23:16'),
(34, 71, 61, '2024-11-20 20:33:26', '2024-11-20 20:33:26'),
(35, 71, 58, '2024-11-20 20:36:37', '2024-11-20 20:36:37'),
(36, 71, 59, '2024-11-20 20:51:56', '2024-11-20 20:51:56'),
(37, 71, 50, '2024-11-20 20:54:07', '2024-11-20 20:54:07'),
(38, 69, 59, '2024-11-20 21:03:52', '2024-11-20 21:03:52'),
(39, 69, 60, '2024-11-22 17:58:09', '2024-11-22 17:58:09'),
(40, 69, 50, '2024-11-26 20:20:58', '2024-11-26 20:20:58'),
(41, 69, 57, '2024-11-26 20:38:29', '2024-11-26 20:38:29'),
(42, 71, 60, '2024-11-27 19:29:49', '2024-11-27 19:29:49'),
(43, 69, 49, '2024-11-27 19:53:01', '2024-11-27 19:53:01');

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
(52, 69, 53, '2024-11-23', '2024-11-29', 3, 18000.00, 'rejected', 'we are not available', '2024-11-20 20:04:24', '2024-11-20 20:05:22'),
(53, 69, 54, '2024-11-23', '2024-11-26', 4, 4000.00, 'cancelled', 'Issue with booking process', '2024-11-20 20:06:51', '2024-11-20 20:10:40'),
(54, 69, 51, '2024-11-20', '2024-11-29', 3, 14000.00, 'completed', NULL, '2024-11-20 20:11:37', '2024-11-20 20:29:01'),
(55, 71, 61, '2024-11-23', '2024-11-30', 4, 11900.00, 'cancelled', 'Found a better place', '2024-11-20 20:34:16', '2024-11-20 20:34:39'),
(56, 71, 58, '2024-11-21', '2024-11-29', 3, 6000.00, 'completed', NULL, '2024-11-20 20:36:51', '2024-11-20 20:50:01'),
(57, 71, 59, '2024-11-23', '2024-11-29', 3, 7800.00, 'cancelled', 'Personal reasons', '2024-11-20 20:52:28', '2024-11-20 20:53:41'),
(58, 69, 50, '2024-11-27', '2024-12-07', 4, 7000.00, 'rejected', '42', '2024-11-20 20:55:11', '2024-11-27 20:50:52'),
(59, 69, 59, '2024-11-21', '2024-11-21', 3, 6500.00, 'completed', NULL, '2024-11-20 21:04:26', '2024-11-20 21:09:01'),
(60, 69, 60, '2024-11-28', '2024-11-29', 1, 900.00, 'cancelled', 'Financial reasons', '2024-11-26 18:30:41', '2024-11-26 18:32:03'),
(61, 69, 60, '2024-11-28', '2024-11-29', 1, 900.00, 'cancelled', 'Personal reasons', '2024-11-26 18:43:02', '2024-11-26 18:45:02'),
(62, 69, 60, '2024-11-28', '2024-11-29', 1, 900.00, 'rejected', 'dsadad', '2024-11-26 18:45:23', '2024-11-26 18:48:14'),
(65, 69, 60, '2024-11-28', '2024-11-29', 3, 900.00, 'cancelled', 'Found a better place', '2024-11-26 18:55:20', '2024-11-26 19:51:31'),
(66, 69, 50, '2024-12-08', '2024-12-11', 3, 3000.00, 'cancelled', NULL, '2024-11-26 21:14:22', '2024-11-26 21:14:22'),
(68, 71, 50, '2024-11-29', '2024-12-07', 2, 8000.00, 'cancelled', 'Found a better place', '2024-11-27 19:50:33', '2024-11-27 20:51:03'),
(69, 69, 49, '2024-11-30', '2024-12-07', 1, 8400.00, 'cancelled', 'Found a better place', '2024-11-27 19:53:09', '2024-11-27 19:54:42'),
(70, 69, 50, '2024-11-28', '2024-11-28', 1, 8000.00, 'cancelled', 'Automatically cancelled due to no response for more than 1 day.', '2024-12-01 20:51:53', '2024-12-02 22:28:00');

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
(23, 70, 71, 'user', NULL, 'Inappropriate Content', 'pending', '2024-12-02 19:58:40', '2024-12-02 19:58:40'),
(24, 70, 69, 'user', NULL, 'gwapo man', 'pending', '2024-12-02 19:59:20', '2024-12-02 19:59:20');

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
(11, 69, 51, 5, 'nice', '2024-11-20 20:29:01', '2024-11-22 19:40:48'),
(12, 71, 58, 5, 'very good house', '2024-11-20 20:50:01', '2024-11-20 20:50:49'),
(13, 71, 50, 1, 'this house is horrible', '2024-11-20 21:01:01', '2024-11-20 21:01:28'),
(14, 69, 59, 2, 'bad Accomodation', '2024-11-20 21:09:01', '2024-11-20 21:09:27'),
(16, 71, 50, NULL, NULL, '2024-11-27 21:15:01', '2024-11-27 21:15:01');

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
('3Xhd6shRPxXrdQhtfOrell85ZikWKzr7oJuwL8vV', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiejZKYWk1SktYdEw5S1FRWXBZM1VYNWs1YnFkZmxSRmp1RHkxb01DRyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNjoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL3dhbGxldC9jYXNob3V0Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ub3RpZmljYXRpb25zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTQ7fQ==', 1733205133),
('riTVFp35UmJ8DkraMxxDrvPWLta6k35EJtH3gE7o', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidXVnYkt2VGtsVldoTkhPcU5aVWtBQ2VTQWViTXRMeW53bkxIY2ZrMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ub3RpZmljYXRpb25zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTQ7fQ==', 1733207710);

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
  `email_verified_at` datetime DEFAULT NULL,
  `stripe_account_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `phone`, `fb_id`, `google_id`, `profile_picture`, `address`, `remember_token`, `created_at`, `updated_at`, `active_status`, `verify_status`, `role`, `strike`, `note`, `email_verification_code`, `email_verified_at`, `stripe_account_id`) VALUES
(14, 'Lopez Roland Shane', 'lopezrolandshane@gmail.com', 'shaner', '$2y$12$KWBaHsB1eLFlGJ.2D.LF2O8u4qpNORuowbKP1xj0zcedchtSRZ81a', '12314134', 0, '107236937285983559710', 'profile-pictures/NsqtYbR4bm9qTg7FvyIID8MApPz7MhofeBfoJ5WS.jpg', 'dsadsadad', NULL, '2024-08-11 19:56:43', '2024-11-15 06:09:28', 0, 0, 'admin', 3, NULL, 796437, '2024-11-07 04:19:18', NULL),
(68, 'Roland Shane Lopez', 'rshan0418@gmail.com', 'roland', '$2y$12$M9.0fLzVbEpg5m3lYEzPcuMg5u28fVIyWZjmqIGOLcTA8KfWW80.O', '09661805821', NULL, NULL, 'profile_picture/kEDKEjA3jRNNPztmQNrveSXYF.jpg', 'purok 3 tres de mayo', NULL, '2024-11-20 18:15:59', '2024-11-20 20:32:21', 0, 1, 'owner', 3, NULL, NULL, '2024-11-21 02:16:40', NULL),
(69, 'Roland Shane Lopez', 'rshan5418@gmail.com', NULL, NULL, '090909090909', 1071441051576088, NULL, 'profile_picture/17P7uknT1nLNN3tJZEDWeodhu.jpg', 'purok 3 tres de mayo', NULL, '2024-11-20 18:23:38', '2024-11-22 19:40:26', 0, 0, 'tenant', 2, 'Your review contains inappropriate words.', NULL, '2024-11-21 02:24:38', 'acct_1QOsgfQIjGYcSTzY'),
(70, 'Degam Jhonry', 'jhonrydegamo@gmail.com', 'degads', '$2y$12$h32SRh2VdQg1duaLDQnMq.AEbTF1c4e0PRJsp/ahe6XQZ/5eRh4sK', '09090909090', NULL, NULL, 'profile_picture/FurI715A5UrGqPiKsbWG1svii.jpg', 'purok 3 tres de mayo', NULL, '2024-11-20 19:34:52', '2024-11-20 19:35:49', 0, 1, 'owner', 3, NULL, NULL, '2024-11-21 03:35:42', NULL),
(71, 'shane lopez', 'nokielopez@gmail.com', NULL, NULL, '090909090909', NULL, '106648757521862198329', 'profile_picture/A53NKFOPfoZAZxDuuTlWf5sZc.jpg', 'Tres De Mayo', NULL, '2024-11-20 20:32:53', '2024-11-20 20:33:15', 0, 0, 'tenant', 3, NULL, NULL, '2024-11-21 04:32:53', NULL);

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
(21, 68, 'owner_documents/valid_id/sjtdbFROgSWGlIznJ8e9Sj3CF.jpg', 'owner_documents/business_permit/pq05sithBgblMnkqdqh4vpvEC.png', 'approved', NULL, '2024-11-20 18:16:00', '2024-11-20 18:26:11'),
(22, 70, 'owner_documents/valid_id/8TXOZgyE7GUugLEYez0MyK2t3.jpg', 'owner_documents/business_permit/MhiNgYLjiblc00K38CMJoqhNz.jpg', 'approved', NULL, '2024-11-20 19:34:52', '2024-11-20 19:35:49');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES
(1, 69, 10100.00, '2024-11-24 01:53:19', '2024-11-26 19:53:59'),
(2, 70, 1400.00, '2024-11-25 01:16:52', '2024-12-01 23:09:31'),
(8, 71, 2000.00, '2024-11-28 03:27:08', '2024-11-27 20:52:24'),
(9, 68, 8000.00, '2024-11-28 04:55:11', '2024-11-27 20:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` longtext DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `balance_after` decimal(15,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `details` text DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_transactions`
--

INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `user_id`, `payment_id`, `type`, `amount`, `balance_after`, `status`, `details`, `method`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 69, NULL, 'cash_in', 700.00, 700.00, 'completed', 'Cash-in via Stripe', NULL, '', '2024-11-23 22:48:25', '2024-11-23 22:48:25'),
(2, 1, 69, NULL, 'cash_in', 300.00, 1000.00, 'completed', 'Cash-in via Stripe', NULL, '', '2024-11-23 23:48:24', '2024-11-23 23:48:24'),
(3, 1, 69, NULL, 'cash_in', 100.00, 1300.00, 'completed', 'Cash-in via Stripe', NULL, '', '2024-11-24 17:31:44', '2024-11-24 17:31:44'),
(4, 1, 69, NULL, 'cash_in', 100.00, 1400.00, 'completed', 'Cash-in via Stripe', NULL, '', '2024-11-24 17:39:37', '2024-11-24 17:39:37'),
(5, 1, 69, NULL, 'cash_in', 1000.00, 2400.00, 'completed', 'Cash-in via Stripe', NULL, '', '2024-11-24 17:40:50', '2024-11-24 17:40:50'),
(6, 1, 69, NULL, 'cash_out', -1000.00, 400.00, 'rejected', 'Cash-out request via Stripe', NULL, 'nope', '2024-11-24 18:16:10', '2024-12-02 20:52:53'),
(7, 1, 69, NULL, 'cash_out', -100.00, 300.00, 'rejected', 'Cash-out request via Stripe', NULL, 'Insufficient information', '2024-11-24 18:16:42', '2024-12-02 21:49:57'),
(8, 1, 69, NULL, 'cash_in', 1000.00, 1300.00, 'completed', 'Cash-in via Stripe', NULL, '', '2024-11-24 19:05:21', '2024-11-24 19:05:21'),
(9, 2, 70, NULL, 'cash_out', -1000.00, 300.00, 'pending', 'Cash-out request via Stripe', 'Gcash', '', '2024-11-24 19:16:41', '2024-11-24 19:16:41'),
(10, 1, 69, NULL, 'cash_out', -100.00, 200.00, 'completed', 'Cash-out request via Stripe', NULL, '', '2024-11-24 19:47:16', '2024-12-02 21:51:53'),
(11, 1, 69, NULL, 'cash_out', -100.00, 100.00, 'approved', 'Cash-out request via Stripe', NULL, '', '2024-11-24 19:49:02', '2024-12-02 21:50:59'),
(12, 1, 69, NULL, 'cash_out', -100.00, 900.00, 'pending', 'Cash-out request via Stripe', 'paymaya', '', '2024-11-24 20:02:11', '2024-11-24 20:02:11'),
(13, 1, 69, NULL, 'cash_out', -100.00, 800.00, 'pending', 'Cash-out request via Stripe', NULL, '', '2024-11-24 20:02:42', '2024-11-24 20:02:42'),
(14, 1, 69, NULL, 'cash_in', 200.00, 1000.00, 'completed', 'Cash-in via Stripe', NULL, '', '2024-11-25 18:12:47', '2024-11-25 18:12:47'),
(15, 2, 70, NULL, 'cash_in', 700.00, 700.00, 'completed', 'Cash-in via Stripe', NULL, '', '2024-11-25 21:19:27', '2024-11-25 21:19:27'),
(16, 2, 70, 'pi_3QPHPPGB24OTjK7w1GOYduEf', 'cash_in', 700.00, 1400.00, 'completed', 'Cash-in via Stripe', NULL, '', '2024-11-25 21:35:40', '2024-11-25 21:35:40'),
(17, 1, 69, NULL, 'payment', 900.00, 8200.00, 'completed', 'Payment', NULL, '', '2024-11-26 19:43:56', '2024-11-26 19:43:56'),
(18, 1, 69, NULL, 'Refund', -900.00, 9100.00, 'completed', 'Refund', NULL, '', '2024-11-26 19:51:31', '2024-11-26 19:51:31'),
(19, 1, 69, 'pi_3QPcJAGB24OTjK7w1zGKY5DW', 'cash_in', 1000.00, 10100.00, 'completed', 'Cash-in via Stripe', NULL, '', '2024-11-26 19:53:59', '2024-11-26 19:53:59'),
(20, 8, 71, 'pi_3QPyONGB24OTjK7w1ailnaJK', 'cash_in', 10000.00, 10000.00, 'completed', 'Cash-in via Stripe', NULL, '', '2024-11-27 19:29:12', '2024-11-27 19:29:12'),
(21, 8, 71, NULL, 'payment', -8000.00, 2000.00, 'completed', 'Payment', NULL, '', '2024-11-27 19:52:38', '2024-11-27 19:52:38'),
(22, 8, 71, NULL, 'Refund', 8000.00, 10000.00, 'completed', 'Refund', NULL, '', '2024-11-27 20:51:03', '2024-11-27 20:51:03'),
(23, 8, 71, NULL, 'payment', -8000.00, 2000.00, 'completed', 'Payment', NULL, '', '2024-11-27 20:52:24', '2024-11-27 20:52:24'),
(24, 9, 68, NULL, 'Earning', 8000.00, 8000.00, 'completed', 'Earning', NULL, '', '2024-11-27 20:58:00', '2024-11-27 20:58:00'),
(25, 2, 70, 'pi_3QRRExGB24OTjK7w1pQapnYd', 'cash_in', 1000.00, 2400.00, 'completed', 'Cash-in via Stripe', NULL, '', '2024-12-01 20:28:42', '2024-12-01 20:28:42'),
(27, 2, 70, NULL, 'cash_out', 1000.00, 400.00, 'pending', '09090909090', 'paymaya', NULL, '2024-12-01 23:09:31', '2024-12-01 23:09:31');

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
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_stripe_account_id_unique` (`stripe_account_id`);

--
-- Indexes for table `verifications`
--
ALTER TABLE `verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verification_requests_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wallets_user_id_unique` (`user_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_transactions_user_id_foreign` (`user_id`),
  ADD KEY `wallet_transactions_wallet_id_foreign` (`wallet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billings`
--
ALTER TABLE `billings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `curse_words`
--
ALTER TABLE `curse_words`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `dorms`
--
ALTER TABLE `dorms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=427;

--
-- AUTO_INCREMENT for table `property_views`
--
ALTER TABLE `property_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `rent_forms`
--
ALTER TABLE `rent_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
-- Constraints for table `verifications`
--
ALTER TABLE `verifications`
  ADD CONSTRAINT `verification_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wallet_transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
