<?php
/**
 * Handles uploading new gallery images with basic validation.
 */

$pageTitle = 'Upload Image';
require_once __DIR__ . '/includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caption = post_param('caption');

    if (!empty($_FILES['image']['name'])) {
        $allowedExt = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $maxSize = 2 * 1024 * 1024;
        $tmp = $_FILES['image']['tmp_name'];

        if (!in_array($ext, $allowedExt, true)) {
            $message = 'Only JPG or PNG images allowed.';
        } elseif (!getimagesize($tmp)) {
            $message = 'Invalid image file.';
        } elseif ($_FILES['image']['size'] > $maxSize) {
            $message = 'Image must be less than 2MB.';
        } else {
            $fileName = time() . '_' . uniqid() . '.' . $ext;
            $targetPath = '../uploads/' . $fileName;

            if (move_uploaded_file($tmp, $targetPath)) {
                try {
                    $stmt = $pdo->prepare(
                        'INSERT INTO gallery_images (file_name, caption, uploaded_by) VALUES (?, ?, ?)'
                    );
                    if ($stmt->execute([$fileName, $caption, $_SESSION['user_id']])) {
                        set_flash('success', 'Image uploaded successfully!');
                        header('Location: gallery.php');
                        exit;
                    }
                } catch (PDOException $e) {
                    $message = 'Database error: ' . $e->getMessage();
                }
            } else {
                $message = 'Upload failed.';
            }
        }
    } else {
        $message = 'Please select an image.';
    }
}
?>
<h1>Upload New Image</h1>

<?php if ($message): ?>
    <div class="banner banner-error"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Select Image:</label><br>
    <input type="file" name="image" required><br><br>

    <label>Caption:</label><br>
    <input type="text" name="caption"><br><br>

    <button type="submit">Upload</button>
</form>

<p><a href="gallery.php">⬅ Back to Gallery</a></p>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
