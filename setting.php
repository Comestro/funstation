<?php
// Start session and include the database connection
session_start();
require_once 'database.php'; // Ensure you have your mysqli database connection here

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
        'logo' => '',
        'email' => '',
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Zone Check-In System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-cover h-screen overflow-y-scroll ">
    <!-- Sidebar Toggle Button -->
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <?php include_once "sidebar.php"; ?>

    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Game Zone Settings</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <!-- Hourly Charge -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Hourly Charge</h3>
        <div id="hourly_charge_display" class="text-gray-600 mb-4">₹<?php echo htmlspecialchars($settings['hourly_charge']); ?></div>
        <form action="update_settings.php" method="POST" id="hourly_charge_form" class="hidden">
            <input type="number" name="hourly_charge" value="<?php echo htmlspecialchars($settings['hourly_charge']); ?>" class="border p-2 w-full mb-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
        <button onclick="toggleEdit('hourly_charge')" class="text-blue-500 mt-2">Change</button>
    </div>

    <!-- Contact -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Contact</h3>
        <div id="contact_display" class="text-gray-600 mb-4"><?php echo htmlspecialchars($settings['contact']); ?></div>
        <form action="update_settings.php" method="POST" id="contact_form" class="hidden">
            <input type="text" name="contact" value="<?php echo htmlspecialchars($settings['contact']); ?>" class="border p-2 w-full mb-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
        <button onclick="toggleEdit('contact')" class="text-blue-500 mt-2">Change</button>
    </div>

    <!-- Business Name -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Business Name</h3>
        <div id="business_name_display" class="text-gray-600 mb-4"><?php echo htmlspecialchars($settings['business_name']); ?></div>
        <form action="update_settings.php" method="POST" id="business_name_form" class="hidden">
            <input type="text" name="business_name" value="<?php echo htmlspecialchars($settings['business_name']); ?>" class="border p-2 w-full mb-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
        <button onclick="toggleEdit('business_name')" class="text-blue-500 mt-2">Change</button>
    </div>

    <!-- Address -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Address</h3>
        <div id="address_display" class="text-gray-600 mb-4"><?php echo htmlspecialchars($settings['address']); ?></div>
        <form action="update_settings.php" method="POST" id="address_form" class="hidden">
            <textarea name="address" class="border p-2 w-full mb-2"><?php echo htmlspecialchars($settings['address']); ?></textarea>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
        <button onclick="toggleEdit('address')" class="text-blue-500 mt-2">Change</button>
    </div>

    <!-- Logo -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Logo</h3>
        <img src="<?php echo htmlspecialchars($settings['logo']); ?>" alt="Logo" class="w-16 h-16 mb-4">
        <form action="update_settings.php" method="POST" enctype="multipart/form-data" id="logo_form" class="hidden">
            <input type="file" name="logo" class="border p-2 w-full mb-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
        <button onclick="toggleEdit('logo')" class="text-blue-500 mt-2">Change</button>
    </div>

    <!-- Email -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Email</h3>
        <div id="email_display" class="text-gray-600 mb-4"><?php echo htmlspecialchars($settings['email']); ?></div>
        <form action="update_settings.php" method="POST" id="email_form" class="hidden">
            <input type="email" name="email" value="<?php echo htmlspecialchars($settings['email']); ?>" class="border p-2 w-full mb-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
        <button onclick="toggleEdit('email')" class="text-blue-500 mt-2">Change</button>
    </div>

    <!-- Password -->
    <div class="bg-white rounded-lg shadow-md p-6 col-span-1 sm:col-span-2 md:col-span-3">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Change Password</h3>
        <form action="update_settings.php" method="POST" id="password_form">
            <input type="password" name="password" class="border p-2 w-full mb-2" placeholder="New password">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Change Password</button>
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
</body>

</html>