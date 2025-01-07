<?php
// fetch_cancellations.php

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

// SQL query to fetch data
$sql = "SELECT * FROM cancellations";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    $cancellations = [];
    while($row = $result->fetch_assoc()) {
        $cancellations[] = $row;
    }
    echo json_encode($cancellations);
} else {
    echo json_encode([]);
}

// Close connection
$conn->close();
?>
