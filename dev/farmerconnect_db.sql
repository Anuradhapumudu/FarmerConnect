-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2026 at 08:02 AM
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
('A0001', '', '$2y$10$yHiBFEiMLoYMcuJVIDRZq.8KybA.d527cq8d2QTDHvTlizc4CIw0m', 'janeeshahasadara@gmail.com', '2025-10-23 04:14:33', 'Kamal', 'Widanage', '0778316558', 'https://cdn-icons-png.flaticon.com/512/847/847969.png', '2026-04-16 14:15:18', 'Active');

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
-- Table structure for table `agri_officer_list`
--

CREATE TABLE `agri_officer_list` (
  `officer_id` varchar(15) NOT NULL,
  `govi_jana_sewa_division` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agri_officer_list`
--

INSERT INTO `agri_officer_list` (`officer_id`, `govi_jana_sewa_division`) VALUES
('O0001', 'Meerigama'),
('O0002', 'Pallewela'),
('O0003', 'Pasyala'),
('O0004', 'Badalgama'),
('O0005', 'Walpita'),
('O0006', 'Udugampola'),
('O0007', 'Mabodala'),
('O0008', 'Minuwangoda'),
('O0009', 'Andiambalama'),
('O0010', 'Katana'),
('O0011', 'Ja-Ela'),
('O0012', 'Henarathgoda'),
('O0013', 'Galahitiyawa'),
('O0014', 'Nittambuwa'),
('O0015', 'Urapola'),
('O0016', 'Weke'),
('O0017', 'Dompe'),
('O0018', 'Biyagama'),
('O0019', 'Kelaniya'),
('O0020', 'Pamunugama'),
('O0021', 'Malwatuhiripitiya'),
('O0022', 'Suriyapaluwa'),
('O0023', 'Udupila'),
('O0024', 'Yakkala'),
('O0025', 'Marandagahamula'),
('O0026', 'Bemmulla'),
('O0027', 'Kosgama'),
('O0028', 'Padukka'),
('O0029', 'Homagama'),
('O0030', 'Kesbewa'),
('O0031', 'Kahatuduwa'),
('O0032', 'Kotte'),
('O0033', 'Malabe'),
('O0034', 'Kolonnawa'),
('O0035', 'Warakagoda'),
('O0036', 'Bulathsinghala'),
('O0037', 'Madurawala'),
('O0038', 'Agalawatta'),
('O0039', 'Baduraliya'),
('O0040', 'Ittepana'),
('O0041', 'Matugama'),
('O0042', 'Dodangoda'),
('O0043', 'Walagedara'),
('O0044', 'Halkadawila'),
('O0045', 'Padagoda'),
('O0046', 'Bandaragama'),
('O0047', 'Millaniya'),
('O0048', 'Pamunugama'),
('O0049', 'Ingiriya'),
('O0050', 'Kananwila'),
('O0051', 'Morontuduwa'),
('O0052', 'Nagoda'),
('O0053', 'Panadura'),
('O0054', 'Pelawatta');

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
(1, 'O2', NULL, 'Free Training on Modern Fertilizer Techniques', 'training', 'Attention farmers! The Agriculture Officer team will conduct a free training session on modern fertilizer application techniques on November 5, 2025, at 9:00 AM at the local community hall. All farmers are encouraged to attend and learn best practices to increase crop yield.', '', 1, 0, '2025-10-27 07:25:04', '2026-04-17 13:59:12'),
(3, 'O2', NULL, 'System Maintenance Notice', 'other', 'The system will be undergoing scheduled maintenance on October 25th, from 10:00 PM to 12:00 AM. Please make sure to save your work before this time. We apologize for any inconvenience.', '', 0, 0, '2025-10-20 02:17:27', '2026-04-17 15:29:24'),
(4, 'O2', NULL, 'Paddy Leaf Blight Detected in Several Areas', 'warning', 'A paddy leaf blight outbreak has been reported in the Kurunegala and Anuradhapura districts. Farmers are advised to inspect their fields daily and use recommended fungicides. Please contact your local Agriculture Officer for guidance on treatment methods.', 'uploads/1775835067_disease.jpg', 1, 0, '2025-10-20 02:30:38', '2026-04-10 15:31:07'),
(5, 'O0001', NULL, 'Upcoming Training on Modern Irrigation Techniques', 'training', 'A practical workshop on “Efficient Water Management and Drip Irrigation” will be held on October 28th at 9:00 AM at the District Agrarian Center, Polonnaruwa. Participation is free for registered farmers. Seats are limited — register by October 25th.', '', 0, 0, '2025-10-20 02:31:05', '2025-10-27 07:21:27'),
(6, 'O0001', NULL, 'Fertilizer Distribution Schedule for Maha Season 2025', 'fertilizer', 'Distribution of subsidized fertilizer for the Maha 2025 cultivation season will begin on November 2nd. Farmers can collect fertilizer from their respective Agrarian Service Centers between 8:00 AM and 4:00 PM. Please bring your Farmer ID card and land registration documents.', '', 0, 0, '2025-10-20 02:33:15', '2025-10-27 07:21:48'),
(7, 'O2', NULL, 'Update: New Land Usage Policy Effective from November 2025', 'policy', 'The Ministry of Agriculture has updated the Land Usage Policy to encourage crop diversification. Farmers cultivating paddy continuously for over three years are encouraged to plant pulses or maize during the next season. More details are available at your local Agrarian Office.', 'uploads/1775393767_Lab-4_ Hash Lookup.pdf', 1, 0, '2025-10-20 02:34:20', '2026-04-17 14:01:11'),
(11, 'O2', NULL, 'test', 'other', 'test', '', 0, 1, '2026-04-04 09:37:03', '2026-04-04 09:38:03'),
(12, 'O2', NULL, 'test', 'other', 'test', 'uploads/1775315598_5. Session 5.pdf,uploads/1775315598_L11(privacy).pdf,uploads/1775315598_L10(Authn).pdf,uploads/1775315598_L8(Virus).pdf,uploads/1775315598_L3(MAC).pdf', 1, 1, '2026-04-04 12:54:02', '2026-04-04 18:15:48'),
(13, 'O2', NULL, 'test 2 asds', 'other', 'testing', '', 1, 1, '2026-04-04 13:50:46', '2026-04-04 17:10:55'),
(14, 'O2', NULL, 'test 3', 'other', 'testing', 'uploads/1775312560_backiee-316429 (1).jpg,uploads/1775312560_fantasy-style-character-fire.jpg,uploads/1775312560_backiee-91591.jpg,uploads/1775312560_kvbas.png,uploads/1775312560_pexels-francesco-ungaro-1525041.jpg', 1, 1, '2026-04-04 13:56:54', '2026-04-10 15:32:30'),
(15, 'O0012', NULL, 'test', 'other', 'test', 'uploads/1776489867_The-Hidden-Downsides-of-Urea-Fertilizer-What-You-Need-to-Know.jpg', 0, 0, '2026-04-18 05:24:27', '2026-04-18 05:24:27'),
(16, NULL, 'A0001', 'test', 'other', 'test', '', 0, 0, '2026-04-18 05:31:29', '2026-04-18 05:31:29');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaint_id` varchar(20) NOT NULL,
  `farmerNIC` varchar(20) NOT NULL,
  `plrNumber` varchar(50) NOT NULL,
  `observationDate` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `media` text DEFAULT NULL,
  `severity` enum('low','medium','high') NOT NULL,
  `affectedArea` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `status_updated_by` varchar(15) DEFAULT NULL,
  `is_edited` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`complaint_id`, `farmerNIC`, `plrNumber`, `observationDate`, `title`, `description`, `media`, `severity`, `affectedArea`, `status`, `status_updated_by`, `is_edited`, `is_deleted`, `created_at`, `updated_at`) VALUES
