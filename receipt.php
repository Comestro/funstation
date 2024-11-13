<?php
session_start();
include 'config/database.php'; // Include database connection

// Fetch business information and hourly rate from the settings table
$settingsQuery = "SELECT business_name, email, contact, hourly_charge, address FROM settings LIMIT 1";
$settingsResult = $db->query($settingsQuery);
$settings = $settingsResult->fetch_assoc();

// Define default values if settings are not available
$businessName = $settings['business_name'] ?? 'Kids FunStation';
$businessEmail = $settings['email'] ?? 'info@gamezone.com';
$businessContact = $settings['contact'] ?? '9608297530, 82944913382';
$hourlyRateInclusive = $settings['hourly_charge'] ?? 250; // Default to 250 if not set
$gstNo = $settings['gst'] ?? "10CNCPA1183R1Z6"; // Default to 250 if not set
$businessAddress = $settings['address'] ?? 'Panorama Rameshwaram, 1<sup>st</sup> floor, <br> Near Tanishq Showroom, Line Bazaar, Purnea, Bihar (854301)';

$gstRate = 0.28; // 28% GST
$cgstRate = $gstRate / 2; // 14% CGST
$sgstRate = $gstRate / 2; // 14% SGST

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
        $totalAmountInclusive = $session['total_cost']; // Retrieve stored total cost

        // Calculate base amount and GST components from the inclusive total
        $baseAmount = $totalAmountInclusive / (1 + $gstRate);
        $totalGstAmount = $totalAmountInclusive - $baseAmount;
        $cgstAmount = $baseAmount * $cgstRate;
        $sgstAmount = $baseAmount * $sgstRate;
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
    <title>Bill Generated | <?php echo htmlspecialchars($businessName); ?></title>
    <style>
        /* Thermal Printer Style */
        strong {
            font-weight: 400;
        }
        body {
            /* font-family:sans-serif; */
            font-family: 'Times New Roman', Times, serif;
            width: 80mm;
            margin: 0 auto;
            font-size: 14px;
            color: #000;
        }

        .receipt-container {
            padding: 10px;
            margin-top: 20px;
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
            font-size: 12px;
        }

        .total {
            font-weight: bold;
        }

        .footer {
            font-size: 14px;
            font-family: sans-serif;
            margin-top: 20px;
            text-align: center;
            border-top: 1px dashed #333;
            padding-top: 10px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            gap: 5px;
        }
        .btn-red {
            background-color: hotpink;
            font-family: sans-serif;
        }
        .btn-green {
            background-color: teal;
            font-family: sans-serif;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            .receipt-container, .receipt-container * {
                visibility: visible;
            }
            .receipt-container {
                position: absolute;
                left: 0;
                top: 0;
            }
            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="receipt-container">
    <!-- Header Section -->
    <div class="receipt-header">
        <p class="center">
            <strong class="heading"><?= htmlspecialchars($businessName) ?></strong><br>
            <?= htmlspecialchars($businessAddress); ?><br>
            GST No: <?= htmlspecialchars($gstNo); ?><br><br>
            Phone: <?= htmlspecialchars($businessContact) ?><br>
            <?= htmlspecialchars($businessEmail) ?> <br>
        </p>
    </div>

    <!-- Customer & Session Details -->
    <div>
        <p><strong>Customer:</strong> <?= htmlspecialchars($session['name']) ?></p>
        <p><strong>Check-In Time:</strong> <br> <?= date("h:i A - d/m/Y", strtotime($session['check_in_time'])) ?></p>
        <p><strong>Assigned Hours:</strong> <?= ($assignedHours == 0.5) ? '1/2' : $assignedHours ?> Hours</p>
    </div>

    <!-- Billing Section -->
    <div class="billing">
        <p><strong>Hourly Billing</strong></p>
        <div class="line-item">
            <span>Base Amount (Excl. GST)</span>
            <span>₹<?= number_format($baseAmount, 2) ?></span>
        </div>
        <div class="line-item">
            <span>CGST (<?= $cgstRate * 100 ?>%)</span>
            <span>₹<?= number_format($cgstAmount, 2) ?></span>
        </div>
        <div class="line-item">
            <span>SGST (<?= $sgstRate * 100 ?>%)</span>
            <span>₹<?= number_format($sgstAmount, 2) ?></span>
        </div>

        <!-- Total -->
        <div class="line-item total">
            <span>Total (Incl. GST)</span>
            <span>₹<?= number_format($totalAmountInclusive, 2) ?></span>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>Thank you for visiting <?= htmlspecialchars($businessName) ?>!</p>
        <p>Visit Again!</p>
    </div>
</div>
<div class="btn-container">
    <a href="" class="btn btn-red" onclick="window.print()">Print Receipt</a>
    <a href="index.php" class="btn btn-green">Go Back</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</body>
</html>
