-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2022 at 05:46 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zana_healthcare_clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignedmedicines`
--

CREATE TABLE `assignedmedicines` (
  `id` int(11) NOT NULL,
  `dosage` varchar(100) NOT NULL,
  `frequency` int(11) NOT NULL,
  `route` varchar(70) NOT NULL,
  `days` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `instruction` text NOT NULL,
  `drug_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `doctor` int(11) NOT NULL,
  `payed` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignedmedicines`
--

INSERT INTO `assignedmedicines` (`id`, `dosage`, `frequency`, `route`, `days`, `qty`, `instruction`, `drug_id`, `file_id`, `doctor`, `payed`, `created_at`, `updated_at`) VALUES
(1, '1x2', 2, '0', 2, 5, 'first instruction', 10, 0, 0, 0, '2022-06-27 04:40:50', '2022-06-27 04:40:50'),
(3, '5x2', 3, '0', 6, 5, 'fifth instruction', 11, 9, 31, 0, '2022-06-27 04:40:50', '2022-06-27 04:40:50'),
(4, '2x4', 2, '2x4', 3, 5, 'new instruction', 15, 9, 31, 0, '2022-06-27 04:40:50', '2022-06-27 04:40:50');

-- --------------------------------------------------------

--
-- Table structure for table `assigned_procedures`
--

CREATE TABLE `assigned_procedures` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `procedure_id` int(11) NOT NULL,
  `doctor` int(11) NOT NULL,
  `file` varchar(200) NOT NULL,
  `procedure_note` text NOT NULL,
  `amount` double NOT NULL,
  `confirmed_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assigned_procedures`
--

INSERT INTO `assigned_procedures` (`id`, `file_id`, `procedure_id`, `doctor`, `file`, `procedure_note`, `amount`, `confirmed_by`, `created_at`, `updated_at`) VALUES
(6, 9, 1, 31, '', 'diagnostic lapa procedure', 6000, 0, '2022-06-23 22:45:43', '2022-06-23 22:45:43'),
(8, 9, 3, 31, '', 'adden intrauterine Insem', 9000, 0, '2022-06-24 20:44:02', '2022-06-24 20:44:02');

-- --------------------------------------------------------

--
-- Table structure for table `clinicalnotes`
--

CREATE TABLE `clinicalnotes` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `doctor` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clinicalnotes`
--

INSERT INTO `clinicalnotes` (`id`, `file_id`, `note`, `doctor`, `created_at`, `updated_at`) VALUES
(2, 9, 'mokojo test', 31, '2022-06-21 21:52:59', '2022-06-21 21:52:59'),
(3, 9, 'another clinical note here', 31, '2022-06-21 22:25:14', '2022-06-21 22:25:14'),
(4, 9, 'Some clinical test example', 31, '2022-06-21 22:32:06', '2022-06-21 22:32:06'),
(5, 9, 'another comment here', 31, '2022-06-22 11:09:14', '2022-06-22 11:09:14'),
(6, 9, 'new comment ', 31, '2022-06-22 11:10:37', '2022-06-22 11:10:37');

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `payment` varchar(50) NOT NULL,
  `amount` double NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `payment_confirmed_by` int(11) NOT NULL,
  `consulted_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`id`, `file_id`, `doctor_id`, `payment`, `amount`, `assigned_by`, `payment_confirmed_by`, `consulted_by`, `created_at`, `updated_at`) VALUES
(7, 8, 31, 'NHIF', 5000, 30, 0, 0, '2022-06-16 21:17:45', '2022-06-16 21:17:45'),
(8, 9, 31, 'CASH', 5000, 30, 32, 31, '2022-06-16 21:21:07', '2022-06-16 22:16:19');

-- --------------------------------------------------------

--
-- Table structure for table `consultation_fee`
--

CREATE TABLE `consultation_fee` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `consultation_fee`
--

INSERT INTO `consultation_fee` (`id`, `role_id`, `amount`, `created_at`, `updated_at`) VALUES
(3, 3, 5000, '2022-05-28 20:21:01', '2022-05-28 20:21:01'),
(9, 6, 8000, '2022-05-28 20:39:38', '2022-05-28 20:39:38');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `description` varchar(70) NOT NULL,
  `amount` double NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `description`, `amount`, `created_at`, `updated_at`, `user_id`) VALUES
(3, '  2, 3plates of wali nyama na mahalage', 3000, '2021-12-17 15:13:26', '2021-12-20 00:00:00', 13),
(5, 'nimenunua umeme', 5000, '2022-04-27 12:28:42', '2022-04-27 12:28:42', 19),
(6, 'KUTUPA TAKA', 5000, '2022-04-27 12:57:34', '2022-04-27 12:57:34', 19),
(7, 'nimenunua bahasha', 10000, '2022-04-28 16:01:50', '2022-04-28 16:01:50', 19);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(70) NOT NULL,
  `qty` int(8) NOT NULL,
  `buying_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `exp_date` datetime DEFAULT NULL,
  `description` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `qty`, `buying_price`, `selling_price`, `exp_date`, `description`, `created_at`, `updated_at`, `user_id`) VALUES
