<?php
session_start();
require_once "db.php";

$errorMessage = "";
$submitted = false;


$isAdminLogin = isset($_GET['admin']) && $_GET['admin'] == 1;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submitted = true;
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $errorMessage = "Please enter both username and password.";
    } else {
        if ($isAdminLogin) {

            $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? LIMIT 1");
        } else {
  
            $stmt = $conn->prepare("SELECT * FROM register WHERE username = ? LIMIT 1");
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();


            if ($password === $user['password']) {


                if ($isAdminLogin) {
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_username'] = $user['username'];
                    header("Location: dashboard.php");
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: index.php");
                }
                exit;
            } else {
                $errorMessage = "Incorrect password.";
            }
        } else {
            $errorMessage = $isAdminLogin ? "Admin not found." : "User not found.";
        }
    }
}

$loggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Artzy</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>


<div class="login-container">
    <form class="login-form" method="POST" action="">
        <h2><?= $isAdminLogin ? "Admin Login" : "User Login" ?></h2>

        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
            <?php if ($submitted && $errorMessage): ?>
                <p style="color:red; font-size:14px; margin-top:6px;">
                    <?= htmlspecialchars($errorMessage) ?>
                </p>
            <?php endif; ?>
        </div>

        <button type="submit">Login</button>

        <?php if (!$isAdminLogin): ?>
            <p class="register-text">
                Don’t have an account? <a href="register.php">Register</a>
                <br>
                Are you an administrator? <a href="login.php?admin=1">Login as admin</a>
            </p>
        <?php else: ?>
            <p class="register-text">
                Back to <a href="login.php">User Login</a>
            </p>
        <?php endif; ?>
        
    </form>
</div>

</body>
</html>
