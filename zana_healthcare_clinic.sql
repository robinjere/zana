-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2022 at 05:37 AM
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
(3, '  2, 3plates of wali nyama na mahalage', 3000, '2021-12-17 15:13:26', '2021-12-20 00:00:00', 13);

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
  `description` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `qty`, `buying_price`, `selling_price`, `description`, `created_at`, `updated_at`, `user_id`) VALUES
(3, 'toff plus', 12, 800, 900, 'new toff plus', '2021-12-12 18:43:36', '2022-04-09 00:00:00', 0),
(4, 'amoxilyn', 12, 800, 900, '', '2021-12-12 18:47:55', '2022-04-10 00:00:00', 0),
(5, 'panadol', 25, 3200, 4200, 'new panadol', '2021-12-13 00:15:12', '2022-04-10 00:00:00', 0),
(7, 'paracetamo', 13, 4000, 5000, '', '2021-12-19 16:39:58', '2022-04-10 00:00:00', 13),
(8, 'metacaflini', 29, 400, 500, 'metacaflin is the best, there ', '2022-04-03 13:16:07', '2022-04-10 00:00:00', 19);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`) VALUES
(1, 'can_register_user'),
(2, 'can_view_users_list'),
(3, 'can_edit_user'),
(4, 'can_delete_user'),
(5, 'can_view_item'),
(6, 'can_delete_item'),
(7, 'can_add_drug'),
(8, 'can_edit_drug'),
(9, 'can_view_drugs_out_of_stock'),
(10, 'can_view_sales'),
(11, 'can_sale_drug'),
(12, 'can_view_user_permission'),
(13, 'can_view_expenses'),
(14, 'can_add_expenses'),
(15, 'can_generate_report'),
(16, 'can_view_items_near_to_end');

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
(3, 'Doctor', 'doctor'),
(4, 'Pharmacist', 'pharmacy'),
(5, 'Superuser', 'superuser');

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
(61, 8, 2, '1x2 per day', 500, 1000, '', '2022-04-03 15:18:18', '2022-04-03 15:18:18', 19),
(62, 8, 1, '', 500, 0, '', '2022-04-03 15:23:38', '2022-04-03 15:23:38', 19),
(63, 7, 1, '1x2 per day', 5000, 0, '', '2022-04-03 19:01:10', '2022-04-03 19:01:10', 19),
(64, 7, 1, '8 tablets', 5000, 0, '', '2022-04-03 19:20:31', '2022-04-03 19:20:31', 19),
(68, 7, 1, '1x2 per day', 5000, 0, '', '2022-04-06 06:07:00', '2022-04-06 06:07:00', 19),
(69, 7, 1, '1x2 per day', 5000, 0, '', '2022-04-06 06:07:00', '2022-04-06 06:07:00', 19),
(70, 8, 1, '1x2 per day', 5000, 0, '', '2022-04-06 06:08:16', '2022-04-06 06:08:16', 19),
(71, 8, 1, '1x2 per day', 5000, 0, '', '2022-04-06 06:09:13', '2022-04-06 06:09:13', 19),
(73, 7, 1, '8 tablets', 5000, 0, '', '2022-04-10 05:00:10', '2022-04-10 05:00:10', 19),
(74, 7, 1, '2 tables', 5000, 0, '', '2022-04-10 05:02:03', '2022-04-10 05:02:03', 19),
(75, 7, 1, '2 tables', 5000, 0, '', '2022-04-10 05:02:33', '2022-04-10 05:02:33', 19),
(77, 4, 1, '1x2 per day', 900, 0, '', '2022-04-10 05:18:39', '2022-04-10 05:18:39', 19),
(79, 4, 1, '1x2 per day', 900, 0, '', '2022-04-10 05:24:39', '2022-04-10 05:24:39', 19),
(80, 7, 1, '8 tablets', 5000, 0, '', '2022-04-10 06:00:00', '2022-04-10 06:00:00', 19),
(81, 4, 1, '8 tablets', 900, 0, '', '2022-04-10 06:00:18', '2022-04-10 06:00:18', 19),
(82, 7, 1, '8 tablets', 5000, 0, '', '2022-04-10 06:18:09', '2022-04-10 06:18:09', 19),
(83, 4, 1, '', 900, 0, '', '2022-04-10 06:18:32', '2022-04-10 06:18:32', 19),
(84, 7, 1, '1x2 per day', 5000, 0, '', '2022-04-10 06:20:28', '2022-04-10 06:20:28', 19),
(85, 4, 1, '8 tablets', 900, 0, '', '2022-04-10 06:20:44', '2022-04-10 06:20:44', 19),
(86, 7, 1, '1x2 per day', 5000, 0, '', '2022-04-10 06:24:05', '2022-04-10 06:24:05', 19),
(87, 4, 1, '8 tablets', 900, 0, '', '2022-04-10 06:24:19', '2022-04-10 06:24:19', 19),
(89, 7, 1, '1x2 per day', 5000, 0, '', '2022-04-10 06:38:09', '2022-04-10 06:38:09', 19),
(90, 7, 1, '2tablets', 5000, 0, '', '2022-04-10 06:38:24', '2022-04-10 06:38:24', 19),
(91, 4, 1, '', 900, 0, '', '2022-04-10 06:38:40', '2022-04-10 06:38:40', 19),
(93, 7, 1, '1x2 per day', 5000, 0, '', '2022-04-10 06:40:47', '2022-04-10 06:40:47', 19),
(95, 7, 1, '8 tablets', 5000, 0, '', '2022-04-10 06:42:36', '2022-04-10 06:42:36', 19),
(97, 7, 1, '1x2 per day', 5000, 0, '', '2022-04-10 06:45:54', '2022-04-10 06:45:54', 19),
(98, 8, 1, '1x2 per day', 500, 0, '', '2022-04-10 06:59:04', '2022-04-10 06:59:04', 19),
(99, 4, 1, '', 900, 0, '', '2022-04-10 06:59:19', '2022-04-10 06:59:19', 19),
(101, 7, 1, '8 tablets', 5000, 0, '', '2022-04-10 07:03:27', '2022-04-10 07:03:27', 19),
(102, 8, 1, '2 tables', 500, 0, '', '2022-04-10 07:04:17', '2022-04-10 07:04:17', 19),
(103, 8, 1, '1 tables', 500, 0, '', '2022-04-10 07:53:23', '2022-04-10 07:53:23', 19),
(104, 7, 1, '2 tables', 5000, 0, '', '2022-04-10 07:53:39', '2022-04-10 07:53:39', 19),
(106, 8, 1, '', 500, 0, '', '2022-04-10 07:57:38', '2022-04-10 07:57:38', 19),
(107, 4, 1, '1x2 per day', 900, 0, '', '2022-04-10 08:01:17', '2022-04-10 08:01:17', 19),
(108, 3, 1, '1x2 per day', 900, 0, '', '2022-04-10 08:01:29', '2022-04-10 08:01:29', 19),
(109, 4, 1, '8 tablets', 900, 0, '', '2022-04-10 08:01:39', '2022-04-10 08:01:39', 19),
(110, 3, 1, '2 tables', 900, 0, '', '2022-04-10 08:01:50', '2022-04-10 08:01:50', 19),
(112, 3, 1, '2tablets', 900, 0, '', '2022-04-10 08:04:45', '2022-04-10 08:04:45', 19),
(113, 4, 1, '2tablets', 900, 0, '', '2022-04-10 08:08:20', '2022-04-10 08:08:20', 19),
(114, 4, 1, '2tablets', 900, 0, '', '2022-04-10 08:08:25', '2022-04-10 08:08:25', 19),
(123, 3, 1, '1x2 per day', 900, 0, '', '2022-04-10 08:15:11', '2022-04-10 08:15:11', 19),
(124, 8, 1, '1x2 per day', 500, 0, '', '2022-04-10 12:40:28', '2022-04-10 12:40:28', 19);

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
  `confirmed_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `father_name`, `sex`, `email`, `phone_number`, `address`, `password`, `is_active`, `is_info_confirmed`, `confirmed_by`) VALUES
