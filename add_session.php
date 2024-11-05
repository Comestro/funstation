<?php
// Include database connection
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $check_in_time = $_POST['check_in_time'];
    $assigned_hours = isset($_POST['assigned_hours']) ? (int)$_POST['assigned_hours'] : null;
    $age = $_POST['age']; // Age of the kid

    // Start a transaction
    $db->begin_transaction();

    try {
        // Check if kid already exists
        $stmt = $db->prepare("SELECT id FROM kids WHERE name = ? AND age = ?");
        $stmt->bind_param("si", $name, $age);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Kid exists, retrieve their ID
            $kid = $result->fetch_assoc();
            $kid_id = $kid['id'];
        } else {
            // Kid does not exist, insert new kid
            $stmt = $db->prepare("INSERT INTO kids (name, age) VALUES (?, ?)");
            $stmt->bind_param("si", $name, $age);
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
        header("Location: receipt.php?session_id=" . $session_id);
        exit();

    } catch (Exception $e) {
        // Rollback transaction if there's an error
        $db->rollback();
        http_response_code(500);
        echo "Error: " . $e->getMessage();
    }
}
?>
