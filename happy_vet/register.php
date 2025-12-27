<?php
session_start();
include 'connect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['register_role'];
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $password = $_POST['register_password'];
    $confirm_password = $_POST['confirm_password'];
    $location = trim($_POST['location']);

    // Validate password match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload
    

    // Insert into database
    $sql = "INSERT INTO users (register_role, name, contact, email, password, location) 
            VALUES (?, ?, ?, ?, ?, ?)";


    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $role, $name, $contact, $email, $hashed_password, $location);
        if ($stmt->execute()) {
            echo "Registration successful. <a href='login.html'>Login here</a>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Database error.";
    }

    $conn->close();
}
?>
