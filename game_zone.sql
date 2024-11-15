-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2024 at 10:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `game_zone`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$WR4fmesspF1a4FWLw/tlxefopmXHzoht8jqpPYDCLqqxXxMMOY4DK'),
(2, 'sam', '$2y$10$PUG5upO/.4eZIIu1vcfgvOVlQmKCqnhjpf9rD7N2Y6KMpylnRzrzq'),
(3, 'rock@gmail.com', '$2y$10$CmUxdwELfMbRoFghkfDKIu83OTw7r71rAxRDmMr4dYI/y5trYsYmy');

-- --------------------------------------------------------

--
-- Table structure for table `kids`
--

CREATE TABLE `kids` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(12) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kids`
--

INSERT INTO `kids` (`id`, `name`, `contact`, `age`) VALUES
(22, 'SADIQUE', '', 2),
(23, 'SA1', '', 22),
(24, 'sam', '', 22),
(25, 'roni', '', 22),
(26, 'sarita', '', 15),
(27, 'sam', '', 11),
(28, 'sarita', '9546805580', 22),
(29, 'piyush', '7896543215', 22),
(30, 'hamid', '9546805583', 22),
(31, 'prithvi', '9876543212', 12),
(32, 'deep', '9546852252', 22),
(33, 'abhisekh', '987654323', 12),
(34, 'rupesh', '8765432123', 15),
(35, 'abg', '21445', 3),
(36, 'sgssh', '45625552', 5),
(37, 'rahul', '954543434', 12),
(38, 'price', '123456789876', 22),
(39, 'amit', '2345678', 12),
(40, 'fgfg', '95545454545', 1),
(42, 'fasd', '23423', 2343234),
(43, 'fas', '2345678765', 12),
(44, 'fdasfasd', '98765432', 22),
(45, 'dsfafas', '234567876', 22),
(46, 'ddasff', '323', 322),
(47, 'fga', '', 0),
(48, 'dfa', '', 0),
(49, 'fads', '9876543', 22),
(50, 'fd', '3456783456', 22),
(51, 'prince raj', '1234567897', 12),
(52, 'RAHUL', '2345670', 22),
(53, 'vishal', '987654326', 12);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `offer_name` varchar(255) NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `offer_name`, `discount_percentage`, `start_date`, `end_date`, `is_active`) VALUES
(2, 'welcome offer', 40.00, '2024-11-12', '2024-11-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `kid_id` int(11) NOT NULL,
  `check_in_time` datetime NOT NULL,
  `check_out_time` datetime DEFAULT NULL,
  `assigned_hours` float DEFAULT NULL,
  `total_cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `kid_id`, `check_in_time`, `check_out_time`, `assigned_hours`, `total_cost`) VALUES
(1, 22, '2024-11-08 19:42:00', '2024-11-08 19:43:14', 1, 0),
(2, 23, '2024-11-08 19:43:00', '2024-11-08 19:43:38', 2, 0),
(3, 24, '2024-11-09 13:32:00', '2024-11-09 12:37:01', 1, 0),
(4, 25, '2024-11-09 13:34:00', '2024-11-09 19:05:02', 2, 0),
(5, 26, '2024-11-09 13:34:00', '2024-11-11 07:43:07', 1, 0),
(6, 27, '2024-11-09 12:38:00', '2024-11-09 13:39:16', 1, 0),
(7, 28, '2024-11-09 15:18:00', '2024-11-11 07:43:03', 1, 0),
(8, 28, '2024-11-09 15:19:00', '2024-11-09 17:22:17', 1, 0),
(9, 29, '2024-11-09 17:20:00', '2024-11-11 07:42:59', 1, 0),
(10, 30, '2024-11-11 07:43:00', '2024-11-11 07:51:02', 1, 0),
(11, 31, '2024-11-11 06:47:00', '2024-11-11 07:47:30', 1, 0),
(12, 32, '2024-11-11 09:39:00', '2024-11-11 10:40:42', 1, 0),
(13, 33, '2024-11-11 10:34:00', '2024-11-11 15:20:31', 5, 0),
(14, 34, '2024-11-11 10:35:00', '2024-11-11 15:20:29', 1, 0),
(15, 35, '2024-11-11 11:24:00', '2024-11-11 11:28:14', 0, 0),
(16, 36, '2024-11-11 11:25:00', '2024-11-11 15:20:26', 1, 0),
(17, 37, '2024-11-11 14:30:00', '2024-11-12 09:16:47', 1, 0),
(18, 38, '2024-11-11 15:25:00', NULL, 1, 0),
(19, 39, '2024-11-11 15:25:00', '2024-11-12 09:16:45', 1, 0),
(20, 40, '2024-11-12 09:04:00', '2024-11-12 09:16:33', 0, 0),
(21, 42, '2024-11-12 09:08:00', '2024-11-12 09:16:31', 0, 300),
(22, 43, '2024-11-12 12:59:00', NULL, 0.5, 300),
(23, 44, '2024-11-12 13:29:00', NULL, 0, 300),
(24, 45, '2024-11-12 13:31:00', NULL, 0, 300),
(25, 46, '2024-11-12 13:31:00', NULL, 0, 300),
(26, 47, '2024-11-12 13:45:17', NULL, 0, 0),
(27, 47, '2024-11-12 13:45:24', NULL, 0, 0),
(28, 48, '2024-11-12 13:45:42', NULL, 0, 0),
(29, 42, '2024-11-12 13:46:36', NULL, 0, 0),
(30, 49, '2024-11-12 13:47:00', NULL, 0, 300),
(31, 50, '2024-11-12 13:49:00', NULL, 0, 300),
(32, 39, '2024-11-12 13:50:00', NULL, 0.5, 300),
(33, 51, '2024-11-12 15:40:00', '2024-11-15 14:27:28', 0.5, 300),
(34, 52, '2024-11-14 16:05:00', '2024-11-15 14:27:26', 0.5, 300),
(35, 53, '2024-11-15 14:25:00', NULL, 0.5, 300);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `hourly_charge` decimal(10,2) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `business_name` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `gst` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `hourly_charge`, `contact`, `business_name`, `address`, `gst`, `email`, `password`) VALUES
(1, 250.00, '9608297530', 'Kidz FunStation', 'Panorama Rameshwaram, 1st floor, Shop No 208, 209. Near Tanishq Showroom, Line Bazar, Purnea (Bihar) ', '10CNCPA1183R1Z6', 'kidzfunstation@gmail.com', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kids`
--
ALTER TABLE `kids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kid_id` (`kid_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kids`
--
ALTER TABLE `kids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`kid_id`) REFERENCES `kids` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
