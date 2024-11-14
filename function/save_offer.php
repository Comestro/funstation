<?php
session_start();
include '../config/database.php'; // Include your database connection

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and validate form data
    $offerName = trim($_POST['offer_name']);
    $discountPercentage = floatval($_POST['discount_percentage']);
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Check that end date is after start date
    if ($endDate < $startDate) {
        $_SESSION['errors'] = ["End date must be after start date."];
        header("Location: settings.php");
        exit();
    }

    // Insert offer into the database
    $stmt = $db->prepare("INSERT INTO offers (name, discount_percentage, start_date, end_date, is_active) VALUES (?, ?, ?, ?, 1)");
    $stmt->bind_param("sdss", $offerName, $discountPercentage, $startDate, $endDate);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Offer saved successfully!";
    } else {
        $_SESSION['errors'] = ["Failed to save offer."];
    }

    // Redirect back to settings page
    header("Location: ../index.php");
    exit();
}
?>
