<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
require_once("../config/db.php");

// fethcing farm hours
$stmt = $pdo -> query("SELECT * FROM farm_hours ORDER BY day_of_week ASC");
$hours = $stmt -> fetchAll(PDO::FETCH_ASSOC);
// label
$days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main>
        
    </main>
</body>
</html>