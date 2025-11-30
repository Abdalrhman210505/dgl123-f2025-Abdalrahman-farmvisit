<?php
/**
 * Updates an existing gallery image caption.
 */

$pageTitle = 'Edit Caption';
require_once __DIR__ . '/includes/header.php';

$id = get_param('id');

if (!$id) {
    header('Location: gallery.php');
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT * FROM gallery_images WHERE image_id = ?');
    $stmt->execute([$id]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$image) {
        header('Location: gallery.php');
        exit;
    }
} catch (PDOException $e) {
    set_flash('error', 'Unable to load image: ' . $e->getMessage());
    header('Location: gallery.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caption = post_param('caption');
    try {
        $stmt = $pdo->prepare('UPDATE gallery_images SET caption = ? WHERE image_id = ?');
        if ($stmt->execute([$caption, $id])) {
            set_flash('success', 'Caption updated successfully!');
            header('Location: gallery.php');
            exit;
        }
    } catch (PDOException $e) {
        $message = 'Unable to update caption: ' . $e->getMessage();
    }
}
?>
<h1>Edit Image Caption</h1>

<?php if ($message): ?>
    <div class="banner banner-error"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<img src="../uploads/<?= sanitize_text($image['file_name']) ?>" width="200" alt="Selected image"><br><br>

<form method="POST">
    <label>Caption</label><br>
    <input type="text" name="caption" value="<?= sanitize_text($image['caption']) ?>" required><br><br>

    <button type="submit">Save Changes</button>
</form>

<p><a href="gallery.php">⬅ Back to Gallery</a></p>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
