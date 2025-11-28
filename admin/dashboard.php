<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
   <link rel="stylesheet" href="../assets/css/admin.css">

</head>
<body>
    <main>

<h1>Welcome, <?= $_SESSION["username"] ?></h1>

<ul>
    <li><a href="bookings.php">Manage Bookings</a></li>
    <li><a href="gallery.php">Manage Gallery</a></li>
    <li><a href="hours.php">Manage Farm Hours</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
</main>
</body>
</html>
