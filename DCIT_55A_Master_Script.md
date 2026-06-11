# DCIT 55A Master Script & Presentation Guide

This document is your **Step-by-Step Ultimate Guide** for executing the project and presenting it to your professor. Follow this script precisely to ensure a flawless demonstration and a 100% grade.

---

## 🛠️ Phase 1: Preparation (Do this before the presentation)

Before you begin taking screenshots for your documentation or presenting your video, you need to load the "Dirty Data" into your system.

**Step 1:** Open phpMyAdmin or your MySQL client.
**Step 2:** Select your `purevibe` database.
**Step 3:** Go to the "Import" tab and upload the `purevibe_dirty_data.sql` file.
> *Note: This will delete your current perfect data and replace it with 115+ records containing intentional errors (NULL prices, negative stock, weird category casing).*

---

## 📸 Phase 2: Screenshot Guide for Documentation

Now that the system has dirty data, open your PureVibe Admin Dashboard, click on **"DCIT 55A Project" -> "SQL Runner"**, and run these queries. Take a screenshot of the results and paste them into `PureVibe_DCIT_55A_Documentation.md`.

### 1. Data Assessment Screenshots (Chapter 3)
Run this to show the dirty data:
```sql
SELECT id, name, unit_price, current_stock FROM products WHERE unit_price IS NULL OR current_stock < 0;
```
*(Take screenshot and paste into Chapter 3)*

### 2. Data Cleaning Screenshots (Chapter 4)
Run these one by one. Thanks to the upgraded SQL Runner, it will show a "Before" and "After" table. Screenshot the entire split-screen!
```sql
UPDATE categories SET name = CONCAT(UPPER(SUBSTRING(name, 1, 1)), LOWER(SUBSTRING(name, 2)));
```
```sql
UPDATE products SET unit_price = 0.00 WHERE unit_price IS NULL;
```

### 3. Filtering, Analysis, and JOIN Screenshots (Chapters 5, 6, 7)
Copy and paste every query from `PureVibe_DCIT_55A_Documentation.md` into the SQL Runner, execute them, and take screenshots of the tables it generates.

---

## 🎬 Phase 3: Live Video Presentation Script (10 Minutes)

The rubric strictly requires **all members to participate equally**. Use this rotation script for your video recording to guarantee full points on the Collaboration metric.

### Part 1: System Introduction (Member 1)
**Action:** Share screen showing the Kiosk Welcome Page.
**Script:** "Hello everyone, our group is presenting the PureVibe Kiosk System. This is a modern self-checkout and inventory management system designed to streamline retail operations. While the frontend allows customers to quickly order, the backend relies on an advanced relational database. Today, we will demonstrate the database architecture, data cleaning, and analytical queries that power this system."

### Part 2: Database Architecture (Member 2)
**Action:** Show the ERD diagram from the Documentation.
**Script:** "To ensure data integrity, our database is highly normalized. Our core tables include `products`, `categories`, `suppliers`, `transactions`, and `transaction_items`. The transaction items table maintains historical accuracy by copying the exact price at the moment of checkout. This prevents our financial records from being altered if a product price changes in the future."

### Part 3: Data Assessment & Cleaning (Member 3)
**Action:** Open the SQL Runner in the Admin Dashboard.
**Script:** "A major part of our project involved data quality management. We intentionally loaded inconsistent data to demonstrate our cleaning process. I will now run an `UPDATE` query to fix the `NULL` prices in our products table."
*(Run the `UPDATE products SET unit_price = 0 WHERE unit_price IS NULL;` query)*
"As you can see on our built-in SQL runner, it shows the exact state of the rows before the modification on the left, and the cleaned data on the right."

### Part 4: Data Filtering (Member 4)
**Action:** Stay on the SQL Runner.
**Script:** "Now we will demonstrate data filtering using standard SQL. To find low-stock items, we use the `WHERE` clause."
*(Run: `SELECT id, name, sku, current_stock FROM products WHERE current_stock < 20;`)*
"Next, to find products within a specific price range, we utilize the `BETWEEN` operator."
*(Run: `SELECT name, unit_price FROM products WHERE unit_price BETWEEN 50.00 AND 500.00;`)*

### Part 5: Data Analysis & Aggregation (Member 5)
**Action:** Stay on the SQL Runner.
**Script:** "For business intelligence, we use SQL aggregate functions. To find the average price per category, we use `AVG()` combined with `GROUP BY`."
*(Run: `SELECT category_id, AVG(unit_price) as avg_price FROM products GROUP BY category_id;`)*
"To evaluate our total store inventory valuation, we use the `SUM()` function."
*(Run: `SELECT SUM(current_stock * unit_price) as total_value FROM products;`)*

### Part 6: Complex JOINs & Conclusion (Member 6)
**Action:** Stay on the SQL Runner, then switch back to the Kiosk UI at the end.
**Script:** "Finally, to bring this relational data together, we use `INNER JOIN` operations. This query connects products to their categories and suppliers to give us a complete view of the inventory."
*(Run: `SELECT p.name as product, c.name as category, s.supplier_name FROM products p INNER JOIN categories c ON p.category_id = c.id INNER JOIN suppliers s ON p.supplier_id = s.id LIMIT 10;`)*
"In conclusion, the PureVibe system fully leverages advanced database concepts to ensure accurate real-time inventory management. Thank you for watching our presentation."

---

## ✅ Final Checklist Before Submission
- [ ] Imported `purevibe_dirty_data.sql`
- [ ] Took all screenshots and pasted them into `PureVibe_DCIT_55A_Documentation.md`
- [ ] Exported `PureVibe_DCIT_55A_Documentation.md` to PDF
- [ ] Recorded the 10-minute video using the script above
- [ ] Ensured all 6 team members spoke during the video
