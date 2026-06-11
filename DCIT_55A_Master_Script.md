# DCIT 55A Master Script & Presentation Guide

This document is your **Step-by-Step Ultimate Guide** for executing the project and presenting it to your professor. Follow this script precisely to ensure a flawless demonstration and a 100% grade.

---

## 🛠️ Phase 1: Preparation (Do this before the presentation)

Before you begin taking screenshots for your documentation or presenting your video, you need to load the "Dirty Data" into your system.

**Step 1:** Open phpMyAdmin or your MySQL client.
**Step 2:** Select your application's database (check your `.env` file — the database name is set as `DB_DATABASE`, e.g., `grocery_self_checkout`).
**Step 3:** Go to the "Import" tab and upload the `purevibe_dirty_data.sql` file.
> *Note: This will delete your current data and replace it with 110+ products and 100+ transactions containing intentional errors (NULL prices, negative stock, inconsistent category casing, duplicate SKUs).*

---

## 📸 Phase 2: Screenshot Guide for Documentation

Now that the system has dirty data, open your PureVibe Admin Dashboard and click on **"SQL Runner"** in the left sidebar (under the admin menu). Run the queries below, take a screenshot of the results, and paste them into `PureVibe_DCIT_55A_Documentation.md`.

*(All the queries you need to run for the screenshots are already included in the Phase 3 script below. Just follow the exact queries listed under each member's part, execute them, and take your screenshots for Chapters 3 to 7 of your documentation!)*

---

## 🎬 Phase 3: Live Video Presentation Script (Super Detailed Flow)

The rubric strictly requires **all members to participate equally**. Use this exact word-by-word script for your video recording to guarantee full points on the Collaboration metric.

### Part 1: System Introduction (Member 1)
**Action:** Share screen showing the Kiosk Welcome Page.
**Script (Word-by-Word):** 
"Hello everyone, our group is presenting the PureVibe Kiosk System. This is a modern self-checkout and inventory management system designed to streamline retail operations. While the frontend allows customers to quickly order, the backend relies on an advanced relational database. Today, we will demonstrate the database architecture, data cleaning, and analytical queries that power this system."

### Part 2: Database Architecture & Dynamic Pricing (Member 2)
**Action:** Show the ERD diagram from the Documentation, and briefly show the Pricing & Markup settings in the Admin Dashboard.
**Script (Word-by-Word):** 
"To ensure data integrity and flexibility, our database is highly normalized. Our core tables include products, categories, suppliers, transactions, and transaction items. We also recently implemented a dynamic pricing engine powered by the supplier product prices table. Our system automatically calculates product selling prices by taking the supplier's cost and adding a globally configured markup percentage. To maintain accurate financial audits, the transaction items table saves the exact selling price at the moment of checkout, and the supplier product prices table tracks historical costs, separating old stock value from new stock value."

### Part 3: Data Assessment & Cleaning (Member 3)
**Action:** Open the SQL Runner in the Admin Dashboard.
**Script (Word-by-Word):** 
"A major part of our project involved data quality management. We intentionally loaded inconsistent data to demonstrate our cleaning process. First, let's look at the dirty data. I will run a query to find products with NULL prices or negative stock."
**Action:** Copy, paste, and run this query:
```sql
SELECT id, name, unit_price, current_stock FROM products WHERE unit_price IS NULL OR current_stock < 0;
```
**Script (Word-by-Word):**
"As you can see, we have anomalies. Now, let's clean the data. First, I will standardize our category names to proper title casing."
**Action:** Copy, paste, and run this query:
```sql
UPDATE categories SET name = CONCAT(UPPER(SUBSTRING(name, 1, 1)), LOWER(SUBSTRING(name, 2)));
```
**Script (Word-by-Word):**
"Notice the split-screen showing the 'Before' and 'After' state. Next, we will handle missing pricing by setting NULL prices to zero."
**Action:** Copy, paste, and run this query:
```sql
UPDATE products SET unit_price = 0.00 WHERE unit_price IS NULL;
```
**Script (Word-by-Word):**
"Third, I will fix invalid data by resetting negative inventory stock back to zero."
**Action:** Copy, paste, and run this query:
```sql
UPDATE products SET current_stock = 0 WHERE current_stock < 0;
```
**Script (Word-by-Word):**
"Finally, I will remove duplicate product entries based on their SKU."
**Action:** Copy, paste, and run this query:
```sql
DELETE FROM products WHERE id NOT IN (SELECT min_id FROM (SELECT MIN(id) as min_id FROM products GROUP BY sku) as temp_table);
```

### Part 4: Data Filtering Operations (Member 4)
**Action:** Stay on the SQL Runner.
**Script (Word-by-Word):** 
"Now we will demonstrate data filtering using standard SQL. To find low-stock items, we use the WHERE clause."
**Action:** Copy, paste, and run this query:
```sql
SELECT id, name, sku, current_stock FROM products WHERE current_stock < 20;
```
**Script (Word-by-Word):**
"Next, to find mid-tier products within a specific price range, we utilize the BETWEEN operator."
**Action:** Copy, paste, and run this query:
```sql
SELECT name, unit_price FROM products WHERE unit_price BETWEEN 50.00 AND 500.00;
```
**Script (Word-by-Word):**
"To locate any supplier containing 'Co' in their name, we use the LIKE operator for pattern matching."
**Action:** Copy, paste, and run this query:
```sql
SELECT id, name as supplier_name, email FROM suppliers WHERE name LIKE '%Co%';
```
**Script (Word-by-Word):**
"If we want to filter products belonging to specific categories, we use the IN clause."
**Action:** Copy, paste, and run this query:
```sql
SELECT name, category_id, unit_price FROM products WHERE category_id IN (1, 3, 5);
```
**Script (Word-by-Word):**
"Lastly, to retrieve the top 10 products with the highest inventory, we use the ORDER BY clause."
**Action:** Copy, paste, and run this query:
```sql
SELECT name, current_stock FROM products ORDER BY current_stock DESC LIMIT 10;
```

### Part 5: Data Analysis & Aggregation (Member 5)
**Action:** Stay on the SQL Runner.
**Script (Word-by-Word):** 
"For business intelligence, we extract meaningful metrics using SQL aggregate functions. First, we use the COUNT function to see the total number of products supplied by each supplier."
**Action:** Copy, paste, and run this query:
```sql
SELECT supplier_id, COUNT(*) as total_products_supplied FROM products GROUP BY supplier_id;
```
**Script (Word-by-Word):**
"Next, to evaluate our total store inventory financial valuation, we use the SUM function."
**Action:** Copy, paste, and run this query:
```sql
SELECT SUM(current_stock * unit_price) as total_inventory_valuation FROM products;
```
**Script (Word-by-Word):**
"To determine the average price of products within each category, we combine the AVG function with GROUP BY."
**Action:** Copy, paste, and run this query:
```sql
SELECT category_id, AVG(unit_price) as average_category_price FROM products GROUP BY category_id;
```
**Script (Word-by-Word):**
"If we want to filter our groups, such as finding categories with more than 3 active products, we use GROUP BY with the HAVING clause."
**Action:** Copy, paste, and run this query:
```sql
SELECT category_id, COUNT(*) as product_count FROM products GROUP BY category_id HAVING product_count > 3;
```
**Script (Word-by-Word):**
"We can also use multiple aggregates at once. Here is a comprehensive summary of our completed transaction financials."
**Action:** Copy, paste, and run this query:
```sql
SELECT COUNT(id) as total_transactions, SUM(total_amount) as gross_revenue, AVG(total_amount) as average_order_value, MAX(total_amount) as highest_sale FROM transactions WHERE status = 'completed';
```

### Part 6: Complex JOINs & Conclusion (Member 6)
**Action:** Stay on the SQL Runner.
**Script (Word-by-Word):** 
"Finally, to fully utilize the relational nature of our schema, we use complex JOIN operations. This query connects products to their human-readable categories and suppliers."
**Action:** Copy, paste, and run this query:
```sql
SELECT p.name as product_name, c.name as category_name, s.name as supplier_name FROM products p INNER JOIN categories c ON p.category_id = c.id INNER JOIN suppliers s ON p.supplier_id = s.id LIMIT 15;
```
**Script (Word-by-Word):**
"Our last query is a comprehensive 3-table join that reconstructs a full transaction receipt, joining transactions with their transaction items."
**Action:** Copy, paste, and run this query:
```sql
SELECT t.transaction_number, t.created_at, ti.product_name, ti.quantity, ti.subtotal, t.total_amount FROM transactions t INNER JOIN transaction_items ti ON t.id = ti.transaction_id WHERE t.status = 'completed' ORDER BY t.created_at DESC LIMIT 20;
```
**Action:** Switch back to the Kiosk UI or the Supplier Price History UI.
**Script (Word-by-Word):**
"In conclusion, the PureVibe system fully leverages advanced database concepts to ensure accurate real-time inventory management, dynamic pricing based on supplier costs, and bulletproof historical price tracking. Through data sanitization and targeted business intelligence queries, we've demonstrated our proficiency in database management. Thank you for watching our presentation."

---

## ✅ Final Checklist Before Submission
- [ ] Imported `purevibe_dirty_data.sql`
- [ ] Ran all queries during Phase 3 to take screenshots and paste them into `PureVibe_DCIT_55A_Documentation.md`
- [ ] Exported `PureVibe_DCIT_55A_Documentation.md` to PDF
- [ ] Recorded the live video strictly following the Phase 3 Script above
- [ ] Ensured all 6 team members spoke their respective parts word-by-word
