<?php
session_start();
require_once("../config/db.php");

// For showing errors
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") { // checks if the user clicked on the button
    $username = trim($_POST["username"]); //trim for the accidental spaces before or after in the username field
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password_hash"])) { // checks if the username and passowrd hash translated encrypt again and verify 
        session_regenerate_id(true);
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["username"] = $user["username"];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
