-- =========================================================================
-- DCIT 55A: PureVibe "Dirty Data" Seed Script
-- WARNING: This script clears your current tables and inserts records
-- containing intentional data quality issues for assessment and cleaning.
-- Issues included: NULL prices, negative stock, inconsistent casing, duplicate SKUs.
-- =========================================================================

-- Temporarily disable strict mode so NULL values can be inserted into NOT NULL columns.
-- This is intentional — the dirty data demonstrates data quality issues.
SET sql_mode = '';
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Wipe existing data
DELETE FROM transaction_items;
DELETE FROM transactions;
DELETE FROM inventory_movements;
DELETE FROM stock_entries;
DELETE FROM supplier_product_prices;
DELETE FROM products;
DELETE FROM suppliers;
DELETE FROM categories;


-- =========================================================================
-- 2. INSERT CATEGORIES (10 Records)
-- ISSUE: Inconsistent Formatting / Casing
-- =========================================================================
INSERT INTO categories (id, name, description, created_at, updated_at) VALUES
(1, 'electronics', 'Electronic items and gadgets', NOW(), NOW()),
(2, 'ELECTRONICS', 'Duplicate category with caps', NOW(), NOW()),
(3, 'Furniture', 'Home and office furniture', NOW(), NOW()),
(4, 'furniture', 'lower case furniture', NOW(), NOW()),
(5, 'Groceries', 'Food and beverages', NOW(), NOW()),
(6, 'GROCERIES', 'ALL CAPS GROCERY', NOW(), NOW()),
(7, 'cleaning supplies', 'Household cleaning', NOW(), NOW()),
(8, 'Stationery', 'Office and school supplies', NOW(), NOW()),
(9, 'Clothing', 'Apparel and garments', NOW(), NOW()),
(10, 'Health & Beauty', 'Personal care products', NOW(), NOW());

-- =========================================================================
-- 3. INSERT SUPPLIERS (10 Records)
-- ISSUE: Missing Data (NULL phones, empty phones)
-- =========================================================================
INSERT INTO suppliers (id, name, contact_person, email, phone, address, is_active, created_at, updated_at) VALUES
(1, 'TechNova Distributors', 'Alice Smith', 'alice@technova.com', '0917-123-4567', 'Manila, PH', 1, NOW(), NOW()),
(2, 'MegaMarts Ltd', 'Bob Johnson', 'bob@megamarts.com', NULL, 'Cebu, PH', 1, NOW(), NOW()),
(3, 'Global Supplies Inc', 'Charlie Brown', 'charlie@globalsupplies.com', '', 'Davao, PH', 1, NOW(), NOW()),
(4, 'Fresh Farms Co.', 'Diana Prince', 'diana@freshfarms.com', '0918-987-6543', 'Baguio, PH', 1, NOW(), NOW()),
(5, 'CleanCo International', 'Evan Wright', 'evan@cleanco.com', NULL, 'Quezon City, PH', 1, NOW(), NOW()),
(6, 'OfficePro Wholesale', 'Fiona Davis', 'fiona@officepro.com', '0922-333-4444', 'Makati, PH', 1, NOW(), NOW()),
(7, 'Trendy Threads', 'George Lee', 'george@trendythreads.com', NULL, 'Taguig, PH', 1, NOW(), NOW()),
(8, 'BeautyBasics', 'Hannah White', 'hannah@beautybasics.com', '', 'Pasig, PH', 1, NOW(), NOW()),
(9, 'HomeEssentials', 'Ian Black', 'ian@homeessentials.com', '0919-555-6666', 'Mandaluyong, PH', 1, NOW(), NOW()),
(10, 'Gourmet Foods', 'Julia Green', 'julia@gourmetfoods.com', '0920-777-8888', 'Alabang, PH', 1, NOW(), NOW());

