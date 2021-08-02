SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `ft_account` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ft_account`;

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

TRUNCATE TABLE `company`;
INSERT INTO `company` (`id`, `name`, `contact_person`, `contact`, `mobile`, `fax`, `email`, `gstin`, `pan`, `sac`, `pincode`, `address`, `state`, `bank_name`, `account_no`, `ifsc_code`, `created_date`, `updated_date`) VALUES
(1, 'F.T. Solutions Pvt. Ltd.', 'Deepak Singh', '9920687382', '9920687382', '9920687382', 'deepaksingh@fts-pl.com', '27AACCF6520B1Z4', 'AACCF6520B', '998313', '400604', '401, Meet Galaxy, Trimurti Lane Behind Tip Top Plaza, Teen Hath Naka, Thane 400604 Maharashtra                    ', 22, 'HDFC Bank', '50200029843099', 'HDFC0000543', '2021-05-17 18:40:43', '2021-05-29 17:23:05');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `customers`;
INSERT INTO `customers` (`id`, `group_id`, `name`, `contact_person`, `gstin`, `pan`, `address`, `city`, `state`, `pincode`, `pphone`, `aphone`, `fax`, `email`, `remark`, `invoice_by`, `managername`, `manageremail`, `managerphone`, `status`, `added_date`, `updated_date`) VALUES
(1, 1, 'Aarti Industries Pvt. Ltd.', 'Mangesh', '27AAAAA0000A1Z5', 'AABCA2787L', 'Udyog Kshetra, 2nd Floor,\r\nMulund Goregaon Link Road, Mulund (West), Mumbai - 400080, Maharashtra, India                   ', NULL, 22, '401107', '7498456880', '7498456880', '7498456880', 'deepaksingh0207@gmail.com', 'test', NULL, '', '0', '0', 1, '2021-04-20 13:44:24', '2021-08-02 19:42:26'),
(2, 2, 'Jay Bharat Maruti Limited', 'Lalit', '24AAACJ2021K2Z0', 'VGUPF9456T', 'Survey No.62,Paiki 6&7,GIDC Ext Road-Vithlapur,Taluka Mandal,382130, Distt-Ahmedabad', NULL, 12, '382130', '7645342423', '7645342343', '7645342232', 'lalit@jbm.com', 'ccc', NULL, '', '0', '0', 1, '2021-05-29 12:05:41', '2021-08-02 19:42:31'),
(3, 2, 'Neel Metal TVS', 'Suresh', '33AAACC1206D1ZN', 'DFRTS9878R', 'Hosur', NULL, 35, '534534', '2342342342', '2342342342', '1231243453', 'test@sdsd.com', 'test', NULL, '', '0', '0', 1, '2021-06-09 15:28:13', '2021-08-02 19:42:36'),
(4, 2, 'JBM AS Sanand', 'Manish', '32AAICS2717D1ZR', 'DTUPD9856T', 'Sanand gujarat                        ', NULL, 12, '382110', '9876543211', '', '', 'manish@jbm.ss', 'wsd', NULL, 'Lalit', 'lalit@jbm.vv', '9876543212', 1, '2021-06-21 15:29:46', '2021-08-02 19:43:09');

DROP TABLE IF EXISTS `customer_groups`;
CREATE TABLE IF NOT EXISTS `customer_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `customer_groups`;
INSERT INTO `customer_groups` (`id`, `code`, `name`, `status`, `created_date`, `updated_date`) VALUES
(1, 'FT0003', 'Aarti', 1, '2021-06-09 20:28:01', '2021-06-21 21:39:02'),
(2, 'FT0001', 'JBM', 1, '2021-06-09 20:27:44', '2021-06-21 21:38:44'),
(3, 'FT0002', 'Plasser', 1, '2021-06-09 20:27:44', '2021-06-21 21:38:51');

DROP TABLE IF EXISTS `customer_payments`;
CREATE TABLE IF NOT EXISTS `customer_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_date` datetime NOT NULL,
  `cheque_utr_no` varchar(50) NOT NULL,
  `received_amt` decimal(10,2) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remarks` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`,`cheque_utr_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `customer_payments`;
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
  `payment_term` varchar(100) DEFAULT NULL,
  `pay_percent` decimal(10,0) DEFAULT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `igst` decimal(10,0) NOT NULL,
  `cgst` decimal(10,0) NOT NULL,
  `sgst` decimal(10,0) NOT NULL,
  `invoice_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `invoice_no` varchar(7) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `payment_description` varchar(200) DEFAULT NULL,
  `uom_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `invoices`;
DROP TABLE IF EXISTS `invoice_items`;
CREATE TABLE IF NOT EXISTS `invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `item` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_item_id` int(11) DEFAULT NULL,
  `uom_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `invoice_items`;
