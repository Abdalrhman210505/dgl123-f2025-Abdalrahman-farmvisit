<?php
/**
 * Lists gallery images for admin management with edit/delete actions.
 */

$pageTitle = 'Manage Gallery';
require_once __DIR__ . '/includes/header.php';

$images = [];
try {
    $stmt = $pdo->query('SELECT * FROM gallery_images ORDER BY uploaded_at DESC');
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    set_flash('error', 'Unable to load gallery: ' . $e->getMessage());
}
?>
<h1>Manage Gallery</h1>
<p><a href="upload_gallery.php"> + Upload New Image</a></p>

<table>
    <tr>
        <th>Image</th>
        <th>Caption</th>
        <th>Uploaded At</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($images as $image): ?>
        <tr>
            <td><img src="../uploads/<?= sanitize_text($image['file_name']) ?>" width="120" alt="Gallery image"></td>
            <td><?= sanitize_text($image['caption']) ?></td>
            <td><?= $image['uploaded_at'] ?></td>
            <td>
                <a href="update_gallery.php?id=<?= $image['image_id'] ?>">Edit</a> |
                <a href="delete_gallery.php?id=<?= $image['image_id'] ?>" onclick="return confirm('Are you sure you want to delete this image?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="dashboard.php"> <- Back to Dashboard</a></p>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
