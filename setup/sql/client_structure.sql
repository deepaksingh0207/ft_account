-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2020 at 11:57 AM
-- Server version: 5.7.25
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ztdms_client_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

CREATE TABLE `nodes` (
  `id` int(11) NOT NULL,
  `client_id` varchar(100) DEFAULT NULL,
  `description` varchar(50) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `instance_no` varchar(5) NOT NULL,
  `system_id` varchar(10) NOT NULL,
  `client` varchar(4) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL,
  `type` enum('source','target') NOT NULL,
  `validity_start` datetime DEFAULT NULL,
  `validity_end` datetime DEFAULT NULL,
  `license_key` varchar(100) NOT NULL,
  `machine_id` varchar(100) NOT NULL,
  `status` enum('active','inactive','expire') NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `prefix` varchar(5) NOT NULL,
  `postfix` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`prefix`, `postfix`) VALUES
('ftspl', 'ztdms');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `city` varchar(20) NOT NULL,
  `client_id` varchar(100) DEFAULT NULL,
  `verifiy_code` varchar(100) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `login_attempt` tinyint(1) DEFAULT NULL,
  `level` enum('user','admin','super') NOT NULL DEFAULT 'admin',
  `status` enum('active','lock','inactive') NOT NULL DEFAULT 'active',
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `verify_expire_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `hash`, `company_name`, `mobile`, `city`, `client_id`, `verifiy_code`, `last_login`, `login_attempt`, `level`, `status`, `created_date`, `modified_date`, `verify_expire_time`) VALUES
(1, 'ft', 'ft', 'ft@admin.com', '$2y$10$ZyucvtR9hrouEe1Q46k2x./CC4fZtQptKI3k.jD0HRDqhlqnuB0u2', '', '', '', NULL, '', NULL, NULL, 'super', 'active', '2020-05-20 00:00:00', '2020-05-20 11:57:27', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nodes`
--
ALTER TABLE `nodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nodes`
--
ALTER TABLE `nodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
  
  CREATE TABLE `processes` (
  `id` int(11) NOT NULL,
  `nodes` json NOT NULL,
  `parameters` json NOT NULL,
  `system_summary` json DEFAULT NULL,
  `process_states` json DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifled_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `processes`
--
ALTER TABLE `processes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `processes`
--
ALTER TABLE `processes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
