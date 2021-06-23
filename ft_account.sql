-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 23, 2021 at 12:49 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ft_account`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `fax` varchar(10) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `gstin` varchar(20) NOT NULL,
  `pan` varchar(10) NOT NULL,
  `sac` decimal(6,0) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `address` varchar(255) NOT NULL,
  `state` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `ifsc_code` varchar(15) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `contact_person`, `contact`, `mobile`, `fax`, `email`, `gstin`, `pan`, `sac`, `pincode`, `address`, `state`, `bank_name`, `account_no`, `ifsc_code`, `created_date`, `updated_date`) VALUES
(1, 'F.T. Solutions Pvt. Ltd.', 'Deepak Singh', '9920687382', '9920687382', '9920687382', 'deepaksingh@fts-pl.com', '27AACCF6520B1Z4', 'AACCF6520B', '998313', '400604', '401, Meet Galaxy, Trimurti Lane Behind Tip Top Plaza, Teen Hath Naka, Thane 400604 Maharashtra                    ', 22, 'HDFC Bank', '50200029843099', 'HDFC0000543', '2021-05-17 18:40:43', '2021-05-29 17:23:05');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `gstin` varchar(15) NOT NULL,
  `pan` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` int(11) DEFAULT NULL,
  `state` int(11) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `pphone` varchar(10) NOT NULL,
  `aphone` varchar(10) DEFAULT NULL,
  `fax` varchar(10) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `invoice_by` int(10) DEFAULT NULL,
  `managername` varchar(50) NOT NULL,
  `manageremail` varchar(100) NOT NULL,
  `managerphone` varchar(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `group_id`, `name`, `contact_person`, `gstin`, `pan`, `address`, `city`, `state`, `pincode`, `pphone`, `aphone`, `fax`, `email`, `remark`, `invoice_by`, `managername`, `manageremail`, `managerphone`, `status`, `added_date`, `updated_date`) VALUES
(1, 3, 'Aarti Industries Pvt. Ltd.', 'Mangesh', '27AAAAA0000A1Z5', 'AABCA2787L', 'Udyog Kshetra, 2nd Floor,\r\nMulund Goregaon Link Road, Mulund (West), Mumbai - 400080, Maharashtra, India                   ', NULL, 22, '401107', '7498456880', '7498456880', '7498456880', 'deepaksingh0207@gmail.com', 'test', NULL, '', '0', '0', 1, '2021-04-20 13:44:24', '2021-06-09 15:11:31'),
(2, 1, 'Jay Bharat Maruti Limited', 'Lalit', '24AAACJ2021K2Z0', 'VGUPF9456T', 'Survey No.62,Paiki 6&7,GIDC Ext Road-Vithlapur,Taluka Mandal,382130, Distt-Ahmedabad', NULL, 12, '382130', '7645342423', '7645342343', '7645342232', 'lalit@jbm.com', 'ccc', NULL, '', '0', '0', 1, '2021-05-29 12:05:41', '2021-06-09 15:06:17'),
(3, 1, 'Neel Metal TVS', 'Suresh', '33AAACC1206D1ZN', 'DFRTS9878R', 'Hosur', NULL, 35, '534534', '2342342342', '2342342342', '1231243453', 'test@sdsd.com', 'test', NULL, '', '0', '0', 1, '2021-06-09 15:28:13', '2021-06-09 15:28:13'),
(4, 1, 'JBM AS Sanand', 'Manish', '32AAICS2717D1ZR', 'DTUPD9856T', 'Sanand gujarat                        ', NULL, 12, '382110', '9876543211', '', '', 'manish@jbm.ss', 'wsd', NULL, 'Lalit', 'lalit@jbm.vv', '9876543212', 1, '2021-06-21 15:29:46', '2021-06-21 15:35:24'),
(5, 1, 'Pilot Customer', 'Jones Thayil', '27AACCF6520B1Z4', 'AACCF6520B', '401, Meet Galaxy, Tika No. 8,\r\nPlot No.3, Opp. Raheja Garden, Nr. Teen Hath Naka,\r\nBehind Tip Top Plaza', NULL, 22, '401105', '28161117', '', '', 'jones.thayil@gmail.com', 'Test Remark', NULL, 'JThayil', 'jones.thayil@gmail.com', '9082207560', 1, '2021-06-22 04:36:45', '2021-06-22 04:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `customer_groups`
--

DROP TABLE IF EXISTS `customer_groups`;
CREATE TABLE IF NOT EXISTS `customer_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_groups`
--

INSERT INTO `customer_groups` (`id`, `code`, `name`, `status`, `created_date`, `updated_date`) VALUES
(1, 'FT0001', 'test', 1, '2021-06-09 20:27:44', '2021-06-23 18:17:15'),
(2, 'FT0002', 'Plasser', 1, '2021-06-09 20:27:44', '2021-06-21 21:38:51'),
(3, 'FT0003', 'Aarti', 1, '2021-06-09 20:28:01', '2021-06-21 21:39:02'),
(4, 'FT0004', 'Apar', 1, '2021-06-09 20:28:01', '2021-06-21 21:39:07'),
(5, NULL, 'Bliss', 1, '2021-06-23 18:12:02', '2021-06-23 18:17:37');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_date` datetime NOT NULL,
  `pay_days` int(2) DEFAULT NULL,
  `po_no` varchar(20) NOT NULL,
  `sales_person` varchar(50) NOT NULL,
  `bill_to` varchar(255) NOT NULL,
  `ship_to` varchar(255) NOT NULL,
  `order_total` decimal(10,0) NOT NULL DEFAULT '0',
  `payment_term` varchar(100) NOT NULL,
  `pay_percent` decimal(10,0) NOT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `igst` decimal(10,0) NOT NULL,
  `cgst` decimal(10,0) NOT NULL,
  `sgst` decimal(10,0) NOT NULL,
  `invoice_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `customer_id`, `order_id`, `invoice_date`, `pay_days`, `po_no`, `sales_person`, `bill_to`, `ship_to`, `order_total`, `payment_term`, `pay_percent`, `sub_total`, `igst`, `cgst`, `sgst`, `invoice_total`, `remarks`, `status`, `added_date`, `updated_date`) VALUES
