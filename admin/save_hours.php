<?php
/**
 * Persists updated farm hours submitted from the admin form.
 */

$pageTitle = 'Save Hours';
require_once __DIR__ . '/includes/header.php';

$openTimes = $_POST['open_time'] ?? [];
$closeTimes = $_POST['close_time'] ?? [];
$notes = $_POST['notes'] ?? [];
$isClosed = $_POST['is_closed'] ?? [];

for ($day = 0; $day <= 6; $day++) {
    $open = $openTimes[$day] ?? null;
    $close = $closeTimes[$day] ?? null;
    $note = sanitize_text($notes[$day] ?? '');
    $closed = isset($isClosed[$day]) ? 1 : 0;

    try {
        $stmt = $pdo->prepare(
            'UPDATE farm_hours SET open_time = ?, close_time = ?, notes = ?, is_closed = ? WHERE day_of_week = ?'
        );
        $stmt->execute([$open, $close, $note, $closed, $day]);
    } catch (PDOException $e) {
        set_flash('error', 'Unable to save hours: ' . $e->getMessage());
    }
}

set_flash('success', 'Hours updated successfully.');
header('Location: hours.php');
exit;
