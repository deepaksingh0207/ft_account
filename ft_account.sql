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
  `declaration` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `customers`;
INSERT INTO `customers` (`id`, `group_id`, `name`, `contact_person`, `gstin`, `pan`, `address`, `city`, `state`, `pincode`, `pphone`, `aphone`, `fax`, `email`, `remark`, `invoice_by`, `managername`, `manageremail`, `managerphone`, `status`, `added_date`, `updated_date`, `declaration`) VALUES
(1, 3, 'Aarti Industries Pvt. Ltd.', 'Mangesh', '27AAAAA0000A1Z5', 'AABCA2787L', 'Udyog Kshetra, 2nd Floor,\r\nMulund Goregaon Link Road, Mulund (West), Mumbai - 400080, Maharashtra, India', NULL, 22, '401107', '7498456880', '7498456880', '7498456880', 'deepaksingh0207@gmail.com', 'test', NULL, '', '0', '0', 1, '2021-04-20 13:44:24', '2021-06-22 04:14:33', NULL),
(2, 1, 'Jay Bharat Maruti Limited', 'Lalit', '24AAACJ2021K2Z0', 'VGUPF9456T', 'Survey No.62,Paiki 6&7,GIDC Ext Road-Vithlapur,Taluka Mandal,382130, Distt-Ahmedabad', NULL, 12, '382130', '7645342423', '7645342343', '7645342232', 'lalit@jbm.com', 'ccc', NULL, '', '0', '0', 1, '2021-05-29 12:05:41', '2021-06-09 15:06:17', NULL),
(3, 1, 'Neel Metal TVS', 'Suresh', '33AAACC1206D1ZN', 'DFRTS9878R', 'Hosur', NULL, 35, '534534', '2342342342', '2342342342', '1231243453', 'test@sdsd.com', 'test', NULL, '', '0', '0', 1, '2021-06-09 15:28:13', '2021-06-09 15:28:13', NULL),
(4, 1, 'JBM AS Sanand', 'Manish', '32AAICS2717D1ZR', 'DTUPD9856T', 'Sanand gujarat                        ', NULL, 12, '382110', '9876543211', '', '', 'manish@jbm.ss', 'wsd', NULL, 'Lalit', 'lalit@jbm.vv', '9876543212', 1, '2021-06-21 15:29:46', '2021-06-21 15:35:24', NULL),
(5, 1, 'vvvv', '', '', '', '', NULL, 1, '', '', '', '', '', '', NULL, '', '', '', 1, '2021-07-08 13:30:08', '2021-07-08 13:30:08', NULL);

