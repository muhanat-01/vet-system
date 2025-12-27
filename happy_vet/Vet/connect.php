<?php
$host = "localhost";  // Change this if your database is hosted remotely
$user = "root";       // Your MySQL username (default is 'root' for XAMPP)
$pass = "";           // Your MySQL password (default is empty for XAMPP)
$db = "vet_system"; // Your database name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
