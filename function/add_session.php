<?php
// Include database connection
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $check_in_time = $_POST['check_in_time'];
    $assigned_hours = isset($_POST['assigned_hours']) ? (int)$_POST['assigned_hours'] : null;
    $age = $_POST['age'];
    $contact = $_POST['contact'];

    // Start a transaction
    $db->begin_transaction();

    try {
        // Check if kid already exists based on contact
        $stmt = $db->prepare("SELECT id FROM kids WHERE contact = ?");
        $stmt->bind_param("s", $contact);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Kid exists, retrieve their ID
            $kid = $result->fetch_assoc();
            $kid_id = $kid['id'];
        } else {
            // Kid does not exist, insert new kid with name, age, and contact
            $stmt = $db->prepare("INSERT INTO kids (name, age, contact) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $name, $age, $contact);
            $stmt->execute();
            $kid_id = $db->insert_id;
        }

        // Insert the new session with check-in time, kid ID, and assigned hours
        $stmt = $db->prepare("INSERT INTO sessions (kid_id, check_in_time, assigned_hours) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $kid_id, $check_in_time, $assigned_hours);
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
