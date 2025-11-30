<?php
/**
 * Admin login page that authenticates staff and starts a secure session.
 */

$requireAuth = false;
$pageTitle = 'Admin Login';
require_once __DIR__ . '/includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = post_param('username');
    $password = trim($_POST['password'] ?? '');

    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            set_flash('success', 'Login successful.');
            header('Location: dashboard.php');
            exit;
        }

        $error = 'Invalid username or password.';
    } catch (PDOException $e) {
        $error = 'Database error: ' . $e->getMessage();
    }
}
?>
<h2>Admin Login</h2>

<?php if ($error): ?>
    <div class="banner banner-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST">
    <label>Username</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
    <br><br>
    <a href="register.php" class="btn-secondary">Create New Account</a>
</form>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
