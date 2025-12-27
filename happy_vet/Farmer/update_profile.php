<?php
include 'connect.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];

// Fetch user data
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $location = $_POST['location'];
    $role = $_POST['register_role'];// farmer or vet

    $update_sql = "UPDATE users SET name = ?, email = ?, contact = ?, location = ?, register_role = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssi", $name, $email, $contact, $location, $role, $user_id);

    if ($stmt->execute()) {
        header("Location: my_profile.php?updated=1");
        exit();
    } else {
        $error = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('images/farmer1.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .edit-container {
            background: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            background-color: green;
            color: white;
            border: none;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: darkgreen;
        }

        .error {
            color: red;
            text-align: center;
        }

        .back-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            color: #2980b9;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="edit-container">
    <h2>Edit Profile</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label for="name">Full Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label for="contact">Phone:</label>
        <input type="text" name="contact" value="<?= htmlspecialchars($user['contact']) ?>" required>

        <label for="location">Location:</label>
        <input type="text" name="location" value="<?= htmlspecialchars($user['location']) ?>" required>

        <label for="register_role">Role:</label>
        <select name="register_role" required>
            <option value="farmer" <?= $user['register_role'] == 'farmer' ? 'selected' : '' ?>>Farmer</option>
            <option value="vet" <?= $user['register_role'] == 'vet' ? 'selected' : '' ?>>Vet</option>
        </select>

        <button type="submit">Update Profile</button>
        <a href="my_profile.php" class="back-link">Cancel and return to profile</a>
    </form>
</div>

</body>
</html>

<?php $conn->close(); ?>
