<?php
/**
 * Public gallery page showing uploaded farm images.
 */
require_once('../config/db.php');

$stmt = $pdo->query("SELECT * FROM gallery_images ORDER BY uploaded_at DESC");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
  />
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Poppins:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <a href="index.php"><img class="logo" src="images/kehler-logo1.png" alt="kehler logo"></a>
        <nav >
            <a class="toggle" onclick="showNav()"><i class="fa fa-bars" aria-hidden="true"></i></a>
            <ul id="nav-items">
                <li><a href="index.php">Home</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="gallery.php">Gallery</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="gallery-section">
            <h1>Farm Gallery</h1>
            <p>Check out our farm happenings.</p>
            <div class="grid-gallery">
                <?php foreach ($images as $img): ?>
                <div class="gallery-card">
                    <img src="../uploads/<?= htmlspecialchars($img['file_name']) ?>" alt="<?= htmlspecialchars($img['caption']) ?>" loading="lazy">
                    <p><?= htmlspecialchars($img['caption']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <footer>
        <nav>
            <div class="footer-container">
                <img class="logo" src="images/kehler-logo1.png" alt="kehler logo">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                </ul>
                <ul class="end-footer">
                    <li>
                        follow along with the farm and to see whats growing find us on facebook and instagram.
                        <div><a href="https://www.instagram.com/kehlervegetables" target="_blank"><img src="images/instagram.png" alt="instagram logo">@kehlervegetables</a></div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="divider">
            <h4>©2024 - <span>This is fictional website for a college project</span> | All right reserved</h4>
        </div>
    </footer>
    <script src="../assets/js/main.js"></script>
</body>
</html>
