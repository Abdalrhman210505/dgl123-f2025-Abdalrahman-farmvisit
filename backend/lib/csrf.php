<?php
function csrf_token(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

function csrf_field(): string
{
    $token = csrf_token();
    return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($token, ENT_QUOTES) . '">';
}

function verify_csrf(?string $token): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['_csrf_token']) || !is_string($token)) {
        return false;
    }
    return hash_equals($_SESSION['_csrf_token'], $token);
}
