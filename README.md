# Farm Visit Showcase – DGL 123 (Milestone 4)

This project is part of **DGL 123 – PHP & MySQL** at North Island College.  
It implements a small-scale farm visit showcase website with a functional **PHP/MySQL** backend and a protected **admin dashboard**.  
The system supports user authentication, CRUD operations, and a booking request workflow.

---

## 📌 Project Overview

The website includes:

- A public-facing frontend (home, gallery, contact/booking form)
- An admin dashboard where authorized users can:
  - Manage gallery images (CRUD)
  - Update farm hours
  - View and update booking statuses
- A database-driven backend using **PHP (PDO)** and **MySQL**
- A booking handler that accepts submissions from the frontend and stores them in the database

---

## 📂 Folder Structure

dgl123-f2025-Abdalrahman-farmvisit/
│
├── admin/ # Admin dashboard pages
│ ├── login.php
│ ├── register.php
│ ├── dashboard.php
│ ├── gallery.php
│ ├── upload_gallery.php
│ ├── update_gallery.php
│ ├── delete_gallery.php
│ ├── hours.php
│ ├── save_hours.php
│ ├── bookings.php
│ ├── update_booking.php
│ └── logout.php
│
├── assets/
│ ├── css/
│ │ ├── style.css # Frontend styling
│ │ └── admin.css # Admin styling
│ ├── js/
│ │ └── main.js # JS logic for gallery + booking form
│ └── images/ # Images + gallery assets
│
├── config/
│ └── db.php # Database connection
│
├── database/
│ └── schema.sql # MySQL schema + seed data
│
├── frontend/
│ ├── index.html
│ ├── gallery.html
│ └── contact.html
│
├── handlers/
│ └── submit_booking.php # JSON booking submission handler
│
└── uploads/ # Uploaded gallery images (writeable)


---

# 🖥️ **How to Run the Project Locally (XAMPP Setup Guide)**

Follow these steps carefully to run this project on your machine.

---

## 1️⃣ Install XAMPP

Download from:  
https://www.apachefriends.org/

Install and open the **XAMPP Control Panel**.

---

## 2️⃣ Start Required Services

In XAMPP:

- ✔ Start **Apache**
- ✔ Start **MySQL**

Both must be running (green).

---

## 3️⃣ Place the Project in `htdocs`

Move the entire project folder to:

C:\xampp\htdocs\dgl123-f2025-Abdalrahman-farmvisit


---

## 4️⃣ Import the Database Using phpMyAdmin

1. Open your browser and go to:

http://localhost/phpmyadmin


2. Click **New** → Create a database named:

farmvisit


3. Select the new database.
4. Go to the **Import** tab.
5. Import this file:

/database/schema.sql


This creates all required tables:

✔ users  
✔ gallery_images  
✔ bookings  
✔ farm_hours  
✔ produce  
✔ categories  

---

## 5️⃣ Configure Database Credentials

Open:

config/db.php


Make sure the values match your XAMPP setup:

```php
$host = "localhost";
$dbname = "farmvisit";
$username = "root";
$password = ""; // Default XAMPP password is empty

6️⃣ Access the Public Website

Open:

http://localhost/dgl123-f2025-Abdalrahman-farmvisit/frontend/index.html

7️⃣ Access the Admin Dashboard

Admin login page:

http://localhost/dgl123-f2025-Abdalrahman-farmvisit/admin/login.php

Before logging in, create an account:

http://localhost/dgl123-f2025-Abdalrahman-farmvisit/admin/register.php

This creates your staff user.
---

## 🆕 Milestone 4 Summary

- Added reusable admin header/footer with centralized authentication, input sanitization, and flash message handling.
- Ensured every admin page uses forward-slash CSS paths and session protection.
- Improved database access with prepared statements and guarded execution.
- Cleaned up file upload validation, booking submission handling, and general formatting.
- Documented files with purpose comments and refreshed frontend asset links.

✨ Features Implemented
🔐 User Authentication

Staff registration

Login & logout

Password hashing using password_hash()

Admin-only access using sessions

🖼️ Gallery Management (CRUD)

Upload new images

Edit captions

Delete images

Display gallery on frontend

🕒 Farm Hours Management

Update farm hours stored in MySQL

Display changes on the public site

📩 Booking System

Frontend form submits via JS (AJAX)

handlers/submit_booking.php validates + stores request

Admin can update booking status (new → confirmed/cancelled)

🎨 Frontend Design

Responsive layout

Hover effects

Image modal viewer

Smooth scrolling

📌 Future Enhancements

(Optional for Milestone 3 but good for full project polish.)

Add CRUD for produce/categories

Add email confirmation for bookings

Improve admin dashboard UI

Add admin roles (manager, staff)

Add pagination to gallery

🤖 AI Assistance Acknowledgement

Portions of this project—including code refactoring, debugging guidance, and parts of this README—were created with the help of AI tools (ChatGPT).
All final implementations were tested, reviewed, and modified manually to meet the course requirements.

✔ Project Ready for Submission

GitHub Repository:
https://github.com/Abdalrhman210505/dgl123-f2025-Abdalrahman-farmvisit