<?php include_once "config/database.php"; 

require_once 'include/login_required.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage checkout Sessions | <?php echo htmlspecialchars($title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php include_once "include/header.php"; ?>


    <?php include_once "include/sidebar.php"; ?>

    <!-- Main Content -->
    <div class="p-4 md:h-screen  sm:ml-64">
        <div class="p-4 rounded-lg dark:border-gray-700">
            <div class="grid grid-cols-1 gap-4 mb-4">
                <div class="flex md:flex-row flex-col md:justify-between md:items-center ">
                    <h3 class="text-xl font-semibold md:mb-0 mb-4">Checkout Sessions</h3>
                    <div class="flex flex-col md:items-center md:flex-row justify-between  gap-2">
                      
                        <!-- search work -->
                        <div class="flex">
                            <input type="text" id="searchTerm" placeholder="Search by Kid's Name" class="border rounded-s-lg border-gray-300 px-2 py-1 w-full sm:w-auto" />
                            <button id="searchBtn" class="bg-blue-500 text-white px-2 py-2 rounded-e-lg">Search</button>
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


                <div class="overflow-x-scroll">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
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
    </div>

    <!-- JavaScript -->
    <script>
    $(document).ready(function() {
        // Load sessions data and update the session list
        function loadSessions(filter = 'today', search = '') {
            $.getJSON('api/get_sessions.php', {
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
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    ${session.contact}
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
                                    <a  href="receipt.php?session_id=${session.session_id}" class="text-blue-600 hover:text-blue-800">Receipt</a>
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