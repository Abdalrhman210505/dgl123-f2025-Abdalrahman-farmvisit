<?php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/repositories.php';
require_once __DIR__ . '/../lib/validators.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /backend/admin/gallery.php');
    exit;
}

if (!verify_csrf($_POST['_csrf'] ?? null)) {
    $_SESSION['flash_error'] = 'Invalid request token.';
    header('Location: /backend/admin/gallery.php');
    exit;
}

$uploadDir = dirname(__DIR__, 2) . '/uploads/gallery';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

$action = $_POST['action'] ?? 'save';

if ($action === 'delete') {
    $image = deleteImage((int)($_POST['image_id'] ?? 0));
    if ($image && !empty($image['filename'])) {
        $path = $uploadDir . '/' . $image['filename'];
        if (is_file($path)) {
            unlink($path);
        }
    }
    $_SESSION['flash_success'] = 'Image deleted.';
    header('Location: /backend/admin/gallery.php');
    exit;
}

if (!empty($_POST['image_id'])) {
    $caption = trim($_POST['caption'] ?? '');
    $isPublic = isset($_POST['is_public']) ? 1 : 0;
    updateImage((int)$_POST['image_id'], $caption, $isPublic);
    $_SESSION['flash_success'] = 'Image updated.';
    header('Location: /backend/admin/gallery.php');
    exit;
}

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['flash_error'] = 'Please choose an image to upload.';
    header('Location: /backend/admin/gallery.php');
    exit;
}

$file = $_FILES['image'];
$allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
if (!array_key_exists($file['type'], $allowed)) {
    $_SESSION['flash_error'] = 'Unsupported file type.';
    header('Location: /backend/admin/gallery.php');
    exit;
}
if ($file['size'] > 4 * 1024 * 1024) {
    $_SESSION['flash_error'] = 'File too large (max 4MB).';
    header('Location: /backend/admin/gallery.php');
    exit;
}

$extension = $allowed[$file['type']];
$base = safe_filename(pathinfo($file['name'], PATHINFO_FILENAME)) ?? bin2hex(random_bytes(8));
$filename = $base . '-' . time() . '.' . $extension;
$destination = $uploadDir . '/' . $filename;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    $_SESSION['flash_error'] = 'Failed to store uploaded file.';
    header('Location: /backend/admin/gallery.php');
    exit;
}

$caption = trim($_POST['caption'] ?? '');
$isPublic = isset($_POST['is_public']) ? 1 : 0;
$user = currentUser();
$uploadedBy = $user['user_id'] ?? null;

createImage([
    'filename' => $filename,
    'caption' => $caption,
    'is_public' => $isPublic,
    'uploaded_by' => $uploadedBy,
]);

$_SESSION['flash_success'] = 'Image uploaded successfully.';
header('Location: /backend/admin/gallery.php');
exit;
