<?php
// Database configuration
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

// Retrieve form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$checkInDate = $_POST['date'];
$adults = $_POST['adults'];
$children = $_POST['children'];
$room = $_POST['rooms'];
$promoCode = $_POST['promo'];
$numRooms = $_POST['n_rooms'];
$paymentStatus = "Pending"; 
$paymentAmount = 1000.00; 

// Prepare and bind the insert statement
$sql = "INSERT INTO bookings (first_name, last_name, email, phone_num, date, adults, children, room, promo, room_num, paymentStatus, paymentAmount) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}

// Binding parameters with correct types
$stmt->bind_param("sssssiissisd", $firstName, $lastName, $email, $phone, $checkInDate, $adults, $children, $room, $promoCode, $numRooms, $paymentStatus, $paymentAmount);

// Execute the statement
if ($stmt->execute()) {
    echo "<script>alert('Booking and payment Information recorded successfully.'); window.location.href='/reciept.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
