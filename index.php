<?php
require_once 'config/database.php';
require_once 'include/login_required.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> - a world for kidz </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-cover h-screen overflow-y-scroll ">
    <!-- Sidebar Toggle Button -->


    <?php include_once "include/header.php"; ?>
    <?php include_once "include/sidebar.php"; ?>

    <!-- Main Content -->


    <div class="p-4 sm:ml-64">
        <div class="md:p-4 rounded-lg">
            <div class="grid grid-cols-1 gap-4 mb-4">
                <div class="flex flex-col gap-3">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <!-- Realtime Sessions Header -->
                            <h3 class="md:text-2xl font-bold text-slate-600">Realtime Sessions (<span id="count_session">0</span>)</h3>

                            <!-- Ping Indicator (Hidden on small screens) -->
                            <span class="relative flex h-3 w-3 -mt-5 hidden sm:flex">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Add Session Button (Hidden on small screens) -->
                            <a href="#ex1" rel="modal:open" class="bg-pink-600 hover:bg-pink-800 text-white px-3 py-2 ml-5 rounded shadow hidden sm:block">
                                Add Session
                            </a>

                            <!-- Modal -->
                            <div id="ex1" class="modal">
                                <div class="mx-auto mt-5">
                                    <h2 class="text-2xl font-semibold mb-6">Add Session</h2>
                                    <?php include "include/insert_session_form.php"; ?>
                                </div>
                            </div>

                            <!-- Refresh Button (Visible only on medium and larger screens) -->
                            <a href="index.php" class="hidden bg-white hover:bg-gray-50 border border-green-600 text-green-600 font-semibold px-3 py-2 rounded shadow md:flex items-center gap-1">
                                <svg class="w-6 h-6 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4" />
                                </svg>
                                <span>Refresh</span>
                            </a>
                        </div>
                    </div>
                    <ul role="list" class="gap-3 grid lg:grid-cols-3 xl:grid-cols-4 md:grid-cols-2 sm:grid-cols-1" id="currentSessions"></ul>
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
            setInterval(updateDateTimeField, 10000);
        });

        $(document).ready(function() {
            // Load sessions data and update the session list
            function loadSessions() {
                $.getJSON('api/get_sessions.php', function(data) {
                    $('#currentSessions').empty();
                    // Display current sessions
                    let length = data.current_sessions.length;
                    $("#count_session").html(length);
                    // Get the current hour
                    const currentHour = new Date().getHours();
                    let greeting;

                    // Determine the greeting based on the current hour
                    if (currentHour >= 5 && currentHour < 12) {
                        greeting = "Good morning";
                    } else if (currentHour >= 12 && currentHour < 17) {
                        greeting = "Good afternoon";
                    } else {
                        greeting = "Good evening";
                    }

                    // Check if there are no sessions and display the message with the greeting
                    if (length === 0) {
                        $('#currentSessions').append(`<li class="col-span-4 h-[300px] justify-center flex flex-col text-gray-600">
                            <span class="md:text-[100px] text-[50px] text-gray-300 font-semibold capitalize">${greeting}</span>
                            <span class="md:text-2xl capitalize text-gray-300 font-medium">no current sessions, let's Start Adding new Session</span>
                        </li>`);
                    }

                    data.current_sessions.forEach(function(session) {
                        const checkInTime = new Date(session.check_in_time);
                        const formattedTime = checkInTime.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        });
                        const isTimeExceeded = hasTimeExceeded(checkInTime, session.assigned_hours);
                        const extendButton = isTimeExceeded ?
                            `
    <div class="flex justify-center items-center w-full gap-1">
        <select class="extend-time-dropdown px-2 text-sm" data-session-id="${session.session_id}">
            <option value="" selected disabled>Extend Time</option>
            <option value="0.5">half Hour</option>
            <option value="1">1 hour</option>
            <option value="2">2 hours</option>
            <option value="3">3 hours</option>
            <option value="4">4 hours</option>
            <option value="5">5 hours</option>
        </select>
    </div>
    ` :"";
            $('#currentSessions').append(`
                    <li class="w-full shadow-md border-gray-300 border ${isTimeExceeded ? "bg-red-100 text-red-800" : "bg-green-100 text-green-800"}">
                        <div class="flex flex-col md:flex-row items-start md:items-center">
                            <div class="flex-1 w-full">
                                <div class="p-2 flex flex-col md:flex-row items-center gap-3">
                                    <div class="flex-1 w-full flex flex-col gap-2">
                                       <div class="flex-1 flex w-full justify-between"> 
                                            <p class="text-sm  flex flex-col  text-gray-900 truncate ">
                                                <span class='font-bold'>${session.name}</span>
                                                <span class='flex ml-0 items-center'>
                                                <svg class="w-[18px] h-[18px] aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z"/>
                                                </svg>
                                                <span>${session.contact}</span>
                                                </span>
                                            </p>
                                            <span>${extendButton}</span>
                                        </div>

                                        <div class="flex-1 flex items-center gap-1 w-full">
                                        <svg class="w-[14px] h-[14px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z"/>
                                            </svg> 
                                            <span>${formattedTime} ${checkInTime.getHours() >= 12 ? 'PM' : 'AM'}</span>
                                            </div>
                                        <p class="text-sm truncate">
                                            Time Left: <span id="timer-${session.session_id}" class="font-bold"></span>
                                        </p>
                                         <div class="flex justify-between flex-row gap-1  text-xs font-semibold">
                                        <div class="flex justify-center items-center gap-1 w-full py-1">
                                            <svg class="size-[14px] text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <span class="truncate">${session.assigned_hours} ${session.assigned_hours == 1 ? "hour" : "hours"}</span>
                                        </div>
                                        <div class="flex justify-center items-center gap-1 w-full hover:bg-gray-200 hover:cursor-pointer  py-1">
                                            <svg class="size-[14px] text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 8h6m-6 4h6m-6 4h6M6 3v18l2-2 2 2 2-2 2 2 2-2 2 2V3l-2 2-2-2-2 2-2-2-2 2-2-2Z"/>
                                            </svg>
                                            <a href="receipt.php?session_id=${session.session_id}">Receipt</a>
                                        </div>
                                        <div class="flex justify-center items-center truncate w-full gap-1 hover:bg-gray-200 hover:cursor-pointer  py-1">
                                            <svg class="w-[14px] h-[14px] text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <button class="check-out-btn" data-session-id="${session.session_id}">Check-out</button>
                                        </div>
                                    </div>
                                    </div>
                                   
                                </div>
                                <!-- Progress bar -->
                                <div class="w-full bg-gray-200 rounded-full h-1  mt-2">
                                    <div class="${isTimeExceeded ? "bg-red-600 " : "bg-green-600"} h-1 rounded-full" id="progress-bar-${session.session_id}" style="width: 100%"></div>
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
                const endTime = new Date(checkInTime.getTime() + assignedHours * 60 * 60 * 1000);


                // Declare timerInterval here to ensure it is accessible throughout the function
                let timerInterval;

                function updateTimer() {
                    const now = new Date();
                    const remainingTime = Math.max(endTime - now, 0);

                    if (remainingTime === 0) {
                        clearInterval(timerInterval); // Clear the interval when time is over
                        document.getElementById(`timer-${sessionId}`).textContent = "Time Over";
                    } else {
                        const hours = Math.floor(remainingTime / (1000 * 60 * 60));
                        const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                        document.getElementById(`timer-${sessionId}`).textContent = `${hours}h ${minutes}m ${seconds}s`;

                        // Update the progress bar
                        const totalDuration = assignedHours * 60 * 60 * 1000;
                        const progressPercentage = ((totalDuration - remainingTime) / totalDuration) * 100;
                        document.getElementById(`progress-bar-${sessionId}`).style.width = `${progressPercentage}%`;
                    }
                }

                updateTimer(); // Initial call to set the timer immediately
                timerInterval = setInterval(updateTimer, 1000); // Assign the interval to the declared variable
            }


            // Checkout button click handler
            $(document).on('click', '.check-out-btn', function() {
                const sessionId = $(this).data('session-id');
                console.log("Session ID for checkout: ", sessionId); // Debugging log

                if (confirm('Are you sure you want to check out?')) { // Confirmation before checkout
                    $.post('api/checkout.php', {
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

            $(document).on("change", ".extend-time-dropdown", function() {
                const sessionId = $(this).data("session-id");
                const extraHours = $(this).val();

                if (extraHours && !isNaN(extraHours) && extraHours > 0) {
                    $.post("api/extra_hours.php", {
                            session_id: sessionId,
                            extra_hours: extraHours
                        })
                        .done(function(response) {
                            const data = JSON.parse(response);
                            loadSessions(); // Reload the session list


                            if (data.success) {
                                alert("Assigned hours extended successfully!");

                                // Update the UI and timer
                                const checkInTime = new Date(); // Assuming current time is the new start point
                                startRealTimeTimer(sessionId, checkInTime, parseInt(extraHours)); // Restart the timer
                            } else {
                                alert("Failed to extend assigned hours.");
                            }
                        })
                        .fail(function() {
                            alert("An error occurred while extending assigned hours.");
                        });
                } else {
                    alert("Please enter a valid number of hours.");
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