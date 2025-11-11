<?php
require_once __DIR__ . '/../lib/csrf.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
echo json_encode(['token' => csrf_token()]);
