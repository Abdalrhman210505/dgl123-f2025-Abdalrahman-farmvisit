<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once("../config/db.php");

$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: gallery.php");
    exit;
}

// 1. Get the file name first
$stmt = $pdo->prepare("SELECT file_name FROM gallery_images WHERE image_id = ?");
$stmt->execute([$id]);
$image = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$image) {
    header("Location: gallery.php");
    exit;
}

// 2. Delete the image file from /uploads
$filePath = "../uploads/" . $image["file_name"];

if (file_exists($filePath)) {
    unlink($filePath);
}

// 3. Delete from the database
$stmt = $pdo->prepare("DELETE FROM gallery_images WHERE image_id = ?");
$stmt->execute([$id]);

// 4. Redirect back to gallery
header("Location: gallery.php");
exit;
