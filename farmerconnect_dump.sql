-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: farmerconnect
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `admin_id` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES ('A0001','','$2y$10$WQAhbPWhBQAlFmcgA6MkCe/xekCTLBLknf6YStKXuaA83Tc0Yel6m',NULL,'2025-10-23 04:14:33');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agrarian_service_centers`
--

DROP TABLE IF EXISTS `agrarian_service_centers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agrarian_service_centers` (
  `center_id` int(11) NOT NULL AUTO_INCREMENT,
  `district_id` int(11) NOT NULL,
  `center_name` varchar(150) NOT NULL,
  PRIMARY KEY (`center_id`),
  KEY `district_id` (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agrarian_service_centers`
--

LOCK TABLES `agrarian_service_centers` WRITE;
/*!40000 ALTER TABLE `agrarian_service_centers` DISABLE KEYS */;
INSERT INTO `agrarian_service_centers` VALUES (1,1,'Meerigama'),(2,1,'Pallewela'),(3,1,'Pasyala'),(4,1,'Badalgama'),(5,1,'Walpita'),(6,1,'Udugampola'),(7,1,'Mabodala'),(8,1,'Minuwangoda'),(9,1,'Andiambalama'),(10,1,'Katana'),(11,1,'Ja-Ela'),(12,1,'Henarathgoda'),(13,1,'Galahitiyawa'),(14,1,'Nittambuwa'),(15,1,'Urapola'),(16,1,'Weke'),(17,1,'Dompe'),(18,1,'Biyagama'),(19,1,'Kelaniya'),(20,1,'Pamunugama'),(21,1,'Malwatuhiripitiya'),(22,1,'Suriyapaluwa'),(23,1,'Udupila'),(24,1,'Yakkala'),(25,1,'Marandagahamula'),(26,1,'Bemmulla'),(27,2,'Kosgama'),(28,2,'Padukka'),(29,2,'Homagama'),(30,2,'Kesbewa'),(31,2,'Kahatuduwa'),(32,2,'Kotte'),(33,2,'Malabe'),(34,2,'Kolonnawa'),(35,3,'Warakagoda'),(36,3,'Bulathsinghala'),(37,3,'Madurawala'),(38,3,'Agalawatta'),(39,3,'Baduraliya'),(40,3,'Ittepana'),(41,3,'Matugama'),(42,3,'Dodangoda'),(43,3,'Walagedara'),(44,3,'Halkadawila'),(45,3,'Padagoda'),(46,3,'Bandaragama'),(47,3,'Millaniya'),(48,3,'Pamunugama'),(49,3,'Ingiriya'),(50,3,'Kananwila'),(51,3,'Morontuduwa'),(52,3,'Nagoda'),(53,3,'Panadura'),(54,3,'Pelawatta');
/*!40000 ALTER TABLE `agrarian_service_centers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (2,NULL,NULL,'ax','fertilizer','ax','',0,1,'2025-10-19 03:58:06','2025-10-20 02:29:59'),(3,NULL,'A1','System Maintenance Notice','other','The system will be undergoing scheduled maintenance on October 25th, from 10:00 PM to 12:00 AM. Please make sure to save your work before this time. We apologize for any inconvenience.','',0,0,'2025-10-20 02:17:27','2025-10-20 11:58:29'),(4,'O0001',NULL,'Paddy Leaf Blight Detected in Several Areas','warning','A paddy leaf blight outbreak has been reported in the Kurunegala and Anuradhapura districts. Farmers are advised to inspect their fields daily and use recommended fungicides. Please contact your local Agriculture Officer for guidance on treatment methods.','',1,0,'2025-10-20 02:30:38','2025-10-23 06:53:05'),(5,'O2',NULL,'Upcoming Training on Modern Irrigation Techniques','training','A practical workshop on “Efficient Water Management and Drip Irrigation” will be held on October 28th at 9:00 AM at the District Agrarian Center, Polonnaruwa. Participation is free for registered farmers. Seats are limited — register by October 25th.','',0,0,'2025-10-20 02:31:05','2025-10-20 02:33:34'),(6,'O2',NULL,'Fertilizer Distribution Schedule for Maha Season 2025','fertilizer','Distribution of subsidized fertilizer for the Maha 2025 cultivation season will begin on November 2nd. Farmers can collect fertilizer from their respective Agrarian Service Centers between 8:00 AM and 4:00 PM. Please bring your Farmer ID card and land registration documents.','',1,0,'2025-10-20 02:33:15','2025-10-23 07:51:16'),(7,'O2',NULL,'Update: New Land Usage Policy Effective from November 2025','policy','The Ministry of Agriculture has updated the Land Usage Policy to encourage crop diversification. Farmers cultivating paddy continuously for over three years are encouraged to plant pulses or maize during the next season. More details are available at your local Agrarian Office.','',1,0,'2025-10-20 02:34:20','2025-10-23 06:17:57'),(8,'O2',NULL,'sa','fertilizer','dsasa','',0,1,'2025-10-20 02:43:30','2025-10-20 02:43:54'),(9,'O2',NULL,'csdvc','training','accsca','uploads/1760951668_register_img_desktop-01.jpeg',0,1,'2025-10-20 03:44:28','2025-10-20 03:46:45'),(10,'O2',NULL,'Images (jpg/png/gif) show as a small preview inside the card.  PDFs show as a preview using .  Other file types display their name as before.  Clicking the card still opens the file in a new tab.  Card has max width/height and scales nicely on mobile.','fertilizer','jcn','',0,1,'2025-10-20 04:08:43','2025-10-20 04:09:14'),(11,'O2',NULL,'Images (jpg/png/gif) show as a small preview inside the card.  PDFs show as a preview using .  Other file types display their name as before.  Clicking the card still opens the file in a new tab.  Card has max width/height and scales nicely on mobile.','fertilizer','jcn','',0,1,'2025-10-20 04:11:35','2025-10-20 04:11:52'),(12,NULL,NULL,'cs','training','adC','',0,1,'2025-10-20 08:17:02','2025-10-20 08:17:26'),(13,NULL,NULL,'dasc','policy','sca','',0,1,'2025-10-20 08:17:50','2025-10-20 08:28:32'),(14,NULL,NULL,'sdvv','fertilizer','asxac','',0,1,'2025-10-20 08:19:03','2025-10-20 08:28:22'),(15,'O2',NULL,'fasd','warning','sacv','',0,1,'2025-10-20 08:31:02','2025-10-20 08:31:11'),(16,'O2',NULL,'aC','warning','cvds','',0,1,'2025-10-20 08:31:51','2025-10-20 08:32:02'),(17,'O2',NULL,'wdaf','fertilizer','qwda','',0,1,'2025-10-20 10:55:05','2025-10-20 10:55:17'),(0,'O0001',NULL,'warning','warning','pest outbreak in south','',0,1,'2025-10-22 11:05:24','2025-10-23 07:51:07'),(0,'O0001',NULL,'warning','warning','pest outbreak in south','',0,1,'2025-10-22 11:48:28','2025-10-23 07:51:07'),(0,'O0001',NULL,'warning','warning','pest outbreak in south','',0,1,'2025-10-22 11:48:37','2025-10-23 07:51:07'),(0,'O0001',NULL,'warning','warning','pest outbreak in south','',0,1,'2025-10-22 11:48:40','2025-10-23 07:51:07'),(0,'O0001',NULL,'warning','warning','pest outbreak in south','',0,1,'2025-10-22 12:35:48','2025-10-23 07:51:07'),(0,'O0001',NULL,'warning','warning','pest outbreak in south','',0,1,'2025-10-23 05:46:26','2025-10-23 07:51:07'),(0,'O0001',NULL,'warning','warning','pest outbreak in south','',0,1,'2025-10-23 05:51:03','2025-10-23 07:51:07'),(0,'O0001',NULL,'warning','warning','pest outbreak in south','',0,1,'2025-10-23 05:51:47','2025-10-23 07:51:07'),(0,'O0001',NULL,'warning','warning','pest outbreak in south','',0,1,'2025-10-23 05:52:38','2025-10-23 07:51:07'),(0,'O0001',NULL,'warning','warning','pest outbreak in south','',0,1,'2025-10-23 06:17:31','2025-10-23 07:51:07'),(0,'O0001',NULL,'warning','warning','pest outbreak in south','',0,1,'2025-10-23 06:46:10','2025-10-23 07:51:07'),(0,'O0001',NULL,'warning','warning','pest outbreak in south','',0,1,'2025-10-23 07:50:51','2025-10-23 07:51:11');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disease_officer_responses`
--

DROP TABLE IF EXISTS `disease_officer_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disease_officer_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_code` varchar(20) NOT NULL,
  `officer_id` varchar(50) NOT NULL,
  `response_message` text NOT NULL,
  `response_media` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_edited` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `report_code` (`report_code`),
  KEY `officer_id` (`officer_id`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `fk_dor_report_code` FOREIGN KEY (`report_code`) REFERENCES `disease_reports` (`report_code`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disease_officer_responses`
--

LOCK TABLES `disease_officer_responses` WRITE;
/*!40000 ALTER TABLE `disease_officer_responses` DISABLE KEYS */;
/*!40000 ALTER TABLE `disease_officer_responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disease_reports`
--

DROP TABLE IF EXISTS `disease_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`report_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disease_reports`
--

LOCK TABLES `disease_reports` WRITE;
/*!40000 ALTER TABLE `disease_reports` DISABLE KEYS */;
INSERT INTO `disease_reports` VALUES ('DR001','200206102814','PLR123','2025-10-19','Test CRUD','this is a test crud insertion for interim ssadsajd akjsdblsakdbkasld baskljdjasdbjas','DR001_WhatsApp_Video_2025-08-20_at_1_1760903562.mp4','medium',54.40,'pending','2025-10-19 19:52:42','2025-10-20 14:01:34',0,NULL,0),('DR002','200206102814','PLR123','2025-10-21','adsdas dasdasd asdas dsds','as dasdasdasd asdasmndbask djasbdkasdb akjsdb askdjasbndjkasd baksjmdbnaksjd bajs','DR002_help_1761077069.png','high',23.00,'pending','2025-10-21 20:04:29','2025-10-21 20:04:29',0,NULL,0),('DR003','222222222v','PLR123','2025-10-22','Asjdisj aisjdias djiasjdisa','jsahdushdausdh asodjasiodasjdoas doasidjoas','DR003_WhatsApp_Video_2025-08-20_at_1_1761110123.mp4','high',23.00,'pending','2025-10-22 05:15:23','2025-10-22 05:15:23',0,NULL,0),('DR004','111111111v','PLR123','2025-10-22','sdjasidj aidjasiodjasd oasidjasodijsado adjaiosdjaosid j','sjdhas dshaodha doiasjdioadj asiodjasoida sdsadhaisodjhsaoidjao','DR004_WhatsApp_Video_2025-08-20_at_1_1761110627.mp4','high',21.10,'pending','2025-10-22 05:23:47','2025-10-22 05:23:47',0,NULL,0),('DR008','200105402095','02/25/00083/001/P/0066','2025-10-22','hbjk jllal;al','a set of words that is complete in itself, typically containing a subject and predicate, conveying a statement, question, exclamation, or command, and consisting of a main clause and sometimes one or more subordinate clauses.','','low',100.00,'pending','2025-10-22 15:09:18','2025-12-25 18:24:39',0,NULL,0),('DR009','200105402095','02/25/00083/001/P/0067','2025-10-22','hhhhhhh','zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz','DR009_nadu_1761147714.jpeg','medium',123.00,'pending','2025-10-22 15:41:54','2025-12-25 18:24:43',0,NULL,0),('DR011','200105402095','02/25/00083/001/P/0066','2025-10-23','ttttttttt','tttttttttttttttttttttttttttttttttttt','DR011_WhatsApp_Image_2025-10-23_at_0_1761192713.jpg','high',1.00,'pending','2025-10-23 04:11:53','2025-12-25 18:24:46',0,NULL,0),('DR012','200105402095','02/25/00083/001/P/0067','2025-10-23','hshds dsds','sjdnsjd nsjd  sdnsjdn sjdnsajdnsajdnada','DR012_Screenshot_2025-12-26_at_12_21_1766689242_0.png','high',2.00,'pending','2025-10-23 06:43:40','2025-12-25 19:03:01',0,NULL,0);
/*!40000 ALTER TABLE `disease_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `districts` (
  `district_id` int(11) NOT NULL,
  `district_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `districts`
--

LOCK TABLES `districts` WRITE;
/*!40000 ALTER TABLE `districts` DISABLE KEYS */;
INSERT INTO `districts` VALUES (2,'Colombo'),(1,'Gampaha'),(3,'Kalutara');
/*!40000 ALTER TABLE `districts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `farmer_timeline`
--

DROP TABLE IF EXISTS `farmer_timeline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `farmer_timeline` (
  `farmer_nic` varchar(20) NOT NULL,
  `plr` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  PRIMARY KEY (`farmer_nic`,`plr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `farmer_timeline`
--

LOCK TABLES `farmer_timeline` WRITE;
/*!40000 ALTER TABLE `farmer_timeline` DISABLE KEYS */;
/*!40000 ALTER TABLE `farmer_timeline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `farmer_timeline_progress`
--

DROP TABLE IF EXISTS `farmer_timeline_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `farmer_timeline_progress` (
  `farmer_nic` varchar(20) NOT NULL,
  `plr` varchar(50) NOT NULL,
  `step_order` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`farmer_nic`,`plr`,`step_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `farmer_timeline_progress`
--

LOCK TABLES `farmer_timeline_progress` WRITE;
/*!40000 ALTER TABLE `farmer_timeline_progress` DISABLE KEYS */;
INSERT INTO `farmer_timeline_progress` VALUES ('200105402095','02/25/00083/001/P/0066',1,'problem','2026-04-04');
/*!40000 ALTER TABLE `farmer_timeline_progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `farmers`
--

DROP TABLE IF EXISTS `farmers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  PRIMARY KEY (`nic`),
  KEY `registration_id` (`registration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `farmers`
--

LOCK TABLES `farmers` WRITE;
/*!40000 ALTER TABLE `farmers` DISABLE KEYS */;
INSERT INTO `farmers` VALUES ('','',0,'0765565113','$2y$10$ywSHPMniBatvb0jhyOZbWOWJSvv4oGbxsNzcHTaHM3VOqB37XquYm','male','2025-10-13','55,Gampaha,Udugampola',NULL),('200005402095','amal perera',31,'0778316446','$2y$10$qMqMGUCaqfjrelhqBUbQgOtx6dwe47KcIZJFt07dSn/jK67QNecfO',NULL,NULL,NULL,NULL),('200011223344','K.R.Aberathna',0,'0765565145','$2y$10$M3SQbP50HK91rs1mnCEbcugBUU1L1CBvJ18GDHa0itbtiwAwx6qyO','male','2025-10-13','55,Gampaha,Udugampola',NULL),('200105402095','Sanjana Rajapaksha',32,'0774920578','$2y$10$WQAhbPWhBQAlFmcgA6MkCe/xekCTLBLknf6YStKXuaA83Tc0Yel6m','male','2025-10-20','55,Gampha udugampola',NULL),('200254201944','Janeesha Widanage',28,'0778316232','$2y$10$OCjw5zuNJs0GI.yNHjtjLuMI7lQkoLtEALF8.JsQf4odr.qoQ2WNm',NULL,NULL,NULL,NULL),('200254201945','Kamal Widanage',26,'0778316231','$2y$10$BaeoAQfMaXy00B.JeY5qxOexOJPwPLaVU4DYdafZTD0hxdEgwWbuG',NULL,NULL,NULL,NULL),('200305402095','Menuja Alwis',8,'0774920666','$2y$10$SMPjgBmAl/HGVloMH7Cuf.1F9D/L2FDXj4g8yO0.UBIFEUhI6Qfcq','male','2025-10-07','556,Nittabuwa',NULL),('222222222v','Jack Sparrow',6,'0222222222','$2y$10$4G27psZv4YQCs8dKZolwO..ncdHC15H1FW7TrI0zS1h/lZoSba0DK',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `farmers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `officers`
--

DROP TABLE IF EXISTS `officers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `officers` (
  `officer_id` varchar(15) NOT NULL,
  `nic` varchar(15) DEFAULT NULL,
  `registration_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  PRIMARY KEY (`officer_id`),
  KEY `registration_id` (`registration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officers`
--

LOCK TABLES `officers` WRITE;
/*!40000 ALTER TABLE `officers` DISABLE KEYS */;
INSERT INTO `officers` VALUES ('O0001','200206102815',30,'Andrew','Aiden','','officer1@fc.lk','$2y$10$WQAhbPWhBQAlFmcgA6MkCe/xekCTLBLknf6YStKXuaA83Tc0Yel6m',NULL,NULL),('O0002',NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL),('O0003',NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL),('O2','333333333v',5,'Saman','Perera','','abc@gamil.com','$2y$10$Bxmh4FTfDnvNRqCNWJWufeQ0I8zUXbcHAjWRey4ocLVmosqNs3lgu',NULL,NULL);
/*!40000 ALTER TABLE `officers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paddy`
--

DROP TABLE IF EXISTS `paddy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `CreatedDate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`PLR`),
  KEY `fk_farmer` (`NIC_FK`),
  KEY `fk_officer` (`OfficerID`),
  CONSTRAINT `fk_farmer` FOREIGN KEY (`NIC_FK`) REFERENCES `farmers` (`nic`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_officer` FOREIGN KEY (`OfficerID`) REFERENCES `officers` (`officer_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paddy`
--

LOCK TABLES `paddy` WRITE;
/*!40000 ALTER TABLE `paddy` DISABLE KEYS */;
INSERT INTO `paddy` VALUES ('02/25/00083/001/P/0056','200305402095','O2','B-352',34.00,'Western','Gampaha','Kelaniya','divlapitiya','yaya4','2025-10-22 01:26:53'),('02/25/00083/001/P/0057','200305402095','O2','BG-300',34.00,'Western','Colombo','Kotte','divlapitiya','yaya4','2025-10-22 01:27:23'),('02/25/00083/001/P/0066','200105402095','O2','B-352',34.00,'Western','Gampaha','Galahitiyawa','divlapitiya','Yaya 7','2025-10-23 06:41:22'),('02/25/00083/001/P/0067','200105402095','O2','BW-367',10.00,'Western','Gampaha','Galahitiyawa','divlapitiya','Yaya 5','2025-10-23 05:34:13');
/*!40000 ALTER TABLE `paddy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL,
  `seller_id` int(10) unsigned DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `region` varchar(50) NOT NULL,
  `unit_type` varchar(20) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `available_quantity` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (5,'451363',11,'Fertilizer','','Kandy','kg',10.00,10,'images-removebg-preview.png','Outstock',NULL),(6,'123#',11,'Agrochemicals','','Polonnaruwa','litre',10.00,10,'Manage_Products.jpg','Instock','North Central'),(7,'1415353',11,'Agrochemicals','','Matale','packet',10.00,10,'ChatGPT Image Aug 22, 2025, 09_22_43 PM.png','Instock',NULL),(9,'fertilizer',11,'Equipments','','Ampara','litre',10.00,10,'Manage_Products.jpg','Instock','Eastern'),(10,'Janeeshaaaaaaaaaaaaaahhh',11,'Rental','','Ampara','day',10.00,100,'500-5006416_collection-of-high-wifi-router-png-transparent-png.png','Instock','Eastern'),(11,'fertilizer',11,'Agrochemicals','','Polonnaruwa','kg',10.50,10,'1760940476_360_F_110789919_dRblunjKXDyZ5cKaV3CG5mweTt0gmVdG.jpg','Outstock','North Central');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registrations` (
  `registration_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` enum('farmer','seller','officer') NOT NULL,
  `approved_status` enum('approved','rejected','pending') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending',
  PRIMARY KEY (`registration_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registrations`
--

LOCK TABLES `registrations` WRITE;
/*!40000 ALTER TABLE `registrations` DISABLE KEYS */;
INSERT INTO `registrations` VALUES (13,'seller',NULL,'2025-10-18 12:42:59','$2y$10$vndl7TWQM39ozECBJnA0uOIbN1lkow0dXEA.oLjGxgUHEhcrmVtEq','pending'),(14,'seller',NULL,'2025-10-18 20:23:36','$2y$10$006WV92HpAzUDpkxH6sTBe77KC/l7FR5JLE80aGNGGuNwyvYQYJ3m','pending'),(15,'seller',NULL,'2025-10-20 04:30:23','$2y$10$6QLg5aZcnnAbDX6AFyZBNuEGWkjNl/XwEAQRrFX45Cm1dkk8PADfS','pending'),(16,'seller',NULL,'2025-10-21 04:50:38','$2y$10$mHpILvIuKn6e/AE7M3qytuVx76uQaQyqEFjmBtCB0vkWPT9ORuNmC','pending'),(17,'seller',NULL,'2025-10-21 04:58:19','$2y$10$BKK7coco/dU/wHLvBdzyW.PXS7xeaiM51MBFMdbZTTYHIlWJdQ4ui','pending'),(19,'farmer',NULL,'2025-10-22 06:02:37','$2y$10$V3aOmWMv0.hy.3kui80Hj.ntgjNtAj1VzhDy2H3VN1O9v5zJGd0ky','pending'),(20,'farmer',NULL,'2025-10-22 06:03:44','$2y$10$st7a1EeXjjsYOurKR.llue7m31mwxgHAeHnUkPz3qkDwOq6gK1mf2','pending'),(21,'farmer',NULL,'2025-10-22 06:07:58','$2y$10$Z4ZLwt4ejU0H.VXJSSxEWOzwFEGRy7ZCKtz7Mv.kG8S3V.dEkgHoq','pending'),(22,'farmer',NULL,'2025-10-22 06:09:27','$2y$10$y/kYKol8Oxg.48qRGODioerk1LbC1c.dAJKZhnUf5gOCGTls3ETLu','pending'),(25,'seller',NULL,'2025-10-22 18:27:23','$2y$10$Jur4MxJym71KTz8jdR8CB.RkfY.t.Jn3TiZJdNq2LVhxc9wZFr4eu','pending'),(26,'farmer',NULL,'2025-10-22 19:17:24','$2y$10$BaeoAQfMaXy00B.JeY5qxOexOJPwPLaVU4DYdafZTD0hxdEgwWbuG','pending'),(27,'seller',NULL,'2025-10-23 04:25:10','$2y$10$a/xj5FHjW6LQCwqPMgZdeu7izQqHE5px21251i7hxrbEOUPpl0J/2','pending'),(28,'farmer',NULL,'2025-10-23 04:40:33','$2y$10$OCjw5zuNJs0GI.yNHjtjLuMI7lQkoLtEALF8.JsQf4odr.qoQ2WNm','pending'),(29,'seller',NULL,'2025-10-23 04:41:46','$2y$10$CmQzCwuiZgbyuty4URrvu.AdHH5QAFDGhAmmmSqB4285bZUzbZXsW','pending'),(30,'officer',NULL,'2025-10-23 05:05:36','$2y$10$N.dXBHTXv159uRW/0AToXOfB.lV4jOg6sYIW.F6R.Pauypyh8tVim','pending'),(31,'farmer',NULL,'2025-10-23 05:27:02','$2y$10$qMqMGUCaqfjrelhqBUbQgOtx6dwe47KcIZJFt07dSn/jK67QNecfO','pending'),(32,'farmer',NULL,'2025-10-23 05:30:03','$2y$10$Ct8kwN.SffbHF6rwk2ccueTjRljwvbz.YuGvpZNNospfoK569KJ6C','pending'),(33,'seller',NULL,'2025-10-23 05:56:43','$2y$10$Vz8jQRTI2gc2pSTBC9WKN.49mjwPfoJpmihestBycruiPQyelXTQ2','pending'),(34,'seller',NULL,'2025-10-23 06:18:57','$2y$10$ZuMadV.ZfOeeGe6g487Lk.dPLpRTgFCr4KpQQuYMBKV980.c1wZXm','pending'),(35,'seller',NULL,'2025-10-23 06:47:22','$2y$10$FCQIPEI.dV4vx1NiHvJOUODiIFMhEHQvlB/zDiHu70VuNSZ2A3B0S','pending'),(36,'seller',NULL,'2025-10-23 07:52:30','$2y$10$JBaFOhXeEEubuPGhMG3VheZzV2HF1uqe.RoRbwY5A7SkN0.T7N5Qi','pending');
/*!40000 ALTER TABLE `registrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sellers`
--

DROP TABLE IF EXISTS `sellers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sellers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `gender` enum('male','female') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `seller_id` (`seller_id`),
  KEY `registration_id` (`registration_id`),
  CONSTRAINT `sellers_ibfk_1` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`registration_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sellers`
--

LOCK TABLES `sellers` WRITE;
/*!40000 ALTER TABLE `sellers` DISABLE KEYS */;
INSERT INTO `sellers` VALUES (9,'SE0009','200254201944',25,'Nimal','Perera','Comany.lk','1233','0778316232','janeeshamendis202@gmail.com','209/5, Sri Mawatha , Miriswaththa','$2y$10$Jur4MxJym71KTz8jdR8CB.RkfY.t.Jn3TiZJdNq2LVhxc9wZFr4eu','Approved',NULL,NULL,NULL,'2025-10-22 23:57:23','2025-10-22 23:58:19'),(11,'SE0011','200254201940',29,'Janeesha','Mendis','1233','1278','0778316456','janeeshahasadara@gmail.com','209/5, Sri Mawatha , Miriswaththa','$2y$10$CmQzCwuiZgbyuty4URrvu.AdHH5QAFDGhAmmmSqB4285bZUzbZXsW','Approved',NULL,NULL,NULL,'2025-10-23 10:11:46','2025-10-23 10:11:57'),(15,'SE0015','200254201947',36,'Pumudu','Anuradha','abc d','abc d','0778316245','pumudu820@gmail.com','dsasv','$2y$10$JBaFOhXeEEubuPGhMG3VheZzV2HF1uqe.RoRbwY5A7SkN0.T7N5Qi','Approved',NULL,NULL,NULL,'2025-10-23 13:22:30','2025-10-23 13:22:48');
/*!40000 ALTER TABLE `sellers` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `before_insert_sellers` BEFORE INSERT ON `sellers` FOR EACH ROW BEGIN
    DECLARE next_id INT;

    -- Get the next auto-increment value from the sellers table
    SELECT AUTO_INCREMENT INTO next_id
    FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'sellers';

    -- Set the seller_id with prefix 'SE' and padded number
    SET NEW.seller_id = CONCAT('SE', LPAD(next_id, 4, '0'));
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `timeline_steps`
--

DROP TABLE IF EXISTS `timeline_steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timeline_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `duration_months` float NOT NULL,
  `step_order` int(11) NOT NULL,
  `gap_days` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timeline_steps`
--

LOCK TABLES `timeline_steps` WRITE;
/*!40000 ALTER TABLE `timeline_steps` DISABLE KEYS */;
INSERT INTO `timeline_steps` VALUES (1,3,1,0),(2,3,2,2),(3,3,3,5),(4,3,4,3),(5,3,5,4),(6,3,6,14),(7,3,7,10),(8,3,8,15),(9,3,9,20),(10,3,10,15),(11,3,11,7),(12,3.5,1,0),(13,3.5,2,3),(14,3.5,3,5),(15,3.5,4,4),(16,3.5,5,4),(17,3.5,6,15),(18,3.5,7,12),(19,3.5,8,15),(20,3.5,9,21),(21,3.5,10,16),(22,3.5,11,10),(23,4,1,0),(24,4,2,3),(25,4,3,6),(26,4,4,4),(27,4,5,5),(28,4,6,18),(29,4,7,14),(30,4,8,18),(31,4,9,24),(32,4,10,18),(33,4,11,10),(34,5,1,0),(35,5,2,4),(36,5,3,7),(37,5,4,5),(38,5,5,6),(39,5,6,21),(40,5,7,18),(41,5,8,22),(42,5,9,30),(43,5,10,25),(44,5,11,12);
/*!40000 ALTER TABLE `timeline_steps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yellow_cases`
--

DROP TABLE IF EXISTS `yellow_cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yellow_cases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` varchar(30) NOT NULL,
  `farmer_nic` varchar(20) NOT NULL,
  `plr_number` varchar(60) NOT NULL,
  `observation_date` date NOT NULL,
  `submitted_date` date NOT NULL,
  `case_title` varchar(255) NOT NULL,
  `case_description` text NOT NULL,
  `media` text DEFAULT NULL,
  `status` enum('pending','under_review','resolved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_case_id` (`case_id`),
  KEY `idx_yc_farmer_nic` (`farmer_nic`),
  KEY `idx_yc_observation_date` (`observation_date`),
  KEY `idx_yc_status` (`status`),
  KEY `idx_yc_submitted_date` (`submitted_date`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yellow_cases`
--

LOCK TABLES `yellow_cases` WRITE;
/*!40000 ALTER TABLE `yellow_cases` DISABLE KEYS */;
INSERT INTO `yellow_cases` VALUES (1,'YC-20260404155312-9276','200105402095','02/25/00083/001/P/0066','2026-04-01','2026-04-04','Hello there testing','asdlksam dklsamd laksdmask ldmasldkmsa dlksamdlksa mdlkasdmas','[]','pending','2026-04-04 13:53:12',NULL,0),(2,'YC-20260404165903-226E','200105402095','02/25/00083/001/P/0066','2026-04-04','2026-04-04','Hello there testing','j klm o ooi jiokjnjkkjbkjbjkkjnjknk jn kjnkjn kjknkjnknknkn','[\"1775314743_mmm-japapaaa.gif\"]','pending','2026-04-04 14:59:03',NULL,0),(3,'YC-20260404185332-C758','200105402095','02/25/00083/001/P/0066','2026-04-23','2026-04-04','Hello there testing','i jnjkn kjnk kjn','[\"1775321612_mmm-japapaaa.gif\"]','pending','2026-04-04 16:53:32',NULL,0);
/*!40000 ALTER TABLE `yellow_cases` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-04 23:01:40
