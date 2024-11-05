<?php
require 'database.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kidId = $_POST['kid_id'];
    $checkInTime = date('Y-m-d H:i:s');

    // Insert a new session for the kid
    $stmt = $db->prepare("INSERT INTO sessions (kid_id, check_in_time) VALUES (?, ?)");
    $stmt->bind_param("is", $kidId, $checkInTime);
    $stmt->execute();
    echo "Checked in successfully!";
}
?>
