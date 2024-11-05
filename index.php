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
                <div>
                    <h3 class="text-xl font-semibold mb-3 text-blue-800">Realtime Sessions</h3>
                    <ul role="list" class="gap-3 grid lg:grid-cols-4 grid-cols-1" id="currentSessions"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        
        $(document).ready(function() {
    // Load sessions data and update the session list
    function loadSessions() {
        $.getJSON('get_sessions.php', function(data) {
            $('#currentSessions').empty();

            // Display current sessions
            data.current_sessions.forEach(function(session) {
                const checkInTime = new Date(session.check_in_time);
                const formattedTime = checkInTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
                const isTimeExceeded = hasTimeExceeded(checkInTime, session.assigned_hours);

                $('#currentSessions').append(`
                    <li class="shadow-md border ${isTimeExceeded ? "bg-red-100 text-red-800 border-red-400" : "bg-green-100 text-green-800 border-green-400"}">
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