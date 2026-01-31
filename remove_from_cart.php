<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);
$user_id = $_SESSION['user_id'];

mysqli_query($conn, "DELETE FROM cart WHERE id='$id' AND user_id='$user_id'");
header("Location: cart.php");
exit;
?>
