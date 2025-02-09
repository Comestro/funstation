<?php
$host = 'localhost';         // Database host
$dbname = 'game_zone1';       // Database name
$username = 'root';          // Database username
$password = '';              // Database password

// Create a new MySQLi connection
$db = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Set character set to UTF-8 for proper encoding
$db->set_charset("utf8");

date_default_timezone_set('Asia/Kolkata'); // Replace with your timezone if different
$password = password_hash(123456789, PASSWORD_DEFAULT); // Hash the password

// $db->query("insert into admin (username, password) value ('rock','$password')");

if (!isset($_SESSION['settings'])) {
    $result = $db->query("SELECT * FROM settings WHERE id = 1");
    if ($result) {
        $_SESSION['settings'] = $result->fetch_assoc();
    } else {
        die("Error fetching settings: " . $db->error);
    }
}

$title = isset($_SESSION['settings']['business_name']) ? $_SESSION['settings']['business_name'] : "Game Zone";
?>
