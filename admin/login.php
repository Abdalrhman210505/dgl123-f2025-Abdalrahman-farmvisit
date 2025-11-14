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
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>

<h2>Admin Login</h2>

<?php if ($error): ?>
<p style="color:red;"><?= $error ?></p>  <!-- if there is an error the error text color will be red -->
<?php endif; ?>

<form method="POST"> <!--  this firm is the login the user has to submit-->
    <label>Username</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>
