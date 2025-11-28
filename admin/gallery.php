<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
require_once("../config/db.php");


//getting all the images
$stmt = $pdo -> query("SELECT * FROM gallery_images ORDER BY uploaded_at DESC");
$images = $stmt -> fetchAll(PDO:: FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery</title>
    <link rel="stylesheet" href="../assets/css/admin.css">

</head>
<body>
    <main>
<h1>Manage Gallery!</h1>
<p>
    <a href="upload_gallery.php"> + Upload New Image</a>
</p>

<table>
    <tr>
        <th>Image</th>
        <th>Caption</th>
        <th>Uploaded At</th>
        <th>Actions</th> <!-- NEW -->
    </tr>

    <?php foreach ($images as $img): ?>
    <tr>
        <td>
            <img src="../uploads/<?= htmlspecialchars($img['file_name']) ?>" width="120">
        </td>

        <td><?= htmlspecialchars($img['caption']) ?></td>

        <td><?= $img['uploaded_at'] ?></td>

        <td>
            <a href="update_gallery.php?id=<?= $img['image_id'] ?>">Edit</a>
            |
            <a href="delete_gallery.php?id=<?= $img['image_id'] ?>"
               onclick="return confirm('Are you sure you want to delete this image?');">
               Delete
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<p><a href="dashboard.php"> <- Back to Dashboard</a></p>

    </main>
    
</body>
</html>
