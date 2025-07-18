-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2022 at 12:42 PM
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
-- Table structure for table `email_template`
--

CREATE TABLE `email_template` (
  `et_id` int(10) UNSIGNED NOT NULL,
  `et_heading` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `et_subject` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `et_content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `et_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` (`et_id`, `et_heading`, `et_subject`, `et_content`, `et_status`) VALUES
(2, 'New Comment Received', 'New Comment Received', '&lt;p&gt;&lt;span style=&quot;color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px; text-transform: capitalize; background-color: #ffffff;&quot;&gt;Sender Name :&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;background-color: #ffffff; color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px;&quot;&gt;{{from_name}}&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px; text-transform: capitalize; background-color: #ffffff;&quot;&gt;Sender Email :&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;background-color: #ffffff; color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px;&quot;&gt;{{from_email}}&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px; text-transform: capitalize; background-color: #ffffff;&quot;&gt;Product Url : &lt;/span&gt;&lt;span style=&quot;background-color: #ffffff; color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px;&quot;&gt;&lt;a href=&quot;{{product_url}}&quot;&gt;{{product_url}}&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px; text-transform: capitalize; background-color: #ffffff;&quot;&gt;Comment :&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;background-color: #ffffff; color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px;&quot;&gt;{{comm_text}}&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', 1),
(3, 'Contact Us', 'Contact Us', '&lt;p&gt;&lt;span style=&quot;color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px; text-transform: capitalize; background-color: #ffffff;&quot;&gt;Name :&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;background-color: #ffffff; color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px;&quot;&gt;{{from_name}}&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px; text-transform: capitalize; background-color: #ffffff;&quot;&gt;Email :&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;background-color: #ffffff; color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px;&quot;&gt;{{from_email}}&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px; text-transform: capitalize; background-color: #ffffff;&quot;&gt;Message :&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;background-color: #ffffff; color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px;&quot;&gt;{{message_text}}&lt;/span&gt;&lt;/p&gt;', 1),
(4, 'Forgot Password', 'Forgot Password', '&lt;p&gt;You are receiving this email because we received a password reset request for your account&lt;/p&gt;\r\n&lt;p&gt;&lt;a href=&quot;{{forgot_url}}&quot;&gt;Reset Password&lt;/a&gt;&lt;/p&gt;', 1),
(6, 'Newsletter Signup', 'Newsletter Signup', '&lt;p&gt;You are receiving this email newsletter subscription request&lt;/p&gt;\r\n&lt;p&gt;Please confirm to this link &lt;a href=&quot;{{activate_url}}&quot;&gt;{{activate_url}}&lt;/a&gt; to activate your email subscription.&lt;/p&gt;', 1),
(7, 'Product Rating & Reviews', 'Product Rating & Reviews', '&lt;p&gt;Name : {{from_name}}&lt;/p&gt;\r\n&lt;p&gt;Email : {{from_email}}&lt;/p&gt;\r\n&lt;p&gt;Rating : {{rating}} Stars&lt;/p&gt;\r\n&lt;p&gt;Rating Reason : {{rating_reason}}&lt;/p&gt;\r\n&lt;p&gt;Comment : {{rating_comment}}&lt;/p&gt;\r\n&lt;p&gt;Product Url : &lt;a href=&quot;{{product_url}}&quot;&gt;{{product_url}}&lt;/a&gt;&lt;/p&gt;', 1),
(8, 'Refund Request Received', 'Refund Request Received', '&lt;p&gt;Name : {{from_name}}&lt;/p&gt;\r\n&lt;p&gt;Email : {{from_email}}&lt;/p&gt;\r\n&lt;p&gt;Refund Reason : {{ref_refund_reason}}&lt;/p&gt;\r\n&lt;p&gt;Comment : {{ref_refund_comment}}&lt;/p&gt;\r\n&lt;p&gt;Product Url : &lt;a href=&quot;{{product_url}}&quot;&gt;{{product_url}}&lt;/a&gt;&lt;/p&gt;', 1),
(9, 'New Signup Email Verification', 'Verify Your Email Address', '&lt;p&gt;Your registered email-id is {{email}} , Please click on the below link to verify your email account&lt;/p&gt;\r\n&lt;p&gt;&lt;a href=&quot;{{register_url}}&quot;&gt;Verify Email&lt;/a&gt;&lt;/p&gt;', 1),
(10, 'Contact Support', 'Contact Support', '&lt;p&gt;Name : {{from_name}}&lt;/p&gt;\r\n&lt;p&gt;Email : {{from_email}}&lt;/p&gt;\r\n&lt;p&gt;Subject : {{support_subject}}&lt;/p&gt;\r\n&lt;p&gt;Message : {{support_msg}}&lt;/p&gt;\r\n&lt;p&gt;Product Url : &lt;a href=&quot;{{product_url}}&quot;&gt;{{product_url}}&lt;/a&gt;&lt;/p&gt;', 1),
(11, 'Payment Refund Declined', 'Payment Refund Declined', '&lt;p&gt;Your payment refund is declined. Please contact your administrator&lt;/p&gt;\r\n&lt;p&gt;your refund request amount is : {{price}} {{currency}}&lt;/p&gt;', 1),
(13, 'Payment Refund Accepted', 'Payment Refund Accepted', '&lt;p&gt;Your payment refund is accepted and amount will be credit on your account. Please check your earning balance on your account&lt;/p&gt;\r\n&lt;p&gt;your payment is : {{price}} {{currency}}&lt;/p&gt;', 1),
(15, 'Item Update Notifications', 'Item Update Notifications', '&lt;p&gt;We\'d like to let you know that an update to your item &lt;a href=&quot;{{product_url}}&quot;&gt;{{product_url}}&lt;/a&gt; is now available in your Purchased page.&lt;/p&gt;', 1),
(16, 'Newsletter Updates', 'Newsletter Updates', '&lt;p&gt;Newsletter updates received. Please visit our website&lt;/p&gt;\r\n&lt;p&gt;Subject : {{news_heading}}&lt;/p&gt;\r\n&lt;p&gt;Content : {{news_content}}&lt;/p&gt;', 1),
(17, 'Payment Withdrawal Request Accepted', 'Payment Withdrawal Request Accepted', '&lt;p&gt;Your payment withdrawal request is accepted and amount will be credit on your payment gateway or bank account&lt;/p&gt;\r\n&lt;p&gt;your payment is : {{wd_amount}} {{currency}}&lt;/p&gt;', 1),
(20, 'Subscription Upgrade', 'Subscription Upgrade', '&lt;p&gt;&lt;strong&gt;Thanks for your subscription&lt;/strong&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px; text-transform: capitalize; background-color: #ffffff;&quot;&gt;Pack Name : &lt;/span&gt;&lt;span style=&quot;background-color: #ffffff; color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px;&quot;&gt;{{user_subscr_type}}&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;background-color: #ffffff; color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px;&quot;&gt;&lt;span style=&quot;color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px; text-transform: capitalize; background-color: #ffffff;&quot;&gt;Date :&amp;nbsp;&lt;/span&gt;{{subscr_date}}&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px; text-transform: capitalize; background-color: #ffffff;&quot;&gt;Duration :&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;background-color: #ffffff; color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px;&quot;&gt;{{subscri_date}}&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px; text-transform: capitalize; background-color: #ffffff;&quot;&gt;Price :&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;background-color: #ffffff; color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px;&quot;&gt;{{currency}} {{subscr_price}}&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', 1),
(21, 'Item Purchase Notifications', 'Item Purchase Notifications', '&lt;h3&gt;Thank you for your order&lt;/h3&gt;\r\n&lt;p&gt;&lt;strong&gt;Buyer Details&lt;/strong&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;Name : {{from_name}}&lt;/p&gt;\r\n&lt;p&gt;Email : {{from_email}}&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;Order Details&lt;/strong&gt;&lt;/p&gt;\r\n&lt;p&gt;Order ID : #{{purchased_token}}&lt;/p&gt;\r\n&lt;p&gt;Amount : {{currency}} {{final_amount}}&lt;/p&gt;', 1),
(23, 'Subscription Renewal Notifications', 'Subscription Renewal Notifications', '&lt;h3&gt;&lt;span style=&quot;color: #212529; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 16px; font-weight: 400; background-color: #ffffff;&quot;&gt;Your subscription has been expire on {{expired_date}}. Please click on this page &lt;a href=&quot;{{subscription_url}}&quot;&gt;{{subscription_url}}&lt;/a&gt; and renewal your subscription&lt;/span&gt;&amp;nbsp;&lt;/h3&gt;\r\n&lt;p&gt;&lt;strong&gt;Customer Details&lt;/strong&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;Name : {{from_name}}&lt;/p&gt;\r\n&lt;p&gt;Email : {{from_email}}&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;Subscription Details&lt;/strong&gt;&lt;/p&gt;\r\n&lt;p&gt;Expire On : {{expired_date}}&lt;/p&gt;\r\n&lt;p&gt;Pack Name : {{pack_name}}&lt;/p&gt;', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_template`
--
ALTER TABLE `email_template`
  ADD PRIMARY KEY (`et_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_template`
--
ALTER TABLE `email_template`
  MODIFY `et_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