(1, 1, 1, '2021-05-29 00:00:00', NULL, '1234567890', 'Mangesh', 'Udyog Kshetra, 2nd Floor,\r\nMulund Goregaon Link Road, Mulund (West), Mumbai - 400080, Maharashtra, India', 'Udyog Kshetra, 2nd Floor,\r\nMulund Goregaon Link Road, Mulund (West), Mumbai - 400080, Maharashtra, India', '70000', 'Advance', '30', '21000', '0', '1890', '1890', '24780.00', 'test', 1, '2021-05-29 18:43:32', '2021-05-29 18:43:32'),
(2, 2, 2, '2021-05-29 00:00:00', NULL, '0987654321', 'Lalit', 'Survey No.62,Paiki 6&7,GIDC Ext Road-Vithlapur,Taluka Mandal,382130, Distt-Ahmedabad', 'Survey No.62,Paiki 6&7,GIDC Ext Road-Vithlapur,Taluka Mandal,382130, Distt-Ahmedabad', '200000', 'Full Payment', '100', '200000', '36000', '0', '0', '236000.00', 'test', 1, '2021-05-29 18:45:09', '2021-05-29 18:45:09'),
(4, 1, 1, '2021-05-29 00:00:00', NULL, '1234567890', 'Mangesh', 'Udyog Kshetra, 2nd Floor,\r\nMulund Goregaon Link Road, Mulund (West), Mumbai - 400080, Maharashtra, India', 'Udyog Kshetra, 2nd Floor,\r\nMulund Goregaon Link Road, Mulund (West), Mumbai - 400080, Maharashtra, India', '70000', 'UAT Submit', '20', '14000', '0', '1260', '1260', '16520.00', 'tws', 1, '2021-05-29 19:11:28', '2021-05-29 19:11:28');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
CREATE TABLE IF NOT EXISTS `invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `item` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `it_master`
--

DROP TABLE IF EXISTS `it_master`;
CREATE TABLE IF NOT EXISTS `it_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `igst` float NOT NULL,
  `cgst` float NOT NULL,
  `sgst` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `it_master`
--