(10, 'paracetamol', 50, 50, 100, NULL, '', '2022-04-27 12:50:56', '2022-04-27 00:00:00', 19),
(11, 'ibuprofen', 50, 100, 200, NULL, '', '2022-04-27 12:51:20', '2022-04-27 00:00:00', 19),
(12, 'LOSARTAN 50 MG (REPACE)', 100, 500, 666, NULL, '', '2022-04-27 16:29:28', '2022-04-27 00:00:00', 19),
(13, 'cetamol', 100, 2000, 3000, NULL, '', '2022-04-28 15:57:12', '2022-04-28 00:00:00', 19),
(15, 'paracetamol_new', 400, 500, 600, '2022-05-17 00:00:00', 'new paracetamol', '2022-05-03 16:11:25', '2022-05-14 00:00:00', 19);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(70) NOT NULL,
  `middle_name` varchar(70) NOT NULL,
  `sir_name` varchar(70) NOT NULL,
  `birth_date` date NOT NULL,
  `gender` varchar(20) NOT NULL,
  `address` varchar(80) NOT NULL,
  `phone_no` int(15) NOT NULL,
  `next_kin_name` varchar(70) NOT NULL,
  `next_kin_relationship` varchar(80) NOT NULL,
  `next_kin_phone` int(15) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `first_name`, `middle_name`, `sir_name`, `birth_date`, `gender`, `address`, `phone_no`, `next_kin_name`, `next_kin_relationship`, `next_kin_phone`, `created_at`, `updated_at`, `user_id`) VALUES
(17, 'Jose', 'teminiz', 'joseph', '2021-08-03', 'Male', 'Tabata, Dar es salaam', 8662334, 'joseph', 'relative', 8832666, '2022-06-16 20:08:27', '2022-06-16 20:08:27', 30),
(18, 'andrew', 'mosh', 'moshi', '2021-09-30', 'Male', 'arusha', 8662334, 'Jame', 'relative', 8832666, '2022-06-16 21:20:44', '2022-06-16 21:20:44', 30);

-- --------------------------------------------------------

--
-- Table structure for table `patients_file`
--

CREATE TABLE `patients_file` (
  `id` int(11) NOT NULL,
  `file_no` varchar(200) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `payment_method` varchar(60) NOT NULL,
  `insuarance_no` varchar(200) NOT NULL,
  `start_treatment` date NOT NULL,
  `end_treatment` date NOT NULL,
  `status` varchar(40) NOT NULL COMMENT 'inTreatment, finishTreatment, consultation',
  `patient_character` varchar(40) NOT NULL COMMENT 'outpatient,inpatient,outsider',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients_file`
--

INSERT INTO `patients_file` (`id`, `file_no`, `patient_id`, `payment_method`, `insuarance_no`, `start_treatment`, `end_treatment`, `status`, `patient_character`, `created_at`, `updated_at`) VALUES
(8, 'MRNO/2022/17', 17, 'NHIF', '', '0000-00-00', '0000-00-00', 'consultation', 'outpatient', '2022-06-16 20:08:27', '2022-06-16 21:17:45'),
(9, 'MRNO/2022/18', 18, 'CASH', '', '2022-06-21', '0000-00-00', 'inTreatment', 'outpatient', '2022-06-16 21:20:44', '2022-06-21 22:34:27');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `permission_group` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`, `permission_group`) VALUES
(1, 'can_register_user', 'user'),
(2, 'can_view_users_list', 'user'),
(3, 'can_edit_user', 'user'),
(4, 'can_delete_user', 'user'),
(5, 'can_view_drug', 'drug'),
(6, 'can_delete_drug', 'drug'),
(7, 'can_add_drug', 'drug'),
(8, 'can_edit_drug', 'drug'),
(9, 'can_view_drugs_out_of_stock', 'drug'),
(10, 'can_view_sales', 'sale'),
(11, 'can_sale_drug', 'sale'),
(12, 'can_view_user_permission', 'permission'),
(13, 'can_view_expenses', 'expenses'),
(14, 'can_add_expenses', 'expenses'),
(15, 'can_generate_report', 'report'),
(16, 'can_add_diagnosis', 'diagnosis'),
(17, 'can_delete_diagnosis', 'diagnosis'),
(18, 'can_view_diagnosis', 'diagnosis'),
(19, 'can_add_procedure', 'procedure'),
(20, 'can_view_procedure', 'procedure'),
(21, 'can_delete_procedure', 'procedure'),
(22, 'can_add_patient', 'patient'),
(23, 'can_view_patient', 'patient'),
(24, 'can_delete_patient', 'patient'),
(25, 'can_add_labtest', 'labtest'),
(26, 'can_delete_labtest', 'labtest'),
(27, 'can_view_labtest', 'labtest'),
(28, 'can_add_clinicalnote', 'clinicalnote'),
(29, 'can_view_clinicalnote', 'clinicalnote'),
(30, 'can_delete_clinicalnote', 'clinicalnote'),
(31, 'can_add_radiology', 'radiology'),
(32, 'can_view_radiology', 'radiology'),
(33, 'can_delete_radiology', 'radiology'),
(34, 'can_add_consultation', 'consultation'),
(35, 'can_delete_consultation', 'consultation'),
(36, 'can_view_consultation', 'consultation');

