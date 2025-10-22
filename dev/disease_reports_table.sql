-- Disease Reports Table Creation Script
-- Run this in your MySQL database to create the table for disease reports

CREATE TABLE IF NOT EXISTS `disease_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` varchar(255) NOT NULL UNIQUE,
  `farmer_nic` varchar(20) NOT NULL,
  `plr_number` varchar(50) NOT NULL,
  `observation_date` date NOT NULL,
  `submission_timestamp` datetime DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `severity` enum('low','medium','high') NOT NULL,
  `affected_area` decimal(10,2) NOT NULL,
  `media_files` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `farmer_nic` (`farmer_nic`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
