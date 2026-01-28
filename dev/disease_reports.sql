-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 25, 2025 at 08:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `disease_reports`
--

INSERT INTO `disease_reports` (`report_code`, `farmerNIC`, `plrNumber`, `observationDate`, `title`, `description`, `media`, `severity`, `affectedArea`, `status`, `created_at`, `updated_at`, `is_deleted`) VALUES
('DR001', '200206102814', 'PLR123', '2025-10-19', 'Test CRUD', 'this is a test crud insertion for interim ssadsajd akjsdblsakdbkasld baskljdjasdbjas', 'DR001_WhatsApp_Video_2025-08-20_at_1_1760903562.mp4', 'medium', 54.40, 'pending', '2025-10-19 19:52:42', '2025-10-20 14:01:34', 0),
('DR002', '200206102814', 'PLR123', '2025-10-21', 'adsdas dasdasd asdas dsds', 'as dasdasdasd asdasmndbask djasbdkasdb akjsdb askdjasbndjkasd baksjmdbnaksjd bajs', 'DR002_help_1761077069.png', 'high', 23.00, 'pending', '2025-10-21 20:04:29', '2025-10-21 20:04:29', 0),
('DR003', '222222222v', 'PLR123', '2025-10-22', 'Asjdisj aisjdias djiasjdisa', 'jsahdushdausdh asodjasiodasjdoas doasidjoas', 'DR003_WhatsApp_Video_2025-08-20_at_1_1761110123.mp4', 'high', 23.00, 'pending', '2025-10-22 05:15:23', '2025-10-22 05:15:23', 0),
('DR004', '111111111v', 'PLR123', '2025-10-22', 'sdjasidj aidjasiodjasd oasidjasodijsado adjaiosdjaosid j', 'sjdhas dshaodha doiasjdioadj asiodjasoida sdsadhaisodjhsaoidjao', 'DR004_WhatsApp_Video_2025-08-20_at_1_1761110627.mp4', 'high', 21.10, 'pending', '2025-10-22 05:23:47', '2025-10-22 05:23:47', 0),
('DR008', '200105402095', '02/25/00083/001/P/0066', '2025-10-22', 'hbjk jllal;al', 'a set of words that is complete in itself, typically containing a subject and predicate, conveying a statement, question, exclamation, or command, and consisting of a main clause and sometimes one or more subordinate clauses.', '', 'low', 100.00, 'pending', '2025-10-22 15:09:18', '2025-12-25 18:24:39', 0),
('DR009', '200105402095', '02/25/00083/001/P/0067', '2025-10-22', 'hhhhhhh', 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz', 'DR009_nadu_1761147714.jpeg', 'medium', 123.00, 'pending', '2025-10-22 15:41:54', '2025-12-25 18:24:43', 0),
('DR011', '200105402095', '02/25/00083/001/P/0066', '2025-10-23', 'ttttttttt', 'tttttttttttttttttttttttttttttttttttt', 'DR011_WhatsApp_Image_2025-10-23_at_0_1761192713.jpg', 'high', 1.00, 'pending', '2025-10-23 04:11:53', '2025-12-25 18:24:46', 0),
('DR012', '200105402095', '02/25/00083/001/P/0067', '2025-10-23', 'hshds dsds', 'sjdnsjd nsjd  sdnsjdn sjdnsajdnsajdnada', 'DR012_Screenshot_2025-12-26_at_12_21_1766689242_0.png', 'high', 2.00, 'pending', '2025-10-23 06:43:40', '2025-12-25 19:03:01', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disease_reports`
--
ALTER TABLE `disease_reports`
  ADD PRIMARY KEY (`report_code`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
