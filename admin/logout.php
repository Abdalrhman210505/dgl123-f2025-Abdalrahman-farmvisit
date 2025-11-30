<?php
/**
 * Terminates the admin session and returns user to the login page.
 */

require_once __DIR__ . '/includes/admin_bootstrap.php';
session_unset();
session_destroy();

header('Location: login.php');
exit;
