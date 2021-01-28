-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2021 at 03:16 PM
-- Server version: 10.2.32-MariaDB-1:10.2.32+maria~bionic-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatimmus_db2`
--

-- --------------------------------------------------------

--
-- Table structure for table `site_members`
--

CREATE TABLE `site_members` (
  `sm_memb_id` bigint(20) NOT NULL,
  `app_id` char(36) CHARACTER SET ascii DEFAULT NULL COMMENT 'app_id from applications DB Table. This has to be filled for external users, on whom behalf, an app_id from applications DB Table will be available. app_id is not required for local users.',
  `is_external_user` enum('0','1') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0' COMMENT '0: Local user; 1: External User',
  `ext_system_user_id` varchar(150) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'user_id from any of  the integrated external systems, if applicable.',
  `sm_email` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `sm_password` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `sm_display_name` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'This is optional. Either Display name or First name & Last Name are required when displaying the messages',
  `sm_firstname` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `sm_middlename` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `sm_lastname` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `added_datetime` varchar(30) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `added_datetime_epoch` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `added_by_sm_memb_id` char(36) CHARACTER SET ascii DEFAULT NULL,
  `last_updated_datetime` varchar(30) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `last_updated_datetime_epoch` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `last_updated_by_sm_memb_id` char(36) CHARACTER SET ascii DEFAULT NULL,
  `is_active_status` enum('0','1','2','3') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `crypto_key_version` varchar(15) CHARACTER SET ascii DEFAULT NULL COMMENT 'This is the Version Number of the used Cryptographic Keys ',
  `doc_crypto_hash` char(88) CHARACTER SET ascii DEFAULT NULL COMMENT 'This is the Digital Signature of the Row Data '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `site_members`
--

INSERT INTO `site_members` (`sm_memb_id`, `app_id`, `is_external_user`, `ext_system_user_id`, `sm_email`, `sm_password`, `sm_display_name`, `sm_firstname`, `sm_middlename`, `sm_lastname`, `added_datetime`, `added_datetime_epoch`, `added_by_sm_memb_id`, `last_updated_datetime`, `last_updated_datetime_epoch`, `last_updated_by_sm_memb_id`, `is_active_status`, `crypto_key_version`, `doc_crypto_hash`) VALUES
(1, NULL, '0', NULL, NULL, NULL, NULL, 'Raghu', NULL, 'Dendukuri', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL),
(2, NULL, '0', NULL, NULL, NULL, NULL, 'Raghuveer', NULL, 'D', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL),
(3, NULL, '0', NULL, NULL, NULL, NULL, 'venky', NULL, 'v', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL),
(6, NULL, '0', NULL, NULL, NULL, NULL, 'Raghu', NULL, 'Dendukuri', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL),
(7, NULL, '0', NULL, NULL, NULL, NULL, 'Raghu', NULL, 'Dendukuri', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL),
(8, NULL, '0', NULL, NULL, NULL, NULL, 'Raghu', NULL, 'Dendukuri', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL),
(9, NULL, '0', NULL, NULL, NULL, NULL, 'Raghu', NULL, 'Dendukuri', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL),
(10, NULL, '0', NULL, NULL, NULL, NULL, 'Raghuveer', NULL, 'D', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `site_members`
--
ALTER TABLE `site_members`
  ADD PRIMARY KEY (`sm_memb_id`),
  ADD KEY `is_active_status` (`is_active_status`),
  ADD KEY `sm_email` (`sm_email`),
  ADD KEY `added_datetime_epoch` (`added_datetime_epoch`),
  ADD KEY `added_datetime` (`added_datetime`),
  ADD KEY `last_updated_datetime` (`last_updated_datetime`),
  ADD KEY `last_updated_datetime_epoch` (`last_updated_datetime_epoch`),
  ADD KEY `ext_system_user_id` (`ext_system_user_id`),
  ADD KEY `app_id` (`app_id`),
  ADD KEY `is_external_user` (`is_external_user`),
  ADD KEY `added_by_sm_memb_id` (`added_by_sm_memb_id`),
  ADD KEY `last_updated_by_sm_memb_id` (`last_updated_by_sm_memb_id`),
  ADD KEY `crypto_key_version` (`crypto_key_version`),
  ADD KEY `doc_crypto_hash` (`doc_crypto_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `site_members`
--
ALTER TABLE `site_members`
  MODIFY `sm_memb_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
