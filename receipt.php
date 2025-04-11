<?php
include 'config/database.php'; // Include database connection
require_once 'include/login_required.php';

// Fetch business information and hourly rate from the settings table
$settingsQuery = "SELECT business_name, email, contact, hourly_charge, address, gst FROM settings LIMIT 1";
$settingsResult = $db->query($settingsQuery);
$settings = $settingsResult->fetch_assoc();

// Define default values if settings are not available
$businessName = $settings['business_name'] ?? 'Kids FunStation';
$businessEmail = $settings['email'] ?? 'info@gamezone.com';
$businessContact = $settings['contact'] ?? '9608297530, 82944913382';
$hourlyRateInclusive = $settings['hourly_charge'] ?? 250;
$gstNo = $settings['gst'] ?? "10CNCPA1183R1Z6";
$businessAddress = $settings['address'] ?? 'Panorama Rameshwaram, 1<sup>st</sup> floor, <br> Near Tanishq Showroom, Line Bazaar, Purnea, Bihar (854301)';

$gstRate = 0.18;
$cgstRate = $gstRate / 2;
$sgstRate = $gstRate / 2;

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
        $totalAmountInclusive = $session['total_cost'];
        $includeGst = $session['include_gst'] ?? false;

        // Check for an active offer
        $today = date('Y-m-d');
        $offerQuery = "SELECT * FROM offers WHERE is_active = 1 AND start_date <= ? AND end_date >= ? LIMIT 1";
        $stmt = $db->prepare($offerQuery);
        $stmt->bind_param("ss", $today, $today);
        $stmt->execute();
        $offerResult = $stmt->get_result();

        if ($offer = $offerResult->fetch_assoc()) {
            $sockCharge = ($session['include_socks'] ? 30 : 0);
            $playTimeAmount = $totalAmountInclusive - $sockCharge;
            
            $discount = $offer['discount_percentage'] / 100;
            $discountAmount = $playTimeAmount * $discount;
            $totalAmountInclusive = $playTimeAmount - $discountAmount + $sockCharge;
            $baseAmount = ($totalAmountInclusive - $sockCharge) / (1 + $gstRate);
            $totalGstAmount = ($totalAmountInclusive - $sockCharge) - $baseAmount;
            $cgstAmount = $baseAmount * $cgstRate;
            $sgstAmount = $baseAmount * $sgstRate;
        }

        if ($includeGst) {
            // Calculate base amount and GST components from the inclusive total
            $baseAmount = $totalAmountInclusive / (1 + $gstRate);
            if ($session['include_socks']) {
                $baseAmount -= 30; // Remove socks charge from base amount
            }
            $totalGstAmount = $totalAmountInclusive - $baseAmount - ($session['include_socks'] ? 30 : 0);
            $cgstAmount = $baseAmount * $cgstRate;
            $sgstAmount = $baseAmount * $sgstRate;
        }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bill Generated | <?php echo htmlspecialchars($businessName); ?></title>
    <style>
        /* Thermal Printer Style */
        body {
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
            margin-top: 20px;
            text-align: center;
            border-top: 1px dashed #333;
            padding-top: 10px;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            gap: 5px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .btn-red {
            background-color: hotpink;
        }
        .btn-green {
            background-color: teal;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            .receipt-container, .receipt-container * {
                visibility: visible;
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
    <div class="center">
        <strong><?= htmlspecialchars($businessName) ?></strong><br>
        <?= htmlspecialchars($businessAddress); ?><br>
        <?php if ($includeGst): ?>
            GST No: <?= htmlspecialchars($gstNo); ?><br>
        <?php endif; ?>
        <br>
        Phone: <?= htmlspecialchars($businessContact) ?><br>
        <?= htmlspecialchars($businessEmail) ?><br>
    </div>

    <!-- Customer & Session Details -->
    <div>
        <p><strong>Kid's Name:</strong> <?= htmlspecialchars($session['name']) ?></p>
        <p><strong>Assigned Hours:</strong> <?= htmlspecialchars($assignedHours == 0.5 ? "Half " : $assignedHours) ?> <?= $assignedHours <= 1 ? "Hour" : "Hours";?>  </p>
        <p><strong>Check-In Time:</strong> <?= date("h:i A - d/m/Y", strtotime($session['check_in_time'])) ?></p>
    </div>

    <!-- Billing Section -->
    <div>
        <p><strong>Receipt Details:</strong></p>
        <div class="line-item">
            <span>Play Time Charges:</span>
            <span>₹<?= number_format($playTimeAmount, 2) ?></span>
        </div>

        <?php if ($session['include_socks']): ?>
        <div class="line-item">
            <span>Socks:</span>
            <span>₹30.00</span>
        </div>
        <?php endif; ?>

        <?php if ($includeGst): ?>
            <div class="line-item">
                <span>Base Amount (Excl. GST):</span>
                <span>₹<?= number_format($baseAmount, 2) ?></span>
            </div>
            <div class="line-item">
                <span>CGST (<?= $cgstRate * 100 ?>%):</span>
                <span>₹<?= number_format($cgstAmount, 2) ?></span>
            </div>
            <div class="line-item">
                <span>SGST (<?= $sgstRate * 100 ?>%):</span>
                <span>₹<?= number_format($sgstAmount, 2) ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($offer) && isset($discountAmount)): ?>
        <div class="line-item">
            <span>Discount (<?= htmlspecialchars($offer['discount_percentage']) ?>%):</span>
            <span>-₹<?= number_format($discountAmount, 2) ?></span>
        </div>
        <?php endif; ?>

        <div class="line-item total">
            <span>Total Cost:</span>
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
    <a href="#" class="btn btn-red" onclick="window.print()">Print Receipt</a>
    <a href="index.php" class="btn btn-green">Go Back</a>
</div>
</body>
</html>
