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
</head>

<body>
    <!-- Sidebar Toggle Button -->
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <?php include_once "sidebar.php"; ?>

    <div class="p-4 sm:ml-64">
    <div class="p-4 h-screen overflow-y-scroll border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <div class="container mx-auto mt-5">
            <h2 class="text-2xl font-semibold mb-6">Add Session</h2>
            <form action="add_session.php" method="POST" class="space-y-4">
                <div class="form-group">
                    <label for="name" class="block text-sm font-medium text-gray-700">Kid's Name:</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="form-group">
                    <label for="age" class="block text-sm font-medium text-gray-700">Kid's Age:</label>
                    <input type="number" id="age" name="age" min="1" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="form-group">
                    <label for="check_in_time" class="block text-sm font-medium text-gray-700">Check-in Time:</label>
                    <input type="datetime-local" id="check_in_time" name="check_in_time" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="form-group">
                    <label for="assigned_hours" class="block text-sm font-medium text-gray-700">Assigned Hours:</label>
                    <input type="number" id="assigned_hours" name="assigned_hours" min="1" max="24" placeholder="Optional" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Add Session</button>
            </form>
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


</body>

</html>