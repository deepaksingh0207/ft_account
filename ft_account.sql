SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `ft_account` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `ft_account`;

CREATE TABLE `company` (
  `id` int NOT NULL,
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
  `state` int NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `ifsc_code` varchar(15) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `company`;
INSERT INTO `company` (`id`, `name`, `contact_person`, `contact`, `mobile`, `fax`, `email`, `gstin`, `pan`, `sac`, `pincode`, `address`, `state`, `bank_name`, `account_no`, `ifsc_code`, `created_date`) VALUES
(1, 'F.T. Solutions Pvt. Ltd.', 'Deepak Singh', '9920687382', '9920687382', '9920687382', 'deepaksingh@fts-pl.com', '27AACCF6520B1Z4', 'AACCF6520B', '998313', '400604', '401, Meet Galaxy, Trimurti Lane Behind Tip Top Plaza, Teen Hath Naka, Thane 400604 Maharashtra                    ', 22, 'HDFC Bank', '50200029843099', 'HDFC0000543', '2021-05-17 18:40:43');

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `group_id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `gstin` varchar(15) NOT NULL,
  `pan` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` int DEFAULT NULL,
  `state` int NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `pphone` varchar(10) NOT NULL,
  `aphone` varchar(10) DEFAULT NULL,
  `fax` varchar(10) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `invoice_by` int DEFAULT NULL,
  `managername` varchar(50) NOT NULL,
  `manageremail` varchar(100) NOT NULL,
  `managerphone` varchar(10) NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `declaration` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `customers`;
INSERT INTO `customers` (`id`, `group_id`, `name`, `contact_person`, `gstin`, `pan`, `address`, `city`, `state`, `pincode`, `pphone`, `aphone`, `fax`, `email`, `remark`, `invoice_by`, `managername`, `manageremail`, `managerphone`, `status`, `added_date`, `declaration`) VALUES
(1, 1, 'Aarti Industries Pvt. Ltd.', 'Mangesh', '27AAAAA0000A1Z5', 'AABCA2787L', 'Udyog Kshetra, 2nd Floor,\r\nMulund Goregaon Link Road, Mulund (West), Mumbai - 400080, Maharashtra, India                   ', NULL, 22, '401107', '7498456880', '7498456880', '7498456880', 'deepaksingh0207@gmail.com', 'test', NULL, '', '0', '0', 1, '2021-04-20 13:44:24', NULL),
(2, 2, 'Jay Bharat Maruti Limited', 'Lalit', '24AAACJ2021K2Z0', 'VGUPF9456T', 'Survey No.62,Paiki 6&7,GIDC Ext Road-Vithlapur,Taluka Mandal,382130, Distt-Ahmedabad', NULL, 12, '382130', '7645342423', '7645342343', '7645342232', 'lalit@jbm.com', 'ccc', NULL, '', '0', '0', 1, '2021-05-29 12:05:41', NULL),
(3, 2, 'Neel Metal TVS', 'Suresh', '33AAACC1206D1ZN', 'DFRTS9878R', 'Hosur', NULL, 35, '534534', '2342342342', '2342342342', '1231243453', 'test@sdsd.com', 'test', NULL, '', '0', '0', 1, '2021-06-09 15:28:13', NULL),
(4, 2, 'JBM AS Sanand', 'Manish', '32AAICS2717D1ZR', 'DTUPD9856T', 'Sanand gujarat                        ', NULL, 12, '382110', '9876543211', '', '', 'manish@jbm.ss', 'wsd', NULL, 'Lalit', 'lalit@jbm.vv', '9876543212', 1, '2021-06-21 15:29:46', NULL);

CREATE TABLE `customer_groups` (
  `id` int NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` int NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `customer_groups`;
INSERT INTO `customer_groups` (`id`, `code`, `name`, `status`, `created_date`) VALUES
(1, 'FT0003', 'Aarti', 1, '2021-06-09 20:28:01'),
(2, 'FT0001', 'JBM', 1, '2021-06-09 20:27:44'),
(3, 'FT0002', 'Plasser', 1, '2021-06-09 20:27:44');

CREATE TABLE `customer_payments` (
  `id` int NOT NULL,
  `group_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `order_id` int NOT NULL,
  `invoice_id` int NOT NULL,
  `payment_date` datetime NOT NULL,
  `cheque_utr_no` varchar(50) NOT NULL,
  `received_amt` decimal(10,2) NOT NULL,
  `utr_file` varchar(255) DEFAULT NULL,
  `remarks` varchar(300) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `customer_payments`;
CREATE TABLE `invoices` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `order_id` int NOT NULL,
  `invoice_date` datetime NOT NULL,
  `pay_days` int DEFAULT NULL,
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
  `status` int NOT NULL DEFAULT '1',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `invoice_no` varchar(7) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `group_id` int DEFAULT NULL,
  `payment_description` varchar(200) DEFAULT NULL,
  `uom_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `invoices`;
INSERT INTO `invoices` (`id`, `customer_id`, `order_id`, `invoice_date`, `pay_days`, `po_no`, `sales_person`, `bill_to`, `ship_to`, `order_total`, `payment_term`, `pay_percent`, `sub_total`, `igst`, `cgst`, `sgst`, `invoice_total`, `remarks`, `status`, `added_date`, `invoice_no`, `due_date`, `group_id`, `payment_description`, `uom_id`) VALUES
(1, 1, 1, '2021-10-12 00:00:00', NULL, '1000001', 'Mangesh', '1', '1', '15000', NULL, NULL, '6850', '0', '617', '617', '8083.00', '', 1, '2021-10-12 11:57:06', '1000001', '2021-10-31 00:00:00', 1, NULL, NULL),
(2, 1, 2, '2021-10-12 00:00:00', NULL, '1000002', 'Mangesh', '1', '1', '50000', NULL, NULL, '23000', '0', '2070', '2070', '27140.00', '', 1, '2021-10-12 11:57:39', '1000002', '2021-10-31 00:00:00', 1, NULL, NULL),
(3, 1, 3, '2021-10-12 00:00:00', NULL, '1000003', 'Mangesh', '1', '1', '50000', NULL, NULL, '22833', '0', '2055', '2055', '26943.33', '', 1, '2021-10-12 11:58:03', '1000003', '2021-10-31 00:00:00', 1, NULL, NULL),
(4, 1, 4, '2021-10-13 00:00:00', NULL, '1000004', 'Mangesh', '1', '1', '100000', NULL, NULL, '5000', '0', '450', '450', '5900.00', '', 1, '2021-10-12 11:58:30', '1000004', '2021-10-14 00:00:00', 1, NULL, NULL),
(5, 1, 5, '2021-10-12 00:00:00', NULL, '1000005', 'Mangesh', '1', '1', '301000', NULL, NULL, '25000', '0', '2250', '2250', '29500.00', '', 1, '2021-10-12 11:58:55', '1000006', '2021-10-31 00:00:00', 1, NULL, NULL),
(6, 1, 6, '2021-10-12 00:00:00', NULL, '1000006', 'Mangesh', '1', '1', '301000', NULL, NULL, '25000', '0', '2250', '2250', '29500.00', '', 1, '2021-10-12 11:59:23', '1000006', '2021-10-31 00:00:00', 1, NULL, NULL);

CREATE TABLE `invoice_items` (
  `id` int NOT NULL,
  `invoice_id` int NOT NULL,
  `item` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_item_id` int DEFAULT NULL,
  `uom_id` int DEFAULT NULL,
  `order_payterm_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `invoice_items`;
INSERT INTO `invoice_items` (`id`, `invoice_id`, `item`, `description`, `qty`, `unit_price`, `tax`, `total`, `added_date`, `order_item_id`, `uom_id`, `order_payterm_id`) VALUES
(1, 1, 'On Site Item 1', 'Jan', '1', '3000.00', NULL, '3000.00', '2021-10-12 11:57:06', 1, 2, 1),
(2, 1, 'On Site Item 2', 'Jan', '1', '1500.00', NULL, '1500.00', '2021-10-12 11:57:06', 2, 2, 2),
(3, 1, 'On Site Item 3', 'Jan', '1', '1000.00', NULL, '1000.00', '2021-10-12 11:57:06', 3, 2, 4),
(4, 1, 'On Site Item 4', 'Jan', '1', '750.00', NULL, '750.00', '2021-10-12 11:57:06', 4, 2, 7),
(5, 1, 'On Site Item 5', 'Jan', '1', '600.00', NULL, '600.00', '2021-10-12 11:57:06', 5, 2, 11),
(6, 2, 'Project Item 1', 'Project payment descp 1', '100', '10000.00', NULL, '10000.00', '2021-10-12 11:57:39', 6, 3, 16),
(7, 2, 'Project Item 2', 'Project Payment Descp 1', '50', '10000.00', NULL, '5000.00', '2021-10-12 11:57:39', 7, 3, 17),
(8, 2, 'Project Item 3', 'Project Payment Descp 1', '35', '10000.00', NULL, '3500.00', '2021-10-12 11:57:39', 8, 3, 19),
(9, 2, 'Project Item 4', 'Project Payment Descp 1', '25', '10000.00', NULL, '2500.00', '2021-10-12 11:57:39', 9, 3, 22),
(10, 2, 'Project Item 5', 'Project Payment Descp 1', '20', '10000.00', NULL, '2000.00', '2021-10-12 11:57:39', 10, 3, 26),
(11, 3, 'Amc Item 1', 'Amc Payment 1', '1', '10000.00', NULL, '10000.00', '2021-10-12 11:58:03', 11, 2, 31),
(12, 3, 'Amc Item 2', 'Amc Payment 1', '1', '5000.00', NULL, '5000.00', '2021-10-12 11:58:03', 12, 2, 32),
(13, 3, 'Amc Item 3', 'Amc Payment 1', '1', '3333.33', NULL, '3333.33', '2021-10-12 11:58:03', 13, 2, 34),
(14, 3, 'Amc Item 4', 'Amc Payment 1', '1', '2500.00', NULL, '2500.00', '2021-10-12 11:58:03', 14, 2, 37),
(15, 3, 'Amc Item 5', 'Amc Payment 1', '1', '2000.00', NULL, '2000.00', '2021-10-12 11:58:03', 15, 2, 41),
(16, 4, 'Man days 1', 'Man Days  Descp1', '5', '1000.00', NULL, '5000.00', '2021-10-12 11:58:30', 16, 1, 0),
(17, 5, 'Sap Support 1', 'Sap Support descp 1', '5', '5000.00', NULL, '25000.00', '2021-10-12 11:58:55', 21, 1, 0),
(18, 6, 'Hardware 1', 'Hardware Descp 1', '5', '5000.00', NULL, '25000.00', '2021-10-12 11:59:23', 25, 1, 0);

CREATE TABLE `it_master` (
  `id` int NOT NULL,
  `igst` float NOT NULL,
  `cgst` float NOT NULL,
  `sgst` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `it_master`;
INSERT INTO `it_master` (`id`, `igst`, `cgst`, `sgst`) VALUES
(1, 18, 9, 9);

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `group_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `order_date` datetime NOT NULL,
  `pay_days` int NOT NULL DEFAULT '0',
  `po_no` varchar(20) NOT NULL,
  `sales_person` varchar(50) NOT NULL,
  `bill_to` varchar(255) NOT NULL,
  `ship_to` varchar(255) NOT NULL,
  `order_type` int DEFAULT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `igst` decimal(10,2) NOT NULL,
  `cgst` decimal(10,2) NOT NULL,
  `sgst` decimal(10,2) NOT NULL,
  `tax_rate` decimal(10,2) NOT NULL,
  `ordertotal` decimal(10,2) NOT NULL,
  `po_from_date` datetime DEFAULT NULL,
  `po_to_date` datetime DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `po_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `orders`;
INSERT INTO `orders` (`id`, `group_id`, `customer_id`, `order_date`, `pay_days`, `po_no`, `sales_person`, `bill_to`, `ship_to`, `order_type`, `sub_total`, `igst`, `cgst`, `sgst`, `tax_rate`, `ordertotal`, `po_from_date`, `po_to_date`, `remarks`, `status`, `added_date`, `po_file`) VALUES
(1, 1, 1, '2021-10-12 00:00:00', 0, '1000001', 'Mangesh', '1', '1', 1, '15000', '0.00', '1350.00', '1350.00', '9.00', '17700.00', '2021-10-12 00:00:00', '2021-10-30 00:00:00', '', 1, '2021-10-12 11:45:51', '1634019351_create.pdf'),
(2, 1, 1, '2021-10-12 00:00:00', 0, '1000002', 'Mangesh', '1', '1', 2, '50000', '0.00', '4500.00', '4500.00', '9.00', '59000.00', NULL, NULL, '', 1, '2021-10-12 11:48:56', '1634019536_create.pdf'),
(3, 1, 1, '2021-10-13 00:00:00', 0, '1000003', 'Mangesh', '1', '1', 3, '50000', '0.00', '4500.00', '4500.00', '9.00', '59000.00', '2021-10-12 00:00:00', '2021-10-30 00:00:00', '', 1, '2021-10-12 11:51:46', '1634019706_certificate (4).pdf'),
(4, 1, 1, '2021-10-12 00:00:00', 0, '1000004', 'Mangesh', '1', '1', 4, '100000', '0.00', '9000.00', '9000.00', '9.00', '118000.00', NULL, NULL, '', 1, '2021-10-12 11:53:22', '1634019802_certificate (4).pdf'),
(5, 1, 1, '2021-10-12 00:00:00', 0, '1000005', 'Mangesh', '1', '1', 5, '301000', '0.00', '27090.00', '27090.00', '9.00', '355180.00', NULL, NULL, '', 1, '2021-10-12 11:54:45', '1634019885_LETTER OF INTENT TO HIRE - Raksha.pdf'),
(6, 1, 1, '2021-10-12 00:00:00', 0, '1000006', 'Mangesh', '1', '1', 6, '301000', '0.00', '27090.00', '27090.00', '9.00', '355180.00', NULL, NULL, '', 1, '2021-10-12 11:56:12', '1634019972_certificate (4).pdf');

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `item` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `uom_id` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_type` int DEFAULT NULL,
  `po_from_date` datetime DEFAULT NULL,
  `po_to_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `order_items`;
INSERT INTO `order_items` (`id`, `order_id`, `item`, `description`, `qty`, `uom_id`, `unit_price`, `tax`, `total`, `added_date`, `order_type`, `po_from_date`, `po_to_date`) VALUES
(1, 1, 'On Site Item 1', 'On Site descp 1', '1', 2, '3000.00', NULL, '3000.00', '2021-10-12 11:45:51', NULL, NULL, NULL),
(2, 1, 'On Site Item 2', 'On Site Descp 2', '2', 2, '3000.00', NULL, '3000.00', '2021-10-12 11:45:52', NULL, NULL, NULL),
(3, 1, 'On Site Item 3', 'On Site Descp 3', '3', 2, '3000.00', NULL, '3000.00', '2021-10-12 11:45:52', NULL, NULL, NULL),
(4, 1, 'On Site Item 4', 'On Site Descp 4', '4', 2, '3000.00', NULL, '3000.00', '2021-10-12 11:45:52', NULL, NULL, NULL),
(5, 1, 'On Site Item 5', 'On Site Descp 5', '5', 2, '3000.00', NULL, '3000.00', '2021-10-12 11:45:52', NULL, NULL, NULL),
(6, 2, 'Project Item 1', 'Project Descp 1', '1', 3, '10000.00', NULL, '10000.00', '2021-10-12 11:48:56', NULL, NULL, NULL),
(7, 2, 'Project Item 2', 'Project Descp 2', '2', 3, '10000.00', NULL, '10000.00', '2021-10-12 11:48:56', NULL, NULL, NULL),
(8, 2, 'Project Item 3', 'Project Descp 3', '3', 3, '10000.00', NULL, '10000.00', '2021-10-12 11:48:57', NULL, NULL, NULL),
(9, 2, 'Project Item 4', 'Project Descp 4', '4', 3, '10000.00', NULL, '10000.00', '2021-10-12 11:48:57', NULL, NULL, NULL),
(10, 2, 'Project Item 5', 'Project Descp 5', '5', 3, '10000.00', NULL, '10000.00', '2021-10-12 11:48:57', NULL, NULL, NULL),
(11, 3, 'Amc Item 1', 'Amc Decp 1', '1', 2, '10000.00', NULL, '10000.00', '2021-10-12 11:51:46', NULL, NULL, NULL),
(12, 3, 'Amc Item 2', 'Amc Decp 2', '2', 2, '10000.00', NULL, '10000.00', '2021-10-12 11:51:46', NULL, NULL, NULL),
(13, 3, 'Amc Item 3', 'Amc Decp 3', '3', 2, '10000.00', NULL, '10000.00', '2021-10-12 11:51:46', NULL, NULL, NULL),
(14, 3, 'Amc Item 4', 'Amc Decp 4', '4', 2, '10000.00', NULL, '10000.00', '2021-10-12 11:51:47', NULL, NULL, NULL),
(15, 3, 'Amc Item 5', 'Amc Decp 5', '5', 2, '10000.00', NULL, '10000.00', '2021-10-12 11:51:47', NULL, NULL, NULL),
(16, 4, 'Man days 1', 'Man Days  Descp1', '20', 1, '1000.00', NULL, '20000.00', '2021-10-12 11:53:23', NULL, NULL, NULL),
(17, 4, 'Man Days 2', 'Man Days  Descp2', '20', 1, '1000.00', NULL, '20000.00', '2021-10-12 11:53:23', NULL, NULL, NULL),
(18, 4, 'Man Days 3', 'Man Days  Descp3', '20', 1, '1000.00', NULL, '20000.00', '2021-10-12 11:53:23', NULL, NULL, NULL),
(19, 4, 'Man Days 4', 'Man Days  Descp4', '20', 1, '1000.00', NULL, '20000.00', '2021-10-12 11:53:23', NULL, NULL, NULL),
(20, 4, 'Man Days 5', 'Man Days  Descp5', '20', 1, '1000.00', NULL, '20000.00', '2021-10-12 11:53:23', NULL, NULL, NULL),
(21, 5, 'Sap Support 1', 'Sap Support descp 1', '20', 1, '5000.00', NULL, '100000.00', '2021-10-12 11:54:45', NULL, NULL, NULL),
(22, 5, 'Sap Support 2', 'Sap Support Descp 2', '20', 2, '5000.00', NULL, '100000.00', '2021-10-12 11:54:45', NULL, NULL, NULL),
(23, 5, 'Sap Support 3', 'Sap Support Descp 3', '20', 3, '5000.00', NULL, '1000.00', '2021-10-12 11:54:45', NULL, NULL, NULL),
(24, 5, 'Sap Support 4', 'Sap Support Descp 4', '20', 4, '5000.00', NULL, '100000.00', '2021-10-12 11:54:45', NULL, NULL, NULL),
(25, 6, 'Hardware 1', 'Hardware Descp 1', '20', 1, '5000.00', NULL, '100000.00', '2021-10-12 11:56:12', NULL, NULL, NULL),
(26, 6, 'Hardware 2', 'Hardware Descp 2', '20', 2, '5000.00', NULL, '100000.00', '2021-10-12 11:56:12', NULL, NULL, NULL),
(27, 6, 'Hardware 3', 'Hardware Descp 3', '20', 3, '5000.00', NULL, '1000.00', '2021-10-12 11:56:12', NULL, NULL, NULL),
(28, 6, 'Hardware 4', 'Hardware Descp 4', '20', 4, '5000.00', NULL, '100000.00', '2021-10-12 11:56:12', NULL, NULL, NULL);

CREATE TABLE `order_payterms` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `item` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `uom_id` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_item_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `order_payterms`;
INSERT INTO `order_payterms` (`id`, `order_id`, `item`, `description`, `qty`, `uom_id`, `unit_price`, `total`, `added_date`, `order_item_id`) VALUES
(1, 1, 'On Site Item 1', 'Jan', '1', 2, '3000.00', '3000.00', '2021-10-12 11:45:52', 1),
(2, 1, 'On Site Item 2', 'Jan', '1', 2, '1500.00', '1500.00', '2021-10-12 11:45:52', 2),
(3, 1, 'On Site Item 2', 'Feb', '1', 2, '1500.00', '1500.00', '2021-10-12 11:45:52', 2),
(4, 1, 'On Site Item 3', 'Jan', '1', 2, '1000.00', '1000.00', '2021-10-12 11:45:52', 3),
(5, 1, 'On Site Item 3', 'Feb', '1', 2, '1000.00', '1000.00', '2021-10-12 11:45:52', 3),
(6, 1, 'On Site Item 3', 'Mar', '1', 2, '1000.00', '1000.00', '2021-10-12 11:45:52', 3),
(7, 1, 'On Site Item 4', 'Jan', '1', 2, '750.00', '750.00', '2021-10-12 11:45:52', 4),
(8, 1, 'On Site Item 4', 'Feb', '1', 2, '750.00', '750.00', '2021-10-12 11:45:52', 4),
(9, 1, 'On Site Item 4', 'Mar', '1', 2, '750.00', '750.00', '2021-10-12 11:45:52', 4),
(10, 1, 'On Site Item 4', 'Apr', '1', 2, '750.00', '750.00', '2021-10-12 11:45:52', 4),
(11, 1, 'On Site Item 5', 'Jan', '1', 2, '600.00', '600.00', '2021-10-12 11:45:52', 5),
(12, 1, 'On Site Item 5', 'Feb', '1', 2, '600.00', '600.00', '2021-10-12 11:45:52', 5),
(13, 1, 'On Site Item 5', 'Mar', '1', 2, '600.00', '600.00', '2021-10-12 11:45:52', 5),
(14, 1, 'On Site Item 5', 'Apr', '1', 2, '600.00', '600.00', '2021-10-12 11:45:52', 5),
(15, 1, 'On Site Item 5', 'May', '1', 2, '600.00', '600.00', '2021-10-12 11:45:52', 5),
(16, 2, 'Project Item 1', 'Project payment descp 1', '100', 3, '10000.00', '10000.00', '2021-10-12 11:48:56', 6),
(17, 2, 'Project Item 2', 'Project Payment Descp 1', '50', 3, '10000.00', '5000.00', '2021-10-12 11:48:56', 7),
(18, 2, 'Project Item 2', 'Project Payment Descp 2', '50', 3, '10000.00', '5000.00', '2021-10-12 11:48:57', 7),
(19, 2, 'Project Item 3', 'Project Payment Descp 1', '35', 3, '10000.00', '3500.00', '2021-10-12 11:48:57', 8),
(20, 2, 'Project Item 3', 'Project Payment Descp 2', '35', 3, '10000.00', '3500.00', '2021-10-12 11:48:57', 8),
(21, 2, 'Project Item 3', 'Project Payment Descp 3', '30', 3, '10000.00', '3000.00', '2021-10-12 11:48:57', 8),
(22, 2, 'Project Item 4', 'Project Payment Descp 1', '25', 3, '10000.00', '2500.00', '2021-10-12 11:48:57', 9),
(23, 2, 'Project Item 4', 'Project Payment Descp 2', '25', 3, '10000.00', '2500.00', '2021-10-12 11:48:57', 9),
(24, 2, 'Project Item 4', 'Project Payment Descp 3', '25', 3, '10000.00', '2500.00', '2021-10-12 11:48:57', 9),
(25, 2, 'Project Item 4', 'Project Payment Descp 4', '25', 3, '10000.00', '2500.00', '2021-10-12 11:48:57', 9),
(26, 2, 'Project Item 5', 'Project Payment Descp 1', '20', 3, '10000.00', '2000.00', '2021-10-12 11:48:57', 10),
(27, 2, 'Project Item 5', 'Project Payment Descp 2', '20', 3, '10000.00', '2000.00', '2021-10-12 11:48:57', 10),
(28, 2, 'Project Item 5', 'Project Payment Descp 3', '20', 3, '10000.00', '2000.00', '2021-10-12 11:48:57', 10),
(29, 2, 'Project Item 5', 'Project Payment Descp 4', '20', 3, '10000.00', '2000.00', '2021-10-12 11:48:57', 10),
(30, 2, 'Project Item 5', 'Project Payment Descp 5', '20', 3, '10000.00', '2000.00', '2021-10-12 11:48:57', 10),
(31, 3, 'Amc Item 1', 'Amc Payment 1', '1', 2, '10000.00', '10000.00', '2021-10-12 11:51:46', 11),
(32, 3, 'Amc Item 2', 'Amc Payment 1', '1', 2, '5000.00', '5000.00', '2021-10-12 11:51:46', 12),
(33, 3, 'Amc Item 2', 'Amc Payment 2', '1', 2, '5000.00', '5000.00', '2021-10-12 11:51:46', 12),
(34, 3, 'Amc Item 3', 'Amc Payment 1', '1', 2, '3333.33', '3333.33', '2021-10-12 11:51:46', 13),
(35, 3, 'Amc Item 3', 'Amc Payment 2', '1', 2, '3333.33', '3333.33', '2021-10-12 11:51:46', 13),
(36, 3, 'Amc Item 3', 'Amc Payment 3', '1', 2, '3333.33', '3333.33', '2021-10-12 11:51:47', 13),
(37, 3, 'Amc Item 4', 'Amc Payment 1', '1', 2, '2500.00', '2500.00', '2021-10-12 11:51:47', 14),
(38, 3, 'Amc Item 4', 'Amc Payment 2', '1', 2, '2500.00', '2500.00', '2021-10-12 11:51:47', 14),
(39, 3, 'Amc Item 4', 'Amc Payment 3', '1', 2, '2500.00', '2500.00', '2021-10-12 11:51:47', 14),
(40, 3, 'Amc Item 4', 'Amc Payment 4', '1', 2, '2500.00', '2500.00', '2021-10-12 11:51:47', 14),
(41, 3, 'Amc Item 5', 'Amc Payment 1', '1', 2, '2000.00', '2000.00', '2021-10-12 11:51:47', 15),
(42, 3, 'Amc Item 5', 'Amc Payment 2', '1', 2, '2000.00', '2000.00', '2021-10-12 11:51:47', 15),
(43, 3, 'Amc Item 5', 'Amc Payment 3', '1', 2, '2000.00', '2000.00', '2021-10-12 11:51:47', 15),
(44, 3, 'Amc Item 5', 'Amc Payment 4', '1', 2, '2000.00', '2000.00', '2021-10-12 11:51:47', 15),
(45, 3, 'Amc Item 5', 'Amc Payment 5', '1', 2, '2000.00', '2000.00', '2021-10-12 11:51:47', 15);

CREATE TABLE `order_types` (
  `id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `order_types`;
INSERT INTO `order_types` (`id`, `title`, `status`) VALUES
(1, 'On-Site Support Sale', 1),
(2, 'Project Sale', 1),
(3, 'AMC Support Sale', 1),
(4, 'Man-days-Support Sale', 1),
(5, 'SAP License Sale', 1),
(6, 'Hardware Sale', 1),
(99, 'Multi Order', 1);

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `customer_payment_id` int NOT NULL,
  `invoice_id` int NOT NULL,
  `basic_value` decimal(10,2) NOT NULL,
  `gst_amount` decimal(10,2) NOT NULL,
  `invoice_amount` decimal(10,2) NOT NULL,
  `tds_percent` decimal(10,2) NOT NULL,
  `tds_deducted` decimal(10,2) NOT NULL,
  `receivable_amt` decimal(10,2) NOT NULL,
  `allocated_amt` decimal(10,2) NOT NULL,
  `balance_amt` decimal(10,2) NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `payments`;
CREATE TABLE `states` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL,
  `country_id` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `uom` (
  `id` int NOT NULL,
  `title` varchar(10) NOT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `uom`;
INSERT INTO `uom` (`id`, `title`, `status`) VALUES
(1, 'Day(s)', 1),
(2, 'AU', 1),
(3, 'Percentage', 1),
(4, 'PC', 1);

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(15) NOT NULL,
  `admin` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE TABLE `users`;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`, `status`, `added_date`) VALUES
(1, 'Deepak Singh', 'deepaksingh@fts-pl.com', '1', 0, 1, '2021-04-17 14:14:22'),
(2, 'JThayil', 'jones.thayil@gmail.com', '1', 0, 1, '2021-04-17 14:14:22');


ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `customer_groups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `customer_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`,`cheque_utr_no`);

ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `it_master`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`,`po_no`);

ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_payterms`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_types`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_id` (`invoice_id`);

ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `uom`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;


ALTER TABLE `company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `customer_groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `customer_payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `invoices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `invoice_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `it_master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

ALTER TABLE `order_payterms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

ALTER TABLE `order_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `states`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

ALTER TABLE `uom`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
