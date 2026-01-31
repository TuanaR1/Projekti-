<?php
session_start();
require_once "db.php";

$successMessage = "";
$errorMessage = "";
$isLoggedIn = isset($_SESSION["user_id"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $message = mysqli_real_escape_string($conn, $_POST["message"] ?? "");

    if (empty($message)) {
        $errorMessage = "Please fill in all fields.";
    } else {
        $sql = "INSERT INTO anymous (message) VALUES ('$message')";
        if (mysqli_query($conn, $sql)) {
            $successMessage = "Message sent successfully!";
        } else {
            $errorMessage = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>News | Artzy</title>

<link rel="stylesheet" href="shopCart.css">
<link rel="stylesheet" href="news.css">
<link rel="shortcut icon" type="image/x-icon" href="img/minilogo.png">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
  <div class="nav-left">
    <div class="resp-btn" onclick="hapMeny()">☰</div>
    <ul class="nav-links" id="navLinks">
      <li><a href="index.php">HOME</a></li>
      <li><a href="about.php">ABOUT</a></li>
      <li><a href="products.php">PRODUCTS</a></li>
      <li><a href="news.php" class="active">NEWS</a></li>
      <li><a href="contact.php">CONTACT</a></li>
    </ul>
  </div>

  <div class="nav-center">
    <img src="img/logo.png" alt="Logo" class="logo">
  </div>

  <div class="nav-right">
    <div class="nav-actions">
      <a href="cart.php" class="cart-btn">🛒</a>
      <?php if ($isLoggedIn): ?>
        <span style="color:#aaa;margin-right:10px;"><?= htmlspecialchars($_SESSION["username"]) ?></span>
        <a href="logout.php" class="search-btn" style="text-decoration:none;">LOGOUT</a>
      <?php else: ?>
        <a href="login.php" class="search-btn" style="text-decoration:none;">LOGIN</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<section class="hyrje-section">
  <div class="hyrje-overlay"></div>
  <div class="hyrje-content" style="margin-right: 20px;">
    <img src="img/logo.png" alt="Logo" class="hyrje-logo">
    <h2 class="hyrje-title">What’s New at Artzy</h2>
    <p class="hyrje-text">
      News, releases, and creative insights from the Artzy studio.
    </p>
  </div>
</section>

<section class="content-section">
  <h2 class="section-title">Where Creativity Evolves Into Timeless Visual Narratives</h2>
  <p class="section-text">
    At Artzy, creativity is not a moment — it’s a continuous journey shaped by observation, emotion, and refined vision. This space exists to document that journey. From early concepts and experimental ideas to polished releases and curated collections, Artzy News offers a deeper look into the thinking, process, and inspiration behind every visual we create. Each update shared here reflects our belief that design should speak without words. Posters are not simply decorative elements; they are statements that carry mood, perspective, and identity. Through this journal, we explore how ideas are transformed into visual experiences, how aesthetics are carefully balanced with meaning, and how every detail is intentionally crafted to stand the test of time. Artzy News also serves as a window into our studio mindset. You’ll discover stories behind new launches, insights into creative direction, and reflections on design trends interpreted through the Artzy lens. Rather than following trends, we focus on shaping visuals that feel distinctive, refined, and emotionally resonant. This is more than a news section — it is an evolving archive of creativity, growth, and artistic exploration. A place for those who value thoughtful design, minimal elegance, and visual storytelling. Whether you’re here to stay informed, find inspiration, or understand the philosophy behind Artzy, this is where our creative world unfolds.
  </p>
  <img src="img/newstxt.jpg" alt="News Txt Img" class="section-image">
</section>

<footer class="footer">
  <div class="footer-left">
    <div class="footer-column">
      <h3>Info</h3>
      <p>Unique art, <br> crafted with <br> style.</p>
    </div>
    <div class="footer-column">
      <h3>Quick Shop</h3>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="news.php">News</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="login.php">Log In</a></li>
      </ul>
    </div>
    <div class="footer-column">
      <h3>Contact Us</h3>
      <p>Email: artzy.creative@gmail.com</p>
      <br>
      <p>Phone: +383 00 000 000</p>
    </div>
  </div>

  <div class="footer-right">
    <form class="contact-form" method="POST">
      <h3>Send an Anymous Feedback</h3>
      <textarea name="message" placeholder="Your message" required></textarea>
      <?php if ($successMessage): ?><p style="color:green"><?= $successMessage ?></p><?php endif; ?>
      <?php if ($errorMessage): ?><p style="color:red"><?= $errorMessage ?></p><?php endif; ?>
      <button>Send</button>
    </form>

    <div class="social-buttons">
      <a href="https://www.instagram.com/artzy.io/" class="social-btn"><img src="img/instagram-icon.png" alt="Instagram"></a>
      <a href="https://www.threads.com/@artzy.io" class="social-btn"><img src="img/threads-icon.png" alt="Threads"></a>
      <a href="https://accounts.google.com/servicelogin?service=mail" class="social-btn"><img src="img/mail-icon.png" alt="Mail"></a>
    </div>
  </div>
</footer>

<div class="copyright">
  <p>Copyright © 2025 Artzy</p>
</div>

<script src="news.js"></script>
</body>
</html>
