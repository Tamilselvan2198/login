<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $father = $_POST['father'];
    $mother = $_POST['mother'];
    $age = $_POST['age'];
    $occupation = $_POST['occupation'];
    $phone = $_POST['phone'];
    $qualification = $_POST['qualification'];
    $address_1 = $_POST['address_1'];
    $address_2 = $_POST['address_2'];
    $address_3 = $_POST['address_3'];
    $address_4 = $_POST['address_4'];
    $address_5 = $_POST['address_5'];
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = file_get_contents($image);
    }

    $stmt = $conn->prepare("INSERT INTO users (fname, lname, phone, qualification, address_1, address_2, address_3, address_4, address_5, email, password, father, mother, age, occupation, img) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssss", $fname, $lname, $phone, $qualification, $address_1, $address_2, $address_3, $address_4, $address_5, $email, $password, $father, $mother, $age, $occupation, $imgContent);
    if ($stmt->execute()) {
        echo "User Added Successfully";
        header("Location: login.php");
        exit();
    } else {
        $error = "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>User Registration</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        *{
            font-family: "Montserrat", sans-serif;
        }
    </style>
</head>

<body class="w-full h-screen flex justify-center items-center bg-slate-700 p-5">
    <form class="w-full max-w-lg flex flex-col justify-center items-center gap-5 bg-white p-6 rounded-lg shadow-lg" action="register.php" method="POST" enctype="multipart/form-data">
        <h2 class="text-3xl">User Register</h2>

        <div class="flex flex-col md:flex-row md:justify-between w-full gap-3">
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="fname" placeholder="First Name" required>
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="lname" placeholder="Last Name" required>
        </div>

        <div class="flex flex-col md:flex-row md:justify-between w-full gap-3">
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="father" placeholder="Father Name" required>
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="mother" placeholder="Mother Name" required>
        </div>

        <div class="flex flex-col md:flex-row md:justify-between w-full gap-3">
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="age" placeholder="Age" required>
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="occupation" placeholder="Occupation" required>
        </div>

        <div class="flex flex-col md:flex-row md:justify-between w-full gap-3">
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="email" name="email" placeholder="Email Id" required>
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="password" name="password" placeholder="Password" required>
        </div>

        <div class="flex flex-col md:flex-row md:justify-between w-full gap-3">
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="phone" placeholder="Contact Number" required>
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="qualification" placeholder="Qualification" required>
        </div>

        <div class="flex flex-col md:flex-row md:justify-between w-full gap-3">
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="address_1" placeholder="House no / Apartment" required>
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="address_2" placeholder="Street Name / Opposite to" required>
        </div>
        <input class="w-full h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="address_3" placeholder="City Name" required>
        <div class="flex flex-col md:flex-row md:justify-between w-full gap-3">
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="address_4" placeholder="District" required>
            <input class="lg:w-1/2 md:w-full flex-1 h-8 border p-4 focus:ring-1 ring-lime-500 outline-none rounded-sm" type="text" name="address_5" placeholder="Pin Code" required>
        </div>

        <div>
                <input type="file" name="image" accept="image/*">
        </div>

        <button class="px-7 py-1.5 bg-lime-800 text-white font-semibold rounded-sm hover:scale-110 transition duration-100" type="submit">Register</button>

        <?php if (isset($error)) {
    echo "<p class='text-red-500 mt-2'>$error</p>";
}
?>
    </form>

</body>
</html>