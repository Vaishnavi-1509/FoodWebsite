# Food Order Website (PHP + XAMPP)

This project is a PHP/MySQL food ordering site with a customer‑facing frontend and an admin backend. It supports categories, menu items, a cart flow, and order management.

---

**Table Of Contents**
1. Overview
2. Features
3. Tech Stack
4. Project Structure
5. Local Setup (XAMPP)
6. Database Setup
7. Admin Login
8. Categories And Menu Items
9. Cart And Orders
10. Troubleshooting
11. Notes

---

**Overview**
- Frontend: browse categories and menu, add to cart, and place orders.
- Backend: manage categories, food items, and view order details.
- Orders persist to MySQL, including line items.

---

**Features**
- Category browsing.
- Menu with “Add to Cart”.
- Cart badge in header.
- Order checkout with delivery details and payment method (Pay on Delivery).
- Order total calculation.
- Admin dashboard with order list and order detail page (line items table).

---

**Tech Stack**
- PHP (server‑side)
- MySQL / MariaDB
- HTML, CSS, JavaScript
- XAMPP for local development

---

**Project Structure**
- `index.php` — Homepage
- `menu.php` — Food menu with category filter
- `categories.php` — Categories list
- `order.php` — Cart and checkout
- `index.js` — Frontend interactions + cart storage
- `style.css` — Global styles
- `admin/` — Admin panel
- `config/constants.php` — DB config
- `partials.front/` — Shared frontend layout

---

**Local Setup (XAMPP)**
1. Install XAMPP.
2. Start **Apache** and **MySQL** in XAMPP Control Panel.
3. Copy project folder into:
   - `C:\xampp\htdocs\food-order`
4. Open the site:
   - `http://localhost/food-order/`
5. Admin panel:
   - `http://localhost/food-order/admin/`

---

**Database Setup**
1. Open phpMyAdmin:
   - `http://localhost/phpmyadmin`
2. Create database:
   - `food-order`
3. Import your SQL schema if you have one.
4. Required tables:
   - `tbl_admin`
   - `tbl_category`
   - `tbl_food`
   - `tbl_order`
   - `tbl_order_item` (auto‑created after first order)

---

**Admin Login**
Admin passwords are stored as **MD5** in `tbl_admin`.

Example:
- Username: `admin`
- Password: `1234`
- MD5 of `1234`: `81dc9bdb52d04dc20036dbd8313ed055`

To reset admin password in phpMyAdmin:
1. Go to `tbl_admin`.
2. Edit the row.
3. Set `password` to the MD5 value.

---

**Categories And Menu Items**
Categories and menu items are linked by `category_id`:
- `tbl_category.id` ↔ `tbl_food.category_id`

If a food item doesn’t appear under a category:
1. Check the `category_id` value in `tbl_food`.
2. Ensure the category exists and is `active = 'Yes'`.

---

**Cart And Orders**
- Cart stored in `localStorage` (`fw_cart` key).
- On checkout, cart is POSTed to `order.php`.
- `tbl_order` stores:
  - customer details
  - order summary
  - totals
- `tbl_order_item` stores each ordered item.

Admin order details:
- `admin/manage-order.php` lists summary
- `admin/order-detail.php` shows line items table

---

**Notes**
- No production payment processing.
- Current payment method: Pay on Delivery.
- For real deployments, replace MD5 with stronger hashing.
