<?php
/**
 * Admin bootstrap utilities for initializing sessions, database access,
 * input sanitization, authentication enforcement, and flash messaging.
 * This file centralizes shared logic to keep individual admin pages tidy
 * without altering existing behavior.
 */

require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Trim and escape a string value for safe output.
 */
function sanitize_text(?string $value): string
{
    return htmlspecialchars(trim((string) $value), ENT_QUOTES, 'UTF-8');
}

/**
 * Require an authenticated admin session or redirect to login.
 */
function require_admin_auth(): void
{
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Set a flash message to be rendered on the next request.
 */
function set_flash(string $type, string $message): void
{
    $_SESSION['flash'][$type][] = $message;
}

/**
 * Retrieve and clear flash messages.
 */
function consume_flash(): array
{
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

/**
 * Safely fetch a GET parameter.
 */
function get_param(string $key, $default = null)
{
    return isset($_GET[$key]) ? sanitize_text($_GET[$key]) : $default;
}

/**
 * Safely fetch a POST parameter.
 */
function post_param(string $key, $default = null)
{
    return isset($_POST[$key]) ? sanitize_text($_POST[$key]) : $default;
}

/**
 * Wrap a PDO operation to surface errors without breaking control flow.
 */
function pdo_safe_execute(PDOStatement $statement, array $params = []): bool
{
    try {
        return $statement->execute($params);
    } catch (PDOException $e) {
        set_flash('error', 'Database error: ' . $e->getMessage());
        return false;
    }
}
