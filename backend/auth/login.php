<?php
require_once __DIR__ . '/../lib/auth.php';

ensure_session();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['_csrf'] ?? null)) {
        $errors['csrf'] = 'Invalid CSRF token.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        if (!login_user($username, $password)) {
            $errors['login'] = 'Invalid credentials provided.';
        } else {
            header('Location: /backend/admin/dashboard.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Farm Visit Admin</title>
    <link rel="stylesheet" href="/frontend/style.css">
</head>
<body>
    <main class="auth-container">
        <h1>Admin Login</h1>
        <?php if ($errors): ?>
            <div class="alert error">
                <ul>
                    <?php foreach ($errors as $message): ?>
                        <li><?= htmlspecialchars($message) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <?= csrf_field() ?>
            <label>Username
                <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </label>
            <label>Password
                <input type="password" name="password" required>
            </label>
            <button type="submit">Login</button>
        </form>
        <p>No account? <a href="/backend/auth/register.php">Register</a></p>
    </main>
</body>
</html>