INSERT INTO `it_master` (`id`, `igst`, `cgst`, `sgst`) VALUES
(1, 18, 9, 9);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `pay_days` int(2) NOT NULL DEFAULT '0',
  `po_no` varchar(20) NOT NULL,
  `sales_person` varchar(50) NOT NULL,
  `bill_to` varchar(255) NOT NULL,
  `ship_to` varchar(255) NOT NULL,
  `order_type` int(11) NOT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `igst` decimal(10,2) NOT NULL,
  `cgst` decimal(10,2) NOT NULL,
  `sgst` decimal(10,2) NOT NULL,
  `tax_rate` decimal(10,2) NOT NULL,
  `ordertotal` decimal(10,2) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`,`po_no`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `group_id`, `customer_id`, `order_date`, `pay_days`, `po_no`, `sales_person`, `bill_to`, `ship_to`, `order_type`, `sub_total`, `igst`, `cgst`, `sgst`, `tax_rate`, `ordertotal`, `remarks`, `status`, `added_date`, `updated_date`) VALUES
(7, 1, 2, '2021-06-21 00:00:00', 0, '444444', 'Lalit', '2', '4', 1, '160000', '28800.00', '0.00', '0.00', '18.00', '188800.00', 'ewrwer', 1, '2021-06-21 22:18:20', '2021-06-21 22:18:20'),
(10, 3, 1, '2021-06-21 00:00:00', 0, '999999', 'Mangesh', '1', '1', 2, '1000000', '0.00', '90000.00', '90000.00', '9.00', '1180000.00', 'sdsdasd', 1, '2021-06-21 23:36:29', '2021-06-21 23:36:29'),
(11, 1, 2, '2021-06-22 00:00:00', 0, '13134565', 'Lalit', '2', '5', 6, '2', '0.36', '0.00', '0.00', '18.00', '2.36', 'dasdxczxc', 1, '2021-06-22 10:08:30', '2021-06-22 10:08:30'),
(12, 1, 2, '2021-06-22 00:00:00', 0, '23424234', 'Lalit', '2', '3', 2, '1', '0.18', '0.00', '0.00', '18.00', '1.18', 'sdfsdfsdf', 1, '2021-06-22 15:24:04', '2021-06-22 15:24:04'),
(13, 1, 2, '2021-06-22 00:00:00', 0, '123123132', 'Lalit', '2', '5', 1, '1', '0.18', '0.00', '0.00', '18.00', '1.18', 'asdadads', 1, '2021-06-22 15:24:44', '2021-06-22 15:24:44'),
(14, 1, 5, '2021-06-23 00:00:00', 0, '24234234', 'Jones Thayil', '5', '2', 2, '10000', '0.00', '900.00', '900.00', '9.00', '11800.00', 'fsfsdfsdf', 1, '2021-06-23 00:25:08', '2021-06-23 00:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `item` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `item`, `description`, `qty`, `uom_id`, `unit_price`, `tax`, `total`, `added_date`, `updated_date`) VALUES
(5, 7, 'ABAP support', 'ABAP support apr aniket', '10', 1, '6000.00', NULL, '60000.00', '2021-06-21 22:18:20', '2021-06-21 22:18:20'),
(6, 7, 'ABAP support', 'Venu-may month', '1', 2, '100000.00', NULL, '100000.00', '2021-06-21 22:18:20', '2021-06-21 22:18:20'),
(8, 10, 'SAP Implementation Project  ', 'SAP Implementation Project  ', '100', 3, '1000000.00', NULL, '1000000.00', '2021-06-21 23:36:29', '2021-06-21 23:36:29'),
(9, 11, 'adsas', 'dasdas', '1', 1, '2.00', NULL, '2.00', '2021-06-22 10:08:30', '2021-06-22 10:08:30'),
(10, 12, 'aa', 'aa', '1', 2, '1.00', NULL, '1.00', '2021-06-22 15:24:04', '2021-06-22 15:24:04'),
(11, 13, 'a', 'a', '1', 2, '1.00', NULL, '1.00', '2021-06-22 15:24:44', '2021-06-22 15:24:44'),
(12, 14, 'a', 'a', '50', 3, '10000.00', NULL, '5000.00', '2021-06-23 00:25:08', '2021-06-23 00:25:08'),
(13, 14, 'b', 'b', '20', 3, '10000.00', NULL, '2000.00', '2021-06-23 00:25:08', '2021-06-23 00:25:08'),
(14, 14, 'c', 'c', '30', 3, '10000.00', NULL, '3000.00', '2021-06-23 00:25:08', '2021-06-23 00:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `order_payterms`
--

DROP TABLE IF EXISTS `order_payterms`;
CREATE TABLE IF NOT EXISTS `order_payterms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `item` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_payterms`
--

INSERT INTO `order_payterms` (`id`, `order_id`, `item`, `description`, `qty`, `uom_id`, `unit_price`, `total`, `added_date`, `updated_date`) VALUES
(1, 10, 'Advance ', 'Advance ', '25', 3, '1000000.00', '250000.00', '2021-06-21 23:36:29', '2021-06-21 23:36:29'),
(2, 10, 'Successfully Completion of UAT ', 'Successfully Completion of UAT ', '25', 3, '1000000.00', '250000.00', '2021-06-21 23:36:29', '2021-06-21 23:36:29'),
(3, 10, 'Successfully Completion of Go-Live ', 'Successfully Completion of Go-Live ', '25', 3, '1000000.00', '25000.00', '2021-06-21 23:36:29', '2021-06-22 21:17:04'),
(4, 10, 'Support', 'Support', '25', 3, '1000000.00', '250000.00', '2021-06-21 23:36:29', '2021-06-21 23:36:29'),
(5, 12, 'aa', 'aa', '1', 3, '1.00', '0.01', '2021-06-22 15:24:04', '2021-06-22 15:24:04'),
(6, 14, 'Advance', 'Advance', '20', 3, '10000.00', '2000.00', '2021-06-23 00:25:08', '2021-06-23 00:25:08'),
(7, 14, 'Testing', 'Testing', '20', 3, '10000.00', '2000.00', '2021-06-23 00:25:08', '2021-06-23 00:25:08'),
(8, 14, 'Development', 'Development', '20', 3, '10000.00', '2000.00', '2021-06-23 00:25:08', '2021-06-23 00:25:08'),
(9, 14, 'Testing', 'Testing', '20', 3, '10000.00', '2000.00', '2021-06-23 00:25:08', '2021-06-23 00:25:08'),
(10, 14, 'UAT', 'UAT', '20', 3, '10000.00', '2000.00', '2021-06-23 00:25:08', '2021-06-23 00:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `order_types`
--

DROP TABLE IF EXISTS `order_types`;
CREATE TABLE IF NOT EXISTS `order_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_types`
--

INSERT INTO `order_types` (`id`, `title`, `status`) VALUES
(1, 'On-Site Support Sale', 1),
(2, 'Project Sale', 1),
(3, 'AMC Support Sale', 1),
(4, 'Man-days-Support Sale', 1),
(5, 'SAP License Sale', 1),
(6, 'Hardware Sale', 1);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`) VALUES
(1, 'Andaman and Nicobar Islands', 101),
(2, 'Andhra Pradesh', 101),
(3, 'Arunachal Pradesh', 101),
(4, 'Assam', 101),
(5, 'Bihar', 101),
(6, 'Chandigarh', 101),
(7, 'Chhattisgarh', 101),
(8, 'Dadra and Nagar Haveli', 101),
(9, 'Daman and Diu', 101),
(10, 'Delhi', 101),
(11, 'Goa', 101),
(12, 'Gujarat', 101),
(13, 'Haryana', 101),
(14, 'Himachal Pradesh', 101),
(15, 'Jammu and Kashmir', 101),
(16, 'Jharkhand', 101),
(17, 'Karnataka', 101),
(18, 'Kenmore', 101),
(19, 'Kerala', 101),
(20, 'Lakshadweep', 101),
(21, 'Madhya Pradesh', 101),
(22, 'Maharashtra', 101),
(23, 'Manipur', 101),
(24, 'Meghalaya', 101),
(25, 'Mizoram', 101),
(26, 'Nagaland', 101),
(27, 'Narora', 101),
(28, 'Natwar', 101),
(29, 'Odisha', 101),
(30, 'Paschim Medinipur', 101),
(31, 'Pondicherry', 101),
(32, 'Punjab', 101),
(33, 'Rajasthan', 101),
(34, 'Sikkim', 101),
(35, 'Tamil Nadu', 101),
(36, 'Telangana', 101),
(37, 'Tripura', 101),
(38, 'Uttar Pradesh', 101),
(39, 'Uttarakhand', 101),
(40, 'Vaishali', 101),
(41, 'West Bengal', 101);

-- --------------------------------------------------------

--
-- Table structure for table `uom`
--

DROP TABLE IF EXISTS `uom`;
CREATE TABLE IF NOT EXISTS `uom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uom`
--

INSERT INTO `uom` (`id`, `title`, `status`) VALUES
(1, 'Day(s)', 1),
(2, 'Nos', 1),
(3, 'Percentage', 1),
(4, 'PC', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(15) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`, `status`, `added_date`, `updated_date`) VALUES
(1, 'Deepak Singh', 'deepaksingh@fts-pl.com', 'pass1234', 0, 1, '2021-04-17 14:14:22', '2021-04-17 14:14:22'),
(2, 'JThayil', 'jones.thayil@gmail.com', 'redhat', 0, 1, '2021-04-17 14:14:22', '2021-04-17 14:14:22');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
