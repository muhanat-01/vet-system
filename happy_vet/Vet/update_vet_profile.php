<?php
include 'connect.php';
session_start();

// Redirect to login if not logged in or if user is not a vet
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];

// Fetch vet profile
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
    $speciality = $_POST['speciality'];
    $status = $_POST['status'];

    $update_sql = "UPDATE users SET name = ?, email = ?, contact = ?, location = ?, speciality = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssssi", $name, $email, $contact, $location, $speciality, $status, $user_id);

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
    <title>Edit Vet Profile</title>
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
            background: rgba(255, 255, 255, 0.88);
            padding: 30px;
            border-radius: 10px;
            width: 420px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
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
        }

        button {
            margin-top: 20px;
            padding: 10px;
            width: 100%;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: darkgreen;
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

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="edit-container">
    <h2>Edit Vet Profile</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label for="name">Full Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label for="contact">Phone Number:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['contact']) ?>" required>

        <label for="location">Location:</label>
        <input type="text" name="location" value="<?= htmlspecialchars($user['location']) ?>" required>

        <label for="speciality">Speciality:</label>
        <select name="speciality" required>
            <option value="">-- Select Speciality --</option>
            <option value="All Animals" <?= $user['speciality'] == 'All Animals' ? 'selected' : '' ?>>All Animals</option>
            <option value="Large Animals" <?= $user['speciality'] == 'Large Animals' ? 'selected' : '' ?>>Large Animals</option>
            <option value="Small Animals" <?= $user['speciality'] == 'Small Animals' ? 'selected' : '' ?>>Small Animals</option>
            <option value="Poultry" <?= $user['speciality'] == 'Poultry' ? 'selected' : '' ?>>Poultry</option>
            <option value="Dairy" <?= $user['speciality'] == 'Dairy' ? 'selected' : '' ?>>Dairy</option>
        </select>

        <label for="status">Availability:</label>
        <select name="status" required>
            <option value="Available" <?= $user['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
            <option value="Busy" <?= $user['status'] == 'Busy' ? 'selected' : '' ?>>Busy</option>
        </select>

        <button type="submit">Update Profile</button>
        <a href="my_profile.php" class="back-link">Cancel and return to profile</a>
    </form>
</div>

</body>
</html>

<?php $conn->close(); ?>
