<?php
/**
 * Displays booking requests for admins to review and update.
 */

$pageTitle = 'Manage Bookings';
require_once __DIR__ . '/includes/header.php';

$bookings = [];
try {
    $stmt = $pdo->query('SELECT * FROM bookings ORDER BY created_at DESC');
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    set_flash('error', 'Unable to load bookings: ' . $e->getMessage());
}
?>
<h1>Manage Bookings</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Visitor Name</th>
        <th>Email</th>
        <th>Date</th>
        <th>Time</th>
        <th>Party Size</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($bookings as $booking): ?>
        <tr>
            <td><?= $booking['booking_id'] ?></td>
            <td><?= sanitize_text($booking['visitor_name']) ?></td>
            <td><?= sanitize_text($booking['email']) ?></td>
            <td><?= $booking['visit_date'] ?></td>
            <td><?= $booking['visit_time'] ?></td>
            <td><?= $booking['party_size'] ?></td>
            <td><?= $booking['status'] ?></td>
            <td>
                <a href="update_booking.php?id=<?= $booking['booking_id'] ?>&status=confirmed">Confirm</a> |
                <a href="update_booking.php?id=<?= $booking['booking_id'] ?>&status=cancelled">Cancel</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="dashboard.php">⬅ Back to Dashboard</a></p>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
