<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

require_once __DIR__ . '/../config/db.php';

// Collect and sanitize input
$visitorName = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');

$errors = [];
if ($visitorName === '') {
    $errors[] = 'Name is required.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'A valid email is required.';
}
if ($phone === '') {
    $errors[] = 'Phone is required.';
}
if ($message === '') {
    $errors[] = 'Message is required.';
}

if ($errors) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

try {
    $stmt = $pdo->prepare(
        'INSERT INTO bookings (visitor_name, email, phone, notes, status) VALUES (?, ?, ?, ?, "new")'
    );
    $stmt->execute([$visitorName, $email, $phone, $message]);

    echo json_encode(['success' => true, 'message' => 'Your visit request has been received.']);
