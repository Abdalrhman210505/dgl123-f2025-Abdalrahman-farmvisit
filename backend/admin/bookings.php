<?php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/repositories.php';

requireLogin();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$flashSuccess = $_SESSION['flash_success'] ?? null;
$flashError = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_success'], $_SESSION['flash_error']);

$statusFilter = $_GET['status'] ?? null;
$bookings = listBookings($statusFilter ?: null);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="/frontend/style.css">
</head>
<body>
<header class="admin-header">
    <h1>Bookings</h1>
    <nav>
        <a href="/backend/admin/dashboard.php">Dashboard</a>
        <a href="/backend/admin/bookings.php">Bookings</a>
        <a href="/backend/admin/gallery.php">Gallery</a>
        <a href="/backend/admin/hours.php">Hours</a>
        <a href="/backend/auth/logout.php">Logout</a>
    </nav>
</header>
<main class="admin-table">
    <?php if ($flashSuccess): ?>
        <div class="alert success"><?= htmlspecialchars($flashSuccess) ?></div>
    <?php endif; ?>
    <?php if ($flashError): ?>
        <div class="alert error"><?= htmlspecialchars($flashError) ?></div>
    <?php endif; ?>
    <form method="get" class="filter-form">
        <label>Status Filter
            <select name="status" onchange="this.form.submit()">
                <option value="">All</option>
                <?php foreach (['new', 'confirmed', 'cancelled'] as $status): ?>
                    <option value="<?= $status ?>" <?= $statusFilter === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </form>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Visit Date</th>
                <th>Guests</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($bookings as $booking): ?>
            <tr>
                <td><?= htmlspecialchars($booking['name']) ?></td>
                <td><?= htmlspecialchars($booking['email']) ?></td>
                <td><?= htmlspecialchars($booking['visit_date'] ?? '') ?></td>
                <td><?= htmlspecialchars($booking['guests'] ?? '') ?></td>
                <td><?= htmlspecialchars($booking['status']) ?></td>
                <td>
                    <form method="post" action="/backend/handlers/update_booking.php" class="inline-form">
                        <?= csrf_field() ?>
                        <input type="hidden" name="booking_id" value="<?= (int)$booking['id'] ?>">
                        <select name="status">
                            <?php foreach (['new', 'confirmed', 'cancelled'] as $status): ?>
                                <option value="<?= $status ?>" <?= $booking['status'] === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                    <form method="post" action="/backend/handlers/update_booking.php" class="inline-form" onsubmit="return confirm('Delete this booking?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="booking_id" value="<?= (int)$booking['id'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>
