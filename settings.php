<?php
// Start session and include the database connection
session_start();
require_once 'config/database.php'; // Ensure you have your mysqli database connection here

// Fetch settings from the database
$query = "SELECT * FROM settings WHERE id = 1 LIMIT 1";
$result = $db->query($query);

if ($result && $result->num_rows > 0) {
    $settings = $result->fetch_assoc();
} else {
    $settings = [
        'hourly_charge' => '',
        'contact' => '',
        'business_name' => '',
        'address' => '',
        'gst' => '',
        'email' => '',
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | 8<?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-cover h-screen overflow-y-scroll ">
<?php include_once "include/header.php"; ?>

    <?php include_once "include/sidebar.php"; ?>

    <!-- Main Content -->
    <div class="p-4 sm:ml-64 mt-5">
        <h1 class="text-3xl font-bold text-gray-800 mb-6"><?= $title; ?> Settings</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Hourly Charge -->
            <div class="border border-pink-700 rounded-lg shadow-md p-6">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Hourly Charge</h3>
                    <button onclick="toggleEdit('hourly_charge')" class="bg-pink-700 text-white px-3 py-2 text-sm rounded">Change</button>
                </div>
                <div id="hourly_charge_display" class="text-gray-600 text-3xl">₹<?php echo htmlspecialchars($settings['hourly_charge']); ?></div>

                <form action="function/update_settings.php" method="POST" id="hourly_charge_form" class="hidden mt-2 flex">
                    <input type="number" name="hourly_charge" value="<?php echo htmlspecialchars($settings['hourly_charge']); ?>" class="border border-pink-500 p-2 w-full">
                    <button type="submit" class="bg-pink-800 hover:bg-pink-900 text-white px-4 py-2">Save</button>
                </form>
            </div>

            <!-- Contact -->
            <div class="border border-pink-700 rounded-lg shadow-md p-6">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Contact</h3>
                    <button onclick="toggleEdit('contact')" class="bg-pink-700 text-white px-3 py-2 text-sm rounded">Change</button>
                </div>
                <div id="contact_display" class="text-gray-600"><?php echo htmlspecialchars($settings['contact']); ?></div>
                <form action="function/update_settings.php" method="POST" id="contact_form" class="hidden mt-2">
                    <input type="text" name="contact" value="<?php echo htmlspecialchars($settings['contact']); ?>" class="border border-pink-500 p-2 w-full">
                    <button type="submit" class="bg-pink-800 hover:bg-pink-900 text-white px-4 py-2">Save</button>
                </form>
            </div>

            <!-- Business Name -->
            <div class="border border-pink-700 rounded-lg shadow-md p-6">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Business Name</h3>
                    <button onclick="toggleEdit('business_name')" class="bg-pink-700 text-white px-3 py-2 text-sm rounded">Change</button>
                </div>
                <div id="business_name_display" class="text-gray-600"><?php echo htmlspecialchars($settings['business_name']); ?></div>
                <form action="function/update_settings.php" method="POST" id="business_name_form" class="hidden mt-2">
                    <input type="text" name="business_name" value="<?php echo htmlspecialchars($settings['business_name']); ?>" class="border border-blue-500 p-2 w-full">
                    <button type="submit" class="bg-pink-700 hover:bg-blue-800 text-white px-4 py-2">Save</button>
                </form>
            </div>

            <!-- Address -->
            <div class="border border-pink-700 rounded-lg shadow-md p-6">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Address</h3>
                    <button onclick="toggleEdit('address')" class="bg-pink-700 text-white px-3 py-2 text-sm rounded">Change</button>
                </div>
                <div id="address_display" class="text-gray-600"><?php echo htmlspecialchars($settings['address']); ?></div>
                <form action="function/update_settings.php" method="POST" id="address_form" class="hidden mt-2">
                    <textarea name="address" class="border border-blue-500 p-2 w-full"><?php echo htmlspecialchars($settings['address']); ?></textarea>
                    <button type="submit" class="bg-pink-700 hover:bg-blue-800 text-white px-4 py-2">Save</button>
                </form>
            </div>

            <!-- Email -->
            <div class="border border-pink-700 rounded-lg shadow-md p-6">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Email</h3>
                    <button onclick="toggleEdit('email')" class="bg-pink-700 text-white px-3 py-2 text-sm rounded">Change</button>
                </div>
                <div id="email_display" class="text-gray-600"><?php echo htmlspecialchars($settings['email']); ?></div>
                <form action="function/update_settings.php" method="POST" id="email_form" class="hidden mt-2">
                    <input type="email" name="email" value="<?php echo htmlspecialchars($settings['email']); ?>" class="border border-blue-500 p-2 w-full">
                    <button type="submit" class="bg-pink-700 hover:bg-blue-800 text-white px-4 py-2">Save</button>
                </form>
            </div>

            <!-- Password -->
            <div class="border border-pink-700 rounded-lg shadow-md p-6 col-span-1 sm:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Change Password</h3>
                <form action="function/update_settings.php" method="POST" id="password_form">
                    <input type="password" name="password" class="border border-blue-500 p-2 w-full mb-2" placeholder="New password">
                    <button type="submit" class="bg-pink-700 hover:bg-blue-800 text-white px-4 py-2 w-full">Change Password</button>
                </form>
            </div>

            <!-- GST -->
            <div class="border border-pink-700 rounded-lg shadow-md p-6">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">GST (18%)</h3>
                    <button onclick="toggleEdit('gst')" class="bg-pink-700 text-white px-3 py-2 text-sm rounded">Change</button>
                </div>
                <div id="gst_display" class="text-gray-600"><?php echo $settings['gst']; ?></div>
                <form action="function/update_settings.php" method="POST" id="gst_form" class="hidden mt-2 flex">
                    <input type="text" name="gst" value="<?php echo $settings['gst']; ?>" class="border border-pink-500 p-2 w-full">
                    <button type="submit" class="bg-pink-800 hover:bg-pink-900 text-white px-4 py-2">Save</button>
                </form>
            </div>


        </div>
    </div>

    <script>
        function toggleEdit(field) {
            // Toggle visibility of the form for each field
            const form = document.getElementById(field + '_form');
            const display = document.getElementById(field + '_display');
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                display.classList.add('hidden');
            } else {
                form.classList.add('hidden');
                display.classList.remove('hidden');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</body>

</html>