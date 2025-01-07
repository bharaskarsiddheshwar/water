<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Water Park Ticket Booking</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .admin-header {
            background-color: #007bff;
            color: #fff;
            display: flex;
            justify-content: space-between;
            padding: 15px 20px;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .admin-header .logo h1 {
            margin: 0;
            font-size: 24px;
        }

        .admin-header .admin-info {
            display: flex;
            align-items: center;
        }

        .admin-header .logout-btn {
            margin-left: 20px;
            color: #fff;
            text-decoration: none;
            background-color: #dc3545;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .admin-header .logout-btn:hover {
            background-color: #c82333;
        }

        .admin-sidebar {
            background-color: #343a40;
            padding: 20px;
            min-width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .admin-sidebar nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .admin-sidebar nav ul li {
            margin: 20px 0;
        }

        .admin-sidebar nav ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .admin-sidebar nav ul li a:hover {
            background-color: #495057;
        }

        .admin-content {
            margin-left: 270px;
            padding: 40px;
            flex: 1;
            transition: margin-left 0.3s ease;
        }

        .dashboard h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .stat-box {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }

        .stat-box:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .stat-box h3 {
            font-size: 20px;
            margin: 0 0 10px 0;
            color: #007bff;
        }

        .stat-box p {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        .admin-footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px;
            margin-top: auto;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        .admin-footer p {
            margin: 0;
            color: #777;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                min-width: 200px;
                position: fixed;
                transform: translateX(-100%);
                z-index: 1000;
            }

            .admin-content {
                margin-left: 0;
                padding: 20px;
            }

            .admin-header .admin-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .admin-sidebar.active {
                transform: translateX(0);
            }

            .admin-sidebar-toggle {
                display: block;
                cursor: pointer;
                padding: 10px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 5px;
                position: absolute;
                top: 15px;
                left: 15px;
                z-index: 1000;
            }

            .admin-sidebar nav ul li {
                margin: 10px 0;
            }

            .admin-sidebar nav ul li a {
                padding: 8px;
            }
        }

        @media (max-width: 576px) {
            .admin-header .logo h1 {
                font-size: 20px;
            }

            .stat-box h3 {
                font-size: 18px;
            }

            .stat-box p {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <button class="admin-sidebar-toggle" onclick="toggleSidebar()">☰</button>
        <div class="logo">
            <h1>Water Park Admin</h1>
        </div>
        <div class="admin-info">
            <span>Welcome, Siddhesh</span>
            <a href="log.html" class="logout-btn">Logout</a>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="bookings.html">Bookings</a></li>
                <li><a href="canceled.html">Cancellations</a></li>
                <li><a href="user.html">Users</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="admin-content">
        <section class="dashboard">
            <h2>Dashboard</h2>

            <!-- Total Bookings -->
            <div class="stat-box">
                <h3>Total Bookings</h3>
                <p>
                    <?php
                    // Database connection
                    $conn = new mysqli("localhost", "root", "", "waterparkdb");

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Query to count total bookings
                    $result = $conn->query("SELECT COUNT(*) AS total_bookings FROM bookings");

                    // Fetch the result and display it
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo $row["total_bookings"];
                    } else {
                        echo "0";
                    }

                    // Close the connection
                    $conn->close();
                    ?>
                </p>
            </div>

            <!-- Total Cancellations -->
            <div class="stat-box">
                <h3>Total Cancellations</h3>
                <p>
                    <?php
                    // Database connection (reconnect)
                    $conn = new mysqli("localhost", "root", "", "waterparkdb");

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Query to count total cancellations
                    $result = $conn->query("SELECT COUNT(*) AS total_cancellations FROM cancellations");

                    // Fetch the result and display it
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo $row["total_cancellations"];
                    } else {
                        echo "0";
                    }

                    // Close the connection
                    $conn->close();
                    ?>
                </p>
            </div>

        </section>
    </main>

    <!-- Footer -->
    <footer class="admin-footer">
        <p>&copy; 2024 Water Park Ticket Booking. All rights reserved.</p>
    </footer>

    <script>
        function toggleSidebar() {
            var sidebar = document.querySelector('.admin-sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
</body>
</html>
