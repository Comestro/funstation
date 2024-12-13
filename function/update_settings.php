<?php
session_start();
require_once '../config/database.php'; // Include your database connection file

// Initialize an array to collect any error messages
$errors = [];

// Check if settings row exists, and create it if not
$query = "SELECT * FROM settings WHERE id = 1 LIMIT 1";
$result = $db->query($query);

if ($result->num_rows === 0) {
    // Insert default settings row if it doesn't exist
    $stmt = $db->prepare("INSERT INTO settings (id, hourly_charge, contact, business_name, address, logo, email, password, gst) VALUES (1, 0, '', '', '', '', '', '', null)");
    $stmt->execute();
}

// Check if a form submission is made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update hourly charge
    if (isset($_POST['hourly_charge'])) {
        $hourly_charge = floatval($_POST['hourly_charge']);
        $stmt = $db->prepare("UPDATE settings SET hourly_charge = ? WHERE id = 1");
        $stmt->bind_param("d", $hourly_charge);
        if (!$stmt->execute()) {
            $errors[] = "Failed to update hourly charge.";
        }
    }

    // Update GST
    if (isset($_POST['gst'])) {
         $gst = $_POST['gst'];
        $stmt = $db->prepare("UPDATE settings SET gst = ? WHERE id = 1");
        $stmt->bind_param("s", $gst);
        if (!$stmt->execute()) {
            $errors[] = "Failed to update GST.";
        }
    }

    // Update contact
    if (isset($_POST['contact'])) {
        $contact = htmlspecialchars($_POST['contact']);
        $stmt = $db->prepare("UPDATE settings SET contact = ? WHERE id = 1");
        $stmt->bind_param("s", $contact);
        if (!$stmt->execute()) {
            $errors[] = "Failed to update contact.";
        }
    }

    // Update business name
    if (isset($_POST['business_name'])) {
        $business_name = htmlspecialchars($_POST['business_name']);
        $stmt = $db->prepare("UPDATE settings SET business_name = ? WHERE id = 1");
        $stmt->bind_param("s", $business_name);
        if (!$stmt->execute()) {
            $errors[] = "Failed to update business name.";
        }
    }

    // Update address
    if (isset($_POST['address'])) {
        $address = htmlspecialchars($_POST['address']);
        $stmt = $db->prepare("UPDATE settings SET address = ? WHERE id = 1");
        $stmt->bind_param("s", $address);
        if (!$stmt->execute()) {
            $errors[] = "Failed to update address.";
        }
    }

    // Update email
    if (isset($_POST['email'])) {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if ($email) {
            $stmt = $db->prepare("UPDATE settings SET email = ? WHERE id = 1");
            $stmt->bind_param("s", $email);
            if (!$stmt->execute()) {
                $errors[] = "Failed to update email.";
            }
        } else {
            $errors[] = "Invalid email format.";
        }
    }

    // Update password
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE admin SET password = ? WHERE id = 1");
        $stmt->bind_param("s", $password);
        if (!$stmt->execute()) {
            $errors[] = "Failed to update password.";
        }
    }

    // Redirect back with success or error messages
    if (empty($errors)) {
        $_SESSION['message'] = "Settings updated successfully.";
    } else {
        $_SESSION['errors'] = $errors;
    }
    
    header("Location: ../settings.php");
    exit();
} else {
    header("Location: ../settings.php");
    exit();
}
?>
