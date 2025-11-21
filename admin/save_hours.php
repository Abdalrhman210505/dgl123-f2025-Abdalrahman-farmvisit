<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
require_once("../config/db.php");

// Getting all submitted form data
$open_times  = $_POST["open_time"];
$close_times = $_POST["close_time"];
$notes       = $_POST["notes"];
$is_closed   = $_POST["is_closed"] ?? []; // Checkbox array

// Loop through all 7 days (0 to 6)
for ($day = 0; $day <= 6; $day++) {

    $open  = $open_times[$day] ?? null;
    $close = $close_times[$day] ?? null;
    $note  = $notes[$day] ?? "";

    // Checkbox: if not checked → treat as 0
    $closed = isset($is_closed[$day]) ? 1 : 0;

    // Update query
    $stmt = $pdo -> prepare("
        UPDATE farm_hours
        SET open_time = ?, close_time = ?, notes = ?, is_closed = ?
        WHERE day_of_week = ?
    ");

    $stmt -> execute([$open, $close, $note, $closed, $day]);
}

// Redirect back
header("Location: hours.php");
exit;
