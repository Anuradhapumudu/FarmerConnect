-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2026 at 08:12 PM
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
-- Database: `farmerconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password_hash`, `email`, `created_at`, `first_name`, `last_name`, `phone_no`, `image_url`, `updated_at`, `status`) VALUES
('A0001', '', '$2y$10$yHiBFEiMLoYMcuJVIDRZq.8KybA.d527cq8d2QTDHvTlizc4CIw0m', NULL, '2025-10-23 04:14:33', 'Kamal', 'Widanage', '0778316555', NULL, '2025-12-30 22:14:36', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `agrarian_service_centers`
--

CREATE TABLE `agrarian_service_centers` (
  `center_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `center_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agrarian_service_centers`
--

INSERT INTO `agrarian_service_centers` (`center_id`, `district_id`, `center_name`) VALUES
(1, 1, 'Meerigama'),
(2, 1, 'Pallewela'),
(3, 1, 'Pasyala'),
(4, 1, 'Badalgama'),
(5, 1, 'Walpita'),
(6, 1, 'Udugampola'),
(7, 1, 'Mabodala'),
(8, 1, 'Minuwangoda'),
(9, 1, 'Andiambalama'),
(10, 1, 'Katana'),
(11, 1, 'Ja-Ela'),
(12, 1, 'Henarathgoda'),
(13, 1, 'Galahitiyawa'),
(14, 1, 'Nittambuwa'),
(15, 1, 'Urapola'),
(16, 1, 'Weke'),
(17, 1, 'Dompe'),
(18, 1, 'Biyagama'),
(19, 1, 'Kelaniya'),
(20, 1, 'Pamunugama'),
(21, 1, 'Malwatuhiripitiya'),
(22, 1, 'Suriyapaluwa'),
(23, 1, 'Udupila'),
(24, 1, 'Yakkala'),
(25, 1, 'Marandagahamula'),
(26, 1, 'Bemmulla'),
(27, 2, 'Kosgama'),
(28, 2, 'Padukka'),
(29, 2, 'Homagama'),
(30, 2, 'Kesbewa'),
(31, 2, 'Kahatuduwa'),
(32, 2, 'Kotte'),
(33, 2, 'Malabe'),
(34, 2, 'Kolonnawa'),
(35, 3, 'Warakagoda'),
(36, 3, 'Bulathsinghala'),
(37, 3, 'Madurawala'),
(38, 3, 'Agalawatta'),
(39, 3, 'Baduraliya'),
(40, 3, 'Ittepana'),
(41, 3, 'Matugama'),
(42, 3, 'Dodangoda'),
(43, 3, 'Walagedara'),
(44, 3, 'Halkadawila'),
(45, 3, 'Padagoda'),
(46, 3, 'Bandaragama'),
(47, 3, 'Millaniya'),
(48, 3, 'Pamunugama'),
(49, 3, 'Ingiriya'),
(50, 3, 'Kananwila'),
(51, 3, 'Morontuduwa'),
(52, 3, 'Nagoda'),
(53, 3, 'Panadura'),
(54, 3, 'Pelawatta');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `officer_id` varchar(15) DEFAULT NULL,
  `admin_id` varchar(15) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `is_pinned` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `officer_id`, `admin_id`, `title`, `category`, `content`, `attachment_path`, `is_pinned`, `is_deleted`, `created_at`, `updated_at`) VALUES
(2, NULL, NULL, 'ax', 'fertilizer', 'ax', '', 0, 1, '2025-10-19 03:58:06', '2025-10-20 02:29:59'),
(3, NULL, 'A1', 'System Maintenance Notice', 'other', 'The system will be undergoing scheduled maintenance on October 25th, from 10:00 PM to 12:00 AM. Please make sure to save your work before this time. We apologize for any inconvenience.', '', 0, 0, '2025-10-20 02:17:27', '2025-10-20 11:58:29'),
(4, 'O0001', NULL, 'Paddy Leaf Blight Detected in Several Areas', 'warning', 'A paddy leaf blight outbreak has been reported in the Kurunegala and Anuradhapura districts. Farmers are advised to inspect their fields daily and use recommended fungicides. Please contact your local Agriculture Officer for guidance on treatment methods.', '', 1, 0, '2025-10-20 02:30:38', '2025-10-23 06:53:05'),
(5, 'O2', NULL, 'Upcoming Training on Modern Irrigation Techniques', 'training', 'A practical workshop on “Efficient Water Management and Drip Irrigation” will be held on October 28th at 9:00 AM at the District Agrarian Center, Polonnaruwa. Participation is free for registered farmers. Seats are limited — register by October 25th.', '', 0, 0, '2025-10-20 02:31:05', '2025-10-20 02:33:34'),
(6, 'O2', NULL, 'Fertilizer Distribution Schedule for Maha Season 2025', 'fertilizer', 'Distribution of subsidized fertilizer for the Maha 2025 cultivation season will begin on November 2nd. Farmers can collect fertilizer from their respective Agrarian Service Centers between 8:00 AM and 4:00 PM. Please bring your Farmer ID card and land registration documents.', '', 1, 0, '2025-10-20 02:33:15', '2025-10-23 07:51:16'),
(7, 'O2', NULL, 'Update: New Land Usage Policy Effective from November 2025', 'policy', 'The Ministry of Agriculture has updated the Land Usage Policy to encourage crop diversification. Farmers cultivating paddy continuously for over three years are encouraged to plant pulses or maize during the next season. More details are available at your local Agrarian Office.', '', 1, 0, '2025-10-20 02:34:20', '2025-10-23 06:17:57'),
(8, 'O2', NULL, 'sa', 'fertilizer', 'dsasa', '', 0, 1, '2025-10-20 02:43:30', '2025-10-20 02:43:54'),
(9, 'O2', NULL, 'csdvc', 'training', 'accsca', 'uploads/1760951668_register_img_desktop-01.jpeg', 0, 1, '2025-10-20 03:44:28', '2025-10-20 03:46:45'),
(10, 'O2', NULL, 'Images (jpg/png/gif) show as a small preview inside the card.  PDFs show as a preview using .  Other file types display their name as before.  Clicking the card still opens the file in a new tab.  Card has max width/height and scales nicely on mobile.', 'fertilizer', 'jcn', '', 0, 1, '2025-10-20 04:08:43', '2025-10-20 04:09:14'),
(11, 'O2', NULL, 'Images (jpg/png/gif) show as a small preview inside the card.  PDFs show as a preview using .  Other file types display their name as before.  Clicking the card still opens the file in a new tab.  Card has max width/height and scales nicely on mobile.', 'fertilizer', 'jcn', '', 0, 1, '2025-10-20 04:11:35', '2025-10-20 04:11:52'),
(12, NULL, NULL, 'cs', 'training', 'adC', '', 0, 1, '2025-10-20 08:17:02', '2025-10-20 08:17:26'),
(13, NULL, NULL, 'dasc', 'policy', 'sca', '', 0, 1, '2025-10-20 08:17:50', '2025-10-20 08:28:32'),
(14, NULL, NULL, 'sdvv', 'fertilizer', 'asxac', '', 0, 1, '2025-10-20 08:19:03', '2025-10-20 08:28:22'),
(15, 'O2', NULL, 'fasd', 'warning', 'sacv', '', 0, 1, '2025-10-20 08:31:02', '2025-10-20 08:31:11'),
(16, 'O2', NULL, 'aC', 'warning', 'cvds', '', 0, 1, '2025-10-20 08:31:51', '2025-10-20 08:32:02'),
(17, 'O2', NULL, 'wdaf', 'fertilizer', 'qwda', '', 0, 1, '2025-10-20 10:55:05', '2025-10-20 10:55:17'),
(0, 'O0001', NULL, 'warning', 'warning', 'pest outbreak in south', '', 0, 1, '2025-10-22 11:05:24', '2025-10-23 07:51:07'),
(0, 'O0001', NULL, 'warning', 'warning', 'pest outbreak in south', '', 0, 1, '2025-10-22 11:48:28', '2025-10-23 07:51:07'),
(0, 'O0001', NULL, 'warning', 'warning', 'pest outbreak in south', '', 0, 1, '2025-10-22 11:48:37', '2025-10-23 07:51:07'),
(0, 'O0001', NULL, 'warning', 'warning', 'pest outbreak in south', '', 0, 1, '2025-10-22 11:48:40', '2025-10-23 07:51:07'),
(0, 'O0001', NULL, 'warning', 'warning', 'pest outbreak in south', '', 0, 1, '2025-10-22 12:35:48', '2025-10-23 07:51:07'),
(0, 'O0001', NULL, 'warning', 'warning', 'pest outbreak in south', '', 0, 1, '2025-10-23 05:46:26', '2025-10-23 07:51:07'),
(0, 'O0001', NULL, 'warning', 'warning', 'pest outbreak in south', '', 0, 1, '2025-10-23 05:51:03', '2025-10-23 07:51:07'),
(0, 'O0001', NULL, 'warning', 'warning', 'pest outbreak in south', '', 0, 1, '2025-10-23 05:51:47', '2025-10-23 07:51:07'),
(0, 'O0001', NULL, 'warning', 'warning', 'pest outbreak in south', '', 0, 1, '2025-10-23 05:52:38', '2025-10-23 07:51:07'),
(0, 'O0001', NULL, 'warning', 'warning', 'pest outbreak in south', '', 0, 1, '2025-10-23 06:17:31', '2025-10-23 07:51:07'),
(0, 'O0001', NULL, 'warning', 'warning', 'pest outbreak in south', '', 0, 1, '2025-10-23 06:46:10', '2025-10-23 07:51:07'),
(0, 'O0001', NULL, 'warning', 'warning', 'pest outbreak in south', '', 0, 1, '2025-10-23 07:50:51', '2025-10-23 07:51:11');

-- --------------------------------------------------------

--
-- Table structure for table `disease_officer_responses`
--

CREATE TABLE `disease_officer_responses` (
  `id` int(11) NOT NULL,
  `report_code` varchar(20) NOT NULL,
  `officer_id` varchar(50) NOT NULL,
  `response_message` text NOT NULL,
  `response_media` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disease_reports`
--

CREATE TABLE `disease_reports` (
  `id` int(11) NOT NULL,
  `report_code` varchar(20) NOT NULL DEFAULT '',
  `farmerNIC` varchar(20) NOT NULL,
  `pirNumber` varchar(20) NOT NULL,
  `observationDate` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `media` text DEFAULT NULL,
  `severity` enum('low','medium','high') NOT NULL,
  `affectedArea` decimal(10,2) NOT NULL,
  `status` enum('pending','under_review','resolved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `disease_reports`
--

INSERT INTO `disease_reports` (`id`, `report_code`, `farmerNIC`, `pirNumber`, `observationDate`, `title`, `description`, `media`, `severity`, `affectedArea`, `status`, `created_at`, `updated_at`) VALUES
(17, 'DR001', '200206102814', 'PLR123', '2025-10-19', 'Test CRUD', 'this is a test crud insertion for interim ssadsajd akjsdblsakdbkasld baskljdjasdbjas', 'DR001_WhatsApp_Video_2025-08-20_at_1_1760903562.mp4', 'medium', 54.40, 'pending', '2025-10-19 19:52:42', '2025-10-20 14:01:34'),
(18, 'DR002', '200206102814', 'PLR123', '2025-10-21', 'adsdas dasdasd asdas dsds', 'as dasdasdasd asdasmndbask djasbdkasdb akjsdb askdjasbndjkasd baksjmdbnaksjd bajs', 'DR002_help_1761077069.png', 'high', 23.00, 'pending', '2025-10-21 20:04:29', '2025-10-21 20:04:29'),
(19, 'DR003', '222222222v', 'PLR123', '2025-10-22', 'Asjdisj aisjdias djiasjdisa', 'jsahdushdausdh asodjasiodasjdoas doasidjoas', 'DR003_WhatsApp_Video_2025-08-20_at_1_1761110123.mp4', 'high', 23.00, 'pending', '2025-10-22 05:15:23', '2025-10-22 05:15:23'),
(20, 'DR004', '111111111v', 'PLR123', '2025-10-22', 'sdjasidj aidjasiodjasd oasidjasodijsado adjaiosdjaosid j', 'sjdhas dshaodha doiasjdioadj asiodjasoida sdsadhaisodjhsaoidjao', 'DR004_WhatsApp_Video_2025-08-20_at_1_1761110627.mp4', 'high', 21.10, 'pending', '2025-10-22 05:23:47', '2025-10-22 05:23:47'),
(27, 'DR008', '200105402095', '02/25/00083/001/P/00', '2025-10-22', 'hbjk jllal;al', 'a set of words that is complete in itself, typically containing a subject and predicate, conveying a statement, question, exclamation, or command, and consisting of a main clause and sometimes one or more subordinate clauses.', '', 'low', 100.00, 'pending', '2025-10-22 15:09:18', NULL),
(28, 'DR009', '200105402095', '02/25/00083/001/P/00', '2025-10-22', 'hhhhhhh', 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz', 'DR009_nadu_1761147714.jpeg', 'medium', 123.00, 'pending', '2025-10-22 15:41:54', '2025-10-22 15:41:54'),
(30, 'DR011', '200105402095', '02/25/00083/001/P/00', '2025-10-23', 'ttttttttt', 'tttttttttttttttttttttttttttttttttttt', 'DR011_WhatsApp_Image_2025-10-23_at_0_1761192713.jpg', 'high', 1.00, 'pending', '2025-10-23 04:11:53', '2025-10-23 04:11:53'),
(33, 'DR012', '200105402095', '02/25/00083/001/P/00', '2025-10-23', 'hshds dsds', 'sjdnsjd nsjd  sdnsjdn sjdnsajdnsajdnada', 'DR012_Plantix-plant-diseases_1761201820.jpg', 'high', 2.00, 'pending', '2025-10-23 06:43:40', '2025-10-23 06:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `district_id` int(11) NOT NULL,
  `district_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`district_id`, `district_name`) VALUES
(2, 'Colombo'),
(1, 'Gampaha'),
(3, 'Kalutara');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `id` int(11) NOT NULL,
  `contact_type` enum('emergency','general') DEFAULT 'emergency',
  `phone` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_contacts`
--

INSERT INTO `emergency_contacts` (`id`, `contact_type`, `phone`, `description`, `created_at`, `updated_at`) VALUES
(1, 'emergency', '0771234556', 'Available 24/7 for urgent agricultural issues requiring immediate assistance', '2025-12-22 07:56:20', '2026-01-26 08:18:47');

-- --------------------------------------------------------

--
-- Table structure for table `farmers`
--

CREATE TABLE `farmers` (
  `nic` varchar(15) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `registration_id` int(11) NOT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmers`
--

INSERT INTO `farmers` (`nic`, `full_name`, `registration_id`, `phone_no`, `password`, `gender`, `birthdate`, `address`, `profile_image`, `status`) VALUES
('200005402095', 'amal perera', 31, '0778316446', '$2y$10$qMqMGUCaqfjrelhqBUbQgOtx6dwe47KcIZJFt07dSn/jK67QNecfO', NULL, NULL, NULL, NULL, 'Active'),
('200105402095', 'Sanjana Rajapaksha', 32, '0774920578', '$2y$10$Ct8kwN.SffbHF6rwk2ccueTjRljwvbz.YuGvpZNNospfoK569KJ6C', 'male', '2025-10-20', '55,Gampha udugampola', NULL, 'Active'),
('200254201944', 'Janeesha Widanage', 28, '0778316232', '$2y$10$OCjw5zuNJs0GI.yNHjtjLuMI7lQkoLtEALF8.JsQf4odr.qoQ2WNm', NULL, NULL, NULL, NULL, 'Active'),
('200254201945', 'Kamal Widanage', 26, '0778316231', '$2y$10$BaeoAQfMaXy00B.JeY5qxOexOJPwPLaVU4DYdafZTD0hxdEgwWbuG', NULL, NULL, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `help_center_members`
--

CREATE TABLE `help_center_members` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `user_type` enum('admin','officer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `help_center_members`
--

INSERT INTO `help_center_members` (`id`, `user_id`, `user_type`, `created_at`) VALUES
(7, 'A0001', 'admin', '2026-01-01 18:28:14'),
(9, 'O0001', 'officer', '2026-01-24 11:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE `officers` (
  `officer_id` varchar(15) NOT NULL,
  `nic` varchar(15) DEFAULT NULL,
  `registration_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officers`
--

INSERT INTO `officers` (`officer_id`, `nic`, `registration_id`, `first_name`, `last_name`, `phone_no`, `email`, `password`, `image_url`, `updated_at`, `status`) VALUES
('O0001', '200206102815', 30, 'Andrew', 'Stew', '0778316255', 'officer1@fc.lk', '$2y$10$N.dXBHTXv159uRW/0AToXOfB.lV4jOg6sYIW.F6R.Pauypyh8tVim', 'uploads/officers/O0001_1769257425.jpg', '2026-01-24 12:23:45', 'Inactive'),
('O0002', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2025-12-22 17:15:24', 'Active'),
('O0003', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2025-12-21 06:37:49', 'Active'),
('O2', '333333333v', 5, 'Saman', 'Perera', '', 'abc@gamil.com', '$2y$10$Bxmh4FTfDnvNRqCNWJWufeQ0I8zUXbcHAjWRey4ocLVmosqNs3lgu', NULL, '2025-12-21 06:37:49', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(20) NOT NULL,
  `item_id` varchar(50) NOT NULL,
  `seller_id` varchar(50) NOT NULL,
  `buyer_id` varchar(15) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','card','online') NOT NULL,
  `order_create_date` datetime DEFAULT current_timestamp(),
  `order_status` enum('order_placed','order_confirmed','order_cancelled','ready_to_pickup','order_picked') DEFAULT 'order_placed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `item_id`, `seller_id`, `buyer_id`, `quantity`, `total_price`, `payment_method`, `order_create_date`, `order_status`) VALUES
(1, 'P-SE0011-1', 'SE0011', '2147483647', 1, 100.00, 'cash', '2025-11-20 21:14:52', 'order_placed'),
(3, 'P-SE0011-1', 'SE0011', '200254201944', 4, 400.00, 'cash', '2025-11-20 21:25:04', ''),
(4, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'online', '2025-11-22 11:32:23', 'order_cancelled'),
(6, 'P-SE0011-1', 'SE0011', '200254201944', 8, 800.00, 'cash', '2025-11-22 15:38:00', ''),
(7, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2025-11-22 15:46:52', 'order_placed'),
(8, 'P-SE0011-1', 'SE0011', '200254201944', 4, 400.00, 'cash', '2025-11-22 16:13:42', ''),
(9, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2025-11-22 16:33:37', ''),
(10, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2025-11-22 16:44:15', ''),
(11, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2025-11-22 16:46:06', 'order_picked'),
(12, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2025-11-23 20:52:27', 'order_confirmed'),
(13, 'P-SE0011-1', 'SE0011', '200254201944', 10, 1000.00, 'cash', '2025-11-23 22:20:43', 'order_placed'),
(14, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2025-11-28 01:03:26', 'order_placed'),
(15, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2025-11-28 01:52:12', 'order_placed'),
(16, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2025-11-28 01:58:03', 'order_placed'),
(17, 'P-SE0011-1', 'SE0011', '200254201944', 5, 500.00, 'cash', '2025-11-28 02:02:15', 'order_placed'),
(18, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'online', '2025-11-28 02:40:37', 'order_confirmed'),
(19, 'P-SE0011-1', 'SE0011', 'A0001', 15, 1500.00, 'cash', '2026-01-11 10:30:02', 'order_placed'),
(20, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2026-01-11 10:31:42', 'order_placed'),
(21, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2026-01-11 10:32:35', 'order_placed'),
(22, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2026-01-11 10:32:41', 'order_placed'),
(23, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2026-01-11 10:34:01', 'order_placed'),
(24, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2026-01-11 10:34:32', 'order_placed'),
(25, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2026-01-11 10:35:09', 'order_placed'),
(26, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2026-01-11 10:35:18', 'order_placed'),
(27, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2026-01-11 10:36:39', 'order_placed'),
(28, 'P-SE0011-2', 'SE0011', '200254201944', 1, 10.00, 'cash', '2026-01-11 10:37:46', 'order_placed'),
(29, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2026-01-11 12:33:37', 'order_cancelled'),
(30, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2026-01-11 13:10:39', 'order_picked'),
(31, 'P-SE0011-2', 'SE0011', '200254201944', 1, 10.00, 'cash', '2026-01-12 01:08:01', 'order_picked'),
(32, 'P-SE0011-1', 'SE0011', '200254201944', 2, 200.00, 'online', '2026-01-12 01:13:29', 'order_picked'),
(33, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'online', '2026-01-12 13:24:01', 'order_picked');

-- --------------------------------------------------------

--
-- Table structure for table `order_status_history`
--

CREATE TABLE `order_status_history` (
  `id` int(30) NOT NULL,
  `order_id` int(20) NOT NULL,
  `old_status` varchar(50) DEFAULT NULL,
  `new_status` varchar(50) DEFAULT NULL,
  `changed_at` datetime DEFAULT current_timestamp(),
  `changed_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_status_history`
--

INSERT INTO `order_status_history` (`id`, `order_id`, `old_status`, `new_status`, `changed_at`, `changed_by`) VALUES
(1, 4, 'order_placed', 'order_placed', '2025-11-22 14:59:52', 'SE0011'),
(2, 4, 'order_placed', 'order_confirmed', '2025-11-22 14:59:56', 'SE0011'),
(3, 4, 'order_confirmed', 'order_confirmed', '2025-11-22 15:02:51', 'SE0011'),
(4, 4, 'order_confirmed', 'order_placed', '2025-11-22 15:02:56', 'SE0011'),
(5, 4, 'order_placed', 'order_confirmed', '2025-11-22 15:14:46', 'SE0011'),
(6, 4, 'order_confirmed', 'order_cancelled', '2025-11-22 15:14:54', 'SE0011'),
(7, 3, 'order_placed', 'order_confirmed', '2025-11-22 15:16:40', 'SE0011'),
(8, 3, 'order_confirmed', 'ready_to_pickup', '2025-11-22 15:23:49', 'SE0011'),
(9, 3, 'ready_to_pickup', 'order_picked', '2025-11-22 15:23:59', 'SE0011'),
(10, 6, 'order_placed', 'order_confirmed', '2025-11-22 15:41:14', 'SE0011'),
(11, 6, 'order_confirmed', 'ready_to_pickup', '2025-11-22 15:41:22', 'SE0011'),
(12, 6, 'ready_to_pickup', 'order_picked', '2025-11-22 15:41:29', 'SE0011'),
(13, 8, 'order_placed', 'order_confirmed', '2025-11-22 16:13:54', 'SE0011'),
(14, 8, 'order_confirmed', 'ready_to_pickup', '2025-11-22 16:14:03', 'SE0011'),
(15, 8, 'ready_to_pickup', 'order_picked', '2025-11-22 16:14:11', 'SE0011'),
(16, 9, 'order_placed', 'order_confirmed', '2025-11-22 16:33:48', 'SE0011'),
(17, 9, 'order_confirmed', 'ready_to_pickup', '2025-11-22 16:33:58', 'SE0011'),
(18, 9, 'ready_to_pickup', 'order_picked', '2025-11-22 16:34:10', 'SE0011'),
(19, 10, 'order_placed', 'order_confirmed', '2025-11-22 16:44:29', 'SE0011'),
(20, 10, 'order_confirmed', 'ready_to_pickup', '2025-11-22 16:44:38', 'SE0011'),
(21, 10, 'ready_to_pickup', 'order_picked', '2025-11-22 16:44:49', 'SE0011'),
(22, 11, 'order_placed', 'order_confirmed', '2025-11-22 16:46:55', 'SE0011'),
(23, 11, 'order_confirmed', 'ready_to_pickup', '2025-11-22 16:47:10', 'SE0011'),
(24, 11, 'ready_to_pickup', 'order_picked', '2025-11-22 16:47:21', 'SE0011'),
(25, 12, 'order_placed', 'order_confirmed', '2025-11-23 22:15:02', 'SE0011'),
(26, 18, 'order_placed', 'order_confirmed', '2026-01-05 11:59:07', 'SE0011'),
(27, 33, 'order_placed', 'order_confirmed', '2026-01-12 13:25:54', 'SE0011'),
(28, 32, 'order_placed', 'order_confirmed', '2026-02-08 13:35:56', 'SE0011'),
(29, 32, 'order_confirmed', 'ready_to_pickup', '2026-02-08 13:36:06', 'SE0011'),
(30, 32, 'ready_to_pickup', 'order_picked', '2026-02-08 13:36:12', 'SE0011'),
(31, 33, 'order_confirmed', 'ready_to_pickup', '2026-02-09 02:22:43', 'SE0011'),
(32, 33, 'ready_to_pickup', 'order_picked', '2026-02-09 02:22:48', 'SE0011'),
(33, 31, 'order_placed', 'order_confirmed', '2026-04-02 21:52:55', 'SE0011'),
(34, 31, 'order_confirmed', 'ready_to_pickup', '2026-04-02 22:05:41', 'SE0011'),
(35, 29, 'order_placed', 'order_cancelled', '2026-04-02 22:06:10', 'SE0011'),
(36, 29, 'order_cancelled', 'order_cancelled', '2026-04-02 22:20:34', 'SE0011'),
(37, 31, 'ready_to_pickup', 'order_picked', '2026-04-04 15:01:25', 'SE0011'),
(38, 30, 'order_placed', 'order_confirmed', '2026-04-04 22:09:00', 'SE0011'),
(39, 30, 'order_confirmed', 'ready_to_pickup', '2026-04-04 22:09:07', 'SE0011'),
(40, 30, 'ready_to_pickup', 'order_picked', '2026-04-04 22:09:13', 'SE0011');

-- --------------------------------------------------------

--
-- Table structure for table `paddy`
--

CREATE TABLE `paddy` (
  `PLR` varchar(50) NOT NULL,
  `NIC_FK` varchar(15) NOT NULL,
  `OfficerID` varchar(15) DEFAULT NULL,
  `Paddy_Seed_Variety` varchar(100) NOT NULL,
  `Paddy_Size` decimal(10,2) NOT NULL,
  `Province` varchar(50) NOT NULL,
  `District` varchar(50) NOT NULL,
  `Govi_Jana_Sewa_Division` varchar(100) DEFAULT NULL,
  `Grama_Niladhari_Division` varchar(100) DEFAULT NULL,
  `Yaya` varchar(50) DEFAULT NULL,
  `CreatedDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paddy`
--

INSERT INTO `paddy` (`PLR`, `NIC_FK`, `OfficerID`, `Paddy_Seed_Variety`, `Paddy_Size`, `Province`, `District`, `Govi_Jana_Sewa_Division`, `Grama_Niladhari_Division`, `Yaya`, `CreatedDate`) VALUES
('02/25/00083/001/P/0066', '200105402095', 'O2', 'B-352', 34.00, 'Western', 'Gampaha', 'Galahitiyawa', 'divlapitiya', 'Yaya 7', '2025-10-23 06:41:22'),
('02/25/00083/001/P/0067', '200105402095', 'O2', 'BW-367', 10.00, 'Western', 'Gampaha', 'Galahitiyawa', 'divlapitiya', 'Yaya 5', '2025-10-23 05:34:13');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `item_id` varchar(50) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `seller_id` varchar(15) DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `region` varchar(50) NOT NULL,
  `unit_type` varchar(20) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `available_quantity` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`item_id`, `item_name`, `seller_id`, `category`, `description`, `region`, `unit_type`, `price_per_unit`, `available_quantity`, `image_url`, `status`, `province`) VALUES
('P-SE0011-1', 'fertilizer', 'SE0011', 'Fertilizer', '', 'Kandy', 'litre', 100.00, 31, '1770559134_Plantix-plant-diseases.jpg', 'Outstock', 'Central'),
('P-SE0011-2', 'crop', 'SE0011', 'Seeds', '', 'Kandy', 'litre', 10.00, 98, '1770496804_Zn1qjK8JMweyPhTNgrFvBigzOtuAjyniPrJ3L8E6.jpg', 'Instock', 'Central');

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `generate_item_id` BEFORE INSERT ON `products` FOR EACH ROW BEGIN
    DECLARE last_number INT DEFAULT 0;
    DECLARE seller_prefix VARCHAR(20);

    -- Seller prefix
    SET seller_prefix = CONCAT('P-', NEW.seller_id, '-');

    -- Get last number for this seller
    SELECT CAST(SUBSTRING_INDEX(item_id, '-', -1) AS UNSIGNED)
    INTO last_number
    FROM products
    WHERE item_id LIKE CONCAT(seller_prefix, '%')
    ORDER BY last_number DESC
    LIMIT 1;

    -- If no previous item, start from 1
    IF last_number IS NULL THEN
        SET last_number = 1;
    ELSE
        SET last_number = last_number + 1;
    END IF;

    -- Set new item_id
    SET NEW.item_id = CONCAT(seller_prefix, last_number);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `order_id` int(20) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_id`, `order_id`, `rating`, `created_at`) VALUES
(1, 32, 4, '2026-02-08 14:25:16'),
(2, 33, 4, '2026-02-08 20:53:06'),
(3, 31, 5, '2026-04-04 16:37:18'),
(4, 30, 5, '2026-04-04 16:39:27');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `registration_id` int(11) NOT NULL,
  `user_type` enum('farmer','seller','officer') NOT NULL,
  `approved_status` enum('approved','rejected','pending') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`registration_id`, `user_type`, `approved_status`, `created_at`, `password`, `approval_status`) VALUES
(13, 'seller', NULL, '2025-10-18 12:42:59', '$2y$10$vndl7TWQM39ozECBJnA0uOIbN1lkow0dXEA.oLjGxgUHEhcrmVtEq', 'pending'),
(14, 'seller', NULL, '2025-10-18 20:23:36', '$2y$10$006WV92HpAzUDpkxH6sTBe77KC/l7FR5JLE80aGNGGuNwyvYQYJ3m', 'pending'),
(15, 'seller', NULL, '2025-10-20 04:30:23', '$2y$10$6QLg5aZcnnAbDX6AFyZBNuEGWkjNl/XwEAQRrFX45Cm1dkk8PADfS', 'pending'),
(16, 'seller', NULL, '2025-10-21 04:50:38', '$2y$10$mHpILvIuKn6e/AE7M3qytuVx76uQaQyqEFjmBtCB0vkWPT9ORuNmC', 'pending'),
(17, 'seller', NULL, '2025-10-21 04:58:19', '$2y$10$BKK7coco/dU/wHLvBdzyW.PXS7xeaiM51MBFMdbZTTYHIlWJdQ4ui', 'pending'),
(19, 'farmer', NULL, '2025-10-22 06:02:37', '$2y$10$V3aOmWMv0.hy.3kui80Hj.ntgjNtAj1VzhDy2H3VN1O9v5zJGd0ky', 'pending'),
(20, 'farmer', NULL, '2025-10-22 06:03:44', '$2y$10$st7a1EeXjjsYOurKR.llue7m31mwxgHAeHnUkPz3qkDwOq6gK1mf2', 'pending'),
(21, 'farmer', NULL, '2025-10-22 06:07:58', '$2y$10$Z4ZLwt4ejU0H.VXJSSxEWOzwFEGRy7ZCKtz7Mv.kG8S3V.dEkgHoq', 'pending'),
(22, 'farmer', NULL, '2025-10-22 06:09:27', '$2y$10$y/kYKol8Oxg.48qRGODioerk1LbC1c.dAJKZhnUf5gOCGTls3ETLu', 'pending'),
(25, 'seller', NULL, '2025-10-22 18:27:23', '$2y$10$Jur4MxJym71KTz8jdR8CB.RkfY.t.Jn3TiZJdNq2LVhxc9wZFr4eu', 'pending'),
(26, 'farmer', NULL, '2025-10-22 19:17:24', '$2y$10$BaeoAQfMaXy00B.JeY5qxOexOJPwPLaVU4DYdafZTD0hxdEgwWbuG', 'pending'),
(27, 'seller', NULL, '2025-10-23 04:25:10', '$2y$10$a/xj5FHjW6LQCwqPMgZdeu7izQqHE5px21251i7hxrbEOUPpl0J/2', 'pending'),
(28, 'farmer', NULL, '2025-10-23 04:40:33', '$2y$10$OCjw5zuNJs0GI.yNHjtjLuMI7lQkoLtEALF8.JsQf4odr.qoQ2WNm', 'pending'),
(29, 'seller', NULL, '2025-10-23 04:41:46', '$2y$10$CmQzCwuiZgbyuty4URrvu.AdHH5QAFDGhAmmmSqB4285bZUzbZXsW', 'pending'),
(30, 'officer', NULL, '2025-10-23 05:05:36', '$2y$10$N.dXBHTXv159uRW/0AToXOfB.lV4jOg6sYIW.F6R.Pauypyh8tVim', 'pending'),
(31, 'farmer', NULL, '2025-10-23 05:27:02', '$2y$10$qMqMGUCaqfjrelhqBUbQgOtx6dwe47KcIZJFt07dSn/jK67QNecfO', 'pending'),
(32, 'farmer', NULL, '2025-10-23 05:30:03', '$2y$10$Ct8kwN.SffbHF6rwk2ccueTjRljwvbz.YuGvpZNNospfoK569KJ6C', 'pending'),
(33, 'seller', NULL, '2025-10-23 05:56:43', '$2y$10$Vz8jQRTI2gc2pSTBC9WKN.49mjwPfoJpmihestBycruiPQyelXTQ2', 'pending'),
(34, 'seller', NULL, '2025-10-23 06:18:57', '$2y$10$ZuMadV.ZfOeeGe6g487Lk.dPLpRTgFCr4KpQQuYMBKV980.c1wZXm', 'pending'),
(35, 'seller', NULL, '2025-10-23 06:47:22', '$2y$10$FCQIPEI.dV4vx1NiHvJOUODiIFMhEHQvlB/zDiHu70VuNSZ2A3B0S', 'pending'),
(36, 'seller', NULL, '2025-10-23 07:52:30', '$2y$10$JBaFOhXeEEubuPGhMG3VheZzV2HF1uqe.RoRbwY5A7SkN0.T7N5Qi', 'pending'),
(37, 'seller', NULL, '2025-12-16 08:45:21', '$2y$10$NsF3HlilCKnSU.3Cwv6p8Oj5Unj/Pkzl2yyFIP6rxcghaFZ47TbbS', 'pending'),
(38, 'seller', NULL, '2025-12-16 08:50:14', '$2y$10$6mnWLtpVNjHI75GuJD61letNV/GtM.PkKIaqz2lSq9QdD6PYXv5Ne', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `seller_id` varchar(15) DEFAULT NULL,
  `nic` varchar(15) DEFAULT NULL,
  `registration_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `brn` varchar(50) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `approval_status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `seller_id`, `nic`, `registration_id`, `first_name`, `last_name`, `company_name`, `brn`, `phone_no`, `email`, `address`, `password`, `approval_status`, `created_at`, `updated_at`, `image_url`) VALUES
(9, 'SE0009', '200254201944', 25, 'Nimal', 'Perera', 'Comany.lk', '1233', '0778316232', 'janeeshamendis202@gmail.com', '209/5, Sri Mawatha , Miriswaththa', '$2y$10$Jur4MxJym71KTz8jdR8CB.RkfY.t.Jn3TiZJdNq2LVhxc9wZFr4eu', 'Approved', '2025-10-22 23:57:23', '2025-10-22 23:58:19', NULL),
(11, 'SE0011', '200254201940', 29, 'Janeeshaaa', 'Hasadara', '1235', '1278', '0778316456', 'janeeshahasadara@gmail.com', '209/5, Sri Mawatha , Miriswaththa', '$2y$10$CmQzCwuiZgbyuty4URrvu.AdHH5QAFDGhAmmmSqB4285bZUzbZXsW', 'Approved', '2025-10-23 10:11:46', '2026-01-04 21:10:06', 'uploads/sellers/SE0011_1767132470.jpg'),
(15, 'SE0015', '200254201947', 36, 'Pumudu', 'Anuradha', 'abc d', 'abc d', '0778316245', 'pumudu820@gmail.com', 'dsasv', '$2y$10$JBaFOhXeEEubuPGhMG3VheZzV2HF1uqe.RoRbwY5A7SkN0.T7N5Qi', 'Approved', '2025-10-23 13:22:30', '2025-10-23 13:22:48', NULL),
(17, 'SE0017', '200105402099', 38, 'Malika', 'Nishantha', '1234', '8523', '0778316246', 'piyumiwk@gmail.com', 'dsasv', '$2y$10$6mnWLtpVNjHI75GuJD61letNV/GtM.PkKIaqz2lSq9QdD6PYXv5Ne', 'Rejected', '2025-12-16 14:20:15', '2026-01-04 21:55:32', NULL);

--
-- Triggers `sellers`
--
DELIMITER $$
CREATE TRIGGER `before_insert_sellers` BEFORE INSERT ON `sellers` FOR EACH ROW BEGIN
    DECLARE next_id INT;

    -- Get the next auto-increment value from the sellers table
    SELECT AUTO_INCREMENT INTO next_id
    FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'sellers';

    -- Set the seller_id with prefix 'SE' and padded number
    SET NEW.seller_id = CONCAT('SE', LPAD(next_id, 4, '0'));
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `agrarian_service_centers`
--
ALTER TABLE `agrarian_service_centers`
  ADD PRIMARY KEY (`center_id`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `disease_officer_responses`
--
ALTER TABLE `disease_officer_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_code` (`report_code`),
  ADD KEY `officer_id` (`officer_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `disease_reports`
--
ALTER TABLE `disease_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_code` (`report_code`);

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farmers`
--
ALTER TABLE `farmers`
  ADD PRIMARY KEY (`nic`),
  ADD KEY `registration_id` (`registration_id`);

--
-- Indexes for table `help_center_members`
--
ALTER TABLE `help_center_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`user_type`),
  ADD UNIQUE KEY `user_id_2` (`user_id`);

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`officer_id`),
  ADD KEY `registration_id` (`registration_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `paddy`
--
ALTER TABLE `paddy`
  ADD PRIMARY KEY (`PLR`),
  ADD KEY `fk_farmer` (`NIC_FK`),
  ADD KEY `fk_officer` (`OfficerID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `fk_rating_order` (`order_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registration_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seller_id` (`seller_id`),
  ADD KEY `registration_id` (`registration_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agrarian_service_centers`
--
ALTER TABLE `agrarian_service_centers`
  MODIFY `center_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `disease_officer_responses`
--
ALTER TABLE `disease_officer_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `disease_reports`
--
ALTER TABLE `disease_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `help_center_members`
--
ALTER TABLE `help_center_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `products` (`item_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`seller_id`);

--
-- Constraints for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD CONSTRAINT `order_status_history_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `paddy`
--
ALTER TABLE `paddy`
  ADD CONSTRAINT `fk_farmer` FOREIGN KEY (`NIC_FK`) REFERENCES `farmers` (`nic`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_officer` FOREIGN KEY (`OfficerID`) REFERENCES `officers` (`officer_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `fk_rating_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `sellers`
--
ALTER TABLE `sellers`
  ADD CONSTRAINT `sellers_ibfk_1` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`registration_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
