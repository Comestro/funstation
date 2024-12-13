<?php
require_once 'config/database.php';
require_once 'include/login_required.php';


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $offer_name = $_POST['offer_name'];
    $discount_percentage = $_POST['discount_percentage'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Check if there is already an active offer
    $db->query("DELETE FROM offers"); // Delete any existing offers

    // Insert the new offer
    $stmt = $db->prepare("INSERT INTO offers (offer_name, discount_percentage, start_date, end_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $offer_name, $discount_percentage, $start_date, $end_date);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
}

// Handle delete request
if (isset($_GET['delete_offer_id'])) {
    $offerId = $_GET['delete_offer_id'];
    $stmt = $db->prepare("DELETE FROM offers WHERE id = ?");
    $stmt->bind_param("i", $offerId);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
    exit();
}

// Fetch the current offer
$result = $db->query("SELECT * FROM offers LIMIT 1");
$currentOffer = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Management - A World for Kidz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-cover h-screen overflow-y-scroll">
<?php include_once "include/header.php"; ?>

    <?php include_once "include/sidebar.php"; ?>

    <div class="p-4 sm:ml-64">
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex flex-col lg:flex-row lg:gap-12">
                <!-- Offer Form -->
                <form action="" method="POST" class="space-y-4 flex-1">
                    <h3 class="text-2xl font-semibold text-gray-700">Add or Update Offer</h3>

                    <div>
                        <label for="offer_name" class="block text-sm font-medium text-gray-600">Offer Name</label>
                        <input type="text" id="offer_name" name="offer_name" required
                            value="<?= htmlspecialchars($currentOffer['offer_name'] ?? '') ?>"
                            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-400">
                    </div>

                    <div>
                        <label for="discount_percentage" class="block text-sm font-medium text-gray-600">Discount Percentage (%)</label>
                        <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100" step="0.01" required
                            value="<?= htmlspecialchars($currentOffer['discount_percentage'] ?? '') ?>"
                            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-400">
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-600">Start Date</label>
                        <input type="date" id="start_date" name="start_date" required
                            value="<?= htmlspecialchars($currentOffer['start_date'] ?? '') ?>"
                            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-400">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-600">End Date</label>
                        <input type="date" id="end_date" name="end_date" required
                            value="<?= htmlspecialchars($currentOffer['end_date'] ?? '') ?>"
                            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-400">
                    </div>

                    <button type="submit"
                        class="w-full py-2 px-4 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-300">
                        Save Offer
                    </button>
                </form>

                <!-- Active Offer Details -->
                <?php if ($currentOffer): ?>
                    <div class="flex-1 mt-12 lg:mt-0">
                        <h3 class="text-2xl font-semibold text-gray-700">Current Active Offer</h3>
                        <div class="p-4 border rounded-lg bg-gray-50 flex flex-col mt-10 gap-3">
                            <p><strong>Offer Name:</strong> <?= htmlspecialchars($currentOffer['offer_name']) ?></p>
                            <p><strong>Discount:</strong> <?= htmlspecialchars($currentOffer['discount_percentage']) ?>%</p>
                            <p><strong>Start Date:</strong>
                                <?= htmlspecialchars(date("F j, Y", strtotime($currentOffer['start_date']))) ?>
                            </p>
                            <p><strong>End Date:</strong>
                                <?= htmlspecialchars(date("F j, Y", strtotime($currentOffer['end_date']))) ?>
                            </p>
                            <a href="?delete_offer_id=<?= $currentOffer['id'] ?>"
                                class="mt-4 self-end py-2 px-4 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                                Delete Offer
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="flex-1 mt-8 lg:mt-0">
                        <h3 class="text-2xl font-semibold text-gray-700">No Active Offer</h3>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>