DROP TABLE IF EXISTS `customer_groups`;
CREATE TABLE IF NOT EXISTS `customer_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `customer_groups`;
INSERT INTO `customer_groups` (`id`, `code`, `name`, `status`, `created_date`, `updated_date`) VALUES
(1, 'FT0001', 'JBM', 1, '2021-06-09 20:27:44', '2021-06-21 21:38:44'),
(2, 'FT0002', 'Plasser', 1, '2021-06-09 20:27:44', '2021-06-21 21:38:51'),
(3, 'FT0003', 'Aarti', 1, '2021-06-09 20:28:01', '2021-06-21 21:39:02'),
(4, 'FT0004', 'Apar', 1, '2021-06-09 20:28:01', '2021-06-21 21:39:07'),
(5, NULL, 'Bliss', 1, '2021-06-23 18:06:37', '2021-06-23 18:06:37');

DROP TABLE IF EXISTS `customer_payments`;
CREATE TABLE IF NOT EXISTS `customer_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payment_date` datetime NOT NULL,
  `cheque_utr_no` varchar(50) NOT NULL,
  `received_amt` decimal(10,2) NOT NULL,
  `utr_file` varchar(255) DEFAULT NULL,
  `remarks` varchar(300) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `customer_payments`;
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_no` varchar(7) NOT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_date` datetime NOT NULL,
  `pay_days` int(2) DEFAULT NULL,
  `po_no` varchar(20) NOT NULL,
  `sales_person` varchar(50) NOT NULL,
  `bill_to` varchar(255) NOT NULL,
  `ship_to` varchar(255) NOT NULL,
  `order_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_term` int(2) DEFAULT NULL,
  `pay_percent` decimal(10,2) DEFAULT NULL,
  `payment_description` varchar(255) DEFAULT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `igst` decimal(10,2) NOT NULL,
  `cgst` decimal(10,2) NOT NULL,
  `sgst` decimal(10,2) NOT NULL,
  `invoice_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remarks` varchar(255) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `invoices`;
DROP TABLE IF EXISTS `invoice_items`;
CREATE TABLE IF NOT EXISTS `invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `order_payterm_id` int(11) DEFAULT NULL,
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
  `po_file` varchar(255) DEFAULT NULL,
  `po_from_date` datetime DEFAULT NULL,
  `po_to_date` datetime DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`,`po_no`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `orders`;
INSERT INTO `orders` (`id`, `group_id`, `customer_id`, `order_date`, `pay_days`, `po_no`, `sales_person`, `bill_to`, `ship_to`, `order_type`, `sub_total`, `igst`, `cgst`, `sgst`, `tax_rate`, `ordertotal`, `po_file`, `po_from_date`, `po_to_date`, `remarks`, `status`, `added_date`, `updated_date`) VALUES
(1, 3, 1, '2021-11-26 00:00:00', 0, '10000001', 'Mangesh', '1', '1', 1, '600000', '0.00', '54000.00', '54000.00', '9.00', '708000.00', '1637921448_invoice_1236547.pdf', NULL, NULL, '', 1, '2021-11-26 15:40:48', '2021-11-26 15:40:48'),
(2, 3, 1, '2021-11-26 00:00:00', 0, '10000002', 'Mangesh', '1', '1', 2, '250000', '0.00', '22500.00', '22500.00', '9.00', '295000.00', '1637921510_invoice_1236547.pdf', NULL, NULL, '', 1, '2021-11-26 15:41:50', '2021-11-26 15:41:50'),
(3, 3, 1, '2021-11-27 00:00:00', 0, '10000003', 'Mangesh', '1', '1', 3, '5000', '0.00', '450.00', '450.00', '9.00', '5900.00', '1637921577_invoice_1236547.pdf', NULL, NULL, '', 1, '2021-11-26 15:42:57', '2021-11-26 15:42:57'),
(4, 3, 1, '2021-11-26 00:00:00', 0, '10000004', 'Mangesh', '1', '1', 4, '600000', '0.00', '54000.00', '54000.00', '9.00', '708000.00', '1637921625_invoice_1236547.pdf', NULL, NULL, '', 1, '2021-11-26 15:43:45', '2021-11-26 15:43:45'),
(5, 3, 1, '2021-11-27 00:00:00', 0, '10000005', 'Mangesh', '1', '1', 5, '10000', '0.00', '900.00', '900.00', '9.00', '11800.00', '1637921675_invoice_1236547.pdf', NULL, NULL, '', 1, '2021-11-26 15:44:35', '2021-11-26 15:44:35'),
(6, 3, 1, '2021-11-27 00:00:00', 0, '10000006', 'Mangesh', '1', '1', 6, '300000', '0.00', '27000.00', '27000.00', '9.00', '354000.00', '1637921756_invoice_1236547.pdf', NULL, NULL, '', 1, '2021-11-26 15:45:56', '2021-11-26 15:45:56'),
(7, 1, 2, '2021-11-27 00:00:00', 0, '10000007', 'Lalit', '2', '2', 99, '511000', '91980.00', '0.00', '0.00', '18.00', '602980.00', '1637922026_invoice_1236547.pdf', NULL, NULL, '', 1, '2021-11-26 15:50:26', '2021-11-26 15:50:26');

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
  `order_type` int(11) DEFAULT NULL,
  `po_from_date` datetime DEFAULT NULL,
  `po_to_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `order_items`;