DROP TABLE IF EXISTS `it_master`;
CREATE TABLE IF NOT EXISTS `it_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `igst` float NOT NULL,
  `cgst` float NOT NULL,
  `sgst` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `it_master`;
INSERT INTO `it_master` (`id`, `igst`, `cgst`, `sgst`) VALUES
(1, 18, 9, 9);

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
  `po_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`,`po_no`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `orders`;
INSERT INTO `orders` (`id`, `group_id`, `customer_id`, `order_date`, `pay_days`, `po_no`, `sales_person`, `bill_to`, `ship_to`, `order_type`, `sub_total`, `igst`, `cgst`, `sgst`, `tax_rate`, `ordertotal`, `remarks`, `status`, `added_date`, `updated_date`, `po_file`) VALUES
(1, 1, 1, '2021-08-03 00:00:00', 0, '10001', 'Mangesh', '1', '1', 1, '500000', '0.00', '45000.00', '45000.00', '9.00', '590000.00', '', 1, '2021-08-03 01:20:28', '2021-08-03 01:20:28', 'Test.pdf'),
(2, 1, 1, '2021-08-03 00:00:00', 0, '10002', 'Mangesh', '1', '1', 2, '1000000', '0.00', '90000.00', '90000.00', '9.00', '1180000.00', '', 1, '2021-08-03 01:21:38', '2021-08-03 01:21:38', 'Test.pdf'),
(3, 2, 2, '2021-08-03 00:00:00', 0, '10003', 'Lalit', '2', '4', 3, '160000', '28800.00', '0.00', '0.00', '18.00', '188800.00', '', 1, '2021-08-03 01:23:55', '2021-08-03 01:23:55', 'Test.pdf'),
(4, 2, 3, '2021-08-03 00:00:00', 0, '10004', 'Suresh', '3', '3', 4, '80000', '14400.00', '0.00', '0.00', '18.00', '94400.00', '', 1, '2021-08-03 01:24:51', '2021-08-03 01:24:51', 'Test.pdf'),
(5, 2, 4, '2021-08-03 00:00:00', 0, '10005', 'Manish', '4', '2', 5, '3800000', '684000.00', '0.00', '0.00', '18.00', '4484000.00', '', 1, '2021-08-03 01:25:43', '2021-08-03 01:25:43', 'Test.pdf'),
(6, 1, 1, '2021-08-03 00:00:00', 0, '10006', 'Mangesh', '1', '1', 6, '38400', '0.00', '3456.00', '3456.00', '9.00', '45312.00', '', 1, '2021-08-03 01:26:58', '2021-08-03 01:26:58', 'Test.pdf');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `order_items`;
INSERT INTO `order_items` (`id`, `order_id`, `item`, `description`, `qty`, `uom_id`, `unit_price`, `tax`, `total`, `added_date`, `updated_date`) VALUES
(1, 1, '1. On-Site Support Sale', 'SAP ABAP Onsite Support of Mr. Umesh Chaudhari For the month of April 2021', '5', 2, '500000.00', NULL, '500000.00', '2021-08-03 01:20:28', '2021-08-03 01:20:28'),
(2, 2, '2. Project Sale', 'SAP Implementation Project  ', '4', 3, '1000000.00', NULL, '1000000.00', '2021-08-03 01:21:38', '2021-08-03 01:21:38'),
(3, 3, '3. AMC Support Sale', 'AMC Support for the period  ( April 2021 )', '1', 2, '10000.00', NULL, '10000.00', '2021-08-03 01:23:55', '2021-08-03 01:23:55'),
(4, 3, '3. AMC Support Sale', 'AMC Support for the period  ( April 2021 to June 2021 )', '1', 2, '30000.00', NULL, '30000.00', '2021-08-03 01:23:55', '2021-08-03 01:23:55'),
(5, 3, '3. AMC Support Sale', 'AMC Support for the period  ( April 2021 to March 2022 )', '1', 2, '120000.00', NULL, '120000.00', '2021-08-03 01:23:55', '2021-08-03 01:23:55'),
(6, 4, '4. Man-days-Support Sale', 'SAP Support ', '16', 1, '5000.00', NULL, '80000.00', '2021-08-03 01:24:51', '2021-08-03 01:24:51'),
(7, 5, '5. SAP License  Sale ', 'SAP  functional user', '20', 2, '95000.00', NULL, '1900000.00', '2021-08-03 01:25:43', '2021-08-03 01:25:43'),
(8, 5, '5. SAP License  Sale ', 'SAP Technical user', '20', 2, '95000.00', NULL, '1900000.00', '2021-08-03 01:25:43', '2021-08-03 01:25:43'),
(9, 6, '6. Hardwar  Sale ', 'TRANSPARENT BARCODE LABEL (50.8X203.2MM)', '20000', 4, '1.92', NULL, '38400.00', '2021-08-03 01:26:58', '2021-08-03 01:26:58');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `order_payterms`;
INSERT INTO `order_payterms` (`id`, `order_id`, `item`, `description`, `qty`, `uom_id`, `unit_price`, `total`, `added_date`, `updated_date`) VALUES
(1, 1, 'JAN', 'SAP ABAP Onsite Support Of Mr. Umesh Chaudhari For The Month Of April 2021', '1', 3, '100000.00', '100000.00', '2021-08-03 01:20:28', '2021-08-03 01:20:28'),
(2, 1, 'FEB', 'SAP ABAP Onsite Support Of Mr. Umesh Chaudhari For The Month Of April 2021', '1', 3, '100000.00', '100000.00', '2021-08-03 01:20:28', '2021-08-03 01:20:28'),
(3, 1, 'MAR', 'SAP ABAP Onsite Support Of Mr. Umesh Chaudhari For The Month Of April 2021', '1', 3, '100000.00', '100000.00', '2021-08-03 01:20:28', '2021-08-03 01:20:28'),
(4, 1, 'APR', 'SAP ABAP Onsite Support Of Mr. Umesh Chaudhari For The Month Of April 2021', '1', 3, '100000.00', '100000.00', '2021-08-03 01:20:28', '2021-08-03 01:20:28'),
(5, 1, 'MAY', 'SAP ABAP Onsite Support Of Mr. Umesh Chaudhari For The Month Of April 2021', '1', 3, '100000.00', '100000.00', '2021-08-03 01:20:29', '2021-08-03 01:20:29'),
(6, 2, '2. Project Sale', 'Advance ', '25', 3, '1000000.00', '250000.00', '2021-08-03 01:21:38', '2021-08-03 01:21:38'),
(7, 2, '2. Project Sale', 'Successfully Completion of UAT ', '25', 3, '1000000.00', '250000.00', '2021-08-03 01:21:39', '2021-08-03 01:21:39'),
(8, 2, '2. Project Sale', 'Successfully Completion of Go-Live ', '25', 3, '1000000.00', '250000.00', '2021-08-03 01:21:39', '2021-08-03 01:21:39'),
(9, 2, '2. Project Sale', 'Support', '25', 3, '1000000.00', '250000.00', '2021-08-03 01:21:39', '2021-08-03 01:21:39');

DROP TABLE IF EXISTS `order_types`;
CREATE TABLE IF NOT EXISTS `order_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `order_types`;
INSERT INTO `order_types` (`id`, `title`, `status`) VALUES
(1, 'On-Site Support Sale', 1),
(2, 'Project Sale', 1),
(3, 'AMC Support Sale', 1),
(4, 'Man-days-Support Sale', 1),
(5, 'SAP License Sale', 1),
(6, 'Hardware Sale', 1);

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_payment_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `basic_value` decimal(10,2) NOT NULL,
  `gst_amount` decimal(10,2) NOT NULL,
  `invoice_amount` decimal(10,2) NOT NULL,
  `tds_percent` decimal(10,2) NOT NULL,
  `tds_deducted` decimal(10,2) NOT NULL,
  `receivable_amt` decimal(10,2) NOT NULL,
  `allocated_amt` decimal(10,2) NOT NULL,
  `balance_amt` decimal(10,2) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_id` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `payments`;
DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

TRUNCATE TABLE `states`;
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

DROP TABLE IF EXISTS `uom`;
CREATE TABLE IF NOT EXISTS `uom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `uom`;
INSERT INTO `uom` (`id`, `title`, `status`) VALUES
(1, 'Day(s)', 1),
(2, 'Nos', 1),
(3, 'Percentage', 1),
(4, 'PC', 1);

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

TRUNCATE TABLE `users`;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`, `status`, `added_date`, `updated_date`) VALUES
(1, 'Deepak Singh', 'deepaksingh@fts-pl.com', '1', 0, 1, '2021-04-17 14:14:22', '2021-07-13 04:17:17'),
(2, 'JThayil', 'jones.thayil@gmail.com', '1', 0, 1, '2021-04-17 14:14:22', '2021-07-13 04:17:17');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