-- --------------------------------------------------------

--
-- Table structure for table `procedures`
--

CREATE TABLE `procedures` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `procedures`
--

INSERT INTO `procedures` (`id`, `name`, `price`) VALUES
(1, 'Diagnostic Laparascopy', 6000),
(2, 'Diagnostic Hysteroscopy', 5000),
(3, 'Intrauterine Insemination(IUI)', 9000);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `role_type` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `role_type`) VALUES
(1, 'Administrator', 'admin'),
(2, 'Receptionist', 'reception'),
(3, 'General Doctor', 'general_doctor'),
(4, 'Pharmacist', 'pharmacy'),
(5, 'Superuser', 'superuser'),
(6, 'Specialist Doctor', 'specialist_doctor'),
(7, 'Cashier', 'cashier');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(8) NOT NULL,
  `dose` varchar(60) NOT NULL,
  `amount` double NOT NULL,
  `discount` double NOT NULL,
  `description` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `item_id`, `qty`, `dose`, `amount`, `discount`, `description`, `created_at`, `updated_at`, `user_id`) VALUES
(61, 8, 20, '6', 2000, 0, '', '2022-04-27 12:25:16', '2022-04-27 12:25:16', 19),
(62, 9, 45, '6', 9000, 0, '', '2022-04-27 12:35:47', '2022-04-27 12:35:47', 19),
(63, 9, 5, '', 1000, 0, '', '2022-04-27 12:39:59', '2022-04-27 12:39:59', 19),
(64, 8, 10, '', 1000, 0, '', '2022-04-27 12:40:18', '2022-04-27 12:40:18', 19),
(65, 10, 10, '3', 1000, 0, '', '2022-04-27 12:52:36', '2022-04-27 12:52:36', 19),
(66, 11, 20, '6', 4000, 0, '', '2022-04-27 12:52:54', '2022-04-27 12:52:54', 19),
(67, 10, 35, '6', 3500, 0, '', '2022-04-27 12:54:42', '2022-04-27 12:54:42', 19),
(68, 11, 40, '6', 8000, 0, '', '2022-04-27 12:54:59', '2022-04-27 12:54:59', 19),
(69, 13, 48, '6', 144000, 0, '', '2022-04-28 15:58:57', '2022-04-28 15:58:57', 19),
(70, 13, 2, '3', 6000, 0, '', '2022-04-28 16:00:14', '2022-04-28 16:00:14', 19);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `father_name` varchar(50) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `email` varchar(70) NOT NULL,
  `phone_number` varchar(70) NOT NULL,
  `address` varchar(225) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_info_confirmed` tinyint(1) NOT NULL,
  `confirmed_by` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `father_name`, `sex`, `email`, `phone_number`, `address`, `password`, `is_active`, `is_info_confirmed`, `confirmed_by`, `user_id`) VALUES
(25, 'john', 'doe', 'doe father', 'Male', 'johndoe@gmail.com', '0755323024', 'address Dar -es - salaam', '$2y$10$h0E5hUSRzh6e0u3I.URgnepNK136O3CmBRCbnRBcg6O7ivKRoSr.O', 1, 1, NULL, 0),
(30, 'rec', 'rec last name', 'rec father name', 'Female', 'rec@gmail.com', '0754230326', 'address Dar -es - salaam', '$2y$10$TiEDOpaqXll0jbUxFuXSC.9/JKh8aKhZvZzCM6LIp1k5FMhvlpOS2', 1, 1, NULL, 0),
(31, 'doc', 'doctor', 'doctor father', 'Male', 'doctor@gmail.com', '3201763925', 'mbezi, goba', '$2y$10$QQvrp52R4cyeKZTrxCB2FOnAsW7ESQtW0N1iezDylVVp7fJKAtlPS', 1, 1, NULL, 0),
(32, 'cashier', 'cashier lastname', 'cashier father', 'Female', 'cashier@gmail.com', '3201763925', 'mwenge', '$2y$10$RVQNFGzUgh/IHfZfzm0nd.YCzVOqW2gzvqX.3lfHl9I2nDVPWLCMO', 1, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_permission`
--

