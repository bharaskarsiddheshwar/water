<?php
session_start(); // Start session to manage user sessions

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waterparkdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$admin_email = "waterpark@gmail.com";
$admin_password = "admin@789"; // Use plain text for comparison

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the entered email and password match the admin credentials
    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION['isAdmin'] = true;
        $_SESSION['isLoggedIn'] = true; // Mark as logged in
        header("Location: dashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        // Check for regular user credentials in the database
        $sql = "SELECT name, email, password FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($name, $email, $stored_password);
            $stmt->fetch();

            // Compare entered password with stored password (plain text)
            if ($password === $stored_password) {
                $_SESSION['name'] = $name;
                $_SESSION['isLoggedIn'] = true; // Mark as logged in
                header("Location: home.html"); // Redirect to user homepage
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "No account found with that email.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
