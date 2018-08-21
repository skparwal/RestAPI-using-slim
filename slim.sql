-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2018 at 09:32 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.1.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slim`
--

-- --------------------------------------------------------

--
-- Table structure for table `recipients`
--

CREATE TABLE `recipients` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recipients`
--

INSERT INTO `recipients` (`id`, `name`, `email`, `status`) VALUES
(1, 'sandy', 'parwal@gmail.com', 0),
(2, 'sandy', 'sandy@gmail.com', 0),
(3, 'Sandeep Parwal', 'skparwal@gmail.com', 0),
(4, 'Sandy Parwal', 'sandyparwal@gmail.com', 0),
(5, 'Sandy Parwal', 'sandyparwal@google.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `special_offers`
--

CREATE TABLE `special_offers` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `discount` varchar(10) NOT NULL,
  `status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `special_offers`
--

INSERT INTO `special_offers` (`id`, `name`, `discount`, `status`) VALUES
(1, '30% Discount on all items', '30%', 0),
(2, '10% Discount on all items', '10%', 0),
(3, '12% Discount on all items', '12%', 0),
(4, '25% Discount on all items', '25%', 0),
(5, '5% Discount on all items', '5%', 0);

-- --------------------------------------------------------

--
-- Table structure for table `voucher_codes`
--

CREATE TABLE `voucher_codes` (
  `id` int(10) NOT NULL,
  `voucher_code` char(20) DEFAULT NULL,
  `recipient_id` int(10) DEFAULT NULL,
  `special_offers_id` int(10) DEFAULT NULL,
  `expiry_date` timestamp NULL DEFAULT NULL,
  `coupon_used` smallint(1) NOT NULL DEFAULT '0',
  `date_of_reedim` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voucher_codes`
--

INSERT INTO `voucher_codes` (`id`, `voucher_code`, `recipient_id`, `special_offers_id`, `expiry_date`, `coupon_used`, `date_of_reedim`, `status`) VALUES
(1, 'X6O1IELDGW', 1, 1, '2018-08-20 03:29:36', 1, '2018-08-19 07:03:12', 0),
(2, 'ZB4SUIYQDJ', 3, 1, '2018-08-21 03:35:49', 0, '0000-00-00 00:00:00', 0),
(3, 'VHJ4JN4R3S', 1, 1, '2018-08-21 03:35:49', 1, '2018-08-19 07:07:44', 0),
(4, 'S5VER6PU6T', 2, 1, '2018-08-21 03:35:49', 0, '0000-00-00 00:00:00', 0),
(5, 'A9LZ4GCYGL', 4, 1, '2018-08-21 03:35:49', 0, '0000-00-00 00:00:00', 0),
(6, '1M5JX1CZGL', 3, 2, '2018-08-22 03:35:55', 0, '0000-00-00 00:00:00', 0),
(7, '2GP4JSV3AD', 1, 2, '2018-08-22 03:35:55', 1, '2018-08-19 07:20:35', 0),
(8, 'N5JZJQ6JV6', 2, 2, '2018-08-22 03:35:55', 0, '0000-00-00 00:00:00', 0),
(9, 'EMF5AKMPXX', 4, 2, '2018-08-22 03:35:55', 0, '0000-00-00 00:00:00', 0),
(14, 'M3PRLLJOG4', 3, 4, '2018-08-25 03:49:19', 0, '0000-00-00 00:00:00', 0),
(15, '3QF6X9YBXQ', 1, 4, '2018-08-25 03:49:19', 0, '0000-00-00 00:00:00', 0),
(16, 'SCMM566P9W', 2, 4, '2018-08-25 03:49:19', 0, '0000-00-00 00:00:00', 0),
(17, 'VVL3ZQ11C6', 4, 4, '2018-08-25 03:49:19', 0, '0000-00-00 00:00:00', 0),
(18, 'B3C5IMJWII', 5, 4, '2018-08-25 03:49:19', 0, '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recipients`
--
ALTER TABLE `recipients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `special_offers`
--
ALTER TABLE `special_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher_codes`
--
ALTER TABLE `voucher_codes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recipients`
--
ALTER TABLE `recipients`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `special_offers`
--
ALTER TABLE `special_offers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `voucher_codes`
--
ALTER TABLE `voucher_codes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
