<?php
require_once 'config/database.php';
// require_once 'include/login_required.php';

// Handle form submission and insert offer into the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $offer_name = $_POST['offer_name'];
    $discount_percentage = $_POST['discount_percentage'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Insert offer into the database
    $stmt = $db->prepare("INSERT INTO offers (offer_name, discount_percentage, start_date, end_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $offer_name, $discount_percentage, $start_date, $end_date);
    $stmt->execute();
    $stmt->close();
}

// Fetch all offers to display
$offers = [];
$result = $db->query("SELECT * FROM offers ORDER BY start_date DESC");
if ($result) {
    $offers = $result->fetch_all(MYSQLI_ASSOC);
    $result->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Management - A World for Kidz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-cover h-screen overflow-y-scroll ">
    <!-- Sidebar Toggle Button -->
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> 
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <?php include_once "include/sidebar.php"; ?>

    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="grid grid-cols-1 gap-6 mb-6">
                <!-- Offer Form -->
                <form action="" method="POST" class="space-y-4">
                    <h3 class="text-2xl font-semibold text-gray-700">Add New Offer</h3>
                    
                    <div>
                        <label for="offer_name" class="block text-sm font-medium text-gray-600">Offer Name</label>
                        <input type="text" id="offer_name" name="offer_name" required
                               class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-400" 
                               placeholder="Enter offer name">
                    </div>

                    <div>
                        <label for="discount_percentage" class="block text-sm font-medium text-gray-600">Discount Percentage (%)</label>
                        <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100" step="0.01" required
                               class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-400" 
                               placeholder="Enter discount percentage">
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-600">Start Date</label>
                        <input type="date" id="start_date" name="start_date" required
                               class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-400">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-600">End Date</label>
                        <input type="date" id="end_date" name="end_date" required
                               class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-400">
                    </div>

                    <button type="submit" 
                            class="w-full py-2 px-4 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-300">
                        Save Offer
                    </button>
                </form>

                <!-- Display Offers -->
                <h3 class="text-2xl font-semibold text-gray-700 mt-8">Current Offers</h3>
                <div class="overflow-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Offer Name</th>
                                <th class="py-3 px-6 text-left">Discount (%)</th>
                                <th class="py-3 px-6 text-left">Start Date</th>
                                <th class="py-3 px-6 text-left">End Date</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm font-light">
                            <?php foreach ($offers as $offer): ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($offer['offer_name']); ?></td>
                                    <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($offer['discount_percentage']); ?>%</td>
                                    <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($offer['start_date']); ?></td>
                                    <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($offer['end_date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Flowbite JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>
