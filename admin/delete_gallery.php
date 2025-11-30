<?php
/**
 * Deletes a gallery image record and removes the uploaded file.
 */

$pageTitle = 'Delete Gallery Image';
require_once __DIR__ . '/includes/header.php';

$id = get_param('id');

if ($id) {
    try {
        $stmt = $pdo->prepare('SELECT file_name FROM gallery_images WHERE image_id = ?');
        $stmt->execute([$id]);
        $image = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($image) {
            $filePath = '../uploads/' . $image['file_name'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $delete = $pdo->prepare('DELETE FROM gallery_images WHERE image_id = ?');
            if ($delete->execute([$id])) {
                set_flash('success', 'Image deleted successfully.');
            }
        }
    } catch (PDOException $e) {
        set_flash('error', 'Unable to delete image: ' . $e->getMessage());
    }
}

header('Location: gallery.php');
exit;
