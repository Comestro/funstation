<?php 

include_once "config/database.php";
require_once 'include/login_required.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Session | <?php echo htmlspecialchars($title); ?>  - a world for kidz</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Sidebar Toggle Button -->
    <?php include_once "include/header.php"; ?>

    <?php include_once "include/sidebar.php"; ?>
    <div class="p-4 h-screen sm:ml-64">
        <div class="p-4  w-full rounded-lg dark:border-gray-700">
            <div class="mx-auto mt-5 md:w-1/2">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <h3 class="md:text-2xl font-bold text-gray-600">Add New Sessions</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="index.php" class="bg-white hover:bg-gray-50 border border-green-600 text-green-600 font-semibold px-3 py-2 rounded shadow flex items-center gap-1">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 12h14M5 12l4-4m-4 4 4 4" />
                            </svg>

                            <span class="truncate">Go Back</span>

                        </a>
                    </div>
                </div>
                <?php include "include/insert_session_form.php"; ?>
            </div>
        </div>
    </div>


    <!-- JavaScript to set current date and time in the check-in field -->
    <!-- JavaScript to set current date and time in the check-in field -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkInField = document.getElementById('check_in_time');

            // Function to get current date and time in 'YYYY-MM-DDTHH:MM' format
            function getCurrentDateTime() {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                return `${year}-${month}-${day}T${hours}:${minutes}`;
            }

            // Update the check-in field every minute
            function updateDateTimeField() {
                checkInField.value = getCurrentDateTime();
            }

            // Set the current date and time initially
            updateDateTimeField();

            // Update every minute (60000 milliseconds)
            setInterval(updateDateTimeField, 60000);
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</body>

</html>