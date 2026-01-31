<?php
require_once "db.php";

$successMessage = "";
$errorMessage = "";
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submitted = true;

    $name = mysqli_real_escape_string($conn, $_POST["name"] ?? "");
    $username = mysqli_real_escape_string($conn, $_POST["username"] ?? "");
    $email = mysqli_real_escape_string($conn, $_POST["email"] ?? "");
    $password = mysqli_real_escape_string($conn, $_POST["password"] ?? "");
    $confPass = mysqli_real_escape_string($conn, $_POST["confPass"] ?? "");

    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($confPass)) {
        $errorMessage = "All fields are required.";
    } elseif ($password !== $confPass) {
        $errorMessage = "Passwords do not match.";
    } else {
        $sql = "INSERT INTO register (name, username, email, password, confPass)
                VALUES ('$name', '$username', '$email', '$password', '$confPass')";

        if (mysqli_query($conn, $sql)) {
            $successMessage = "Registration successful!";
        } else {
            $errorMessage = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Artzy</title>

    <link rel="stylesheet" href="shopCart.css">
    <link rel="stylesheet" href="register.css">
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
      <li><a href="news.php">NEWS</a></li>
      <li><a href="contact.php">CONTACT</a></li>
    </ul>
  </div>

  <div class="nav-center">
    <img src="img/logo.png" alt="Logo" class="logo">
  </div>s

  <div class="nav-right">
    <button class="search-btn">
      <a href="login.php" style="text-decoration:none; color:rgb(169,169,169);">LOGIN</a>
    </button>
  </div>
</nav>

<!-- Register Form -->
<div class="login-container">
    <form class="login-form" method="POST" action="">
        <h2>Register</h2>

        <div class="input-group">
            <input type="text" name="name" placeholder="Name" required>
        </div>

        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <div class="input-group">
            <input type="password" name="confPass" placeholder="Confirm Password" required>

            <?php if ($submitted && $successMessage): ?>
                <p style="color:green; font-size:14px; margin-top:6px;">
                    <?= $successMessage ?>
                </p>
            <?php endif; ?>

            <?php if ($submitted && $errorMessage): ?>
                <p style="color:red; font-size:14px; margin-top:6px;">
                    <?= $errorMessage ?>
                </p>
            <?php endif; ?>
        </div>

        <button type="submit">Register</button>

        <p class="register-text">
            You have an account? <a href="login.php">Log In</a>
        </p>
    </form>
</div>


<div class="copyright">
  <p>Copyright © 2025 Artzy</p>
</div>

<script src="register.js"></script>

</body>
</html>
