<?php
// Ensure sessions don't interfere with unit tests.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../backend/lib/db.php';
require __DIR__ . '/../backend/lib/validators.php';
require __DIR__ . '/../backend/lib/csrf.php';
require __DIR__ . '/../backend/lib/repositories.php';
require __DIR__ . '/../backend/lib/auth.php';
