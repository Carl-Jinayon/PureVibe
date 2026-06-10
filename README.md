# PureVibe Kiosk - Self-Checkout System

This is the PureVibe Kiosk, a self-checkout system built with Laravel. It features a frontend kiosk for customers to purchase items, and an admin dashboard to manage products, categories, suppliers, inventory, and transactions.

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL or MariaDB
- Node.js & NPM

## Getting Started

Follow these steps to set up and run the application locally.

### 1. Install Dependencies

Install the PHP dependencies via Composer:

```bash
composer install
```

Install the NPM dependencies and build assets:

```bash
npm install
npm run build
```

### 2. Configure Environment

Copy the example environment file:

```bash
cp .env.example .env
```

Open the `.env` file and configure your database settings. For example:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=grocery_self_checkout
DB_USERNAME=root
DB_PASSWORD=your_password
```

Generate the application key:

```bash
php artisan key:generate
```

### 3. Setup the Database

We have included a `schema.sql` file in the root directory that contains the complete database structure and some initial data (including the default admin user).

1. Create an empty database named `grocery_self_checkout` in your MySQL server.
2. Import the `schema.sql` file into your newly created database:
   ```bash
   mysql -u root -p grocery_self_checkout < schema.sql
   ```
*(Alternatively, you can use a GUI tool like phpMyAdmin, TablePlus, or DBeaver to import the `schema.sql` file).*

**Note:** If you prefer using Laravel's built-in migrations and seeders instead of the SQL dump, you can run:
```bash
php artisan migrate:fresh --seed
```

### 4. Link Storage

The application uses local storage for product images. Create a symbolic link to make them publicly accessible:

```bash
php artisan storage:link
```

### 5. Run the Application

Start the local development server:

```bash
php artisan serve
```

The application will be accessible at `http://127.0.0.1:8000` or `http://localhost:8000`.

---

## Application Structure

- **Kiosk Interface:** The customer-facing checkout system is available at the root URL (`/`).
- **Admin Dashboard:** Access the backend management system at `/admin/login`.

### Admin Login Credentials
If you imported the database using `schema.sql` or ran the seeders, you can log in using the default admin account:
- **Email:** `admin@admin.com`
- **Password:** `password`

## Key Features
- **Real-Time Sync:** Transactions placed on the kiosk appear instantly on the admin dashboard for confirmation.
- **Inventory Tracking:** Stock is automatically deducted and recorded when a transaction is confirmed by an admin.
- **Dynamic Configuration:** Tax rates, store information, and receipt messages can be updated from the Admin Settings panel.
