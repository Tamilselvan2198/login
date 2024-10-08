<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];

            header("Location: profile.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        *{
            font-family: "Montserrat", sans-serif;
        }
    </style>
</head>
<body class="flex items-center justify-center h-screen bg-gradient-to-r from-pink-300 to-sky-300">
    <form class="bg-white shadow-lg rounded-lg p-8 w-96 space-y-6" action="login.php" method="POST">
        <h2 class="text-3xl text-center text-gray-800">User Login</h2>
        <div>
            <input class="w-full h-10 border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-blue-300 p-2" type="email" name="email" placeholder="Enter Email Id" required>
        </div>
        <div>
            <input class="w-full h-10 border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-blue-300 p-2" type="password" name="password" placeholder="Enter Password" required>
        </div>
        <button class="w-full h-8 bg-lime-800 text-white rounded-sm transition duration-100 transform hover:scale-105" type="submit">Login</button>
        <?php if (isset($error)) echo "<p class='text-red-500 text-center'>$error</p>"; ?>
        <p class="text-sm text-center">Don't Have An Account! Create New!</p>
        <button  class="w-full h-8 bg-lime-800 text-white rounded-sm transition duration-100 transform hover:scale-105">
            <a class="text-white hover:underline ml-3 bg-lime-800 px-7 py-1.5 rounded-sm" href="./register.php">Register here
            </a>
        </button>
    </form>
</body>
</html>