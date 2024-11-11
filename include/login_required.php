<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");  // Redirect if not logged in
    exit;
}
?>
