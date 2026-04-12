CREATE TABLE IF NOT EXISTS `complaints` (
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
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`complaint_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `complaint_officer_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `complaint_id` varchar(20) NOT NULL,
  `officer_id` varchar(15) NOT NULL,
  `response_message` text NOT NULL,
  `response_media` text DEFAULT NULL,
  `is_edited` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