-- =========================================================================
-- 4. INSERT PRODUCTS (60 Records)
-- ISSUES: 
-- 1. Missing Data (NULL unit_price)
-- 2. Invalid Data (Negative current_stock)
-- 3. Duplicates (Duplicate SKUs)
-- =========================================================================
INSERT INTO products (id, sku, name, description, unit_price, current_stock, low_stock_threshold, category_id, supplier_id, is_active, barcode, unit, created_at, updated_at) VALUES
-- Normal records
(1, 'SKU-001', 'Wireless Mouse', 'Ergonomic wireless mouse', 450.00, 50, 10, 1, 1, 1, '10000000001', 'piece', NOW(), NOW()),
(2, 'SKU-002', 'Mechanical Keyboard', 'RGB mechanical keyboard', 1200.00, 30, 5, 2, 1, 1, '10000000002', 'piece', NOW(), NOW()),
(3, 'SKU-003', 'Office Chair', 'Ergonomic office chair', 3500.00, 15, 2, 3, 2, 1, '10000000003', 'piece', NOW(), NOW()),
(4, 'SKU-004', 'Wooden Desk', 'Solid wood office desk', 4500.00, 10, 2, 4, 2, 1, '10000000004', 'piece', NOW(), NOW()),
(5, 'SKU-005', 'Apple', 'Fresh red apples', 25.00, 100, 20, 5, 4, 1, '10000000005', 'piece', NOW(), NOW()),
(6, 'SKU-006', 'Banana', 'Fresh yellow bananas', 15.00, 150, 30, 6, 4, 1, '10000000006', 'piece', NOW(), NOW()),

-- NULL Pricing Issue (Missing Data)
(7, 'SKU-007', 'Liquid Soap', 'Antibacterial liquid soap', NULL, 80, 15, 7, 5, 1, '10000000007', 'bottle', NOW(), NOW()),
(8, 'SKU-008', 'Glass Cleaner', 'Window and glass cleaner', NULL, 60, 10, 7, 5, 1, '10000000008', 'bottle', NOW(), NOW()),
(9, 'SKU-009', 'Notebook', 'A5 lined notebook', NULL, 200, 50, 8, 6, 1, '10000000009', 'piece', NOW(), NOW()),
(10, 'SKU-010', 'Ballpen', 'Blue ink ballpen', NULL, 500, 100, 8, 6, 1, '10000000010', 'piece', NOW(), NOW()),

-- Negative Stock Issue (Invalid Data)
(11, 'SKU-011', 'T-Shirt', 'Plain white t-shirt', 150.00, -5, 10, 9, 7, 1, '10000000011', 'piece', NOW(), NOW()),
(12, 'SKU-012', 'Jeans', 'Blue denim jeans', 850.00, -12, 5, 9, 7, 1, '10000000012', 'piece', NOW(), NOW()),
(13, 'SKU-013', 'Shampoo', 'Anti-dandruff shampoo', 180.00, -3, 15, 10, 8, 1, '10000000013', 'bottle', NOW(), NOW()),

-- Duplicate SKU Issue (Data Redundancy)
(14, 'SKU-014', 'Face Wash', 'Daily face wash', 220.00, 40, 10, 10, 8, 1, '10000000014', 'tube', NOW(), NOW()),
(15, 'SKU-014', 'Face Wash', 'Daily face wash (duplicate entry)', 220.00, 40, 10, 10, 8, 1, '10000000014', 'tube', NOW(), NOW()),
(16, 'SKU-015', 'Coffee Beans', 'Arabica coffee beans 500g', 350.00, 25, 5, 5, 10, 1, '10000000015', 'bag', NOW(), NOW()),
(17, 'SKU-015', 'Coffee Beans', 'Arabica coffee beans 500g (dup)', 350.00, 25, 5, 5, 10, 1, '10000000015', 'bag', NOW(), NOW()),

