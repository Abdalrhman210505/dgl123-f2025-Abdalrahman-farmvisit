<?php
require_once __DIR__ . '/../lib/validators.php';
require_once __DIR__ . '/../lib/repositories.php';
require_once __DIR__ . '/../lib/csrf.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /frontend/contact.html');
    exit;
}

if (!verify_csrf($_POST['_csrf'] ?? null)) {
    $_SESSION['flash_error'] = 'Invalid request.';
    header('Location: /frontend/contact.html');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$visitDate = $_POST['visit_date'] ?? '';
$visitTime = $_POST['visit_time'] ?? '';
$guests = $_POST['guests'] ?? '';
$message = trim($_POST['message'] ?? '');

$errors = [];
if (!not_empty($name)) {
    $errors[] = 'Name is required.';
}
if (!is_email($email)) {
    $errors[] = 'Valid email is required.';
}
if ($visitDate && !is_date($visitDate)) {
    $errors[] = 'Visit date must be YYYY-MM-DD.';
}
if ($visitTime && !is_time($visitTime)) {
    $errors[] = 'Visit time must be HH:MM.';
}
if ($guests && !is_int_range($guests, 1, 50)) {
    $errors[] = 'Guests must be between 1 and 50.';
}

if ($errors) {
    $_SESSION['flash_error'] = implode(' ', $errors);
    header('Location: /frontend/contact.html');
    exit;
}

createBooking([
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'visit_date' => $visitDate ?: null,
    'visit_time' => $visitTime ?: null,
    'guests' => $guests ?: null,
    'message' => $message,
]);

$_SESSION['flash_success'] = 'Thank you! We will confirm your visit shortly.';
header('Location: /frontend/contact.html');
exit;
