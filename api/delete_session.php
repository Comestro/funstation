<?php
include_once "../config/database.php";
require_once '../include/login_required.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'&& $_SESSION['admin_id'] === 1) {
    $session_id = $_POST['session_id'];

    $query = "DELETE FROM sessions WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $session_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete session']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
}
?>
