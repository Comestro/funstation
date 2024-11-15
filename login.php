<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafb;
            background-image: url("images/bg.jpg");     
            background-size: cover;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-card {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .logo {
            width: 300px; /* Adjust logo size */
            margin: 0 auto 1rem auto;
        }

        

        .login-button {
            background-color: #3b82f6; /* Tailwind blue */
            color: white;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #2563eb; /* Darker blue on hover */
        }

        
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card p-5">
            <img src="images/logo.png" alt="Logo" class="logo">
            <form action="function/process_admin_login.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter your username">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter your password">
                </div>
                <button type="submit" class="w-full p-2 login-button rounded-md">Login</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</body>

</html>
