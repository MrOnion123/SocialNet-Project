<?php
session_start();

// Redirect to signin page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Page</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }

        /* Menu Bar */
        .navbar {
            background-color: #2c3e50;
            padding: 15px;
            display: flex;
            gap: 15px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .navbar a:hover {
            background-color: #34495e;
        }

        /* Main Content */
        .container {
            width: 60%;
            margin: 50px auto;
        }

        .card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            margin-top: 0;
            color: #2c3e50;
        }

        .info {
            font-size: 18px;
            margin: 15px 0;
        }
    </style>
</head>
<body>

    <!-- Menu Bar -->
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="setting.php">Setting</a>
        <a href="profile.php">Profile</a>
        <a href="about.php">About</a>
        <a href="signout.php">SignOut</a>
    </div>

    <!-- Main Content -->
    <div class="container">

        <div class="card">

            <h2>About</h2>

            <div class="info">
                <strong>Student Name:</strong>
                Do Quang Huy
            </div>

            <div class="info">
                <strong>Student Number:</strong>
                1694889
            </div>

        </div>

    </div>

</body>
</html>
