<?php
session_start(); // Ensure session is started

// Check if user is logged in
$isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waterpark</title>
</head>
<body>
    <header>
        <?php if (!$isLoggedIn): ?>
            <a href="login.html">Login</a>
        <?php else: ?>
            <a href="logout.php">Logout</a>
        <?php endif; ?>
    </header>

    <!-- Rest of your page content -->
</body>
</html>
