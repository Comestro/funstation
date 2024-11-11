<?php
session_start();
require '../config/database.php';  // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the query using MySQLi
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Check if the admin exists and password is correct
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: index.php");  // Redirect to the admin dashboard
        exit;
    } else {
        echo "Invalid username or password.";
    }
}
?>
