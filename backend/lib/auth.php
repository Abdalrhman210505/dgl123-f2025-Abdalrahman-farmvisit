<?php
require_once __DIR__ . '/repositories.php';
require_once __DIR__ . '/validators.php';
require_once __DIR__ . '/csrf.php';

function ensure_session(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function currentUser(): ?array
{
    ensure_session();
    if (!empty($_SESSION['user'])) {
        return $_SESSION['user'];
    }
    return null;
}

function requireLogin(): void
{
    ensure_session();
    if (empty($_SESSION['user'])) {
        header('Location: /backend/auth/login.php');
        exit;
    }
}

function register_user(array $data): array
{
    $errors = [];

    if (!not_empty($data['name'] ?? '')) {
        $errors['name'] = 'Name is required';
    }
    if (!is_email($data['email'] ?? '')) {
        $errors['email'] = 'Valid email required';
    }
    if (!len_between($data['username'] ?? '', 3, 50)) {
        $errors['username'] = 'Username must be between 3 and 50 characters';
    }
    if (!len_between($data['password'] ?? '', 8, 100)) {
        $errors['password'] = 'Password must be at least 8 characters';
    }
    if (($data['password'] ?? '') !== ($data['confirm_password'] ?? '')) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    if (findUserByUsername($data['username'] ?? '')) {
        $errors['username'] = 'Username already taken';
    }

    if ($errors) {
        return ['errors' => $errors];
    }

    $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

    $userId = createUser([
        'name' => $data['name'],
        'email' => $data['email'],
        'username' => $data['username'],
        'password_hash' => $passwordHash,
        'role' => 'admin',
    ]);

    return ['user_id' => $userId];
}

function login_user(string $username, string $password): bool
{
    ensure_session();
    $user = findUserByUsername($username);
    if (!$user) {
        return false;
    }
    if (!password_verify($password, $user['password_hash'])) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['user'] = [
        'user_id' => (int)$user['id'],
        'username' => $user['username'],
        'role' => $user['role'],
    ];
    return true;
}

function logout_user(): void
{
    ensure_session();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
