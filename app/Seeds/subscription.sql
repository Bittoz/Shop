-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2022 at 12:43 PM
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
-- Database: `downgrade`
--

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `subscr_id` int(11) NOT NULL,
  `subscr_name` varchar(200) NOT NULL,
  `subscr_slug` varchar(200) NOT NULL,
  `subscr_price` float NOT NULL,
  `subscr_duration` varchar(50) NOT NULL,
  `subscr_item_level` varchar(100) DEFAULT NULL,
  `subscr_item` int(100) NOT NULL,
  `subscr_download_item` mediumint(9) NOT NULL,
  `subscr_space_level` varchar(100) DEFAULT NULL,
  `subscr_space` int(100) NOT NULL,
  `subscr_space_type` varchar(100) DEFAULT NULL,
  `subscr_order` int(50) NOT NULL,
  `subscr_email_support` int(50) NOT NULL,
  `subscr_payment_mode` int(50) NOT NULL,
  `subscr_status` int(50) NOT NULL,
  `subscr_drop_status` varchar(50) NOT NULL DEFAULT 'no',
  `highlight_pack` int(11) NOT NULL DEFAULT 0,
  `highlight_bg_color` varchar(191) DEFAULT NULL,
  `highlight_text_color` varchar(191) DEFAULT NULL,
  `icon_color` varchar(191) DEFAULT NULL,
  `button_bg_color` varchar(191) DEFAULT NULL,
  `button_text_color` varchar(191) DEFAULT NULL,
  `extra_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`subscr_id`, `subscr_name`, `subscr_slug`, `subscr_price`, `subscr_duration`, `subscr_item_level`, `subscr_item`, `subscr_download_item`, `subscr_space_level`, `subscr_space`, `subscr_space_type`, `subscr_order`, `subscr_email_support`, `subscr_payment_mode`, `subscr_status`, `subscr_drop_status`, `highlight_pack`, `highlight_bg_color`, `highlight_text_color`, `icon_color`, `button_bg_color`, `button_text_color`, `extra_info`) VALUES
(7, 'Monthly', 'monthly', 29, '1 Month', 'limited', 50, 0, NULL, 0, NULL, 1, 0, 0, 1, 'no', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Yearly', 'yearly', 129, '1 Year', 'limited', 300, 0, NULL, 0, NULL, 2, 0, 0, 1, 'no', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Life Time', 'life-time', 1499, '1000 Year', 'unlimited', 0, 0, NULL, 0, NULL, 3, 0, 0, 1, 'no', 0, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`subscr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `subscr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
