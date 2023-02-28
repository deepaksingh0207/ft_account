CREATE DATABASE  IF NOT EXISTS `db_account` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_account`;
-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: db_account
-- ------------------------------------------------------
-- Server version	8.0.31

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_payments`
--

LOCK TABLES `customer_payments` WRITE;
/*!40000 ALTER TABLE `customer_payments` DISABLE KEYS */;
INSERT INTO `customer_payments` VALUES (1,3,1,NULL,NULL,'2023-01-07 00:00:00','12313',100000.00,'1673088376_Blank.pdf','test',1,'2023-01-07 16:16:16','2023-01-07 16:16:16',2),(2,3,1,NULL,NULL,'2023-01-07 00:00:00','3447568',8000.00,'1673088722_Blank.pdf','',1,'2023-01-07 16:22:02','2023-01-07 16:22:02',2);
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
INSERT INTO `customers` VALUES (1,3,'Aarti Industries Pvt. Ltd.','Mangesh','27AAAAA0000A1Z5','AABCA2787L','T8-B, A-Wing, 5th Floor, Phoenix House, Phoenix Mill Compound, S. B. Marg,  Lower Parel (W) , Mumbai- 400013',NULL,22,'401107','7498456880','7498456880','7498456880','deepaksingh0207@gmail.com','test',NULL,'asdasdasdasdad','0','0',1,'2021-04-20 13:44:24','2023-01-12 11:25:03',''),(2,1,'Jay Bharat Maruti Limited','Lalit','24AAACJ2021K2Z0','VGUPF9456T','3rd 4th floor Central Plaza Mall Golf Course Road, Sector 53, Haryana Gurgugram HARYANA - 122002',NULL,12,'382130','7645342423','7645342343','7645342232','lalit@jbm.com','ccc',NULL,'','0','0',1,'2021-05-29 12:05:41','2023-01-01 14:56:40',_binary 'I/We F.T. Solutions Pvt. Ltd. do hereby declare That the aggregate turnover of \"the company computed as per\r\nSection 2/6 of Central Goods and Service Tax Act, 2017 exceed the limit prescribed for generation of an\r\nunique Invoice Registration Number(IRN) and QR code as per the provisions of Central Goods and Service Tax\r\nAct, 2017 and rules thereunder (GST Law). Accordingly we are covered or not Covered under the ambit of GST\r\ne-invoicing provisions w.e.f 1at June,2021. And therefore the invoices, debit notes, credit notes or any other\r\nprescribed document under e- invoicing issued/raised by us duly complies with the notified e-invoicing\r\nprovisions.'),(3,1,'Neel Metal TVS','Suresh','33AAACC1206D1ZN','DFRTS9878R','3rd 4th floor Central Plaza Mall Golf Course Road, Sector 53, Haryana Gurgugram HARYANA - 122002',NULL,35,'534534','2342342342','2342342342','1231243453','test@sdsd.com','test',NULL,'','0','0',1,'2021-06-09 15:28:13','2021-12-14 05:33:04',''),(4,1,'JBM AS Sanand','Manish','32AAICS2717D1ZR','DTUPD9856T','Sanand gujarat                        ',NULL,12,'382110','9876543211','','','manish@jbm.ss','wsd',NULL,'Lalit','lalit@jbm.vv','9876543212',1,'2021-06-21 15:29:46','2021-06-21 15:35:24',NULL),(5,1,'vvvv','','','','',NULL,1,'','','','','','',NULL,'','','',1,'2021-07-08 13:30:08','2021-07-08 13:30:08',NULL),(6,4,'Plasser India Private Limited(karjan)','Mr. Vimal Shah','24AAACP6670L1Z6','AAACP6670L','Plasser India Private Limited Industrial Park, Village -\r\nDethan , Plot # 10A,\r\nContrans Logistic , Ta. Karjan Dist. Vadodara-392144\r\nKarjan - 391244.',NULL,12,'391244','9874563210','8655318112','','jones.thayil@gmail.com','test',NULL,'Vimal Shah','jones.thayil@gmail.com','9874563210',1,'2022-07-05 10:23:09','2022-07-05 10:23:09',_binary 'I/We F.T. Solutions Pvt. Ltd. do hereby declare That the aggregate turnover of \"the company computed as per\r\nSection 2/6 of Central Goods and Service Tax Act, 2017 exceed the limit prescribed for generation of an\r\nunique Invoice Registration Number(IRN) and QR code as per the provisions of Central Goods and Service Tax\r\nAct, 2017 and rules thereunder (GST Law). Accordingly we are covered or not Covered under the ambit of GST\r\ne-invoicing provisions w.e.f 1at June,2021. And therefore the invoices, debit notes, credit notes or any other\r\nprescribed document under e- invoicing issued/raised by us duly complies with the notified e-invoicing\r\nprovisions.');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hsn_codes`
--

DROP TABLE IF EXISTS `hsn_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hsn_codes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(150) NOT NULL,
  `code` varchar(8) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hsn_codes`
--

LOCK TABLES `hsn_codes` WRITE;
/*!40000 ALTER TABLE `hsn_codes` DISABLE KEYS */;
INSERT INTO `hsn_codes` VALUES (1,'RFID Scanner','84711000',1,'2023-01-12 15:47:35','2023-01-22 22:32:56'),(2,'HARDWARE WEIGHBRIDGEINTEGRATION WITHSAP','84231000',1,'2023-01-12 15:47:35','2023-01-12 15:47:35'),(3,'API Charges','998313',1,'2023-01-12 15:48:14','2023-01-12 15:48:14'),(4,'Man Days Support','998313',1,'2023-01-12 15:48:14','2023-01-12 15:48:14'),(5,'Onsite / Offsite Support','998313',1,'2023-01-12 15:48:54','2023-01-12 15:48:54'),(6,'AMC for Hardware','998713',1,'2023-01-12 15:48:54','2023-01-12 15:48:54'),(7,'AMC  for Software','998713',1,'2023-01-12 15:49:23','2023-01-12 15:49:23'),(8,'Point Mobile Hand Gun','84711000',0,'2023-01-12 15:49:23','2023-01-21 14:39:36');
/*!40000 ALTER TABLE `hsn_codes` ENABLE KEYS */;
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
  `hsn_id` int DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,'Aniket Support','Dec',4,2,400000.00,NULL,400000.00,'2022-12-04 12:40:22','2022-12-07 07:14:00',1,'2022-12-01 00:00:00','2022-12-31 00:00:00'),(2,2,'Accounts portal','test',5,3,500000.00,NULL,500000.00,'2022-12-04 12:42:10','2022-12-04 12:42:10',2,NULL,NULL),(3,3,'Jan','Jan',5,2,200000.00,NULL,200000.00,'2022-12-04 12:44:47','2022-12-07 07:14:00',3,'2022-12-01 00:00:00','2022-12-31 00:00:00'),(4,4,'Man Days','test',4,1,400000.00,NULL,1600000.00,'2022-12-04 12:45:38','2022-12-04 12:45:38',4,NULL,NULL),(5,5,'Sap','Silver',4,2,400000.00,NULL,1600000.00,'2022-12-04 12:46:26','2022-12-04 12:46:26',5,NULL,NULL),(6,6,'ram','6ghz',4,4,16000.00,NULL,64000.00,'2022-12-04 12:47:29','2022-12-04 12:47:29',6,NULL,NULL),(7,7,'123','132',2,1,2.00,NULL,4.00,'2022-12-10 10:57:03','2022-12-10 10:57:03',4,NULL,NULL),(8,8,'ads','ads',2,2,2.00,NULL,2.00,'2022-12-19 11:49:55','2022-12-19 11:49:55',1,'2022-12-20 00:00:00','2022-12-22 00:00:00'),(9,9,'Pp','Pp',3,2,132000.00,NULL,132000.00,'2022-12-20 18:13:22','2022-12-20 18:13:22',1,'2022-12-01 00:00:00','2023-02-28 00:00:00'),(10,9,'Mm','Mm',3,2,132000.00,NULL,132000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23',1,'2022-12-01 00:00:00','2023-02-28 00:00:00'),(11,9,'Basis','Basis',3,2,132000.00,NULL,132000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23',1,'2022-12-01 00:00:00','2023-02-28 00:00:00'),(12,9,'Abap','Abap',3,2,132000.00,NULL,132000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23',1,'2022-12-01 00:00:00','2023-02-28 00:00:00'),(13,9,'abap','abap',3,2,132000.00,NULL,132000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23',1,'2022-12-20 00:00:00','2022-12-21 00:00:00'),(14,9,'basis','Basis',3,2,132000.00,NULL,132000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23',1,'2022-12-01 00:00:00','2023-02-28 00:00:00'),(15,10,'item No 1','Description No 1',2,2,200.00,NULL,200.00,'2022-12-22 11:51:12','2022-12-22 11:51:12',1,'2022-12-23 00:00:00','2022-12-30 00:00:00'),(16,11,'Onsite Consultant Deployment for ui5/fio ','Onsite Consultant Deployment for ui5/fio (  Prashant Tiwari',2,2,595600.00,NULL,595600.00,'2022-12-22 14:48:38','2022-12-22 14:48:38',1,'2022-12-01 00:00:00','2023-01-31 00:00:00'),(17,12,'Man Days','Man days support',20,1,6000.00,NULL,120000.00,'2022-12-22 14:58:30','2022-12-22 14:58:30',4,NULL,NULL),(18,13,'sdfsdf','sdfsd',2,2,23232.00,NULL,23232.00,'2023-01-17 12:49:14','2023-01-17 12:49:14',1,'2023-01-18 00:00:00','2023-01-19 00:00:00'),(19,13,'zxcz','zxczcx',3,2,3000.00,NULL,3000.00,'2023-01-17 12:49:14','2023-01-17 12:49:14',1,'2023-01-18 00:00:00','2023-01-19 00:00:00'),(20,14,'bhvj','bhbhb',24,1,2400.00,NULL,57600.00,'2023-01-18 15:59:20','2023-01-18 15:59:20',4,NULL,NULL),(21,14,'jhfhfggh','bjhjh',54,1,654646.00,NULL,35350884.00,'2023-01-18 15:59:20','2023-01-18 15:59:20',4,NULL,NULL),(22,14,'hello','decr',2,1,2000.00,NULL,4000.00,'2023-01-21 17:52:58','2023-01-21 17:52:58',4,NULL,NULL),(23,14,'asd','asd',1,1,1.00,NULL,1.00,'2023-01-23 15:30:38','2023-01-23 15:30:38',4,NULL,NULL),(24,14,'d','d',4,1,4.00,NULL,16.00,'2023-01-23 15:30:38','2023-01-23 15:30:38',4,NULL,NULL),(25,14,'asd','34',3,1,333.00,NULL,999.00,'2023-01-23 15:33:12','2023-01-23 15:33:12',4,NULL,NULL),(26,14,'dfdf','ssdfsdf',45,1,45.00,NULL,2025.00,'2023-01-23 15:33:53','2023-01-23 15:33:53',4,NULL,NULL),(27,14,'sdfs','fsf3',3,1,3.00,NULL,9.00,'2023-01-23 15:35:24','2023-01-23 15:35:24',4,NULL,NULL),(28,14,'sdf','sdf',23,1,23.00,NULL,529.00,'2023-01-23 15:36:17','2023-01-23 15:36:17',4,NULL,NULL),(29,12,'sdf','sdf',23,1,23.00,NULL,529.00,'2023-01-23 15:37:08','2023-01-23 15:37:08',4,NULL,NULL),(30,14,'5','5',5,1,5.00,NULL,25.00,'2023-01-23 17:29:03','2023-01-23 17:29:03',4,NULL,NULL),(31,14,'5','5',5,1,5.00,NULL,25.00,'2023-01-23 17:29:46','2023-01-23 17:29:46',4,NULL,NULL),(32,14,'6','6',6,1,6.00,NULL,36.00,'2023-01-23 17:31:28','2023-01-23 17:31:28',4,NULL,NULL),(33,14,'6','6',6,1,6.00,NULL,36.00,'2023-01-23 17:33:49','2023-01-23 17:33:49',4,NULL,NULL),(34,14,'9','9',9,1,9.00,NULL,81.00,'2023-01-23 17:36:47','2023-01-23 17:36:47',4,NULL,NULL),(35,14,'9','9',9,1,9.00,NULL,81.00,'2023-01-23 17:37:54','2023-01-23 17:37:54',4,NULL,NULL),(36,14,'9','9',9,1,9.00,NULL,81.00,'2023-01-23 17:48:20','2023-01-23 17:48:20',4,NULL,NULL),(37,14,'9','9',9,1,9.00,NULL,81.00,'2023-01-23 17:49:52','2023-01-23 17:49:52',4,NULL,NULL),(38,14,'9','9',9,1,9.00,NULL,81.00,'2023-01-23 17:50:37','2023-01-23 17:50:37',4,NULL,NULL),(39,14,'9','9',9,1,9.00,NULL,81.00,'2023-01-23 17:50:40','2023-01-23 17:50:40',4,NULL,NULL),(40,14,'23','23',23,1,23.00,NULL,529.00,'2023-01-23 17:53:02','2023-01-23 17:53:02',4,NULL,NULL),(41,14,'23','23',23,1,23.00,NULL,529.00,'2023-01-23 17:53:36','2023-01-23 17:53:36',4,NULL,NULL),(42,10,'234','234',234,1,234.00,NULL,54756.00,'2023-01-23 17:54:38','2023-01-23 17:54:38',4,NULL,NULL),(43,8,'23','23',23,1,23.00,NULL,529.00,'2023-01-23 17:55:30','2023-01-23 17:55:30',4,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_payterms`
