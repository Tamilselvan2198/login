<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user information from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>User Profile</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        *{
            font-family: "Montserrat", sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 p-5">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-lg">

        <div class="flex justify-center items-center gap-10 mb-4 border p-3">
        <?php
            echo '<img src="data:image/jpeg;base64,' . base64_encode($user['img']) . '" alt="Uploaded Image" class="w-16 h-16 rounded-full">';
        ?>
        <h2 class="text-2xl">Welcome, <?php echo htmlspecialchars($user['fname'] . " " . $user['lname']); ?>!</h2>

        </div>

        <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-500">
                    <th class="text-white font-light border border-gray-300 px-4 py-2">Person</th>
                    <th class="text-white font-light border border-gray-300 px-4 py-2">Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">Name</td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($user['fname'] . " " . $user['lname']); ?></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">Father Name</td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($user['father']); ?></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">Mother Name</td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($user['mother']); ?></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">Age</td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($user['age']); ?></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">Occupation</td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($user['occupation']); ?></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">Email</td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">User ID</td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($user['id']); ?></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">Phone No</td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($user['phone']); ?></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">Qualification</td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($user['qualification']); ?></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">Address</td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($user['address_1'] . ", " . $user['address_2'] . ", " . $user['address_3'] . ", " . $user['address_4'] . " - " . $user['address_5']); ?></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">Role</td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo $user['is_admin'] ? 'Admin' : 'User'; ?></td>
                </tr>
            </tbody>
        </table>

        <div class="flex text-center gap-5 mt-4">
            <a href="logout.php" class="text-white hover:underline px-7 py-1.5 rounded-sm  bg-lime-800">Logout</a>
            <?php if ($_SESSION['is_admin']): ?>
                <a href="admin.php" class="text-white hover:underline px-7 py-1.5 rounded-sm  bg-lime-800">Go to Admin Panel</a>
            <?php endif;?>
        </div>
    </div>
</body>
</html>