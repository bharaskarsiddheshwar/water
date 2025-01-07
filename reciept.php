<?php
// Include your database connection file here
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

function generateReceipt($email, $conn) {
    // Prepare the query to select all records based on email
    $query = "SELECT * FROM bookings WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate receipt
        $receipt = "Receipt\n";
        $receipt .= "-----------------------------\n";
        
        while ($booking = $result->fetch_assoc()) {
            $receipt .= "Name: " . $booking['first_name'] . " " . $booking['last_name'] . "\n";
            $receipt .= "Email: " . $booking['email'] . "\n";
            $receipt .= "Phone: " . $booking['phone_num'] . "\n";
            $receipt .= "Adults: " . $booking['adults'] . "\n";
            $receipt .= "Children: " . $booking['children'] . "\n";
            $receipt .= "Room Type: " . $booking['room'] . "\n";
            $receipt .= "Number of Rooms: " . $booking['room_num'] . "\n";
            $receipt .= "Check-in Date: " . $booking['date'] . "\n";
            $receipt .= "-----------------------------\n";
        }
        $receipt .= "Thank you for your booking!";
        
        // Output receipt as plain text
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="receipt_' . $email . '.txt"');
        echo $receipt;
        exit();
    } else {
        echo "No bookings found for this email.";
    }
}

// Check if 'email' parameter is set in the request
if (isset($_GET['email'])) {
    // Retrieve and sanitize email from the request
    $email = $_GET['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Validate the email format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Generate and download receipt
        generateReceipt($email, $conn);
    } else {
        echo "Invalid email format.";
    }
} else {
    // Display the form if no email is provided
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Get Receipt</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .container {
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                padding: 20px;
                max-width: 400px;
                width: 100%;
                text-align: center;
            }
            h1 {
                color: #333;
            }
            form {
                margin-top: 20px;
            }
            label {
                display: block;
                font-weight: bold;
                margin-bottom: 10px;
            }
            input[type="email"] {
                width: calc(100% - 22px);
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                margin-bottom: 10px;
            }
            input[type="submit"] {
                background-color: #5cb85c;
                border: none;
                color: white;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                border-radius: 4px;
                cursor: pointer;
            }
            input[type="submit"]:hover {
                background-color: #4cae4c;
            }
            .message {
                margin-top: 20px;
                color: #d9534f;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Get Your Receipt</h1>
            <form action="" method="get">
                <label for="email">Enter your email:</label>
                <input type="email" id="email" name="email" required>
                <input type="submit" value="Get Receipt">
            </form>
            <?php
            // Display any error messages
            if (isset($_GET['error'])) {
                echo '<div class="message">' . htmlspecialchars($_GET['error']) . '</div>';
            }
            ?>
        </div>
    </body>
    </html>
    <?php
}
?>
