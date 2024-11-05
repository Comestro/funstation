<?php
session_start();
include 'database.php'; // Include database connection

// Define hourly rate (inclusive of GST) and GST rate
$hourlyRateInclusive = 250; // Set your hourly rate inclusive of GST
$gstRate = 0.18; // 18% GST

// Get session_id from URL
$sessionId = $_GET['session_id'] ?? null;

if ($sessionId) {
    // Fetch session and kid details from the database
    $stmt = $db->prepare("SELECT s.*, k.name FROM sessions s JOIN kids k ON s.kid_id = k.id WHERE s.id = ?");
    $stmt->bind_param("i", $sessionId);
    $stmt->execute();
    $result = $stmt->get_result();
    $session = $result->fetch_assoc();

    if ($session) {
        $assignedHours = $session['assigned_hours'];
        $totalAmountInclusive = $assignedHours * $hourlyRateInclusive;

        // Calculate base amount and GST from the inclusive total
        $baseAmount = $totalAmountInclusive / (1 + $gstRate);
        $gstAmount = $totalAmountInclusive - $baseAmount;
    } else {
        echo "Session not found.";
        exit();
    }
} else {
    echo "No session ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
    <style>
        /* Thermal Printer Style */
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 80mm;
            margin: 0 auto;
            font-size: 14px;
            color: #000;
        }

        .receipt-container {
            padding: 10px;
            border: 1px dashed #333;
        }

        .center {
            text-align: center;
        }

        .receipt-header, .receipt-footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .line-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .total {
            font-weight: bold;
        }

        .footer {
            font-size: 10px;
            margin-top: 20px;
            text-align: center;
            border-top: 1px dashed #333;
            padding-top: 10px;
        }
        .heading{
            font-size: 18px;
        }
    </style>
</head>
<body>
<div class="receipt-container">
    <!-- Header Section -->
    <div class="receipt-header">
        <p class="center">
            <strong class="heading">Kids FunStation</strong><br>
            Panorama Rameshwaram, 1<sup>st</sup> floor, <br>
            Near Tanishq Showroom, Line Bazaar, 
            Purnea, Bihar (854301)<br><br>
            Phone: 9608297530, 82944913382<br>
            Email: info@gamezone.com
        </p>
    </div>

    <!-- Customer & Session Details -->
    <div>
        <p><strong>Customer:</strong> <?= htmlspecialchars($session['name']) ?></p>
        <p><strong>Check-In Time:</strong> <br> <?= $session['check_in_time'] ?></p>
        <p><strong>Assigned Hours:</strong> <?= $assignedHours ?> Hours</p>
    </div>

    <!-- Billing Section -->
    <div class="billing">
        <p><strong>Hourly Billing</strong></p>
        <div class="line-item">
            <span>Base Amount (Excl. GST)</span>
            <span>₹<?= number_format($baseAmount, 2) ?></span>
        </div>
        <div class="line-item">
            <span>GST (<?= $gstRate * 100 ?>%)</span>
            <span>₹<?= number_format($gstAmount, 2) ?></span>
        </div>

        <!-- Total -->
        <div class="line-item total">
            <span>Total (Incl. GST)</span>
            <span>₹<?= number_format($totalAmountInclusive, 2) ?></span>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>Thank you for visiting Game Zone!</p>
        <p>Visit Again!</p>
    </div>
</div>
</body>
</html>