('CP001', '200105402095', '02/25/00083/001/P/0066', '2026-04-04', 'Testing 1234', 'skdsa mdkamsd samdas;dsamd; lsamdaksldm salkdm aslkdmasl', 'NEW_HEubw45WQAA3VRl_1775328884_0.jpeg', 'high', 22.80, 'Pending', NULL, 0, 0, '2026-04-04 13:24:44', '2026-04-04 13:24:44'),
('CP002', '200105402095', '02/25/00083/001/P/0066', '2026-04-01', 'test2', 'kjh jkj njkn knjhgvhjgvjghfhgvjvhjbj', 'CP002_AQPPzc5ahrejCRzEI-YXO2yCt3j9QL_1775329459_0.mp4,CP002_CP002_AQPPzc5ahrejCRzEI-YXO2yC_1775481190_0.mp4', 'high', 5.80, 'pending', 'O0001', 1, 0, '2026-04-04 13:34:19', '2026-04-06 07:43:10'),
('CP003', '200105402095', '02/25/00083/001/P/0067', '2026-04-05', 'I got water supply issue on paddy', 'Each group is allocated a maximum of 30 minutes for the presentation and the demonstration. A Q&A session and a code check will follow the presentation and demonstration. \r\n\r\nYou should do a 5 to 10-minute presentation and a maximum of 20 to 25-minute demonstration. (You can change the durations accordingly within the 30 minutes)', 'NEW_close-up-of-raindrops-on-leave_1775424532_0.jpg', 'high', 5.00, 'pending', 'O0001', 0, 0, '2026-04-05 15:58:52', '2026-04-05 17:24:07'),
('CP004', '200105402095', '02/25/00083/001/P/0066', '2026-04-05', 'This is a test complaint message', 'Each group is allocated a maximum of 30 minutes for the presentation and the demonstration. A Q&A session and a code check will follow the presentation and demonstration. \r\n\r\nYou should do a 5 to 10-minute presentation and a maximum of 20 to 25-minute demonstration. (You can change the durations accordingly within the 30 minutes)', 'NEW_Image_created_with_a_mobile_ph_1775427776_0.png', 'high', 18.00, 'under_review', 'O0001', 0, 0, '2026-04-05 16:52:56', '2026-04-05 17:22:41'),
('CP005', '200105402095', '02/25/00083/001/P/0067', '2026-04-06', 'Testing after update', 'You chose to start developing in Test Mode, which left your Cloud Firestore database completely open to the Internet. Because your app was vulnerable to attackers, your Firestore security rules were configured to stop allowing requests after the first 30 days.', 'CP005_Image_created_with_a_mobile_ph_1775482844_0.png,CP005_CP002_AQPPzc5ahrejCRzEI-YXO2yC_1775482856_0.mp4', 'high', 6.60, 'under_review', 'O0001', 1, 0, '2026-04-06 07:52:01', '2026-04-06 08:19:40');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_officer_responses`
--

CREATE TABLE `complaint_officer_responses` (
  `id` int(11) NOT NULL,
  `complaint_id` varchar(20) NOT NULL,
  `officer_id` varchar(15) NOT NULL,
  `response_message` text NOT NULL,
  `response_media` text DEFAULT NULL,
  `is_edited` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint_officer_responses`
--

INSERT INTO `complaint_officer_responses` (`id`, `complaint_id`, `officer_id`, `response_message`, `response_media`, `is_edited`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'CP004', 'O0001', 'I got this one', 'CP004_officer_O0001_close-up-of-raindrops-on-leave_1775429594_0.jpg', 0, 0, '2026-04-05 17:23:14', '2026-04-05 17:23:14'),
(2, 'CP005', 'O0001', 'I got this complaint', 'CP005_officer_O0001_close-up-of-raindrops-on-leave_1775483393_0.jpg', 0, 0, '2026-04-06 08:19:53', '2026-04-06 08:19:53');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_plr`
--

CREATE TABLE `deleted_plr` (
  `id` int(11) NOT NULL,
  `PLR` varchar(50) DEFAULT NULL,
  `NIC_FK` varchar(15) DEFAULT NULL,
  `OfficerID` varchar(15) DEFAULT NULL,
  `Paddy_Seed_Variety` varchar(100) DEFAULT NULL,
  `Paddy_Size` decimal(10,2) DEFAULT NULL,
  `Province` varchar(50) DEFAULT NULL,
  `District` varchar(50) DEFAULT NULL,
  `Govi_Jana_Sewa_Division` varchar(100) DEFAULT NULL,
  `Grama_Niladhari_Division` varchar(100) DEFAULT NULL,
  `Yaya` varchar(50) DEFAULT NULL,
  `CreatedDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_by` varchar(20) DEFAULT NULL,
  `deleted_by_id` varchar(20) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_plr`
--

