-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2024 at 06:11 AM
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
(32, 69, 59, 6500.00, '2024-11-28', 'paid', 'Proof_of_Payment/K8kHdX8VaQQ19rv6rmoq5L1iM.jpg', 'bank_transfer', '2024-11-20 05:07:41', '2024-11-20 21:06:00', '2024-11-20 21:07:41');

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
(49, 68, 'Rainy Days Guesthouse', 'A cozy, family-run guesthouse with clean, comfortable private rooms. Includes breakfast and a garden space for guests to relax.', 'Unabia Street, Poblacion Ward III, Vito, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.24793790, 123.79749656, 1200.00, 3, 4, 2, '\"[\\\"dorm_pictures\\\\\\/1732156681_673e9d090c29c.jpg\\\",\\\"dorm_pictures\\\\\\/1732156681_673e9d09929d8.jpg\\\",\\\"dorm_pictures\\\\\\/1732156681_673e9d09c8ae1.jpg\\\",\\\"dorm_pictures\\\\\\/1732156682_673e9d0a06f68.jpg\\\"]\"', 0, 0, 0, '2024-11-20 18:38:02', '2024-11-20 19:11:52'),
(50, 68, 'Guesthouse', 'A small, family-run accommodation with private rooms, often located in quieter areas. It typically offers a more homely atmosphere than a hotel. Some guesthouses may offer breakfast included.', 'Poblacion Ward II, Calajo-an, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.24244786, 123.79470706, 1000.00, 4, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1732156801_673e9d81a112b.jpg\\\",\\\"dorm_pictures\\\\\\/1732156802_673e9d8233e9d.jpg\\\",\\\"dorm_pictures\\\\\\/1732156802_673e9d82627d7.jpg\\\",\\\"dorm_pictures\\\\\\/1732156802_673e9d829209a.jpg\\\"]\"', 0, 0, 0, '2024-11-20 18:40:02', '2024-11-20 21:01:01'),
(51, 68, 'The Velvet Boutique Hotel', 'Small, stylish hotels with a unique character. They often have personalized service, artistic design, and cozy, individually designed rooms. Often located in trendy neighborhoods.', 'Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.24743113, 123.80966306, 2000.00, 3, 2, 1, '\"[\\\"dorm_pictures\\\\\\/1732158370_673ea3a232e59.jpg\\\",\\\"dorm_pictures\\\\\\/1732158370_673ea3a2b1191.jpg\\\",\\\"dorm_pictures\\\\\\/1732158370_673ea3a2ded7b.jpg\\\",\\\"dorm_pictures\\\\\\/1732158371_673ea3a322507.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:05:18', '2024-11-20 20:29:01'),
(52, 68, 'Green Haven Eco-Lodge', 'Focused on sustainability, eco-lodges often use environmentally friendly materials, renewable energy, and locally sourced goods. Located in nature-rich areas, these options offer an immersive experience in natural surroundings', 'Poblacion Ward IV, Calajo-an, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.24552018, 123.79525423, 1500.00, 4, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1732158564_673ea4642bb62.jpg\\\",\\\"dorm_pictures\\\\\\/1732158564_673ea464b0d70.jpg\\\",\\\"dorm_pictures\\\\\\/1732158564_673ea464e052d.jpg\\\",\\\"dorm_pictures\\\\\\/1732158565_673ea4651babc.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:09:25', '2024-11-20 19:13:45'),
(53, 68, 'LuxTents Glamping Retreat', 'A luxurious glamping experience with king-sized beds, private decks, and en-suite bathrooms in spacious tents, nestled in a scenic national park.', 'Poblacion Ward III, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25229819, 123.80162716, 3000.00, 4, 3, 2, '\"[\\\"dorm_pictures\\\\\\/1732158997_673ea615bf80f.jpg\\\",\\\"dorm_pictures\\\\\\/1732158998_673ea61670693.jpg\\\",\\\"dorm_pictures\\\\\\/1732158998_673ea6169b54d.jpg\\\",\\\"dorm_pictures\\\\\\/1732158998_673ea616e7307.jpg\\\",\\\"dorm_pictures\\\\\\/1732158999_673ea6171b5aa.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:16:39', '2024-11-20 20:05:22'),
(54, 68, 'Sunny Grove Cottage', 'A charming 2-bedroom cottage in a quiet neighborhood, with a garden, outdoor patio, and modern amenities. Great for short stays or weekend getaways.', 'Poblacion Ward II, Calajo-an, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.24260623, 123.79503965, 1000.00, 4, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1732159148_673ea6ac4567b.jpg\\\",\\\"dorm_pictures\\\\\\/1732159148_673ea6acc833f.jpg\\\",\\\"dorm_pictures\\\\\\/1732159149_673ea6ad04edf.jpg\\\",\\\"dorm_pictures\\\\\\/1732159149_673ea6ad387ed.jpg\\\",\\\"dorm_pictures\\\\\\/1732159149_673ea6ad74168.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:19:09', '2024-11-20 20:10:40'),
(55, 68, 'Bahay sa Lungsod', 'A modern 3-bedroom townhouse located in the heart of the city. Features include a rooftop garden, fully furnished spaces, and easy access to shopping, restaurants, and public transport.', 'Cebu South Road, Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.24892504, 123.80340278, 2500.00, 5, 4, 3, '\"[\\\"dorm_pictures\\\\\\/1732159288_673ea7380d1a5.jpg\\\",\\\"dorm_pictures\\\\\\/1732159288_673ea738906b2.jpg\\\",\\\"dorm_pictures\\\\\\/1732159288_673ea738c0471.jpg\\\",\\\"dorm_pictures\\\\\\/1732159288_673ea738eed44.jpg\\\",\\\"dorm_pictures\\\\\\/1732159289_673ea73927f75.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:21:29', '2024-11-20 19:21:29'),
(56, 70, 'Bahay ng Pagdapo', 'A lavish 6-bedroom mansion located on a hill with stunning views of the surrounding city or beach. The house includes a gourmet kitchen, infinity pool, multiple lounges, and a garden, offering luxurious comforts for guests', 'Fonte di Versailles, Calajo-an, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.23776013, 123.79665971, 5000.00, 10, 7, 6, '\"[\\\"dorm_pictures\\\\\\/1732160894_673ead7e76d3d.jpg\\\",\\\"dorm_pictures\\\\\\/1732160895_673ead7f05af3.jpg\\\",\\\"dorm_pictures\\\\\\/1732160895_673ead7f355b0.jpg\\\",\\\"dorm_pictures\\\\\\/1732160895_673ead7f69110.jpg\\\",\\\"dorm_pictures\\\\\\/1732160895_673ead7f98ac4.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:48:15', '2024-11-20 19:48:15'),
(57, 70, 'Bahay Luntian', 'A charming 2-bedroom house surrounded by greenery, with a tropical garden and a porch perfect for morning coffee. Ideal for short stays, the house offers a cozy atmosphere with modern amenities.', 'Teves, Vito, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25381847, 123.79330158, 1500.00, 4, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1732161019_673eadfb8ee69.jpg\\\",\\\"dorm_pictures\\\\\\/1732161020_673eadfc1c440.jpg\\\",\\\"dorm_pictures\\\\\\/1732161020_673eadfc4bd59.jpg\\\",\\\"dorm_pictures\\\\\\/1732161020_673eadfc7b61a.jpg\\\",\\\"dorm_pictures\\\\\\/1732161020_673eadfcaa3a6.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:50:20', '2024-11-20 19:50:20'),
(58, 70, 'Bahay Alaga', 'A 3-bedroom, pet-friendly home featuring a large, fenced backyard where pets can roam freely. It also has easy access to pet-friendly parks and walking trails.', 'Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25491645, 123.80471706, 1200.00, 4, 4, 3, '\"[\\\"dorm_pictures\\\\\\/1732161236_673eaed4c348b.jpg\\\",\\\"dorm_pictures\\\\\\/1732161237_673eaed550c5b.jpg\\\",\\\"dorm_pictures\\\\\\/1732161237_673eaed57f5d3.jpg\\\",\\\"dorm_pictures\\\\\\/1732161237_673eaed5adfaa.jpg\\\",\\\"dorm_pictures\\\\\\/1732161237_673eaed5e8f2e.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:53:58', '2024-11-20 20:50:01'),
(59, 70, 'Bahay Bagong Buhay', 'A 2-bedroom eco-friendly home made with sustainable materials, complete with a solar power system, water conservation, and organic garden. Located in a serene environment, it\'s ideal for guests seeking a sustainable, green way of living.', 'Poblacion Ward IV, Vito, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.24893032, 123.79273295, 1300.00, 3, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1732161368_673eaf5854e73.jpg\\\",\\\"dorm_pictures\\\\\\/1732161368_673eaf58d588f.jpg\\\",\\\"dorm_pictures\\\\\\/1732161369_673eaf5914ec2.jpg\\\",\\\"dorm_pictures\\\\\\/1732161369_673eaf594bce8.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:56:09', '2024-11-20 21:09:01'),
(60, 70, 'Bahay Kanto', 'A modern 2-bedroom townhouse conveniently located near key city attractions, with easy access to public transport and local markets. Features a compact but stylish living area, a small garden, and an outdoor balcony.', 'Kingswood Village, Linao, Pakigne, Minglanilla, Cebu, Central Visayas, 6046, Pilipinas', 10.25542321, 123.80918026, 900.00, 3, 2, 2, '\"[\\\"dorm_pictures\\\\\\/1732161454_673eafaeba1f1.jpg\\\",\\\"dorm_pictures\\\\\\/1732161455_673eafaf4376b.jpg\\\",\\\"dorm_pictures\\\\\\/1732161455_673eafaf7a9d5.jpg\\\",\\\"dorm_pictures\\\\\\/1732161455_673eafafa85cb.jpg\\\",\\\"dorm_pictures\\\\\\/1732161455_673eafafd5ed8.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:57:36', '2024-11-20 19:57:36'),
(61, 70, 'Bahay Bahay-nga', 'A heritage-style home with traditional Filipino architecture, beautifully preserved with antique wooden floors and classic furnishings. Located in a historical district, it offers a glimpse into Filipino culture while enjoying modern amenities.', 'Cantibjang, Pakigne, Minglanilla, Cebu, Central Visayas, 6064, Pilipinas', 10.25113686, 123.81332159, 1700.00, 5, 3, 2, '\"[\\\"dorm_pictures\\\\\\/1732161564_673eb01c4befd.jpg\\\",\\\"dorm_pictures\\\\\\/1732161564_673eb01cd0cbb.jpg\\\",\\\"dorm_pictures\\\\\\/1732161565_673eb01d0a557.jpg\\\",\\\"dorm_pictures\\\\\\/1732161565_673eb01d3b989.jpg\\\"]\"', 0, 0, 0, '2024-11-20 19:59:25', '2024-11-20 20:34:38');

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
(371, 69, 'review', '<strong>Your rent has ended</strong> <br> <p>Your rent has ended on <strong>Bahay Bagong Buhay</strong> Please leave a review for the Accomodation.</p><br><p>Sent on: 2024-11-21 05:09:01</p>', 1, 'http://localhost:8000/my-reviews', '2024-11-20 21:09:01', '2024-11-20 21:09:12', 59, 14);

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
(38, 69, 59, '2024-11-20 21:03:52', '2024-11-20 21:03:52');

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
(58, 71, 50, '2024-11-21', '2024-11-29', 4, 7000.00, 'completed', NULL, '2024-11-20 20:55:11', '2024-11-20 21:01:01'),
(59, 69, 59, '2024-11-21', '2024-11-21', 3, 6500.00, 'completed', NULL, '2024-11-20 21:04:26', '2024-11-20 21:09:01');

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
(11, 69, 51, 4, 'nice house', '2024-11-20 20:29:01', '2024-11-20 20:30:34'),
(12, 71, 58, 5, 'very good house', '2024-11-20 20:50:01', '2024-11-20 20:50:49'),
(13, 71, 50, 1, 'this house is horrible', '2024-11-20 21:01:01', '2024-11-20 21:01:28'),
(14, 69, 59, 2, 'bad Accomodation', '2024-11-20 21:09:01', '2024-11-20 21:09:27');

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
('5Ksv9uIqCWIEUWACPcEHowH8sGVN3FXHRsrTJ3Sv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUzlIdUpUZHJtcjc5QmJkSjRDd3U5Y2U5QUxEaDkyQlRuazB4UzlzMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1732165824),
('VfylJnKNLzkbKETgnQkqSaFLpoRFBwDU5puC7i2H', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR2FtSlVlemlvcXJ6NXV2aVFsUE9IWWpHd3hWMFNMZ1lkV0RVTGY0aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NToic3RhdGUiO3M6NDA6ImlJaVdwcTdmajBtZWZOOXAxOXNtVEVEd0psd3Y2UWJxQU5SOG5FRVYiO30=', 1732165804);

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
(14, 'Lopez Roland Shane', 'lopezrolandshane@gmail.com', 'shaner', '$2y$12$KWBaHsB1eLFlGJ.2D.LF2O8u4qpNORuowbKP1xj0zcedchtSRZ81a', '12314134', 0, '107236937285983559710', 'profile-pictures/NsqtYbR4bm9qTg7FvyIID8MApPz7MhofeBfoJ5WS.jpg', 'dsadsadad', NULL, '2024-08-11 19:56:43', '2024-11-15 06:09:28', 0, 0, 'admin', 3, NULL, 796437, '2024-11-07 04:19:18'),
(68, 'Roland Shane Lopez', 'rshan0418@gmail.com', 'roland', '$2y$12$M9.0fLzVbEpg5m3lYEzPcuMg5u28fVIyWZjmqIGOLcTA8KfWW80.O', '09661805821', NULL, NULL, 'profile_picture/kEDKEjA3jRNNPztmQNrveSXYF.jpg', 'purok 3 tres de mayo', NULL, '2024-11-20 18:15:59', '2024-11-20 20:32:21', 0, 1, 'owner', 3, NULL, NULL, '2024-11-21 02:16:40'),
(69, 'Roland Shane Lopez', 'rshan04122@gmail.com', NULL, NULL, '090909090909', 1071441051576088, NULL, 'profile_picture/17P7uknT1nLNN3tJZEDWeodhu.jpg', 'purok 3 tres de mayo', NULL, '2024-11-20 18:23:38', '2024-11-20 20:30:04', 0, 0, 'tenant', 2, NULL, NULL, '2024-11-21 02:24:38'),
(70, 'Degam Jhonry', 'jhonrydegamo@gmail.com', 'degads', '$2y$12$h32SRh2VdQg1duaLDQnMq.AEbTF1c4e0PRJsp/ahe6XQZ/5eRh4sK', '09090909090', NULL, NULL, 'profile_picture/FurI715A5UrGqPiKsbWG1svii.jpg', 'purok 3 tres de mayo', NULL, '2024-11-20 19:34:52', '2024-11-20 19:35:49', 0, 1, 'owner', 3, NULL, NULL, '2024-11-21 03:35:42'),
(71, 'shane lopez', 'nokielopez@gmail.com', NULL, NULL, '090909090909', NULL, '106648757521862198329', 'profile_picture/A53NKFOPfoZAZxDuuTlWf5sZc.jpg', 'Tres De Mayo', NULL, '2024-11-20 20:32:53', '2024-11-20 20:33:15', 0, 0, 'tenant', 3, NULL, NULL, '2024-11-21 04:32:53');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;

--
-- AUTO_INCREMENT for table `property_views`
--
ALTER TABLE `property_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `rent_forms`
--
ALTER TABLE `rent_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
