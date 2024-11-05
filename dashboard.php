<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

echo "<h1>Welcome to the Game Zone</h1>";
echo "<a href='checkin.php'>Check In</a> | <a href='checkout.php'>Check Out</a> | <a href='logout.php'>Logout</a>";
?>
