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

$hours = getHours();
$hoursByDay = [];
foreach ($hours as $row) {
    $hoursByDay[(int)$row['day_of_week']] = $row;
}
$days = [
    0 => 'Sunday',
    1 => 'Monday',
    2 => 'Tuesday',
    3 => 'Wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farm Hours</title>
    <link rel="stylesheet" href="/frontend/style.css">
</head>
<body>
<header class="admin-header">
    <h1>Farm Hours</h1>
    <nav>
        <a href="/backend/admin/dashboard.php">Dashboard</a>
        <a href="/backend/admin/bookings.php">Bookings</a>
        <a href="/backend/admin/gallery.php">Gallery</a>
        <a href="/backend/admin/hours.php">Hours</a>
        <a href="/backend/auth/logout.php">Logout</a>
    </nav>
</header>
<main class="hours-admin">
    <?php if ($flashSuccess): ?>
        <div class="alert success"><?= htmlspecialchars($flashSuccess) ?></div>
    <?php endif; ?>
    <?php if ($flashError): ?>
        <div class="alert error"><?= htmlspecialchars($flashError) ?></div>
    <?php endif; ?>
    <form method="post" action="/backend/handlers/save_hours.php">
        <?= csrf_field() ?>
        <table>
            <thead>
            <tr>
                <th>Day</th>
                <th>Open</th>
                <th>Close</th>
                <th>Closed?</th>
                <th>Notes</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($days as $index => $label): $row = $hoursByDay[$index] ?? null; ?>
                <tr>
                    <td><?= $label ?></td>
                    <td><input type="time" name="hours[<?= $index ?>][open_time]" value="<?= htmlspecialchars($row['open_time'] ?? '') ?>"></td>
                    <td><input type="time" name="hours[<?= $index ?>][close_time]" value="<?= htmlspecialchars($row['close_time'] ?? '') ?>"></td>
                    <td><input type="checkbox" name="hours[<?= $index ?>][is_closed]" value="1" <?= !empty($row) && (int)$row['is_closed'] === 1 ? 'checked' : '' ?>></td>
                    <td><input type="text" name="hours[<?= $index ?>][notes]" value="<?= htmlspecialchars($row['notes'] ?? '') ?>"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit">Save Hours</button>
    </form>
</main>
</body>
</html>
