-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2023 at 09:21 AM
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
-- Table structure for table `custom_settings`
--

CREATE TABLE `custom_settings` (
  `sno` int(11) NOT NULL,
  `google_recaptcha_site_key` varchar(200) DEFAULT NULL,
  `google_recaptcha_secret_key` varchar(200) DEFAULT NULL,
  `mercadopago_mode` int(10) NOT NULL DEFAULT 0,
  `mercadopago_client_id` varchar(200) DEFAULT NULL,
  `mercadopago_client_secret` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `custom_settings`
--

INSERT INTO `custom_settings` (`sno`, `google_recaptcha_site_key`, `google_recaptcha_secret_key`, `mercadopago_mode`, `mercadopago_client_id`, `mercadopago_client_secret`) VALUES
(1, '6LdZaAclAAAAAPmRk3F9grUl6LeQiAzznmBZ91dl', '6LdZaAclAAAAAOgesG5XB9PzTSZG3CnuLPEYQzJt', 0, 'TEST-bd89ca30-986a-41b6-80a2-6b47a3df5f66', 'TEST-2868251246865916-050517-7c55f176e9c060137cf2717909a7f4e5-555090144');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `custom_settings`
--
ALTER TABLE `custom_settings`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `custom_settings`
--
ALTER TABLE `custom_settings`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
