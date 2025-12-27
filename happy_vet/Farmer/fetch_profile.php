<?php
// Include the database connection file
include 'connect.php';

// Retrieve search input values from the POST request
// trim() is used to remove unnecessary whitespace
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$speciality = isset($_POST['speciality']) ? trim($_POST['speciality']) : '';
$location = isset($_POST['location']) ? trim($_POST['location']) : '';
$availability = isset($_POST['availability']) ? trim($_POST['availability']) : '';

// Initialize the base SQL query
// "WHERE 1=1" allows easy appending of additional conditions
$sql = "SELECT * FROM vets WHERE 1=1";

// Add name filter if name is provided (partial match using LIKE)
if ($name !== '') {
    $sql .= " AND name LIKE '%" . $conn->real_escape_string($name) . "%'";
}

// Add speciality filter if speciality is provided (exact match)
if ($speciality !== '') {
    $sql .= " AND speciality = '" . $conn->real_escape_string($speciality) . "'";
}

// Add location filter if location is provided (partial match using LIKE)
if ($location !== '') {
    $sql .= " AND location LIKE '%" . $conn->real_escape_string($location) . "%'";
}

// Add availability filter if availability is provided (exact match)
if ($availability !== '') {
    $sql .= " AND availability = '" . $conn->real_escape_string($availability) . "'";
}

// Execute the dynamically built SQL query
$result = $conn->query($sql);

// Check if any veterinarian records were returned
if ($result->num_rows > 0) {

    // Loop through each result row
    while($row = $result->fetch_assoc()) {

        // Display veterinarian details inside a card layout
        echo '<div class="vet-card">';
        echo '<p><strong>Name:</strong> ' . htmlspecialchars($row['name']) . '</p>';
        echo '<p><strong>Speciality:</strong> ' . htmlspecialchars($row['speciality']) . '</p>';
        echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
        echo '<p><strong>Availability:</strong> ' . htmlspecialchars($row['availability']) . '</p>';
        echo '<button class="request-btn">Request Service</button>';
        echo '</div>';
    }

} else {
    // Message displayed when no matching veterinarians are found
    echo '<p>No veterinarians found.</p>';
}

// Close the database connection
$conn->close();
?>
