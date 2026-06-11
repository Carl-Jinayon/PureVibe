# DCIT 55A - Advanced Database Management System
## Comprehensive Project Guide with Strategic Approach

**Course:** DCIT 55A - Advanced Database Management System  
**Institution:** Cavite State University - CCAT Campus  
**Semester:** 2nd Semester A.Y. 2025-2026  
**Total Points:** 100  
**Group Size:** 6-7 members

---

## TABLE OF CONTENTS
1. [Project Overview](#project-overview)
2. [Critical Clarifications](#critical-clarifications)
3. [Strategic Approach (Our Methodology)](#strategic-approach-our-methodology)
4. [Example System: Inventory Management System](#example-system-inventory-management-system)
5. [Technical Stack Decision](#technical-stack-decision)
6. [Detailed Implementation Steps](#detailed-implementation-steps)
7. [How to Demonstrate Each Requirement](#how-to-demonstrate-each-requirement)
8. [Risk Mitigation & Best Practices](#risk-mitigation--best-practices)
9. [Scoring Maximization Strategy](#scoring-maximization-strategy)
10. [Timeline & Deliverables](#timeline--deliverables)

---

## PROJECT OVERVIEW

### What is this project?

This is a **database system design and implementation project** where you build a real-world database application that demonstrates:

- ✅ Proper database architecture (ERD, normalized tables, PK/FK)
- ✅ Data quality management (identify, document, and fix data issues)
- ✅ SQL expertise (filtering, analysis, aggregations, JOINs)
- ✅ Professional documentation and presentation
- ✅ Team collaboration and individual understanding

### Two Track Options

| **Laboratory Track** | **Lecture Track** |
|---|---|
| Live/recorded demo (5-10 min) | Written documentation (6 chapters) |
| Code-based demonstration | Report-based presentation |
| SQL outputs shown in demo | SQL code + outputs in document |
| Emphasis: Practical execution | Emphasis: Documentation & explanation |

---

## CRITICAL CLARIFICATIONS

### ❓ Question 1: Can we use Python or other languages?

**Short Answer:** YES, but with caveats.

**SQL operations must be demonstrated in SQL:**
- All filtering queries → **Must use SQL WHERE, BETWEEN, LIKE, IN, ORDER BY**
- All analytical queries → **Must use SQL COUNT, SUM, AVG, GROUP BY, HAVING**
- All JOIN operations → **Must use SQL JOINs**
- Results must be shown with actual outputs

**Python (or other languages) CAN be used for:**
- 🐍 **Data generation/preparation** - Create CSV files, simulate datasets
- 🐍 **Frontend UI** - Build a user-friendly interface (optional but beneficial)
- 🐍 **ETL pipeline** - Import data into database
- 🐍 **Reporting scripts** - Generate reports from SQL results
- 🐍 **Automation** - Batch processing or scheduled tasks

**What Python CANNOT replace:**
- ❌ SQL filtering operations (don't use pandas `.loc[]`, use SQL WHERE)
- ❌ SQL aggregations (don't use pandas `.groupby()`, use SQL GROUP BY)
- ❌ SQL JOINs (don't merge dataframes, use SQL JOINs)
- ❌ The actual database (don't store as CSV/JSON, use a real DBMS)

**Why this matters for grading:**
The rubric specifically asks for:
- "SQL queries used"
- "Output/results shown"
- "Minimum 5 filtering queries" (must be SQL)
- "Minimum 5 analytical queries" (must be SQL)

If you do filtering in Python and claim it as a SQL requirement, you lose points.

---

### ❓ Question 2: Is it just SQL or a real system?

**Answer: REAL SYSTEM with SQL as the core.**

What "real system" means here:
- 📊 **Database** - Actual DBMS (MySQL, PostgreSQL, SQL Server, etc.)
- 📊 **Data** - Real or simulated data (100+ records)
- 📊 **Operations** - SQL commands that modify, clean, filter, and analyze data
- 📊 **Demonstration** - Show the database working (UI optional)

**Example workflow:**
```
User Interface (Optional)
         ↓
Application Code (Python, Node.js, etc. - Optional)
         ↓
SQL Queries (REQUIRED - must be shown)
         ↓
Database (REQUIRED - must store 100+ records)
```

You can have a professional UI, but the SQL operations are what matter for grading.

---

### ❓ Question 3: Isn't this just embedded in source code?

**Answer: No, it's separated and demonstrated.**

| **Approach** | **What Students Show** | **Grading** |
|---|---|---|
| **❌ Wrong**: Only show Python code | Python scripts that process data | Instructor can't see SQL operations |
| **✅ Right**: Show actual SQL | SQL query window, terminal, or UI with query preview | Clear evidence of SQL filtering, JOINs, etc. |

**Key point:** You must explicitly show the SQL queries and their results.

For example:
```
BAD: "We used Python to filter inventory by warehouse_id"
GOOD: Show the actual SQL query:
       SELECT * FROM inventory WHERE warehouse_id = 3;
       (Display 15 matching records)
```

---

## STRATEGIC APPROACH (Our Methodology)

If I were leading this project group, here's exactly what I'd do:

### **Phase 1: Planning (Week 1)**

**Step 1.1 - System Selection & Requirement Analysis**
```
□ Choose system: Inventory Management System (practical, diverse operations)
□ Define the scope and real-world context
□ List all tables needed (minimum 5)
□ Plan data relationships
□ Identify what data quality issues to introduce
```

**Step 1.2 - Technology Stack Decision**
```
Database: MySQL (ubiquitous, easy to demonstrate)
Frontend: Python Flask/FastAPI (optional, for UI)
OR: phpMyAdmin (free, built-in MySQL interface)
OR: Command line (pure SQL demonstration)

Documentation: PDF (required format)
Collaboration: Git/GitHub (track contributions)
```

**Step 1.3 - Team Role Assignment**
```
1-2 Database Designer → Create ERD, schema, table structure
1-2 Data Engineer → Create dataset, introduce quality issues
1-2 SQL Developer → Write filtering & analysis queries
1 UI Developer (optional) → Build frontend
1 Documentation Lead → Compile chapters, format PDF
```

---

### **Phase 2: Database Design (Week 2)**

**Step 2.1 - Create ER Diagram**
- Tools: Lucidchart, DrawIO, MySQL Workbench, or even draw.io
- Show all 5+ tables, PKs, FKs, relationships
- Save as image for documentation

**Step 2.2 - Define Table Structure**
```sql
-- Example tables for Inventory System
1. products (product_id PK, name, category, unit_cost, ...)
2. warehouses (warehouse_id PK, warehouse_name, location, ...)
3. inventory (inventory_id PK, product_id FK, warehouse_id FK, quantity, ...)
4. suppliers (supplier_id PK, supplier_name, contact, ...)
5. product_supplier (ps_id PK, product_id FK, supplier_id FK, ...)
6. inventory_transactions (trans_id PK, inventory_id FK, trans_type, date, ...)
```

**Step 2.3 - Create Database & Tables**
- Actually execute CREATE statements
- Verify table structure
- Take screenshots for documentation

---

### **Phase 3: Data Generation (Week 2-3)**

**Step 3.1 - Generate Initial Dataset**
```
Option A: Python Script
- Use Faker library to generate realistic data
- Create CSV files with 100+ records
- Example: 50 products, 10 warehouses, 200+ inventory records

Option B: Manual Creation
- Create sample data in Excel
- Import into database

Option C: MySQL INSERT statements
- Write INSERT statements directly
```

**Step 3.2 - Introduce Intentional Data Quality Issues**

For EACH table, deliberately add:
- ✓ NULL values (15-20% of records)
- ✓ Duplicates (5-10 duplicate records)
- ✓ Inconsistent formats (e.g., "USA", "usa", "U.S.A")
- ✓ Invalid entries (wrong data types, out-of-range values)
- ✓ Spelling/formatting issues

**Example:**
```
products table before cleaning:
| product_id | name           | category     | unit_cost |
|------------|----------------|--------------|-----------|
| 1          | Laptop         | Electronics  | 50000     |
| 2          | MOUSE          | electronics  | NULL      |
| 3          | Keyboard       | ELECTRONICS  | 2500      |
| 2          | mouse          | Electronics  | 1500      | ← DUPLICATE
| 4          | Monitor        | NULL         | 8000      |
```

---

### **Phase 4: Data Quality Assessment (Week 3)**

**Step 4.1 - Document All Issues**
```
Create a report with:
1. List of problems found
2. Which table(s) affected
3. Sample records showing the issues
4. Impact on data quality
5. Proposed solutions

Example:
- Inconsistent category values (Electronics, ELECTRONICS, electronics)
- NULL values in unit_cost (5 records in products table)
- Duplicate product records (product_id = 2 appears twice)
- Invalid quantity values (negative numbers in inventory)
```

**Step 4.2 - Take Screenshots**
- Show actual database records with problems
- Include in documentation as evidence

---

### **Phase 5: Data Cleaning (Week 3-4)**

**Step 5.1 - Write SQL Cleaning Queries**

DO NOT manually fix in spreadsheet. Show SQL operations:

```sql
-- Remove duplicates
DELETE FROM products 
WHERE product_id IN (
    SELECT product_id 
    FROM (SELECT product_id, 
          ROW_NUMBER() OVER (PARTITION BY product_id ORDER BY product_id) as rn 
          FROM products) t 
    WHERE rn > 1
);

-- Standardize category values
UPDATE products 
SET category = UPPER(TRIM(category));

-- Handle NULL values
UPDATE products 
SET unit_cost = 0 
WHERE unit_cost IS NULL;

-- Fix invalid quantities
UPDATE inventory 
SET quantity = 0 
WHERE quantity < 0;
```

**Step 5.2 - Verify Cleaning**
- Run verification queries
- Confirm no duplicates exist
- Check for remaining NULLs
- Take screenshots of results

---

### **Phase 6: SQL Operations (Week 4-5)**

**This is CRITICAL for grading.**

#### **6.1 Data Filtering Queries (Minimum 5)**

```sql
-- Query 1: WHERE clause
SELECT * FROM inventory 
WHERE quantity < 50;

-- Query 2: BETWEEN
SELECT product_id, unit_cost FROM products 
WHERE unit_cost BETWEEN 1000 AND 5000;

-- Query 3: LIKE
SELECT * FROM suppliers 
WHERE supplier_name LIKE '%Ltd%';

-- Query 4: IN clause
SELECT * FROM products 
WHERE category IN ('Electronics', 'Furniture', 'Supplies');

-- Query 5: ORDER BY
SELECT product_id, quantity FROM inventory 
ORDER BY quantity DESC LIMIT 10;
```

**IMPORTANT:** For each query:
- ✅ Write the query
- ✅ Execute it
- ✅ Show the results
- ✅ Explain what it shows (in documentation)

#### **6.2 Data Analysis Queries (Minimum 5)**

```sql
-- Query 1: COUNT
SELECT category, COUNT(*) as total_products 
FROM products 
GROUP BY category;

-- Query 2: SUM
SELECT warehouse_id, SUM(quantity) as total_inventory 
FROM inventory 
GROUP BY warehouse_id;

-- Query 3: AVG
SELECT category, AVG(unit_cost) as avg_cost 
FROM products 
GROUP BY category;

-- Query 4: GROUP BY with HAVING
SELECT warehouse_id, COUNT(*) as product_count 
FROM inventory 
GROUP BY warehouse_id 
HAVING product_count > 5;

-- Query 5: Multiple aggregates
SELECT 
    product_id, 
    COUNT(*) as warehouse_count,
    SUM(quantity) as total_qty,
    AVG(quantity) as avg_qty,
    MIN(quantity) as min_qty,
    MAX(quantity) as max_qty
FROM inventory 
GROUP BY product_id;
```

#### **6.3 JOIN Operations (Minimum 2)**

```sql
-- Query 1: INNER JOIN
SELECT 
    p.product_id,
    p.name,
    p.category,
    i.warehouse_id,
    i.quantity
FROM products p
INNER JOIN inventory i ON p.product_id = i.product_id
WHERE i.quantity > 100;

-- Query 2: LEFT JOIN (connecting multiple tables)
SELECT 
    p.product_id,
    p.name,
    s.supplier_name,
    ps.supplier_id
FROM products p
LEFT JOIN product_supplier ps ON p.product_id = ps.product_id
LEFT JOIN suppliers s ON ps.supplier_id = s.supplier_id;

-- Query 3: (BONUS) Complex JOIN for additional points
SELECT 
    w.warehouse_name,
    p.name,
    i.quantity,
    CASE 
        WHEN i.quantity < 50 THEN 'Low Stock'
        WHEN i.quantity < 200 THEN 'Medium Stock'
        ELSE 'High Stock'
    END as stock_level
FROM warehouses w
INNER JOIN inventory i ON w.warehouse_id = i.warehouse_id
INNER JOIN products p ON i.product_id = p.product_id
ORDER BY w.warehouse_name, i.quantity;
```

---

### **Phase 7: Documentation (Week 5)**

**For Laboratory Track:**
- Create a 5-10 minute video/live demo
- Show: Database, sample data, run queries, show results
- Speak clearly about what each operation does

**For Lecture Track:**
- Compile 6 chapters into a PDF document
- Include screenshots, SQL code, and explanations
- Format as required (Times New Roman, 12pt, 1.5 spacing)

---

### **Phase 8: Demonstration & Presentation (Week 6)**

**What to show:**
1. System overview (name, purpose, real-world use)
2. Database structure (tables, relationships, ERD)
3. Data quality issues found and how they were resolved
4. Execute each SQL query with visible results
5. Explain the insights gained from the data

**How to make it impressive:**
- Use a database GUI (phpMyAdmin, MySQL Workbench, DBeaver)
- Have a prepared script of what to demonstrate
- Practice beforehand
- Have backup screenshots if live demo fails
- All team members should be able to explain any part

---

## EXAMPLE SYSTEM: INVENTORY MANAGEMENT SYSTEM

I've chosen this because:
- ✅ Real-world relevance (every business needs it)
- ✅ Rich data for quality issues (pricing, quantities, statuses)
- ✅ Multiple tables naturally (products, warehouses, suppliers, transactions)
- ✅ Diverse SQL operations (filtering by stock level, analyzing by category, joining multiple tables)
- ✅ Clear insights from data (low stock alerts, supplier analysis, warehouse utilization)

### System Description

**Purpose:** Track products across multiple warehouses, manage supplier relationships, and provide inventory analytics for business decision-making.

**Real-world scenario:**
A retail company has 5 warehouses across different regions. They need to:
- Know current stock levels for each product in each warehouse
- Identify low-stock items that need reordering
- Analyze which suppliers are most reliable
- Generate reports on warehouse utilization
- Track inventory movements over time

### Database Tables (6 tables for extra completeness)

```sql
-- 1. PRODUCTS
CREATE TABLE products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(100) NOT NULL,
    category VARCHAR(50),
    unit_cost DECIMAL(10,2),
    retail_price DECIMAL(10,2),
    created_date DATE
);

-- 2. WAREHOUSES
CREATE TABLE warehouses (
    warehouse_id INT PRIMARY KEY AUTO_INCREMENT,
    warehouse_name VARCHAR(100) NOT NULL,
    location VARCHAR(100),
    capacity INT,
    manager_name VARCHAR(100)
);

-- 3. INVENTORY
CREATE TABLE inventory (
    inventory_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    quantity INT,
    last_updated DATE,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(warehouse_id)
);

-- 4. SUPPLIERS
CREATE TABLE suppliers (
    supplier_id INT PRIMARY KEY AUTO_INCREMENT,
    supplier_name VARCHAR(100) NOT NULL,
    contact_person VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    country VARCHAR(50)
);

-- 5. PRODUCT_SUPPLIER (Many-to-Many relationship)
CREATE TABLE product_supplier (
    ps_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    supplier_id INT NOT NULL,
    lead_time_days INT,
    unit_price DECIMAL(10,2),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id)
);

-- 6. INVENTORY_TRANSACTIONS
CREATE TABLE inventory_transactions (
    trans_id INT PRIMARY KEY AUTO_INCREMENT,
    inventory_id INT NOT NULL,
    trans_type ENUM('IN', 'OUT', 'ADJUSTMENT'),
    quantity_changed INT,
    trans_date DATETIME,
    notes VARCHAR(255),
    FOREIGN KEY (inventory_id) REFERENCES inventory(inventory_id)
);
```

### Sample Data Issues to Introduce

```
products table:
- Category inconsistency: "Electronics", "ELECTRONICS", "electronics"
- NULL values in unit_cost (missing pricing)
- Duplicate entries (product_id 5 appears twice)
- Invalid retail_price (less than unit_cost)

inventory table:
- NULL values in quantity (20 records)
- Negative quantities (5 records with qty = -100)
- Duplicate warehouse-product combinations

suppliers table:
- Email format inconsistency
- Missing phone numbers (NULL)
- Duplicate supplier names
- Country values like "PH", "PHL", "Philippines" (inconsistent)

inventory_transactions table:
- Wrong data types in trans_type ("in" vs "IN")
- NULL notes field
- Future-dated transactions (after today)
```

### Filtering Queries Example

```sql
1. Get all low-stock items (< 50 units)
   SELECT * FROM inventory WHERE quantity < 50;

2. Find products in a specific price range
   SELECT * FROM products WHERE unit_cost BETWEEN 1000 AND 5000;

3. Search suppliers by partial name
   SELECT * FROM suppliers WHERE supplier_name LIKE '%Ltd%';

4. Get inventory for specific warehouses
   SELECT * FROM inventory WHERE warehouse_id IN (1, 3, 5);

5. Get recent transactions ordered by date
   SELECT * FROM inventory_transactions ORDER BY trans_date DESC LIMIT 20;
```

### Analysis Queries Example

```sql
1. Count products by category
   SELECT category, COUNT(*) FROM products GROUP BY category;

2. Total inventory per warehouse
   SELECT w.warehouse_name, SUM(i.quantity) as total_stock 
   FROM warehouses w 
   LEFT JOIN inventory i ON w.warehouse_id = i.warehouse_id 
   GROUP BY w.warehouse_id;

3. Average unit cost per category
   SELECT category, AVG(unit_cost) FROM products GROUP BY category;

4. Warehouses with high stock (>1000 units total)
   SELECT warehouse_id, SUM(quantity) as total 
   FROM inventory 
   GROUP BY warehouse_id 
   HAVING total > 1000;

5. Best suppliers (highest delivered items)
   SELECT s.supplier_name, COUNT(*) as product_count 
   FROM suppliers s 
   JOIN product_supplier ps ON s.supplier_id = ps.supplier_id 
   GROUP BY s.supplier_id 
   ORDER BY product_count DESC;
```

### JOIN Queries Example

```sql
1. Get product names with current inventory in each warehouse
   SELECT 
       p.product_name, 
       w.warehouse_name, 
       i.quantity 
   FROM products p 
   INNER JOIN inventory i ON p.product_id = i.product_id 
   INNER JOIN warehouses w ON i.warehouse_id = w.warehouse_id;

2. Show products and their suppliers
   SELECT 
       p.product_name, 
       s.supplier_name, 
       ps.unit_price 
   FROM products p 
   LEFT JOIN product_supplier ps ON p.product_id = ps.product_id 
   LEFT JOIN suppliers s ON ps.supplier_id = s.supplier_id;
```

---

## TECHNICAL STACK DECISION

### Option 1: Recommended Stack (What I'd Choose)

```
Database:         MySQL 8.0+
Interface:        phpMyAdmin (free, web-based)
Demo Recording:   OBS Studio or ScreenFlow
Documentation:   Google Docs → PDF
Collaboration:    GitHub
```

**Why:**
- ✅ MySQL is industry standard and easy to demonstrate
- ✅ phpMyAdmin requires no coding, queries are visible
- ✅ Easy to show results in real-time
- ✅ Free and accessible

### Option 2: Python Flask + MySQL

```
Database:         MySQL 8.0+
Backend:          Python Flask/FastAPI
Frontend:         HTML/CSS/Bootstrap
Demo Recording:   Built-in demo of web interface
Documentation:    Google Docs → PDF
```

**Why:**
- ✅ Professional UI
- ✅ Can still show SQL queries (in Flask code or query logs)
- ✅ Impressive for demonstration
- ⚠️ More work, but shows full-stack capability

### Option 3: PostgreSQL + pgAdmin

```
Database:         PostgreSQL
Interface:        pgAdmin (free, web-based)
Demo:             Live query execution
Documentation:    Google Docs → PDF
```

**Why:**
- ✅ More advanced than MySQL
- ✅ pgAdmin is excellent
- ⚠️ May be overkill for this project

### My Recommendation: **Option 1**

Why? Because:
1. **Easy to demonstrate** - Everyone can see the SQL queries and results
2. **Less error-prone** - No web framework bugs to worry about
3. **Grading-friendly** - Instructor clearly sees SQL operations
4. **Time-efficient** - More time on data and SQL, less on UI code

---

## DETAILED IMPLEMENTATION STEPS

### Step-by-Step Execution Plan

#### **Step 1: Database Setup (Day 1)**

```bash
# Install MySQL Server (if not already installed)
# On Windows: MySQL installer
# On Mac: brew install mysql
# On Linux: sudo apt-get install mysql-server

# Start MySQL service
mysql -u root -p

# Create database
CREATE DATABASE inventory_db;
USE inventory_db;
```

#### **Step 2: Create Tables (Day 1)**

Execute all CREATE TABLE statements (provided above in example system)

Take screenshot of each table structure:
```
DESCRIBE products;
DESCRIBE warehouses;
DESCRIBE inventory;
DESCRIBE suppliers;
DESCRIBE product_supplier;
DESCRIBE inventory_transactions;
```

#### **Step 3: Generate Data (Days 2-3)**

**Option A: Python Script**

```python
import mysql.connector
from faker import Faker
import random
from datetime import datetime, timedelta

fake = Faker()

# Connect to MySQL
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="your_password",
    database="inventory_db"
)
cursor = conn.cursor()

# 1. Insert Products (50 records with issues)
categories = ['Electronics', 'Furniture', 'Supplies', 'Tools']
for i in range(50):
    name = fake.word().title()
    # Introduce inconsistent category formatting
    category = random.choice(categories + ['ELECTRONICS', 'furniture', None])
    unit_cost = random.randint(500, 50000) if random.random() > 0.1 else None
    retail_price = random.randint(1000, 100000) if unit_cost else None
    
    cursor.execute("""
        INSERT INTO products (product_name, category, unit_cost, retail_price, created_date)
        VALUES (%s, %s, %s, %s, %s)
    """, (name, category, unit_cost, retail_price, datetime.now().date()))

# 2. Insert Warehouses (5 records)
locations = ['Manila', 'Cebu', 'Davao', 'Cagayan de Oro', 'Bacolod']
for i, loc in enumerate(locations):
    warehouse_name = f"Warehouse {i+1}"
    capacity = random.randint(5000, 50000)
    manager = fake.name()
    
    cursor.execute("""
        INSERT INTO warehouses (warehouse_name, location, capacity, manager_name)
        VALUES (%s, %s, %s, %s)
    """, (warehouse_name, loc, capacity, manager))

# 3. Insert Inventory (200+ records with issues)
for product_id in range(1, 51):
    for warehouse_id in range(1, 6):
        # Introduce NULLs and negative quantities
        quantity = random.randint(-100, 1000) if random.random() > 0.2 else None
        last_updated = datetime.now().date() - timedelta(days=random.randint(0, 30))
        
        cursor.execute("""
            INSERT INTO inventory (product_id, warehouse_id, quantity, last_updated)
            VALUES (%s, %s, %s, %s)
        """, (product_id, warehouse_id, quantity, last_updated))

# 4. Insert Suppliers (20 records)
countries = ['Philippines', 'PH', 'Thailand', 'Vietnam', 'China']
for i in range(20):
    supplier_name = fake.company()
    contact = fake.name()
    email = fake.email()
    phone = fake.phone_number()
    country = random.choice(countries)
    
    cursor.execute("""
        INSERT INTO suppliers (supplier_name, contact_person, email, phone, country)
        VALUES (%s, %s, %s, %s, %s)
    """, (supplier_name, contact, email, phone, country))

# 5. Insert Product-Supplier relationships
for i in range(100):
    product_id = random.randint(1, 50)
    supplier_id = random.randint(1, 20)
    lead_time = random.randint(3, 30)
    unit_price = random.randint(500, 30000)
    
    cursor.execute("""
        INSERT INTO product_supplier (product_id, supplier_id, lead_time_days, unit_price)
        VALUES (%s, %s, %s, %s)
    """, (product_id, supplier_id, lead_time, unit_price))

# 6. Insert Transactions (150+ records)
trans_types = ['IN', 'OUT', 'ADJUSTMENT']
for i in range(150):
    inventory_id = random.randint(1, 250)
    trans_type = random.choice(trans_types)
    quantity_changed = random.randint(-100, 500)
    trans_date = datetime.now() - timedelta(days=random.randint(0, 90))
    notes = fake.sentence() if random.random() > 0.5 else None
    
    cursor.execute("""
        INSERT INTO inventory_transactions (inventory_id, trans_type, quantity_changed, trans_date, notes)
        VALUES (%s, %s, %s, %s, %s)
    """, (inventory_id, trans_type, quantity_changed, trans_date, notes))

conn.commit()
cursor.close()
conn.close()
print("Data inserted successfully!")
```

#### **Step 4: Document Data Quality Issues (Days 3-4)**

```sql
-- Identify NULL values
SELECT 'products' as table_name, COUNT(*) as null_count 
FROM products WHERE unit_cost IS NULL
UNION ALL
SELECT 'inventory', COUNT(*) FROM inventory WHERE quantity IS NULL
UNION ALL
SELECT 'suppliers', COUNT(*) FROM suppliers WHERE phone IS NULL;

-- Find duplicates
SELECT product_id, COUNT(*) as count 
FROM products 
GROUP BY product_id 
HAVING count > 1;

-- Check for negative quantities
SELECT * FROM inventory WHERE quantity < 0;

-- Check category inconsistencies
SELECT DISTINCT category FROM products;

-- Find outliers (products cheaper when sold)
SELECT * FROM products WHERE retail_price < unit_cost;
```

Create a document listing all issues found with screenshots.

#### **Step 5: Data Cleaning Queries (Days 4-5)**

```sql
-- 1. Remove duplicates
DELETE FROM products WHERE product_id IN (
    SELECT product_id FROM (
        SELECT product_id, 
        ROW_NUMBER() OVER (PARTITION BY product_id) as rn
        FROM products
    ) t WHERE rn > 1
);

-- 2. Standardize category (uppercase)
UPDATE products SET category = UPPER(TRIM(category)) WHERE category IS NOT NULL;

-- 3. Handle NULL unit costs (set to average)
UPDATE products SET unit_cost = (SELECT AVG(unit_cost) FROM products WHERE unit_cost IS NOT NULL)
WHERE unit_cost IS NULL;

-- 4. Fix negative quantities
UPDATE inventory SET quantity = 0 WHERE quantity < 0;

-- 5. Handle NULL quantities
UPDATE inventory SET quantity = 0 WHERE quantity IS NULL;

-- 6. Standardize country names
UPDATE suppliers SET country = 'PHILIPPINES' WHERE country IN ('PH', 'Philippines');

-- 7. Remove NULL phone numbers (fill with placeholder)
UPDATE suppliers SET phone = 'N/A' WHERE phone IS NULL OR phone = '';

-- 8. Verify all fixes
SELECT * FROM products ORDER BY product_id LIMIT 10;
```

Take before/after screenshots.

#### **Step 6: Write and Execute Filtering Queries (Days 5-6)**

Create a file `filtering_queries.sql` with all 5+ queries:

```sql
-- FILTERING QUERY 1: Low stock items
SELECT product_id, warehouse_id, quantity 
FROM inventory 
WHERE quantity < 100 
ORDER BY quantity ASC;

-- FILTERING QUERY 2: Products in price range
SELECT product_id, product_name, unit_cost, category 
FROM products 
WHERE unit_cost BETWEEN 5000 AND 20000;

-- FILTERING QUERY 3: Suppliers search
SELECT * FROM suppliers 
WHERE supplier_name LIKE '%Ltd%' OR supplier_name LIKE '%Inc%';

-- FILTERING QUERY 4: Specific categories
SELECT product_id, product_name, category 
FROM products 
WHERE category IN ('ELECTRONICS', 'FURNITURE');

-- FILTERING QUERY 5: Recent transactions
SELECT * FROM inventory_transactions 
WHERE trans_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
ORDER BY trans_date DESC;
```

**For each query:**
1. Execute in phpMyAdmin or MySQL client
2. Take screenshot showing query and results
3. Document what the query shows (e.g., "Shows 23 products with inventory below 100 units")

#### **Step 7: Write and Execute Analysis Queries (Days 6-7)**

Create file `analysis_queries.sql`:

```sql
-- ANALYSIS QUERY 1: Inventory levels by warehouse
SELECT 
    w.warehouse_name,
    COUNT(i.inventory_id) as product_count,
    SUM(i.quantity) as total_quantity,
    AVG(i.quantity) as avg_quantity,
    MIN(i.quantity) as min_quantity,
    MAX(i.quantity) as max_quantity
FROM warehouses w
LEFT JOIN inventory i ON w.warehouse_id = i.warehouse_id
GROUP BY w.warehouse_id, w.warehouse_name;

-- ANALYSIS QUERY 2: Products by category with pricing
SELECT 
    category,
    COUNT(*) as product_count,
    AVG(unit_cost) as avg_cost,
    AVG(retail_price) as avg_selling_price,
    MIN(unit_cost) as min_cost,
    MAX(unit_cost) as max_cost
FROM products
GROUP BY category
HAVING COUNT(*) > 0;

-- ANALYSIS QUERY 3: Supplier diversity
SELECT 
    supplier_name,
    COUNT(DISTINCT product_id) as products_supplied,
    AVG(unit_price) as avg_unit_price,
    AVG(lead_time_days) as avg_lead_time
FROM suppliers s
JOIN product_supplier ps ON s.supplier_id = ps.supplier_id
GROUP BY s.supplier_id, s.supplier_name
ORDER BY products_supplied DESC;

-- ANALYSIS QUERY 4: Transaction patterns
SELECT 
    DATE(trans_date) as transaction_date,
    trans_type,
    COUNT(*) as transaction_count,
    SUM(ABS(quantity_changed)) as total_units_moved
FROM inventory_transactions
GROUP BY DATE(trans_date), trans_type
ORDER BY transaction_date DESC;

-- ANALYSIS QUERY 5: High-value inventory
SELECT 
    p.product_name,
    i.warehouse_id,
    i.quantity,
    p.unit_cost,
    (i.quantity * p.unit_cost) as inventory_value
FROM products p
JOIN inventory i ON p.product_id = i.product_id
WHERE (i.quantity * p.unit_cost) > 100000
ORDER BY inventory_value DESC;
```

Again, for each:
1. Execute and screenshot results
2. Write interpretation (e.g., "Warehouse 1 has highest inventory value at ₱2.5M")

#### **Step 8: Write and Execute JOIN Queries (Days 7-8)**

```sql
-- JOIN QUERY 1: Product inventory across all warehouses
SELECT 
    p.product_id,
    p.product_name,
    p.category,
    w.warehouse_name,
    i.quantity,
    (i.quantity * p.unit_cost) as stock_value
FROM products p
INNER JOIN inventory i ON p.product_id = i.product_id
INNER JOIN warehouses w ON i.warehouse_id = w.warehouse_id
ORDER BY p.product_id, w.warehouse_id;

-- JOIN QUERY 2: Supplier coverage analysis
SELECT 
    s.supplier_name,
    s.country,
    ps.lead_time_days,
    p.product_name,
    p.category
FROM suppliers s
LEFT JOIN product_supplier ps ON s.supplier_id = ps.supplier_id
LEFT JOIN products p ON ps.product_id = p.product_id
WHERE s.supplier_id IN (
    SELECT DISTINCT supplier_id FROM product_supplier LIMIT 15
)
ORDER BY s.supplier_name, p.product_name;

-- (BONUS) JOIN QUERY 3: Complex multi-table analysis
SELECT 
    w.warehouse_name,
    p.category,
    COUNT(DISTINCT p.product_id) as unique_products,
    SUM(i.quantity) as total_stock,
    COUNT(DISTINCT s.supplier_id) as supplier_count,
    CASE 
        WHEN SUM(i.quantity) < 500 THEN 'Low'
        WHEN SUM(i.quantity) < 2000 THEN 'Medium'
        ELSE 'High'
    END as warehouse_capacity
FROM warehouses w
LEFT JOIN inventory i ON w.warehouse_id = i.warehouse_id
LEFT JOIN products p ON i.product_id = p.product_id
LEFT JOIN product_supplier ps ON p.product_id = ps.product_id
LEFT JOIN suppliers s ON ps.supplier_id = s.supplier_id
GROUP BY w.warehouse_id, p.category
ORDER BY w.warehouse_name, p.category;
```

---

## HOW TO DEMONSTRATE EACH REQUIREMENT

### Laboratory Track (5-10 minute video/live demo)

**Script to Follow:**

```
[TIME: 0:00-1:00] SYSTEM OVERVIEW
"Good morning, our group presents the Inventory Management System. 
This system tracks products across 5 warehouses nationwide and manages 
supplier relationships. Our database contains 50 products, 5 warehouses, 
and over 200 inventory records with real-world scenarios."

[TIME: 1:00-2:00] DATABASE STRUCTURE
"Let me show you our database design. We have 6 interconnected tables."
→ Show ERD image
→ Show CREATE TABLE statements
→ Explain each table's purpose
→ Highlight Primary Keys and Foreign Keys

[TIME: 2:00-3:00] DATA QUALITY ISSUES
"Before cleaning, we identified several data quality issues."
→ Show screenshot of data with NULLs
→ Show duplicates
→ Show inconsistent category values
→ Explain impact: "These issues would cause incorrect reporting"

[TIME: 3:00-4:00] DATA CLEANING
"Here's how we fixed these issues using SQL."
→ Show SQL cleaning query
→ Execute it: "Watch how we standardize all categories to uppercase"
→ Show before/after comparison
"Before: Electronics, ELECTRONICS, electronics"
"After: ELECTRONICS, ELECTRONICS, ELECTRONICS"

[TIME: 4:00-6:00] FILTERING QUERIES
"Now let's filter the data to answer business questions."
→ Run filtering query #1 in phpMyAdmin
   "This shows all low-stock items (< 100 units). We found 14 products."
→ Run filtering query #2
   "This shows products in the ₱5,000-₱20,000 price range. 12 results."
(Run 3-5 queries with brief explanations)

[TIME: 6:00-8:00] ANALYSIS QUERIES
"Let's analyze patterns in our data."
→ Run analysis query #1: Warehouse inventory summary
   "Warehouse 1 has 5,234 total units with average of 104 per product"
→ Run analysis query #2: Category analysis
   "Electronics category has highest average cost at ₱15,000"
(Show results with GROUP BY, aggregates, insights)

[TIME: 8:00-9:30] JOIN OPERATIONS
"Finally, let's see how we connect data across tables."
→ Run JOIN query #1
   "This shows every product with its current inventory in each warehouse
    and the stock value. Useful for understanding our assets."
→ Run JOIN query #2
   "This shows supplier relationships. We can see which suppliers
    provide which products and their lead times."

[TIME: 9:30-10:00] INSIGHTS & CONCLUSION
"Key insights from our analysis:
- Warehouse 1 is most utilized (27% of total inventory)
- Electronics category needs urgent restocking (avg stock 45 units)
- Top supplier 'Tech Ltd' provides 12 products with 5-day lead time
- Total inventory value across all warehouses: ₱42.3 Million"

Team coordination note: "All team members understand every aspect of 
this system. Ask any of us any question about the database or queries."
```

### Lecture Track (PDF Documentation)

Create a comprehensive PDF with these sections:

**Chapter 1 Title Page & Overview (10 points)**
```
- Project title, system name, course, instructor, group members
- System description (1 paragraph)
- Objectives (3 bullet points)
- Real-world context (1 paragraph)
```

**Chapter 2 Database Design (20 points)**
```
- Database description
- Tables used (with purpose for each)
- ER Diagram (image)
- OR text explanation of relationships
- Primary and Foreign Keys identified
- Screenshot of CREATE TABLE statements
```

**Chapter 3 Data Quality Assessment (10 points)**
```
- Dataset overview (100+ records, 6 tables)
- Listed problems found:
  * 15 NULL values in unit_cost
  * 5 duplicate products
  * Inconsistent category formatting
  * 8 negative quantities in inventory
  * Missing phone numbers in suppliers
- Screenshot of sample problematic data
- Impact analysis for each issue
```

**Chapter 4 Data Cleaning & Transformation (15 points)**
```
- Explanation of cleaning process (1 page)
- SQL cleaning queries with code blocks
  * Query for removing duplicates (with results before/after)
  * Query for standardizing categories
  * Query for handling NULL values
  * Query for fixing negative quantities
  * Transformation explanations
- Verification queries showing final clean state
- Screenshots of before/after states
```

**Chapter 5 Data Filtering & Analysis (20 points)**
```
- 5+ Filtering Queries Section
  * Query 1: Low stock items (SQL + results screenshot)
  * Query 2: Price range filter (SQL + results)
  * Query 3: Supplier search (SQL + results)
  * Query 4: Category filter (SQL + results)
  * Query 5: Recent transactions (SQL + results)
  * Explanation: "These queries show how managers can find specific data"

- 5+ Analysis Queries Section
  * Query 1: Warehouse summary with GROUP BY (SQL + results)
    Explanation: "Total inventory per warehouse helps allocation decisions"
  * Query 2: Category analysis with AVG, MIN, MAX (SQL + results)
  * Query 3: Supplier analysis (SQL + results)
  * Query 4: Transaction patterns (SQL + results)
  * Query 5: High-value inventory (SQL + results)
  * Insights: "Electronics category shows 30% lower average quantity,
    suggesting demand pressure"

- Summary of Results (1 page)
  * Key findings from analysis
  * Business implications
  * Recommendations
```

**Chapter 6 JOIN Operations (15 points)**
```
- Overview of how tables relate
- JOIN Query 1: Products with inventory and warehouses
  * SQL code
  * Results screenshot
  * Explanation: "Shows product availability across locations"

- JOIN Query 2: Suppliers with products
  * SQL code
  * Results screenshot
  * Explanation: "Identifies supplier diversity and coverage"

- Additional JOIN (Bonus)
  * Shows complex multi-table relationship
  * Adds value to analysis

- Output Interpretation (1 page)
  * What the JOINs reveal
  * Business value of the data combinations
  * Real-world application
```

**Formatting:**
- Font: Times New Roman or Arial
- Size: 12pt
- Spacing: 1.5 lines
- Margins: 1 inch all sides
- Include page numbers
- Table of contents
- Screenshots should be clear and labeled

---

## RISK MITIGATION & BEST PRACTICES

### Common Mistakes to Avoid

| ❌ MISTAKE | ✅ SOLUTION |
|---|---|
| Using Python's pandas for filtering instead of SQL | Explicitly use SQL WHERE, GROUP BY, etc. Show the queries |
| Not showing SQL query results | Always include screenshots/outputs of query results |
| Incomplete ERD | Use proper ER diagram tool (Lucidchart, DrawIO) and include relationships |
| Only showing 3 filtering queries instead of minimum 5 | Plan minimum requirements and exceed them by 1-2 |
| Team members not understanding parts of system | Rotate who explains each section during demo/presentation |
| Data quality issues too subtle to see | Make issues obvious (many NULLs, clear duplicates, obvious inconsistencies) |
| Not documenting the cleaning process | Keep before/after screenshots for every major fix |
| Queries that don't run or have errors | Test all queries multiple times before presentation |
| Forgetting to explain insights from data | Always add 1-2 sentences explaining what the results mean |
| Poor presentation skills | Practice demo 3+ times before actual presentation |

### Best Practices for Success

**1. Version Control (Use Git)**
```bash
# Initialize repository
git init
git add .
git commit -m "Initial project setup"

# Track contributions
git log --oneline

# Each team member works on branch
git checkout -b [member_name]/[feature]
git push origin [member_name]/[feature]
```

**2. Documentation as You Go**
- Don't wait until the end to document
- Take screenshots immediately after running queries
- Keep notes of findings in real-time
- Maintain a shared document (Google Docs) where everyone updates

**3. Regular Testing**
```sql
-- After each batch of changes, run verification queries
SELECT 'products' as table_name, COUNT(*) FROM products
UNION ALL SELECT 'inventory', COUNT(*) FROM inventory
UNION ALL SELECT 'suppliers', COUNT(*) FROM suppliers;

-- Check for data issues again
SELECT COUNT(*) as null_count FROM products WHERE unit_cost IS NULL;
SELECT COUNT(*) as negative_qty FROM inventory WHERE quantity < 0;
```

**4. Database Backup**
```bash
# Export database before major operations
mysqldump -u root -p inventory_db > backup_$(date +%Y%m%d).sql

# Can restore if something goes wrong
mysql -u root -p inventory_db < backup_20250101.sql
```

**5. Query Optimization**
- Index frequently queried columns
- Avoid SELECT * when possible
- Use LIMIT for large result sets
- Document what each query does

**6. Team Coordination**
- Weekly sync meetings
- Shared Google Drive with all documents
- Assign clear responsibilities
- Backup plan if someone can't present

---

## SCORING MAXIMIZATION STRATEGY

### Laboratory Track (100 points)

| Component | Points | Strategy |
|-----------|--------|----------|
| Database Design | 20 | Create detailed ERD with 6 tables (exceed 5 minimum), proper relationships |
| Dataset | 10 | Exactly 100+ records, aligned to system perfectly |
| Data Quality ID | 10 | Identify 8+ issues, document with screenshots |
| Data Cleaning | 15 | Show 5+ different cleaning techniques with before/after |
| Data Filtering | 10 | Implement 5 queries, maybe add 1-2 bonus advanced filters |
| Data Analysis | 15 | Implement 5 queries with interesting insights, not just basic counts |
| JOIN Operations | 10 | Implement 2+ JOINs, add 1 complex multi-table JOIN |
| Demo | 10 | Practice extensively, show confidence, explain clearly |
| Collaboration | 10 | All members participate equally, all can explain any part |
| **TOTAL** | **100** | **Exceed minimums in every category** |

### To Maximize Points:

✅ **Add Extra Elements:**
- Create views for frequently used queries
- Add derived columns with CASE statements
- Create a simple web UI with Python Flask (shows initiative)
- Write triggers for automatic updates
- Document edge cases and how you handled them

✅ **Demonstrate Deep Understanding:**
- Explain WHY you chose certain table designs
- Discuss normalization (1NF, 2NF, 3NF)
- Show performance considerations
- Mention security concerns (SQL injection prevention)

✅ **Professional Presentation:**
- Professional attire during demo
- Prepared script (not reading slides)
- Smooth transitions between speakers
- Handle questions confidently

---

## TIMELINE & DELIVERABLES

### Suggested 8-Week Timeline

| Week | Task | Deliverable |
|------|------|-------------|
| **Week 1** | System selection, requirement analysis, team roles | Project charter, system scope document |
| **Week 2** | ER diagram design, table structure planning | ERD image, CREATE TABLE statements |
| **Week 3** | Data generation, introduce quality issues | Raw dataset (CSV), 100+ records |
| **Week 3-4** | Document data quality problems | Data quality report with screenshots |
| **Week 4** | Write and test cleaning queries | Cleaned dataset, before/after documentation |
| **Week 5** | Write filtering and analysis queries | SQL file with 10+ queries and outputs |
| **Week 5-6** | Write JOIN queries, create visualizations | SQL JOIN file, result screenshots |
| **Week 6** | Create documentation/prepare demo | Draft PDF chapters OR demo script |
| **Week 7** | Practice presentation, refine materials | Polished PDF OR demo video |
| **Week 8** | Final submission/presentation | Final PDF submission OR live demo |

### Submission Checklist

**For Laboratory Track:**
- [ ] 5-10 minute video OR live demonstration scheduled
- [ ] All team members present/able to explain system
- [ ] Database with 100+ records in working state
- [ ] All SQL queries executed with visible results
- [ ] Backup of database (`.sql` file)
- [ ] Script or outline of demo presentation

**For Lecture Track:**
- [ ] PDF document (100+ pages expected)
- [ ] All 6 chapters with required content
- [ ] Screenshots embedded in document
- [ ] SQL code blocks showing all queries
- [ ] Before/after comparison for data cleaning
- [ ] Proper formatting (Times New Roman, 12pt, 1.5 spacing)
- [ ] Table of contents and page numbers
- [ ] Date submitted clearly marked

**For Both:**
- [ ] Cover letter with group members and roles
- [ ] Evidence of data quality issues (screenshots)
- [ ] Clean, organized submission
- [ ] All files properly named and labeled

---

## CONCLUSION & FINAL THOUGHTS

### What This Project Tests

✅ **Database Design** - Can you architect a normalized database?  
✅ **Data Engineering** - Can you handle real-world messy data?  
✅ **SQL Proficiency** - Can you write complex queries?  
✅ **Analysis Skills** - Can you derive insights from data?  
✅ **Communication** - Can you explain technical concepts?  
✅ **Teamwork** - Can you collaborate and divide work fairly?  

### Why This Matters

This project is **not** just about getting a grade. It's training for real jobs where:
- Database administrators manage production databases
- Data engineers clean and prepare data
- Data analysts extract insights
- Software engineers integrate databases with applications
- Project managers coordinate teams

### Success Formula

```
PLANNING (10%) + EXECUTION (60%) + PRESENTATION (20%) + TEAMWORK (10%) = 100
```

Plan thoroughly → Execute consistently → Present professionally → Work together harmoniously

### If You Follow This Guide

You will:
- ✅ Meet ALL requirements
- ✅ Understand every part of your system
- ✅ Score 85-100 points
- ✅ Build portfolio-worthy work
- ✅ Graduate prepared for industry

---

**Good luck! You've got this. 💪**

---

## QUICK REFERENCE: Commands You'll Need

```sql
-- Create database
CREATE DATABASE inventory_db;
USE inventory_db;

-- Export data
mysqldump -u root -p inventory_db > backup.sql

-- Import data
mysql -u root -p inventory_db < backup.sql

-- View data quality
SELECT COUNT(*) as total FROM products;
SELECT COUNT(*) as nulls FROM products WHERE unit_cost IS NULL;
SELECT product_id, COUNT(*) FROM products GROUP BY product_id HAVING COUNT(*) > 1;

-- Clean data
UPDATE products SET category = UPPER(TRIM(category));
DELETE FROM products WHERE product_id IN (...);

-- Analyze data
SELECT category, COUNT(*), AVG(unit_cost) FROM products GROUP BY category;
SELECT * FROM products WHERE unit_cost BETWEEN 1000 AND 5000;
SELECT * FROM products p INNER JOIN inventory i ON p.product_id = i.product_id;
```

---

**Document prepared as comprehensive guide for DCIT 55A Project**  
**Last updated: June 2026**
