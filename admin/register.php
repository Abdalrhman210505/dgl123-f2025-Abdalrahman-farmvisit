<?php
session_start();
require_once("../config/db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]); // trim is to remove unwanted spaces or weird symbols
    $email    = trim($_POST["email"]);
    $fullName = trim($_POST["full_name"]);
    $password = $_POST["password"];
    $confirm  = $_POST["confirm_password"];

    // Making sure that there is no empty fields
    if ($username === "" || $email === "" || $password === "") {
        $message = "All fields are required.";
    }
    // Check password match
    elseif ($password !== $confirm) {
        $message = "Passwords do not match.";
    } 
    else {

        // Check if username exists
        $stmt = $pdo -> prepare("SELECT * FROM users WHERE username = ?");
        $stmt -> execute([$username]);

        if ($stmt -> rowCount() > 0) {
            $message = "Username already taken.";
        } else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <main>
    </main>
</body>
</html>