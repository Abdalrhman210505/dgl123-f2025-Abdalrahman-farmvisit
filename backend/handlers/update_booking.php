<?php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/repositories.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /backend/admin/bookings.php');
    exit;
}

if (!verify_csrf($_POST['_csrf'] ?? null)) {
    $_SESSION['flash_error'] = 'Invalid request token.';
    header('Location: /backend/admin/bookings.php');
    exit;
}

$bookingId = (int)($_POST['booking_id'] ?? 0);
$action = $_POST['action'] ?? 'update';

if ($bookingId <= 0) {
    $_SESSION['flash_error'] = 'Invalid booking selected.';
    header('Location: /backend/admin/bookings.php');
    exit;
}

if ($action === 'delete') {
    deleteBooking($bookingId);
    $_SESSION['flash_success'] = 'Booking removed.';
} else {
    $status = $_POST['status'] ?? 'new';
    if (!in_array($status, ['new', 'confirmed', 'cancelled'], true)) {
        $status = 'new';
    }
    updateBookingStatus($bookingId, $status);
    $_SESSION['flash_success'] = 'Booking updated.';
}

header('Location: /backend/admin/bookings.php');
exit;
