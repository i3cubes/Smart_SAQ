-- MySQL dump 10.16  Distrib 10.1.36-MariaDB, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: smart_saq
-- ------------------------------------------------------
-- Server version	10.1.36-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `saq_approvals`
--

DROP TABLE IF EXISTS `saq_approvals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_approvals` (
  `id` int(11) NOT NULL,
  `requirement` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_approvals`
--

LOCK TABLES `saq_approvals` WRITE;
/*!40000 ALTER TABLE `saq_approvals` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_approvals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_department`
--

DROP TABLE IF EXISTS `saq_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dept` varchar(45) DEFAULT NULL,
  `status` smallint(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_department`
--

LOCK TABLES `saq_department` WRITE;
/*!40000 ALTER TABLE `saq_department` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_ditrict`
--

DROP TABLE IF EXISTS `saq_ditrict`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_ditrict` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `saq_province_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_saq_ditrict_saq_province1_idx` (`saq_province_id`),
  CONSTRAINT `fk_saq_ditrict_saq_province1` FOREIGN KEY (`saq_province_id`) REFERENCES `saq_province` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_ditrict`
--

LOCK TABLES `saq_ditrict` WRITE;
/*!40000 ALTER TABLE `saq_ditrict` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_ditrict` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_ds`
--

DROP TABLE IF EXISTS `saq_ds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_ds` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_ds`
--

LOCK TABLES `saq_ds` WRITE;
/*!40000 ALTER TABLE `saq_ds` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_ds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_employee`
--

DROP TABLE IF EXISTS `saq_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `status` smallint(2) DEFAULT '1',
  `saq_department_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_saq_employee_saq_department_idx` (`saq_department_id`),
  CONSTRAINT `fk_saq_employee_saq_department` FOREIGN KEY (`saq_department_id`) REFERENCES `saq_department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_employee`
--

LOCK TABLES `saq_employee` WRITE;
/*!40000 ALTER TABLE `saq_employee` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_guideline`
--

DROP TABLE IF EXISTS `saq_guideline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_guideline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `uploaded_date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_guideline`
--

LOCK TABLES `saq_guideline` WRITE;
/*!40000 ALTER TABLE `saq_guideline` DISABLE KEYS */;
INSERT INTO `saq_guideline` VALUES (1,'Test saq upload','Testing purpose',NULL),(2,'Test saq upload','Testing purpose','2020-12-15 16:28:02'),(3,'Test saq upload','Testing purpose','2020-12-15 16:29:17'),(4,'Test saq upload','Testing purpose','2020-12-15 16:30:34'),(5,'Test','Test description','2020-12-15 21:47:05');
/*!40000 ALTER TABLE `saq_guideline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_guideline_files`
--

DROP TABLE IF EXISTS `saq_guideline_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_guideline_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `uploaded_date_time` datetime DEFAULT NULL,
  `saq_guideline_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_saq_guideline_files_saq_guideline1_idx` (`saq_guideline_id`),
  CONSTRAINT `fk_saq_guideline_files_saq_guideline1` FOREIGN KEY (`saq_guideline_id`) REFERENCES `saq_guideline` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_guideline_files`
--

LOCK TABLES `saq_guideline_files` WRITE;
/*!40000 ALTER TABLE `saq_guideline_files` DISABLE KEYS */;
INSERT INTO `saq_guideline_files` VALUES (1,'SRS_Smart SAQ_V1.0.pdf','../saq_guideline_files/1608029540556.pdf','2020-12-15 16:22:20',1),(2,'SRS_Smart SAQ_V1.0.pdf','../saq_guideline_files/1608029882259.pdf','2020-12-15 16:28:02',2),(3,'SRS_Smart SAQ_V1.0.pdf','../saq_guideline_files/1608029957915.pdf','2020-12-15 16:29:17',3),(4,'SRS_Smart SAQ_V1.0.pdf','../saq_guideline_files/1608030034773.pdf','2020-12-15 16:30:34',4),(5,'Untitled.png','../saq_guideline_files/1608048862663.png','2020-12-15 21:44:22',1),(6,'Capture.JPG','../saq_guideline_files/1608048907278.JPG','2020-12-15 21:45:07',1),(7,'Capture.JPG','../saq_guideline_files/1608049025610.JPG','2020-12-15 21:47:05',5),(8,'Untitled.png','../saq_guideline_files/1608049045617.png','2020-12-15 21:47:25',5);
/*!40000 ALTER TABLE `saq_guideline_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_la`
--

DROP TABLE IF EXISTS `saq_la`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_la` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_la`
--

LOCK TABLES `saq_la` WRITE;
/*!40000 ALTER TABLE `saq_la` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_la` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_other_operator`
--

DROP TABLE IF EXISTS `saq_other_operator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_other_operator` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_other_operator`
--

LOCK TABLES `saq_other_operator` WRITE;
/*!40000 ALTER TABLE `saq_other_operator` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_other_operator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_police_station`
--

DROP TABLE IF EXISTS `saq_police_station`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_police_station` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_police_station`
--

LOCK TABLES `saq_police_station` WRITE;
/*!40000 ALTER TABLE `saq_police_station` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_police_station` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_province`
--

DROP TABLE IF EXISTS `saq_province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_province` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_province`
--

LOCK TABLES `saq_province` WRITE;
/*!40000 ALTER TABLE `saq_province` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_province` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_region`
--

DROP TABLE IF EXISTS `saq_region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `status` smallint(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_region`
--

LOCK TABLES `saq_region` WRITE;
/*!40000 ALTER TABLE `saq_region` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_region_employee`
--

DROP TABLE IF EXISTS `saq_region_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_region_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `saq_region_id` int(11) NOT NULL,
  `saq_employee_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_saq_region_employee_saq_region1_idx` (`saq_region_id`),
  KEY `fk_saq_region_employee_saq_employee1_idx` (`saq_employee_id`),
  CONSTRAINT `fk_saq_region_employee_saq_employee1` FOREIGN KEY (`saq_employee_id`) REFERENCES `saq_employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_saq_region_employee_saq_region1` FOREIGN KEY (`saq_region_id`) REFERENCES `saq_region` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_region_employee`
--

LOCK TABLES `saq_region_employee` WRITE;
/*!40000 ALTER TABLE `saq_region_employee` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_region_employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_site_agreement_data`
--

DROP TABLE IF EXISTS `saq_site_agreement_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_site_agreement_data` (
  `id` int(11) NOT NULL,
  `agreement_status` varchar(15) DEFAULT NULL,
  `date_expire` date DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `payment_mode` varchar(45) DEFAULT NULL,
  `lease_period` varchar(45) DEFAULT NULL,
  `start_monthly_rental` float DEFAULT NULL,
  `rate_increment` float DEFAULT NULL,
  `advance_payment` float DEFAULT NULL,
  `bank_account` varchar(45) DEFAULT NULL,
  `bank_name` varchar(45) DEFAULT NULL,
  `branch_name` varchar(45) DEFAULT NULL,
  `account_type` varchar(45) DEFAULT NULL,
  `account_holder_name` varchar(45) DEFAULT NULL,
  `account_holder_nic` varchar(45) DEFAULT NULL,
  `monthly_deduction_for_adv` float DEFAULT NULL,
  `adv_recovery_period` varchar(45) DEFAULT NULL,
  `saq_sites_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_saq_site_agreement_data_saq_sites1_idx` (`saq_sites_id`),
  CONSTRAINT `fk_saq_site_agreement_data_saq_sites1` FOREIGN KEY (`saq_sites_id`) REFERENCES `saq_sites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_site_agreement_data`
--

LOCK TABLES `saq_site_agreement_data` WRITE;
/*!40000 ALTER TABLE `saq_site_agreement_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_site_agreement_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_site_approvals`
--

DROP TABLE IF EXISTS `saq_site_approvals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_site_approvals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `saq_approvals_id` int(11) NOT NULL,
  `saq_sites_id` int(11) NOT NULL,
  `available` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `fk_saq_site_approvals_saq_approvals1_idx` (`saq_approvals_id`),
  KEY `fk_saq_site_approvals_saq_sites1_idx` (`saq_sites_id`),
  CONSTRAINT `fk_saq_site_approvals_saq_approvals1` FOREIGN KEY (`saq_approvals_id`) REFERENCES `saq_approvals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_saq_site_approvals_saq_sites1` FOREIGN KEY (`saq_sites_id`) REFERENCES `saq_sites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_site_approvals`
--

LOCK TABLES `saq_site_approvals` WRITE;
/*!40000 ALTER TABLE `saq_site_approvals` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_site_approvals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_site_assesment_info`
--

DROP TABLE IF EXISTS `saq_site_assesment_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_site_assesment_info` (
  `id` int(11) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `assessment_tax` float DEFAULT NULL,
  `trade_tax` float DEFAULT NULL,
  `saq_sites_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_saq_site_assesment_info_saq_sites1_idx` (`saq_sites_id`),
  CONSTRAINT `fk_saq_site_assesment_info_saq_sites1` FOREIGN KEY (`saq_sites_id`) REFERENCES `saq_sites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_site_assesment_info`
--

LOCK TABLES `saq_site_assesment_info` WRITE;
/*!40000 ALTER TABLE `saq_site_assesment_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_site_assesment_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_site_other_operator`
--

DROP TABLE IF EXISTS `saq_site_other_operator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_site_other_operator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `saq_other_operator_id` int(11) NOT NULL,
  `saq_sites_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_saq_site_other_operator_saq_other_operator1_idx` (`saq_other_operator_id`),
  KEY `fk_saq_site_other_operator_saq_sites1_idx` (`saq_sites_id`),
  CONSTRAINT `fk_saq_site_other_operator_saq_other_operator1` FOREIGN KEY (`saq_other_operator_id`) REFERENCES `saq_other_operator` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_saq_site_other_operator_saq_sites1` FOREIGN KEY (`saq_sites_id`) REFERENCES `saq_sites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_site_other_operator`
--

LOCK TABLES `saq_site_other_operator` WRITE;
/*!40000 ALTER TABLE `saq_site_other_operator` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_site_other_operator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_site_technical`
--

DROP TABLE IF EXISTS `saq_site_technical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_site_technical` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `available` enum('Y','N') DEFAULT 'N',
  `saq_technical_id` int(11) NOT NULL,
  `saq_sites_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_saq_site_technical_saq_technical1_idx` (`saq_technical_id`),
  KEY `fk_saq_site_technical_saq_sites1_idx` (`saq_sites_id`),
  CONSTRAINT `fk_saq_site_technical_saq_sites1` FOREIGN KEY (`saq_sites_id`) REFERENCES `saq_sites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_saq_site_technical_saq_technical1` FOREIGN KEY (`saq_technical_id`) REFERENCES `saq_technical` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_site_technical`
--

LOCK TABLES `saq_site_technical` WRITE;
/*!40000 ALTER TABLE `saq_site_technical` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_site_technical` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_sites`
--

DROP TABLE IF EXISTS `saq_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `site_ownership` varchar(45) DEFAULT NULL,
  `tower_height` int(11) DEFAULT NULL,
  `building_height` int(11) DEFAULT NULL,
  `land_area` float DEFAULT NULL,
  `on_air_date` date DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lon` float DEFAULT NULL,
  `access_type` varchar(45) DEFAULT NULL,
  `manual_distance` varchar(45) DEFAULT NULL,
  `access_permission_type` varchar(45) DEFAULT NULL,
  `PG_installation_possibility` varchar(45) DEFAULT NULL,
  `LO_name` varchar(45) DEFAULT NULL,
  `LO_address` varchar(45) DEFAULT NULL,
  `LO_nic_brc` varchar(45) DEFAULT NULL,
  `LO_mobile` varchar(45) DEFAULT NULL,
  `LO_land_number` varchar(45) DEFAULT NULL,
  `contact_person_number` varchar(45) DEFAULT NULL,
  `LO_fax` varchar(45) DEFAULT NULL,
  `LO_email` varchar(45) DEFAULT NULL,
  `saq_ditrict_id` int(11) NOT NULL,
  `saq_ds_id` int(11) NOT NULL,
  `saq_la_id` int(11) NOT NULL,
  `saq_police_station_id` int(11) NOT NULL,
  `saq_region_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_saq_sites_saq_ditrict1_idx` (`saq_ditrict_id`),
  KEY `fk_saq_sites_saq_ds1_idx` (`saq_ds_id`),
  KEY `fk_saq_sites_saq_la1_idx` (`saq_la_id`),
  KEY `fk_saq_sites_saq_police_station1_idx` (`saq_police_station_id`),
  KEY `fk_saq_sites_saq_region1_idx` (`saq_region_id`),
  CONSTRAINT `fk_saq_sites_saq_ditrict1` FOREIGN KEY (`saq_ditrict_id`) REFERENCES `saq_ditrict` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_saq_sites_saq_ds1` FOREIGN KEY (`saq_ds_id`) REFERENCES `saq_ds` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_saq_sites_saq_la1` FOREIGN KEY (`saq_la_id`) REFERENCES `saq_la` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_saq_sites_saq_police_station1` FOREIGN KEY (`saq_police_station_id`) REFERENCES `saq_police_station` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_saq_sites_saq_region1` FOREIGN KEY (`saq_region_id`) REFERENCES `saq_region` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_sites`
--

LOCK TABLES `saq_sites` WRITE;
/*!40000 ALTER TABLE `saq_sites` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_technical`
--

DROP TABLE IF EXISTS `saq_technical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_technical` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `technology` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_technical`
--

LOCK TABLES `saq_technical` WRITE;
/*!40000 ALTER TABLE `saq_technical` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_technical` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_us`
--

DROP TABLE IF EXISTS `saq_us`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  `date_last_login` datetime DEFAULT NULL,
  `status` smallint(2) DEFAULT '1',
  `saq_employee_id` int(11) DEFAULT NULL,
  `saq_us_role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_saq_us_saq_employee1_idx` (`saq_employee_id`),
  KEY `fk_saq_us_saq_us_role1_idx` (`saq_us_role_id`),
  CONSTRAINT `fk_saq_us_saq_employee1` FOREIGN KEY (`saq_employee_id`) REFERENCES `saq_employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_saq_us_saq_us_role1` FOREIGN KEY (`saq_us_role_id`) REFERENCES `saq_us_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='		';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_us`
--

LOCK TABLES `saq_us` WRITE;
/*!40000 ALTER TABLE `saq_us` DISABLE KEYS */;
INSERT INTO `saq_us` VALUES (1,'admin','7e240de74fb1ed08fa08d38063f6a6a91462a815','2020-12-15 14:00:16','2020-12-15 14:00:16',1,NULL,NULL);
/*!40000 ALTER TABLE `saq_us` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_us_role`
--

DROP TABLE IF EXISTS `saq_us_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_us_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) DEFAULT NULL,
  `status` smallint(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_us_role`
--

LOCK TABLES `saq_us_role` WRITE;
/*!40000 ALTER TABLE `saq_us_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `saq_us_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-16  9:22:03