-- Filler Products to reach 100+ total records
(18, 'SKU-018', 'Printer Paper', 'A4 80gsm 500 sheets', 250.00, 120, 20, 8, 6, 1, '10000000018', 'ream', NOW(), NOW()),
(19, 'SKU-019', 'Stapler', 'Heavy duty stapler', 350.00, 45, 10, 8, 6, 1, '10000000019', 'piece', NOW(), NOW()),
(20, 'SKU-020', 'Sticky Notes', '3x3 yellow notes', 45.00, 300, 50, 8, 6, 1, '10000000020', 'pad', NOW(), NOW()),
(21, 'SKU-021', 'USB Flash Drive', '32GB USB 3.0', 380.00, 85, 15, 1, 1, 1, '10000000021', 'piece', NOW(), NOW()),
(22, 'SKU-022', 'HDMI Cable', '2 meter braided HDMI', 150.00, 110, 20, 1, 1, 1, '10000000022', 'piece', NOW(), NOW()),
(23, 'SKU-023', 'Webcam', '1080p HD Webcam', 1800.00, 25, 5, 1, 1, 1, '10000000023', 'piece', NOW(), NOW()),
(24, 'SKU-024', 'Filing Cabinet', '3-drawer metal cabinet', 5500.00, 8, 2, 3, 2, 1, '10000000024', 'piece', NOW(), NOW()),
(25, 'SKU-025', 'Bookshelf', '5-tier wooden bookshelf', 2800.00, 12, 3, 4, 2, 1, '10000000025', 'piece', NOW(), NOW()),
(26, 'SKU-026', 'Orange', 'Navel orange', 30.00, 90, 20, 5, 4, 1, '10000000026', 'piece', NOW(), NOW()),
(27, 'SKU-027', 'Milk', '1L Whole Milk', 95.00, 40, 10, 6, 4, 1, '10000000027', 'carton', NOW(), NOW()),
(28, 'SKU-028', 'Eggs', 'Dozen large eggs', 120.00, 60, 15, 6, 4, 1, '10000000028', 'tray', NOW(), NOW()),
(29, 'SKU-029', 'Bread', 'White sliced bread', 65.00, 35, 10, 6, 4, 1, '10000000029', 'loaf', NOW(), NOW()),
(30, 'SKU-030', 'Butter', 'Salted butter 200g', 140.00, 50, 10, 6, 4, 1, '10000000030', 'block', NOW(), NOW()),
(31, 'SKU-031', 'Dish Soap', 'Lemon dishwashing liquid', 85.00, 150, 30, 7, 5, 1, '10000000031', 'bottle', NOW(), NOW()),
(32, 'SKU-032', 'Laundry Detergent', 'Powder detergent 1kg', 190.00, 80, 20, 7, 5, 1, '10000000032', 'pack', NOW(), NOW()),
(33, 'SKU-033', 'Sponges', '3-pack cleaning sponges', 45.00, 200, 40, 7, 5, 1, '10000000033', 'pack', NOW(), NOW()),
(34, 'SKU-034', 'Trash Bags', 'Large black trash bags 10s', 65.00, 120, 25, 7, 5, 1, '10000000034', 'roll', NOW(), NOW()),
(35, 'SKU-035', 'Highlighter', 'Yellow highlighter pen', 35.00, 300, 50, 8, 6, 1, '10000000035', 'piece', NOW(), NOW()),
(36, 'SKU-036', 'Paper Clips', 'Box of 100 paper clips', 25.00, 500, 100, 8, 6, 1, '10000000036', 'box', NOW(), NOW()),
(37, 'SKU-037', 'Socks', '3-pack cotton socks', 150.00, 75, 15, 9, 7, 1, '10000000037', 'pack', NOW(), NOW()),
(38, 'SKU-038', 'Jacket', 'Zip-up hoodie', 650.00, 30, 10, 9, 7, 1, '10000000038', 'piece', NOW(), NOW()),
(39, 'SKU-039', 'Belt', 'Leather reversible belt', 350.00, 45, 10, 9, 7, 1, '10000000039', 'piece', NOW(), NOW()),
(40, 'SKU-040', 'Toothpaste', 'Fluoride toothpaste 150g', 95.00, 100, 20, 10, 8, 1, '10000000040', 'tube', NOW(), NOW()),
(41, 'SKU-041', 'Toothbrush', 'Soft bristle toothbrush', 45.00, 150, 30, 10, 8, 1, '10000000041', 'piece', NOW(), NOW()),
(42, 'SKU-042', 'Body Wash', 'Moisturizing body wash', 220.00, 60, 15, 10, 8, 1, '10000000042', 'bottle', NOW(), NOW()),
(43, 'SKU-043', 'Deodorant', 'Roll-on deodorant', 120.00, 85, 20, 10, 8, 1, '10000000043', 'piece', NOW(), NOW()),
(44, 'SKU-044', 'Olive Oil', 'Extra virgin olive oil 500ml', 380.00, 40, 10, 5, 10, 1, '10000000044', 'bottle', NOW(), NOW()),
(45, 'SKU-045', 'Pasta', 'Spaghetti 500g', 65.00, 110, 25, 5, 10, 1, '10000000045', 'pack', NOW(), NOW()),
(46, 'SKU-046', 'Tomato Sauce', 'Italian tomato sauce 400g', 85.00, 90, 20, 5, 10, 1, '10000000046', 'can', NOW(), NOW()),
(47, 'SKU-047', 'Cheese', 'Cheddar block 250g', 180.00, 50, 15, 6, 4, 1, '10000000047', 'block', NOW(), NOW()),
(48, 'SKU-048', 'Yogurt', 'Greek yogurt 150g', 55.00, 70, 20, 6, 4, 1, '10000000048', 'cup', NOW(), NOW()),
(49, 'SKU-049', 'Cereal', 'Corn flakes 300g', 140.00, 65, 15, 5, 10, 1, '10000000049', 'box', NOW(), NOW()),
(50, 'SKU-050', 'Oats', 'Rolled oats 500g', 95.00, 80, 20, 5, 10, 1, '10000000050', 'pack', NOW(), NOW()),
(51, 'SKU-051', 'Green Tea', 'Green tea bags 25s', 120.00, 55, 15, 5, 10, 1, '10000000051', 'box', NOW(), NOW()),
(52, 'SKU-052', 'Honey', 'Pure honey 250ml', 250.00, 35, 10, 5, 10, 1, '10000000052', 'jar', NOW(), NOW()),
(53, 'SKU-053', 'Peanut Butter', 'Creamy peanut butter 340g', 160.00, 45, 10, 5, 10, 1, '10000000053', 'jar', NOW(), NOW()),
(54, 'SKU-054', 'Jam', 'Strawberry jam 300g', 130.00, 50, 10, 5, 10, 1, '10000000054', 'jar', NOW(), NOW()),
(55, 'SKU-055', 'Salt', 'Iodized salt 500g', 25.00, 150, 30, 5, 10, 1, '10000000055', 'pack', NOW(), NOW()),
(56, 'SKU-056', 'Pepper', 'Black pepper powder 100g', 60.00, 80, 20, 5, 10, 1, '10000000056', 'bottle', NOW(), NOW()),
(57, 'SKU-057', 'Sugar', 'Brown sugar 1kg', 75.00, 120, 25, 5, 10, 1, '10000000057', 'pack', NOW(), NOW()),
(58, 'SKU-058', 'Flour', 'All-purpose flour 1kg', 85.00, 90, 20, 5, 10, 1, '10000000058', 'pack', NOW(), NOW()),
(59, 'SKU-059', 'Cooking Oil', 'Vegetable oil 1L', 140.00, 70, 15, 5, 10, 1, '10000000059', 'bottle', NOW(), NOW()),
(60, 'SKU-060', 'Soy Sauce', 'Premium soy sauce 500ml', 55.00, 100, 20, 5, 10, 1, '10000000060', 'bottle', NOW(), NOW());


