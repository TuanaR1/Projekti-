<?php
session_start();
require_once "db.php";

$successMessage = "";
$errorMessage = "";
$isLoggedIn = isset($_SESSION["user_id"]);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["message"])) {
    $message = mysqli_real_escape_string($conn, $_POST["message"]);
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

// Fetch products from DB
$productsResult = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Products | Artzy</title>
<link rel="stylesheet" href="shopCart.css">
<link rel="stylesheet" href="products.css">
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
      <li><a href="products.php" class="active">PRODUCTS</a></li>
      <li><a href="news.php">NEWS</a></li>
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

<section class="products-section" id="products-section">
  <div class="products">
<?php while($product = $productsResult->fetch_assoc()): ?>
<div class="product-card">
  <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
  <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
  <div class="formats">
    <label><input type="radio" name="p<?= $product['id'] ?>" checked data-price="<?= htmlspecialchars($product['price']) ?>"><span>A1</span></label>
    <label><input type="radio" name="p<?= $product['id'] ?>" data-price="<?= round($product['price']*0.75,2) ?>"><span>A2</span></label>
    <label><input type="radio" name="p<?= $product['id'] ?>" data-price="<?= round($product['price']*0.5,2) ?>"><span>A3</span></label>
    <label><input type="radio" name="p<?= $product['id'] ?>" data-price="<?= round($product['price']*0.25,2) ?>"><span>A4</span></label>
  </div>
  <div class="price">€<span class="price-value"><?= htmlspecialchars($product['price']) ?></span></div>
  <button class="add-to-cart">Add to Cart</button>
</div>
<?php endwhile; ?>
  </div>
</section>

<!-- ---------- FOOTER ---------- -->
<footer class="footer">
  <div class="footer-left">
    <div class="footer-column">
      <h3>Info</h3>
      <p>Unique art,<br>crafted with style.</p>
    </div>

    <div class="footer-column">
      <h3>Quick Shop</h3>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="news.php">News</a></li>
        <li><a href="contact.php">Contact</a></li>
        <?php if (!$isLoggedIn): ?>
            <li><a href="login.php">Log In</a></li>
        <?php endif; ?>
      </ul>
    </div>

    <div class="footer-column">
      <h3>Contact Us</h3>
      <p>Email: artzy.creative@gmail.com</p>
      <p>Phone: +383 00 000 000</p>
    </div>
  </div>

  <div class="footer-right">
    <form method="POST">
      <h3>Send an Anonymous Feedback</h3>
      <textarea name="message" placeholder="Your message" required></textarea>

      <?php if ($successMessage): ?><p style="color:green"><?= $successMessage ?></p><?php endif; ?>
      <?php if ($errorMessage): ?><p style="color:red"><?= $errorMessage ?></p><?php endif; ?>

      <button>Send</button>
    </form>
  </div>
</footer>

<div class="copyright">
  <p>Copyright © 2025 Artzy</p>
</div>

<script src="products.js"></script>
<script>
const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

document.querySelectorAll(".add-to-cart").forEach(btn=>{
  btn.addEventListener("click",()=>{
    if(!isLoggedIn){
      alert("You must be logged in to add items to the cart!");
      window.location.href = "login.php";
      return;
    }

    const card = btn.closest(".product-card");
    const name = card.querySelector(".product-name").innerText;
    const radio = card.querySelector("input[type=radio]:checked");
    const size = radio.nextElementSibling.innerText;
    const price = radio.dataset.price;

    fetch("add_to_cart.php", {
      method:"POST",
      headers:{"Content-Type":"application/x-www-form-urlencoded"},
      body:`name=${encodeURIComponent(name)}&size=${encodeURIComponent(size)}&price=${encodeURIComponent(price)}`
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
    })
    .catch(err => alert("Error adding product to cart"));
  });
});
</script>

</body>
</html>
