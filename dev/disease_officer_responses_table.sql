-- Disease Officer Responses Table Creation Script
-- Run this in your MySQL database to create the table for officer responses to disease reports

CREATE TABLE IF NOT EXISTS `disease_officer_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_code` varchar(255) NOT NULL,
  `officer_id` varchar(50) NOT NULL,
  `response_message` text NOT NULL,
  `response_media` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `report_code` (`report_code`),
  KEY `officer_id` (`officer_id`),
  KEY `created_at` (`created_at`),
  FOREIGN KEY (`report_code`) REFERENCES `disease_reports`(`report_code`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;