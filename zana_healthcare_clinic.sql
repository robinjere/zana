-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2022 at 09:55 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic-store`
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
(15, 'can_generate_report');

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
  `confirmed_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `father_name`, `sex`, `email`, `phone_number`, `address`, `password`, `is_active`, `is_info_confirmed`, `confirmed_by`) VALUES
(19, 'NATAI', 'DANIEL', 'REMMY', 'Male', 'natai@gmail.com', '0762504358', 'dar es salaam', '$2y$10$SdP/U6EGbSmmrUVzlL9MXuEJ4jVZFxNoU7VuN3Zs8x4Dk2Xl76eDi', 1, 1, NULL),
(20, 'zakaria', 'batista', 'ngingo', 'Male', 'zakaria@gmail.com', '0762504358', 'dar es salaam', '$2y$10$Wzw0WwUiaIZiKWrCxF7/mOBDbW3DwkF8Q/NoejavZqCoVFYZUYPPy', 1, 1, NULL),
(21, 'JOHN', 'KIMARO', 'REMMY', 'Male', 'doc@tz.com', '0762504358', 'NJOMBE', '$2y$10$L.QZK1zv77T8hyFzTGLI6u56qLkjK6RujE9YMUWDy9rTz/PMG1xNe', 1, 1, NULL);

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
(67, 20, 1),
(68, 20, 2),
(69, 20, 3),
(70, 20, 6),
(71, 21, 1),
(72, 21, 2),
(73, 21, 3),
(74, 21, 4),
(75, 21, 5),
(76, 21, 6),
(77, 21, 7),
(78, 21, 8),
(79, 21, 9),
(80, 21, 10),
(81, 21, 11),
(82, 21, 12),
(83, 21, 13),
(84, 21, 14),
(85, 21, 15);

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
(18, 5, 19),
(19, 1, 20),
(20, 3, 21);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
