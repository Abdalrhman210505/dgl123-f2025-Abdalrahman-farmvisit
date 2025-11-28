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

            // Hash password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $stmt = $pdo -> prepare("
                INSERT INTO users (username, password_hash, email, full_name, role)
                VALUES (?, ?, ?, ?, 'staff')
            ");
            $stmt -> execute([$username, $passwordHash, $email, $fullName]);

            $message = "Registration successful! You may now log in.";
            header("Location: login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
  <link rel="stylesheet" href="../assets/css/admin.css">

</head>
<body>
    <main>
<?php if ($message): ?>
    <p style="color: red;"><?= $message ?></p>
<?php endif; ?>

<form method="POST">

    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Full Name:</label><br>
    <input type="text" name="full_name"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Register</button>

</form>

<p><a href="login.php"><- Back to Login</a></p>

    </main>
</body>
</html>