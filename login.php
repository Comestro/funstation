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
            padding:10px;
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

    <div class="login-container p-5">
   
        <div class="login-card ">
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
            <div class="mt-3">
        <div class="flex flex-col items-center justify-center mt-[120px]">
            <p class="text-center text-gray-600 text-xs font-semibold mb-2">Powered By </p>
            <a href="https://www.comestro.com" target="_blank"><img src="images/comestro_logo.png"
            alt="Comestro Logo" class=" h-9 object-content "></a>
        </div>
    </div>
        </div>
    </div>
   
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</body>

</html>
