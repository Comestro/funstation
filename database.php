<?php
$host = 'localhost';         // Database host
$dbname = 'game_zone';       // Database name
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

?>
