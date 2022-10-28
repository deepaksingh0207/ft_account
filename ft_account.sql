CREATE DATABASE  IF NOT EXISTS `db_account` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_account`;
-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: db_account
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acl`
--

DROP TABLE IF EXISTS `acl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acl` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `controller` varchar(45) NOT NULL,
  `action` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=693 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl`
--

LOCK TABLES `acl` WRITE;
/*!40000 ALTER TABLE `acl` DISABLE KEYS */;
INSERT INTO `acl` VALUES (210,0,'company','getDetails'),(230,0,'payments','utr_validty'),(229,0,'orders','searchopenpo'),(228,0,'orders','search'),(227,0,'orders','po_validty'),(226,0,'orders','getSearchResult'),(225,0,'orders','getdetails'),(224,0,'orders','getOrderListByCustomer'),(223,0,'invoices','proforma_validty'),(222,0,'invoices','invoice_validty'),(221,0,'invoices','search'),(220,0,'invoices','genInvoiceNo'),(218,0,'invoices','getDetails'),(219,0,'invoices','getInvoiceIdsByCustomer'),(217,0,'invoices','preview'),(216,0,'invoices','generateInvoice'),(215,0,'invoices','getTaxesRate'),(214,0,'customers','groupCustomers'),(213,0,'customers','getDetails'),(212,0,'customergroups','groupCustomers'),(211,0,'customergroups','getDetails'),(692,1,'payments','view'),(691,1,'payments','create'),(690,1,'payments','index'),(689,1,'orders','edit'),(688,1,'orders','renew'),(687,1,'orders','openpo'),(686,1,'orders','create'),(685,1,'orders','view'),(684,1,'orders','list'),(683,1,'orders','index'),(682,1,'invoices','view'),(681,1,'invoices','create'),(680,1,'invoices','index'),(679,1,'dashboard','expiredpo'),(678,1,'dashboard','orderSummary'),(677,1,'dashboard','report'),(676,1,'dashboard','index'),(675,1,'customers','create'),(674,1,'customers','edit'),(673,1,'customers','view'),(672,1,'customers','index'),(671,1,'customergroups','create'),(670,1,'customergroups','edit'),(669,1,'customergroups','view'),(668,1,'customergroups','index'),(667,1,'company','create'),(666,1,'company','edit'),(665,1,'company','view'),(664,1,'company','index');
/*!40000 ALTER TABLE `acl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `contact` varchar(11) NOT NULL,
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
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,'F.T. Solutions Pvt. Ltd.','Deepak Singh','02228161117','9920687382','9920687382','deepaksingh@fts-pl.com','27AACCF6520B1Z4','AACCF6520B',998313,'400604','                        401, Meet Galaxy, Trimurti Lane Behind Tip Top Plaza, Teen Hath Naka, Thane 400604 Maharashtra                                        ',22,'HDFC Bank','50200029843099','HDFC0000543','2021-05-17 18:40:43','2022-01-04 10:49:04');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_groups`
--

DROP TABLE IF EXISTS `customer_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_groups`
--

LOCK TABLES `customer_groups` WRITE;
/*!40000 ALTER TABLE `customer_groups` DISABLE KEYS */;
INSERT INTO `customer_groups` VALUES (1,'FT0001','JBM',1,'2021-06-09 20:27:44','2021-06-21 21:38:44'),(3,'FT0003','Aarti',1,'2021-06-09 20:28:01','2021-06-21 21:39:02'),(4,NULL,'Plasser India',1,'2022-02-22 11:16:30','2022-02-22 11:16:39');
/*!40000 ALTER TABLE `customer_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_payments`
--

DROP TABLE IF EXISTS `customer_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `invoice_id` int DEFAULT NULL,
  `payment_date` datetime NOT NULL,
  `cheque_utr_no` varchar(50) NOT NULL,
  `received_amt` decimal(10,2) NOT NULL,
  `utr_file` varchar(255) DEFAULT NULL,
  `remarks` varchar(300) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cheque_utr_no` (`cheque_utr_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_payments`
--

LOCK TABLES `customer_payments` WRITE;
/*!40000 ALTER TABLE `customer_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
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
  `declaration` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,3,'Aarti Industries Pvt. Ltd.','Mangesh','27AAAAA0000A1Z5','AABCA2787L','201-202, Bezzola Complex, ‘A’ Wing, 2nd Floor, Sion Trombay Road, Chembur, Mumbai - 400071',NULL,22,'401107','7498456880','7498456880','7498456880','deepaksingh0207@gmail.com','test',NULL,'asdasdasdasdad','0','0',1,'2021-04-20 13:44:24','2022-08-30 10:49:51',_binary 'I/We F.T. Solutions Pvt. Ltd. do hereby declare That the aggregate turnover of \"the company computed as per\r\nSection 2/6 of Central Goods and Service Tax Act, 2017 exceed the limit prescribed for generation of an\r\nunique Invoice Registration Number(IRN) and QR code as per the provisions of Central Goods and Service Tax\r\nAct, 2017 and rules thereunder (GST Law). Accordingly we are covered or not Covered under the ambit of GST\r\ne-invoicing provisions w.e.f 1at June,2021. And therefore the invoices, debit notes, credit notes or any other\r\nprescribed document under e- invoicing issued/raised by us duly complies with the notified e-invoicing\r\nprovisions.'),(2,1,'Jay Bharat Maruti Limited','Lalit','24AAACJ2021K2Z0','VGUPF9456T','3rd 4th floor Central Plaza Mall Golf Course Road, Sector 53, Haryana Gurgugram HARYANA - 122002',NULL,12,'382130','7645342423','7645342343','7645342232','lalit@jbm.com','ccc',NULL,'','0','0',1,'2021-05-29 12:05:41','2021-12-14 05:39:17',''),(3,1,'Neel Metal TVS','Suresh','33AAACC1206D1ZN','DFRTS9878R','3rd 4th floor Central Plaza Mall Golf Course Road, Sector 53, Haryana Gurgugram HARYANA - 122002',NULL,35,'534534','2342342342','2342342342','1231243453','test@sdsd.com','test',NULL,'','0','0',1,'2021-06-09 15:28:13','2021-12-14 05:33:04',''),(4,1,'JBM AS Sanand','Manish','32AAICS2717D1ZR','DTUPD9856T','Sanand gujarat                        ',NULL,12,'382110','9876543211','','','manish@jbm.ss','wsd',NULL,'Lalit','lalit@jbm.vv','9876543212',1,'2021-06-21 15:29:46','2021-06-21 15:35:24',NULL),(5,1,'vvvv','','','','',NULL,1,'','','','','','',NULL,'','','',1,'2021-07-08 13:30:08','2021-07-08 13:30:08',NULL),(6,4,'Plasser India Private Limited(karjan)','Mr. Vimal Shah','24AAACP6670L1Z6','AAACP6670L','Plasser India Private Limited Industrial Park, Village -\r\nDethan , Plot # 10A,\r\nContrans Logistic , Ta. Karjan Dist. Vadodara-392144\r\nKarjan - 391244.',NULL,12,'391244','9874563210','8655318112','','jones.thayil@gmail.com','test',NULL,'Vimal Shah','jones.thayil@gmail.com','9874563210',1,'2022-07-05 10:23:09','2022-07-05 10:23:09',_binary 'I/We F.T. Solutions Pvt. Ltd. do hereby declare That the aggregate turnover of \"the company computed as per\r\nSection 2/6 of Central Goods and Service Tax Act, 2017 exceed the limit prescribed for generation of an\r\nunique Invoice Registration Number(IRN) and QR code as per the provisions of Central Goods and Service Tax\r\nAct, 2017 and rules thereunder (GST Law). Accordingly we are covered or not Covered under the ambit of GST\r\ne-invoicing provisions w.e.f 1at June,2021. And therefore the invoices, debit notes, credit notes or any other\r\nprescribed document under e- invoicing issued/raised by us duly complies with the notified e-invoicing\r\nprovisions.');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoice_id` int NOT NULL,
  `order_item_id` int NOT NULL,
  `order_payterm_id` int DEFAULT NULL,
  `item` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `uom_id` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `proforma_invoice_item_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_items`
--

LOCK TABLES `invoice_items` WRITE;
/*!40000 ALTER TABLE `invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `invoice_no` varchar(7) NOT NULL,
  `order_id` int NOT NULL,
  `invoice_date` datetime NOT NULL,
  `pay_days` int DEFAULT NULL,
  `po_no` varchar(20) NOT NULL,
  `sales_person` varchar(50) NOT NULL,
  `bill_to` varchar(255) NOT NULL,
  `ship_to` varchar(255) NOT NULL,
  `order_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_term` int DEFAULT NULL,
  `pay_percent` decimal(10,2) DEFAULT NULL,
  `payment_description` varchar(255) DEFAULT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `igst` decimal(10,2) NOT NULL,
  `cgst` decimal(10,2) NOT NULL,
  `sgst` decimal(10,2) NOT NULL,
  `invoice_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remarks` varchar(255) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `it_master`
