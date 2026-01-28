-- Disease Reports Table Creation Script
-- Run this in your MySQL database to create the table for disease reports
-- Updated to match App Model M_disease.php

CREATE TABLE IF NOT EXISTS `disease_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_code` varchar(255) NOT NULL,
  `farmerNIC` varchar(20) NOT NULL,
  `plrNumber` varchar(50) NOT NULL,
  `observationDate` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `media` text,
  `severity` enum('low','medium','high') NOT NULL,
  `affectedArea` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_code` (`report_code`),
  KEY `farmerNIC` (`farmerNIC`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
