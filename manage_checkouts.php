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

    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
        <div class="p-4 h-screen overflow-y-scroll border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
            <div class="grid grid-cols-1 gap-4 mb-4">
                <div class="flex justify-between items-center ">
                    <h3 class="text-xl font-semibold">Checkout Sessions</h3>
                    <div class="flex items-center gap-2">
                      
                        <!-- search work -->
                        <div class="flex">
                            <input type="text" id="searchTerm" placeholder="Search by Kid's Name" class="border rounded-s-lg border-gray-300 px-2 py-1" />
                            <button id="searchBtn" class="bg-blue-500 text-white px-2 py-1 rounded-e-lg">Search</button>
                        </div>
                        <!-- filter work -->
                        <select id="dateFilter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2">
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last7days">Last 7 Days</option>
                            <option value="thismonth">This Month</option>
                            <option value="lastmonth">Last Month</option>
                        </select>
                    </div>
                </div>


                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-In Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Hours</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-Out Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="checkoutSessions" class="bg-white divide-y divide-gray-200">
                        <!-- Session rows will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
    $(document).ready(function() {
        // Load sessions data and update the session list
        function loadSessions(filter = 'today', search = '') {
            $.getJSON('get_sessions.php', {
                filter: filter,
                search: search
            }, function(data) {
                $('#checkoutSessions').empty();

                // Display current sessions
                data.checked_out_sessions.forEach(function(session) {
                    const checkInTime = new Date(session.check_in_time);
                    const checkOutTime = new Date(session.check_out_time);

                    // Calculate total duration in minutes
                    const durationMillis = checkOutTime - checkInTime;
                    const totalMinutes = Math.floor(durationMillis / (1000 * 60));
                    const totalHours = Math.floor(totalMinutes / 60);
                    const remainingMinutes = totalMinutes % 60;
                    const totalDuration = `${totalHours}h ${remainingMinutes}m`;

                    $('#checkoutSessions').append(`
                        <tr class="bg-white text-black">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    ${session.name}
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm flex items-center gap-1 truncate">
                                    ${checkInTime.toLocaleString()}
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium">${session.assigned_hours} ${session.assigned_hours == 1 ? "hour" : "hours"}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm flex items-center gap-1 truncate">
                                    ${checkOutTime.toLocaleString()}
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm flex items-center gap-1 truncate">
                                    ${totalDuration}
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex gap-2">
                                    <a href="receipt.php?session_id=${session.session_id}" class="text-blue-600 hover:text-blue-800">Receipt</a>
                                </div>
                            </td>
                        </tr>
                    `);
                });
            });
        }

        // Search button click handler
        $('#searchBtn').on('click', function() {
            const searchTerm = $('#searchTerm').val().trim();
            const filter = $('#dateFilter').val(); // Get the current filter value
            loadSessions(filter, searchTerm); // Load sessions with the current filter and search term
        });

        // Date filter change handler
        $('#dateFilter').on('change', function() {
            const selectedFilter = $(this).val();
            const searchTerm = $('#searchTerm').val().trim(); // Get current search term
            loadSessions(selectedFilter, searchTerm); // Load sessions with the selected filter and current search term
        });

        // Initial load and periodic refresh
        loadSessions(); // Load sessions without any filters initially
    });

    </script>

    <!-- Flowbite JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>