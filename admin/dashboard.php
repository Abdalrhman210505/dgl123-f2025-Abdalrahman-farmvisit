<?php
/**
 * Landing page for admin users linking to key management sections.
 */

$pageTitle = 'Admin Dashboard';
require_once __DIR__ . '/includes/header.php';
?>
<h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>

<ul>
    <li><a href="bookings.php">Manage Bookings</a></li>
    <li><a href="gallery.php">Manage Gallery</a></li>
    <li><a href="hours.php">Manage Farm Hours</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
