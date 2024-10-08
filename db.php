<?php
$host = 'localhost'; // Your database host
$db = 'user_management'; // Your database name
$user = 'rock'; // Your database username
$pass = '123'; // Your database password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
