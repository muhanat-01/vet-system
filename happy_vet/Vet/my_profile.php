<?php
include 'connect.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "Vet not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vet Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('images/farmer1.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        .home-icon {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 24px;
            color: white;
            background-color: rgba(34, 139, 34, 0.7);
            padding: 10px;
            border-radius: 50%;
            text-decoration: none;
        }

        .home-icon:hover {
            background-color: darkgreen;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            width: 420px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .profile-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .profile-card h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .profile-details {
            text-align: left;
        }

        .profile-details p {
            margin: 10px 0;
        }

        .label {
            font-weight: bold;
            color: #444;
        }

        .edit-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background-color: #228B22;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .edit-btn:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>

<a href="vet_dashboard.html" class="home-icon" title="Dashboard">
    <i class="fas fa-home"></i>
</a>

<div class="profile-card">
    <h2>Vet Profile</h2>
    <div class="profile-details">
         <p><span class="label">Name:</span> <?= htmlspecialchars($user['name']) ?></p>
        <p><span class="label">Email:</span> <?= htmlspecialchars($user['email']) ?></p>
        <p><span class="label">Phone:</span> <?= htmlspecialchars($user['contact']) ?></p>
        <p><span class="label">Location:</span> <?= htmlspecialchars($user['location']) ?></p>
        <p><span class="label">Speciality:</span> <?= htmlspecialchars($user['speciality']) ?></p>
        <p><span class="label">Availability:</span> <?= htmlspecialchars($user['status']) ?></p>
    </div>
    <a href="update_vet_profile.php" class="edit-btn">Edit Profile</a>
</div>

</body>
</html>
