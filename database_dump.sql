-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: grocery_self_checkout
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.24.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint unsigned DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 05:09:10','2026-06-10 05:09:10'),(2,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 05:15:08','2026-06-10 05:15:08'),(3,1,'User logged out','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 05:24:25','2026-06-10 05:24:25'),(4,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 05:26:01','2026-06-10 05:26:01'),(5,1,'Created supplier','App\\Models\\Supplier',6,NULL,'{\"id\": 6, \"name\": \"Vladiver\", \"email\": \"shawn@gmail.com\", \"phone\": \"09765724466\", \"address\": \"ditosatabikostreetmissnakita\", \"is_active\": true, \"created_at\": \"2026-06-10T13:31:14.000000Z\", \"updated_at\": \"2026-06-10T13:31:14.000000Z\", \"contact_person\": \"Shawn Michael Regencia\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 05:31:14','2026-06-10 05:31:14'),(6,1,'Updated supplier','App\\Models\\Supplier',5,'{\"id\": 5, \"name\": \"CleanHome Distributors\", \"email\": \"orders@cleanhome.com\", \"phone\": \"+63 921 567 8901\", \"address\": \"654 Supply Chain Ave, Mandaluyong City, Metro Manila\", \"is_active\": true, \"created_at\": \"2026-06-10T12:59:59.000000Z\", \"updated_at\": \"2026-06-10T12:59:59.000000Z\", \"contact_person\": \"Roberto Mendoza\"}','{\"id\": 5, \"name\": \"CleanHome Distributors\", \"email\": \"orders@cleanhome.com\", \"phone\": \"+63 921 567 8901\", \"address\": \"654 Supply Chain Ave, Mandaluyong City, Metro Manil\", \"is_active\": true, \"created_at\": \"2026-06-10T12:59:59.000000Z\", \"updated_at\": \"2026-06-10T13:31:36.000000Z\", \"contact_person\": \"Roberto Mendoza\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 05:31:36','2026-06-10 05:31:36'),(7,1,'Updated supplier','App\\Models\\Supplier',5,'{\"id\": 5, \"name\": \"CleanHome Distributors\", \"email\": \"orders@cleanhome.com\", \"phone\": \"+63 921 567 8901\", \"address\": \"654 Supply Chain Ave, Mandaluyong City, Metro Manil\", \"is_active\": true, \"created_at\": \"2026-06-10T12:59:59.000000Z\", \"updated_at\": \"2026-06-10T13:31:36.000000Z\", \"contact_person\": \"Roberto Mendoza\"}','{\"id\": 5, \"name\": \"CleanHome Distributors\", \"email\": \"orders@cleanhome.com\", \"phone\": \"+63 921 567 8901\", \"address\": \"654 Supply Chain Ave, Mandaluyong City, Metro Manila\", \"is_active\": true, \"created_at\": \"2026-06-10T12:59:59.000000Z\", \"updated_at\": \"2026-06-10T13:31:46.000000Z\", \"contact_person\": \"Roberto Mendoza\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 05:31:46','2026-06-10 05:31:46'),(8,1,'Created stock entry','App\\Models\\StockEntry',1,NULL,'{\"id\": 1, \"notes\": \"Add lysol\", \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-10T13:55:54.000000Z\", \"updated_at\": \"2026-06-10T13:55:54.000000Z\", \"supplier_id\": \"2\", \"entry_number\": \"SE-20260610-GTIB1T\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 05:55:54','2026-06-10 05:55:54'),(9,1,'Deleted product','App\\Models\\Product',18,'{\"id\": 18, \"sku\": \"CAN-CAMP298\", \"name\": \"Campbell\'s Cream of Mushroom Soup 298g\", \"unit\": \"can\", \"image\": null, \"barcode\": \"0051000012517\", \"is_active\": true, \"created_at\": \"2026-06-10T13:00:03.000000Z\", \"unit_price\": \"95.00\", \"updated_at\": \"2026-06-10T13:00:03.000000Z\", \"category_id\": 3, \"description\": \"Rich and creamy condensed mushroom soup\", \"supplier_id\": 3, \"current_stock\": 7, \"low_stock_threshold\": 10}',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 06:00:26','2026-06-10 06:00:26'),(10,1,'Created stock entry','App\\Models\\StockEntry',2,NULL,'{\"id\": 2, \"notes\": \"Restocking lysol\", \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-10T14:07:36.000000Z\", \"updated_at\": \"2026-06-10T14:07:36.000000Z\", \"supplier_id\": \"5\", \"entry_number\": \"SE-20260610-QUHABH\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 06:07:36','2026-06-10 06:07:36'),(11,1,'Created stock entry','App\\Models\\StockEntry',3,NULL,'{\"id\": 3, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-10T14:13:46.000000Z\", \"updated_at\": \"2026-06-10T14:13:46.000000Z\", \"supplier_id\": \"5\", \"entry_number\": \"SE-20260610-QICUVO\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 14:13:46','2026-06-10 14:13:46'),(12,1,'Created stock entry','App\\Models\\StockEntry',4,NULL,'{\"id\": 4, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-10T14:18:36.000000Z\", \"updated_at\": \"2026-06-10T14:18:36.000000Z\", \"supplier_id\": \"4\", \"entry_number\": \"SE-20260610-17T6NQ\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 14:18:36','2026-06-10 14:18:36'),(13,1,'Approved stock entry','App\\Models\\StockEntry',4,'{\"id\": 4, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-10T14:18:36.000000Z\", \"updated_at\": \"2026-06-10T14:18:36.000000Z\", \"approved_at\": null, \"approved_by\": null, \"supplier_id\": 4, \"entry_number\": \"SE-20260610-17T6NQ\"}','{\"id\": 4, \"items\": [{\"id\": 4, \"notes\": null, \"product\": {\"id\": 28, \"sku\": \"HH-LYSOL340\", \"name\": \"Lysol Disinfectant Spray 340g\", \"unit\": \"can\", \"image\": null, \"barcode\": \"0019200044284\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"295.00\", \"updated_at\": \"2026-06-10T05:48:22.000000Z\", \"category_id\": 5, \"description\": \"Kills 99.9% of viruses and bacteria on surfaces\", \"supplier_id\": 5, \"current_stock\": 6, \"low_stock_threshold\": 5}, \"quantity\": 6, \"created_at\": \"2026-06-10T14:18:36.000000Z\", \"product_id\": 28, \"updated_at\": \"2026-06-10T14:18:36.000000Z\", \"stock_entry_id\": 4}], \"notes\": null, \"status\": \"approved\", \"user_id\": 1, \"created_at\": \"2026-06-10T14:18:36.000000Z\", \"updated_at\": \"2026-06-10T14:28:07.000000Z\", \"approved_at\": \"2026-06-10T14:28:07.000000Z\", \"approved_by\": 1, \"supplier_id\": 4, \"entry_number\": \"SE-20260610-17T6NQ\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 14:28:07','2026-06-10 14:28:07'),(14,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 14:49:45','2026-06-10 14:49:45'),(15,1,'Created product','App\\Models\\Product',31,NULL,'{\"id\": 31, \"sku\": \"PRD-6K42NM\", \"name\": \"carl\", \"unit\": \"piece\", \"barcode\": \"338898357250\", \"is_active\": true, \"created_at\": \"2026-06-10T14:50:32.000000Z\", \"unit_price\": \"67.00\", \"updated_at\": \"2026-06-10T14:50:32.000000Z\", \"category_id\": \"2\", \"description\": null, \"supplier_id\": \"2\", \"current_stock\": 54, \"low_stock_threshold\": 10}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 14:50:32','2026-06-10 14:50:32'),(16,1,'User logged out','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 14:55:21','2026-06-10 14:55:21'),(17,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 14:55:46','2026-06-10 14:55:46'),(18,1,'User logged out','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 15:00:44','2026-06-10 15:00:44'),(19,3,'User logged in','App\\Models\\User',3,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 15:00:56','2026-06-10 15:00:56'),(20,3,'User logged out','App\\Models\\User',3,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 15:01:30','2026-06-10 15:01:30'),(21,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 15:01:39','2026-06-10 15:01:39'),(22,1,'Created product','App\\Models\\Product',32,NULL,'{\"id\": 32, \"sku\": \"PRD-YGR06C\", \"name\": \"karu\", \"unit\": \"piece\", \"image\": \"products/fkvsKHSVrMV7bS3wlvGE8kbG5FjuuLFzVQl4IoEo.jpg\", \"barcode\": \"862156288349\", \"is_active\": true, \"created_at\": \"2026-06-10T15:16:32.000000Z\", \"unit_price\": \"6767.00\", \"updated_at\": \"2026-06-10T15:16:32.000000Z\", \"category_id\": \"2\", \"description\": \"hhhii\", \"supplier_id\": \"2\", \"current_stock\": 11, \"low_stock_threshold\": 10}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-10 15:16:33','2026-06-10 15:16:33'),(23,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 00:28:42','2026-06-11 00:28:42'),(24,1,'Approved stock entry','App\\Models\\StockEntry',3,'{\"id\": 3, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-10T14:13:46.000000Z\", \"updated_at\": \"2026-06-10T14:13:46.000000Z\", \"approved_at\": null, \"approved_by\": null, \"supplier_id\": 5, \"entry_number\": \"SE-20260610-QICUVO\"}','{\"id\": 3, \"items\": [{\"id\": 3, \"notes\": null, \"product\": {\"id\": 28, \"sku\": \"HH-LYSOL340\", \"name\": \"Lysol Disinfectant Spray 340g\", \"unit\": \"can\", \"image\": null, \"barcode\": \"0019200044284\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"295.00\", \"updated_at\": \"2026-06-10T14:28:07.000000Z\", \"category_id\": 5, \"description\": \"Kills 99.9% of viruses and bacteria on surfaces\", \"supplier_id\": 5, \"current_stock\": 12, \"low_stock_threshold\": 5}, \"quantity\": 6, \"created_at\": \"2026-06-10T14:13:46.000000Z\", \"product_id\": 28, \"updated_at\": \"2026-06-10T14:13:46.000000Z\", \"stock_entry_id\": 3}], \"notes\": null, \"status\": \"approved\", \"user_id\": 1, \"created_at\": \"2026-06-10T14:13:46.000000Z\", \"updated_at\": \"2026-06-11T00:56:53.000000Z\", \"approved_at\": \"2026-06-11T00:56:53.000000Z\", \"approved_by\": 1, \"supplier_id\": 5, \"entry_number\": \"SE-20260610-QICUVO\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 00:56:53','2026-06-11 00:56:53'),(25,1,'Approved stock entry','App\\Models\\StockEntry',2,'{\"id\": 2, \"notes\": \"Restocking lysol\", \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-10T06:07:36.000000Z\", \"updated_at\": \"2026-06-10T06:07:36.000000Z\", \"approved_at\": null, \"approved_by\": null, \"supplier_id\": 5, \"entry_number\": \"SE-20260610-QUHABH\"}','{\"id\": 2, \"items\": [{\"id\": 2, \"notes\": null, \"product\": {\"id\": 28, \"sku\": \"HH-LYSOL340\", \"name\": \"Lysol Disinfectant Spray 340g\", \"unit\": \"can\", \"image\": null, \"barcode\": \"0019200044284\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"295.00\", \"updated_at\": \"2026-06-11T00:56:53.000000Z\", \"category_id\": 5, \"description\": \"Kills 99.9% of viruses and bacteria on surfaces\", \"supplier_id\": 5, \"current_stock\": 18, \"low_stock_threshold\": 5}, \"quantity\": 6, \"created_at\": \"2026-06-10T06:07:36.000000Z\", \"product_id\": 28, \"updated_at\": \"2026-06-10T06:07:36.000000Z\", \"stock_entry_id\": 2}], \"notes\": \"Restocking lysol\", \"status\": \"approved\", \"user_id\": 1, \"created_at\": \"2026-06-10T06:07:36.000000Z\", \"updated_at\": \"2026-06-11T00:57:02.000000Z\", \"approved_at\": \"2026-06-11T00:57:02.000000Z\", \"approved_by\": 1, \"supplier_id\": 5, \"entry_number\": \"SE-20260610-QUHABH\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 00:57:02','2026-06-11 00:57:02'),(26,1,'Approved stock entry','App\\Models\\StockEntry',1,'{\"id\": 1, \"notes\": \"Add lysol\", \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-10T05:55:54.000000Z\", \"updated_at\": \"2026-06-10T05:55:54.000000Z\", \"approved_at\": null, \"approved_by\": null, \"supplier_id\": 2, \"entry_number\": \"SE-20260610-GTIB1T\"}','{\"id\": 1, \"items\": [{\"id\": 1, \"notes\": null, \"product\": {\"id\": 28, \"sku\": \"HH-LYSOL340\", \"name\": \"Lysol Disinfectant Spray 340g\", \"unit\": \"can\", \"image\": null, \"barcode\": \"0019200044284\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"295.00\", \"updated_at\": \"2026-06-11T00:57:02.000000Z\", \"category_id\": 5, \"description\": \"Kills 99.9% of viruses and bacteria on surfaces\", \"supplier_id\": 5, \"current_stock\": 23, \"low_stock_threshold\": 5}, \"quantity\": 5, \"created_at\": \"2026-06-10T05:55:54.000000Z\", \"product_id\": 28, \"updated_at\": \"2026-06-10T05:55:54.000000Z\", \"stock_entry_id\": 1}], \"notes\": \"Add lysol\", \"status\": \"approved\", \"user_id\": 1, \"created_at\": \"2026-06-10T05:55:54.000000Z\", \"updated_at\": \"2026-06-11T00:57:08.000000Z\", \"approved_at\": \"2026-06-11T00:57:08.000000Z\", \"approved_by\": 1, \"supplier_id\": 2, \"entry_number\": \"SE-20260610-GTIB1T\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 00:57:08','2026-06-11 00:57:08'),(27,1,'Updated product','App\\Models\\Product',30,'{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": null, \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-10T05:00:06.000000Z\", \"category_id\": 5, \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": 5, \"current_stock\": 20, \"low_stock_threshold\": 5}','{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/g5ZPUpoh4LgpwegqEXHEUqIDQEiEA8h5R0dqQKSY.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:44.000000Z\", \"category_id\": \"5\", \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": \"5\", \"current_stock\": 20, \"low_stock_threshold\": 5}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:32:45','2026-06-11 04:32:45'),(28,1,'Updated product','App\\Models\\Product',30,'{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/g5ZPUpoh4LgpwegqEXHEUqIDQEiEA8h5R0dqQKSY.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:44.000000Z\", \"category_id\": 5, \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": 5, \"current_stock\": 20, \"low_stock_threshold\": 5}','{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/kRqBukyiNtsm76qqxsHV7LLwqtaQQFcZnqtaUOLr.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:46.000000Z\", \"category_id\": \"5\", \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": \"5\", \"current_stock\": 20, \"low_stock_threshold\": 5}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:32:47','2026-06-11 04:32:47'),(29,1,'Updated product','App\\Models\\Product',30,'{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/kRqBukyiNtsm76qqxsHV7LLwqtaQQFcZnqtaUOLr.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:46.000000Z\", \"category_id\": 5, \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": 5, \"current_stock\": 20, \"low_stock_threshold\": 5}','{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/zWuEqysgYre3PRuDFzt87a4qR3b58JadXcyjokeN.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:48.000000Z\", \"category_id\": \"5\", \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": \"5\", \"current_stock\": 20, \"low_stock_threshold\": 5}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:32:48','2026-06-11 04:32:48'),(30,1,'Updated product','App\\Models\\Product',30,'{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/zWuEqysgYre3PRuDFzt87a4qR3b58JadXcyjokeN.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:48.000000Z\", \"category_id\": 5, \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": 5, \"current_stock\": 20, \"low_stock_threshold\": 5}','{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/s5tTbKFc8f0EYmTOKi6uL50ry7pYW5sr4FBdcuRP.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:49.000000Z\", \"category_id\": \"5\", \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": \"5\", \"current_stock\": 20, \"low_stock_threshold\": 5}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:32:49','2026-06-11 04:32:49'),(31,1,'Updated product','App\\Models\\Product',30,'{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/s5tTbKFc8f0EYmTOKi6uL50ry7pYW5sr4FBdcuRP.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:49.000000Z\", \"category_id\": 5, \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": 5, \"current_stock\": 20, \"low_stock_threshold\": 5}','{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/wAXq5ndttvdNpFVlISvE8HscJdyTKyPX2bYbKdTc.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:50.000000Z\", \"category_id\": \"5\", \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": \"5\", \"current_stock\": 20, \"low_stock_threshold\": 5}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:32:50','2026-06-11 04:32:50'),(32,1,'Updated product','App\\Models\\Product',30,'{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/wAXq5ndttvdNpFVlISvE8HscJdyTKyPX2bYbKdTc.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:50.000000Z\", \"category_id\": 5, \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": 5, \"current_stock\": 20, \"low_stock_threshold\": 5}','{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/ZmUhHzOaWAPPcsK2tKQEVLS7bpfnbqgvOebPFOzJ.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:51.000000Z\", \"category_id\": \"5\", \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": \"5\", \"current_stock\": 20, \"low_stock_threshold\": 5}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:32:51','2026-06-11 04:32:51'),(33,1,'Updated product','App\\Models\\Product',30,'{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/ZmUhHzOaWAPPcsK2tKQEVLS7bpfnbqgvOebPFOzJ.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:51.000000Z\", \"category_id\": 5, \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": 5, \"current_stock\": 20, \"low_stock_threshold\": 5}','{\"id\": 30, \"sku\": \"HH-GLAD30G\", \"name\": \"Glad Trash Bags 30 Gallon 25ct\", \"unit\": \"box\", \"image\": \"products/Wz6ZX8vVJFiWhu0gexL7CypykTFHmkf6c95DFDgk.png\", \"barcode\": \"0012587700211\", \"is_active\": true, \"created_at\": \"2026-06-10T05:00:06.000000Z\", \"unit_price\": \"185.00\", \"updated_at\": \"2026-06-11T04:32:52.000000Z\", \"category_id\": \"5\", \"description\": \"Heavy-duty drawstring trash bags\", \"supplier_id\": \"5\", \"current_stock\": 20, \"low_stock_threshold\": 5}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:32:52','2026-06-11 04:32:52'),(34,1,'Created product','App\\Models\\Product',33,NULL,'{\"id\": 33, \"sku\": \"PRD-I1ICSX\", \"name\": \"hihi\", \"unit\": \"piece\", \"image\": \"products/1eqnqmr2cym2mac8K4VDevhSeiqwRZKI2zsBpzKy.png\", \"barcode\": \"080530270291\", \"is_active\": true, \"created_at\": \"2026-06-11T04:33:13.000000Z\", \"unit_price\": \"54.00\", \"updated_at\": \"2026-06-11T04:33:13.000000Z\", \"category_id\": \"1\", \"description\": \"dgdsg\", \"supplier_id\": \"2\", \"current_stock\": 5, \"low_stock_threshold\": 10}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:33:13','2026-06-11 04:33:13'),(35,1,'Created user','App\\Models\\User',4,NULL,'{\"id\": 4, \"name\": \"Carl-Jinayon\'s Org\", \"email\": \"carljinayon18@gmail.com\", \"role_id\": \"2\", \"username\": \"admin23\", \"is_active\": true, \"created_at\": \"2026-06-11T04:52:02.000000Z\", \"updated_at\": \"2026-06-11T04:52:02.000000Z\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:52:03','2026-06-11 04:52:03'),(36,1,'User logged out','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:52:12','2026-06-11 04:52:12'),(37,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:52:20','2026-06-11 04:52:20'),(38,1,'User logged out','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:58:45','2026-06-11 04:58:45'),(39,3,'User logged in','App\\Models\\User',3,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:58:59','2026-06-11 04:58:59'),(40,3,'User logged in','App\\Models\\User',3,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:59:00','2026-06-11 04:59:00'),(41,3,'User logged out','App\\Models\\User',3,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:59:37','2026-06-11 04:59:37'),(42,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 04:59:44','2026-06-11 04:59:44'),(43,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:00:48','2026-06-11 05:00:48'),(44,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:01:01','2026-06-11 05:01:01'),(45,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:01:11','2026-06-11 05:01:11'),(46,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:02:00','2026-06-11 05:02:00'),(47,1,'User logged out','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:03:07','2026-06-11 05:03:07'),(48,2,'User logged in','App\\Models\\User',2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:03:15','2026-06-11 05:03:15'),(49,2,'User logged out','App\\Models\\User',2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:03:58','2026-06-11 05:03:58'),(50,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:04:07','2026-06-11 05:04:07'),(51,1,'User logged out','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:05:50','2026-06-11 05:05:50'),(52,3,'User logged in','App\\Models\\User',3,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:06:02','2026-06-11 05:06:02'),(53,3,'User logged out','App\\Models\\User',3,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:06:20','2026-06-11 05:06:20'),(54,1,'User logged in','App\\Models\\User',1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:06:28','2026-06-11 05:06:28'),(55,1,'Updated product','App\\Models\\Product',1,'{\"id\": 1, \"sku\": \"BEV-COLA330\", \"name\": \"Coca-Cola 330ml\", \"unit\": \"can\", \"image\": null, \"barcode\": \"5449000000996\", \"is_active\": true, \"created_at\": \"2026-06-10T04:59:59.000000Z\", \"unit_price\": \"35.00\", \"updated_at\": \"2026-06-10T15:40:52.000000Z\", \"category_id\": 1, \"description\": \"Classic Coca-Cola carbonated soft drink in a 330ml can\", \"supplier_id\": 1, \"current_stock\": 147, \"low_stock_threshold\": 20}','{\"id\": 1, \"sku\": \"BEV-COLA330\", \"name\": \"Coca-Cola 330ml\", \"unit\": \"can\", \"image\": \"products/uDj3W9D8UsYkkJJmVzWWhk02jHFQahNMtQiPBsaH.webp\", \"barcode\": \"5449000000996\", \"is_active\": true, \"created_at\": \"2026-06-10T04:59:59.000000Z\", \"unit_price\": \"35.00\", \"updated_at\": \"2026-06-11T05:18:53.000000Z\", \"category_id\": \"1\", \"description\": \"Classic Coca-Cola carbonated soft drink in a 330ml can\", \"supplier_id\": \"1\", \"current_stock\": 147, \"low_stock_threshold\": 20}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 05:18:53','2026-06-11 05:18:53'),(56,1,'Created product','App\\Models\\Product',34,NULL,'{\"id\": 34, \"sku\": \"PRD-P6XVVF\", \"name\": \"sfasf\", \"unit\": \"piece\", \"barcode\": \"063109292475\", \"is_active\": true, \"created_at\": \"2026-06-11T06:03:24.000000Z\", \"unit_price\": \"32.00\", \"updated_at\": \"2026-06-11T06:03:24.000000Z\", \"category_id\": \"2\", \"description\": \"fsfsfs\", \"supplier_id\": \"2\", \"current_stock\": 32, \"low_stock_threshold\": 10}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:03:24','2026-06-11 06:03:24'),(57,1,'Updated product','App\\Models\\Product',34,'{\"id\": 34, \"sku\": \"PRD-P6XVVF\", \"name\": \"sfasf\", \"unit\": \"piece\", \"image\": null, \"barcode\": \"063109292475\", \"is_active\": true, \"created_at\": \"2026-06-11T06:03:24.000000Z\", \"unit_price\": \"32.00\", \"updated_at\": \"2026-06-11T06:03:24.000000Z\", \"category_id\": 2, \"description\": \"fsfsfs\", \"supplier_id\": 2, \"current_stock\": 32, \"low_stock_threshold\": 10}','{\"id\": 34, \"sku\": \"PRD-P6XVVF\", \"name\": \"sfasf\", \"unit\": \"piece\", \"image\": \"products/vJYmE5WWxARE6cu9KbmnTnyNaaaWialu4xYUQJLz.jpg\", \"barcode\": \"063109292475\", \"is_active\": true, \"created_at\": \"2026-06-11T06:03:24.000000Z\", \"unit_price\": \"32.00\", \"updated_at\": \"2026-06-11T06:04:00.000000Z\", \"category_id\": \"2\", \"description\": \"fsfsfs\", \"supplier_id\": \"2\", \"current_stock\": 32, \"low_stock_threshold\": 10}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:04:01','2026-06-11 06:04:01'),(58,1,'Created category','App\\Models\\Category',6,NULL,'{\"id\": 6, \"name\": \"mga oat\", \"is_active\": true, \"created_at\": \"2026-06-11T06:04:27.000000Z\", \"updated_at\": \"2026-06-11T06:04:27.000000Z\", \"description\": \"fsfasdfsfsdf\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:04:27','2026-06-11 06:04:27'),(59,1,'Updated category','App\\Models\\Category',6,'{\"id\": 6, \"name\": \"mga oat\", \"image\": null, \"is_active\": true, \"created_at\": \"2026-06-11T06:04:27.000000Z\", \"updated_at\": \"2026-06-11T06:04:27.000000Z\", \"description\": \"fsfasdfsfsdf\"}','{\"id\": 6, \"name\": \"mga oat\", \"image\": null, \"is_active\": true, \"created_at\": \"2026-06-11T06:04:27.000000Z\", \"updated_at\": \"2026-06-11T06:04:51.000000Z\", \"description\": \"maayos\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:04:51','2026-06-11 06:04:51'),(60,1,'Adjusted stock via Quick Control','App\\Models\\Product',33,'{\"current_stock\": 0}','{\"current_stock\": \"10\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:07:15','2026-06-11 06:07:15'),(61,1,'Adjusted stock via Quick Control','App\\Models\\Product',33,'{\"current_stock\": 10}','{\"current_stock\": \"11\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:07:22','2026-06-11 06:07:22'),(62,1,'Created user','App\\Models\\User',5,NULL,'{\"id\": 5, \"name\": \"sfasf\", \"email\": \"carljinayon11@gmail.com\", \"role_id\": \"3\", \"username\": \"auditor23\", \"is_active\": true, \"created_at\": \"2026-06-11T06:09:57.000000Z\", \"updated_at\": \"2026-06-11T06:09:57.000000Z\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:09:57','2026-06-11 06:09:57'),(63,1,'Created stock entry','App\\Models\\StockEntry',7,NULL,'{\"id\": 7, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:11:23.000000Z\", \"updated_at\": \"2026-06-11T06:11:23.000000Z\", \"supplier_id\": \"2\", \"entry_number\": \"SE-20260611-EOGVGG\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:11:23','2026-06-11 06:11:23'),(64,1,'Approved stock entry','App\\Models\\StockEntry',7,'{\"id\": 7, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:11:23.000000Z\", \"updated_at\": \"2026-06-11T06:11:23.000000Z\", \"approved_at\": null, \"approved_by\": null, \"supplier_id\": 2, \"entry_number\": \"SE-20260611-EOGVGG\"}','{\"id\": 7, \"items\": [{\"id\": 5, \"notes\": null, \"product\": {\"id\": 33, \"sku\": \"PRD-I1ICSX\", \"name\": \"hihi\", \"unit\": \"piece\", \"image\": \"products/1eqnqmr2cym2mac8K4VDevhSeiqwRZKI2zsBpzKy.png\", \"barcode\": \"080530270291\", \"is_active\": true, \"created_at\": \"2026-06-11T04:33:13.000000Z\", \"unit_price\": \"54.00\", \"updated_at\": \"2026-06-11T06:07:22.000000Z\", \"category_id\": 1, \"description\": \"dgdsg\", \"supplier_id\": 2, \"current_stock\": 23, \"low_stock_threshold\": 10}, \"quantity\": 12, \"unit_cost\": \"121.00\", \"created_at\": \"2026-06-11T06:11:23.000000Z\", \"product_id\": 33, \"updated_at\": \"2026-06-11T06:11:23.000000Z\", \"stock_entry_id\": 7}], \"notes\": null, \"status\": \"approved\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:11:23.000000Z\", \"updated_at\": \"2026-06-11T06:11:37.000000Z\", \"approved_at\": \"2026-06-11T06:11:37.000000Z\", \"approved_by\": 1, \"supplier_id\": 2, \"entry_number\": \"SE-20260611-EOGVGG\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:11:37','2026-06-11 06:11:37'),(65,1,'Updated supplier','App\\Models\\Supplier',6,'{\"id\": 6, \"name\": \"Vladiver\", \"email\": \"shawn@gmail.com\", \"phone\": \"09765724466\", \"address\": \"ditosatabikostreetmissnakita\", \"is_active\": true, \"created_at\": \"2026-06-10T05:31:14.000000Z\", \"updated_at\": \"2026-06-10T05:31:14.000000Z\", \"contact_person\": \"Shawn Michael Regencia\"}','{\"id\": 6, \"name\": \"Vladiver\", \"email\": \"shawn@gmail.com\", \"phone\": \"09765724466\", \"address\": \"ditosatabikostreetmissnakita\", \"is_active\": true, \"created_at\": \"2026-06-10T05:31:14.000000Z\", \"updated_at\": \"2026-06-10T05:31:14.000000Z\", \"contact_person\": \"Shawn Michael Regencia\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:21:09','2026-06-11 06:21:09'),(66,1,'Created stock entry','App\\Models\\StockEntry',8,NULL,'{\"id\": 8, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:21:33.000000Z\", \"updated_at\": \"2026-06-11T06:21:33.000000Z\", \"supplier_id\": \"6\", \"entry_number\": \"SE-20260611-5VP4U0\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:21:33','2026-06-11 06:21:33'),(67,1,'Approved stock entry','App\\Models\\StockEntry',8,'{\"id\": 8, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:21:33.000000Z\", \"updated_at\": \"2026-06-11T06:21:33.000000Z\", \"approved_at\": null, \"approved_by\": null, \"supplier_id\": 6, \"entry_number\": \"SE-20260611-5VP4U0\"}','{\"id\": 8, \"items\": [{\"id\": 6, \"notes\": null, \"product\": {\"id\": 33, \"sku\": \"PRD-I1ICSX\", \"name\": \"hihi\", \"unit\": \"piece\", \"image\": \"products/1eqnqmr2cym2mac8K4VDevhSeiqwRZKI2zsBpzKy.png\", \"barcode\": \"080530270291\", \"is_active\": true, \"created_at\": \"2026-06-11T04:33:13.000000Z\", \"unit_price\": \"54.00\", \"updated_at\": \"2026-06-11T06:21:09.000000Z\", \"category_id\": 1, \"description\": \"dgdsg\", \"supplier_id\": 6, \"current_stock\": 90, \"low_stock_threshold\": 10}, \"quantity\": 67, \"unit_cost\": \"212.00\", \"created_at\": \"2026-06-11T06:21:33.000000Z\", \"product_id\": 33, \"updated_at\": \"2026-06-11T06:21:33.000000Z\", \"stock_entry_id\": 8}], \"notes\": null, \"status\": \"approved\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:21:33.000000Z\", \"updated_at\": \"2026-06-11T06:21:39.000000Z\", \"approved_at\": \"2026-06-11T06:21:39.000000Z\", \"approved_by\": 1, \"supplier_id\": 6, \"entry_number\": \"SE-20260611-5VP4U0\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:21:39','2026-06-11 06:21:39'),(68,1,'Created stock entry','App\\Models\\StockEntry',9,NULL,'{\"id\": 9, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:50:24.000000Z\", \"updated_at\": \"2026-06-11T06:50:24.000000Z\", \"supplier_id\": \"1\", \"entry_number\": \"SE-20260611-DHCGKU\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:50:24','2026-06-11 06:50:24'),(69,1,'Updated supplier','App\\Models\\Supplier',6,'{\"id\": 6, \"name\": \"Vladiver\", \"email\": \"shawn@gmail.com\", \"phone\": \"09765724466\", \"address\": \"ditosatabikostreetmissnakita\", \"is_active\": true, \"created_at\": \"2026-06-10T05:31:14.000000Z\", \"updated_at\": \"2026-06-10T05:31:14.000000Z\", \"contact_person\": \"Shawn Michael Regencia\"}','{\"id\": 6, \"name\": \"Vladiver\", \"email\": \"shawn@gmail.com\", \"phone\": \"09765724466\", \"address\": \"ditosatabikostreetmissnakita\", \"is_active\": true, \"created_at\": \"2026-06-10T05:31:14.000000Z\", \"updated_at\": \"2026-06-10T05:31:14.000000Z\", \"contact_person\": \"Shawn Michael Regencia\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:51:43','2026-06-11 06:51:43'),(70,1,'Updated supplier','App\\Models\\Supplier',6,'{\"id\": 6, \"name\": \"Vladiver\", \"email\": \"shawn@gmail.com\", \"phone\": \"09765724466\", \"address\": \"ditosatabikostreetmissnakita\", \"is_active\": true, \"created_at\": \"2026-06-10T05:31:14.000000Z\", \"updated_at\": \"2026-06-10T05:31:14.000000Z\", \"contact_person\": \"Shawn Michael Regencia\"}','{\"id\": 6, \"name\": \"Vladiver\", \"email\": \"shawn@gmail.com\", \"phone\": \"09765724466\", \"address\": \"ditosatabikostreetmissnakita\", \"is_active\": true, \"created_at\": \"2026-06-10T05:31:14.000000Z\", \"updated_at\": \"2026-06-10T05:31:14.000000Z\", \"contact_person\": \"Shawn Michael Regencia\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:51:59','2026-06-11 06:51:59'),(71,1,'Updated supplier','App\\Models\\Supplier',6,'{\"id\": 6, \"name\": \"Vladiver\", \"email\": \"shawn@gmail.com\", \"phone\": \"09765724466\", \"address\": \"ditosatabikostreetmissnakita\", \"is_active\": true, \"created_at\": \"2026-06-10T05:31:14.000000Z\", \"updated_at\": \"2026-06-10T05:31:14.000000Z\", \"contact_person\": \"Shawn Michael Regencia\"}','{\"id\": 6, \"name\": \"Vladiver\", \"email\": \"shawn@gmail.com\", \"phone\": \"09765724466\", \"address\": \"ditosatabikostreetmissnakita\", \"is_active\": true, \"created_at\": \"2026-06-10T05:31:14.000000Z\", \"updated_at\": \"2026-06-10T05:31:14.000000Z\", \"contact_person\": \"Shawn Michael Regencia\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:52:18','2026-06-11 06:52:18'),(72,1,'Updated supplier','App\\Models\\Supplier',6,'{\"id\": 6, \"name\": \"Vladiver\", \"email\": \"shawn@gmail.com\", \"phone\": \"09765724466\", \"address\": \"ditosatabikostreetmissnakita\", \"is_active\": true, \"created_at\": \"2026-06-10T05:31:14.000000Z\", \"updated_at\": \"2026-06-10T05:31:14.000000Z\", \"contact_person\": \"Shawn Michael Regencia\"}','{\"id\": 6, \"name\": \"Vladiver\", \"email\": \"shawn@gmail.com\", \"phone\": \"09765724466\", \"address\": \"ditosatabikostreetmissnakita\", \"is_active\": true, \"created_at\": \"2026-06-10T05:31:14.000000Z\", \"updated_at\": \"2026-06-10T05:31:14.000000Z\", \"contact_person\": \"Shawn Michael Regencia\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:52:35','2026-06-11 06:52:35'),(73,1,'Created stock entry','App\\Models\\StockEntry',10,NULL,'{\"id\": 10, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:53:28.000000Z\", \"updated_at\": \"2026-06-11T06:53:28.000000Z\", \"supplier_id\": \"3\", \"entry_number\": \"SE-20260611-YVBUYJ\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:53:28','2026-06-11 06:53:28'),(74,1,'Rejected stock entry','App\\Models\\StockEntry',10,'{\"id\": 10, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:53:28.000000Z\", \"updated_at\": \"2026-06-11T06:53:28.000000Z\", \"approved_at\": null, \"approved_by\": null, \"supplier_id\": 3, \"entry_number\": \"SE-20260611-YVBUYJ\"}','{\"id\": 10, \"notes\": null, \"status\": \"rejected\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:53:28.000000Z\", \"updated_at\": \"2026-06-11T06:54:20.000000Z\", \"approved_at\": \"2026-06-11T06:54:20.000000Z\", \"approved_by\": 1, \"supplier_id\": 3, \"entry_number\": \"SE-20260611-YVBUYJ\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:54:21','2026-06-11 06:54:21'),(75,1,'Rejected stock entry','App\\Models\\StockEntry',9,'{\"id\": 9, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:50:24.000000Z\", \"updated_at\": \"2026-06-11T06:50:24.000000Z\", \"approved_at\": null, \"approved_by\": null, \"supplier_id\": 1, \"entry_number\": \"SE-20260611-DHCGKU\"}','{\"id\": 9, \"notes\": null, \"status\": \"rejected\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:50:24.000000Z\", \"updated_at\": \"2026-06-11T06:54:35.000000Z\", \"approved_at\": \"2026-06-11T06:54:35.000000Z\", \"approved_by\": 1, \"supplier_id\": 1, \"entry_number\": \"SE-20260611-DHCGKU\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:54:35','2026-06-11 06:54:35'),(76,1,'Created stock entry','App\\Models\\StockEntry',11,NULL,'{\"id\": 11, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:59:16.000000Z\", \"updated_at\": \"2026-06-11T06:59:16.000000Z\", \"supplier_id\": \"2\", \"entry_number\": \"SE-20260611-8LVVA9\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:59:16','2026-06-11 06:59:16'),(77,1,'Approved stock entry','App\\Models\\StockEntry',11,'{\"id\": 11, \"notes\": null, \"status\": \"pending\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:59:16.000000Z\", \"updated_at\": \"2026-06-11T06:59:16.000000Z\", \"approved_at\": null, \"approved_by\": null, \"supplier_id\": 2, \"entry_number\": \"SE-20260611-8LVVA9\"}','{\"id\": 11, \"items\": [{\"id\": 9, \"notes\": null, \"product\": {\"id\": 12, \"sku\": \"SNK-PLAN292\", \"name\": \"Planters Mixed Nuts 292g\", \"unit\": \"can\", \"image\": null, \"barcode\": \"0029000016811\", \"is_active\": true, \"cost_price\": null, \"created_at\": \"2026-06-10T05:00:02.000000Z\", \"unit_price\": \"320.00\", \"updated_at\": \"2026-06-11T06:39:18.000000Z\", \"category_id\": 2, \"description\": \"Premium mix of peanuts, cashews, almonds, and pecans\", \"supplier_id\": 2, \"current_stock\": 11, \"markup_percentage\": null, \"low_stock_threshold\": 8}, \"quantity\": 6, \"unit_cost\": null, \"created_at\": \"2026-06-11T06:59:16.000000Z\", \"product_id\": 12, \"updated_at\": \"2026-06-11T06:59:16.000000Z\", \"stock_entry_id\": 11}], \"notes\": null, \"status\": \"approved\", \"user_id\": 1, \"created_at\": \"2026-06-11T06:59:16.000000Z\", \"updated_at\": \"2026-06-11T06:59:26.000000Z\", \"approved_at\": \"2026-06-11T06:59:26.000000Z\", \"approved_by\": 1, \"supplier_id\": 2, \"entry_number\": \"SE-20260611-8LVVA9\"}','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-11 06:59:26','2026-06-11 06:59:26');
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Beverages','Drinks, juices, sodas, water, and other beverages',NULL,1,'2026-06-10 04:59:56','2026-06-10 04:59:56'),(2,'Snacks','Chips, crackers, cookies, nuts, and other snack items',NULL,1,'2026-06-10 04:59:56','2026-06-10 04:59:56'),(3,'Canned Goods','Canned vegetables, fruits, meats, soups, and sauces',NULL,1,'2026-06-10 04:59:57','2026-06-10 04:59:57'),(4,'Frozen Foods','Frozen meals, vegetables, ice cream, and frozen treats',NULL,1,'2026-06-10 04:59:57','2026-06-10 04:59:57'),(5,'Household Products','Cleaning supplies, paper goods, and household essentials',NULL,1,'2026-06-10 04:59:57','2026-06-10 04:59:57'),(6,'mga oat','maayos',NULL,1,'2026-06-11 06:04:27','2026-06-11 06:04:51');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_movements`
--

DROP TABLE IF EXISTS `inventory_movements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_movements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `before_stock` int NOT NULL,
  `after_stock` int NOT NULL,
  `reference_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventory_movements_product_id_foreign` (`product_id`),
  KEY `inventory_movements_user_id_foreign` (`user_id`),
  CONSTRAINT `inventory_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventory_movements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_movements`
--

LOCK TABLES `inventory_movements` WRITE;
/*!40000 ALTER TABLE `inventory_movements` DISABLE KEYS */;
INSERT INTO `inventory_movements` VALUES (1,1,'out',1,150,149,'App\\Models\\Transaction',1,'Sale via kiosk',NULL,'2026-06-10 05:08:13','2026-06-10 05:08:13'),(2,3,'out',5,80,75,'App\\Models\\Transaction',2,'Sale via kiosk',NULL,'2026-06-10 05:24:55','2026-06-10 05:24:55'),(3,4,'out',7,200,193,'App\\Models\\Transaction',2,'Sale via kiosk',NULL,'2026-06-10 05:24:55','2026-06-10 05:24:55'),(4,4,'out',1,193,192,'App\\Models\\Transaction',3,'Sale via kiosk',NULL,'2026-06-10 05:25:18','2026-06-10 05:25:18'),(5,3,'out',1,75,74,'App\\Models\\Transaction',3,'Sale via kiosk',NULL,'2026-06-10 05:25:18','2026-06-10 05:25:18'),(6,28,'out',2,3,1,'App\\Models\\Transaction',4,'Sale via kiosk',NULL,'2026-06-10 05:42:16','2026-06-10 05:42:16'),(7,28,'out',1,1,0,'App\\Models\\Transaction',5,'Sale via kiosk',NULL,'2026-06-10 05:48:22','2026-06-10 05:48:22'),(8,29,'out',1,50,49,'App\\Models\\Transaction',6,'Sale via kiosk',NULL,'2026-06-10 05:48:49','2026-06-10 05:48:49'),(9,29,'out',1,49,48,'App\\Models\\Transaction',7,'Sale via kiosk',NULL,'2026-06-10 05:48:55','2026-06-10 05:48:55'),(10,28,'in',6,0,6,'App\\Models\\StockEntry',4,'Stock entry approved: SE-20260610-17T6NQ',1,'2026-06-10 14:28:07','2026-06-10 14:28:07'),(11,3,'out',2,74,72,'App\\Models\\Transaction',8,'Sale via kiosk',NULL,'2026-06-10 14:47:50','2026-06-10 14:47:50'),(12,31,'in',54,0,54,NULL,NULL,'Initial stock on product creation',1,'2026-06-10 14:50:32','2026-06-10 14:50:32'),(13,32,'in',11,0,11,NULL,NULL,'Initial stock on product creation',1,'2026-06-10 15:16:33','2026-06-10 15:16:33'),(14,32,'out',1,11,10,'App\\Models\\Transaction',10,'Sale via kiosk',NULL,'2026-06-10 15:16:50','2026-06-10 15:16:50'),(15,32,'out',1,10,9,'App\\Models\\Transaction',11,'Sale via kiosk',NULL,'2026-06-10 15:19:16','2026-06-10 15:19:16'),(16,2,'out',1,120,119,'App\\Models\\Transaction',12,'Sale via kiosk',NULL,'2026-06-10 15:32:57','2026-06-10 15:32:57'),(17,3,'out',1,72,71,'App\\Models\\Transaction',13,'Sale via kiosk',NULL,'2026-06-10 15:33:09','2026-06-10 15:33:09'),(18,12,'out',1,5,4,'App\\Models\\Transaction',14,'Sale via kiosk',NULL,'2026-06-10 15:35:21','2026-06-10 15:35:21'),(19,1,'out',1,149,148,'App\\Models\\Transaction',15,'Sale via kiosk',NULL,'2026-06-10 15:35:51','2026-06-10 15:35:51'),(20,1,'out',1,148,147,'App\\Models\\Transaction',15,'Sale via kiosk (confirmed)',NULL,'2026-06-10 15:40:52','2026-06-10 15:40:52'),(21,4,'out',1,192,191,'App\\Models\\Transaction',16,'Sale via kiosk (confirmed)',NULL,'2026-06-11 00:29:18','2026-06-11 00:29:18'),(22,3,'out',1,71,70,'App\\Models\\Transaction',16,'Sale via kiosk (confirmed)',NULL,'2026-06-11 00:29:18','2026-06-11 00:29:18'),(23,4,'out',1,191,190,'App\\Models\\Transaction',17,'Sale via kiosk (confirmed)',NULL,'2026-06-11 00:47:17','2026-06-11 00:47:17'),(24,28,'in',6,6,12,'App\\Models\\StockEntry',3,'Stock entry approved: SE-20260610-QICUVO',1,'2026-06-11 00:56:53','2026-06-11 00:56:53'),(25,28,'in',6,12,18,'App\\Models\\StockEntry',2,'Stock entry approved: SE-20260610-QUHABH',1,'2026-06-11 00:57:02','2026-06-11 00:57:02'),(26,28,'in',5,18,23,'App\\Models\\StockEntry',1,'Stock entry approved: SE-20260610-GTIB1T',1,'2026-06-11 00:57:08','2026-06-11 00:57:08'),(27,33,'in',5,0,5,NULL,NULL,'Initial stock on product creation',1,'2026-06-11 04:33:13','2026-06-11 04:33:13'),(28,33,'out',5,5,0,'App\\Models\\Transaction',18,'Sale via kiosk (confirmed)',NULL,'2026-06-11 05:57:49','2026-06-11 05:57:49'),(29,34,'in',32,0,32,NULL,NULL,'Initial stock on product creation',1,'2026-06-11 06:03:24','2026-06-11 06:03:24'),(30,33,'adjustment',10,0,10,NULL,NULL,'Manual quick adjustment',1,'2026-06-11 06:07:15','2026-06-11 06:07:15'),(31,33,'adjustment',1,10,11,NULL,NULL,'Manual quick adjustment',1,'2026-06-11 06:07:22','2026-06-11 06:07:22'),(32,33,'in',12,11,23,'App\\Models\\StockEntry',7,'Stock entry approved: SE-20260611-EOGVGG',1,'2026-06-11 06:11:37','2026-06-11 06:11:37'),(33,33,'in',67,23,90,'App\\Models\\StockEntry',8,'Stock entry approved: SE-20260611-5VP4U0',1,'2026-06-11 06:21:39','2026-06-11 06:21:39'),(34,12,'in',6,5,11,'App\\Models\\StockEntry',11,'Stock entry approved: SE-20260611-8LVVA9',1,'2026-06-11 06:59:26','2026-06-11 06:59:26');
/*!40000 ALTER TABLE `inventory_movements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2024_01_01_000001_create_roles_table',1),(2,'2024_01_01_000002_create_users_table',1),(3,'2024_01_01_000003_create_categories_table',1),(4,'2024_01_01_000004_create_suppliers_table',1),(5,'2024_01_01_000005_create_products_table',1),(6,'2024_01_01_000006_create_transactions_table',1),(7,'2024_01_01_000007_create_transaction_items_table',1),(8,'2024_01_01_000008_create_stock_entries_table',1),(9,'2024_01_01_000009_create_stock_entry_items_table',1),(10,'2024_01_01_000010_create_inventory_movements_table',1),(11,'2024_01_01_000011_create_audit_logs_table',1),(12,'2024_01_01_000012_create_sessions_table',1),(13,'2024_01_01_000013_create_cache_table',1),(14,'2024_01_01_000014_create_jobs_table',1),(15,'2026_06_10_230607_create_settings_table',2),(16,'2026_06_11_142601_add_pricing_to_products_and_create_supplier_price_history',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint unsigned NOT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL COMMENT 'Supplier cost price for this product',
  `markup_percentage` decimal(5,2) DEFAULT NULL COMMENT 'Per-product markup override. NULL = use global setting.',
  `current_stock` int NOT NULL DEFAULT '0',
  `low_stock_threshold` int NOT NULL DEFAULT '10',
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'piece',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  UNIQUE KEY `products_barcode_unique` (`barcode`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Coca-Cola 330ml','Classic Coca-Cola carbonated soft drink in a 330ml can',1,1,'products/uDj3W9D8UsYkkJJmVzWWhk02jHFQahNMtQiPBsaH.webp','BEV-COLA330','5449000000996',35.00,NULL,NULL,150,20,'can',1,'2026-06-10 04:59:59','2026-06-11 06:39:18'),(2,'Sprite 330ml','Lemon-lime flavored carbonated drink in a 330ml can',1,1,NULL,'BEV-SPRT330','5449000001061',35.00,NULL,NULL,120,20,'can',1,'2026-06-10 04:59:59','2026-06-11 06:39:18'),(3,'Nestea Lemon Iced Tea 500ml','Refreshing lemon-flavored iced tea beverage',1,1,NULL,'BEV-NESTEA500','4800361414142',30.00,NULL,NULL,80,15,'bottle',1,'2026-06-10 04:59:59','2026-06-11 06:39:18'),(4,'Aquafina Purified Water 1L','Pure and refreshing purified drinking water',1,NULL,NULL,'BEV-AQUA1L','0012000001086',31.20,26.00,NULL,200,30,'bottle',1,'2026-06-10 05:00:00','2026-06-11 06:51:58'),(5,'Red Bull Energy Drink 250ml','Energy drink with taurine and caffeine',1,1,NULL,'BEV-REDB250','9002490100070',65.00,NULL,NULL,60,10,'can',1,'2026-06-10 05:00:00','2026-06-10 05:00:00'),(6,'Kopiko 78°C Coffee 240ml','Ready-to-drink smooth coffee beverage',1,1,NULL,'BEV-KOP240','8886001400023',28.00,NULL,NULL,8,10,'bottle',1,'2026-06-10 05:00:00','2026-06-10 05:00:00'),(7,'Minute Maid Orange Juice 1L','Fresh-tasting orange juice from concentrate',1,1,NULL,'BEV-MMOJ1L','5449000134127',85.00,NULL,NULL,40,10,'carton',1,'2026-06-10 05:00:01','2026-06-10 05:00:01'),(8,'Lay\'s Classic Potato Chips 184g','Crispy classic salted potato chips',2,2,NULL,'SNK-LAYS184','0028400064545',89.00,NULL,NULL,45,10,'bag',1,'2026-06-10 05:00:01','2026-06-10 05:00:01'),(9,'Pringles Original 107g','Stackable original flavor potato crisps',2,2,NULL,'SNK-PRNG107','5053990101573',99.00,NULL,NULL,35,8,'can',1,'2026-06-10 05:00:01','2026-06-10 05:00:01'),(10,'Oreo Original Cookies 133g','Chocolate sandwich cookies with vanilla cream filling',2,2,NULL,'SNK-OREO133','7622210100610',45.00,NULL,NULL,70,12,'pack',1,'2026-06-10 05:00:01','2026-06-10 05:00:01'),(11,'SkyFlakes Crackers 250g','Light and crispy saltine crackers',2,2,NULL,'SNK-SKYF250','4800092160325',52.00,NULL,NULL,90,15,'pack',1,'2026-06-10 05:00:01','2026-06-10 05:00:01'),(12,'Planters Mixed Nuts 292g','Premium mix of peanuts, cashews, almonds, and pecans',2,2,NULL,'SNK-PLAN292','0029000016811',320.00,NULL,NULL,11,8,'can',1,'2026-06-10 05:00:02','2026-06-11 06:59:26'),(13,'Jack \'n Jill Chippy 110g','Corn chips with barbecue flavor',2,2,NULL,'SNK-CHIP110','4800016551109',32.00,NULL,NULL,100,15,'bag',1,'2026-06-10 05:00:02','2026-06-10 05:00:02'),(14,'Monde Butter Cookies 400g','Assorted butter cookies in a decorative tin',2,2,NULL,'SNK-MOND400','4800166601012',150.00,NULL,NULL,25,5,'tin',1,'2026-06-10 05:00:02','2026-06-10 05:00:02'),(15,'Century Tuna Flakes in Oil 180g','Premium tuna flakes packed in vegetable oil',3,3,NULL,'CAN-TUNA180','4800092130168',42.00,NULL,NULL,100,20,'can',1,'2026-06-10 05:00:03','2026-06-10 05:00:03'),(16,'Argentina Corned Beef 260g','Classic corned beef in a convenient can',3,3,NULL,'CAN-CORN260','4800036760260',68.00,NULL,NULL,75,15,'can',1,'2026-06-10 05:00:03','2026-06-10 05:00:03'),(17,'Del Monte Pineapple Chunks 432g','Sweet pineapple chunks in light syrup',3,3,NULL,'CAN-PINE432','0024000163268',55.00,NULL,NULL,60,12,'can',1,'2026-06-10 05:00:03','2026-06-10 05:00:03'),(19,'Hunt\'s Pork and Beans 230g','Savory pork and beans in tomato sauce',3,3,NULL,'CAN-HUNT230','0027000379073',28.00,NULL,NULL,110,20,'can',1,'2026-06-10 05:00:04','2026-06-10 05:00:04'),(20,'Spam Classic Luncheon Meat 340g','Classic fully cooked luncheon meat',3,3,NULL,'CAN-SPAM340','0037600108003',185.00,NULL,NULL,30,8,'can',1,'2026-06-10 05:00:04','2026-06-10 05:00:04'),(21,'Magnolia Ice Cream Vanilla 750ml','Rich and creamy classic vanilla ice cream',4,4,NULL,'FRZ-ICVN750','4800787100758',180.00,NULL,NULL,25,5,'tub',1,'2026-06-10 05:00:04','2026-06-10 05:00:04'),(22,'McCain French Fries 750g','Premium golden crispy French fries',4,4,NULL,'FRZ-FRIE750','8710438091038',145.00,NULL,NULL,35,8,'bag',1,'2026-06-10 05:00:04','2026-06-10 05:00:04'),(23,'Bibigo Chicken Dumplings 500g','Korean-style chicken and vegetable dumplings',4,4,NULL,'FRZ-DUMP500','8801007057477',210.00,NULL,NULL,18,5,'pack',1,'2026-06-10 05:00:05','2026-06-10 05:00:05'),(24,'Green Giant Mixed Vegetables 450g','Frozen mix of corn, peas, carrots, and green beans',4,4,NULL,'FRZ-VEGM450','0020000121024',120.00,NULL,NULL,22,5,'bag',1,'2026-06-10 05:00:05','2026-06-10 05:00:05'),(25,'Tender Juicy Hotdog 1kg','Classic pork and chicken hotdogs',4,4,NULL,'FRZ-HOTD1KG','4800092162022',165.00,NULL,NULL,40,10,'pack',1,'2026-06-10 05:00:05','2026-06-10 05:00:05'),(26,'Joy Dishwashing Liquid Lemon 500ml','Powerful grease-cutting dishwashing liquid',5,5,NULL,'HH-JOY500','4902430890922',78.00,NULL,NULL,55,10,'bottle',1,'2026-06-10 05:00:05','2026-06-10 05:00:05'),(27,'Ariel Powder Detergent 1kg','Premium laundry detergent powder with stain removal',5,5,NULL,'HH-ARIEL1KG','4902430890939',145.00,NULL,NULL,40,8,'pack',1,'2026-06-10 05:00:06','2026-06-10 05:00:06'),(28,'Lysol Disinfectant Spray 340g','Kills 99.9% of viruses and bacteria on surfaces',5,5,NULL,'HH-LYSOL340','0019200044284',295.00,NULL,NULL,3,5,'can',1,'2026-06-10 05:00:06','2026-06-11 06:39:18'),(29,'Bounty Paper Towels 2-Ply','Absorbent and strong 2-ply paper towels',5,5,NULL,'HH-BOUNT2P','0037000744849',120.00,NULL,NULL,50,10,'roll',1,'2026-06-10 05:00:06','2026-06-11 06:39:19'),(30,'Glad Trash Bags 30 Gallon 25ct','Heavy-duty drawstring trash bags',5,5,'products/Wz6ZX8vVJFiWhu0gexL7CypykTFHmkf6c95DFDgk.png','HH-GLAD30G','0012587700211',185.00,NULL,NULL,20,5,'box',1,'2026-06-10 05:00:06','2026-06-11 04:32:52'),(31,'carl',NULL,2,2,'products/test.png','PRD-6K42NM','338898357250',67.00,NULL,NULL,54,10,'piece',1,'2026-06-10 14:50:32','2026-06-10 14:58:18'),(32,'karu','hhhii',2,2,'products/fkvsKHSVrMV7bS3wlvGE8kbG5FjuuLFzVQl4IoEo.jpg','PRD-YGR06C','862156288349',6767.00,NULL,NULL,9,10,'piece',1,'2026-06-10 15:16:32','2026-06-10 15:19:16'),(33,'hihi','dgdsg',1,NULL,'products/1eqnqmr2cym2mac8K4VDevhSeiqwRZKI2zsBpzKy.png','PRD-I1ICSX','080530270291',14.40,12.00,NULL,90,10,'piece',1,'2026-06-11 04:33:13','2026-06-11 06:52:35'),(34,'sfasf','fsfsfs',2,2,'products/vJYmE5WWxARE6cu9KbmnTnyNaaaWialu4xYUQJLz.jpg','PRD-P6XVVF','063109292475',32.00,NULL,NULL,32,10,'piece',1,'2026-06-11 06:03:24','2026-06-11 06:04:00'),(35,'Campbell\'s Cream of Mushroom Soup 298g','Rich and creamy condensed mushroom soup',3,3,NULL,'CAN-CAMP298','0051000012517',95.00,NULL,NULL,7,10,'can',1,'2026-06-11 06:39:18','2026-06-11 06:39:18');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Admin','Full system access with all privileges','2026-06-10 04:59:54','2026-06-10 04:59:54'),(2,'inventory_manager','Inventory Manager','Manage products, categories, suppliers, and inventory','2026-06-10 04:59:54','2026-06-10 04:59:54'),(3,'auditor','Auditor','Read-only access to view reports and logs','2026-06-10 04:59:54','2026-06-10 04:59:54');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('gq9KmiHFkjG5nuZjjWXhfIGj2sXRgNXxUGF1WlLw',NULL,'127.0.0.1','curl/8.5.0','eyJfdG9rZW4iOiJrWWlQZnVrZTFObWhaVlJpMXFDZE5KY05sMVVoNjYybjl4bWxKY3IyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1781155397),('OHVxKE4jWEeOdLwaSK6M4jfppQ8TN1kyZnPtQ1bA',1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJkVFdBWEcwVVdYUzEzRTVJVlBjSElKYUE3SEVyMzM2SnVJUkFNdFh1IiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9zdG9jay1lbnRyaWVzXC8xMSIsInJvdXRlIjoiYWRtaW4uc3RvY2stZW50cmllcy5zaG93In0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==',1781161172),('S81YRhHgUqQs8jG2AqPf1g8J1LHRj5TgSY3nQmKv',3,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJObHg0dW1vTjFDN1ZGclYyMXBPamZxTXNpY1BqUUY0TWJqejZJckZDIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6WyJzdWNjZXNzIl19LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjMsInN1Y2Nlc3MiOiJXZWxjb21lIGJhY2ssIFN5c3RlbSBBdWRpdG9yISJ9',1781153939);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'store_name','PureVibe Kiosk','2026-06-10 15:41:20','2026-06-10 15:41:20'),(2,'contact_email','support@purevibe.com','2026-06-10 15:41:21','2026-06-10 15:41:21'),(3,'contact_phone','(555) 123-4567','2026-06-10 15:41:21','2026-06-10 15:41:21'),(4,'store_address','123 Grocery Lane&#10;Market District','2026-06-10 15:41:21','2026-06-10 15:41:21'),(5,'default_tax_rate','13','2026-06-10 15:41:21','2026-06-10 15:41:21'),(6,'tax_name','VAT','2026-06-10 15:41:22','2026-06-10 15:41:22'),(7,'receipt_header','Welcome to PureVibe!','2026-06-10 15:41:22','2026-06-10 15:41:22'),(8,'receipt_footer','Thank you for shopping with us!&#10;Please come again.','2026-06-10 15:41:22','2026-06-10 15:41:22'),(9,'idle_timeout','120','2026-06-10 15:41:22','2026-06-10 15:41:22'),(10,'currency_symbol','₱','2026-06-10 15:41:23','2026-06-10 15:41:23'),(11,'enable_sound','1','2026-06-10 15:41:23','2026-06-10 15:41:23'),(12,'allow_guest','1','2026-06-10 15:41:23','2026-06-10 15:41:23'),(13,'prices_include_tax','1','2026-06-10 15:41:23','2026-06-10 15:41:53'),(14,'default_markup_percentage','20','2026-06-11 06:26:43','2026-06-11 06:26:43');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_entries`
--

DROP TABLE IF EXISTS `stock_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_entries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `entry_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_entries_entry_number_unique` (`entry_number`),
  KEY `stock_entries_supplier_id_foreign` (`supplier_id`),
  KEY `stock_entries_user_id_foreign` (`user_id`),
  KEY `stock_entries_approved_by_foreign` (`approved_by`),
  CONSTRAINT `stock_entries_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `stock_entries_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `stock_entries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_entries`
