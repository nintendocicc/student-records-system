# 🎓 Student Records Management System

A simple CRUD web application built with **PHP**, **Apache**, and **MySQL** for managing student records.

## Features

- ✅ Add student records
- ✅ Display all students in a sortable, searchable table
- ✅ Update student information
- ✅ Delete student records
- 📊 Live dashboard stats (total students, courses, avg GPA, honors count)

## Tech Stack

| Layer    | Technology        |
|----------|-------------------|
| Frontend | HTML, CSS, JavaScript (vanilla) |
| Backend  | PHP 8+            |
| Server   | Apache (via MAMP) |
| Database | MySQL             |

## Project Structure

```
student-records-system/
├── index.php        ← Frontend UI (HTML + CSS + JS)
├── api.php          ← Backend CRUD logic (PHP)
├── db_connect.php   ← Database connection config
├── database.sql     ← DB schema + sample data
├── .gitignore
└── README.md
```

## Setup Instructions (macOS with MAMP)

### 1. Install MAMP
Download from [mamp.info](https://www.mamp.info) and start Apache + MySQL.

### 2. Configure the database connection
Open `db_connect.php` and adjust for your setup:

```php
// MAMP defaults
define('DB_PASS', 'root');   // MAMP uses 'root'
define('DB_PORT', 8889);     // MAMP uses 8889
```

### 3. Create the database
- Open phpMyAdmin: `http://localhost:8888/phpMyAdmin`
- Click the **SQL** tab
- Paste the contents of `database.sql` and click **Go**

### 4. Deploy the project
Copy the entire `student-records-system/` folder to:
```
/Applications/MAMP/htdocs/student-records-system/
```

### 5. Open the app
Visit: [http://localhost:8888/student-records-system/](http://localhost:8888/student-records-system/)

---

## XAMPP Setup (alternative)

- `DB_PASS` → `''` (empty string)
- `DB_PORT` → `3306`
- Copy folder to: `/Applications/XAMPP/htdocs/student-records-system/`
- Visit: `http://localhost/student-records-system/`

---

## Author

Jayson James Mayor — Introduction to PHP, Apache and MySQL