--

LOCK TABLES `order_payterms` WRITE;
/*!40000 ALTER TABLE `order_payterms` DISABLE KEYS */;
INSERT INTO `order_payterms` VALUES (1,1,1,'Aniket Support','Dec',1,2,100000.00,100000.00,'2022-12-04 12:40:22','2022-12-04 12:40:22'),(2,1,1,'Aniket Support','Jan',1,2,100000.00,100000.00,'2022-12-04 12:40:22','2022-12-04 12:40:22'),(3,1,1,'Aniket Support','Feb',1,2,100000.00,100000.00,'2022-12-04 12:40:22','2022-12-04 12:40:22'),(4,1,1,'Aniket Support','Mar',1,2,100000.00,100000.00,'2022-12-04 12:40:22','2022-12-04 12:40:22'),(5,2,2,'Accounts portal','Advance',25,3,500000.00,125000.00,'2022-12-04 12:42:10','2022-12-04 12:42:10'),(6,2,2,'Accounts portal','Development',25,3,500000.00,125000.00,'2022-12-04 12:42:10','2022-12-04 12:42:10'),(7,2,2,'Accounts portal','Testing',25,3,500000.00,125000.00,'2022-12-04 12:42:10','2022-12-04 12:42:10'),(8,2,2,'Accounts portal','Deploy',10,3,500000.00,50000.00,'2022-12-04 12:42:10','2022-12-04 12:42:10'),(9,2,2,'Accounts portal','Mobile',15,3,500000.00,75000.00,'2022-12-04 12:42:10','2022-12-04 12:42:10'),(10,3,3,'Jan','Jan',1,2,40000.00,40000.00,'2022-12-04 12:44:47','2022-12-04 12:44:47'),(11,3,3,'Jan','Feb',1,2,40000.00,40000.00,'2022-12-04 12:44:47','2022-12-04 12:44:47'),(12,3,3,'Jan','Mar',1,2,40000.00,40000.00,'2022-12-04 12:44:47','2022-12-04 12:44:47'),(13,3,3,'Jan','Apr',1,2,40000.00,40000.00,'2022-12-04 12:44:47','2022-12-04 12:44:47'),(14,3,3,'Jan','May',1,2,40000.00,40000.00,'2022-12-04 12:44:47','2022-12-04 12:44:47'),(15,8,8,'ads','a',1,2,1.00,1.00,'2022-12-19 11:49:55','2022-12-19 11:49:55'),(16,8,8,'ads','v',1,2,1.00,1.00,'2022-12-19 11:49:55','2022-12-19 11:49:55'),(17,9,9,'Pp','Dec Pp',1,2,44000.00,44000.00,'2022-12-20 18:13:22','2022-12-20 18:13:22'),(18,9,9,'Pp','Jan Pp',1,2,44000.00,44000.00,'2022-12-20 18:13:22','2022-12-20 18:13:22'),(19,9,9,'Pp','Feb Pp',1,2,44000.00,44000.00,'2022-12-20 18:13:22','2022-12-20 18:13:22'),(20,9,10,'Mm','Dec Mm',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(21,9,10,'Mm','Jan Mm',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(22,9,10,'Mm','Feb Mm',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(23,9,11,'Basis','Dec Basis',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(24,9,11,'Basis','Jan Basis',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(25,9,11,'Basis','Feb Basis',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(26,9,12,'Abap','dec',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(27,9,12,'Abap','jan',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(28,9,12,'Abap','frb',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(29,9,13,'abap','jan',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(30,9,13,'abap','feb',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(31,9,13,'abap','mar',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(32,9,14,'basis','Jan',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(33,9,14,'basis','Feb',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(34,9,14,'basis','Mar',1,2,44000.00,44000.00,'2022-12-20 18:13:23','2022-12-20 18:13:23'),(35,10,15,'item No 1','Jancy',1,2,100.00,100.00,'2022-12-22 11:51:12','2022-12-22 11:51:12'),(36,10,15,'item No 1','Fancy',1,2,100.00,100.00,'2022-12-22 11:51:12','2022-12-22 11:51:12'),(37,11,16,'Onsite Consultant Deployment for ui5/fio ','Onsite Consultant Deployment for ui5/fio ( Dec 22) - Prashant Tiwari',1,2,297800.00,297800.00,'2022-12-22 14:48:38','2022-12-22 14:48:38'),(38,11,16,'Onsite Consultant Deployment for ui5/fio ','Onsite Consultant Deployment for ui5/fio ( Jan 23) - Prashant Tiwari',1,2,297800.00,297800.00,'2022-12-22 14:48:38','2022-12-22 14:48:38'),(39,13,18,'sdfsdf','ad',1,2,11616.00,11616.00,'2023-01-17 12:49:14','2023-01-17 12:49:14'),(40,13,18,'sdfsdf','asd',1,2,11616.00,11616.00,'2023-01-17 12:49:14','2023-01-17 12:49:14'),(41,13,19,'zxcz','sdf',1,2,1000.00,1000.00,'2023-01-17 12:49:14','2023-01-17 12:49:14'),(42,13,19,'zxcz','sdf',1,2,1000.00,1000.00,'2023-01-17 12:49:14','2023-01-17 12:49:14'),(43,13,19,'zxcz','sdf',1,2,1000.00,1000.00,'2023-01-17 12:49:14','2023-01-17 12:49:14');
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
  `disable_monitor` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`,`po_no`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,3,1,'2022-12-04 00:00:00',0,'1111111','Mangesh','1','1',1,400000,0.00,36000.00,36000.00,9.00,472000.00,'1670137822_Blank.pdf',NULL,NULL,'On Site Support',1,'2022-12-04 12:40:22','2022-12-07 10:37:56',2,0,0),(2,3,1,'2022-12-01 00:00:00',0,'2222222','Mangesh','1','1',2,500000,0.00,45000.00,45000.00,9.00,590000.00,'1670137930_Blank.pdf',NULL,NULL,'Project Sale',1,'2022-12-04 12:42:10','2022-12-04 12:42:10',2,0,0),(3,3,1,'2022-12-01 00:00:00',0,'3333333','Mangesh','1','1',3,200000,0.00,18000.00,18000.00,9.00,236000.00,'1670138087_Blank.pdf',NULL,NULL,'',1,'2022-12-04 12:44:47','2022-12-07 09:11:59',2,0,0),(4,3,1,'2022-12-01 00:00:00',0,'4444444','Mangesh','1','1',4,1600000,0.00,144000.00,144000.00,9.00,1888000.00,'1670138138_Blank.pdf',NULL,NULL,'',1,'2022-12-04 12:45:38','2022-12-04 12:45:38',2,0,0),(5,3,1,'2022-12-01 00:00:00',0,'5555555','Mangesh','1','1',5,1600000,0.00,144000.00,144000.00,9.00,1888000.00,'1670138186_Blank.pdf',NULL,NULL,'test',1,'2022-12-04 12:46:26','2022-12-04 12:46:26',2,0,0),(6,3,1,'2022-12-01 00:00:00',0,'6666666','Mangesh','1','1',6,64000,0.00,5760.00,5760.00,9.00,75520.00,'1670138249_Blank.pdf',NULL,NULL,'test',1,'2022-12-04 12:47:29','2022-12-04 12:47:29',2,0,0),(7,3,1,'2022-12-11 00:00:00',0,'1231233','Mangesh','1','1',4,4,0.00,0.36,0.36,9.00,4.72,NULL,NULL,NULL,'3',1,'2022-12-10 10:57:02','2022-12-10 10:57:02',2,1,0),(8,3,1,'2022-12-21 00:00:00',0,'6446465466','Mangesh','1','1',1,531,95.22,0.18,0.18,9.00,626.58,NULL,NULL,NULL,'',1,'2022-12-19 11:49:55','2022-12-19 11:49:55',2,1,0),(9,3,1,'2022-12-20 00:00:00',0,'45678','Mangesh','1','1',1,792000,0.00,71280.00,71280.00,9.00,934560.00,'1671540202_Blank.pdf',NULL,NULL,'',1,'2022-12-20 18:13:22','2022-12-20 18:13:22',2,0,0),(10,1,2,'2022-12-23 00:00:00',0,'1231231','Lalit','2','3',1,54956,36.00,4928.04,4928.04,18.00,64848.08,NULL,NULL,NULL,'1231232',1,'2022-12-22 11:51:12','2022-12-22 11:51:12',2,1,0),(11,4,6,'2022-12-22 00:00:00',0,'345678','Mr. Vimal Shah','6','6',1,595600,107208.00,0.00,0.00,18.00,702808.00,'1671700718_Blank.pdf',NULL,NULL,'',1,'2022-12-22 14:48:38','2022-12-22 14:48:38',2,0,0),(12,1,4,'2022-12-22 00:00:00',0,'4567890','Manish','4','4',4,120000,21600.00,0.00,0.00,18.00,141600.00,NULL,NULL,NULL,'',1,'2022-12-22 14:58:30','2022-12-22 14:58:30',2,1,0),(13,3,1,'2023-01-18 00:00:00',0,'234232432','Mangesh','1','1',1,26232,0.00,2360.88,2360.88,9.00,30953.76,NULL,NULL,NULL,'',1,'2023-01-17 12:49:14','2023-01-17 12:49:14',2,1,0),(14,3,1,'2023-01-19 00:00:00',0,'7868687668','Mangesh','1','1',4,35408484,0.00,3186763.56,3186763.56,9.00,41782011.12,NULL,NULL,NULL,'',1,'2023-01-18 15:59:20','2023-01-18 15:59:20',2,1,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,2,1,100000.00,18000.00,118000.00,10.00,10000.00,118000.00,100000.00,18000.00,1,'2023-01-07 16:16:16','2023-01-07 16:17:02',2,1),(2,2,2,NULL,100000.00,18000.00,118000.00,0.00,0.00,18000.00,8000.00,0.00,1,'2023-01-07 16:22:02','2023-01-07 16:22:02',2,1);
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
  `hsn_id` int DEFAULT NULL,
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

-- Dump completed on 2023-02-28 17:33:21
