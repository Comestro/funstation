<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['admin_id'])) {
    include '../config/database.php'; // Include your database connection file

    // Only necessary variables for updating the session
    $session_id = $_POST['session_id']; // Session ID to identify which session to update
    $extra_hours = $_POST['extra_hours']; // Extra hours to add

    // Fetch business settings for hourly charge
    $settingsQuery = "SELECT hourly_charge FROM settings LIMIT 1";
    $settingsResult = $db->query($settingsQuery);
    $settings = $settingsResult->fetch_assoc();

    // Assume hourly_rate is fetched from your settings
    $hourly_rate = $settings['hourly_charge']; // Retrieve hourly charge from settings

    // Get the current assigned hours from the session record
    $sessionQuery = "SELECT assigned_hours FROM sessions WHERE id = ?";
    $stmt = $db->prepare($sessionQuery);
    $stmt->bind_param("i", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $session = $result->fetch_assoc();

    // If session doesn't exist, return an error
    if (!$session) {
        echo json_encode(['success' => false, 'message' => 'Session not found']);
        exit;
    }

    // Current assigned hours
    $assigned_hours = $session['assigned_hours'];

    // Calculate the new total cost after adding the extra hours
    $new_assigned_hours = $assigned_hours + $extra_hours;
    $new_total_cost = ($new_assigned_hours == 0.5) ? $hourly_rate * 0.6 : $hourly_rate * $new_assigned_hours;

    // Update both assigned_hours and total_cost in the sessions table
    $query = "UPDATE sessions SET assigned_hours = ?, total_cost = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("dii", $new_assigned_hours, $new_total_cost, $session_id); // "d" for double, "i" for integer

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Assigned hours and total cost updated', "id" => $session_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update assigned hours and total cost']);
    }
}
?>
