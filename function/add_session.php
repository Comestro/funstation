<?php
// Include database connection
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $check_in_time = $_POST['check_in_time'];
    $assigned_hours = $_POST['assigned_hours'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];
    $include_gst = $_POST['include_gst'];
    $include_socks = isset($_POST['include_socks']) ? 1 : 0;

    $settingsQuery = "SELECT business_name, email, contact, hourly_charge, address, gst FROM settings LIMIT 1";
    $settingsResult = $db->query($settingsQuery);
    $settings = $settingsResult->fetch_assoc();

    $hourly_rate = $settings['hourly_charge'];

    // Calculate the total cost including socks if selected
    $total_cost = ($assigned_hours == 0.5) ? $hourly_rate * 0.6 : $hourly_rate * $assigned_hours;
    if ($include_socks) {
        $total_cost += 30; // Add socks charge
    }

    // Start a transaction
    $db->begin_transaction();

    try {
        // Check if kid already exists based on contact
        $stmt = $db->prepare("SELECT id FROM kids WHERE contact = ? and contact = ?");
        $stmt->bind_param("ss", $contact, $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Kid exists, retrieve their ID
            $kid = $result->fetch_assoc();
            $kid_id = $kid['id'];
        } else {
            // Kid does not exist, insert new kid with name, age, and contact
            $stmt = $db->prepare("INSERT INTO kids (name, age, contact) VALUES (?, ?, ?)");
            $stmt->bind_param("sds", $name, $age, $contact);
            $stmt->execute();
            $kid_id = $db->insert_id;
        }

        // Insert the new session with check-in time, kid ID, assigned hours, and total cost
        $stmt = $db->prepare("INSERT INTO sessions (kid_id, check_in_time, assigned_hours, total_cost, include_gst, include_socks) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isddii", $kid_id, $check_in_time, $assigned_hours, $total_cost, $include_gst, $include_socks);
        $stmt->execute();

        // Get the inserted session ID
        $session_id = $db->insert_id;

        // Commit transaction
        $db->commit();

        // Redirect to receipt.php with the session ID to display the receipt
        header("Location: ../receipt.php?session_id=" . $session_id);
        exit();

    } catch (Exception $e) {
        // Rollback transaction if there's an error
        $db->rollback();
        http_response_code(500);
        echo "Error: " . $e->getMessage();
    }
}
?>
