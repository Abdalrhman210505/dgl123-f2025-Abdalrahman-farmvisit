# Farm Visit & Produce Showcase - Milestone 3

This repository contains the backend implementation for the Farm Visit & Produce Showcase project. It introduces a PHP/MySQL stack with authentication, admin management tools, and PHPUnit tests.

## Requirements

- PHP 8.1+
- Composer
- MySQL 8 (or MariaDB 10.5+)
- PDO extension enabled

## Project Structure

```
backend/
  auth/        # Login, register, logout screens
  admin/       # Admin dashboard and CRUD screens
  handlers/    # Form submission handlers
  lib/         # Shared libraries (PDO, auth, validators, repositories, CSRF)
uploads/
  gallery/     # Writable directory for uploaded images
frontend/      # Existing HTML/CSS/JS prototypes
database/      # Schema and seed SQL files
```

## Environment Configuration

Configure environment variables for database access:

```
DB_HOST=127.0.0.1
DB_NAME=farm_visit_showcase
DB_USER=farm_user
DB_PASS=secret
```

Alternatively set `DB_DSN` to a full PDO DSN (e.g., `mysql:host=127.0.0.1;dbname=farm_visit_showcase;charset=utf8mb4`).

## Installation

1. Install PHP dependencies:
   ```bash
   composer install
   ```
2. Create a new MySQL database and user with access to it.
3. Import the schema and seed data:
   ```bash
   mysql -u farm_user -p farm_visit_showcase < database/schema.sql
   mysql -u farm_user -p farm_visit_showcase < database/seed.sql
   ```

Ensure `uploads/gallery` is writable by the web server process.

## Running the Application

Use PHP's built-in server for development:

```bash
php -S localhost:8000 -t frontend
```

For admin routes, point the server to the repository root:

```bash
php -S localhost:8000 -t .
```

Then access:
- Public site: http://localhost:8000/frontend/index.html
- Admin dashboard: http://localhost:8000/backend/admin/dashboard.php

## Tests

Run PHPUnit with:

```bash
vendor/bin/phpunit
```

The test suite uses an in-memory SQLite database.

## Database Dump

To generate the submission dump, run:

```bash
mysqldump -u farm_user -p farm_visit_showcase > database/dump.sql
```

Commit the resulting `dump.sql` for milestone submission.

## Security Notes

- Passwords are stored using `password_hash` and verified with `password_verify`.
- Sessions are regenerated on login; only minimal user data is stored in the session.
- All forms performing state changes include CSRF protection (`csrf_field` + `verify_csrf`).
- All database queries use prepared statements through the repository layer.
- Uploaded filenames are sanitized and stored in `uploads/gallery`.

