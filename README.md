# Log HARDWARE - Official Spare Parts & Appliance Store
### CodeIgniter 3 MVC Web Application

A fully functional PHP CodeIgniter 3 web application converted from the **Google Stitch** design system (*Sahara — Warm Minimalism* & *High-Utility Modern E-Commerce*).

---

## 🚀 Key Features

### 1. Storefront & Catalog (Frontend)
- **Home (`/`)**: Dynamic landing page featuring active appliance categories, top spare parts, instant search bar, warehouse status notice, and WhatsApp direct ordering links.
- **Product Catalog (`/products`)**: Dynamic catalog with real-time live search, category filtering (AC, Washing Machine, Refrigerator, Microwave, Water Purifier), brand filter, stock availability status, and clean pagination.
- **Product Details (`/products/{id}`)**: Detailed view with high-resolution image preview, full technical specifications table, warranty, OEM compatibility, WhatsApp quotation builder, and wholesale order inquiry form.
- **Instant Inquiry (`/inquire`)**: Quote and stock inquiry submission stored directly in MySQL and dispatchable via WhatsApp.

### 2. Secure Admin Operations Portal (`/admin`)
- **Authentication (`/admin/login`)**:
  - **Email:** `Sameer123@AA.com`
  - **Password:** `Sameer3111`
  - Stored securely using PHP `password_hash()` (Bcrypt) and validated via `password_verify()`.
  - Protected with CodeIgniter session guards on all admin routes.
- **Real-Time KPI Dashboard (`/admin/dashboard`)**:
  - Dynamically calculates: Total SKUs, Active Inventory, Low Stock alerts (≤10 units), and Out of Stock counts directly from the MySQL database.
- **Product & Inventory Management (`/admin/products`)**:
  - Search, filter, and review catalog items.
  - **Add Product (`/admin/products/add`)**: Complete modal and standalone form with image file uploads stored in `/uploads/products/`.
  - **Edit Product (`/admin/products/edit/{id}`)**: Update product details, prices, stock levels, and upload replacement photos.
  - **Delete & Status Toggle**: Fast SKU removal with confirmation and one-click active/inactive visibility toggle.
- **Customer & Technician Inquiries (`/admin/inquiries`)**:
  - Review quote requests, phone numbers, and requirements with 1-click WhatsApp reply integration.
- **Categories Manager (`/admin/categories`)**:
  - Manage appliance taxonomy and product classifications.

---

## 🛠 Project Structure

```
New_project/
│
├── application/
│   ├── config/
│   │   ├── config.php          # Dynamic base URL, CSRF protection, session handling
│   │   ├── database.php        # MySQL database settings (with env variable fallbacks)
│   │   ├── routes.php          # Clean RESTful routing
│   │   └── autoload.php        # Auto-loaded libraries, helpers, and models
│   │
│   ├── controllers/
│   │   ├── Home.php            # Storefront homepage controller
│   │   ├── Products.php        # Catalog, search, filters, detail, and inquiries
│   │   └── Admin/
│   │       ├── Auth.php        # Admin login/logout & session verification
│   │       ├── Dashboard.php   # Real-time metrics and inventory control
│   │       ├── Products.php    # Product CRUD and image upload handling
│   │       ├── Categories.php  # Appliance category management
│   │       └── Inquiries.php   # Customer/technician orders & quote requests
│   │
│   ├── core/
│   │   └── MY_Controller.php   # Session auth guard for admin controller hierarchy
│   │
│   ├── models/
│   │   ├── Product_model.php   # Product queries, search, filtering, and KPI counts
│   │   ├── Category_model.php  # Category queries and product counts
│   │   ├── Admin_model.php     # Admin authentication and secure password check
│   │   └── Inquiry_model.php   # Inquiries and customer messages
│   │
│   └── views/
│       ├── frontend/
│       │   ├── home.php            # Screen 1: Store Landing Page
│       │   ├── products.php        # Screen 2: Catalog & Filter Page
│       │   └── product_detail.php  # Detailed product view
│       ├── admin/
│       │   ├── login.php           # Screen 4: Admin Login Portal
│       │   ├── dashboard.php       # Screen 3: Admin Dashboard with Add Product Modal
│       │   ├── add_product.php     # Dedicated Add Product form
│       │   ├── edit_product.php    # Dedicated Edit Product form
│       │   ├── inquiries.php       # Inquiries & Quotes management
│       │   └── categories.php     # Category taxonomy manager
│       └── templates/
│           └── admin_sidebar.php   # Shared Sahara Operations navigation
│
├── database/
│   └── log_hardware.sql        # Complete MySQL database schema & seed data
│
├── uploads/
│   └── products/               # Product image uploads (.htaccess protected)
│
├── assets/                     # CSS, JS, and image assets
├── system/                     # Official CodeIgniter 3.1.13 Framework Core
├── index.php                   # Front controller
└── .htaccess                   # URL rewriting & security rules
```

---

## ⚙️ Installation & Setup Instructions

### 1. Database Setup
1. Create a MySQL database named `log_hardware`:
   ```sql
   CREATE DATABASE log_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Import the schema and seed data from `database/log_hardware.sql`:
   ```bash
   mysql -u root -p log_hardware < database/log_hardware.sql
   ```

### 2. Database Configuration
Open [`application/config/database.php`](file:///home/nowapps/Downloads/Ck/New_project/application/config/database.php) and adjust your credentials if needed:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'log_hardware',
    'dbdriver' => 'mysqli',
    ...
);
```

### 3. Run Locally (Apache / Nginx / PHP Built-in Server)
You can test and run the application instantly using PHP's built-in server or your web server (Apache/Nginx/XAMPP):
```bash
php -S localhost:8080
```
- Open `http://localhost:8080/` for the **Customer Storefront**.
- Open `http://localhost:8080/products` for the **Catalog & Spare Parts Search**.
- Open `http://localhost:8080/admin/login` for the **Admin Portal**.

---

## 🔐 Admin Credentials

- **Email:** `Sameer123@AA.com`
- **Password:** `Sameer3111`
- **Role:** `superadmin`
