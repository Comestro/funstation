<?php
require_once '../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['session_id'])) {
    $session_id = $_POST['session_id'];
    
    try {
        // Update both include_socks and total_cost
        $stmt = $db->prepare("UPDATE sessions SET include_socks = 1, total_cost = total_cost + 30 WHERE id = ? AND include_socks = 0");
        $stmt->bind_param("i", $session_id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Session not found or socks already added']);
        }
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
