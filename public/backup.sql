-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: palmyra
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_type` int(11) NOT NULL DEFAULT 0,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'normal',
  `account_id` bigint(20) unsigned DEFAULT NULL,
  `result_account_id` bigint(20) unsigned DEFAULT NULL,
  `final_account_id` bigint(20) unsigned DEFAULT NULL,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `ratio` double(8,2) DEFAULT NULL,
  `parity` double DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `is_warning_when_pass_max_limit` tinyint(1) NOT NULL DEFAULT 0,
  `is_client` tinyint(1) DEFAULT 0,
  `is_assembly` tinyint(1) DEFAULT 0,
  `is_distributive` tinyint(1) DEFAULT 0,
  `is_final` tinyint(1) DEFAULT 0,
  `is_normal` tinyint(1) DEFAULT 0,
  `is_credit` tinyint(1) DEFAULT 0,
  `is_debit` tinyint(1) DEFAULT 0,
  `is_both` tinyint(1) DEFAULT 0,
  `is_max_limit_credit` tinyint(1) DEFAULT 0,
  `is_max_limit_debit` tinyint(1) DEFAULT 0,
  `is_max_limit_both` tinyint(1) DEFAULT 0,
  `assembly_normal_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`assembly_normal_ids`)),
  `distributive_normal_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`distributive_normal_ids`)),
  `tax_account_id` bigint(20) unsigned DEFAULT NULL,
  `tax_ratio` double DEFAULT NULL,
  `fixed_tax` tinyint(1) DEFAULT NULL,
  `enable_tax` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accounts_code_unique` (`code`),
  UNIQUE KEY `accounts_name_unique` (`name`),
  UNIQUE KEY `accounts_foreign_name_unique` (`foreign_name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'n1','حساب عادي 1 ','Normal Account 1 ',0,'normal',NULL,NULL,11,1,0.00,0,' ',NULL,0,0,0,0,0,1,1,0,0,0,0,1,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(2,'n2','حساب عادي 2 ','Normal Account 2',0,'normal',NULL,NULL,11,1,0.00,0,' ',NULL,0,0,0,0,0,1,0,0,1,1,0,0,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(3,'n3','حساب عادي 3 ','Normal Account 3',0,'normal',1,NULL,12,1,0.00,0,' ',NULL,0,1,0,0,0,1,0,1,0,0,1,0,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(4,'n4','حساب عادي 4 ','Normal Account 4',0,'normal',1,NULL,12,1,0.00,0,' ',NULL,0,0,0,0,0,1,0,1,0,0,1,0,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(5,'n5','حساب عادي 5 ','Normal Account 5',0,'normal',4,NULL,11,1,0.00,0,' ',NULL,0,1,0,0,0,1,0,0,1,0,0,1,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(6,'n6','حساب عادي 6 ','Normal Account 6',0,'normal',2,NULL,11,1,0.00,0,' ',NULL,0,1,0,0,0,1,0,0,1,0,0,1,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(7,'n7','حساب عادي 7 ','Normal Account 7',0,'normal',2,NULL,11,1,0.00,0,' ',NULL,0,0,0,0,0,1,0,0,1,0,0,1,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(8,'n8','حساب عادي 8 ','Normal Account 8',0,'normal',7,NULL,11,1,0.00,0,' ',NULL,0,1,0,0,0,1,0,0,1,0,0,1,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(9,'n9','حساب عادي 9 ','Normal Account 9',0,'normal',7,NULL,12,1,0.00,0,' ',NULL,0,1,0,0,0,1,0,0,1,0,0,1,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(10,'f1','حساب ختامي 1 ','Final Account 1',3,'normal',NULL,NULL,NULL,1,0.00,0,' ',NULL,0,0,0,0,1,0,0,0,1,0,0,1,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(11,'f2','حساب ختامي 2 ','Final Account 2',3,'normal',NULL,NULL,NULL,1,0.00,0,' ',NULL,0,0,0,0,1,0,0,0,1,0,0,1,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(12,'f3','حساب ختامي 3 ','Final Account 3',3,'normal',NULL,11,NULL,1,0.00,0,' ',NULL,0,0,0,0,1,0,0,0,1,0,0,1,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(13,'f4','حساب ختامي 4 ','Final Account 4',3,'normal',NULL,12,NULL,1,0.00,0,' ',NULL,0,0,0,0,1,0,0,0,1,0,0,1,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(14,'f5','حساب ختامي5 ','Final Account 5',3,'normal',NULL,11,NULL,1,0.00,0,' ',NULL,0,0,0,0,1,0,1,0,0,1,0,0,'[]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(15,'a1','حساب تجميعي 1','Assembly Account 1',1,'normal',NULL,NULL,NULL,1,0.00,0,' ',NULL,0,0,1,0,0,0,1,0,0,1,0,0,'[{\"id\":3},{\"id\":5}]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(16,'a2','حساب تجميعي 2','Assembly Account 2',1,'normal',NULL,NULL,NULL,1,0.00,0,' ',NULL,0,0,1,0,0,0,1,0,0,1,0,0,'[{\"id\":6},{\"id\":9}]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(17,'a3','حساب تجميعي 3','Assembly Account 3',1,'normal',NULL,NULL,NULL,1,0.00,0,' ',NULL,0,0,1,0,0,0,1,0,0,1,0,0,'[{\"id\":6}]','[]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(18,'d1','حساب توزيعي 1 ','Distributed Account 1',2,'normal',NULL,NULL,NULL,1,0.00,0,' ',NULL,0,0,0,1,0,0,1,0,0,1,0,0,'[]','[{\"id\":3,\"ratio\":\"40%\"},{\"id\":5,\"ratio\":\"40%\"},{\"id\":6,\"ratio\":\"40%\"}]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(19,'d2','حساب توزيعي 2 ','Distributed Account 2',2,'normal',NULL,NULL,NULL,1,0.00,0,' ',NULL,0,0,0,1,0,0,1,0,0,1,0,0,'[]','[{\"id\":5,\"ratio\":\"40%\"},{\"id\":6,\"ratio\":\"40%\"}]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(20,'d3','حساب توزيعي3 ','Distributed Account3',2,'normal',NULL,NULL,NULL,1,0.00,0,' ',NULL,0,0,0,1,0,0,1,0,0,1,0,0,'[]','[{\"id\":3,\"ratio\":\"40%\"},{\"id\":8,\"ratio\":\"40%\"},{\"id\":9,\"ratio\":\"40%\"}]',NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `table` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `table_id` bigint(20) unsigned DEFAULT NULL,
  `old_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_settings`
--

DROP TABLE IF EXISTS `app_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_settings`
--

LOCK TABLES `app_settings` WRITE;
/*!40000 ALTER TABLE `app_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_groups`
--

DROP TABLE IF EXISTS `asset_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_group_id` bigint(20) unsigned DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asset_groups_code_unique` (`code`),
  UNIQUE KEY `asset_groups_name_unique` (`name`),
  UNIQUE KEY `asset_groups_foreign_name_unique` (`foreign_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_groups`
--

LOCK TABLES `asset_groups` WRITE;
/*!40000 ALTER TABLE `asset_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `asset_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_group_id` bigint(20) unsigned DEFAULT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chasseh_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_of` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_serial_number` tinyint(1) NOT NULL DEFAULT 0,
  `is_multi_quantities` tinyint(1) NOT NULL DEFAULT 0,
  `manufac_date` date DEFAULT NULL,
  `contract_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipment_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `import_license_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arrival_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warranty_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt_date` date DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `contract_date` date DEFAULT NULL,
  `customs_declaration` date DEFAULT NULL,
  `shipment_date` date DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `warranty_begining` date DEFAULT NULL,
  `warranty_ending` date DEFAULT NULL,
  `is_not_subject_to_reappraisal` tinyint(1) NOT NULL DEFAULT 0,
  `is_not_subject_to_depreciation` tinyint(1) NOT NULL DEFAULT 0,
  `depreciation_method` int(11) NOT NULL DEFAULT 0,
  `default_age_value` double(8,2) NOT NULL DEFAULT 0.00,
  `default_age` int(11) NOT NULL DEFAULT 0,
  `annual_depreciation` int(11) NOT NULL DEFAULT 0,
  `begining_data_of` date DEFAULT NULL,
  `scrap_value` int(11) NOT NULL DEFAULT 0,
  `asset_account_id` bigint(20) unsigned DEFAULT NULL,
  `depreciation_account_id` bigint(20) unsigned DEFAULT NULL,
  `accumulated_account_id` bigint(20) unsigned DEFAULT NULL,
  `expenses_account_id` bigint(20) unsigned DEFAULT NULL,
  `captial_gains_account_id` bigint(20) unsigned DEFAULT NULL,
  `captial_losses_account_id` bigint(20) unsigned DEFAULT NULL,
  `surplus_of_reappraisal_account_id` bigint(20) unsigned DEFAULT NULL,
  `deficit_of_reappraisal_account_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `assets_code_unique` (`code`),
  UNIQUE KEY `assets_name_unique` (`name`),
  UNIQUE KEY `assets_foreign_name_unique` (`foreign_name`),
  KEY `assets_asset_account_id_foreign` (`asset_account_id`),
  KEY `assets_depreciation_account_id_foreign` (`depreciation_account_id`),
  KEY `assets_accumulated_account_id_foreign` (`accumulated_account_id`),
  KEY `assets_expenses_account_id_foreign` (`expenses_account_id`),
  KEY `assets_captial_gains_account_id_foreign` (`captial_gains_account_id`),
  KEY `assets_captial_losses_account_id_foreign` (`captial_losses_account_id`),
  KEY `assets_surplus_of_reappraisal_account_id_foreign` (`surplus_of_reappraisal_account_id`),
  KEY `assets_deficit_of_reappraisal_account_id_foreign` (`deficit_of_reappraisal_account_id`),
  KEY `assets_asset_group_id_foreign` (`asset_group_id`),
  CONSTRAINT `assets_accumulated_account_id_foreign` FOREIGN KEY (`accumulated_account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `assets_asset_account_id_foreign` FOREIGN KEY (`asset_account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `assets_asset_group_id_foreign` FOREIGN KEY (`asset_group_id`) REFERENCES `asset_groups` (`id`),
  CONSTRAINT `assets_captial_gains_account_id_foreign` FOREIGN KEY (`captial_gains_account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `assets_captial_losses_account_id_foreign` FOREIGN KEY (`captial_losses_account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `assets_deficit_of_reappraisal_account_id_foreign` FOREIGN KEY (`deficit_of_reappraisal_account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `assets_depreciation_account_id_foreign` FOREIGN KEY (`depreciation_account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `assets_expenses_account_id_foreign` FOREIGN KEY (`expenses_account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `assets_surplus_of_reappraisal_account_id_foreign` FOREIGN KEY (`surplus_of_reappraisal_account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
/*!40000 ALTER TABLE `assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachmentable_id` int(11) DEFAULT NULL,
  `attachmentable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `src` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachments`
--

LOCK TABLES `attachments` WRITE;
/*!40000 ALTER TABLE `attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barcodes`
--

DROP TABLE IF EXISTS `barcodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barcodes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `barcode_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `unit_id` bigint(20) unsigned DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `barcodes_barcode_name_unique` (`barcode_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barcodes`
--

LOCK TABLES `barcodes` WRITE;
/*!40000 ALTER TABLE `barcodes` DISABLE KEYS */;
INSERT INTO `barcodes` VALUES (1,'111',1,1,'notes','2023-11-22 10:17:14','2023-11-22 10:17:14'),(2,'222',1,3,'notes','2023-11-22 10:17:14','2023-11-22 10:17:14'),(3,'333',1,3,'notes','2023-11-22 10:17:14','2023-11-22 10:17:14'),(4,'444',2,2,'notes','2023-11-22 10:17:14','2023-11-22 10:17:14'),(5,'555',3,3,'notes','2023-11-22 10:17:14','2023-11-22 10:17:14');
/*!40000 ALTER TABLE `barcodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill_addition_and_discounts`
--

DROP TABLE IF EXISTS `bill_addition_and_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_addition_and_discounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `addition_index` int(11) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `discount_ratio` double DEFAULT NULL,
  `addition` double DEFAULT NULL,
  `addition_ratio` double DEFAULT NULL,
  `account_id` bigint(20) unsigned DEFAULT NULL,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `parity` double DEFAULT NULL,
  `equivalent` double DEFAULT NULL,
  `bill_id` bigint(20) unsigned DEFAULT NULL,
  `cost_center_id` bigint(20) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_addition_and_discounts`
--

LOCK TABLES `bill_addition_and_discounts` WRITE;
/*!40000 ALTER TABLE `bill_addition_and_discounts` DISABLE KEYS */;
INSERT INTO `bill_addition_and_discounts` VALUES (1,NULL,11.1,11,11,11,1,1,21,21,2,3,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(2,NULL,22.1,22,22,22,1,1,5,1,2,2,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(3,NULL,33.1,33,33,33,1,1,21,44,2,1,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15');
/*!40000 ALTER TABLE `bill_addition_and_discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill_permission_users`
--

DROP TABLE IF EXISTS `bill_permission_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_permission_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `show_setting` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`show_setting`)),
  `print_setting` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`print_setting`)),
  `bill_template_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_permission_users`
--

LOCK TABLES `bill_permission_users` WRITE;
/*!40000 ALTER TABLE `bill_permission_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `bill_permission_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill_records`
--

DROP TABLE IF EXISTS `bill_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `index` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `unit_price` double DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `item_id` bigint(20) unsigned DEFAULT NULL,
  `gift_price` double DEFAULT NULL,
  `bill_price` double DEFAULT NULL,
  `cost_center_id` bigint(20) unsigned DEFAULT NULL,
  `bill_id` bigint(20) unsigned NOT NULL,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parity` double(200,7) DEFAULT NULL,
  `security_level` int(11) DEFAULT NULL,
  `storing_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_affects_cost_price` tinyint(1) DEFAULT 1,
  `is_discounts_affects_cost_price` tinyint(1) DEFAULT 1,
  `is_additions_affects_cost_price` tinyint(1) DEFAULT 1,
  `general_discount` double DEFAULT NULL,
  `general_addition` double DEFAULT NULL,
  `gift` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gift_unit_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gift_conversion_factor` double DEFAULT NULL,
  `store_id` bigint(20) unsigned DEFAULT NULL,
  `input_store_id` bigint(20) unsigned DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `net` double DEFAULT NULL,
  `net_without_tax` double DEFAULT NULL,
  `item_discount` double DEFAULT NULL,
  `item_discount_ratio` double DEFAULT NULL,
  `item_addition` double DEFAULT NULL,
  `item_addition_ratio` double DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `tax_ratio` double DEFAULT NULL,
  `is_input` tinyint(1) DEFAULT NULL,
  `is_output` tinyint(1) DEFAULT NULL,
  `count` double DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_quantity` double DEFAULT NULL,
  `final_store_quantity` double DEFAULT NULL,
  `conversion_factor` double DEFAULT NULL,
  `expired_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `production_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_exist_quantity` double DEFAULT NULL,
  `current_store_exist_quantity` double DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `left_bill_quantity` double DEFAULT NULL,
  `max_bill_quantity` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_records`
--

LOCK TABLES `bill_records` WRITE;
/*!40000 ALTER TABLE `bill_records` DISABLE KEYS */;
INSERT INTO `bill_records` VALUES (1,NULL,NULL,5000,NULL,1,NULL,NULL,NULL,1,1,'2020-1-1',1.0000000,1,'IN',1,1,1,NULL,NULL,NULL,NULL,NULL,1,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(2,NULL,NULL,5000,NULL,1,NULL,NULL,NULL,2,1,'2020-1-2',1.0000000,1,'IN',1,1,1,NULL,NULL,NULL,NULL,NULL,1,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(3,NULL,NULL,5,NULL,1,NULL,NULL,NULL,3,2,'2020-1-3',7000.0000000,1,'IN',1,1,1,NULL,NULL,NULL,NULL,NULL,1,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(4,NULL,NULL,10000,NULL,1,NULL,NULL,NULL,4,1,'2020-1-3',1.0000000,1,'IN',1,1,1,NULL,NULL,NULL,NULL,NULL,1,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(5,NULL,NULL,10,NULL,1,NULL,NULL,NULL,9,2,'2020-1-4',10000.0000000,3,'IN',1,1,1,NULL,NULL,NULL,NULL,NULL,1,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(6,NULL,NULL,10,NULL,1,NULL,NULL,NULL,9,2,'2020-1-5',12000.0000000,3,'IN',1,1,1,NULL,NULL,NULL,NULL,NULL,1,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(7,NULL,NULL,55,NULL,1,NULL,NULL,NULL,9,2,'2020-1-6',13000.0000000,3,'IN',1,1,1,NULL,NULL,NULL,NULL,NULL,1,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(8,NULL,NULL,110,NULL,1,NULL,NULL,NULL,4,2,'2020-1-8',12000.0000000,3,'IN',1,1,1,NULL,NULL,NULL,NULL,NULL,1,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(9,NULL,NULL,7,NULL,1,NULL,NULL,NULL,3,3,'2020-1-9',10000.0000000,3,'IN',1,1,1,NULL,NULL,NULL,NULL,NULL,1,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15');
/*!40000 ALTER TABLE `bill_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill_returned_bills`
--

DROP TABLE IF EXISTS `bill_returned_bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_returned_bills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `returned_bill_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_returned_bills`
--

LOCK TABLES `bill_returned_bills` WRITE;
/*!40000 ALTER TABLE `bill_returned_bills` DISABLE KEYS */;
/*!40000 ALTER TABLE `bill_returned_bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill_templates`
--

DROP TABLE IF EXISTS `bill_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `abbreviation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `bill_type` int(11) NOT NULL DEFAULT 0,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_items_account_lock` tinyint(1) DEFAULT 0,
  `is_items_account_show` tinyint(1) DEFAULT 0,
  `discount_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_discount_account_lock` tinyint(1) DEFAULT 0,
  `is_discount_account_show` tinyint(1) DEFAULT 0,
  `addition_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_addition_account_lock` tinyint(1) DEFAULT 0,
  `is_addition_account_show` tinyint(1) DEFAULT 0,
  `cash_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_cash_account_lock` tinyint(1) DEFAULT 0,
  `is_cash_account_show` tinyint(1) DEFAULT 0,
  `tax_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_tax_account_lock` tinyint(1) DEFAULT 0,
  `is_tax_account_show` tinyint(1) DEFAULT 0,
  `cost_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_cost_account_lock` tinyint(1) DEFAULT 0,
  `is_cost_account_show` tinyint(1) DEFAULT 0,
  `stock_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_stock_account_lock` tinyint(1) DEFAULT 0,
  `is_stock_account_show` tinyint(1) DEFAULT 0,
  `gifts_account_id` bigint(20) unsigned DEFAULT NULL,
  `gifts_contra_account_id` bigint(20) unsigned DEFAULT NULL,
  `input_items_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_input_items_account_lock` tinyint(1) DEFAULT 0,
  `is_input_items_account_show` tinyint(1) DEFAULT 0,
  `input_discount_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_input_discount_account_lock` tinyint(1) DEFAULT 0,
  `is_input_discount_account_show` tinyint(1) DEFAULT 0,
  `input_addition_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_input_addition_account_lock` tinyint(1) DEFAULT 0,
  `is_input_addition_account_show` tinyint(1) DEFAULT 0,
  `input_cash_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_input_cash_account_lock` tinyint(1) DEFAULT 0,
  `is_input_cash_account_show` tinyint(1) DEFAULT 0,
  `input_tax_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_input_tax_account_lock` tinyint(1) DEFAULT 0,
  `is_input_tax_account_show` tinyint(1) DEFAULT 0,
  `input_cost_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_input_cost_account_lock` tinyint(1) DEFAULT 0,
  `is_input_cost_account_show` tinyint(1) DEFAULT 0,
  `input_stock_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_input_stock_account_lock` tinyint(1) DEFAULT 0,
  `is_input_stock_account_show` tinyint(1) DEFAULT 0,
  `input_gifts_account_id` bigint(20) unsigned DEFAULT NULL,
  `input_gifts_contra_account_id` bigint(20) unsigned DEFAULT NULL,
  `is_generate_entry` tinyint(1) DEFAULT 0,
  `is_auto_posting_to_accounts` tinyint(1) DEFAULT 0,
  `is_perpetual_inventory` tinyint(1) DEFAULT 0,
  `is_consider_gifts_from_sales` tinyint(1) DEFAULT 0,
  `is_affects_cost_price` tinyint(1) DEFAULT 0,
  `is_discounts_affects_cost_price` tinyint(1) DEFAULT 0,
  `is_additions_affects_cost_price` tinyint(1) DEFAULT 0,
  `is_auto_posting_to_stores` tinyint(1) DEFAULT 0,
  `is_use_VAT_system` tinyint(1) DEFAULT 0,
  `is_use_TTC_system` tinyint(1) DEFAULT 0,
  `is_use_sales_tax` tinyint(1) DEFAULT 0,
  `is_calculate_before_discounts` tinyint(1) DEFAULT 0,
  `is_calculate_before_additions` tinyint(1) DEFAULT 0,
  `is_apply_taxes_on_gifts` tinyint(1) DEFAULT 0,
  `is_consider_TTC_differences_as_sales_or_purchases` tinyint(1) DEFAULT 0,
  `is_addtions_affect_output` tinyint(1) DEFAULT 0,
  `is_additions_affect_input` tinyint(1) DEFAULT 0,
  `is_discounts_affect_output` tinyint(1) DEFAULT 0,
  `is_discounts_affect_input` tinyint(1) DEFAULT 0,
  `is_affects_item_profits_and_losses` tinyint(1) DEFAULT 0,
  `is_discount_affect_profits_and_losses` tinyint(1) DEFAULT 0,
  `is_addition_affect_profits_and_losses` tinyint(1) DEFAULT 0,
  `is_general_discount_is_affected_by_total_items` tinyint(1) DEFAULT 0,
  `is_general_addition_is_affected_by_total_items` tinyint(1) DEFAULT 0,
  `is_client_discount` tinyint(1) DEFAULT 0,
  `is_item_discount` tinyint(1) DEFAULT 0,
  `bill_price_id` bigint(20) unsigned DEFAULT NULL,
  `is_bill_price_lock` tinyint(1) DEFAULT 0,
  `is_bill_price_show` tinyint(1) DEFAULT 0,
  `cost_price_id` bigint(20) unsigned DEFAULT NULL,
  `is_cost_price_lock` tinyint(1) DEFAULT 0,
  `is_cost_price_show` tinyint(1) DEFAULT 0,
  `gifts_price_id` bigint(20) unsigned DEFAULT NULL,
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  `is_branch_show` tinyint(1) DEFAULT 0,
  `cost_center_id` bigint(20) unsigned DEFAULT NULL,
  `is_cost_center_lock` tinyint(1) DEFAULT 0,
  `is_cost_center_show` tinyint(1) DEFAULT 0,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `is_currency_lock` tinyint(1) DEFAULT 0,
  `is_currency_show` tinyint(1) DEFAULT 0,
  `return_bill_id` int(11) DEFAULT 0,
  `date` date DEFAULT NULL,
  `is_date_lock` tinyint(1) DEFAULT 0,
  `is_date_show` tinyint(1) DEFAULT 0,
  `time` time DEFAULT NULL,
  `is_time_show` tinyint(1) DEFAULT 0,
  `payment_type` int(11) DEFAULT 0,
  `is_payment_type_lock` tinyint(1) DEFAULT 0,
  `is_payment_type_show` tinyint(1) DEFAULT 0,
  `receipt_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_receipt_number_show` tinyint(1) DEFAULT 0,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  `is_client_lock` tinyint(1) DEFAULT 0,
  `is_client_show` tinyint(1) DEFAULT 0,
  `store_id` bigint(20) unsigned DEFAULT NULL,
  `is_store_lock` tinyint(1) DEFAULT 0,
  `is_store_show` tinyint(1) DEFAULT 0,
  `input_store_id` bigint(20) unsigned DEFAULT NULL,
  `is_input_store_lock` tinyint(1) DEFAULT 0,
  `is_input_store_show` tinyint(1) DEFAULT 0,
  `is_client` tinyint(1) DEFAULT 0,
  `is_cost_center` tinyint(1) DEFAULT 0,
  `is_fix_purchases_bill` tinyint(1) DEFAULT 0,
  `is_receipt_number` tinyint(1) DEFAULT 0,
  `is_fix_sales_invoice` tinyint(1) DEFAULT 0,
  `is_negative_output` tinyint(1) DEFAULT 0,
  `is_sale_less_than_cost_price` tinyint(1) DEFAULT 0,
  `is_changing_store` tinyint(1) DEFAULT 0,
  `is_changing_price` tinyint(1) DEFAULT 0,
  `is_client_has_discount` tinyint(1) DEFAULT 0,
  `is_item_is_expired` tinyint(1) DEFAULT 0,
  `is_item_has_discount` tinyint(1) DEFAULT 0,
  `is_use_payment_terms` tinyint(1) DEFAULT 0,
  `is_print_duplicated_copy` tinyint(1) DEFAULT 0,
  `is_sales` tinyint(1) DEFAULT 0,
  `is_purchases` tinyint(1) DEFAULT 0,
  `is_sales_return` tinyint(1) DEFAULT 0,
  `is_purchasing_return` tinyint(1) DEFAULT 0,
  `is_exchange` tinyint(1) DEFAULT 0,
  `is_output_store` tinyint(1) DEFAULT 0,
  `is_input_store` tinyint(1) DEFAULT 0,
  `is_beginning_inventory` tinyint(1) DEFAULT 0,
  `is_cash` tinyint(1) DEFAULT 0,
  `is_on_credit` tinyint(1) DEFAULT 0,
  `is_up` tinyint(1) DEFAULT 0,
  `is_down` tinyint(1) DEFAULT 0,
  `is_round` tinyint(1) DEFAULT 0,
  `is_none` tinyint(1) DEFAULT 0,
  `is_bill_value` tinyint(1) DEFAULT 0,
  `is_item_value` tinyint(1) DEFAULT 0,
  `is_both` tinyint(1) DEFAULT 0,
  `is_use_rounding` tinyint(1) DEFAULT 0,
  `round_type` int(11) DEFAULT 0,
  `value` int(11) DEFAULT 0,
  `rounding_on_type` int(11) DEFAULT 0,
  `rounding_account` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bill_templates_abbreviation_unique` (`abbreviation`),
  UNIQUE KEY `bill_templates_name_unique` (`name`),
  UNIQUE KEY `bill_templates_foreign_name_unique` (`foreign_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_templates`
--

LOCK TABLES `bill_templates` WRITE;
/*!40000 ALTER TABLE `bill_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `bill_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `storing_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt_number` int(11) DEFAULT NULL,
  `account_id` bigint(20) unsigned DEFAULT NULL,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `parity` double(200,7) DEFAULT NULL,
  `bill_price_id` int(11) DEFAULT NULL,
  `security_level` int(11) DEFAULT NULL,
  `bill_template_id` bigint(20) unsigned DEFAULT NULL,
  `cost_center_id` bigint(20) unsigned DEFAULT NULL,
  `input_store_id` bigint(20) unsigned DEFAULT NULL,
  `store_id` bigint(20) unsigned DEFAULT NULL,
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  `discount_value` double DEFAULT NULL,
  `addition_value` double DEFAULT NULL,
  `best_choice_for_addition_discount` double DEFAULT NULL,
  `bill_value` double DEFAULT NULL,
  `first_pay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_pay_rest` double DEFAULT NULL,
  `items_account_id` bigint(20) unsigned DEFAULT NULL,
  `cash_account_id` bigint(20) unsigned DEFAULT NULL,
  `payment_type` double DEFAULT NULL,
  `total_items` double DEFAULT NULL,
  `total_item_addition` double DEFAULT NULL,
  `total_item_discount` double DEFAULT NULL,
  `total_items_net` double DEFAULT NULL,
  `has_returned_bill` tinyint(1) DEFAULT 0,
  `source_bill_id` int(11) DEFAULT NULL,
  `has_source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `max_quantity` double DEFAULT NULL,
  `left_quantity` double DEFAULT NULL,
  `is_input` tinyint(1) DEFAULT NULL,
  `is_output` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
INSERT INTO `bills` VALUES (1,'IN','in','2020-1-1',NULL,NULL,NULL,1,1.0000000,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'0',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(2,'IN','in','2020-1-2',NULL,NULL,NULL,1,1.0000000,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'0',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(3,'IN','in','2020-1-3',NULL,NULL,NULL,2,7000.0000000,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'0',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(4,'IN','in','2020-1-3',NULL,NULL,NULL,1,1.0000000,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'0',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(5,'IN','in','2020-1-4',NULL,NULL,NULL,2,10000.0000000,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'0',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(6,'IN','in','2020-1-5',NULL,NULL,NULL,2,12000.0000000,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'0',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(7,'IN','in','2020-1-6',NULL,NULL,NULL,2,13000.0000000,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'0',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(8,'IN','in','2020-1-7',NULL,NULL,NULL,2,13000.0000000,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'0',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(9,'IN','in','2020-1-9',NULL,NULL,NULL,3,10000.0000000,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'0',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:15','2023-11-22 10:17:15');
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  `responsibility` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'branch',
  `is_root` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `branches_email_unique` (`email`),
  KEY `branches_branch_id_foreign` (`branch_id`),
  CONSTRAINT `branches_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branches`
--

LOCK TABLES `branches` WRITE;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` VALUES (1,'1','الفرع الرئيسي','Main Branch',NULL,'','','mainbranch.com','mainbranch@gmail.com','041877645','0994848736','notes ','branch',1,1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(2,'101','الفرع 1','branch 1',1,'','','branch1.com','branch1@gmail.com','0412088635','0948943236','notes 1 ','branch',0,1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(3,'102','الفرع 2','branch 2',2,'','','branch2.com','branch2@gmail.com','043325645','0093648736','notes 2','branch',0,1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(4,'10101','الفرع 3 ','branch 3',2,'','','branch3.com','branch3@gmail.com','041878875','09940935736','notes 3','branch',0,1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(5,'B9','الفرع 4','branch 4',2,'','','branch4.com','brancwqfh4@gmail.com','041078875','09944935736','notes 4','branch',0,1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(6,'133','الفرع 5','branch 5',1,'','','branch5.com','branchece5@gmail.com','04107855875','09944449','notes 5','branch',0,1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(7,'13436','الفرع 6','branch 6',5,'','','branch5.com','branwdwech5@gmail.com','04107855875','09944449','notes 6 ','branch',0,1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(8,'13336','الفرع 7','branch 7',5,'','','branch5.com','branvvrch5@gmail.com','04107855875','09944449','notes 7','branch',0,1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(9,'132236','الفرع 8 ','branch 8',7,'','','branch5.com','branvvch5@gmail.com','04107855875','09944449','notes 8','branch',0,1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(10,'1232336','الفرع 9','branch 9',7,'','','branch5.com','brancrrh5@gmail.com','04107855875','09944449','notes 9','branch',0,1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(11,'13362332','الفرع 11','branch 11',9,'','','branch5.com','brarrnch5@gmail.com','04107855875','09944449','notes 11','branch',0,1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(12,'133232036','الفرع 12','branch 12',9,'','','branch5.com','brranch5@gmail.com','04107855875','09944449','notes 12','branch',0,1,'2023-11-22 10:17:00','2023-11-22 10:17:00');
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'category',
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_category_id_foreign` (`category_id`),
  CONSTRAINT `categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'category 1','11111','الصنف الأول','category',NULL,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(2,'category 2','2222222','الصنف الثاني','category',NULL,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(3,'category 3','33333333','الصنف الثالث','category',1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(4,'category 4','444444','الصنف الرابع','category',3,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(5,'category 5','55555','الصنف الخامس','category',4,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(6,'category 6','666666','الصنف السادس','category',5,'2023-11-22 10:17:00','2023-11-22 10:17:00');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_ratio` double(8,2) DEFAULT NULL,
  `discount_account_id` bigint(20) unsigned DEFAULT NULL,
  `account_id` bigint(20) unsigned DEFAULT NULL,
  `notes_client` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_id` bigint(20) unsigned DEFAULT NULL,
  `payment` int(11) NOT NULL DEFAULT 0,
  `is_customer` tinyint(1) DEFAULT 0,
  `is_vendor` tinyint(1) DEFAULT 0,
  `is_both_client` tinyint(1) DEFAULT 0,
  `gender` int(11) NOT NULL DEFAULT 0,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `record_date` date DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,NULL,'client1',NULL,NULL,0.00,NULL,5,NULL,1,0,1,0,0,0,NULL,NULL,NULL,NULL,'2000-01-12','lattakia',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(2,NULL,NULL,NULL,NULL,34.00,NULL,8,NULL,5,0,0,1,0,0,NULL,NULL,NULL,NULL,NULL,'homs',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(3,NULL,NULL,NULL,NULL,51.00,NULL,6,NULL,3,0,0,1,0,0,NULL,NULL,NULL,NULL,NULL,'tartos',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(4,NULL,NULL,NULL,NULL,77.00,NULL,9,NULL,2,0,0,1,0,0,NULL,NULL,NULL,NULL,NULL,'lattakia',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(5,NULL,NULL,NULL,NULL,100.00,NULL,3,NULL,2,0,0,1,0,0,NULL,NULL,NULL,NULL,NULL,'lattakia',NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_information`
--

DROP TABLE IF EXISTS `company_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_information` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_number` int(11) DEFAULT NULL,
  `commercial_certificate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manufactured_certificate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_information_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_information`
--

LOCK TABLES `company_information` WRITE;
/*!40000 ALTER TABLE `company_information` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cost_centers`
--

DROP TABLE IF EXISTS `cost_centers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cost_centers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_type` int(11) NOT NULL DEFAULT 0,
  `is_normal` tinyint(1) NOT NULL DEFAULT 0,
  `is_assembly` tinyint(1) NOT NULL DEFAULT 0,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost_center_id` bigint(20) unsigned DEFAULT NULL,
  `assembly_normal_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`assembly_normal_ids`)),
  `balance` int(11) DEFAULT 0,
  `credit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'normal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cost_centers_code_unique` (`code`),
  UNIQUE KEY `cost_centers_name_unique` (`name`),
  UNIQUE KEY `cost_centers_foreign_name_unique` (`foreign_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cost_centers`
--

LOCK TABLES `cost_centers` WRITE;
/*!40000 ALTER TABLE `cost_centers` DISABLE KEYS */;
INSERT INTO `cost_centers` VALUES (1,'011','مركز الكلفة 1','Cost Center 1',0,1,0,NULL,NULL,NULL,0,NULL,NULL,'normal','2023-11-22 10:17:14','2023-11-22 10:17:14'),(2,'012','مركز الكلفة 2','Cost Center 2',0,1,0,NULL,1,NULL,0,NULL,NULL,'normal','2023-11-22 10:17:14','2023-11-22 10:17:14'),(3,'013','مركز الكلفة 3','Cost Center 3',0,1,0,NULL,2,NULL,0,NULL,NULL,'normal','2023-11-22 10:17:14','2023-11-22 10:17:14'),(4,'014','مركز الكلفة 4','Cost Center 4',0,1,0,NULL,1,NULL,0,NULL,NULL,'normal','2023-11-22 10:17:14','2023-11-22 10:17:14'),(5,'015','مركز الكلفة 5','Cost Center 5',0,1,0,NULL,4,NULL,0,NULL,NULL,'normal','2023-11-22 10:17:14','2023-11-22 10:17:14'),(6,'016','مركز الكلفة 6','Cost Center 6',0,1,0,NULL,5,NULL,0,NULL,NULL,'normal','2023-11-22 10:17:14','2023-11-22 10:17:14'),(7,'0166','مركز الكلفة التجميعي 1','Assembly Cost Center 1',1,0,1,NULL,NULL,'[{\"id\":3}]',0,NULL,NULL,'normal','2023-11-22 10:17:14','2023-11-22 10:17:14'),(8,'0167','مركز الكلفة التجميعي 2','Assembly Cost Center 2',1,0,1,NULL,NULL,'[{\"id\":3},{\"id\":5}]',0,NULL,NULL,'normal','2023-11-22 10:17:14','2023-11-22 10:17:14');
/*!40000 ALTER TABLE `cost_centers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parity` double(20,10) DEFAULT NULL,
  `equivalent` double(20,10) DEFAULT NULL,
  `proportion` int(11) DEFAULT 0,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `decimal_places` int(11) DEFAULT 0,
  `reminder_of_exchange_rates_changing_daily` tinyint(1) DEFAULT 0,
  `is_currency_reminder_active` tinyint(1) NOT NULL DEFAULT 0,
  `part_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foreign_part_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1,'دولار','$','dolar',1.0000000000,1.0000000000,0,1,0,0,0,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(2,'ليرة','SP','ssss',13000.0000000000,0.0000769231,0,0,0,0,0,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(3,'درهم','UAE','UUU',10000.0000000000,0.0001000000,0,0,0,0,0,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency_activities`
--

DROP TABLE IF EXISTS `currency_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `parity` double(20,10) DEFAULT NULL,
  `last_update_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency_activities`
--

LOCK TABLES `currency_activities` WRITE;
/*!40000 ALTER TABLE `currency_activities` DISABLE KEYS */;
INSERT INTO `currency_activities` VALUES (1,1,1.0000000000,'2020-01-01','2023-11-22 10:17:15','2023-11-22 10:17:15'),(2,2,10000.0000000000,'2020-01-03','2023-11-22 10:17:15','2023-11-22 10:17:15'),(3,2,12000.0000000000,'2020-01-05','2023-11-22 10:17:15','2023-11-22 10:17:15'),(4,3,10000.0000000000,'2020-01-07','2023-11-22 10:17:15','2023-11-22 10:17:15'),(5,2,13000.0000000000,'2020-01-09','2023-11-22 10:17:15','2023-11-22 10:17:15');
/*!40000 ALTER TABLE `currency_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `default_currencies`
--

DROP TABLE IF EXISTS `default_currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `default_currencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proportion` int(11) DEFAULT NULL,
  `parity` double(20,10) DEFAULT 1.0000000000,
  `equivalent` double(20,10) DEFAULT NULL,
  `part_name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `part_name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foreign_part_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `default_currencies_foreign_name_unique` (`foreign_name`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `default_currencies`
--

LOCK TABLES `default_currencies` WRITE;
/*!40000 ALTER TABLE `default_currencies` DISABLE KEYS */;
INSERT INTO `default_currencies` VALUES (1,'ليرة سورية','Syrian Pound','ل.س.','SYP','Syrian Pound',100,0.0000000000,0.0000000000,'قرش','Piastre','Piastre','2023-11-22 10:17:14','2023-11-22 10:17:14'),(2,'دينار أردني','Jordanian Dinar','د.أ.','JOD','Jordanian Dinar',100,0.0000000000,0.0000000000,'قرش','Piastre','Piastre','2023-11-22 10:17:14','2023-11-22 10:17:14'),(3,'درهم إماراتي','UAE Dirham','د.هـ.','AED','UAE Dirham',100,0.0000000000,0.0000000000,'فلس','Fils','Fils','2023-11-22 10:17:14','2023-11-22 10:17:14'),(4,'ريال عماني','Omani Rial','ر.ع.','OMR','Omani Rial',1000,0.0000000000,0.0000000000,'بيسة','Baisa','Baisa','2023-11-22 10:17:14','2023-11-22 10:17:14'),(5,'دينار كويتي','Kuwaiti Dinar','د.كـ.','KWD','Kuwaiti Dinar',1000,0.0000000000,0.0000000000,'فلس','Fils','Fils','2023-11-22 10:17:14','2023-11-22 10:17:14'),(6,'ريال سعودي','Saudi Riyal','ر.س.','SAR','Saudi Riyal',100,0.0000000000,0.0000000000,'هللة','Halalat','Halalat','2023-11-22 10:17:14','2023-11-22 10:17:14'),(7,'دينار عراقي','Iraq Dinar','د.ع.','IQD','Iraq Dinar',1000,0.0000000000,0.0000000000,'فلس','Fils','Fils','2023-11-22 10:17:14','2023-11-22 10:17:14'),(8,'ليرة لبنانية','Lebanon Pound','ل.ل.','LBP','Lebanon Pound',100,0.0000000000,0.0000000000,'قرش','Piastre','Piastre','2023-11-22 10:17:14','2023-11-22 10:17:14'),(9,'دينار بحريني','Bahraini Dinar','د.ب.','BHD','Bahraini Dinar',1000,0.0000000000,0.0000000000,'فلس','Fils','Fils','2023-11-22 10:17:14','2023-11-22 10:17:14'),(10,'ريال قطري','Qatari Riyal','ر.ق.','QAR','Qatari Riyal',100,0.0000000000,0.0000000000,'درهم','Dirham','Dirham','2023-11-22 10:17:14','2023-11-22 10:17:14'),(11,'ريال يمني','Yemen Riyal','ر.ي.','YER','Yemen Riyal',100,0.0000000000,0.0000000000,'فلس','Fils','Fils','2023-11-22 10:17:14','2023-11-22 10:17:14'),(12,'جنيه مصري','Egypt Pound','ج.م.','EGP','Egypt Pound',100,0.0000000000,0.0000000000,'قرش','Piastre','Piastre','2023-11-22 10:17:14','2023-11-22 10:17:14'),(13,'دينار جزائري','Algerian Dinar','د.ج.','DZD','Algerian Dinar',100,0.0000000000,0.0000000000,'سنتيم','Santeem','Santeem','2023-11-22 10:17:14','2023-11-22 10:17:14'),(14,'دينار ليبي','Libyan Dinar','د.ل.','LYD','Libyan Dinar',1000,0.0000000000,0.0000000000,'درهم','Dirham','Dirham','2023-11-22 10:17:14','2023-11-22 10:17:14'),(15,'شلن صومالي','Somali Shilling','SH','SH','Somali Shilling',100,0.0000000000,0.0000000000,'سنت','Senti','Senti','2023-11-22 10:17:14','2023-11-22 10:17:14'),(16,'دينار تونسي','Tunisian Dinar','د.ت.','MAD','Tunisian Dinar',100,0.0000000000,0.0000000000,'مليم','Millime','Millime','2023-11-22 10:17:14','2023-11-22 10:17:14'),(17,'ريال إيراني','Iranian Rial','ر.إ.','IRR','Iranian Rial',100,0.0000000000,0.0000000000,'دينار','Dinar','Dinar','2023-11-22 10:17:14','2023-11-22 10:17:14'),(18,'جنيه سوداني','Sudanese pound','ج.س.','SDG','Sudanese pound',100,0.0000000000,0.0000000000,'قرش','Piastre','Piastre','2023-11-22 10:17:14','2023-11-22 10:17:14'),(19,'دولار أمريكي','US Dollar','$','$','US Dollar',100,0.0000000000,0.0000000000,'سنت','Cent','Cent','2023-11-22 10:17:14','2023-11-22 10:17:14'),(20,'يورو','Euro','€','€','Euro',100,0.0000000000,0.0000000000,'سنت','Santه','Santه','2023-11-22 10:17:14','2023-11-22 10:17:14'),(21,'ليرة تركية','Turkish Lira','₺','₺','Turkish Lira',100,0.0000000000,0.0000000000,'قرش','Piastre','Piastre','2023-11-22 10:17:14','2023-11-22 10:17:14'),(22,'روبل روسي','Russian Ruble','₽','₽','Russian Ruble',100,0.0000000000,0.0000000000,'كوبك','Kopek','Kopek','2023-11-22 10:17:14','2023-11-22 10:17:14'),(23,'جنيه إسترليني','British Pound','£','£','British Pound',100,0.0000000000,0.0000000000,'بنس','Penny','Penny','2023-11-22 10:17:14','2023-11-22 10:17:14'),(24,'راند جنوب أفريقي','South African Rand','R','R','South African Rand',100,0.0000000000,0.0000000000,'سنت','Cent','Cent','2023-11-22 10:17:14','2023-11-22 10:17:14'),(25,'يوان صيني','YUAN PRC','₺','₺','YUAN PRC',100,0.0000000000,0.0000000000,'سنت','Cent','Cent','2023-11-22 10:17:14','2023-11-22 10:17:14');
/*!40000 ALTER TABLE `default_currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `default_prices`
--

DROP TABLE IF EXISTS `default_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `default_prices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `default_prices`
--

LOCK TABLES `default_prices` WRITE;
/*!40000 ALTER TABLE `default_prices` DISABLE KEYS */;
INSERT INTO `default_prices` VALUES (1,'بدون','None','بدون','None','none','2023-11-22 10:17:14','2023-11-22 10:17:14'),(2,'آخر شراء','Last Purchase','آخر شراء','Last Purchase','last_purchase','2023-11-22 10:17:14','2023-11-22 10:17:14'),(3,'الجملة','wholesale','الجملة','wholesale','wholesale','2023-11-22 10:17:14','2023-11-22 10:17:14'),(4,'نصف الجملة','Semi wholesale','نصف الجملة','Semi wholesale','semi_wholesale','2023-11-22 10:17:14','2023-11-22 10:17:14'),(5,'التصدير','Export','التصدير','Export','export','2023-11-22 10:17:14','2023-11-22 10:17:14'),(6,'الموزع','Distributer','الموزع','Distributer','distributer','2023-11-22 10:17:14','2023-11-22 10:17:14'),(7,'المفرق','Retail ','المفرق','Retail','retail','2023-11-22 10:17:14','2023-11-22 10:17:14'),(8,'المستهلك','Consumer ','المستهلك','Consumer','consumer','2023-11-22 10:17:14','2023-11-22 10:17:14'),(9,'آخر مبيع للزبون ','Last customer price','آخر مبيع للزبون','Last customer price','last_customer_price','2023-11-22 10:17:14','2023-11-22 10:17:14'),(10,'سعر بطاقة الزبون ','Customer price','سعر بطاقة الزبون','Customer price','customer_price','2023-11-22 10:17:14','2023-11-22 10:17:14'),(11,'آخر شراء مع الحسميات والإضافات','Last price with discount and addition','آخر شراء مع الحسميات والإضافات','Last price with discount and addition','last_price_with_discount_and_addition','2023-11-22 10:17:14','2023-11-22 10:17:14');
/*!40000 ALTER TABLE `default_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` bigint(20) unsigned DEFAULT NULL,
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'department',
  `is_root` tinyint(1) NOT NULL DEFAULT 0,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `departments_department_id_foreign` (`department_id`),
  KEY `departments_branch_id_foreign` (`branch_id`),
  CONSTRAINT `departments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `departments_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_tasks`
--

DROP TABLE IF EXISTS `employee_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_tasks`
--

LOCK TABLES `employee_tasks` WRITE;
/*!40000 ALTER TABLE `employee_tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `father_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_place` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_type` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_card_no` int(11) DEFAULT NULL,
  `id_card_issued_by` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnostics` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_no` int(11) DEFAULT NULL,
  `is_smoker` tinyint(1) DEFAULT NULL,
  `marital_status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `children_no` int(11) DEFAULT NULL,
  `partner_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partner_work` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_work` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_work` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile1` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education_level` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialization` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issued_by` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issued_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificate1` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date1` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificate2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificate3` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date3` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leave_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leave_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill1` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill3` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill4` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill5` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill6` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_issued_by` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_issued_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_expired_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_license_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_license_issued_by` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_license_issued_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_license_expired_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residence_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residence_issued_by` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residence_issued_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residence_expired_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `health_insurance_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `health_insurance_company` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `health_insurance_type` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `health_insurance_issued_by` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `health_insurance_issued_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visa_munber` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visa_entry_port` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visa_issued_by` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_root` tinyint(1) NOT NULL DEFAULT 0,
  `visa_issued_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visa_expired_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visa_entry_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'employee',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imageable_id` int(11) DEFAULT NULL,
  `imageable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manuf_company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_of_origin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caliber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chemical_composition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'item',
  `parity` double DEFAULT NULL,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `auto_discount_on_salse` double DEFAULT 0,
  `added_value_tax` double DEFAULT 0,
  `auto_counting_for_prices` tinyint(1) DEFAULT NULL,
  `expired_date` tinyint(1) DEFAULT NULL,
  `serial_number` tinyint(1) DEFAULT NULL,
  `production_date` tinyint(1) DEFAULT NULL,
  `should_alert` tinyint(1) DEFAULT NULL,
  `days_before_alert` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'221221','item 1','syria-lattakia-jableh','update','syria','source','caliber','chemical','المادة الأولى',1,'23.23','size','Stock','this is first item','gbgfd','item',1,1,2.1,2.2,1,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(2,'234321','item 2','syria-lattakia-jableh','update','syria','source','caliber','chemical','المادة الثانية',2,'23.23','size','Stock','this is first item','gbgfd','item',1,2,3.3,5.5,1,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(3,'121212','item 3','syria-lattakia-jableh','update','syria','source','caliber','chemical','المادة الثالثة',3,'23.23','size','Service','this is first item','gbgfd','item',1,3,8.1,2.2,1,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:00','2023-11-22 10:17:00');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_entries`
--

DROP TABLE IF EXISTS `journal_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_entries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `parity` int(11) DEFAULT NULL,
  `security_level` int(11) DEFAULT NULL,
  `debit_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_post_to_account` tinyint(1) DEFAULT NULL,
  `post_to_account_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` bigint(20) unsigned NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`source`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_entries`
--

LOCK TABLES `journal_entries` WRITE;
/*!40000 ALTER TABLE `journal_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `journal_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_entry_permission_users`
--

DROP TABLE IF EXISTS `journal_entry_permission_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_entry_permission_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `show_setting` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`show_setting`)),
  `print_setting` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`print_setting`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_entry_permission_users`
--

LOCK TABLES `journal_entry_permission_users` WRITE;
/*!40000 ALTER TABLE `journal_entry_permission_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `journal_entry_permission_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_entry_records`
--

DROP TABLE IF EXISTS `journal_entry_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_entry_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `index` int(11) DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` bigint(20) unsigned DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `relative_debit` double DEFAULT NULL,
  `relative_credit` double DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost_center_id` bigint(20) unsigned DEFAULT NULL,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `parity` int(11) DEFAULT NULL,
  `today_parity` int(11) DEFAULT NULL,
  `equivalent` int(11) DEFAULT NULL,
  `contra_account_id` bigint(20) unsigned DEFAULT NULL,
  `journal_entry_id` bigint(20) unsigned NOT NULL,
  `current_balance` double DEFAULT NULL,
  `final_balance` double DEFAULT NULL,
  `is_post_to_account` tinyint(1) DEFAULT NULL,
  `post_to_account_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relative_final_balance` int(11) DEFAULT NULL,
  `relative_current_balance` int(11) DEFAULT NULL,
  `source_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_template_id` int(11) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_entry_records`
--

LOCK TABLES `journal_entry_records` WRITE;
/*!40000 ALTER TABLE `journal_entry_records` DISABLE KEYS */;
INSERT INTO `journal_entry_records` VALUES (1,NULL,'2020-1-1',1,5000,5000,NULL,NULL,NULL,1,1,1,NULL,NULL,NULL,1,NULL,NULL,1,NULL,NULL,NULL,'Bill',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(2,NULL,'2020-1-2',1,5000,5000,NULL,NULL,NULL,1,1,1,NULL,NULL,NULL,1,NULL,NULL,1,NULL,NULL,NULL,'Bill',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(3,NULL,'2020-1-3',1,5,5,NULL,NULL,NULL,1,2,7000,NULL,NULL,NULL,1,NULL,NULL,1,NULL,NULL,NULL,'Voucher',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(4,NULL,'2020-1-3',1,10000,10000,NULL,NULL,NULL,1,1,1,NULL,NULL,NULL,1,NULL,NULL,1,NULL,NULL,NULL,'Voucher',NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(5,NULL,'2020-1-4',1,10,10,NULL,NULL,NULL,1,2,10000,NULL,NULL,NULL,1,NULL,NULL,1,NULL,NULL,NULL,'Bill',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(6,NULL,'2020-1-5',1,10,10,NULL,NULL,NULL,1,2,12000,NULL,NULL,NULL,1,NULL,123,1,NULL,NULL,NULL,'Bill',NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(7,NULL,'2020-1-6',1,5,5,NULL,NULL,NULL,1,2,13000,NULL,NULL,NULL,1,NULL,123,1,NULL,NULL,NULL,'Bill',NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(8,NULL,'2020-1-7',1,10,10,NULL,NULL,NULL,1,2,13000,NULL,NULL,NULL,1,NULL,123,1,NULL,NULL,NULL,'Bill',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(9,NULL,'2020-1-8',1,10,10,NULL,NULL,NULL,1,2,12000,NULL,NULL,NULL,1,NULL,123,1,NULL,NULL,NULL,'Voucher',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(10,NULL,'2020-1-9',1,7,7,NULL,NULL,NULL,1,3,10000,NULL,NULL,NULL,1,NULL,NULL,1,NULL,NULL,NULL,'Bill',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14');
/*!40000 ALTER TABLE `journal_entry_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0000_00_00_000000_create_websockets_statistics_entries_table',1),(2,'2013_03_27_152716_create_branches_table',1),(3,'2014_10_12_000000_create_users_table',1),(4,'2014_10_12_100000_create_password_resets_table',1),(5,'2018_08_08_100000_create_telescope_entries_table',1),(6,'2019_08_19_000000_create_failed_jobs_table',1),(7,'2019_12_14_000001_create_personal_access_tokens_table',1),(8,'2023_03_26_154645_create_permission_groups_table',1),(9,'2023_03_27_15466_create_permission_tables',1),(10,'2023_03_27_154758_create_trashes_table',1),(11,'2023_03_27_154845_create_activities_table',1),(12,'2023_03_28_095909_create_stores_table',1),(13,'2023_03_30_171135_create_currencies_table',1),(14,'2023_03_30_171734_create_default_currencies_table',1),(15,'2023_03_30_171819_create_cost_centers_table',1),(16,'2023_04_07_200821_create_accounts_table',1),(17,'2023_04_08_100232_create_categories_table',1),(18,'2023_04_08_100507_create_items_table',1),(19,'2023_04_09_100807_create_units_table',1),(20,'2023_04_10_112200_create_barcodes_table',1),(21,'2023_04_11_103756_create_clients_table',1),(22,'2023_04_11_193348_create_default_prices_table',1),(23,'2023_05_02_084900_create_journal_entries_table',1),(24,'2023_05_02_085659_create_journal_entry_records_table',1),(25,'2023_05_02_090348_create_journal_entry_permission_users_table',1),(26,'2023_05_06_195647_create_voucher_templates_table',1),(27,'2023_05_21_153134_create_vouchers_table',1),(28,'2023_05_21_153609_create_voucher_records_table',1),(29,'2023_05_24_201720_create_voucher_permission_users_table',1),(30,'2023_05_27_110549_create_bill_templates_table',1),(31,'2023_06_10_193334_create_bills_table',1),(32,'2023_06_10_194142_create_bill_records_table',1),(33,'2023_06_10_194209_create_bill_permission_users_table',1),(34,'2023_06_13_085738_create_bill_addition_and_discounts_table',1),(35,'2023_06_13_103132_create_serials_table',1),(36,'2023_06_13_202300_create_asset_groups_table',1),(37,'2023_06_17_191904_create_assets_table',1),(38,'2023_07_02_190517_create_departments_table',1),(39,'2023_07_03_195523_create_employees_table',1),(40,'2023_07_04_101744_create_quantities_table',1),(41,'2023_07_11_084740_create_bill_returned_bills_table',1),(42,'2023_07_15_114053_create_tasks_table',1),(43,'2023_07_19_074712_create_task_activities_table',1),(44,'2023_07_19_112736_create_task_states_table',1),(45,'2023_07_19_203139_create_employee_tasks_table',1),(46,'2023_07_25_190401_create_attachments_table',1),(47,'2023_07_26_211505_create_settings_table',1),(48,'2023_07_28_161204_create_reports_table',1),(49,'2023_07_29_104402_create_user_settings_table',1),(50,'2023_08_07_182721_create_serial_number_bill_records_table',1),(51,'2023_08_08_195104_create_currency_activities_table',1),(52,'2023_08_24_173040_create_report_templates_table',1),(53,'2023_09_19_164336_create_images_table',1),(54,'2023_10_06_170923_create_notifications_table',1),(55,'2023_10_12_161906_create_company_information_table',1),(56,'2023_11_06_130802_create_app_settings_table',1),(57,'2023_11_06_132121_create_report_settings_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
INSERT INTO `model_has_permissions` VALUES (1,'App\\Models\\User',1),(1,'App\\Models\\User',3),(2,'App\\Models\\User',1),(2,'App\\Models\\User',3),(3,'App\\Models\\User',1),(4,'App\\Models\\User',1),(5,'App\\Models\\User',1),(6,'App\\Models\\User',1),(7,'App\\Models\\User',1),(8,'App\\Models\\User',1),(9,'App\\Models\\User',1),(10,'App\\Models\\User',1),(11,'App\\Models\\User',1),(12,'App\\Models\\User',1),(13,'App\\Models\\User',1),(14,'App\\Models\\User',1),(15,'App\\Models\\User',1),(16,'App\\Models\\User',1),(17,'App\\Models\\User',1),(18,'App\\Models\\User',1),(19,'App\\Models\\User',1),(20,'App\\Models\\User',1),(21,'App\\Models\\User',1),(22,'App\\Models\\User',1),(23,'App\\Models\\User',1),(24,'App\\Models\\User',1),(25,'App\\Models\\User',1),(26,'App\\Models\\User',1),(27,'App\\Models\\User',1),(28,'App\\Models\\User',1),(29,'App\\Models\\User',1),(30,'App\\Models\\User',1),(31,'App\\Models\\User',1),(32,'App\\Models\\User',1),(33,'App\\Models\\User',1),(34,'App\\Models\\User',1),(35,'App\\Models\\User',1),(36,'App\\Models\\User',1),(37,'App\\Models\\User',1),(38,'App\\Models\\User',1),(39,'App\\Models\\User',1),(40,'App\\Models\\User',1),(41,'App\\Models\\User',1),(42,'App\\Models\\User',1),(43,'App\\Models\\User',1),(44,'App\\Models\\User',1),(45,'App\\Models\\User',1),(46,'App\\Models\\User',1),(47,'App\\Models\\User',1),(48,'App\\Models\\User',1),(49,'App\\Models\\User',1),(50,'App\\Models\\User',1),(51,'App\\Models\\User',1),(52,'App\\Models\\User',1),(53,'App\\Models\\User',1),(54,'App\\Models\\User',1),(55,'App\\Models\\User',1),(56,'App\\Models\\User',1),(57,'App\\Models\\User',1),(58,'App\\Models\\User',1),(59,'App\\Models\\User',1),(60,'App\\Models\\User',1),(61,'App\\Models\\User',1),(62,'App\\Models\\User',1),(63,'App\\Models\\User',1),(64,'App\\Models\\User',1),(65,'App\\Models\\User',1),(66,'App\\Models\\User',1),(67,'App\\Models\\User',1),(68,'App\\Models\\User',1),(69,'App\\Models\\User',1),(70,'App\\Models\\User',1),(71,'App\\Models\\User',1),(72,'App\\Models\\User',1),(73,'App\\Models\\User',1),(74,'App\\Models\\User',1),(75,'App\\Models\\User',1),(76,'App\\Models\\User',1),(77,'App\\Models\\User',1),(78,'App\\Models\\User',1),(79,'App\\Models\\User',1),(80,'App\\Models\\User',1);
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(2,'App\\Models\\User',3),(2,'App\\Models\\User',6),(3,'App\\Models\\User',4),(3,'App\\Models\\User',5);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `source_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachment`)),
  `from_user_id` bigint(20) unsigned NOT NULL,
  `to_employee_id` bigint(20) unsigned NOT NULL,
  `to_user_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_groups`
--

DROP TABLE IF EXISTS `permission_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_groups`
--

LOCK TABLES `permission_groups` WRITE;
/*!40000 ALTER TABLE `permission_groups` DISABLE KEYS */;
INSERT INTO `permission_groups` VALUES (1,'branch_permissions','صلاحيات الأفرع','Branch Permissions ','2023-11-22 10:17:00','2023-11-22 10:17:00'),(2,'user_permissions','صلاحيات المستخدمين','User Permissions ','2023-11-22 10:17:00','2023-11-22 10:17:00'),(3,'store_permissions','صلاحيات المستودعات','Store Permissions ','2023-11-22 10:17:00','2023-11-22 10:17:00'),(4,'costCenter_permissions','صلاحيات مراكز الكلفة','CostCenter Permissions ','2023-11-22 10:17:00','2023-11-22 10:17:00'),(5,'currency_permissions','صلاحيات العملات','Currency Permissions ','2023-11-22 10:17:00','2023-11-22 10:17:00'),(6,'account_permissions','صلاحيات الحسابات','Account Permissions ','2023-11-22 10:17:00','2023-11-22 10:17:00'),(7,'category_permissions','صلاحيات الأصناف','Category Permissions ','2023-11-22 10:17:00','2023-11-22 10:17:00'),(8,'item_permissions','صلاحيات المواد ','Item Permissions ','2023-11-22 10:17:00','2023-11-22 10:17:00'),(9,'department_permissions','صلاحيات الأقسام ','Department Permissions ','2023-11-22 10:17:00','2023-11-22 10:17:00'),(10,'employee_permissions','صلاحيات الموظفين ','Employee Permissions ','2023-11-22 10:17:00','2023-11-22 10:17:00');
/*!40000 ALTER TABLE `permission_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_group_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'save_branch','web','حفظ فرع  ','Save Branch ',1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(2,'update_branch','web','تعديل فرع  ','Update Branch',1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(3,'delete_branch','web','حذف فرع  ','Delete Branch',1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(4,'update_main_branch','web','تعديل الفرع الرئيسي ','Update Main Branch',1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(5,'update_branch_name','web','تعديل اسم الفرع ','Update Branch Name',1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(6,'update_branch_code','web','تعديل كود الفرع','Update Branch Code',1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(7,'update_branch_foreign_name','web','تعديل الاسم الأجنبي للفرع ','Update Branch Foreign Name',1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(8,'update_branch_activation','web','تعديل تنشيط الفرع ','Update Branch Activation',1,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(9,'save_user','web','حفظ مستخدم  ','Save User',2,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(10,'update_user','web','تعديل مستخدم  ','Update User',2,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(11,'delete_user','web','حذف مستخدم  ','Delete User',2,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(12,'update_user_main_branch','web','تعديل الفرع الرئيسي للمستخدم ','Update User Main Branch',2,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(13,'update_user_name','web','تعديل اسم المستخدم','Update User Name',2,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(14,'update_user_code','web',' تعديل كود المستخدم ','Update User Code',2,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(15,'update_user_foreign_name','web','تعديل الاسم الأجنبي للمستخدم ','Update User Foreign Name',2,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(16,'update_user_activation','web','تعديل تنشيط االمستخدم ','Update User Activation',2,'2023-11-22 10:17:00','2023-11-22 10:17:00'),(17,'save_store','web','حفظ مستودع  ','Save Store',3,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(18,'update_store','web','تعديل مستودع  ','Update Store',3,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(19,'delete_store','web','حذف مستودع  ','Delete Store',3,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(20,'update_main_store','web','تعديل المستودع الرئيسي ','Update Main Store',3,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(21,'update_store_name','web','تعديل اسم المستودع ','Update Store Name',3,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(22,'update_store_code','web','تعديل كود المسودع','Update Store Code',3,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(23,'update_store_foreign_name','web','تعديل الاسم الأجنبي للمستودع ','Update Store Foreign Name',3,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(24,'save_costCenter','web','حفظ مركز الكلفة  ','Save CostCenter',4,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(25,'update_costCenter','web','تعديل مركز الكلفة  ','Update CostCenter',4,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(26,'delete_costCenter','web','حذف مركز الكلفة  ','Delete CostCenter',4,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(27,'update_main_costCenter','web','تعديل مركز الكلفة الرئيسي ','Update Main CostCenter',4,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(28,'update_costCenter_name','web','تعديل اسم مركز الكلفة ','Update CostCenter Name',4,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(29,'update_costCenter_code','web',' تعديل كود مركز الكلفة','Update CostCenter Code',4,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(30,'update_costCenter_foreign_name','web','تعديل الاسم الأجنبي لمركز الكلفة','Update CostCenter Foreign Name',4,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(31,'save_currency','web','حفظ العملة   ','Save Currency',5,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(32,'update_currency','web','تعديل العملة   ','Update Currency',5,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(33,'delete_currency','web','حذف العملة   ','Delete Currency',5,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(34,'update_currency_name','web','تعديل اسم العملة ','Update Currency Name',5,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(35,'update_currency_code','web','تعديل كود العملة','Update Currency Code',5,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(36,'update_currency_foreign_name','web','تعديل الاسم الأجنبي للعملة ','Update Currency Foreign Name',5,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(37,'update_currency_part_name','web','تعديل الاسم الجزئي للعملة ','Update Currency Part Name',5,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(38,'update_currency_foreign_part_name','web','تعديل الاسم الجزئي الأجنبي للعملة ','Update Currency Foreign Part Name',5,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(39,'update_currency_value_of_part','web','تعديل قيمة الجزء للعملة ','Update Currency Value Of Part',5,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(40,'update_currency_parity','web','تعديل تكافؤ العملة ','Update Currency Parity',5,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(41,'update_currency_decimal_places','web','تعديل قيمة المنازل العشرية للعملة ','Update Currency Decimal Places',5,'2023-11-22 10:17:01','2023-11-22 10:17:01'),(42,'update_currency_exchange_rate_reminder','web','تعديل تذكير سعر الصرف للعملة ','Update Currency Exchange Rate Reminder',5,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(43,'save_account','web','حفظ الحساب   ','Save Account',6,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(44,'update_account','web','تعديل الحساب   ','Update Account',6,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(45,'delete_account','web','حذف الحساب   ','Delete Account',6,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(46,'update_main_account','web','تعديل الحساب الرئيسي ','Update Main Account',6,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(47,'update_account_name','web','تعديل اسم الحساب ','Update Account Name',6,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(48,'update_account_code','web','تعديل كود الحساب','Update Account Code',6,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(49,'update_account_foreign_name','web','تعديل الاسم الأجنبي للحساب ','Update Account Foreign Name',6,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(50,'update_final_account','web','تعديل الحساب النهائي ','Update Final Account',6,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(51,'update_result_account','web','تعديل حساب النتيجة ','Update Result Account',6,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(52,'save_category','web','حفظ الصنف   ','Save Category',7,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(53,'update_category','web','تعديل الصنف   ','Update Category',7,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(54,'delete_category','web','حذف الصنف   ','Delete Category',7,'2023-11-22 10:17:02','2023-11-22 10:17:02'),(55,'update_main_category','web','تعديل الصنف الرئيسي ','Update Main Category',7,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(56,'update_category_name','web','تعديل اسم الصنف ','Update Category Name',7,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(57,'update_category_code','web','تعديل كود الصنف','Update Category Code',7,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(58,'update_category_foreign_name','web','تعديل الاسم الأجنبي للصنف ','Update Category Foreign Name',7,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(59,'save_item','web','حفظ المادة   ','Save Item',8,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(60,'update_item','web','تعديل المادة ','Update Item',8,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(61,'delete_item','web','حذف المادة   ','Delete Item',8,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(62,'update_item_main_category','web','تعديل الصنف الرئيسي للمادة ','Update Item Main Category',8,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(63,'update_item_name','web','تعديل اسم المادة ','Update Item Name',8,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(64,'update_item_code','web','تعديل كود المادة','Update Item Code',8,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(65,'update_item_foreign_name','web','تعديل الاسم الأجنبي للمادة ','Update Item Foreign Name',8,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(66,'save_department','web','حفظ القسم   ','Save Department',9,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(67,'update_department','web','تعديل القسم   ','Update Department',9,'2023-11-22 10:17:03','2023-11-22 10:17:03'),(68,'delete_department','web','حذف القسم   ','Delete Department',9,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(69,'update_main_department','web','تعديل القسم الرئيسي ','Update Main Department',9,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(70,'update_department_name','web','تعديل اسم القسم ','Update Department Name',9,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(71,'update_department_code','web',' تعديل كود القسم ','Update Department Code',9,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(72,'update_department_foreign_name','web','تعديل الاسم الأجنبي للقسم ','Update Department Foreign Name',9,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(73,'update_department_branch','web','تعديل فرع القسم ','Update Department Branch',9,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(74,'save_employee','web','حفظ موظف   ','Save Employee',10,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(75,'update_employee','web','تعديل الموظف   ','Update Employee',10,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(76,'delete_employee','web','حذف الموظف   ','Delete Employee',10,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(77,'update_employee_main_department','web','تعديل القسم الرئيسي للموظف ','Update Employee Main Department',10,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(78,'update_employee_name','web','تعديل اسم الموظف ','Update Employee Name',10,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(79,'update_employee_code','web','تعديل كود الموظف','Update Employee Code',10,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(80,'update_employee_foreign_name','web','تعديل الاسم الأجنبي للموظف ','Update Employee Foreign Name',10,'2023-11-22 10:17:04','2023-11-22 10:17:04');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quantities`
--

DROP TABLE IF EXISTS `quantities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quantities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned DEFAULT NULL,
  `item_id` bigint(20) unsigned DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quantities`
--

LOCK TABLES `quantities` WRITE;
/*!40000 ALTER TABLE `quantities` DISABLE KEYS */;
/*!40000 ALTER TABLE `quantities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_settings`
--

DROP TABLE IF EXISTS `report_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_settings`
--

LOCK TABLES `report_settings` WRITE;
/*!40000 ALTER TABLE `report_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_templates`
--

DROP TABLE IF EXISTS `report_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_templates`
--

LOCK TABLES `report_templates` WRITE;
/*!40000 ALTER TABLE `report_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','web','2023-11-22 10:17:04','2023-11-22 10:17:04'),(2,'Accountant','web','2023-11-22 10:17:04','2023-11-22 10:17:04'),(3,'Casher','web','2023-11-22 10:17:04','2023-11-22 10:17:04');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serial_number_bill_records`
--

DROP TABLE IF EXISTS `serial_number_bill_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `serial_number_bill_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `serial_id` int(11) DEFAULT NULL,
  `bill_record_id` int(11) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `item_Id` int(11) DEFAULT NULL,
  `is_input` tinyint(1) DEFAULT NULL,
  `is_output` int(11) DEFAULT NULL,
  `input_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `output_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serial_number_bill_records`
--

LOCK TABLES `serial_number_bill_records` WRITE;
/*!40000 ALTER TABLE `serial_number_bill_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `serial_number_bill_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serials`
--

DROP TABLE IF EXISTS `serials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `serials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_id` bigint(20) unsigned DEFAULT NULL,
  `manufacture_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_index` int(11) DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serials`
--

LOCK TABLES `serials` WRITE;
/*!40000 ALTER TABLE `serials` DISABLE KEYS */;
INSERT INTO `serials` VALUES (1,'0909',1,'2023','red',NULL,'notes','2023-11-22 10:17:15','2023-11-22 10:17:15'),(2,'9999',1,'2023','red',NULL,'notes','2023-11-22 10:17:15','2023-11-22 10:17:15'),(3,'7777',2,'2023','red',NULL,'notes','2023-11-22 10:17:15','2023-11-22 10:17:15'),(4,'8888',1,'2023','red',NULL,'notes','2023-11-22 10:17:15','2023-11-22 10:17:15'),(5,'5555',3,'2023','red',NULL,'notes','2023-11-22 10:17:15','2023-11-22 10:17:15'),(6,'4444',4,'2023','red',NULL,'notes','2023-11-22 10:17:15','2023-11-22 10:17:15'),(7,'33333',2,'2023','red',NULL,'notes','2023-11-22 10:17:15','2023-11-22 10:17:15'),(8,'22222',1,'2023','red',NULL,'notes','2023-11-22 10:17:15','2023-11-22 10:17:15');
/*!40000 ALTER TABLE `serials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stores`
--

DROP TABLE IF EXISTS `stores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_type` int(11) NOT NULL DEFAULT 0,
  `store_id` bigint(20) unsigned DEFAULT NULL,
  `assembly_normal_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`assembly_normal_ids`)),
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_keeper` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `storage_capacity` int(11) DEFAULT NULL,
  `is_normal` tinyint(1) NOT NULL DEFAULT 0,
  `is_assembly` tinyint(1) NOT NULL DEFAULT 0,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'normal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stores_code_unique` (`code`),
  UNIQUE KEY `stores_name_unique` (`name`),
  UNIQUE KEY `stores_foreign_name_unique` (`foreign_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stores`
--

LOCK TABLES `stores` WRITE;
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_activities`
--

DROP TABLE IF EXISTS `task_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` bigint(20) unsigned DEFAULT NULL,
  `old_employee_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_employee_ids`)),
  `new_employee_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_employee_ids`)),
  `operation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_task_status_id` int(11) DEFAULT NULL,
  `new_task_status_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_activities`
--

LOCK TABLES `task_activities` WRITE;
/*!40000 ALTER TABLE `task_activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_states`
--

DROP TABLE IF EXISTS `task_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_states` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pattern` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_states`
--

LOCK TABLES `task_states` WRITE;
/*!40000 ALTER TABLE `task_states` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employees_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`employees_ids`)),
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `remind_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remind_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remind_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_terminated` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terminate_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terminate_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `font_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_entries`
--

DROP TABLE IF EXISTS `telescope_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries` (
  `sequence` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sequence`),
  UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  KEY `telescope_entries_batch_id_index` (`batch_id`),
  KEY `telescope_entries_family_hash_index` (`family_hash`),
  KEY `telescope_entries_created_at_index` (`created_at`),
  KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_entries`
--

LOCK TABLES `telescope_entries` WRITE;
/*!40000 ALTER TABLE `telescope_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_entries_tags`
--

DROP TABLE IF EXISTS `telescope_entries_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `telescope_entries_tags_entry_uuid_tag_index` (`entry_uuid`,`tag`),
  KEY `telescope_entries_tags_tag_index` (`tag`),
  CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_entries_tags`
--

LOCK TABLES `telescope_entries_tags` WRITE;
/*!40000 ALTER TABLE `telescope_entries_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_entries_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_monitoring`
--

DROP TABLE IF EXISTS `telescope_monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_monitoring`
--

LOCK TABLES `telescope_monitoring` WRITE;
/*!40000 ALTER TABLE `telescope_monitoring` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_monitoring` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trashes`
--

DROP TABLE IF EXISTS `trashes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trashes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `table` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trashes`
--

LOCK TABLES `trashes` WRITE;
/*!40000 ALTER TABLE `trashes` DISABLE KEYS */;
/*!40000 ALTER TABLE `trashes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `item_id` bigint(20) unsigned NOT NULL,
  `relative_unit` int(11) DEFAULT NULL,
  `conversion_factor` double DEFAULT NULL,
  `unit_number` int(11) DEFAULT NULL,
  `prices` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`prices`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'gram','غرام','1',1,NULL,NULL,1,'{\"consumer\":12,\"wholesale\":32,\"semi_wholesale\":1,\"export\":12,\"distributer\":2,\"retail\":12,\"last_purchase\":\"2021-01-05T00:00:00.000000Z\"}','2023-11-22 10:17:00','2023-11-22 10:17:00'),(2,'kilo gram','كيلو غرام','1',2,1,10,1,'{\"consumer\":22,\"wholesale\":11,\"semi_wholesale\":12,\"export\":11,\"distributer\":2,\"retail\":2,\"last_purchase\":\"2021-04-05T00:00:00.000000Z\"}','2023-11-22 10:17:00','2023-11-22 10:17:00'),(3,'ton','طن','1',3,1,10,1,'{\"consumer\":44,\"wholesale\":21,\"semi_wholesale\":32,\"export\":21,\"distributer\":32,\"retail\":3,\"last_purchase\":\"2021-09-05T00:00:00.000000Z\"}','2023-11-22 10:17:00','2023-11-22 10:17:00');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_settings`
--

DROP TABLE IF EXISTS `user_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `setting_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_settings`
--

LOCK TABLES `user_settings` WRITE;
/*!40000 ALTER TABLE `user_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `national_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `real_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) unsigned DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `security_level` int(11) DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_root` tinyint(1) NOT NULL DEFAULT 0,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `databases` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]' CHECK (json_valid(`databases`)),
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_branch_id_foreign` (`branch_id`),
  CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'المدير العام','Super Admin','3456789','A11','superAdmin@gmail.com',NULL,'eyJpdiI6IjFVRmpuZnlXSzI2ajlPbWttWWg3dGc9PSIsInZhbHVlIjoicGlpMzFicnZ2eWpxNi80VlR6RWhsUT09IiwibWFjIjoiNGE0Mjc5ODZmZmZhNmQxODVjZmJhMTMyNzA0NTFhYzUyODJhZmRmYWQzMjE1OGFmYWU1NDdiMjk2M2M3NmM1NCIsInRhZyI6IiJ9',NULL,NULL,1,'s','s','s','09913646374',NULL,NULL,'0414949494','latakkia-jableh',1,'notes','001123938373774',1,1,'user',NULL,'[]',NULL,'2023-11-22 10:17:04','2023-11-22 10:17:04'),(2,'نور الكنج','Noor Al-kinj','345675489','U2','noor@gmail.com',NULL,'eyJpdiI6IlBMcTdQRmRkallicHBXNnhQbk1SZVE9PSIsInZhbHVlIjoiN0FqU2tKL3hYbW1UbjZKRjhDMTZlZz09IiwibWFjIjoiODdiNzg3ZThiMmM1ODc2OGM3ODU2OTM2YjgyYzdlN2U3OTQwZWQzZGNjZjljZjQ0M2M3N2Q5Mzg2MzhjMTk2OCIsInRhZyI6IiJ9',NULL,NULL,1,'a','s','s','09955556374',NULL,NULL,'0414949494','latakkia-jableh',2,'notes','001123938373774',1,0,'user',NULL,'[]',NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(3,'كلودا الركاد','Clauda Al-Rakkad','3445356789','U3','clauda@gmail.com',NULL,'eyJpdiI6IlVKUlpqWFk2c1JnNFJJVFNxMVd4eUE9PSIsInZhbHVlIjoiMlpaQjhJV2tlQ3BUaUcwbFF2UEZOQT09IiwibWFjIjoiMGE1ZTE3ODhjOGE2OGIyZGZiNDNmYTgxZjExNGFiMGIyOTI4ZGVhZDVkM2Y3YTM2MDFiYTQ2NGJjZDVkNzU2MiIsInRhZyI6IiJ9',NULL,NULL,2,'s','s','s','09913646374',NULL,NULL,'0414949494','latakkia-jableh',3,'notes ','001123938373774',1,0,'user',NULL,'[]',NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(4,'سارا عبدو','Sara Abdo','345346789','u5','sara@gmail.com',NULL,'eyJpdiI6InNxb3pDdHdmWDAyTEtET2NiR01UNXc9PSIsInZhbHVlIjoiakVUU2xuVHNnazErMUw3R1dFQlpXUT09IiwibWFjIjoiMTcxNWQzMWFlN2YxNjg5MTYwNDYyZjRmZGNiMWIyMjYyN2E4ZDZhOWNjODQxOTg3ODQ0NmZiYjg3ODYwN2M4ZCIsInRhZyI6IiJ9',NULL,NULL,3,'a','s','s','09955556374',NULL,NULL,'0414949494','latakkia-jableh',1,'notes','001123938373774',1,0,'user',NULL,'[]',NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(5,'مهند محمود','Mohannad Mahmoud','3398765456789','z100','raghad@gmail.com',NULL,'eyJpdiI6IktjU3Q3eHRnZGlqeDlzczhKZ05OdFE9PSIsInZhbHVlIjoiQXQvT3Q0czFzWGpLd2FHbFZjTFZvdz09IiwibWFjIjoiZjg1NTE4OTBkMzUzMzU5NDM0ZWVjMzVkY2NjNWU4MjU0OGE3OTE4MjgxZmE1NTljODVjMTY5OTM4NGEzNzY1MyIsInRhZyI6IiJ9',NULL,NULL,4,'a','s','s','09955556374',NULL,NULL,'0414949494','latakkia-jableh',1,'notes','001123938373774',1,0,'user',NULL,'[]',NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(6,'أحمد علي','Ahmad Ali','339856789','A987','ahmad@gmail.com',NULL,'eyJpdiI6ImJ6RWNYQXA4Q2JhNmpkNWwyUS9zYXc9PSIsInZhbHVlIjoiMFlGK2IrbnNSMDhEVCtFeEg1NjBwUT09IiwibWFjIjoiOTA0MzIxOWY5ZWRmNTU2YWM5Mzg4OTAxZGEyNDBhYjBjMDFmZWFmYmViODhhNjRhOWY0MGVlNWRkZTJhN2RhYiIsInRhZyI6IiJ9',NULL,NULL,3,'a','s','s','09955556374',NULL,NULL,'0414949494','Banyas',1,'notes','001123938373774',1,0,'user',NULL,'[]',NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voucher_permission_users`
--

DROP TABLE IF EXISTS `voucher_permission_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voucher_permission_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `show_setting` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`show_setting`)),
  `print_setting` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`print_setting`)),
  `voucher_template_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher_permission_users`
--

LOCK TABLES `voucher_permission_users` WRITE;
/*!40000 ALTER TABLE `voucher_permission_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `voucher_permission_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voucher_records`
--

DROP TABLE IF EXISTS `voucher_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voucher_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `index` int(11) DEFAULT NULL,
  `account_id` bigint(20) unsigned DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `relative_debit` double DEFAULT NULL,
  `relative_credit` double DEFAULT NULL,
  `post_to_account_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_post_to_account` tinyint(1) DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost_center_id` bigint(20) unsigned DEFAULT NULL,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `parity` int(11) DEFAULT NULL,
  `today_parity` int(11) DEFAULT NULL,
  `equivalent` int(11) DEFAULT NULL,
  `contra_account_id` double DEFAULT NULL,
  `current_balance` double DEFAULT NULL,
  `final_balance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relative_current_balance` int(11) DEFAULT NULL,
  `relative_final_balance` int(11) DEFAULT NULL,
  `id2` int(11) DEFAULT NULL,
  `tax_account` bigint(20) unsigned DEFAULT NULL,
  `tax_ratio` double DEFAULT NULL,
  `tax_value` double DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `voucher_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher_records`
--

LOCK TABLES `voucher_records` WRITE;
/*!40000 ALTER TABLE `voucher_records` DISABLE KEYS */;
INSERT INTO `voucher_records` VALUES (1,1,1,34.7,34.7,34.7,34.7,NULL,NULL,'notes',1,1,1,NULL,1,1,37,'0',NULL,NULL,1,NULL,NULL,NULL,NULL,1,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(2,2,1,34.7,34.7,34.7,34.7,NULL,NULL,'notes',1,1,1,NULL,1,1,37,'0',NULL,NULL,2,NULL,NULL,NULL,NULL,1,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(3,3,1,34.7,34.7,34.7,34.7,NULL,NULL,'notes',1,1,1,NULL,1,1,37,'0',NULL,NULL,3,NULL,NULL,NULL,NULL,1,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(4,4,1,34.7,34.7,34.7,34.7,NULL,NULL,'notes',1,1,1,NULL,1,1,37,'0',NULL,NULL,4,NULL,NULL,NULL,NULL,2,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(5,5,1,34.7,34.7,34.7,34.7,NULL,NULL,'notes',2,1,1,NULL,1,1,37,'0',NULL,NULL,5,NULL,NULL,NULL,NULL,2,'2023-11-22 10:17:15','2023-11-22 10:17:15'),(6,6,1,34.7,34.7,34.7,34.7,NULL,NULL,'notes',1,1,1,NULL,1,1,37,'0',NULL,NULL,6,NULL,NULL,NULL,NULL,3,'2023-11-22 10:17:15','2023-11-22 10:17:15');
/*!40000 ALTER TABLE `voucher_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voucher_templates`
--

DROP TABLE IF EXISTS `voucher_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voucher_templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `abbreviation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher_type` int(11) NOT NULL DEFAULT 0,
  `foreign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_entry` tinyint(1) NOT NULL DEFAULT 0,
  `is_receipt` tinyint(1) NOT NULL DEFAULT 0,
  `is_payment` tinyint(1) NOT NULL DEFAULT 0,
  `is_daily` tinyint(1) NOT NULL DEFAULT 0,
  `account_id` bigint(20) unsigned DEFAULT NULL,
  `is_account_lock` tinyint(1) NOT NULL DEFAULT 0,
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  `is_branch_lock` tinyint(1) NOT NULL DEFAULT 0,
  `is_branch_show` tinyint(1) NOT NULL DEFAULT 0,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `is_currency_lock` tinyint(1) NOT NULL DEFAULT 0,
  `cost_center_id` bigint(20) unsigned DEFAULT NULL,
  `is_cost_center_lock` tinyint(1) NOT NULL DEFAULT 0,
  `is_cost_center_show` tinyint(1) NOT NULL DEFAULT 0,
  `date` date DEFAULT NULL,
  `is_date_lock` tinyint(1) NOT NULL DEFAULT 0,
  `is_date_show` tinyint(1) NOT NULL DEFAULT 0,
  `time` time DEFAULT NULL,
  `is_time_lock` tinyint(1) NOT NULL DEFAULT 0,
  `is_time_show` tinyint(1) NOT NULL DEFAULT 0,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_accepts_distributive_accounts` tinyint(1) NOT NULL DEFAULT 0,
  `is_generates_entry_for_each_item` tinyint(1) NOT NULL DEFAULT 0,
  `is_auto_posting_to_accounts` tinyint(1) NOT NULL DEFAULT 0,
  `is_print_duplicated_copy` tinyint(1) NOT NULL DEFAULT 0,
  `is_enforce_cost_center` tinyint(1) NOT NULL DEFAULT 0,
  `is_enforce_receipt_number` tinyint(1) NOT NULL DEFAULT 0,
  `uses_vat_tax_system` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uses_ttc_tax_system` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `voucher_templates_abbreviation_unique` (`abbreviation`),
  UNIQUE KEY `voucher_templates_name_unique` (`name`),
  UNIQUE KEY `voucher_templates_foreign_name_unique` (`foreign_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher_templates`
--

LOCK TABLES `voucher_templates` WRITE;
/*!40000 ALTER TABLE `voucher_templates` DISABLE KEYS */;
INSERT INTO `voucher_templates` VALUES (1,'vTe1','نمط السند الافتتاحي 1',0,'voucher template entry 1',1,1,0,0,0,1,1,2,0,1,1,1,1,1,1,'2000-01-12',1,1,'12:17:14',1,1,'entry1',1,1,1,1,1,1,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(2,'vTe2','نمط السند الافتتاحي 2',0,'voucher template entry 2',0,1,0,0,0,2,1,2,0,1,1,1,1,0,0,'2000-01-12',1,1,'12:17:14',1,1,'entry2',0,1,1,0,1,1,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(3,'vTr1','نمط السند الايصال 1',1,'voucher template receipt 1',1,0,1,0,0,2,1,2,0,1,1,0,1,1,1,'2000-12-02',0,1,'12:17:14',1,1,'entry1',1,0,0,1,1,0,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(4,'vTr2','نمط السند الايصال 2',1,'voucher template receipt 2',0,0,1,0,0,2,1,4,0,1,1,1,1,1,0,'2010-05-02',0,1,'12:17:14',1,1,'entry1',1,1,1,1,1,0,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(5,'vTr3','نمط السند الايصال 3',1,'voucher template receipt 3',1,0,1,0,0,2,1,1,1,1,1,1,1,1,1,'2022-08-02',1,1,'12:17:14',1,1,'entry1',1,1,1,1,1,0,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(6,'vTp1','نمط سند الفاتورة 1',2,'voucher template payment 1',1,0,0,1,0,2,1,2,0,1,1,1,1,1,0,'2000-09-02',0,1,'12:17:14',1,1,'entry1',1,0,1,1,1,1,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(7,'vTd1','نمط سند اليومي 1',3,'voucher template daily 1',0,0,0,0,1,2,1,1,1,1,1,1,1,1,1,'2000-02-02',1,1,'12:17:14',1,1,'entry1',1,1,1,1,1,1,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14');
/*!40000 ALTER TABLE `voucher_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vouchers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` bigint(20) unsigned DEFAULT NULL,
  `currency_id` bigint(20) unsigned DEFAULT NULL,
  `parity` int(11) DEFAULT NULL,
  `security_level` int(11) DEFAULT NULL,
  `voucher_template_id` bigint(20) unsigned NOT NULL,
  `debit_total` double DEFAULT NULL,
  `credit_total` double DEFAULT NULL,
  `total_balance` double DEFAULT NULL,
  `branch_id` bigint(20) unsigned NOT NULL,
  `cost_center_id` bigint(20) unsigned DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_current_cash` double DEFAULT NULL,
  `account_final_cash` double DEFAULT NULL,
  `relative_account_current_cash` int(11) DEFAULT NULL,
  `relative_account_final_cash` int(11) DEFAULT NULL,
  `generated_entry_id` int(11) DEFAULT NULL,
  `post_to_account_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_post_to_account` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vouchers`
--

LOCK TABLES `vouchers` WRITE;
/*!40000 ALTER TABLE `vouchers` DISABLE KEYS */;
INSERT INTO `vouchers` VALUES (1,'2020-4-4','','1',1,1,1,1,3,567,4567,NULL,1,NULL,'notes',23,0,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(2,'2020-4-4','','2',1,1,1,2,1,0,0,NULL,2,NULL,'notes',0,0,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14'),(3,'2020-4-4','','3',1,1,1,3,2,0,0,NULL,2,NULL,'notes',0,0,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-22 10:17:14','2023-11-22 10:17:14');
/*!40000 ALTER TABLE `vouchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `websockets_statistics_entries`
--

DROP TABLE IF EXISTS `websockets_statistics_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `websockets_statistics_entries`
--

LOCK TABLES `websockets_statistics_entries` WRITE;
/*!40000 ALTER TABLE `websockets_statistics_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `websockets_statistics_entries` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-22 14:17:27
