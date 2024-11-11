<?php include "config/database.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics | <?php echo htmlspecialchars($title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <!-- Sidebar Toggle Button -->
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <?php include_once "include/sidebar.php"; ?>
    <div class="p-4 h-screen  sm:ml-64">
        <div class="p-4 rounded-lg dark:border-gray-700">
      
        <h1 class="text-2xl font-semibold mb-6 text-blue-800">Game Zone Report</h1>

        <!-- Chart Containers -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Daily Check-ins Chart -->
            <div class="bg-white shadow-md rounded p-4">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Daily Check-ins</h2>
                <canvas id="dailyCheckinsChart"></canvas>
            </div>

            <!-- Revenue Report Chart -->
            <div class="bg-white shadow-md rounded p-4">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Revenue Report</h2>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
    </div>
    
    <script>
        $(document).ready(function() {
            // Fetch data from the server
            $.ajax({
                url: 'api/get_report_data.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Load data into charts
                    loadCharts(response);
                },
                error: function(error) {
                    console.error("Error fetching report data:", error);
                }
            });

            function loadCharts(data) {
                // Daily Check-ins Chart
                const dailyCheckinsCtx = document.getElementById('dailyCheckinsChart').getContext('2d');
                new Chart(dailyCheckinsCtx, {
                    type: 'bar',
                    data: {
                        labels: data.dailyCheckins.labels,
                        datasets: [{
                            label: 'Daily Check-ins',
                            data: data.dailyCheckins.data,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Revenue Report Chart
                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: data.revenue.labels,
                        datasets: [{
                            label: 'Revenue (in INR)',
                            data: data.revenue.data,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</body>

</html>
