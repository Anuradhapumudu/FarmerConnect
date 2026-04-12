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
('DR001', '200206102814', 'PLR123', '2025-10-19', 'Test CRUD', 'this is a test crud insertion for interim ssadsajd akjsdblsakdbkasld baskljdjasdbjas', 'DR001_WhatsApp_Video_2025-08-20_at_1_1760903562.mp4', 'medium', 54.40, 'pending', '2025-10-19 19:52:42', '2026-04-05 18:32:52', 0, NULL, 1),
('DR002', '200206102814', 'PLR123', '2025-10-21', 'adsdas dasdasd asdas dsds', 'as dasdasdasd asdasmndbask djasbdkasdb akjsdb askdjasbndjkasd baksjmdbnaksjd bajs', 'DR002_help_1761077069.png', 'high', 23.00, 'pending', '2025-10-21 20:04:29', '2026-04-05 19:23:09', 0, 'O0001', 0),
('DR003', '222222222v', 'PLR123', '2025-10-22', 'Asjdisj aisjdias djiasjdisa', 'jsahdushdausdh asodjasiodasjdoas doasidjoas', 'DR003_WhatsApp_Video_2025-08-20_at_1_1761110123.mp4', 'high', 23.00, 'pending', '2025-10-22 05:15:23', '2025-10-22 05:15:23', 0, NULL, 0),
('DR004', '111111111v', 'PLR123', '2025-10-22', 'sdjasidj aidjasiodjasd oasidjasodijsado adjaiosdjaosid j', 'sjdhas dshaodha doiasjdioadj asiodjasoida sdsadhaisodjhsaoidjao', 'DR004_WhatsApp_Video_2025-08-20_at_1_1761110627.mp4', 'high', 21.10, 'pending', '2025-10-22 05:23:47', '2025-10-22 05:23:47', 0, NULL, 0),
('DR008', '200105402095', '02/25/00083/001/P/0066', '2025-10-22', 'hbjk jllal;al', 'a set of words that is complete in itself, typically containing a subject and predicate, conveying a statement, question, exclamation, or command, and consisting of a main clause and sometimes one or more subordinate clauses.', '', 'low', 100.00, 'pending', '2025-10-22 15:09:18', '2025-12-25 18:24:39', 0, NULL, 0),
('DR009', '200105402095', '02/25/00083/001/P/0067', '2025-10-22', 'hhhhhhh', 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz', 'DR009_nadu_1761147714.jpeg', 'medium', 123.00, 'pending', '2025-10-22 15:41:54', '2025-12-25 18:24:43', 0, NULL, 0),
('DR011', '200105402095', '02/25/00083/001/P/0066', '2025-10-23', 'ttttttttt', 'tttttttttttttttttttttttttttttttttttt', 'DR011_WhatsApp_Image_2025-10-23_at_0_1761192713.jpg', 'high', 1.00, 'pending', '2025-10-23 04:11:53', '2025-12-25 18:24:46', 0, NULL, 0),
('DR012', '200105402095', '02/25/00083/001/P/0067', '2025-10-23', 'hshds dsds', 'sjdnsjd nsjd  sdnsjdn sjdnsajdnsajdnada', 'DR012_Screenshot_2025-12-26_at_12_21_1766689242_0.png', 'high', 2.00, 'resolved', '2025-10-23 06:43:40', '2026-04-05 19:11:37', 0, 'O0001', 0),
('DR013', '200105402095', '02/25/00083/001/P/0067', '2026-04-05', 'Testing 1234', 'Make sure you meet the supervisor and co-supervisor before you come to the presentation and viva. You can get their feedback in the final meetings and finalize your work. \r\n\r\nAlso, plan and design your presentation and the demonstration well to give the maximum value to all the effort you put into this project throughout the year.\r\n\r\nAlso, ensure your backups are ready when you come to the presentation in case anything goes wrong. (Have an extra device prepared to run the system.', 'DR013_close-up-of-raindrops-on-leave_1775414818_0.jpg', 'high', 6.00, 'under_review', '2026-04-05 15:39:43', '2026-04-05 18:47:57', 1, 'O0001', 0),
('DR014', '200105402095', '02/25/00083/001/P/0066', '2026-04-05', 'Testin 2345', 'Each group is allocated a maximum of 30 minutes for the presentation and the demonstration. A Q&A session and a code check will follow the presentation and demonstration. \r\n\r\nYou should do a 5 to 10-minute presentation and a maximum of 20 to 25-minute demonstration. (You can change the durations accordingly within the 30 minutes)', 'NEW_close-up-of-raindrops-on-leave_1775421683_0.jpg', 'high', 14.00, 'under_review', '2026-04-05 20:41:23', '2026-04-05 20:41:49', 0, 'O0001', 0),
('DR015', '200105402095', '02/25/00083/001/P/0067', '2026-04-05', 'Testing 3456', 'Each group is allocated a maximum of 30 minutes for the presentation and the demonstration. A Q&A session and a code check will follow the presentation and demonstration. \r\n\r\nYou should do a 5 to 10-minute presentation and a maximum of 20 to 25-minute demonstration. (You can change the durations accordingly within the 30 minutes)', 'NEW_close-up-of-raindrops-on-leave_1775422254_0.jpg', 'high', 8.80, 'under_review', '2026-04-05 20:50:54', '2026-04-05 21:00:32', 0, 'O0001', 0);
