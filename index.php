<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Zone Check-In System</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        <div class="p-4  rounded-lg dark:border-gray-700">
            <div class="grid grid-cols-1 gap-4 mb-4">
                <div class="flex flex-col gap-3">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <!-- Realtime Sessions Header -->
                            <h3 class="text-2xl font-bold text-slate-600">Realtime Sessions (<span id="count_session">0</span>)</h3>

                            <!-- Ping Indicator -->
                            <span class="relative flex h-3 w-3 -mt-5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="#ex1" rel="modal:open" class="bg-pink-600 hover:bg-pink-800 text-white px-3 py-2 rounded shadow">Add Session</a>
                            <div id="ex1" class="modal">
                                <div class="mx-auto mt-5">
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
                            <a href="index.php" class="bg-white hover:bg-gray-50 border border-green-600 text-green-600 font-semibold px-3 py-2 rounded shadow flex items-center gap-1">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4" />
                                </svg>
                                <span>Refresh</span>

                            </a>
                        </div>
                    </div>
                    <ul role="list" class="gap-3 grid lg:grid-cols-4 grid-cols-1" id="currentSessions"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
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

        $(document).ready(function() {
            // Load sessions data and update the session list
            function loadSessions() {
                $.getJSON('get_sessions.php', function(data) {
                    $('#currentSessions').empty();
                    $("#count_session").html(data.current_sessions.length);
                    // Display current sessions
                    data.current_sessions.forEach(function(session) {
                        const checkInTime = new Date(session.check_in_time);
                        const formattedTime = checkInTime.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        });
                        const isTimeExceeded = hasTimeExceeded(checkInTime, session.assigned_hours);

                        $('#currentSessions').append(`
                    <li class="shadow-md border-gray-300 border ${isTimeExceeded ? "bg-red-100 text-red-800" : "bg-green-100 text-green-800"}">
                        <div class="flex items-center">
                            <div class="flex-1 min-w-0">
                                <div class="py-2 px-3 flex items-start gap-3">
                                    <div class="flex-1 flex flex-col gap-2">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            ${session.name}
                                        </p>
                                        <p title="${checkInTime.toLocaleString()}" class="cursor-help text-sm flex items-center gap-1 truncate">
                                            <svg class="w-[14px] h-[14px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z"/>
                                            </svg> ${formattedTime} ${checkInTime.getHours() >= 12 ? 'PM' : 'AM'}
                                        </p>
                                        <p class="text-sm truncate dark:text-gray-400">
                                            Time Left: <span id="timer-${session.session_id}" class="font-bold"></span>
                                        </p>
                                    </div>
                                    <div class="flex flex-col gap-1 items-start text-xs font-semibold">
                                        <div class="flex items-center gap-1 px-2 py-1">
                                            <svg class="size-[14px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <span class="truncate">${session.assigned_hours} ${session.assigned_hours == 1 ? "hour" : "hours"}</span>
                                        </div>
                                        <div class="flex items-center gap-1 w-full hover:bg-gray-200 hover:cursor-pointer px-2 py-1">
                                            <svg class="size-[14px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 8h6m-6 4h6m-6 4h6M6 3v18l2-2 2 2 2-2 2 2 2-2 2 2V3l-2 2-2-2-2 2-2-2-2 2-2-2Z"/>
                                            </svg>
                                            <a href="receipt.php?session_id=${session.session_id}" class="open-receipt-modal" data-session-id="${session.session_id}" rel="modal:open">Receipt</a>
                                        </div>
                                        <div class="flex items-center truncate w-full gap-1 hover:bg-gray-200 hover:cursor-pointer px-2 py-1">
                                            <svg class="w-[14px] h-[14px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <button class="check-out-btn" data-session-id="${session.session_id}">Check-out</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Progress bar -->
                                <div class="w-full bg-gray-200 rounded-full h-1 dark:bg-gray-700 mt-2">
                                    <div class="${isTimeExceeded ? "bg-red-600" : "bg-green-600"} h-1 rounded-full" id="progress-bar-${session.session_id}" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </li>
                `);

                        // Start the real-time timer and progress bar for each session
                        startRealTimeTimer(session.session_id, checkInTime, session.assigned_hours);
                    });
                });

            }

            // Check if the session has exceeded the assigned time
            function hasTimeExceeded(checkInTime, assignedHours) {
                const elapsedTime = Math.floor((new Date() - checkInTime) / (1000 * 60 * 60));
                return elapsedTime >= assignedHours;
            }

            // Real-time timer and progress bar updater for each session
            function startRealTimeTimer(sessionId, checkInTime, assignedHours) {
                const timerElement = document.getElementById(`timer-${sessionId}`);
                const progressBar = document.getElementById(`progress-bar-${sessionId}`);
                const totalMinutes = assignedHours * 60;

                setInterval(() => {
                    const now = new Date();
                    const elapsedMinutes = Math.floor((now - checkInTime) / (1000 * 60));
                    const remainingMinutes = totalMinutes - elapsedMinutes;

                    // Update the timer display
                    if (remainingMinutes > 0) {
                        timerElement.textContent = `${Math.floor(remainingMinutes / 60)}h ${remainingMinutes % 60}m left`;
                        progressBar.style.width = `${(elapsedMinutes / totalMinutes) * 100}%`;
                    } else {
                        timerElement.textContent = "Time exceeded!";
                        timerElement.classList.add("text-red-600");
                        progressBar.style.width = "100%";
                    }
                }, 1000);
            }

            // Checkout button click handler
            $(document).on('click', '.check-out-btn', function() {
                const sessionId = $(this).data('session-id');
                console.log("Session ID for checkout: ", sessionId); // Debugging log

                if (confirm('Are you sure you want to check out?')) { // Confirmation before checkout
                    $.post('checkout.php', {
                        session_id: sessionId
                    }, function(response) {
                        console.log(response); // Log the response for debugging
                        if (response.success) {
                            alert('Successfully checked out!');
                            loadSessions(); // Reload the session list
                        } else {
                            alert('Error checking out: ' + response.message);
                        }
                    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
                        alert('Request failed: ' + textStatus + ', ' + errorThrown);
                    });
                }
            });

            // Initial load and periodic refresh
            loadSessions();
            setInterval(loadSessions, 60000); // Refresh every 60 seconds
        });
    </script>

    <!-- Flowbite JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>