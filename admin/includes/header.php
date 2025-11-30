<?php
/**
 * Shared admin header markup including authentication enforcement and
 * flash message rendering for consistent feedback styling.
 */

$requireAuth = $requireAuth ?? true;
require_once __DIR__ . '/admin_bootstrap.php';

if ($requireAuth) {
    require_admin_auth();
}

$flashMessages = consume_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Admin' ?></title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<main>
    <?php if (!empty($flashMessages)): ?>
        <?php foreach ($flashMessages as $type => $messages): ?>
            <?php foreach ($messages as $message): ?>
                <div class="banner banner-<?= htmlspecialchars($type) ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endif; ?>
