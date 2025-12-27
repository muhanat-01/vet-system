<?php
include 'connect.php';
session_start();

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <!-- Font Awesome CDN for icons -->
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
            background-color: rgba(0, 128, 0, 0.7);
            padding: 10px;
            border-radius: 50%;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .home-icon:hover {
            background-color: darkgreen;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .profile-card h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .profile-details {
            margin-top: 10px;
            text-align: left;
        }

        .profile-details p {
            font-size: 16px;
            margin: 10px 0;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .edit-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: green;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .edit-btn:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>

<!-- Home Button -->
<a href="farmer_dashboard.html" class="home-icon" title="Go to Home">
    <i class="fas fa-home"></i>
</a>

<div class="profile-card">
    <h2>My Profile</h2>
    <div class="profile-details">
        <p><span class="label">Full Name:</span> <?= htmlspecialchars($user['name']) ?></p>
        <p><span class="label">Email:</span> <?= htmlspecialchars($user['email']) ?></p>
        <p><span class="label">Phone:</span> <?= htmlspecialchars($user['contact']) ?></p>
        <p><span class="label">Location:</span> <?= htmlspecialchars($user['location']) ?></p>
        <p><span class="label">Role:</span> <?= htmlspecialchars(ucfirst($user['register_role'])) ?></p>
    </div>
    <a href="update_profile.php" class="edit-btn">Edit Profile</a>
</div>

</body>
</html>

<?php
$conn->close();
?>