INSERT INTO `order_items` (`id`, `order_id`, `item`, `description`, `qty`, `uom_id`, `unit_price`, `tax`, `total`, `added_date`, `updated_date`, `order_type`, `po_from_date`, `po_to_date`) VALUES
(1, 1, 'On site support', 'On Site Support Descp', '6', 2, '600000.00', NULL, '600000.00', '2021-11-26 15:40:48', '2021-11-26 15:40:48', 1, '2021-11-26 00:00:00', '2021-11-27 00:00:00'),
(2, 2, 'Accounts', 'Descp', '4', 3, '250000.00', NULL, '250000.00', '2021-11-26 15:41:50', '2021-11-26 15:41:50', 2, NULL, NULL),
(3, 3, 'Amc ', 'Support', '5', 2, '5000.00', NULL, '5000.00', '2021-11-26 15:42:57', '2021-11-26 15:42:57', 3, '2021-11-26 00:00:00', '2021-11-26 00:00:00'),
(4, 4, 'man Days', 'Man Days Descp', '12', 1, '50000.00', NULL, '600000.00', '2021-11-26 15:43:45', '2021-11-26 15:43:45', 4, NULL, NULL),
(5, 5, 'Sap', 'Descp', '2', 1, '5000.00', NULL, '10000.00', '2021-11-26 15:44:35', '2021-11-26 15:44:35', 5, NULL, NULL),
(6, 6, 'Hardware', 'Descp', '60', 4, '5000.00', NULL, '300000.00', '2021-11-26 15:45:56', '2021-11-26 15:45:56', 6, NULL, NULL),
(7, 7, 'On site support', 'On Site Support Descp', '2', 2, '20000.00', NULL, '20000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26', 1, '2021-11-26 00:00:00', '2021-11-27 00:00:00'),
(8, 7, 'Project', 'Descop', '3', 3, '50000.00', NULL, '50000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26', 2, NULL, NULL),
(9, 7, 'Amc Support', 'Amc Support Descp', '5', 2, '25000.00', NULL, '25000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26', 3, '2021-11-26 00:00:00', '2021-11-27 00:00:00'),
(10, 7, 'Man Day', 'Man Day Decp', '3', 1, '25000.00', NULL, '75000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26', 4, NULL, NULL),
(11, 7, 'Sap License Sale', 'Sap License Sale', '5', 4, '25000.00', NULL, '125000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26', 5, NULL, NULL),
(12, 7, 'Hardware', 'Descp', '6', 4, '36000.00', NULL, '216000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26', 6, NULL, NULL);

