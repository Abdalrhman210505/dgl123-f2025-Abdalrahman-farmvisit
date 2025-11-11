<?php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/repositories.php';
require_once __DIR__ . '/../lib/validators.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /backend/admin/hours.php');
    exit;
}

if (!verify_csrf($_POST['_csrf'] ?? null)) {
    $_SESSION['flash_error'] = 'Invalid request token.';
    header('Location: /backend/admin/hours.php');
    exit;
}

$rows = [];
foreach ($_POST['hours'] ?? [] as $day => $data) {
    $dayIndex = (int)$day;
    $open = $data['open_time'] ?? null;
    $close = $data['close_time'] ?? null;
    $isClosed = isset($data['is_closed']) ? 1 : 0;
    $notes = trim($data['notes'] ?? '');

    if ($open && !is_time($open)) {
        $_SESSION['flash_error'] = 'Invalid open time for day ' . $dayIndex;
        header('Location: /backend/admin/hours.php');
        exit;
    }
    if ($close && !is_time($close)) {
        $_SESSION['flash_error'] = 'Invalid close time for day ' . $dayIndex;
        header('Location: /backend/admin/hours.php');
        exit;
    }

    $rows[] = [
        'day_of_week' => $dayIndex,
        'open_time' => $open ?: null,
        'close_time' => $close ?: null,
        'is_closed' => $isClosed,
        'notes' => $notes,
    ];
}

saveHours($rows);
$_SESSION['flash_success'] = 'Hours saved.';
header('Location: /backend/admin/hours.php');
exit;