-- =========================================================================
-- 5. INSERT TRANSACTIONS (15 Records)
-- =========================================================================
INSERT INTO transactions (id, transaction_number, subtotal, tax_amount, discount_amount, total_amount, payment_method, status, created_at, updated_at) VALUES
(1, 'TXN-0001', 450.00, 0, 0, 450.00, 'cash', 'completed', DATE_SUB(NOW(), INTERVAL 14 DAY), DATE_SUB(NOW(), INTERVAL 14 DAY)),
(2, 'TXN-0002', 1200.00, 0, 0, 1200.00, 'card', 'completed', DATE_SUB(NOW(), INTERVAL 12 DAY), DATE_SUB(NOW(), INTERVAL 12 DAY)),
(3, 'TXN-0003', 3500.00, 0, 0, 3500.00, 'cash', 'completed', DATE_SUB(NOW(), INTERVAL 10 DAY), DATE_SUB(NOW(), INTERVAL 10 DAY)),
(4, 'TXN-0004', 150.00, 0, 0, 150.00, 'gcash', 'completed', DATE_SUB(NOW(), INTERVAL 9 DAY), DATE_SUB(NOW(), INTERVAL 9 DAY)),
(5, 'TXN-0005', 850.00, 0, 0, 850.00, 'cash', 'completed', DATE_SUB(NOW(), INTERVAL 8 DAY), DATE_SUB(NOW(), INTERVAL 8 DAY)),
(6, 'TXN-0006', 4500.00, 0, 0, 4500.00, 'card', 'completed', DATE_SUB(NOW(), INTERVAL 7 DAY), DATE_SUB(NOW(), INTERVAL 7 DAY)),
(7, 'TXN-0007', 40.00, 0, 0, 40.00, 'cash', 'completed', DATE_SUB(NOW(), INTERVAL 6 DAY), DATE_SUB(NOW(), INTERVAL 6 DAY)),
(8, 'TXN-0008', 220.00, 0, 0, 220.00, 'gcash', 'completed', DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY)),
(9, 'TXN-0009', 350.00, 0, 0, 350.00, 'cash', 'completed', DATE_SUB(NOW(), INTERVAL 4 DAY), DATE_SUB(NOW(), INTERVAL 4 DAY)),
(10, 'TXN-0010', 250.00, 0, 0, 250.00, 'cash', 'completed', DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY)),
(11, 'TXN-0011', 350.00, 0, 0, 350.00, 'card', 'completed', DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY)),
(12, 'TXN-0012', 45.00, 0, 0, 45.00, 'cash', 'completed', DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY)),
(13, 'TXN-0013', 380.00, 0, 0, 380.00, 'gcash', 'completed', NOW(), NOW()),
(14, 'TXN-0014', 150.00, 0, 0, 150.00, 'cash', 'pending', NOW(), NOW()),
(15, 'TXN-0015', 1800.00, 0, 0, 1800.00, 'card', 'pending', NOW(), NOW());

