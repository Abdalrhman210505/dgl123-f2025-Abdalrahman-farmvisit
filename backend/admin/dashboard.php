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

$pdo = getPDO();
$pending = $pdo->query("SELECT COUNT(*) AS total FROM bookings WHERE status = 'new'")->fetch()['total'] ?? 0;
$images = $pdo->query('SELECT COUNT(*) AS total FROM gallery_images')->fetch()['total'] ?? 0;
$todayIndex = (int)date('w');
$stmt = $pdo->prepare('SELECT * FROM farm_hours WHERE day_of_week = :day');
$stmt->execute(['day' => $todayIndex]);
$todayHours = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/frontend/style.css">
</head>
<body>
    <header class="admin-header">
        <h1>Farm Visit Admin Dashboard</h1>
        <nav>
            <a href="/backend/admin/dashboard.php">Dashboard</a>
            <a href="/backend/admin/bookings.php">Bookings</a>
            <a href="/backend/admin/gallery.php">Gallery</a>
            <a href="/backend/admin/hours.php">Hours</a>
            <a href="/backend/auth/logout.php">Logout</a>
        </nav>
    </header>
    <main class="dashboard">
        <?php if ($flashSuccess): ?>
            <div class="alert success"><?= htmlspecialchars($flashSuccess) ?></div>
        <?php endif; ?>
        <?php if ($flashError): ?>
            <div class="alert error"><?= htmlspecialchars($flashError) ?></div>
        <?php endif; ?>
        <section class="card">
            <h2>Pending Bookings</h2>
            <p><?= (int)$pending ?></p>
        </section>
        <section class="card">
            <h2>Total Gallery Images</h2>
            <p><?= (int)$images ?></p>
        </section>
        <section class="card">
            <h2>Today's Status</h2>
            <?php if ($todayHours && (int)$todayHours['is_closed'] === 0): ?>
                <p>Open from <?= htmlspecialchars($todayHours['open_time']) ?> to <?= htmlspecialchars($todayHours['close_time']) ?></p>
                <?php if ($todayHours['notes']): ?><p><?= htmlspecialchars($todayHours['notes']) ?></p><?php endif; ?>
            <?php else: ?>
                <p>Closed today.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
