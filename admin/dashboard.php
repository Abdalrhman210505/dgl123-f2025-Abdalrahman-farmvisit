<?php
/**
 * Admin Dashboard
 * 
 * Purpose:
 * Displays admin navigation and greets the logged-in user.
 * Accessible only after successful login.
 * 
 * Refactor Changes:
 * - Improved readability and formatting.
 * - Added documentation block.
 * - Added security best practices.
 */

session_start();

// Redirect if user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// OPTIONAL: Improve session security
session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <!-- Admin Panel Stylesheet -->
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>
    <main class="dashboard-container">

        <!-- Greeting -->
        <h1 class="dashboard-title">
            Welcome, <?= htmlspecialchars($_SESSION["username"]); ?>
        </h1>

        <!-- Admin Navigation -->
        <ul class="admin-nav">
            <li><a href="bookings.php">Manage Bookings</a></li>
            <li><a href="gallery.php">Manage Gallery</a></li>
            <li><a href="hours.php">Manage Farm Hours</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

    </main>
</body>
</html>
