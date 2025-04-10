<?php
require '../config/database.php';
// Get the filter and search parameters from the request
$filter = $_GET['filter'] ?? 'today';
$searchTerm = $_GET['search'] ?? ''; // Retrieve the search term
$dateCondition = '';

// Set the date condition based on the filter
switch ($filter) {
    case 'yesterday':
        $dateCondition = "DATE(s.check_in_time) = CURDATE() - INTERVAL 1 DAY";
        break;
    case 'last7days':
        $dateCondition = "s.check_in_time >= NOW() - INTERVAL 7 DAY";
        break;
    case 'thismonth':
        $dateCondition = "MONTH(s.check_in_time) = MONTH(CURDATE()) AND YEAR(s.check_in_time) = YEAR(CURDATE())";
        break;
    case 'lastmonth':
        $dateCondition = "MONTH(s.check_in_time) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(s.check_in_time) = YEAR(CURDATE())";
        break;
    case 'last6months':
        $dateCondition = "s.check_in_time >= NOW() - INTERVAL 6 MONTH";
        break;
    case 'lastyear':
        $dateCondition = "YEAR(s.check_in_time) = YEAR(CURDATE()) - 1";
        break;
    case 'thisyear':
        $dateCondition = "YEAR(s.check_in_time) = YEAR(CURDATE())";
        break;
    case 'today':
    default:
        $dateCondition = "DATE(s.check_in_time) = CURDATE()";
        break;
}

// Prepare search condition
$searchCondition = '';
if (!empty($searchTerm)) {
    $searchTerm = $db->real_escape_string($searchTerm); // Escape the search term for security
    $searchCondition = "AND k.name LIKE '%$searchTerm%'";
}

$currentSessionsQuery = "SELECT s.id AS session_id, k.name,k.contact, s.check_in_time, s.assigned_hours, s.include_socks
                         FROM sessions s
                         JOIN kids k ON s.kid_id = k.id
                         WHERE s.check_out_time IS NULL 
                         ORDER BY s.check_in_time DESC";
$currentSessionsResult = $db->query($currentSessionsQuery);
$currentSessions = $currentSessionsResult->fetch_all(MYSQLI_ASSOC);

// Fetch checked-out sessions with the new filters
$checkedOutSessionsQuery = "SELECT s.id AS session_id, k.name, k.contact, s.check_in_time, s.check_out_time, s.assigned_hours
                            FROM sessions s
                            JOIN kids k ON s.kid_id = k.id
                            WHERE s.check_out_time IS NOT NULL 
                            AND $dateCondition
                            $searchCondition 
                            ORDER BY s.check_out_time DESC"; // Adjust the limit
$checkedOutSessionsResult = $db->query($checkedOutSessionsQuery);
$checkedOutSessions = $checkedOutSessionsResult->fetch_all(MYSQLI_ASSOC);

// Combine both types of data into one response
$response = [
    'current_sessions' => $currentSessions,
    'checked_out_sessions' => $checkedOutSessions
];

echo json_encode($response);

?>
