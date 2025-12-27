<?php

// Include the database connection file
include 'connect.php';

// Retrieve search inputs from the POST request and remove extra spaces
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$speciality = isset($_POST['speciality']) ? trim($_POST['speciality']) : '';
$location = isset($_POST['location']) ? trim($_POST['location']) : '';
$status = isset($_POST['status']) ? trim($_POST['status']) : '';  // Availability/status selected from the form
$contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';

// Initialize SQL query to select only users registered as vets
$sql = "SELECT * FROM users WHERE register_role = 'vet'";

// Apply name filter if provided (partial match)
if ($name !== '') {
    $sql .= " AND name LIKE '%" . $conn->real_escape_string($name) . "%'";
}

// Apply speciality filter if provided (exact match)
if ($speciality !== '') {
    $sql .= " AND speciality = '" . $conn->real_escape_string($speciality) . "'";
}

// Apply location filter if provided (partial match)
if ($location !== '') {
    $sql .= " AND location LIKE '%" . $conn->real_escape_string($location) . "%'";
}

// Apply availability/status filter
if ($status === 'available') {
    // Filter vets who are currently available
    $sql .= " AND status = 'available'";
} elseif ($status !== '' && $status !== 'all') {
    // Optional support for other statuses such as 'busy'
    $sql .= " AND status = '" . $conn->real_escape_string($status) . "'";
}

// Apply contact filter if provided (partial match)
if ($contact !== '') {
    $sql .= " AND contact LIKE '%" . $conn->real_escape_string($contact) . "%'";
}

// Execute the constructed SQL query
$result = $conn->query($sql);

// Check if any veterinarian records were found
if ($result->num_rows > 0) {

    // Loop through each veterinarian record
    while ($row = $result->fetch_assoc()) {

        // Display veterinarian information inside a card layout
        echo '<div class="vet-card">';
        echo '<p><strong>Name:</strong> ' . htmlspecialchars($row['name']) . '</p>';
        echo '<p><strong>Speciality:</strong> ' . htmlspecialchars($row['speciality']) . '</p>';
        echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
        echo '<p><strong>Status:</strong> ' . htmlspecialchars($row['status']) . '</p>';
        echo '<p><strong>Contact:</strong> ' . htmlspecialchars($row['contact']) . '</p>';

        // Form used to send a service request to the selected veterinarian
        echo '<form action="send_request.html" method="GET">';
        echo '<input type="hidden" name="vet_id" value="' . $row['id'] . '">';      // Vet identifier
        echo '<input type="hidden" name="farmer_id" value="2">';                  // Farmer identifier (static for now)
        echo '</form>';

        echo '</div>';
    }

} else {
    // Message displayed when no matching veterinarians are found
    echo '<p>No veterinarians found.</p>';
}

// Close the database connection
$conn->close();
?>
