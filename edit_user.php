<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $father = $_POST['father'];
    $mother = $_POST['mother'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $occupation = $_POST['occupation'];
    $address_1 = $_POST['address_1'];
    $address_2 = $_POST['address_2'];
    $address_3 = $_POST['address_3'];
    $address_4 = $_POST['address_4'];
    $address_5 = $_POST['address_5'];
    $is_admin = $_POST['is_admin'];
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = file_get_contents($image);
    }

    $stmt = $conn->prepare("UPDATE users SET fname = ?, lname = ?, email = ?, phone = ?, address_1 = ?, address_2 = ?, address_3 = ?, address_4 = ?, address_5 = ?, is_admin = ?, father = ?, mother = ?, age = ?, occupation = ?, img = ? WHERE id = ?");
    $stmt->bind_param("sssssssssssssssi", $fname, $lname, $email, $phone, $address_1, $address_2, $address_3, $address_4, $address_5, $is_admin, $father, $mother, $age, $occupation, $imgContent, $id);
    $stmt->execute();

    header("Location: admin.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit User</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        *{
            font-family: "Montserrat", sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="w-1/2 container mx-auto p-6">
        <h2 class="text-xl mb-4">Edit User</h2>
        <form action="edit_user.php" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
            <table class="min-w-full divide-y divide-gray-200">
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="image" class="block text-sm font-medium text-gray-700">Profile Image</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="file" id="image" name="image" value="<?php echo htmlspecialchars($user['img']); ?>" required class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="fname" class="block text-sm font-medium text-gray-700">First Name</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($user['fname']); ?>" required class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($user['lname']); ?>" required class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="father" class="block text-sm font-medium text-gray-700">Father Name</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="father" name="father" value="<?php echo htmlspecialchars($user['father']); ?>" required class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="mother" class="block text-sm font-medium text-gray-700">Mother Name</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="mother" name="mother" value="<?php echo htmlspecialchars($user['mother']); ?>" required class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="email" class="block text-sm font-medium text-gray-700">Email Id</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="age" class="block text-sm font-medium text-gray-700">Age</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="age" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" required class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="occupation" class="block text-sm font-medium text-gray-700">Occupation</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="occupation" name="occupation" value="<?php echo htmlspecialchars($user['occupation']); ?>" required class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="address_1" class="block text-sm font-medium text-gray-700">Address Line-1</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="address_1" name="address_1" value="<?php echo htmlspecialchars($user['address_1']); ?>" required class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="address_2" class="block text-sm font-medium text-gray-700">Address Line-2</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="address_2" name="address_2" value="<?php echo htmlspecialchars($user['address_2']); ?>" class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="address_3" class="block text-sm font-medium text-gray-700">Address Line-3</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="address_3" name="address_3" value="<?php echo htmlspecialchars($user['address_3']); ?>" class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="address_4" class="block text-sm font-medium text-gray-700">Address Line-4</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="address_4" name="address_4" value="<?php echo htmlspecialchars($user['address_4']); ?>" class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="address_5" class="block text-sm font-medium text-gray-700">Address Line-5</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="address_5" name="address_5" value="<?php echo htmlspecialchars($user['address_5']); ?>" class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-1 whitespace-nowrap"><label for="is_admin" class="block text-sm font-medium text-gray-700">Make Admin</label></td>
                        <td class="px-6 py-1 whitespace-nowrap"><input type="text" id="is_admin" name="is_admin" value="<?php echo htmlspecialchars($user['is_admin']); ?>" class="border-gray-300 rounded-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-300 focus:ring-opacity-50 outline-none w-full p-2"></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="text-white hover:underline px-7 py-1.5 rounded-sm  bg-lime-800">Update</button>
        </form>
    </div>
</body>
</html>