(19, 'Sam', 'LastOne', 'SamFather', 'Male', 'sam@gmail.com', '0755323024', 'kinondoni shamba', '$2y$10$fUzyHEnfo7YRK/OKVGBJ0Oa7HZvU4S3kRmdUyQwG6eCowMRa13UEm', 1, 1, NULL);

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
(6, 14, 1),
(7, 14, 2),
(8, 14, 3),
(16, 13, 1),
(17, 13, 2),
(18, 17, 1),
(19, 17, 2),
(20, 17, 3),
(21, 17, 4),
(22, 17, 5),
(23, 17, 6),
(24, 17, 7),
(25, 17, 8),
(26, 17, 9),
(27, 17, 10),
(28, 17, 11),
(29, 17, 12),
(30, 17, 13),
(31, 17, 14),
(32, 17, 15),
(48, 19, 1),
(49, 19, 2),
(50, 19, 3),
(51, 19, 4),
(52, 19, 5),
(53, 19, 6),
(54, 19, 7),
(55, 19, 8),
(56, 19, 9),
(57, 19, 10),
(58, 19, 11),
(59, 19, 12),
(60, 19, 13),
(61, 19, 14),
(62, 19, 15),
(63, 19, 16);

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
(10, 5, 11),
(12, 2, 13),
(13, 2, 14),
(15, 5, 16),
(16, 5, 17),
(17, 2, 18),
(18, 5, 19);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `permission`
--
ALTER TABLE `permission`
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
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
