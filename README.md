# SDLC_Project – PHP Auth + Admin CRUD

A beginner-friendly PHP + MySQL project demonstrating:

- User **registration** and **login** with hashed passwords
- **Session-based authentication** (`user_id`, `username`, `role`)
- **Role-based authorization** (admin vs. regular user)
- **Product CRUD** (admin only)
- **User management** (admin only – change role, delete)

Stack: plain PHP · MySQLi · XAMPP · CSS (no frameworks)

---

## Prerequisites

| Tool | Download |
|------|----------|
| XAMPP (PHP 8.x + Apache + MySQL) | https://www.apachefriends.org/ |
| HeidiSQL (optional GUI) | https://www.heidisql.com/ |

---

## Setup Steps

### 1 – Start XAMPP

Open the **XAMPP Control Panel** and start **Apache** and **MySQL**.

### 2 – Copy the project

Place this folder inside `C:\xampp\htdocs\` so the path becomes:

```
C:\xampp\htdocs\SDLC_Project\
```

### 3 – Create the database

**Option A – phpMyAdmin**

1. Open http://localhost/phpmyadmin
2. Click **Import** → choose `database.sql` → click **Go**

**Option B – HeidiSQL**

1. Connect to `localhost` with user `root` (no password by default)
2. Open a new query tab, paste the contents of `database.sql`, run it

**Option C – MySQL CLI**

```bash
mysql -u root -p < database.sql
```

### 4 – Verify the connection settings

Open `demo_connect.php` and confirm the values match your XAMPP setup:

```php
$connect = mysqli_connect("localhost", "root", "", "SE08102_SDLC");
```

Change `root` / password / database name if your XAMPP configuration differs.

### 5 – Open the project

Visit http://localhost/SDLC_Project/login.php

---

## Default Admin Account

| Field    | Value      |
|----------|------------|
| Username | `admin`    |
| Password | `admin123` |

> **Important:** Change this password after your first login, or create a new admin and delete the default one.

---

## File Overview

| File | Purpose |
|------|---------|
| `demo_connect.php` | Database connection |
| `auth.php` | Session helpers – `is_login()`, `require_login()`, `require_admin()` |
| `register.php` | New user registration (bcrypt password hash) |
| `login.php` | Login form – `password_verify()`, stores session |
| `logout.php` | Destroys session, redirects to login |
| `index.php` | Home page – public product list |
| `admin.php` | Admin dashboard – product CRUD list |
| `product_add.php` | Add a product (admin only) |
| `product_edit.php` | Edit a product (admin only) |
| `product_delete.php` | Delete a product (admin only) |
| `admin_users.php` | User management list (admin only) |
| `user_role.php` | Change a user's role (admin only) |
| `user_delete.php` | Delete a user (admin only) |
| `style.css` | Shared CSS stylesheet |
| `database.sql` | Full SQL schema + default admin INSERT |

---

## Manual Test Flow

1. **Register** a new user at `/register.php`
2. **Login** as that user → you should land on `/index.php`
3. Try to visit `/admin.php` → you should be redirected to `/index.php` (not admin)
4. **Login as admin** (`admin` / `admin123`)
5. You should be redirected to `/admin.php`
6. **Add / Edit / Delete** a product
7. Go to **Quản lý User** and verify you see the user list
8. Try **Set Admin** on the test user, then **Set User** again
9. Try the **Xóa** (delete) button on your own row – it should be blocked
10. Try the **Set User** button on your own row – it should be blocked
11. Click **Đăng xuất** (logout) → you should land on `/login.php`

---

## Security Notes

- Passwords are stored using `password_hash()` with `PASSWORD_DEFAULT` (bcrypt)
- All SQL uses **prepared statements** – no SQL injection risk
- Session ID is regenerated after login to prevent session fixation
- Admin self-delete and self-role-removal are blocked server-side
- XSS is mitigated with `htmlspecialchars()` on all user output
