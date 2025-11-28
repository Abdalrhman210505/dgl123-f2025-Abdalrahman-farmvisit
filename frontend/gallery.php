<?php
require_once('../config/db.php');


// Fetch images from database
$stmt = $pdo->query("SELECT * FROM gallery_images ORDER BY id DESC");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gallery</title>

       <link rel="stylesheet" href="../assets/css/style.css">


        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Poppins:wght@400;700&display=swap" rel="stylesheet">

        <!--the ham bar function -->
        <script>
        function showNav() {
            var element = document.getElementById("nav-items");
            element.classList.toggle("show-items");
        }
        </script>

        <style>
            /* Ensure gallery is grid responsive like the original */
            .gallery-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
                padding: 1rem;
            }

            .gallery-grid img {
                width: 100%;
                height: 250px;
                object-fit: cover;
                border-radius: 8px;
                cursor: pointer;
            }
        </style>
    </head>

<body>

<header>
    <a href="index.php"><img class="logo" src="images/kehler-logo1.png" alt="kehler logo"></a>

    <nav>
      <a class="toggle" onclick="showNav()">
        <i class="fa fa-bars" aria-hidden="true"></i>
      </a>
      
      <ul id="nav-items">
          <li><a href="index.php">Home</a></li>
          <li><a href="contact.php">Contact Us</a></li>
          <li><a href="gallery.php">Gallery</a></li>
      </ul>
    </nav>
</header>

<main>
    <section class="hero-section">
        <h1>Here are some images of the farm</h1>
    </section>

    <!-- Gallery Grid -->
    <div class="gallery-grid">

        <?php if (count($images) > 0): ?>
            <?php foreach ($images as $i): ?>
                <img 
                    src="uploads/<?= htmlspecialchars($i['file_name']) ?>" 
                    alt="<?= htmlspecialchars($i['caption']) ?>"
                    class="gallery-img"
                >
            <?php endforeach; ?>

        <?php else: ?>
            <p style="padding:20px;">No images found in the gallery.</p>
        <?php endif; ?>

    </div>

    <!-- Modal -->
    <div class="modal" id="imageModal">
        <button class="nav-button left" id="prevButton">❮</button>

        <div class="modal-content">
            <img id="modalImage" src="" alt="">
            <div class="caption" id="modalCaption"></div>
        </div>

        <button class="nav-button right" id="nextButton">❯</button>
    </div>

</main>

<footer>
    <nav>
        <div class="footer-container">
            <img class="logo" src="images/kehler-logo1.png" alt="kehler logo" />
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="gallery.php">Gallery</a></li>
            </ul>
        
            <ul class="end-footer">
                <li>
                    Follow along with the farm to see what's growing.  
                    <div>
                        <a href="https://www.instagram.com/kehlervegetables" target="_blank">
                            <img src="images/instagram.png" alt="instagram logo">@kehlervegetables
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="divider">
        <h4>@2024 - <span>This is a fictional website for a college project</span> | All rights reserved</h4>
    </div>
</footer>

<script src="../assets/js/main.js"></script>

<!-- JS for modal -->
<script>
const images = document.querySelectorAll('.gallery-img');
const modal = document.getElementById('imageModal');
const modalImg = document.getElementById('modalImage');
const modalCaption = document.getElementById('modalCaption');

let currentIndex = 0;

images.forEach((img, index) => {
    img.addEventListener('click', () => {
        currentIndex = index;
        openModal();
    });
});

function openModal() {
    modal.style.display = "flex";
    modalImg.src = images[currentIndex].src;
    modalCaption.textContent = images[currentIndex].alt;
}

document.getElementById('prevButton').onclick = () => {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    openModal();
};

document.getElementById('nextButton').onclick = () => {
    currentIndex = (currentIndex + 1) % images.length;
    openModal();
};

modal.onclick = (e) => {
    if (e.target === modal) modal.style.display = "none";
};
</script>

</body>
</html>