--

DROP TABLE IF EXISTS `it_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `it_master` (
  `id` int NOT NULL AUTO_INCREMENT,
  `igst` float NOT NULL,
  `cgst` float NOT NULL,
  `sgst` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `it_master`
--

LOCK TABLES `it_master` WRITE;
/*!40000 ALTER TABLE `it_master` DISABLE KEYS */;
INSERT INTO `it_master` VALUES (1,18,9,9);
/*!40000 ALTER TABLE `it_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
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
  `po_to_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_payterms`
--

DROP TABLE IF EXISTS `order_payterms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_payterms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `order_item_id` int NOT NULL,
  `item` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `uom_id` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_payterms`
--

LOCK TABLES `order_payterms` WRITE;
/*!40000 ALTER TABLE `order_payterms` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_payterms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_types`
--

DROP TABLE IF EXISTS `order_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_types`
--

LOCK TABLES `order_types` WRITE;
/*!40000 ALTER TABLE `order_types` DISABLE KEYS */;
INSERT INTO `order_types` VALUES (1,'On-Site Support Sale',1),(2,'Project Sale',1),(3,'AMC Support Sale',1),(4,'Man-days-Support Sale',1),(5,'SAP License Sale',1),(6,'Hardware Sale',1),(7,'Custom',1),(99,'Multi Order',1);
/*!40000 ALTER TABLE `order_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `order_date` datetime NOT NULL,
  `pay_days` int NOT NULL DEFAULT '0',
  `po_no` varchar(20) NOT NULL,
  `sales_person` varchar(50) NOT NULL,
  `bill_to` varchar(255) NOT NULL,
  `ship_to` varchar(255) NOT NULL,
  `order_type` int NOT NULL,
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
  `status` int NOT NULL DEFAULT '1',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `open_po` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`,`po_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_payment_id` int NOT NULL,
  `invoice_id` int DEFAULT NULL,
  `proforma_id` int DEFAULT NULL,
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
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  `order_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proforma_invoice_items`
--

DROP TABLE IF EXISTS `proforma_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proforma_invoice_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `proforma_invoice_id` int NOT NULL,
  `order_item_id` int NOT NULL,
  `order_payterm_id` int DEFAULT NULL,
  `item` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `uom_id` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proforma_invoice_items`
--

LOCK TABLES `proforma_invoice_items` WRITE;
/*!40000 ALTER TABLE `proforma_invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `proforma_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proforma_invoices`
--

DROP TABLE IF EXISTS `proforma_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proforma_invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `invoice_no` varchar(7) NOT NULL,
  `order_id` int NOT NULL,
  `invoice_date` datetime NOT NULL,
  `pay_days` int DEFAULT NULL,
  `po_no` varchar(20) NOT NULL,
  `sales_person` varchar(50) NOT NULL,
  `bill_to` varchar(255) NOT NULL,
  `ship_to` varchar(255) NOT NULL,
  `order_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_term` int DEFAULT NULL,
  `pay_percent` decimal(10,2) DEFAULT NULL,
  `payment_description` varchar(255) DEFAULT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `igst` decimal(10,2) NOT NULL,
  `cgst` decimal(10,2) NOT NULL,
  `sgst` decimal(10,2) NOT NULL,
  `invoice_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remarks` varchar(255) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proforma_invoices`
--

LOCK TABLES `proforma_invoices` WRITE;
/*!40000 ALTER TABLE `proforma_invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `proforma_invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `states` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `country_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,'Andaman and Nicobar Islands',101),(2,'Andhra Pradesh',101),(3,'Arunachal Pradesh',101),(4,'Assam',101),(5,'Bihar',101),(6,'Chandigarh',101),(7,'Chhattisgarh',101),(8,'Dadra and Nagar Haveli',101),(9,'Daman and Diu',101),(10,'Delhi',101),(11,'Goa',101),(12,'Gujarat',101),(13,'Haryana',101),(14,'Himachal Pradesh',101),(15,'Jammu and Kashmir',101),(16,'Jharkhand',101),(17,'Karnataka',101),(18,'Kenmore',101),(19,'Kerala',101),(20,'Lakshadweep',101),(21,'Madhya Pradesh',101),(22,'Maharashtra',101),(23,'Manipur',101),(24,'Meghalaya',101),(25,'Mizoram',101),(26,'Nagaland',101),(27,'Narora',101),(28,'Natwar',101),(29,'Odisha',101),(30,'Paschim Medinipur',101),(31,'Pondicherry',101),(32,'Punjab',101),(33,'Rajasthan',101),(34,'Sikkim',101),(35,'Tamil Nadu',101),(36,'Telangana',101),(37,'Tripura',101),(38,'Uttar Pradesh',101),(39,'Uttarakhand',101),(40,'Vaishali',101),(41,'West Bengal',101);
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uom`
--

DROP TABLE IF EXISTS `uom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `uom` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(10) NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uom`
--

LOCK TABLES `uom` WRITE;
/*!40000 ALTER TABLE `uom` DISABLE KEYS */;
INSERT INTO `uom` VALUES (1,'Day(s)',1),(2,'Nos',1),(3,'Percentage',1),(4,'PC',1);
/*!40000 ALTER TABLE `uom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(15) NOT NULL,
  `admin` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Deepak Singh','deepaksingh@fts-pl.com','1',0,1,'2021-04-17 14:14:22','2022-03-07 11:33:08'),(2,'FT Accounts','admin@gmail.com','1',1,1,'2021-07-03 07:16:47','2022-03-11 08:55:11'),(3,'Jones Thayil','jones.thayil@gmail.com','1',0,1,'2021-04-17 14:14:22','2022-03-05 09:41:51');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'db_account'
--

--
-- Dumping routines for database 'db_account'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-28 11:44:40
