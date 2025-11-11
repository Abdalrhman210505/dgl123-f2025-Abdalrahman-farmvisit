<?php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/repositories.php';

requireLogin();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$flashSuccess = $_SESSION['flash_success'] ?? null;
$flashError = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_success'], $_SESSION['flash_error']);

$images = listImages(false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Gallery</title>
    <link rel="stylesheet" href="/frontend/style.css">
</head>
<body>
<header class="admin-header">
    <h1>Gallery</h1>
    <nav>
        <a href="/backend/admin/dashboard.php">Dashboard</a>
        <a href="/backend/admin/bookings.php">Bookings</a>
        <a href="/backend/admin/gallery.php">Gallery</a>
        <a href="/backend/admin/hours.php">Hours</a>
        <a href="/backend/auth/logout.php">Logout</a>
    </nav>
</header>
<main class="gallery-admin">
    <?php if ($flashSuccess): ?>
        <div class="alert success"><?= htmlspecialchars($flashSuccess) ?></div>
    <?php endif; ?>
    <?php if ($flashError): ?>
        <div class="alert error"><?= htmlspecialchars($flashError) ?></div>
    <?php endif; ?>
    <section class="upload">
        <h2>Upload New Image</h2>
        <form method="post" action="/backend/handlers/upload_image.php" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <label>Image File
                <input type="file" name="image" accept="image/*" required>
            </label>
            <label>Caption
                <input type="text" name="caption" maxlength="255">
            </label>
            <label>
                <input type="checkbox" name="is_public" value="1" checked>
                Public
            </label>
            <button type="submit">Upload</button>
        </form>
    </section>
    <section class="list">
        <h2>Existing Images</h2>
        <table>
            <thead>
            <tr>
                <th>Preview</th>
                <th>Caption</th>
                <th>Visibility</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($images as $image): ?>
                <tr>
                    <td><img src="/uploads/gallery/<?= htmlspecialchars($image['filename']) ?>" alt="" width="100"></td>
                    <td><?= htmlspecialchars($image['caption'] ?? '') ?></td>
                    <td><?= (int)$image['is_public'] === 1 ? 'Public' : 'Private' ?></td>
                    <td>
                        <form method="post" action="/backend/handlers/upload_image.php" class="inline-form">
                            <?= csrf_field() ?>
                            <input type="hidden" name="image_id" value="<?= (int)$image['id'] ?>">
                            <input type="text" name="caption" value="<?= htmlspecialchars($image['caption'] ?? '') ?>">
                            <label>
                                <input type="checkbox" name="is_public" value="1" <?= (int)$image['is_public'] === 1 ? 'checked' : '' ?>> Public
                            </label>
                            <button type="submit">Update</button>
                        </form>
                        <form method="post" action="/backend/handlers/upload_image.php" class="inline-form" onsubmit="return confirm('Delete this image?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="image_id" value="<?= (int)$image['id'] ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
</body>
</html>