INSERT INTO `deleted_plr` (`id`, `PLR`, `NIC_FK`, `OfficerID`, `Paddy_Seed_Variety`, `Paddy_Size`, `Province`, `District`, `Govi_Jana_Sewa_Division`, `Grama_Niladhari_Division`, `Yaya`, `CreatedDate`, `deleted_by`, `deleted_by_id`, `deleted_at`) VALUES
(1, '02/25/00083/001/P/3377', '200305402095', 'O2', 'B-352', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', '2026-04-11 04:40:35', 'farmer', '200305402095', '2026-04-11 10:11:04'),
(2, '02/25/00083/001/P/9999', '200305402095', 'O2', 'BW-367', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', '2026-04-10 04:45:24', 'farmer', '200305402095', '2026-04-11 10:14:52'),
(3, '02/25/00083/001/P/0001', '200105402095', 'O2', 'B-352', 34.00, 'Western', 'Gampaha', 'Nittambuwa', 'divlapitiya', 'Yaya 8', '2026-04-05 02:07:03', 'officer', 'O2', '2026-04-11 10:58:37'),
(4, '02/25/00083/001/P/5555', '200105402095', 'O2', 'BG-300', 34.00, 'Western', 'Colombo', 'Kolonnawa', 'divlapitiya', 'Yaya 8', '2026-04-04 05:15:12', 'officer', 'O2', '2026-04-11 11:03:56'),
(5, '02/25/00083/001/P/5533', '200105402095', 'O2', 'B-352', 34.00, 'Western', 'Kalutara', 'Nagoda', 'divlapitiya', 'Yaya 8', '2026-04-04 05:52:41', 'officer', 'O2', '2026-04-11 11:05:19'),
(6, '02/25/00083/001/P/5550', '200105402095', 'O2', 'BW-367', 24.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'Yaya 8', '2026-04-05 04:46:13', 'officer', 'O2', '2026-04-11 11:13:23'),
(7, '02/25/00083/001/P/0100', '200305402095', 'O2', 'AT-307', -1.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', '2026-04-15 04:10:34', 'farmer', '200305402095', '2026-04-15 04:12:35'),
(8, '02/25/00083/001/P/0777', '200405402095', 'O0012', 'AT-308', 70.00, 'Western', 'Gampaha', 'Ja-Ela', 'Buluruppa', 'yaya 5', '2026-04-16 10:43:58', 'farmer', '200405402095', '2026-04-17 02:13:26');

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_edited` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `disease_officer_responses`
--

INSERT INTO `disease_officer_responses` (`id`, `report_code`, `officer_id`, `response_message`, `response_media`, `created_at`, `updated_at`, `is_edited`, `is_deleted`) VALUES
(5, 'DR013', 'O0001', 'Hello', 'DR013_officer_O0001_close-up-of-raindrops-on-leave_1775404928_0.jpg,DR013_officer_upd_O0001_close-up-of-raindrops-on-leaves-hd-background-luxury-hd-wallpaper-image-trendy-background-illustration-free-photo_1775414508_0.jpg,DR013_officer_upd_O0001_Image_created_with_a_mobile_phone_1775414524_0.png', '2026-04-05 10:32:08', '2026-04-05 13:16:15', 1, 1),
(6, 'DR013', 'O0001', 'Make sure you meet the supervisor and co-supervisor before you come to the presentation and viva. You can get their feedback in the final meetings and finalize your work.', 'DR013_officer_O0001_close-up-of-raindrops-on-leave_1775415920_0.jpg,DR013_officer_upd_O0001_Image_created_with_a_mobile_phone_1775417440_0.png', '2026-04-05 13:35:20', '2026-04-05 14:00:40', 1, 0),
(7, 'DR015', 'O0001', 'I got this', 'DR015_officer_O0001_close-up-of-raindrops-on-leave_1775422843_0.jpg', '2026-04-05 15:30:43', '2026-04-05 15:30:43', 0, 0),
(8, 'DR015', 'O0001', 'I\'m going to handle this problem', 'DR015_officer_O0001_Image_created_with_a_mobile_ph_1775422957_0.png', '2026-04-05 15:32:37', '2026-04-05 15:32:37', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `disease_reports`
--

CREATE TABLE `disease_reports` (
  `report_code` varchar(20) NOT NULL DEFAULT '',
  `farmerNIC` varchar(20) NOT NULL,
  `plrNumber` varchar(50) DEFAULT NULL,
  `observationDate` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `media` text DEFAULT NULL,
  `severity` enum('low','medium','high') NOT NULL,
  `affectedArea` decimal(10,2) NOT NULL,
  `status` enum('pending','under_review','resolved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `is_edited` tinyint(1) DEFAULT 0,
  `status_updated_by` varchar(50) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `disease_reports`
--

INSERT INTO `disease_reports` (`report_code`, `farmerNIC`, `plrNumber`, `observationDate`, `title`, `description`, `media`, `severity`, `affectedArea`, `status`, `created_at`, `updated_at`, `is_edited`, `status_updated_by`, `is_deleted`) VALUES
('DR001', '200206102814', 'PLR123', '2025-10-19', 'Test CRUD', 'this is a test crud insertion for interim ssadsajd akjsdblsakdbkasld baskljdjasdbjas', 'DR001_WhatsApp_Video_2025-08-20_at_1_1760903562.mp4', 'medium', 54.40, 'pending', '2025-10-19 14:22:42', '2026-04-05 13:02:52', 0, NULL, 1),
('DR002', '200206102814', 'PLR123', '2025-10-21', 'adsdas dasdasd asdas dsds', 'as dasdasdasd asdasmndbask djasbdkasdb akjsdb askdjasbndjkasd baksjmdbnaksjd bajs', 'DR002_help_1761077069.png', 'high', 23.00, 'pending', '2025-10-21 14:34:29', '2026-04-05 13:53:09', 0, 'O0001', 0),
('DR003', '222222222v', 'PLR123', '2025-10-22', 'Asjdisj aisjdias djiasjdisa', 'jsahdushdausdh asodjasiodasjdoas doasidjoas', 'DR003_WhatsApp_Video_2025-08-20_at_1_1761110123.mp4', 'high', 23.00, 'pending', '2025-10-21 23:45:23', '2025-10-21 23:45:23', 0, NULL, 0),
('DR004', '111111111v', 'PLR123', '2025-10-22', 'sdjasidj aidjasiodjasd oasidjasodijsado adjaiosdjaosid j', 'sjdhas dshaodha doiasjdioadj asiodjasoida sdsadhaisodjhsaoidjao', 'DR004_WhatsApp_Video_2025-08-20_at_1_1761110627.mp4', 'high', 21.10, 'pending', '2025-10-21 23:53:47', '2025-10-21 23:53:47', 0, NULL, 0),
('DR008', '200105402095', '02/25/00083/001/P/0066', '2025-10-22', 'hbjk jllal;al', 'a set of words that is complete in itself, typically containing a subject and predicate, conveying a statement, question, exclamation, or command, and consisting of a main clause and sometimes one or more subordinate clauses.', '', 'low', 100.00, 'pending', '2025-10-22 09:39:18', '2025-12-25 12:54:39', 0, NULL, 0),
('DR009', '200105402095', '02/25/00083/001/P/0067', '2025-10-22', 'hhhhhhh', 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz', 'DR009_nadu_1761147714.jpeg', 'medium', 123.00, 'pending', '2025-10-22 10:11:54', '2025-12-25 12:54:43', 0, NULL, 0),
('DR011', '200105402095', '02/25/00083/001/P/0066', '2025-10-23', 'ttttttttt', 'tttttttttttttttttttttttttttttttttttt', 'DR011_WhatsApp_Image_2025-10-23_at_0_1761192713.jpg', 'high', 1.00, 'pending', '2025-10-22 22:41:53', '2025-12-25 12:54:46', 0, NULL, 0),
('DR012', '200105402095', '02/25/00083/001/P/0067', '2025-10-23', 'hshds dsds', 'sjdnsjd nsjd  sdnsjdn sjdnsajdnsajdnada', 'DR012_Screenshot_2025-12-26_at_12_21_1766689242_0.png', 'high', 2.00, 'resolved', '2025-10-23 01:13:40', '2026-04-05 13:41:37', 0, 'O0001', 0),
('DR013', '200105402095', '02/25/00083/001/P/0067', '2026-04-05', 'Testing 1234', 'Make sure you meet the supervisor and co-supervisor before you come to the presentation and viva. You can get their feedback in the final meetings and finalize your work. \r\n\r\nAlso, plan and design your presentation and the demonstration well to give the maximum value to all the effort you put into this project throughout the year.\r\n\r\nAlso, ensure your backups are ready when you come to the presentation in case anything goes wrong. (Have an extra device prepared to run the system.', 'DR013_close-up-of-raindrops-on-leave_1775414818_0.jpg', 'high', 6.00, 'under_review', '2026-04-05 10:09:43', '2026-04-05 13:17:57', 1, 'O0001', 0),
('DR014', '200105402095', '02/25/00083/001/P/0066', '2026-04-05', 'Testin 2345', 'Each group is allocated a maximum of 30 minutes for the presentation and the demonstration. A Q&A session and a code check will follow the presentation and demonstration. \r\n\r\nYou should do a 5 to 10-minute presentation and a maximum of 20 to 25-minute demonstration. (You can change the durations accordingly within the 30 minutes)', 'NEW_close-up-of-raindrops-on-leave_1775421683_0.jpg', 'high', 14.00, 'under_review', '2026-04-05 15:11:23', '2026-04-05 15:11:49', 0, 'O0001', 0),
('DR015', '200105402095', '02/25/00083/001/P/0067', '2026-04-05', 'Testing 3456', 'Each group is allocated a maximum of 30 minutes for the presentation and the demonstration. A Q&A session and a code check will follow the presentation and demonstration. \r\n\r\nYou should do a 5 to 10-minute presentation and a maximum of 20 to 25-minute demonstration. (You can change the durations accordingly within the 30 minutes)', 'NEW_close-up-of-raindrops-on-leave_1775422254_0.jpg', 'high', 8.80, 'under_review', '2026-04-05 15:20:54', '2026-04-05 15:30:32', 0, 'O0001', 0),
('DR016', '200254201944', '02/25/00083/001/P/7799', '2026-04-18', 'This is test', 'Donald John Trump (born June 14, 1946) is an American politician, media personality, and businessman who is the 47th president of the United States. A member of the Republican Party, he served as the 45th president from 2017 to 2021.\r\n\r\nBorn into a wealthy New York City family, Trump graduated from the University of Pennsylvania in 1968 with a bachelor\'s degree in economics. He became the president of his family\'s real estate business in 1971, renamed it the Trump Organization, and began acquiring and building skyscrapers, hotels, casinos, and golf courses. He launched side ventures, many licensing the Trump name, and filed for six business bankruptcies in the 1990s and 2000s. From 2004 to 2015, he hosted the reality television show The Apprentice, bolstering his fame as a billionaire. Presenting himself as a political outsider, Trump won the 2016 presidential election against Democratic Party nominee Hillary Clinton.', 'NEW_The-Hidden-Downsides-of-Urea-F_1776488782_0.jpg', 'high', 17.00, 'pending', '2026-04-18 05:06:22', NULL, 0, NULL, 0);

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
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `email` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmers`
--

INSERT INTO `farmers` (`nic`, `full_name`, `registration_id`, `phone_no`, `password`, `gender`, `birthdate`, `address`, `profile_image`, `status`, `email`) VALUES
('', '', 40, '0765565113', '$2y$10$ywSHPMniBatvb0jhyOZbWOWJSvv4oGbxsNzcHTaHM3VOqB37XquYm', 'male', '2025-10-13', '55,Gampaha,Udugampola', NULL, 'Active', 0),
('200000000000', 'Nimal Silva', 41, '0112233445', '$2y$10$gW5djTFho0B5.6wf74ldTubulGdV3QFE38dNgX.f4MA2Kx01./skK', NULL, NULL, NULL, NULL, 'Active', 0),
('200005402095', 'amal perera', 31, '0778316446', '$2y$10$qMqMGUCaqfjrelhqBUbQgOtx6dwe47KcIZJFt07dSn/jK67QNecfO', NULL, NULL, NULL, NULL, 'Active', 0),
('200011223344', 'K.R.Aberathna', 42, '0765565145', '$2y$10$M3SQbP50HK91rs1mnCEbcugBUU1L1CBvJ18GDHa0itbtiwAwx6qyO', 'male', '2025-10-13', '55,Gampaha,Udugampola', NULL, 'Active', 0),
('200105402095', 'Sanjana Rajapaksha', 43, '0774920587', '$2y$10$zfaOSt9p9NrA2J9y2GZ1suJOiNNxrtfVVmaIttuATB7ZtvNRAxLR.', 'male', '2001-02-16', '262,Thotillagahawaththa,Katuwellegama', '/uploads/farmer_profiles/farmer_200105402095.jpg', 'Active', 0),
('200254201944', 'Janeesha Widanage', 28, '0778316232', '$2y$10$OCjw5zuNJs0GI.yNHjtjLuMI7lQkoLtEALF8.JsQf4odr.qoQ2WNm', NULL, NULL, NULL, '/uploads/farmer_profiles/farmer_200254201944.jpg', 'Active', 0),
('200254201945', 'Kamal Widanage', 26, '0778316231', '$2y$10$BaeoAQfMaXy00B.JeY5qxOexOJPwPLaVU4DYdafZTD0hxdEgwWbuG', NULL, NULL, NULL, NULL, 'Active', 0),
('200305402095', 'Menuja Alwis', 44, '0774920666', '$2y$10$SMPjgBmAl/HGVloMH7Cuf.1F9D/L2FDXj4g8yO0.UBIFEUhI6Qfcq', 'male', '2025-10-07', '556,Nittabuwa', '/uploads/farmer_profiles/farmer_200305402095.jpg', 'Active', 0),
('200405402095', 'Kamal Mendis', 45, '0774920888', '$2y$10$5YFKmNSAIs51LXt/LNPGYeHN91DWb8Ny9fcwJvhfxq54bZ6n4N8zm', 'male', '2000-12-14', '556,Nittabuwa', NULL, 'Active', 0),
('222222222v', 'Jack Sparrow', 46, '0222222222', '$2y$10$4G27psZv4YQCs8dKZolwO..ncdHC15H1FW7TrI0zS1h/lZoSba0DK', NULL, NULL, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `farmer_timeline`
--

CREATE TABLE `farmer_timeline` (
  `farmer_nic` varchar(20) NOT NULL,
  `plr` varchar(50) NOT NULL,
  `start_date` date DEFAULT NULL,
  `stage1_request` enum('none','pending','approved') DEFAULT 'none',
  `stage2_request` enum('none','pending','approved') DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmer_timeline`
--

INSERT INTO `farmer_timeline` (`farmer_nic`, `plr`, `start_date`, `stage1_request`, `stage2_request`) VALUES
('200305402095', '02/25/00083/001/P/0200', '2026-04-05', 'none', 'none'),
('200305402095', '02/25/00083/001/P/0995', '2025-12-02', 'approved', 'approved'),
('200305402095', '02/25/00083/001/P/0999', '2026-03-15', 'none', 'none'),
('200305402095', '02/25/00083/001/P/3311', '2026-04-13', 'none', 'none'),
('200305402095', '02/25/00083/001/P/3314', '2026-04-13', 'none', 'none'),
('200305402095', '02/25/00083/001/P/5236', '2026-03-01', 'approved', 'none'),
('200305402095', '02/25/00083/001/P/9991', '2026-04-10', 'none', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `farmer_timeline_progress`
--

CREATE TABLE `farmer_timeline_progress` (
  `id` int(11) NOT NULL,
  `farmer_nic` varchar(20) DEFAULT NULL,
  `plr` varchar(30) DEFAULT NULL,
  `step_order` int(11) DEFAULT NULL,
  `status` enum('done','pending','problem') NOT NULL,
  `updated_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmer_timeline_progress`
--

INSERT INTO `farmer_timeline_progress` (`id`, `farmer_nic`, `plr`, `step_order`, `status`, `updated_date`) VALUES
(92, '200305402095', '02/25/00083/001/P/0999', 1, 'done', '2026-04-10'),
(93, '200305402095', '02/25/00083/001/P/0999', 2, 'done', '2026-04-10'),
(95, '200305402095', '02/25/00083/001/P/0999', 3, 'problem', '2026-04-10'),
(96, '200305402095', '02/25/00083/001/P/9991', 1, 'done', '2026-04-10'),
(97, '200305402095', '02/25/00083/001/P/9991', 2, 'done', '2026-04-10'),
(101, '200305402095', '02/25/00083/001/P/5236', 1, 'done', '2026-04-12'),
(105, '200305402095', '02/25/00083/001/P/3314', 1, 'done', '2026-04-13'),
(106, '200305402095', '02/25/00083/001/P/5236', 2, 'done', '2026-04-13'),
(107, '200305402095', '02/25/00083/001/P/5236', 3, 'done', '2026-04-13'),
(108, '200305402095', '02/25/00083/001/P/5236', 4, 'done', '2026-04-13'),
(109, '200305402095', '02/25/00083/001/P/5236', 5, 'done', '2026-04-13'),
(112, '200305402095', '02/25/00083/001/P/3311', 1, 'done', '2026-04-13'),
(115, '200305402095', '02/25/00083/001/P/5236', 6, 'done', '2026-04-15'),
(149, '200305402095', '02/25/00083/001/P/0200', 1, 'done', '2026-04-15'),
(150, '200305402095', '02/25/00083/001/P/0200', 2, 'done', '2026-04-15'),
(151, '200305402095', '02/25/00083/001/P/0995', 1, 'done', '2026-04-15'),
(152, '200305402095', '02/25/00083/001/P/0995', 2, 'done', '2026-04-15'),
(153, '200305402095', '02/25/00083/001/P/0995', 3, 'done', '2026-04-15'),
(156, '200305402095', '02/25/00083/001/P/0995', 4, 'done', '2026-04-15'),
(157, '200305402095', '02/25/00083/001/P/0995', 5, 'done', '2026-04-15'),
(158, '200305402095', '02/25/00083/001/P/0995', 6, 'done', '2026-04-15'),
(160, '200305402095', '02/25/00083/001/P/0995', 7, 'done', '2026-04-15'),
(161, '200305402095', '02/25/00083/001/P/0995', 8, 'done', '2026-04-15'),
(162, '200305402095', '02/25/00083/001/P/0995', 9, 'done', '2026-04-15'),
(163, '200305402095', '02/25/00083/001/P/0995', 10, 'done', '2026-04-15'),
(164, '200305402095', '02/25/00083/001/P/0995', 11, 'done', '2026-04-15'),
(166, '200305402095', '02/25/00083/001/P/5236', 7, 'done', '2026-04-15'),
(167, '200305402095', '02/25/00083/001/P/0200', 3, 'problem', '2026-04-18');

-- --------------------------------------------------------

--
-- Table structure for table `fertilizer_recommendations`
--

CREATE TABLE `fertilizer_recommendations` (
  `id` int(11) NOT NULL,
  `crop_type_months` decimal(3,1) NOT NULL,
  `crop_stage` int(11) NOT NULL,
  `urea_per_acre` decimal(6,2) NOT NULL,
  `potash_per_acre` decimal(6,2) NOT NULL,
  `phosphate_per_acre` decimal(6,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fertilizer_recommendations`
--

INSERT INTO `fertilizer_recommendations` (`id`, `crop_type_months`, `crop_stage`, `urea_per_acre`, `potash_per_acre`, `phosphate_per_acre`, `updated_at`) VALUES
(1, 2.5, 1, 12.00, 20.00, 12.00, '2026-04-18 03:33:43'),
(2, 2.5, 2, 30.00, 43.00, 33.40, '2026-04-16 02:53:58'),
(3, 2.5, 3, 45.00, 50.00, 55.00, '2026-04-16 02:54:06'),
(4, 3.0, 1, 80.00, 80.00, 80.00, '2026-01-04 06:16:53'),
(5, 3.0, 2, 30.00, 43.00, 33.40, '2026-01-05 14:01:18'),
(6, 3.0, 3, 60.00, 60.00, 60.00, '2026-01-04 06:16:53'),
(7, 3.5, 1, 110.00, 110.00, 110.00, '2026-01-04 06:16:53'),
(8, 3.5, 2, 100.00, 100.00, 100.00, '2026-01-04 06:16:53'),
(9, 3.5, 3, 90.00, 90.00, 90.00, '2026-01-04 06:16:53'),
(10, 4.0, 1, 150.00, 150.00, 150.00, '2026-01-04 06:16:53'),
(11, 4.0, 2, 140.00, 140.00, 140.00, '2026-01-04 06:16:53'),
(12, 4.0, 3, 130.00, 130.00, 130.00, '2026-01-04 06:16:53'),
(14, 4.5, 1, 500.00, 500.00, 500.00, '2026-04-16 03:09:52'),
(15, 4.5, 2, 459.00, 245.00, 44.50, '2026-04-16 03:18:26'),
(16, 4.5, 3, 300.00, 300.00, 300.00, '2026-04-16 03:02:09');

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
-- Table structure for table `knowledge_articles`
--

CREATE TABLE `knowledge_articles` (
  `id` int(11) NOT NULL,
  `article_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `knowledge_articles`
--

INSERT INTO `knowledge_articles` (`id`, `article_name`, `description`, `image_path`, `category_id`, `created_at`, `updated_at`, `is_deleted`) VALUES
(6, 'Bg 352 (Short Duration)', 'Bg 352 is a short-duration rice variety that matures in approximately 90 days, making it ideal for regions with limited water availability or short growing seasons. This variety is resistant to several common pests, including brown planthopper, and can tolerate moderate drought conditions. \r\n\r\nPlanting Tips: Sow seeds in well-prepared, leveled fields with spacing of 20 x 20 cm. Maintain water management for optimal growth.\r\n\r\nHarvesting:  Harvest when grains turn golden yellow and moisture content is around 20%. Allows quick turnover for multiple crops per year.\r\n\r\nYield:  Expected yield: 4-5 tons per hectare under optimal conditions.', 'uploads/knowledgecenter/1764413164_Bg352.png', 5, '2025-11-29 10:46:04', '2025-12-03 09:20:03', 0),
(10, 'Suwandel', 'Suwandel is a premium traditional rice variety prized for aroma, soft texture, and taste. Mostly grown in wet zone areas, it has a maturation period of around 120 days. \r\n\r\nPlanting Tips: Best in fertile, clay-rich soils. Transplant seedlings 25 x 25 cm apart and maintain consistent water levels.\r\n\r\nPest & Disease Management: Moderately susceptible to blast disease and leaf spot. Regular monitoring and timely organic fungicide application is recommended.\r\n\r\nHarvesting: Harvest when grains are fully mature to retain aroma and quality.\r\n\r\nYield: Average: 3-4 tons per hectare. Premium quality fetches higher market price.', 'uploads/knowledgecenter/1764742123_Suwandel.png', 5, '2025-12-03 06:08:43', '2025-12-03 09:21:40', 0),
(12, 'Bg 300 (High Yield)', 'Bg 300 is a high-yield commercial variety resistant to several pests and diseases. Growth period is around 110 days. Strong stalks prevent lodging under heavy rainfall. \r\n\r\nPlanting Tips: Well-fertilized fields with proper water retention. Transplant seedlings at 20 x 20 cm spacing. Regular weeding and nitrogen management boost yield.\r\n\r\nPest Control:  Resistant to brown planthopper and stem borers; monitor for occasional outbreaks.\r\n\r\nHarvesting: Harvest when 80-90% of grains ripen. Proper drying ensures grain quality for storage or sale.\r\n\r\nYield: 6-7 tons per hectare under ideal conditions. Suitable for high-demand commercial production.', 'uploads/knowledgecenter/1764766473_Bg300.jpeg', 5, '2025-12-03 12:54:33', '2025-12-03 12:54:33', 0),
(13, 'Organic Fertilizers', 'Organic fertilizers such as compost, manure, and green manure enrich the soil with nutrients naturally. They improve soil structure, increase water retention, and support beneficial microorganisms.\r\n\r\nApplication Tips:  Apply during land preparation or as top dressing. Balance with crop nutrient requirements for optimal results.\r\n\r\nBenefits: Enhances long-term soil fertility and reduces dependency on chemical inputs.\r\n\r\nPrecautions: Avoid over-application to prevent nutrient runoff.', 'uploads/knowledgecenter/1764766866_organic_fertilizer.jpg', 6, '2025-12-03 13:01:06', '2025-12-03 13:01:06', 0),
(14, 'Chemical Fertilizers', 'Chemical fertilizers play a vital role in modern paddy cultivation, helping farmers achieve higher yields and maintain soil fertility. While organic matter improves soil health, chemical fertilizers provide essential nutrients in precise amounts, ensuring rice plants grow healthy and productive.\r\n\r\n<b>Types of Chemical Fertilizers for Paddy</b>\r\n\r\nRice plants need three primary nutrients: Nitrogen (N), Phosphorus (P), and Potassium (K). These are available in different chemical fertilizer forms:\r\n\r\n<b>Nitrogen (N) Fertilizers</b> – Promote leaf and tiller growth\r\n\r\n1. Urea\r\n2. Ammonium sulfate\r\n<img src=\"http://localhost/FarmerConnect/uploads/knowledgecenter/articles/1766939334_urea-nitrogen.webp\" alt=\"\">\r\n\r\n<b>Phosphorus (P) Fertilizers</b> – Aid root development and early growth\r\n\r\n1. Single superphosphate (SSP)\r\n2. Triple superphosphate (TSP)\r\n<img src=\"http://localhost/FarmerConnect/uploads/knowledgecenter/articles/1766939482_Triple-Super-Phosphat.jpg\" alt=\"\">\r\n\r\n<b>Potassium (K) Fertilizers </b>– Improve disease resistance and grain quality\r\n\r\n1. Muriate of potash (MOP)\r\n<img src=\"http://localhost/FarmerConnect/uploads/knowledgecenter/articles/1766939499_mop.png\" alt=\"\">\r\n\r\n<b>Secondary Nutrients and Micronutrients</b>\r\n\r\n* Calcium, Magnesium, Sulfur, Zinc, Boron may be needed depending on soil tests\r\n* Soil testing is recommended for accurate application in paddy fields\r\n\r\n<b>Fertilizer Application Stages for Paddy</b>\r\n\r\n<b>1. Basal Fertilizer</b>\r\n* Applied before or at transplanting in paddy fields\r\n* Provides initial nutrients for seedling establishment\r\n* Typical formula: Nitrogen + Phosphorus + Potassium in recommended proportions\r\n\r\n<b>2. Top Dressing</b>\r\n* Top dressing ensures nutrients are available during critical paddy growth stages:\r\n* Tillering stage – encourages more tillers\r\n* Panicle initiation stage – supports flower formation and grain filling\r\nSplit nitrogen application is important to prevent nutrient loss and improve efficiency in paddy cultivation.\r\n\r\n<b>Recommended Practices for Paddy Fields</b>\r\n\r\n1. Follow DOA guidelines for nutrient rates per hectare based on paddy variety and season\r\n2. Avoid overuse: Excess nitrogen leads to lodge-prone, weak plants and environmental issues\r\n3. Even application: Broadcast evenly or use side-dressing techniques in paddy\r\n4. Water management: Fertilizers are more effective when soil moisture in paddy fields is adequate\r\n5. Timing: Apply fertilizers when paddy plants are actively growing\r\n\r\n<b>Safety Precautions</b>\r\n\r\n1. Always wear gloves and masks when handling chemical fertilizers\r\n2. Do not store near food or in damp conditions\r\n3. Wash hands and tools after application\r\n\r\n<b>Integrated Fertilizer Management (IFM) for Paddy</b>\r\n\r\nCombine chemical fertilizers with organic manure for better soil health\r\nUse green manures and compost along with fertilizers\r\nRegular soil testing helps avoid nutrient imbalances in paddy fields', 'uploads/knowledgecenter/1766939894_chemical_fertilizer.webp', 6, '2025-12-28 16:38:14', '2025-12-28 17:16:30', 0),
(15, 'Foliar Fertilizers', 'Foliar fertilizers are applied directly to the leaves and are absorbed quickly. They are ideal for correcting micronutrient deficiencies during critical growth stages.\r\n\r\nApplication Tips: Apply in the early morning or late afternoon to prevent leaf burn. Ensure proper dilution as per product instructions.\r\n\r\nBenefits: Rapid nutrient absorption, improves crop quality, and supports recovery from stress.\r\n\r\nPrecautions: Avoid application during high sunlight or drought stress to prevent leaf damage.', 'uploads/knowledgecenter/1764767051_foliar_fertilizer.png', 6, '2025-12-03 13:04:11', '2026-04-17 16:47:47', 0),
(18, 'test', 'Bg 352 is a short-duration rice variety that matures in approximately 90 days, making it ideal for regions with limited water availability or short growing seasons. This variety is resistant to several common pests, including brown planthopper, and can tolerate moderate drought conditions.\r\n\r\nPlanting Tips: Sow seeds in well-prepared, leveled fields with spacing of 20 x 20 cm. Maintain water management for optimal growth.\r\n\r\nHarvesting: Harvest when grains turn golden yellow and moisture content is around 20%. Allows quick turnover for multiple crops per year.\r\n\r\nYield: Expected yield: 4-5 tons per hectare under optimal conditions.', 'uploads/knowledgecenter/1766411085_backiee-91591.jpg', 5, '2025-12-22 13:44:45', '2026-04-17 07:48:34', 1),
(19, 'test', 'Bg 352 is a short-duration rice variety that matures in approximately 90 days, making it ideal for regions with limited water availability or short growing seasons. This variety is resistant to several common pests, including brown planthopper, and can tolerate moderate drought conditions.\r\n\r\nPlanting Tips: Sow seeds in well-prepared, leveled fields with spacing of 20 x 20 cm. Maintain water management for optimal growth.\r\n\r\n<b>Harvesting</b>: Harvest when grains turn golden yellow and moisture content is around 20%. Allows quick turnover for multiple crops per year.\r\n<img src=\"http://localhost/FarmerConnect/uploads/knowledgecenter/articles/1766411491_backiee-91591.jpg\" alt=\"\">\r\nYield: Expected yield: 4-5 tons per hectare under optimal conditions.\r\n<img src=\"http://localhost/FarmerConnect/uploads/knowledgecenter/articles/1766902012_backiee-292979.jpg\" alt=\"\">', 'uploads/knowledgecenter/1766411496_backiee-292979.jpg', 5, '2025-12-22 13:51:36', '2025-12-28 07:06:15', 0),
(28, 'Test', 'nyehd', 'uploads/knowledgecenter/1776490223_Screenshot 2026-04-12 215857.png', 12, '2026-04-18 05:30:23', '2026-04-18 05:30:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_categories`
--

CREATE TABLE `knowledge_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `knowledge_categories`
--

INSERT INTO `knowledge_categories` (`id`, `category_name`, `created_by`, `description`, `image_path`, `created_at`, `updated_at`, `is_deleted`) VALUES
(5, 'Rice Varieties', 'O2', 'Explore high-yield and climate-smart rice types.', 'uploads/1761640642_rice-varieties.jpg', '2025-10-28 08:37:22', '2025-12-03 14:06:35', 0),
(6, 'Fertilizer Management', 'O2', 'Smart fertilizer use for better crop nutrition.', 'uploads/1761640672_fertilizer.jpg', '2025-10-28 08:37:52', '2025-10-28 08:37:52', 0),
(7, 'Pest Control', 'O2', 'Best practices to control pests and protect your crops.', 'uploads/1761640739_pest-control.jpg', '2025-10-28 08:38:59', '2025-10-28 08:38:59', 0),
(8, 'Cultivation Techniques', 'O2', 'Methods for efficient land preparation, sowing, and harvesting.', 'uploads/1761640782_cultivation-techniques.png', '2025-10-28 08:39:42', '2025-10-28 08:39:42', 0),
(9, 'Soil Health', 'O2', 'Tips on maintaining soil fertility and long-term health.', 'uploads/1761641031_soil-health.jpg', '2025-10-28 08:43:51', '2025-10-28 08:43:51', 0),
(10, 'Others', 'O2', 'Extra resources to support your farming.', 'uploads/1761641070_others.jpg', '2025-10-28 08:44:30', '2025-10-28 08:44:30', 0),
(11, 'test test', 'O2', 'test test', 'uploads/1764771063_Suwandel.png', '2025-12-03 14:11:03', '2025-12-03 14:19:22', 1),
(12, 'test', 'O0012', 'test', 'uploads/1776490038_The-Hidden-Downsides-of-Urea-Fertilizer-What-You-Need-to-Know.jpg', '2026-04-18 05:27:18', '2026-04-18 05:27:18', 0);

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
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `gender` enum('male','female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `govi_jana_sewa_division` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officers`
--

INSERT INTO `officers` (`officer_id`, `nic`, `registration_id`, `first_name`, `last_name`, `phone_no`, `email`, `password`, `image_url`, `updated_at`, `status`, `gender`, `birthdate`, `govi_jana_sewa_division`) VALUES
('O0001', '200206102815', 49, 'Andrew', 'Aiden', '', 'officer1@fc.lk', '$2y$10$N.dXBHTXv159uRW/0AToXOfB.lV4jOg6sYIW.F6R.Pauypyh8tVim', NULL, '2026-04-18 05:18:43', 'Active', NULL, NULL, NULL),
('O0002', '200312345678', 50, 'Menuja', 'Alwis', '0121212121', 'menujaalwis@gmail.com', '$2y$10$S2c0S5R/fi9ZIe30tkfZ0.kGEjjsbcpHB4uC8v5kplbDSZJzlqUOy', NULL, '2026-04-18 05:18:43', 'Active', NULL, NULL, NULL),
('O0003', '200311111111', 51, 'Miguel', 'Diaz', '0123456789', 'abcdef@gmail.com', '$2y$10$IwFwLhD5CN.7Wn97iGqbVeQ/j0UytupkofZ5OOl1YCPPYdJDuYG/G', NULL, '2026-04-18 05:18:43', 'Active', NULL, NULL, NULL),
('O0004', '200322222222', 52, 'John', 'Doe', '0222222222', 'a@gmail.com', '$2y$10$/HoHxIgAW4er4W6MG7vegOWPBVg7JX.VaBTeimvP/YcacdDMXaR3O', NULL, '2026-04-18 05:18:43', 'Active', NULL, NULL, NULL),
('O0005', '200320312737', 53, 'aaa', 'bbb', '0121212123', 'sac@gmail.com', '$2y$10$hV5hpm5S0uC7hnUvexuAZeSdNYX/DyR2zoXS/XvTi2sIx6SwuCDya', NULL, '2026-04-18 05:18:43', 'Active', NULL, NULL, 'Maharagama'),
('O0012', '200000000088', 47, 'Asanka', 'Pathirana', '0774920688', 'asnkapathirana555@gmail.com', '$2y$10$XxY83YfC3/D6CsdswbTj4.oWLdLN4Hc9RsOdTUFp/6C9kPPhtO0hq', NULL, '2026-04-18 04:54:58', 'Active', NULL, NULL, 'Ja-Ela'),
('O2', '333333333v', 48, 'Saman', 'Perera', '', 'abc@gamil.com', '$2y$10$Bxmh4FTfDnvNRqCNWJWufeQ0I8zUXbcHAjWRey4ocLVmosqNs3lgu', NULL, '2026-04-18 04:55:05', 'Active', NULL, NULL, 'Marandagahamula');

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
(28, 'P-SE0011-2', 'SE0011', '200254201944', 1, 10.00, 'cash', '2026-01-11 10:37:46', 'order_confirmed'),
(29, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2026-01-11 12:33:37', 'order_cancelled'),
(30, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'cash', '2026-01-11 13:10:39', 'order_picked'),
(31, 'P-SE0011-2', 'SE0011', '200254201944', 1, 10.00, 'cash', '2026-01-12 01:08:01', 'order_picked'),
(32, 'P-SE0011-1', 'SE0011', '200254201944', 2, 200.00, 'online', '2026-01-12 01:13:29', 'order_picked'),
(33, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'online', '2026-01-12 13:24:01', 'order_picked'),
(34, 'P-SE0015-1', 'SE0015', '200254201944', 4, 400.00, 'cash', '2026-04-17 10:56:54', 'order_cancelled'),
(35, 'P-SE0015-1', 'SE0015', '200254201944', 10, 1000.00, 'cash', '2026-04-17 12:09:44', 'order_placed'),
(36, 'P-SE0015-1', 'SE0015', '200254201944', 6, 600.00, 'cash', '2026-04-17 12:12:22', 'order_placed'),
(37, 'P-SE0015-1', 'SE0015', '200254201944', 10, 1000.00, 'cash', '2026-04-17 12:34:22', 'order_placed'),
(38, 'P-SE0015-1', 'SE0015', '200254201944', 1, 100.00, 'cash', '2026-04-17 12:43:56', 'order_placed'),
(39, 'P-SE0015-1', 'SE0015', '200254201944', 5, 500.00, 'cash', '2026-04-17 12:54:39', 'order_placed'),
(40, 'P-SE0015-1', 'SE0015', '200254201944', 4, 400.00, 'cash', '2026-04-17 13:02:03', 'order_placed'),
(41, 'P-SE0011-1', 'SE0011', '200254201944', 35, 3500.00, 'online', '2026-04-17 13:08:08', 'order_placed'),
(42, 'P-SE0011-1', 'SE0011', '200254201944', 35, 3500.00, 'online', '2026-04-17 13:11:22', 'order_placed'),
(43, 'P-SE0011-1', 'SE0011', '200254201944', 35, 3500.00, 'online', '2026-04-17 13:16:58', 'order_placed'),
(44, 'P-SE0011-1', 'SE0011', '200254201944', 35, 3500.00, 'cash', '2026-04-17 13:17:53', 'order_placed'),
(45, 'P-SE0011-2', 'SE0011', '200254201944', 1, 10.00, 'online', '2026-04-17 13:19:17', 'order_placed'),
(46, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 13:19:33', 'order_placed'),
(47, 'P-SE0011-2', 'SE0011', '200254201944', 1, 10.00, 'online', '2026-04-17 13:25:37', 'order_placed'),
(48, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 13:25:50', 'order_placed'),
(49, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 13:28:48', 'order_placed'),
(50, 'P-SE0011-2', 'SE0011', '200254201944', 1, 10.00, 'online', '2026-04-17 13:55:34', 'order_placed'),
(51, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 13:55:44', 'order_placed'),
(52, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 13:58:19', 'order_placed'),
(53, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 14:03:05', 'order_placed'),
(54, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 14:08:26', 'order_placed'),
(55, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 14:13:35', 'order_placed'),
(56, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 14:16:07', 'order_placed'),
(57, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 14:18:20', 'order_placed'),
(58, 'P-SE0011-2', 'SE0011', '200254201944', 12, 120.00, 'online', '2026-04-17 14:21:23', 'order_placed'),
(59, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 14:40:45', 'order_placed'),
(60, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 14:58:37', 'order_placed'),
(61, 'P-SE0011-2', 'SE0011', '200254201944', 1, 10.00, 'online', '2026-04-17 14:58:52', 'order_placed'),
(62, 'P-SE0011-2', 'SE0011', '200254201944', 10, 100.00, 'online', '2026-04-17 14:59:11', 'order_placed'),
(63, 'P-SE0011-2', 'SE0011', '200254201944', 1, 10.00, 'online', '2026-04-17 15:00:11', 'order_placed'),
(64, 'P-SE0011-2', 'SE0011', '200254201944', 1, 10.00, 'online', '2026-04-17 15:00:23', 'order_placed'),
(65, 'P-SE0011-2', 'SE0011', '200254201944', 8, 80.00, 'online', '2026-04-17 15:07:14', 'order_placed'),
(66, 'P-SE0011-2', 'SE0011', '200254201944', 27, 270.00, 'cash', '2026-04-17 15:07:38', 'order_placed'),
(67, 'P-SE0011-2', 'SE0011', '200254201944', 8, 80.00, 'online', '2026-04-17 15:08:33', 'order_cancelled'),
(68, 'P-SE0011-1', 'SE0011', '200254201944', 1, 100.00, 'online', '2026-04-17 17:03:53', 'order_confirmed');

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
(40, 30, 'ready_to_pickup', 'order_picked', '2026-04-04 22:09:13', 'SE0011'),
(41, 28, 'order_placed', 'order_confirmed', '2026-04-17 10:48:25', 'SE0011'),
(42, 34, 'order_placed', 'order_cancelled', '2026-04-17 11:10:28', 'SE0015'),
(43, 68, 'order_placed', 'order_confirmed', '2026-04-17 17:10:03', 'SE0011'),
(44, 67, 'order_placed', 'order_cancelled', '2026-04-17 17:10:34', 'SE0011');

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
('02/25/00083/001/P/0055', '200105402095', 'O2', 'BG-250', 25.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', '2026-04-14 22:32:05'),
('02/25/00083/001/P/0200', '200305402095', 'O2', 'BG-300', 70.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', '2026-04-14 21:59:11'),
('02/25/00083/001/P/0444', '200105402095', 'O2', 'BG-357', 20.00, 'Western', 'Gampaha', 'Marandagahamula', 'divlapitiya', 'yaya 5', '2026-04-14 22:39:13'),
('02/25/00083/001/P/0676', '200305402095', 'O2', 'BG-300', 70.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', '2026-04-18 03:59:52'),
('02/25/00083/001/P/0995', '200305402095', NULL, 'BW-367', 17.00, 'Western', 'Gampaha', 'Ja-Ela', 'Buluruppa', 'yaya 5', '2026-04-14 22:01:43'),
('02/25/00083/001/P/0999', '200305402095', 'O2', 'AT-308', 8.70, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', '2026-04-09 23:14:44'),
('02/25/00083/001/P/3311', '200305402095', 'O2', 'BW-375', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', '2026-04-10 23:31:33'),
('02/25/00083/001/P/3314', '200305402095', 'O0012', 'BW-375', 10.00, 'Western', 'Gampaha', 'Ja-Ela', 'Buluruppa', 'yaya 5', '2026-04-11 23:20:29'),
('02/25/00083/001/P/5236', '200305402095', 'O2', 'BG-250', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', '2026-04-11 21:04:34'),
('02/25/00083/001/P/7799', '200254201944', 'O2', 'BG-357', 34.00, 'Western', 'Gampaha', 'Marandagahamula', 'Thotillagahawaththa', 'yaya 5', '2026-04-18 05:04:48'),
('02/25/00083/001/P/9991', '200305402095', 'O2', 'BW-367', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', '2026-04-09 23:20:01');

-- --------------------------------------------------------

--
-- Table structure for table `paddy_requests`
--

CREATE TABLE `paddy_requests` (
  `id` int(11) NOT NULL,
  `PLR` varchar(50) DEFAULT NULL,
  `NIC_FK` varchar(15) DEFAULT NULL,
  `OfficerID` varchar(15) DEFAULT NULL,
  `Paddy_Seed_Variety` varchar(100) DEFAULT NULL,
  `Paddy_Size` decimal(10,2) DEFAULT NULL,
  `Province` varchar(50) DEFAULT NULL,
  `District` varchar(50) DEFAULT NULL,
  `Govi_Jana_Sewa_Division` varchar(100) DEFAULT NULL,
  `Grama_Niladhari_Division` varchar(100) DEFAULT NULL,
  `Yaya` varchar(50) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paddy_requests`
--

INSERT INTO `paddy_requests` (`id`, `PLR`, `NIC_FK`, `OfficerID`, `Paddy_Seed_Variety`, `Paddy_Size`, `Province`, `District`, `Govi_Jana_Sewa_Division`, `Grama_Niladhari_Division`, `Yaya`, `status`, `created_at`) VALUES
(1, '02/25/00083/001/P/3366', '200305402095', 'O2', 'BW-367', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', 'approved', '2026-04-10 23:59:20'),
(2, '02/25/00083/001/P/3377', '200305402095', 'O2', 'B-352', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', 'approved', '2026-04-11 00:03:07'),
(3, '02/25/00083/001/P/3311', '200305402095', 'O2', 'BW-375', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', 'approved', '2026-04-11 04:18:56'),
(4, '02/25/00083/001/P/1199', '200305402095', 'O2', 'B-352', 23.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'Yaya 8', 'pending', '2026-04-11 05:02:24'),
(5, '02/25/00083/001/P/2222', '200305402095', 'O2', 'B-352', 23.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'Yaya 8', 'approved', '2026-04-11 06:36:41'),
(6, '02/25/00083/001/P/2222', '200105402095', 'O2', 'B-352', 23.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'Yaya 8', 'approved', '2026-04-11 06:37:28'),
(7, '02/25/00083/001/P/2222', '200305402095', 'O2', 'B-352', 23.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'Yaya 8', 'rejected', '2026-04-11 06:58:04'),
(8, '02/25/00083/001/P/0999', '200305402095', 'O2', 'B-352', 23.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'Yaya 8', 'pending', '2026-04-11 07:24:07'),
(9, '02/25/00083/001/P/3367', '200305402095', 'O2', 'BW-367', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', 'pending', '2026-04-11 07:26:55'),
(10, '02/25/00083/001/P/9991', '200305402095', 'O2', 'BW-367', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', 'pending', '2026-04-11 07:53:34'),
(11, '02/25/00083/001/P/5236', '200305402095', 'O2', 'BG-250', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', 'approved', '2026-04-12 02:33:48'),
(12, '02/25/00083/001/P/0995', '200305402095', 'O2', 'BW-367', 10.00, 'Western', 'Gampaha', 'Ja-Ela', 'Buluruppa', 'yaya 5', 'approved', '2026-04-12 04:49:54'),
(13, '02/25/00083/001/P/3314', '200305402095', 'O2', 'BW-375', 10.00, 'Western', 'Gampaha', 'Ja-Ela', 'Buluruppa', 'yaya 5', 'approved', '2026-04-12 04:50:10'),
(14, '02/25/00083/001/P/0100', '200305402095', 'O2', 'BG-357', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', 'approved', '2026-04-13 07:17:35'),
(15, '02/25/00083/001/P/0200', '200305402095', 'O2', 'BG-357', 10.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', 'approved', '2026-04-14 06:37:47'),
(16, '02/25/00083/001/P/1200', '200305402095', 'O2', 'BG-300', 67.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', 'pending', '2026-04-15 04:13:13'),
(17, '02/25/00083/001/P/0676', '200305402095', 'O2', 'BG-300', 70.00, 'Western', 'Gampaha', 'Marandagahamula', 'Buluruppa', 'yaya 5', 'approved', '2026-04-16 09:42:32'),
(18, '02/25/00083/001/P/0777', '200405402095', 'O2', 'AT-308', 70.00, 'Western', 'Gampaha', 'Ja-Ela', 'Buluruppa', 'yaya 5', 'approved', '2026-04-16 10:43:38'),
(19, '02/25/00083/001/P/7799', '200254201944', 'O2', 'BG-357', 34.00, 'Western', 'Gampaha', 'Marandagahamula', 'Thotillagahawaththa', 'yaya 5', 'approved', '2026-04-18 05:03:56');

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
('P-SE0011-1', 'fertilizer', 'SE0011', 'Fertilizer', '', 'Kandy', 'litre', 100.00, 9, '1770559134_Plantix-plant-diseases.jpg', 'Instock', 'Central'),
('P-SE0011-2', 'crop', 'SE0011', 'Seeds', '', 'Kandy', 'litre', 10.00, 0, '1770496804_Zn1qjK8JMweyPhTNgrFvBigzOtuAjyniPrJ3L8E6.jpg', 'Outstock', 'Central'),
('P-SE0015-1', 'crop', 'SE0015', 'Rental', '', 'Kilinochchi', 'packet', 100.00, 0, '1776403591_The-Hidden-Downsides-of-Urea-Fertilizer-What-You-Need-to-Know.jpg', 'Outstock', 'Northern');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`registration_id`, `user_type`, `created_at`, `approval_status`) VALUES
(13, 'seller', '2025-10-18 12:42:59', 'pending'),
(14, 'seller', '2025-10-18 20:23:36', 'pending'),
(15, 'seller', '2025-10-20 04:30:23', 'pending'),
(16, 'seller', '2025-10-21 04:50:38', 'pending'),
(17, 'seller', '2025-10-21 04:58:19', 'pending'),
(19, 'farmer', '2025-10-22 06:02:37', 'pending'),
(20, 'farmer', '2025-10-22 06:03:44', 'pending'),
(21, 'farmer', '2025-10-22 06:07:58', 'pending'),
(22, 'farmer', '2025-10-22 06:09:27', 'pending'),
(25, 'seller', '2025-10-22 18:27:23', 'pending'),
(26, 'farmer', '2025-10-22 19:17:24', 'pending'),
(27, 'seller', '2025-10-23 04:25:10', 'pending'),
(28, 'farmer', '2025-10-23 04:40:33', 'pending'),
(29, 'seller', '2025-10-23 04:41:46', 'pending'),
(30, 'officer', '2025-10-23 05:05:36', 'pending'),
(31, 'farmer', '2025-10-23 05:27:02', 'pending'),
(32, 'farmer', '2025-10-23 05:30:03', 'pending'),
(33, 'seller', '2025-10-23 05:56:43', 'pending'),
(34, 'seller', '2025-10-23 06:18:57', 'pending'),
(35, 'seller', '2025-10-23 06:47:22', 'pending'),
(36, 'seller', '2025-10-23 07:52:30', 'pending'),
(37, 'seller', '2025-12-16 08:45:21', 'pending'),
(38, 'seller', '2025-12-16 08:50:14', 'pending'),
(39, 'seller', '2026-04-15 12:17:47', 'pending'),
(40, 'farmer', '2026-04-18 04:31:13', 'pending'),
(41, 'farmer', '2026-04-18 04:31:13', 'pending'),
(42, 'farmer', '2026-04-18 04:31:13', 'pending'),
(43, 'farmer', '2025-10-08 03:31:13', 'pending'),
(44, 'farmer', '2026-04-18 04:31:13', 'pending'),
(45, 'farmer', '2026-04-18 04:31:13', 'pending'),
(46, 'farmer', '2024-04-17 04:31:13', 'pending'),
(47, 'officer', '2026-04-18 04:53:42', 'approved'),
(48, 'officer', '2026-04-18 04:53:42', 'approved'),
(49, 'officer', '2026-04-18 05:17:52', 'approved'),
(50, 'officer', '2026-04-18 05:17:52', 'approved'),
(51, 'officer', '2026-04-18 05:17:52', 'approved'),
(52, 'officer', '2026-04-18 05:17:52', 'approved'),
(53, 'officer', '2026-04-18 05:17:52', 'approved');

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
(11, 'SE0011', '200254201940', 29, 'Janeesha', 'Hasadara', 'company c', '1278', '0778316456', 'janeeshahasadara@gmail.com', '209/5, Sri Mawatha , Miriswaththa', '$2y$10$CmQzCwuiZgbyuty4URrvu.AdHH5QAFDGhAmmmSqB4285bZUzbZXsW', 'Approved', '2025-10-23 10:11:46', '2026-04-16 19:17:27', 'https://cdn-icons-png.flaticon.com/512/847/847969.png'),
(15, 'SE0015', '200254201947', 36, 'Pumudu', 'Anuradha', 'abc d', 'abc d', '0778316245', 'pumudu820@gmail.com', 'dsasv', '$2y$10$JBaFOhXeEEubuPGhMG3VheZzV2HF1uqe.RoRbwY5A7SkN0.T7N5Qi', 'Approved', '2025-10-23 13:22:30', '2025-10-23 13:22:48', NULL),
(17, 'SE0017', '200105402099', 38, 'Malika', 'Nishantha', '1234', '8523', '0778316246', 'piyumiwk@gmail.com', 'dsasv', '$2y$10$6mnWLtpVNjHI75GuJD61letNV/GtM.PkKIaqz2lSq9QdD6PYXv5Ne', 'Rejected', '2025-12-16 14:20:15', '2026-01-04 21:55:32', NULL),
(18, 'SE0018', '789456123012', 39, 'kaml', 'fernando', '693', '45693', '7894561230', 'abc@gmail.com', '209/1, Sri Jinarathana Mawatha, Batakeththara, Madapatha , Piliyandala', '$2y$10$sCCfjFw22jCgYCam.6ldveJoN.V9EaO4BfKAfEw7R1.QrSrbg0x1S', 'Approved', '2026-04-15 17:47:47', '2026-04-15 17:50:50', NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `timeline_steps`
--

CREATE TABLE `timeline_steps` (
  `id` int(11) NOT NULL,
  `duration_months` decimal(3,1) NOT NULL,
  `stage` int(11) NOT NULL,
  `step_order` int(11) NOT NULL,
  `step_name` varchar(100) NOT NULL,
  `gap_days` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timeline_steps`
--

INSERT INTO `timeline_steps` (`id`, `duration_months`, `stage`, `step_order`, `step_name`, `gap_days`, `created_at`) VALUES
(21, 2.5, 1, 1, 'Ready the Field I', 0, '2026-01-25 11:32:44'),
(22, 2.5, 1, 2, 'Water Supply', 1, '2026-01-25 11:32:44'),
(23, 2.5, 1, 3, 'Prepare Land', 10, '2026-01-25 11:32:44'),
(24, 2.5, 1, 4, 'Ready the Field II', 8, '2026-01-25 11:32:44'),
(25, 2.5, 1, 5, 'Prepare Land II', 2, '2026-01-25 11:32:44'),
(26, 2.5, 2, 6, 'Sowing', 9, '2026-01-25 11:32:44'),
(27, 2.5, 2, 7, 'Fertilization I', 14, '2026-01-25 11:32:44'),
(28, 2.5, 2, 8, 'Fertilization II', 7, '2026-01-25 11:32:44'),
(29, 2.5, 2, 9, 'Fertilization III', 14, '2026-01-25 11:32:44'),
(30, 2.5, 2, 10, 'Fertilization IV', 14, '2026-01-25 11:32:44'),
(31, 2.5, 3, 11, 'Harvesting', 33, '2026-01-25 11:32:44'),
(32, 3.0, 1, 1, 'Ready the Field I', 0, '2026-01-25 11:34:24'),
(33, 3.0, 1, 2, 'Water Supply', 1, '2026-01-25 11:34:24'),
(34, 3.0, 1, 3, 'Prepare Land', 10, '2026-01-25 11:34:24'),
(35, 3.0, 1, 4, 'Ready the Field II', 8, '2026-01-25 11:34:24'),
(36, 3.0, 1, 5, 'Prepare Land II', 2, '2026-01-25 11:34:24'),
(37, 3.0, 2, 6, 'Sowing', 9, '2026-01-25 11:34:24'),
(38, 3.0, 2, 7, 'Fertilization I', 15, '2026-01-25 11:34:24'),
(39, 3.0, 2, 8, 'Fertilization II', 15, '2026-01-25 11:34:24'),
(40, 3.0, 2, 9, 'Fertilization III', 15, '2026-01-25 11:34:24'),
(41, 3.0, 2, 10, 'Fertilization IV', 7, '2026-01-25 11:34:24'),
(42, 3.0, 3, 11, 'Harvesting', 38, '2026-01-25 11:34:24'),
(43, 3.5, 1, 1, 'Ready the Field I', 0, '2026-01-25 11:35:51'),
(44, 3.5, 1, 2, 'Water Supply', 1, '2026-01-25 11:35:51'),
(45, 3.5, 1, 3, 'Prepare Land', 10, '2026-01-25 11:35:51'),
(46, 3.5, 1, 4, 'Ready the Field II', 8, '2026-01-25 11:35:51'),
(47, 3.5, 1, 5, 'Prepare Land II', 2, '2026-01-25 11:35:51'),
(48, 3.5, 2, 6, 'Sowing', 9, '2026-01-25 11:35:51'),
(49, 3.5, 2, 7, 'Fertilization I', 17, '2026-01-25 11:35:51'),
(50, 3.5, 2, 8, 'Fertilization II', 17, '2026-01-25 11:35:51'),
(51, 3.5, 2, 9, 'Fertilization III', 17, '2026-01-25 11:35:51'),
(52, 3.5, 2, 10, 'Fertilization IV', 8, '2026-01-25 11:35:51'),
(53, 3.5, 3, 11, 'Harvesting', 46, '2026-01-25 11:35:51'),
(54, 4.0, 1, 1, 'Ready the Field I', 0, '2026-01-25 11:37:05'),
(55, 4.0, 1, 2, 'Water Supply', 1, '2026-01-25 11:37:05'),
(56, 4.0, 1, 3, 'Prepare Land', 10, '2026-01-25 11:37:05'),
(57, 4.0, 1, 4, 'Ready the Field II', 8, '2026-01-25 11:37:05'),
(58, 4.0, 1, 5, 'Prepare Land II', 2, '2026-01-25 11:37:05'),
(59, 4.0, 2, 6, 'Sowing', 9, '2026-01-25 11:37:05'),
(60, 4.0, 2, 7, 'Fertilization I', 22, '2026-01-25 11:37:05'),
(61, 4.0, 2, 8, 'Fertilization II', 22, '2026-01-25 11:37:05'),
(62, 4.0, 2, 9, 'Fertilization III', 15, '2026-01-25 11:37:05'),
(63, 4.0, 2, 10, 'Fertilization IV', 8, '2026-01-25 11:37:05'),
(64, 4.0, 3, 11, 'Harvesting', 53, '2026-01-25 11:37:05');

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
-- Indexes for table `agri_officer_list`
--
ALTER TABLE `agri_officer_list`
  ADD PRIMARY KEY (`officer_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `deleted_plr`
--
ALTER TABLE `deleted_plr`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `farmer_timeline`
--
ALTER TABLE `farmer_timeline`
  ADD PRIMARY KEY (`farmer_nic`,`plr`),
  ADD KEY `fk_timeline_paddy` (`plr`);

--
-- Indexes for table `farmer_timeline_progress`
--
ALTER TABLE `farmer_timeline_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `farmer_nic` (`farmer_nic`,`plr`,`step_order`),
  ADD KEY `fk_progress_paddy` (`plr`);

--
-- Indexes for table `fertilizer_recommendations`
--
ALTER TABLE `fertilizer_recommendations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crop_type_months` (`crop_type_months`,`crop_stage`);

--
-- Indexes for table `help_center_members`
--
ALTER TABLE `help_center_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`user_type`),
  ADD UNIQUE KEY `user_id_2` (`user_id`);

--
-- Indexes for table `knowledge_articles`
--
ALTER TABLE `knowledge_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_article_category` (`category_id`);

--
-- Indexes for table `knowledge_categories`
--
ALTER TABLE `knowledge_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_creator` (`created_by`);

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
-- Indexes for table `paddy_requests`
--
ALTER TABLE `paddy_requests`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `timeline_steps`
--
ALTER TABLE `timeline_steps`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agrarian_service_centers`
--
ALTER TABLE `agrarian_service_centers`
  MODIFY `center_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `deleted_plr`
--
ALTER TABLE `deleted_plr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `farmer_timeline_progress`
--
ALTER TABLE `farmer_timeline_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `fertilizer_recommendations`
--
ALTER TABLE `fertilizer_recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `help_center_members`
--
ALTER TABLE `help_center_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `knowledge_articles`
--
ALTER TABLE `knowledge_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `knowledge_categories`
--
ALTER TABLE `knowledge_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `paddy_requests`
--
ALTER TABLE `paddy_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `timeline_steps`
--
ALTER TABLE `timeline_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `farmer_timeline`
--
ALTER TABLE `farmer_timeline`
  ADD CONSTRAINT `fk_timeline_paddy` FOREIGN KEY (`plr`) REFERENCES `paddy` (`PLR`) ON DELETE CASCADE;

--
-- Constraints for table `farmer_timeline_progress`
--
ALTER TABLE `farmer_timeline_progress`
  ADD CONSTRAINT `fk_progress_paddy` FOREIGN KEY (`plr`) REFERENCES `paddy` (`PLR`) ON DELETE CASCADE;

--
-- Constraints for table `knowledge_articles`
--
ALTER TABLE `knowledge_articles`
  ADD CONSTRAINT `fk_article_category` FOREIGN KEY (`category_id`) REFERENCES `knowledge_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `knowledge_categories`
--
ALTER TABLE `knowledge_categories`
  ADD CONSTRAINT `fk_category_creator` FOREIGN KEY (`created_by`) REFERENCES `officers` (`officer_id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
