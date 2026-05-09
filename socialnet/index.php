<?php
session_start();

// Redirect user to signin page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Include database connection
require_once 'db.php';

// Get current user information
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username, fullname FROM account WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$currentUser = $result->fetch_assoc();

// Get list of other users
$stmt2 = $conn->prepare("SELECT id, username, fullname FROM account WHERE id != ?");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$usersResult = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

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
            width: 80%;
            margin: 30px auto;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
        }

        /* User List */
        .user-list {
            list-style: none;
            padding: 0;
        }

        .user-list li {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .user-list li:last-child {
            border-bottom: none;
        }

        .user-list a {
            text-decoration: none;
            color: #2980b9;
            font-weight: bold;
        }

        .user-list a:hover {
            text-decoration: underline;
        }

        .fullname {
            color: #555;
            margin-left: 10px;
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

        <!-- Current User Information -->
        <div class="card">
            <h2>User Information</h2>

            <?php if ($currentUser): ?>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($currentUser['username']); ?></p>
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($currentUser['fullname']); ?></p>
            <?php else: ?>
                <p>User information not found.</p>
            <?php endif; ?>
        </div>

        <!-- Other Users -->
        <div class="card">
            <h2>Other Users</h2>

            <ul class="user-list">
                <?php while ($user = $usersResult->fetch_assoc()): ?>
                    <li>
                        <a href="profile.php?id=<?php echo $user['username']; ?>">
                            <?php echo htmlspecialchars($user['username']); ?>
                        </a>

                        <span class="fullname">
                            (<?php echo htmlspecialchars($user['fullname']); ?>)
                        </span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

    </div>

</body>
</html>
