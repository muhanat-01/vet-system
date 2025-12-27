<?php
include 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = trim($_POST["register_role"]); // Ensure it matches the database column
    $email = strtolower(trim($_POST["email"]));  // Convert email to lowercase
    $password = trim($_POST["password"]);

    // Adjust column names to match your database
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE LOWER(email) = ? AND register_role = ?");
    if (!$stmt) {
        die("Query error: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"];
            $_SESSION["role"] = $role;

            // Redirect based on role
            $redirect = ($role == "farmer") ? "Farmer/farmer_dashboard.html" : "Vet/vet_dashboard.html";
            header("Location: $redirect");
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found. Please check your email and role.'); window.location.href='login.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
