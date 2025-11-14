<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
require_once("../config/db.php");


$stmt = $pdo->query(SELECT * FROM bookings ORDER BY created_at DESC);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
