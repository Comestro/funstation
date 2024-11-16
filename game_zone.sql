-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2024 at 06:55 PM
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
(1, 'admin', '$2y$10$WR4fmesspF1a4FWLw/tlxefopmXHzoht8jqpPYDCLqqxXxMMOY4DK');

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
(54, 'vishal', '7903096900', 12),
(55, 'vishal', '423423432', 22),
(56, 'raunak', '9472007003', 20),
(57, 'fdsa', 'fds', 22),
(61, 'fsafdd', '9876543222', 22),
(62, 'testing', '234567893456', 22),
(63, 'safas', '32432432432', 2332),
(64, 'Pratik', '12457890', 9),
(65, 'fdsafsa', '9876543211', 2147483647),
(66, 'fads', '324574342', 22),
(67, 'fdsa', '323232323', 22),
(68, 'fdsa', '324324324324', 22),
(69, 'fdsaf', '4332423', 22);

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
(8, 'welcome offer', 30.00, '2024-11-17', '2024-12-17', 1);

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
  `total_cost` int(11) NOT NULL,
  `include_gst` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `kid_id`, `check_in_time`, `check_out_time`, `assigned_hours`, `total_cost`, `include_gst`) VALUES
(1, 54, '2024-11-16 11:29:00', NULL, 0.5, 300, 0),
(2, 54, '2024-11-16 12:29:00', NULL, 0.5, 300, 0),
(3, 55, '2024-11-16 13:55:00', NULL, 1, 500, 0),
(4, 54, '2024-11-16 18:53:00', NULL, 0.5, 300, 0),
(5, 56, '2024-11-16 19:17:00', NULL, 0.5, 300, 0),
(6, 57, '2024-11-16 21:26:00', NULL, 1, 590, 1),
(7, 57, '2024-11-16 21:26:00', NULL, 1, 590, 1),
(8, 61, '2024-11-16 21:33:00', NULL, 1, 500, 1),
(9, 62, '2024-11-16 21:47:00', NULL, 1, 500, 0),
(10, 63, '2024-11-16 21:49:00', NULL, 0.5, 300, 0),
(11, 64, '2024-11-16 21:52:00', '2024-11-16 23:07:35', 1, 500, 1),
(12, 65, '2024-11-16 21:52:00', NULL, 0.5, 300, NULL),
(13, 66, '2024-11-16 22:59:00', NULL, 1, 500, 1),
(14, 67, '2024-11-16 22:59:00', NULL, 4, 2000, 1),
(15, 68, '2024-11-16 23:00:00', NULL, 1, 500, 1),
(16, 69, '2024-11-16 23:03:00', NULL, 1, 200, 1),
(17, 65, '2024-11-16 23:14:00', NULL, 1, 500, NULL);

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
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `hourly_charge`, `contact`, `business_name`, `address`, `gst`, `email`) VALUES
(1, 500.00, '9608297530', 'Kidz FunStation', 'Panorama Rameshwaram, 1st floor, Shop No 208, 209. Near Tanishq Showroom, Line Bazar, Purnea (Bihar) ', '10CNCPA1183R1Z6', 'kidzfunstation@gmail.com');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