DROP TABLE IF EXISTS `order_payterms`;
CREATE TABLE IF NOT EXISTS `order_payterms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `item` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `order_payterms`;
INSERT INTO `order_payterms` (`id`, `order_id`, `order_item_id`, `item`, `description`, `qty`, `uom_id`, `unit_price`, `total`, `added_date`, `updated_date`) VALUES
(1, 1, 1, 'On site support', 'jan', '1', 2, '100000.00', '100000.00', '2021-11-26 15:40:48', '2021-11-26 15:40:48'),
(2, 1, 1, 'On site support', 'Feb', '1', 2, '100000.00', '100000.00', '2021-11-26 15:40:48', '2021-11-26 15:40:48'),
(3, 1, 1, 'On site support', 'mar', '1', 2, '100000.00', '100000.00', '2021-11-26 15:40:48', '2021-11-26 15:40:48'),
(4, 1, 1, 'On site support', 'Apr', '1', 2, '100000.00', '100000.00', '2021-11-26 15:40:48', '2021-11-26 15:40:48'),
(5, 1, 1, 'On site support', 'May', '1', 2, '100000.00', '100000.00', '2021-11-26 15:40:48', '2021-11-26 15:40:48'),
(6, 1, 1, 'On site support', 'Jun', '1', 2, '100000.00', '100000.00', '2021-11-26 15:40:48', '2021-11-26 15:40:48'),
(7, 2, 2, 'Accounts', 'advance', '25', 3, '250000.00', '62500.00', '2021-11-26 15:41:50', '2021-11-26 15:41:50'),
(8, 2, 2, 'Accounts', 'Development', '25', 3, '250000.00', '62500.00', '2021-11-26 15:41:50', '2021-11-26 15:41:50'),
(9, 2, 2, 'Accounts', 'testing', '25', 3, '250000.00', '62500.00', '2021-11-26 15:41:50', '2021-11-26 15:41:50'),
(10, 2, 2, 'Accounts', 'Uat Submit', '25', 3, '250000.00', '62500.00', '2021-11-26 15:41:50', '2021-11-26 15:41:50'),
(11, 3, 3, 'Amc ', 'jan', '1', 2, '1000.00', '1000.00', '2021-11-26 15:42:57', '2021-11-26 15:42:57'),
(12, 3, 3, 'Amc ', 'Feb', '1', 2, '1000.00', '1000.00', '2021-11-26 15:42:57', '2021-11-26 15:42:57'),
(13, 3, 3, 'Amc ', 'Mar', '1', 2, '1000.00', '1000.00', '2021-11-26 15:42:57', '2021-11-26 15:42:57'),
(14, 3, 3, 'Amc ', 'Apr', '1', 2, '1000.00', '1000.00', '2021-11-26 15:42:57', '2021-11-26 15:42:57'),
(15, 3, 3, 'Amc ', 'May', '1', 2, '1000.00', '1000.00', '2021-11-26 15:42:57', '2021-11-26 15:42:57'),
(16, 7, 7, 'On site support', 'Jan', '1', 2, '10000.00', '10000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26'),
(17, 7, 7, 'On site support', 'Feb', '1', 2, '10000.00', '10000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26'),
(18, 7, 8, 'Project', 'Project 1', '35', 3, '50000.00', '17500.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26'),
(19, 7, 8, 'Project', 'Project 2', '35', 3, '50000.00', '17500.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26'),
(20, 7, 8, 'Project', 'Project 3', '30', 3, '50000.00', '15000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26'),
(21, 7, 9, 'Amc Support', 'Jan', '1', 2, '5000.00', '5000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26'),
(22, 7, 9, 'Amc Support', 'Feb', '1', 2, '5000.00', '5000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26'),
(23, 7, 9, 'Amc Support', 'Mar', '1', 2, '5000.00', '5000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26'),
(24, 7, 9, 'Amc Support', 'Apr', '1', 2, '5000.00', '5000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26'),
(25, 7, 9, 'Amc Support', 'Jun', '1', 2, '5000.00', '5000.00', '2021-11-26 15:50:26', '2021-11-26 15:50:26');

DROP TABLE IF EXISTS `order_types`;
CREATE TABLE IF NOT EXISTS `order_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `order_types`;
INSERT INTO `order_types` (`id`, `title`, `status`) VALUES
(1, 'On-Site Support Sale', 1),
(2, 'Project Sale', 1),
(3, 'AMC Support Sale', 1),
(4, 'Man-days-Support Sale', 1),
(5, 'SAP License Sale', 1),
(6, 'Hardware Sale', 1),
(99, 'Multi Order', 1);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `payments`;
DROP TABLE IF EXISTS `proforma_invoices`;
CREATE TABLE IF NOT EXISTS `proforma_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_no` varchar(7) NOT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_date` datetime NOT NULL,
  `pay_days` int(2) DEFAULT NULL,
  `po_no` varchar(20) NOT NULL,
  `sales_person` varchar(50) NOT NULL,
  `bill_to` varchar(255) NOT NULL,
  `ship_to` varchar(255) NOT NULL,
  `order_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_term` int(2) DEFAULT NULL,
  `pay_percent` decimal(10,2) DEFAULT NULL,
  `payment_description` varchar(255) DEFAULT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `igst` decimal(10,2) NOT NULL,
  `cgst` decimal(10,2) NOT NULL,
  `sgst` decimal(10,2) NOT NULL,
  `invoice_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remarks` varchar(255) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `proforma_invoices`;
DROP TABLE IF EXISTS `proforma_invoice_items`;
CREATE TABLE IF NOT EXISTS `proforma_invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proforma_invoice_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `order_payterm_id` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `proforma_invoice_items`;
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
(1, 'Deepak Singh', 'deepaksingh@fts-pl.com', 'pass1234', 0, 1, '2021-04-17 14:14:22', '2021-04-17 14:14:22'),
(2, 'PF Accounts', 'account@fts-pl.com', 'Fts#2015@thane', 1, 1, '2021-07-03 07:16:47', '2021-07-03 07:16:47');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
