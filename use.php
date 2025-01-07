<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waterparkdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch bookings data
$sql = "SELECT * FROM user";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
} else {
    $bookings = [];
}

$conn->close();

// Encode data to JSON format
echo json_encode($bookings);
?>
