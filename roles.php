<?php
require_once 'config/database.php';
require_once 'include/login_required.php';

if ($_SESSION['admin_id'] === 1) {


// Fetch all admins without selecting the 'role' column
$query = "SELECT id, username FROM admin";
$result = $db->query($query);

                    // Handle form submission for admin signup
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $username = $_POST['username'];
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

                        // Check if the username already exists
                        $checkQuery = "SELECT * FROM admin WHERE username = '$username'";
                        $checkResult = $db->query($checkQuery);

                        if ($checkResult->num_rows > 0) {
                            // Username already exists
                            echo "<p class='text-red-500'>Error: Username already exists.</p>";
                        } else {
                            // Insert the new admin record into the database
                            $insertQuery = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";

                            if ($db->query($insertQuery) === TRUE) {
                                // Redirect to refresh the page and clear the form
                                header("Location: " . $_SERVER['PHP_SELF']);
                                exit;
                            } else {
                                echo "<p class='text-red-500'>Error: " . $db->error . "</p>";
                            }
                        }
                    }
                    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup and Records - A World for Kidz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-cover h-screen overflow-y-scroll">

<?php include_once "include/header.php"; ?>


    <?php include_once "include/sidebar.php"; ?>

    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
        <div class="p-4 rounded-lg dark:border-gray-700">
            <h2 class="md:text-2xl font-bold mb-4">Manage Admin Signup and Records</h2>

            <!-- Parallel Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Admin Signup Form -->
                <div class="bg-white p-6 shadow rounded-lg">
                    <h3 class="text-lg font-semibold mb-4">Add New Admin</h3>
                    <form action="" method="POST">
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium">Username</label>
                            <input type="text" id="username" name="username" required class="w-full p-2 border rounded">
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium">Password</label>
                            <input type="password" id="password" name="password" required class="w-full p-2 border rounded">
                        </div>

                        <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Sign Up</button>
                    </form>
                    
                </div>

                <!-- Display Admin Records Table -->
                <div class="bg-white p-6 shadow rounded-lg overflow-auto">
                    <h3 class="text-lg font-semibold mb-4">Admin Records</h3>
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border">ID</th>
                                <th class="py-2 px-4 border">Username</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td class="py-2 px-4 border"><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td class="py-2 px-4 border"><?php echo htmlspecialchars($row['username']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Flowbite JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>
<?php } else {echo "unauthorized";} ?>