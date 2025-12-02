<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once("../config/db.php");

$message = "";

// When form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $caption = trim($_POST["caption"]);

    if (!empty($_FILES["image"]["name"])) {

        // Allow more formats
        $allowedExt = ["jpg", "jpeg", "png", "webp"];
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

        // Raise max upload size (25MB)
        $maxSize = 25 * 1024 * 1024;

        // Validate real image
        $tmp = $_FILES["image"]["tmp_name"];

        if (!in_array($ext, $allowedExt)) {
            $message = "Only JPG, PNG, or WEBP images allowed.";
        }
        elseif (!getimagesize($tmp)) {
            $message = "Invalid image file (not a real image).";
        }
        elseif ($_FILES["image"]["size"] > $maxSize) {
            $message = "Image is too large (max 25MB).";
        }
        else {

            // Safe unique file name
            $fileName = time() . "_" . uniqid() . "." . $ext;
            $targetPath = "../uploads/" . $fileName;

            if (move_uploaded_file($tmp, $targetPath)) {

                // Insert into DB
                $stmt = $pdo->prepare("
                    INSERT INTO gallery_images (file_name, caption, uploaded_by)
                    VALUES (?, ?, ?)
                ");

                $stmt->execute([$fileName, $caption, $_SESSION["user_id"]]);

                $message = "Image uploaded successfully!";
            } else {
                $message = "Upload failed.";
            }
        }

    } else {
        $message = "Please select an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Image</title>
    <link rel="stylesheet" href="../assets/css/admin.css">

</head>
<body>

<main>
<h1>Upload New Image</h1>

<?php if ($message): ?>
<p style="color:green;"><?= $message ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <label>Select Image:</label><br>
    <input type="file" name="image" required><br><br>

    <label>Caption:</label><br>
    <input type="text" name="caption"><br><br>

    <button type="submit">Upload</button>
</form>

<p><a href="gallery.php">⬅ Back to Gallery</a></p>
</main>

</body>
</html>
