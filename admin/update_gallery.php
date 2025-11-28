<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once("../config/db.php");

$id = $_GET["id"] ?? null;

// No ID? Go back
if (!$id) {
    header("Location: gallery.php");
    exit;
}

// Fetch image
$stmt = $pdo->prepare("SELECT * FROM gallery_images WHERE image_id = ?");
$stmt->execute([$id]);
$image = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$image) {
    header("Location: gallery.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $caption = trim($_POST["caption"]);

    $stmt = $pdo->prepare("
        UPDATE gallery_images 
        SET caption = ? 
        WHERE image_id = ?
    ");

    $stmt->execute([$caption, $id]);

    $message = "Caption updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Caption</title>
    <link rel="stylesheet" href="../assets/css/admin.css">

</head>
<body>

<main>
<h1>Edit Image Caption</h1>

<?php if ($message): ?>
    <p style="color:green;"><?= $message ?></p>
<?php endif; ?>

<img src="../uploads/<?= htmlspecialchars($image['file_name']) ?>" width="200"><br><br>

<form method="POST">
    <label>Caption</label><br>
    <input type="text" name="caption" value="<?= htmlspecialchars($image['caption']) ?>" required><br><br>

    <button type="submit">Save Changes</button>
</form>

<p><a href="gallery.php">⬅ Back to Gallery</a></p>
</main>

</body>
</html>