--

LOCK TABLES `stock_entries` WRITE;
/*!40000 ALTER TABLE `stock_entries` DISABLE KEYS */;
INSERT INTO `stock_entries` VALUES (1,'SE-20260610-GTIB1T',2,1,'approved','Add lysol',1,'2026-06-11 00:57:08','2026-06-10 05:55:54','2026-06-11 00:57:08'),(2,'SE-20260610-QUHABH',5,1,'approved','Restocking lysol',1,'2026-06-11 00:57:02','2026-06-10 06:07:36','2026-06-11 00:57:02'),(3,'SE-20260610-QICUVO',5,1,'approved',NULL,1,'2026-06-11 00:56:53','2026-06-10 14:13:46','2026-06-11 00:56:53'),(4,'SE-20260610-17T6NQ',4,1,'approved',NULL,1,'2026-06-10 14:28:07','2026-06-10 14:18:36','2026-06-10 14:28:07'),(7,'SE-20260611-EOGVGG',2,1,'approved',NULL,1,'2026-06-11 06:11:37','2026-06-11 06:11:23','2026-06-11 06:11:37'),(8,'SE-20260611-5VP4U0',6,1,'approved',NULL,1,'2026-06-11 06:21:39','2026-06-11 06:21:33','2026-06-11 06:21:39'),(9,'SE-20260611-DHCGKU',1,1,'rejected',NULL,1,'2026-06-11 06:54:35','2026-06-11 06:50:24','2026-06-11 06:54:35'),(10,'SE-20260611-YVBUYJ',3,1,'rejected',NULL,1,'2026-06-11 06:54:20','2026-06-11 06:53:28','2026-06-11 06:54:20'),(11,'SE-20260611-8LVVA9',2,1,'approved',NULL,1,'2026-06-11 06:59:26','2026-06-11 06:59:16','2026-06-11 06:59:26');
/*!40000 ALTER TABLE `stock_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_entry_items`
--

DROP TABLE IF EXISTS `stock_entry_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_entry_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stock_entry_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_entry_items_stock_entry_id_foreign` (`stock_entry_id`),
  KEY `stock_entry_items_product_id_foreign` (`product_id`),
  CONSTRAINT `stock_entry_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_entry_items_stock_entry_id_foreign` FOREIGN KEY (`stock_entry_id`) REFERENCES `stock_entries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_entry_items`
--

LOCK TABLES `stock_entry_items` WRITE;
/*!40000 ALTER TABLE `stock_entry_items` DISABLE KEYS */;
INSERT INTO `stock_entry_items` VALUES (1,1,28,5,NULL,NULL,'2026-06-10 05:55:54','2026-06-10 05:55:54'),(2,2,28,6,NULL,NULL,'2026-06-10 06:07:36','2026-06-10 06:07:36'),(3,3,28,6,NULL,NULL,'2026-06-10 14:13:46','2026-06-10 14:13:46'),(4,4,28,6,NULL,NULL,'2026-06-10 14:18:36','2026-06-10 14:18:36'),(5,7,33,12,121.00,NULL,'2026-06-11 06:11:23','2026-06-11 06:11:23'),(6,8,33,67,212.00,NULL,'2026-06-11 06:21:33','2026-06-11 06:21:33'),(7,9,4,212,NULL,NULL,'2026-06-11 06:50:24','2026-06-11 06:50:24'),(8,10,15,12,NULL,NULL,'2026-06-11 06:53:28','2026-06-11 06:53:28'),(9,11,12,6,NULL,NULL,'2026-06-11 06:59:16','2026-06-11 06:59:16');
/*!40000 ALTER TABLE `stock_entry_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_product_prices`
--

DROP TABLE IF EXISTS `supplier_product_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_product_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `cost_price` decimal(10,2) NOT NULL COMMENT 'Price supplier charges us',
  `selling_price` decimal(10,2) NOT NULL COMMENT 'Calculated selling price at time of recording',
  `markup_percentage` decimal(5,2) NOT NULL COMMENT 'Markup % applied at time of recording',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Reason for price change',
  `recorded_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_product_prices_supplier_id_foreign` (`supplier_id`),
  KEY `supplier_product_prices_product_id_foreign` (`product_id`),
  KEY `supplier_product_prices_recorded_by_foreign` (`recorded_by`),
  CONSTRAINT `supplier_product_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `supplier_product_prices_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `supplier_product_prices_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_product_prices`
--

LOCK TABLES `supplier_product_prices` WRITE;
/*!40000 ALTER TABLE `supplier_product_prices` DISABLE KEYS */;
INSERT INTO `supplier_product_prices` VALUES (1,6,4,26.00,31.20,20.00,'Supplier edit manual cost update',1,'2026-06-11 06:51:43','2026-06-11 06:51:43'),(2,6,33,12.00,14.40,20.00,'Supplier edit manual cost update',1,'2026-06-11 06:52:18','2026-06-11 06:52:18');
/*!40000 ALTER TABLE `supplier_product_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Pacific Beverages Inc.','Juan Dela Cruz','+63 917 123 4567','sales@pacificbev.com','123 Industrial Ave, Makati City, Metro Manila',1,'2026-06-10 04:59:58','2026-06-10 04:59:58'),(2,'Golden Snacks Trading','Maria Santos','+63 918 234 5678','orders@goldensnacks.com','456 Commerce St, Quezon City, Metro Manila',1,'2026-06-10 04:59:58','2026-06-10 04:59:58'),(3,'Metro Canned Goods Corp.','Pedro Reyes','+63 919 345 6789','supply@metrocanned.com','789 Warehouse Blvd, Pasig City, Metro Manila',1,'2026-06-10 04:59:58','2026-06-10 04:59:58'),(4,'Arctic Frozen Foods Co.','Ana Garcia','+63 920 456 7890','info@arcticfoods.com','321 Cold Storage Rd, Taguig City, Metro Manila',1,'2026-06-10 04:59:58','2026-06-10 04:59:58'),(5,'CleanHome Distributors','Roberto Mendoza','+63 921 567 8901','orders@cleanhome.com','654 Supply Chain Ave, Mandaluyong City, Metro Manila',1,'2026-06-10 04:59:59','2026-06-10 05:31:46'),(6,'Vladiver','Shawn Michael Regencia','09765724466','shawn@gmail.com','ditosatabikostreetmissnakita',1,'2026-06-10 05:31:14','2026-06-10 05:31:14');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_items`
--

DROP TABLE IF EXISTS `transaction_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaction_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_items_transaction_id_foreign` (`transaction_id`),
  KEY `transaction_items_product_id_foreign` (`product_id`),
  CONSTRAINT `transaction_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaction_items_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_items`
--

LOCK TABLES `transaction_items` WRITE;
/*!40000 ALTER TABLE `transaction_items` DISABLE KEYS */;
INSERT INTO `transaction_items` VALUES (1,1,1,'Coca-Cola 330ml',35.00,1,35.00,'2026-06-10 05:08:13','2026-06-10 05:08:13'),(2,2,3,'Nestea Lemon Iced Tea 500ml',30.00,5,150.00,'2026-06-10 05:24:55','2026-06-10 05:24:55'),(3,2,4,'Aquafina Purified Water 1L',25.00,7,175.00,'2026-06-10 05:24:55','2026-06-10 05:24:55'),(4,3,4,'Aquafina Purified Water 1L',25.00,1,25.00,'2026-06-10 05:25:18','2026-06-10 05:25:18'),(5,3,3,'Nestea Lemon Iced Tea 500ml',30.00,1,30.00,'2026-06-10 05:25:18','2026-06-10 05:25:18'),(6,4,28,'Lysol Disinfectant Spray 340g',295.00,2,590.00,'2026-06-10 05:42:16','2026-06-10 05:42:16'),(7,5,28,'Lysol Disinfectant Spray 340g',295.00,1,295.00,'2026-06-10 05:48:22','2026-06-10 05:48:22'),(8,6,29,'Bounty Paper Towels 2-Ply',120.00,1,120.00,'2026-06-10 05:48:49','2026-06-10 05:48:49'),(9,7,29,'Bounty Paper Towels 2-Ply',120.00,1,120.00,'2026-06-10 05:48:55','2026-06-10 05:48:55'),(10,8,3,'Nestea Lemon Iced Tea 500ml',30.00,2,60.00,'2026-06-10 14:47:50','2026-06-10 14:47:50'),(11,10,32,'karu',6767.00,1,6767.00,'2026-06-10 15:16:50','2026-06-10 15:16:50'),(12,11,32,'karu',6767.00,1,6767.00,'2026-06-10 15:19:16','2026-06-10 15:19:16'),(13,12,2,'Sprite 330ml',35.00,1,35.00,'2026-06-10 15:32:57','2026-06-10 15:32:57'),(14,13,3,'Nestea Lemon Iced Tea 500ml',30.00,1,30.00,'2026-06-10 15:33:09','2026-06-10 15:33:09'),(15,14,12,'Planters Mixed Nuts 292g',320.00,1,320.00,'2026-06-10 15:35:21','2026-06-10 15:35:21'),(16,15,1,'Coca-Cola 330ml',35.00,1,35.00,'2026-06-10 15:35:51','2026-06-10 15:35:51'),(17,16,4,'Aquafina Purified Water 1L',25.00,1,25.00,'2026-06-11 00:28:26','2026-06-11 00:28:26'),(18,16,3,'Nestea Lemon Iced Tea 500ml',30.00,1,30.00,'2026-06-11 00:28:26','2026-06-11 00:28:26'),(19,17,4,'Aquafina Purified Water 1L',25.00,1,25.00,'2026-06-11 00:47:05','2026-06-11 00:47:05'),(20,18,33,'hihi',54.00,5,270.00,'2026-06-11 05:57:41','2026-06-11 05:57:41');
/*!40000 ALTER TABLE `transaction_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_transaction_number_unique` (`transaction_number`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,'TXN-20260610-FQAXNA',35.00,0.00,0.00,35.00,'cash','completed',NULL,'2026-06-10 05:08:13','2026-06-10 05:08:13'),(2,'TXN-20260610-ETJNGL',325.00,0.00,0.00,325.00,'cash','completed',NULL,'2026-06-10 05:24:55','2026-06-10 05:24:55'),(3,'TXN-20260610-YXGVQ2',55.00,0.00,0.00,55.00,'cash','completed',NULL,'2026-06-10 05:25:18','2026-06-10 05:25:18'),(4,'TXN-20260610-SOI1NL',590.00,0.00,0.00,590.00,'cash','completed',NULL,'2026-06-10 05:42:16','2026-06-10 05:42:16'),(5,'TXN-20260610-AHMERG',295.00,0.00,0.00,295.00,'cash','completed',NULL,'2026-06-10 05:48:22','2026-06-10 05:48:22'),(6,'TXN-20260610-FSZTRK',120.00,0.00,0.00,120.00,'cash','completed',NULL,'2026-06-10 05:48:49','2026-06-10 05:48:49'),(7,'TXN-20260610-BWQC4F',120.00,0.00,0.00,120.00,'cash','completed',NULL,'2026-06-10 05:48:55','2026-06-10 05:48:55'),(8,'TXN-20260610-JTKZME',60.00,0.00,0.00,60.00,'cash','completed',NULL,'2026-06-10 14:47:50','2026-06-10 14:47:50'),(9,'TXN-20260610-JSU0FO',100.00,0.00,0.00,100.00,'cash','completed',NULL,'2026-06-10 15:12:45','2026-06-10 15:45:25'),(10,'TXN-20260610-KFWRDC',6767.00,812.04,0.00,7579.04,'cash','completed',NULL,'2026-06-10 15:16:50','2026-06-10 15:34:52'),(11,'TXN-20260610-EFULIB',6767.00,812.04,0.00,7579.04,'cash','completed',NULL,'2026-06-10 15:19:16','2026-06-10 15:20:25'),(12,'TXN-20260610-QA6HCK',35.00,4.20,0.00,39.20,'cash','completed',NULL,'2026-06-10 15:32:57','2026-06-10 15:34:39'),(13,'TXN-20260610-JZMH1K',30.00,3.60,0.00,33.60,'cash','completed',NULL,'2026-06-10 15:33:09','2026-06-10 15:33:24'),(14,'TXN-20260610-SDH3UN',320.00,38.40,0.00,358.40,'cash','completed',NULL,'2026-06-10 15:35:21','2026-06-10 15:35:27'),(15,'TXN-20260610-KBA0JP',35.00,4.20,0.00,39.20,'cash','completed',NULL,'2026-06-10 15:35:51','2026-06-10 15:40:53'),(16,'TXN-20260611-6SR472',55.00,7.15,0.00,62.15,'cash','completed',NULL,'2026-06-11 00:28:26','2026-06-11 00:29:18'),(17,'TXN-20260611-R9NJDI',25.00,3.25,0.00,28.25,'cash','completed',NULL,'2026-06-11 00:47:05','2026-06-11 00:47:17'),(18,'TXN-20260611-C0HVKW',270.00,35.10,0.00,305.10,'cash','completed',NULL,'2026-06-11 05:57:41','2026-06-11 05:57:49');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'System Administrator','admin@grocery.com','admin','$2y$12$dTeyWKdSTjjf5wesFR2f7.VDsLiSfTNFEEFa/NILm8gwRGUCNi7fW',1,NULL,1,'2026-06-11 05:06:28',NULL,'2026-06-10 04:59:55','2026-06-11 06:39:17'),(2,'Inventory Manager','manager@grocery.com','manager','$2y$12$wLGREiSEMLCbZcIdJYRME.HNyOSx7EVDFqz0EixKXtTUX43pAXVRe',2,NULL,1,'2026-06-11 05:03:14',NULL,'2026-06-10 04:59:55','2026-06-11 06:39:17'),(3,'System Auditor','auditor@grocery.com','auditor','$2y$12$VDGDUqf0uDk2DKm4nVKlHOVrynvTLcWhTRSV5pF1qEQYjfQJCgzge',3,NULL,1,'2026-06-11 05:06:02',NULL,'2026-06-10 04:59:56','2026-06-11 06:39:17'),(4,'Carl-Jinayon\'s Org','carljinayon18@gmail.com','admin23','$2y$12$ivy0ujnX3UWb/j.u6T94Ku8zT9Pf88ibyBNb/ibA3Ire.wKEnqefi',2,NULL,1,NULL,NULL,'2026-06-11 04:52:02','2026-06-11 04:52:02'),(5,'sfasf','carljinayon11@gmail.com','auditor23','$2y$12$vbnVw1P339J0fJFQJFpRiuqE4oMNr3wSlhOxSmNen49yZM2ONe0uS',3,NULL,1,NULL,NULL,'2026-06-11 06:09:57','2026-06-11 06:09:57');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-11 15:04:41
