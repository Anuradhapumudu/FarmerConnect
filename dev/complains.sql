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
('CP001', '200105402095', '02/25/00083/001/P/0066', '2026-04-04', 'Testing 1234', 'skdsa mdkamsd samdas;dsamd; lsamdaksldm salkdm aslkdmasl', 'NEW_HEubw45WQAA3VRl_1775328884_0.jpeg', 'high', 22.80, 'Pending', NULL, 0, 0, '2026-04-04 18:54:44', '2026-04-04 18:54:44'),
('CP002', '200105402095', '02/25/00083/001/P/0066', '2026-04-01', 'test2', 'kjh jkj njkn knjhgvhjgvjghfhgvjvhjbj', 'CP002_AQPPzc5ahrejCRzEI-YXO2yCt3j9QL_1775329459_0.mp4,CP002_CP002_AQPPzc5ahrejCRzEI-YXO2yC_1775481190_0.mp4', 'high', 5.80, 'pending', 'O0001', 1, 0, '2026-04-04 19:04:19', '2026-04-06 13:13:10'),
('CP003', '200105402095', '02/25/00083/001/P/0067', '2026-04-05', 'I got water supply issue on paddy', 'Each group is allocated a maximum of 30 minutes for the presentation and the demonstration. A Q&A session and a code check will follow the presentation and demonstration. \r\n\r\nYou should do a 5 to 10-minute presentation and a maximum of 20 to 25-minute demonstration. (You can change the durations accordingly within the 30 minutes)', 'NEW_close-up-of-raindrops-on-leave_1775424532_0.jpg', 'high', 5.00, 'pending', 'O0001', 0, 0, '2026-04-05 21:28:52', '2026-04-05 22:54:07'),
('CP004', '200105402095', '02/25/00083/001/P/0066', '2026-04-05', 'This is a test complaint message', 'Each group is allocated a maximum of 30 minutes for the presentation and the demonstration. A Q&A session and a code check will follow the presentation and demonstration. \r\n\r\nYou should do a 5 to 10-minute presentation and a maximum of 20 to 25-minute demonstration. (You can change the durations accordingly within the 30 minutes)', 'NEW_Image_created_with_a_mobile_ph_1775427776_0.png', 'high', 18.00, 'under_review', 'O0001', 0, 0, '2026-04-05 22:22:56', '2026-04-05 22:52:41'),
('CP005', '200105402095', '02/25/00083/001/P/0067', '2026-04-06', 'Testing after update', 'You chose to start developing in Test Mode, which left your Cloud Firestore database completely open to the Internet. Because your app was vulnerable to attackers, your Firestore security rules were configured to stop allowing requests after the first 30 days.', 'CP005_Image_created_with_a_mobile_ph_1775482844_0.png,CP005_CP002_AQPPzc5ahrejCRzEI-YXO2yC_1775482856_0.mp4', 'high', 6.60, 'under_review', 'O0001', 1, 0, '2026-04-06 13:22:01', '2026-04-06 13:49:40');

-- --------------------------------------------------------
