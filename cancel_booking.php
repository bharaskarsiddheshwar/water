<?php
// Database connection
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

// Get user email from form submission
$email = $_POST['email'];

// Check if the user has a booking
$checkBookingQuery = "SELECT * FROM bookings WHERE email = ?";
$stmtCheckBooking = $conn->prepare($checkBookingQuery);
if ($stmtCheckBooking === false) {
    die("Prepare failed: " . $conn->error);
}
$stmtCheckBooking->bind_param("s", $email);
$stmtCheckBooking->execute();
$result = $stmtCheckBooking->get_result();

// Check if the result contains any rows (i.e., if a booking exists)
if ($result->num_rows > 0) {
    // The user has a booking, proceed to record the cancellation
    $row = $result->fetch_assoc();

    // Get data from POST request
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];

    // Prepare SQL statement to insert into cancellations
    $sqlInsertCancellation = "INSERT INTO cancellations (first_name, last_name, email, phone_num, date) VALUES (?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsertCancellation);
    if ($stmtInsert === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmtInsert->bind_param("sssss", $firstName, $lastName, $email, $phone, $date);

    // Execute the insert query
    if ($stmtInsert->execute()) {
        echo "<script>alert('Booking cancellation recorded successfully.'); window.location.href='/index.html';</script>";
    } else {
        echo "<script>alert('Error processing cancellation. Please try again.'); window.location.href='/cancel.html';</script>";
    }

    // Close the prepared statement
    $stmtInsert->close();
} else {
    // No booking found
    echo "<script>alert('No booking found for this user.'); window.location.href='/cancel.html';</script>";
}

// Close the database connection
$stmtCheckBooking->close();
$conn->close();
?>
