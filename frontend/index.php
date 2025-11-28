<?php
require_once("config/db.php");

// Fetch hours dynamically
$stmt = $pdo->query("SELECT * FROM farm_hours ORDER BY day_of_week ASC");
$hours = $stmt->fetchAll(PDO::FETCH_ASSOC);

$days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <link rel="stylesheet" href="style.css">

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Poppins:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>

<header>
    <a href="index.php">
        <img class="logo" src="images/kehler-logo1.png" alt="kehler logo" loading="lazy">
    </a>

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

<!-- Mobile nav script -->
<script>
function showNav() {
    var element = document.getElementById("nav-items");
    element.classList.toggle("show-items");
}
</script>

<main>

    <section class="hero-section">
        <div class="hero-container">
            <div>
                <h1>About us!</h1>
                <p>
                    Kehler Vegetable Company is a small mixed market farm of vegetables,
                    berries and eggs from our pasture located on a 20 acre farm in the
                    Comox Valley. We are committed to providing the most nutritious,
                    locally grown and sustainable produce.
                </p>
            </div>

            <h2>Address: #8083, Black Creek, BC V9J 1G9</h2>
        </div>

        <img src="images/kehler's-farm.jpg" alt="the farm picture" loading="lazy">
    </section>

    <section class="about-us-section">
        <div>
            <h2>How We Grow</h2>
            <p>
                Our farm runs on a best practice system... (your text unchanged)
            </p>
        </div>
        <img src="images/kehler's2-farm.jpg" alt="produce" loading="lazy">
    </section>

    <section class="youtube-embed">
        <iframe src="https://www.youtube.com/embed/j00nyVYsemw?si=nuKFvadjaUhRjJE2"
        title="YouTube video player"
        referrerpolicy="strict-origin-when-cross-origin"
        allowfullscreen></iframe>
    </section>

    <!-- ⭐ DYNAMIC FARM HOURS ⭐ -->
    <section class="farm-hours">
        <h3>Available Hours</h3>

        <table>
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Farm Stand Open</th>
                    <th>Farm Visits</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($hours as $h): ?>
                <tr>
                    <td><?= $days[$h["day_of_week"]] ?></td>

                    <!-- OPEN/CLOSE or CLOSED display -->
                    <td>
                        <?php if ($h["is_closed"]): ?>
                            Closed
                        <?php else: ?>
                            <?= date("g:i A", strtotime($h["open_time"])) ?>
                            -
                            <?= date("g:i A", strtotime($h["close_time"])) ?>
                        <?php endif; ?>
                    </td>

                    <!-- NOTES (Farm visits column) -->
                    <td>
                        <?php
                            echo $h["notes"]
                                ? htmlspecialchars($h["notes"])
                                : "—";
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </section>

</main>

<footer>
    <nav>
        <div class="footer-container">
            <img class="logo" src="images/kehler-logo1.png" alt="kehler logo" loading="lazy">

            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="gallery.php">Gallery</a></li>
            </ul>

            <ul class="end-footer">
                <li>
                    Follow along with the farm...  
                    <div>
                        <a href="https://www.instagram.com/kehlervegetables" target="_blank">
                            <img src="images/instagram.png" alt="instagram logo" loading="lazy">
                            @kehlervegetables
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="divider">
        <h4>©2024 - <span>This is fictional website for a college project</span> | All rights reserved</h4>
    </div>
</footer>

<script src="../assets/js/main.js"></script>

</body>
</html>
