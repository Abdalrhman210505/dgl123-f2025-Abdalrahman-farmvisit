<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once("../config/db.php");

// Get booking id + status
$id = isset($_GET["id"]) ? (int) $_GET["id"] : null;
$status = $_GET["status"] ?? null;

$allowedStatuses = ["new", "confirmed", "cancelled"];

if (!$id || !$status || !in_array($status, $allowedStatuses, true)) {
    header("Location: bookings.php");
    exit;
}

// Update booking
$stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
$stmt->execute([$status, $id]);

header("Location: bookings.php");
exit;