-- =========================================================================
-- 6. INSERT TRANSACTION ITEMS (20 Records)
-- =========================================================================
INSERT INTO transaction_items (id, transaction_id, product_id, product_name, quantity, unit_price, subtotal, created_at, updated_at) VALUES
(1, 1, 1, 'Wireless Mouse', 1, 450.00, 450.00, NOW(), NOW()),
(2, 2, 2, 'Mechanical Keyboard', 1, 1200.00, 1200.00, NOW(), NOW()),
(3, 3, 3, 'Office Chair', 1, 3500.00, 3500.00, NOW(), NOW()),
(4, 4, 11, 'T-Shirt', 1, 150.00, 150.00, NOW(), NOW()),
(5, 5, 12, 'Jeans', 1, 850.00, 850.00, NOW(), NOW()),
(6, 6, 4, 'Wooden Desk', 1, 4500.00, 4500.00, NOW(), NOW()),
(7, 7, 5, 'Apple', 1, 25.00, 25.00, NOW(), NOW()),
(8, 7, 6, 'Banana', 1, 15.00, 15.00, NOW(), NOW()),
(9, 8, 14, 'Face Wash', 1, 220.00, 220.00, NOW(), NOW()),
(10, 9, 16, 'Coffee Beans', 1, 350.00, 350.00, NOW(), NOW()),
(11, 10, 18, 'Printer Paper', 1, 250.00, 250.00, NOW(), NOW()),
(12, 11, 19, 'Stapler', 1, 350.00, 350.00, NOW(), NOW()),
(13, 12, 20, 'Sticky Notes', 1, 45.00, 45.00, NOW(), NOW()),
(14, 13, 21, 'USB Flash Drive', 1, 380.00, 380.00, NOW(), NOW()),
(15, 14, 22, 'HDMI Cable', 1, 150.00, 150.00, NOW(), NOW()),
(16, 15, 23, 'Webcam', 1, 1800.00, 1800.00, NOW(), NOW()),
(17, 10, 5, 'Apple', 2, 25.00, 50.00, NOW(), NOW()),
(18, 11, 6, 'Banana', 3, 15.00, 45.00, NOW(), NOW()),
(19, 12, 35, 'Highlighter', 1, 35.00, 35.00, NOW(), NOW()),
(20, 13, 36, 'Paper Clips', 1, 25.00, 25.00, NOW(), NOW());

