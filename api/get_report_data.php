<?php
require '../config/database.php'; // Ensure this connects to your database

// Define your hourly rate for calculating revenue
$hourlyRate = 250; // Adjust the rate as needed

// Initialize arrays for labels and data
$dailyCheckins = ['labels' => [], 'data' => []];
$revenue = ['labels' => [], 'data' => []];

// Fetch daily check-ins for the last 7 days
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $dailyCheckins['labels'][] = date('D', strtotime($date)); // Day name

    // Query to count check-ins on each day
    $checkinsQuery = "SELECT COUNT(*) AS checkins 
                      FROM sessions 
                      WHERE DATE(check_in_time) = '$date'";
    $checkinsResult = $db->query($checkinsQuery);
    $checkinsData = $checkinsResult->fetch_assoc();
    $dailyCheckins['data'][] = (int) $checkinsData['checkins'];
}

// Fetch monthly revenue for the last 6 months
for ($i = 5; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i months"));
    $revenue['labels'][] = date('F', strtotime($month)); // Month name

    // Calculate revenue for each month
    $revenueQuery = "SELECT SUM(TIMESTAMPDIFF(HOUR, check_in_time, check_out_time) * $hourlyRate) AS monthly_revenue
                     FROM sessions
                     WHERE DATE_FORMAT(check_in_time, '%Y-%m') = '$month'
                     AND check_out_time IS NOT NULL"; // Only completed sessions
    $revenueResult = $db->query($revenueQuery);
    $revenueData = $revenueResult->fetch_assoc();
    $revenue['data'][] = (int) $revenueData['monthly_revenue'];
}

// Prepare data for JSON response
$data = [
    'dailyCheckins' => $dailyCheckins,
    'revenue' => $revenue
];

header('Content-Type: application/json');
echo json_encode($data);
