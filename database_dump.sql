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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Beverages','Drinks, juices, sodas, water, and other beverages',NULL,1,'2026-06-10 04:59:56','2026-06-10 04:59:56'),(2,'Snacks','Chips, crackers, cookies, nuts, and other snack items',NULL,1,'2026-06-10 04:59:56','2026-06-10 04:59:56'),(3,'Canned Goods','Canned vegetables, fruits, meats, soups, and sauces',NULL,1,'2026-06-10 04:59:57','2026-06-10 04:59:57'),(4,'Frozen Foods','Frozen meals, vegetables, ice cream, and frozen treats',NULL,1,'2026-06-10 04:59:57','2026-06-10 04:59:57'),(5,'Household Products','Cleaning supplies, paper goods, and household essentials',NULL,1,'2026-06-10 04:59:57','2026-06-10 04:59:57');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_movements`
--

LOCK TABLES `inventory_movements` WRITE;
/*!40000 ALTER TABLE `inventory_movements` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2024_01_01_000001_create_roles_table',1),(2,'2024_01_01_000002_create_users_table',1),(3,'2024_01_01_000003_create_categories_table',1),(4,'2024_01_01_000004_create_suppliers_table',1),(5,'2024_01_01_000005_create_products_table',1),(6,'2024_01_01_000006_create_transactions_table',1),(7,'2024_01_01_000007_create_transaction_items_table',1),(8,'2024_01_01_000008_create_stock_entries_table',1),(9,'2024_01_01_000009_create_stock_entry_items_table',1),(10,'2024_01_01_000010_create_inventory_movements_table',1),(11,'2024_01_01_000011_create_audit_logs_table',1),(12,'2024_01_01_000012_create_sessions_table',1),(13,'2024_01_01_000013_create_cache_table',1),(14,'2024_01_01_000014_create_jobs_table',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Coca-Cola 330ml','Classic Coca-Cola carbonated soft drink in a 330ml can',1,1,NULL,'BEV-COLA330','5449000000996',35.00,150,20,'can',1,'2026-06-10 04:59:59','2026-06-10 04:59:59'),(2,'Sprite 330ml','Lemon-lime flavored carbonated drink in a 330ml can',1,1,NULL,'BEV-SPRT330','5449000001061',35.00,120,20,'can',1,'2026-06-10 04:59:59','2026-06-10 04:59:59'),(3,'Nestea Lemon Iced Tea 500ml','Refreshing lemon-flavored iced tea beverage',1,1,NULL,'BEV-NESTEA500','4800361414142',30.00,80,15,'bottle',1,'2026-06-10 04:59:59','2026-06-10 04:59:59'),(4,'Aquafina Purified Water 1L','Pure and refreshing purified drinking water',1,1,NULL,'BEV-AQUA1L','0012000001086',25.00,200,30,'bottle',1,'2026-06-10 05:00:00','2026-06-10 05:00:00'),(5,'Red Bull Energy Drink 250ml','Energy drink with taurine and caffeine',1,1,NULL,'BEV-REDB250','9002490100070',65.00,60,10,'can',1,'2026-06-10 05:00:00','2026-06-10 05:00:00'),(6,'Kopiko 78°C Coffee 240ml','Ready-to-drink smooth coffee beverage',1,1,NULL,'BEV-KOP240','8886001400023',28.00,8,10,'bottle',1,'2026-06-10 05:00:00','2026-06-10 05:00:00'),(7,'Minute Maid Orange Juice 1L','Fresh-tasting orange juice from concentrate',1,1,NULL,'BEV-MMOJ1L','5449000134127',85.00,40,10,'carton',1,'2026-06-10 05:00:01','2026-06-10 05:00:01'),(8,'Lay\'s Classic Potato Chips 184g','Crispy classic salted potato chips',2,2,NULL,'SNK-LAYS184','0028400064545',89.00,45,10,'bag',1,'2026-06-10 05:00:01','2026-06-10 05:00:01'),(9,'Pringles Original 107g','Stackable original flavor potato crisps',2,2,NULL,'SNK-PRNG107','5053990101573',99.00,35,8,'can',1,'2026-06-10 05:00:01','2026-06-10 05:00:01'),(10,'Oreo Original Cookies 133g','Chocolate sandwich cookies with vanilla cream filling',2,2,NULL,'SNK-OREO133','7622210100610',45.00,70,12,'pack',1,'2026-06-10 05:00:01','2026-06-10 05:00:01'),(11,'SkyFlakes Crackers 250g','Light and crispy saltine crackers',2,2,NULL,'SNK-SKYF250','4800092160325',52.00,90,15,'pack',1,'2026-06-10 05:00:01','2026-06-10 05:00:01'),(12,'Planters Mixed Nuts 292g','Premium mix of peanuts, cashews, almonds, and pecans',2,2,NULL,'SNK-PLAN292','0029000016811',320.00,5,8,'can',1,'2026-06-10 05:00:02','2026-06-10 05:00:02'),(13,'Jack \'n Jill Chippy 110g','Corn chips with barbecue flavor',2,2,NULL,'SNK-CHIP110','4800016551109',32.00,100,15,'bag',1,'2026-06-10 05:00:02','2026-06-10 05:00:02'),(14,'Monde Butter Cookies 400g','Assorted butter cookies in a decorative tin',2,2,NULL,'SNK-MOND400','4800166601012',150.00,25,5,'tin',1,'2026-06-10 05:00:02','2026-06-10 05:00:02'),(15,'Century Tuna Flakes in Oil 180g','Premium tuna flakes packed in vegetable oil',3,3,NULL,'CAN-TUNA180','4800092130168',42.00,100,20,'can',1,'2026-06-10 05:00:03','2026-06-10 05:00:03'),(16,'Argentina Corned Beef 260g','Classic corned beef in a convenient can',3,3,NULL,'CAN-CORN260','4800036760260',68.00,75,15,'can',1,'2026-06-10 05:00:03','2026-06-10 05:00:03'),(17,'Del Monte Pineapple Chunks 432g','Sweet pineapple chunks in light syrup',3,3,NULL,'CAN-PINE432','0024000163268',55.00,60,12,'can',1,'2026-06-10 05:00:03','2026-06-10 05:00:03'),(18,'Campbell\'s Cream of Mushroom Soup 298g','Rich and creamy condensed mushroom soup',3,3,NULL,'CAN-CAMP298','0051000012517',95.00,7,10,'can',1,'2026-06-10 05:00:03','2026-06-10 05:00:03'),(19,'Hunt\'s Pork and Beans 230g','Savory pork and beans in tomato sauce',3,3,NULL,'CAN-HUNT230','0027000379073',28.00,110,20,'can',1,'2026-06-10 05:00:04','2026-06-10 05:00:04'),(20,'Spam Classic Luncheon Meat 340g','Classic fully cooked luncheon meat',3,3,NULL,'CAN-SPAM340','0037600108003',185.00,30,8,'can',1,'2026-06-10 05:00:04','2026-06-10 05:00:04'),(21,'Magnolia Ice Cream Vanilla 750ml','Rich and creamy classic vanilla ice cream',4,4,NULL,'FRZ-ICVN750','4800787100758',180.00,25,5,'tub',1,'2026-06-10 05:00:04','2026-06-10 05:00:04'),(22,'McCain French Fries 750g','Premium golden crispy French fries',4,4,NULL,'FRZ-FRIE750','8710438091038',145.00,35,8,'bag',1,'2026-06-10 05:00:04','2026-06-10 05:00:04'),(23,'Bibigo Chicken Dumplings 500g','Korean-style chicken and vegetable dumplings',4,4,NULL,'FRZ-DUMP500','8801007057477',210.00,18,5,'pack',1,'2026-06-10 05:00:05','2026-06-10 05:00:05'),(24,'Green Giant Mixed Vegetables 450g','Frozen mix of corn, peas, carrots, and green beans',4,4,NULL,'FRZ-VEGM450','0020000121024',120.00,22,5,'bag',1,'2026-06-10 05:00:05','2026-06-10 05:00:05'),(25,'Tender Juicy Hotdog 1kg','Classic pork and chicken hotdogs',4,4,NULL,'FRZ-HOTD1KG','4800092162022',165.00,40,10,'pack',1,'2026-06-10 05:00:05','2026-06-10 05:00:05'),(26,'Joy Dishwashing Liquid Lemon 500ml','Powerful grease-cutting dishwashing liquid',5,5,NULL,'HH-JOY500','4902430890922',78.00,55,10,'bottle',1,'2026-06-10 05:00:05','2026-06-10 05:00:05'),(27,'Ariel Powder Detergent 1kg','Premium laundry detergent powder with stain removal',5,5,NULL,'HH-ARIEL1KG','4902430890939',145.00,40,8,'pack',1,'2026-06-10 05:00:06','2026-06-10 05:00:06'),(28,'Lysol Disinfectant Spray 340g','Kills 99.9% of viruses and bacteria on surfaces',5,5,NULL,'HH-LYSOL340','0019200044284',295.00,3,5,'can',1,'2026-06-10 05:00:06','2026-06-10 05:00:06'),(29,'Bounty Paper Towels 2-Ply','Absorbent and strong 2-ply paper towels',5,5,NULL,'HH-BOUNT2P','0037000744849',120.00,50,10,'roll',1,'2026-06-10 05:00:06','2026-06-10 05:00:06'),(30,'Glad Trash Bags 30 Gallon 25ct','Heavy-duty drawstring trash bags',5,5,NULL,'HH-GLAD30G','0012587700211',185.00,20,5,'box',1,'2026-06-10 05:00:06','2026-06-10 05:00:06');
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
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_entries`
--

LOCK TABLES `stock_entries` WRITE;
/*!40000 ALTER TABLE `stock_entries` DISABLE KEYS */;
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
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_entry_items_stock_entry_id_foreign` (`stock_entry_id`),
  KEY `stock_entry_items_product_id_foreign` (`product_id`),
  CONSTRAINT `stock_entry_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_entry_items_stock_entry_id_foreign` FOREIGN KEY (`stock_entry_id`) REFERENCES `stock_entries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_entry_items`
--

LOCK TABLES `stock_entry_items` WRITE;
/*!40000 ALTER TABLE `stock_entry_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_entry_items` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Pacific Beverages Inc.','Juan Dela Cruz','+63 917 123 4567','sales@pacificbev.com','123 Industrial Ave, Makati City, Metro Manila',1,'2026-06-10 04:59:58','2026-06-10 04:59:58'),(2,'Golden Snacks Trading','Maria Santos','+63 918 234 5678','orders@goldensnacks.com','456 Commerce St, Quezon City, Metro Manila',1,'2026-06-10 04:59:58','2026-06-10 04:59:58'),(3,'Metro Canned Goods Corp.','Pedro Reyes','+63 919 345 6789','supply@metrocanned.com','789 Warehouse Blvd, Pasig City, Metro Manila',1,'2026-06-10 04:59:58','2026-06-10 04:59:58'),(4,'Arctic Frozen Foods Co.','Ana Garcia','+63 920 456 7890','info@arcticfoods.com','321 Cold Storage Rd, Taguig City, Metro Manila',1,'2026-06-10 04:59:58','2026-06-10 04:59:58'),(5,'CleanHome Distributors','Roberto Mendoza','+63 921 567 8901','orders@cleanhome.com','654 Supply Chain Ave, Mandaluyong City, Metro Manila',1,'2026-06-10 04:59:59','2026-06-10 04:59:59');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_items`
--

LOCK TABLES `transaction_items` WRITE;
/*!40000 ALTER TABLE `transaction_items` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'System Administrator','admin@grocery.com','admin','$2y$12$uCaYc5ODPzlHUx8Bvn8rZunJDtA0I7WswHMzp/5uyF.LSVbscM7YW',1,NULL,1,NULL,NULL,'2026-06-10 04:59:55','2026-06-10 04:59:55'),(2,'Inventory Manager','manager@grocery.com','manager','$2y$12$KxGxBPsq4X298L3TndLCH.HcKEpH0hcC66Lk4zIEv9jr4k.mp0eDW',2,NULL,1,NULL,NULL,'2026-06-10 04:59:55','2026-06-10 04:59:55'),(3,'System Auditor','auditor@grocery.com','auditor','$2y$12$IpacvHAM/G9c3fVas3u4PepwSeN6gOTwbYK9.TVOQdeiupuDgNU0C',3,NULL,1,NULL,NULL,'2026-06-10 04:59:56','2026-06-10 04:59:56');
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

-- Dump completed on 2026-06-10 21:06:24
