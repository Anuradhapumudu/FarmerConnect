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
(1, 'CP004', 'O0001', 'I got this one', 'CP004_officer_O0001_close-up-of-raindrops-on-leave_1775429594_0.jpg', 0, 0, '2026-04-05 22:53:14', '2026-04-05 22:53:14'),
(2, 'CP005', 'O0001', 'I got this complaint', 'CP005_officer_O0001_close-up-of-raindrops-on-leave_1775483393_0.jpg', 0, 0, '2026-04-06 13:49:53', '2026-04-06 13:49:53');

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
(5, 'DR013', 'O0001', 'Hello', 'DR013_officer_O0001_close-up-of-raindrops-on-leave_1775404928_0.jpg,DR013_officer_upd_O0001_close-up-of-raindrops-on-leaves-hd-background-luxury-hd-wallpaper-image-trendy-background-illustration-free-photo_1775414508_0.jpg,DR013_officer_upd_O0001_Image_created_with_a_mobile_phone_1775414524_0.png', '2026-04-05 16:02:08', '2026-04-05 18:46:15', 1, 1),
(6, 'DR013', 'O0001', 'Make sure you meet the supervisor and co-supervisor before you come to the presentation and viva. You can get their feedback in the final meetings and finalize your work.', 'DR013_officer_O0001_close-up-of-raindrops-on-leave_1775415920_0.jpg,DR013_officer_upd_O0001_Image_created_with_a_mobile_phone_1775417440_0.png', '2026-04-05 19:05:20', '2026-04-05 19:30:40', 1, 0),
(7, 'DR015', 'O0001', 'I got this', 'DR015_officer_O0001_close-up-of-raindrops-on-leave_1775422843_0.jpg', '2026-04-05 21:00:43', '2026-04-05 21:00:43', 0, 0),
(8, 'DR015', 'O0001', 'I\'m going to handle this problem', 'DR015_officer_O0001_Image_created_with_a_mobile_ph_1775422957_0.png', '2026-04-05 21:02:37', '2026-04-05 21:02:37', 0, 0);
