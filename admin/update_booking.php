<?php
/**
 * Updates the status of a booking record and returns to the bookings list.
 */

$pageTitle = 'Update Booking';
require_once __DIR__ . '/includes/header.php';

$id = get_param('id');
$status = get_param('status');

if ($id && $status) {
    try {
        $stmt = $pdo->prepare('UPDATE bookings SET status = ? WHERE booking_id = ?');
        if ($stmt->execute([$status, $id])) {
            set_flash('success', 'Booking updated successfully.');
        }
    } catch (PDOException $e) {
        set_flash('error', 'Unable to update booking: ' . $e->getMessage());
    }
}

header('Location: bookings.php');
exit;