INSERT INTO `user_permission` (`id`, `user_id`, `permission_id`) VALUES
(145, 25, 1),
(146, 25, 2),
(147, 25, 3),
(148, 25, 4),
(149, 25, 5),
(150, 25, 6),
(151, 25, 7),
(152, 25, 8),
(153, 25, 9),
(154, 25, 10),
(155, 25, 11),
(156, 25, 12),
(157, 25, 13),
(158, 25, 14),
(159, 25, 15),
(160, 25, 16),
(161, 25, 17),
(162, 25, 18),
(163, 25, 19),
(164, 25, 20),
(165, 25, 21),
(166, 25, 22),
(167, 25, 23),
(168, 25, 24),
(169, 25, 25),
(170, 25, 26),
(171, 25, 27),
(172, 25, 28),
(173, 25, 29),
(174, 25, 30),
(175, 25, 31),
(176, 25, 32),
(177, 25, 33),
(178, 25, 34),
(179, 25, 35),
(180, 25, 36),
(194, 30, 5),
(195, 30, 6),
(196, 30, 7),
(197, 30, 8),
(198, 30, 9),
(199, 30, 13),
(200, 30, 14),
(201, 30, 22),
(202, 30, 23),
(203, 30, 24),
(204, 30, 31),
(205, 30, 32),
(206, 30, 33),
(207, 30, 34),
(208, 30, 35),
(209, 30, 36),
(210, 31, 5),
(211, 31, 6),
(212, 31, 7),
(213, 31, 8),
(214, 31, 9),
(215, 31, 16),
(216, 31, 17),
(217, 31, 18),
(218, 31, 19),
(219, 31, 20),
(220, 31, 21),
(221, 31, 22),
(222, 31, 23),
(223, 31, 24),
(224, 31, 25),
(225, 31, 26),
(226, 31, 27),
(227, 31, 28),
(228, 31, 29),
(229, 31, 30),
(230, 31, 31),
(231, 31, 32),
(232, 31, 33),
(233, 31, 34),
(234, 31, 35),
(235, 31, 36),
(236, 32, 5),
(237, 32, 6),
(238, 32, 7),
(239, 32, 8),
(240, 32, 9),
(241, 32, 13),
(242, 32, 14),
(243, 32, 22),
(244, 32, 23),
(245, 32, 24),
(246, 32, 25),
(247, 32, 26),
(248, 32, 27),
(249, 32, 34),
(250, 32, 35),
(251, 32, 36);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role_id` int(10) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role_id`, `user_id`) VALUES
(24, 5, 25),
(29, 2, 30),
(30, 3, 31),
(31, 7, 32);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignedmedicines`
--
ALTER TABLE `assignedmedicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `doctor` (`doctor`),
  ADD KEY `drug_id` (`drug_id`);

--
-- Indexes for table `assigned_procedures`
--
ALTER TABLE `assigned_procedures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `procedure_id` (`procedure_id`),
  ADD KEY `doctor` (`doctor`),
  ADD KEY `confirmed_by` (`confirmed_by`);

--
-- Indexes for table `clinicalnotes`
--
ALTER TABLE `clinicalnotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `doctor` (`doctor`);

--
-- Indexes for table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `consulted_by` (`consulted_by`);

--
-- Indexes for table `consultation_fee`
--
ALTER TABLE `consultation_fee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_id_2` (`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `patients_file`
--
ALTER TABLE `patients_file`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_no` (`file_no`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `procedures`
--
ALTER TABLE `procedures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignedmedicines`
--
ALTER TABLE `assignedmedicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assigned_procedures`
--
ALTER TABLE `assigned_procedures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `clinicalnotes`
--
ALTER TABLE `clinicalnotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `consultation`
--
ALTER TABLE `consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `consultation_fee`
--
ALTER TABLE `consultation_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `patients_file`
--
ALTER TABLE `patients_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `procedures`
--
ALTER TABLE `procedures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
