<?php
/**
 * Admin registration page allowing staff to create login credentials.
 */

$requireAuth = false;
$pageTitle = 'Admin Registration';
require_once __DIR__ . '/includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = post_param('username');
    $email = post_param('email');
    $fullName = post_param('full_name');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm_password'] ?? '');

    if ($username === '' || $email === '' || $password === '') {
        $message = 'All fields are required.';
    } elseif ($password !== $confirm) {
        $message = 'Passwords do not match.';
    } else {
        try {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
            $stmt->execute([$username]);

            if ($stmt->fetchColumn() > 0) {
                $message = 'Username already taken.';
            } else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $insert = $pdo->prepare(
                    'INSERT INTO users (username, password_hash, email, full_name, role) VALUES (?, ?, ?, ?, "staff")'
                );

                if ($insert->execute([$username, $passwordHash, $email, $fullName])) {
                    set_flash('success', 'Registration successful! You may now log in.');
                    header('Location: login.php');
                    exit;
                }
            }
        } catch (PDOException $e) {
            $message = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<?php if ($message): ?>
    <div class="banner banner-error"><?= htmlspecialchars($message) ?></div>
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

<p><a href="login.php" class="btn-secondary">Back to Login</a></p>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
