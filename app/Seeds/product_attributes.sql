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
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `product_attribute_id` int(11) NOT NULL,
  `product_token` varchar(200) DEFAULT NULL,
  `attribute_id` int(200) NOT NULL,
  `product_attribute_label` text DEFAULT NULL,
  `product_attribute_values` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`product_attribute_id`, `product_token`, `attribute_id`, `product_attribute_label`, `product_attribute_values`) VALUES
(6, 'tY1zHrl12AKTvS8w2O9thHrvW', 32, 'Package Includes', 'HTML'),
(7, 'tY1zHrl12AKTvS8w2O9thHrvW', 33, 'Compatible Browsers', 'Chrome'),
(14, '76Z9W6RkWvVg6uytJu9TXUN3P', 32, 'Package Includes', 'CSS,HTML'),
(15, '76Z9W6RkWvVg6uytJu9TXUN3P', 33, 'Compatible Browsers', 'Safari,Firefox'),
(18, 'SfMshw6UsNnZCqi2FsJCkP2Ql', 32, 'Package Includes', 'CSS,HTML'),
(19, 'SfMshw6UsNnZCqi2FsJCkP2Ql', 33, 'Compatible Browsers', 'Safari,Firefox,Internet Explorer'),
(20, 'si39CjKgJYSv3nrLvkUoJObkM', 32, 'Package Includes', 'CSS,HTML'),
(21, 'si39CjKgJYSv3nrLvkUoJObkM', 33, 'Compatible Browsers', 'Safari,Firefox'),
(22, 'Bi41VdRAKMuvR8F5sA5xHvv1a', 32, 'Package Includes', 'HTML'),
(23, 'Bi41VdRAKMuvR8F5sA5xHvv1a', 33, 'Compatible Browsers', 'Safari,Firefox'),
(24, 'fdIgZfiZKARZaAXCJg84hNVBf', 32, 'Package Includes', 'CSS'),
(25, 'fdIgZfiZKARZaAXCJg84hNVBf', 33, 'Compatible Browsers', 'Opera,Safari'),
(26, 'yqB5h8CYCRlALTAWPRxhtKbac', 33, 'Compatible Browsers', 'Opera,Firefox'),
(27, '9k8VnbmpbLdoP7qFvP5cUm9KO', 32, 'Package Includes', 'CSS'),
(28, 'kQ5DbXFk8eOykEYhvCjHADNLj', 32, 'Package Includes', 'CSS,HTML'),
(29, 'kQ5DbXFk8eOykEYhvCjHADNLj', 33, 'Compatible Browsers', 'Opera,Safari,Chrome,Firefox'),
(30, 'HkUZphbtZGjckUp2l35syHJ9f', 32, 'Package Includes', 'CSS,HTML'),
(31, 'HkUZphbtZGjckUp2l35syHJ9f', 33, 'Compatible Browsers', 'Safari,Chrome,Internet Explorer'),
(32, 'sDnVKtQMlrfsQ6HUIrEfPQNhr', 32, 'Package Includes', 'CSS,HTML'),
(33, 'sDnVKtQMlrfsQ6HUIrEfPQNhr', 33, 'Compatible Browsers', 'Safari,Firefox,Internet Explorer'),
(34, 'TZ9BhX9EaEKC4d3Guhr4WkHl9', 32, 'Package Includes', 'CSS,HTML'),
(35, 'TZ9BhX9EaEKC4d3Guhr4WkHl9', 33, 'Compatible Browsers', 'Safari,Chrome,Internet Explorer'),
(36, 'AMqcrMlfKso08tHpxrYFdi5PV', 32, 'Package Includes', 'CSS,HTML'),
(37, 'AMqcrMlfKso08tHpxrYFdi5PV', 33, 'Compatible Browsers', 'Opera,Chrome,Firefox');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`product_attribute_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `product_attribute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
