<?php
require 'database.php';
header('Content-Type: application/json'); // Set the content type to JSON

$response = array(); // Initialize an array for the response

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sessionId = $_POST['session_id'];
    $checkOutTime = date('Y-m-d H:i:s');

    // Update the session with check-out time
    $stmt = $db->prepare("UPDATE sessions SET check_out_time = ? WHERE id = ?");
    $stmt->bind_param("si", $checkOutTime, $sessionId);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Checked out successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error updating the session: " . $stmt->error; // Capture any errors
    }

    $stmt->close(); // Close the statement
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}

// Send the JSON response
echo json_encode($response);
?>