-- Restore/ensure default roles exist so admin/manager/auditor can login
INSERT IGNORE INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES 
(1,'admin','Admin','Full system access with all privileges','2026-06-10 04:59:54','2026-06-10 04:59:54'),
(2,'inventory_manager','Inventory Manager','Manage products, categories, suppliers, and inventory','2026-06-10 04:59:54','2026-06-10 04:59:54'),
(3,'auditor','Auditor','Read-only access to view reports and logs','2026-06-10 04:59:54','2026-06-10 04:59:54');

-- Restore/ensure default users exist
INSERT IGNORE INTO `users` (`id`, `name`, `email`, `username`, `password`, `role_id`, `avatar`, `is_active`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES 
(1,'System Administrator','admin@grocery.com','admin','$2y$12$dTeyWKdSTjjf5wesFR2f7.VDsLiSfTNFEEFa/NILm8gwRGUCNi7fW',1,NULL,1,'2026-06-11 05:06:28',NULL,'2026-06-10 04:59:55','2026-06-11 06:39:17'),
(2,'Inventory Manager','manager@grocery.com','manager','$2y$12$wLGREiSEMLCbZcIdJYRME.HNyOSx7EVDFqz0EixKXtTUX43pAXVRe',2,NULL,1,'2026-06-11 05:03:14',NULL,'2026-06-10 04:59:55','2026-06-11 06:39:17'),
(3,'System Auditor','auditor@grocery.com','auditor','$2y$12$VDGDUqf0uDk2DKm4nVKlHOVrynvTLcWhTRSV5pF1qEQYjfQJCgzge',3,NULL,1,'2026-06-11 05:06:02',NULL,'2026-06-10 04:59:56','2026-06-11 06:39:17');

-- Restore/ensure default settings exist
INSERT IGNORE INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES 
(1,'store_name','PureVibe Kiosk','2026-06-10 15:41:20','2026-06-10 15:41:20'),
(2,'contact_email','support@purevibe.com','2026-06-10 15:41:21','2026-06-10 15:41:21'),
(3,'contact_phone','(555) 123-4567','2026-06-10 15:41:21','2026-06-10 15:41:21'),
(4,'store_address','123 Grocery Lane\nMarket District','2026-06-10 15:41:21','2026-06-10 15:41:21'),
(5,'default_tax_rate','13','2026-06-10 15:41:21','2026-06-10 15:41:21'),
(6,'tax_name','VAT','2026-06-10 15:41:22','2026-06-10 15:41:22'),
(7,'receipt_header','Welcome to PureVibe!','2026-06-10 15:41:22','2026-06-10 15:41:22'),
(8,'receipt_footer','Thank you for shopping with us!\nPlease come again.','2026-06-10 15:41:22','2026-06-10 15:41:22'),
(9,'idle_timeout','120','2026-06-10 15:41:22','2026-06-10 15:41:22'),
(10,'currency_symbol','₱','2026-06-10 15:41:23','2026-06-10 15:41:23'),
(11,'enable_sound','1','2026-06-10 15:41:23','2026-06-10 15:41:23'),
(12,'allow_guest','1','2026-06-10 15:41:23','2026-06-10 15:41:23'),
(13,'prices_include_tax','1','2026-06-10 15:41:23','2026-06-10 15:41:53'),
(14,'default_markup_percentage','20','2026-06-11 06:26:43','2026-06-11 06:26:43');

SET FOREIGN_KEY_CHECKS = 1;
-- Restore strict SQL mode after dirty data import
SET sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
