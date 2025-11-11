<?php
require_once __DIR__ . '/../lib/auth.php';

ensure_session();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['_csrf'] ?? null)) {
        $errors['csrf'] = 'Invalid CSRF token.';
    } else {
        $result = register_user($_POST);
        if (!empty($result['errors'])) {
            $errors = array_merge($errors, $result['errors']);
        } else {
            $success = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Farm Visit Admin</title>
    <link rel="stylesheet" href="/frontend/style.css">
</head>
<body>
    <main class="auth-container">
        <h1>Create Admin Account</h1>
        <?php if ($success): ?>
            <div class="alert success">Registration successful. <a href="/backend/auth/login.php">Login here</a>.</div>
        <?php endif; ?>
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
            <label>Name
                <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            </label>
            <label>Email
                <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </label>
            <label>Username
                <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </label>
            <label>Password
                <input type="password" name="password" required>
            </label>
            <label>Confirm Password
                <input type="password" name="confirm_password" required>
            </label>
            <button type="submit">Register</button>
        </form>
        <p>Already registered? <a href="/backend/auth/login.php">Login</a></p>
    </main>
</body>
</html>
