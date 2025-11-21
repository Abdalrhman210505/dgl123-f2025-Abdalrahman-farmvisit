diff --git a/README.md b/README.md
new file mode 100644
index 0000000000000000000000000000000000000000..e613eac33eed9c07f9d86a92cb61181e77643e4d
--- /dev/null
+++ b/README.md
@@ -0,0 +1,70 @@
+# Farm Visit Showcase (Milestone 3)
+
+This repository contains the in-progress PHP/MySQL implementation for the DGL 123 Project Assignment 3 (Farm Visit Showcase). It includes an admin area for managing gallery images, farm hours, and booking statuses, alongside static public-facing pages.
+
+## Project Structure
+
+- `admin/` – PHP admin dashboard (authentication, gallery CRUD, farm hours, booking status updates).
+- `config/` – Database connection configuration (`db.php`).
+- `database/` – SQL schema for MySQL setup (`schema.sql`).
+- `frontend/` – Static public pages (home, contact, gallery) and supporting assets.
+- `assets/` – Shared CSS/JS and images for the frontend and admin area.
+- `uploads/` – Uploaded gallery images (writeable directory required).
+
+## Prerequisites
+
+- PHP 8.1+ with PDO MySQL extension
+- MySQL 8 or MariaDB
+- Web server capable of running PHP (built-in `php -S` is fine for local development)
+
+## Local Setup
+
+1. **Clone the repository**
+   ```bash
+   git clone <repo-url>
+   cd dgl123-f2025-Abdalrahman-farmvisit
+   ```
+2. **Create the database and tables**
+   ```bash
+   mysql -u <user> -p < database/schema.sql
+   ```
+3. **Configure database credentials**
+   Edit `config/db.php` with your MySQL host, database, username, and password.
+4. **Ensure upload permissions**
+   Make sure the `uploads/` directory is writable by the web server/PHP process.
+5. **Run locally**
+   ```bash
+   php -S localhost:8000 -t .
+   ```
+   Access the site at `http://localhost:8000/frontend/index.html` for public pages and `http://localhost:8000/admin/login.php` for the admin area.
+
+## Current Functionality
+
+- **Authentication**: Staff/admin registration and login with password hashing and session-based access control for admin pages (`admin/login.php`, `admin/register.php`).
+- **Gallery Management**: Upload, edit captions, list, and delete gallery images stored in MySQL with physical file cleanup on deletion (`admin/gallery.php`, `admin/upload_gallery.php`, `admin/update_gallery.php`, `admin/delete_gallery.php`).
+- **Farm Hours Management**: Edit weekly open/close times and notes stored in the `farm_hours` table (`admin/hours.php`, `admin/save_hours.php`).
+- **Booking Status Updates**: List bookings and mark them confirmed or cancelled (`admin/bookings.php`, `admin/update_booking.php`).
+- **Frontend**: Static marketing pages with gallery grid and contact/plan-your-visit section (`frontend/index.html`, `frontend/contact.html`, `frontend/gallery.html`).
+- **Database Assets**: `database/schema.sql` defines the core tables (users, bookings, gallery_images, farm_hours, produce, categories) and seed data for farm hours.
+
+## Gaps Against Milestone 3 Rubric
+
+- **User Authentication (3 pts)**: Login/registration flows exist but roles are not enforced in the UI beyond access checks, and there is no password strength/validation feedback. Multi-role management and logout UX could be improved.
+- **CRUD Operations (3 pts)**: Gallery CRUD and farm-hour updates are present, but booking creation is missing (contact form does not post anywhere and `handlers/submit_booking.php` is empty). Produce/category CRUD is also absent.
+- **Database Integration (3 pts)**: MySQL is wired up for users, gallery, hours, and booking status updates, but some tables (produce, categories) are unused, and bookings cannot be created from the frontend.
+- **Front-End Design & Responsiveness (2 pts)**: Static pages exist with CSS styling, but no responsive testing artifacts, and forms lack dynamic validation/feedback. Admin UI is functional but minimal.
+- **Code Organization & Readability (2 pts each)**: Mixed inline PHP/HTML with minimal comments in some files; JS file (`assets/js/main.js`) mixes unrelated behaviors and reuses variable names. No autoloading or separation of concerns beyond directories.
+
+## Recommendations to Reach “Meets/Above Expectations”
+
+- Wire the contact/plan-your-visit form to create bookings (build `handlers/submit_booking.php`, validate/sanitize input, and persist to `bookings`).
+- Add booking creation on the public side and optionally an admin create/edit/delete interface for bookings.
+- Implement produce/category CRUD to use the existing schema or remove unused tables.
+- Strengthen authentication: role-based authorization for admin-only features, password strength checks, and clearer validation messages.
+- Enhance responsiveness and UX: responsive navigation, form validation, success/error states, and consistent styling across admin/public areas.
+- Add unit/integration tests where possible (e.g., PHP unit tests for handlers) and document how to run them.
+- Provide seeded admin credentials or a setup script for first-time login.
+
+## AI Acknowledgement
+
+Portions of this README and the project review were prepared with the assistance of AI tools to summarize repository contents and highlight needed improvements.
