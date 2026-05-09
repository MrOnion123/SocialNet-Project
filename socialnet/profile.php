<?php
session_start();

// Redirect to signin page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Include database connection
require_once 'db.php';

// Determine profile owner
if (isset($_GET['owner']) && !empty($_GET['owner'])) {

    // Use owner from query string
    $owner = trim($_GET['owner']);

    $stmt = $conn->prepare("
        SELECT username, fullname, description
        FROM account
        WHERE username = ?
    ");

    $stmt->bind_param("s", $owner);

} else {

    // Use logged in user
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("
        SELECT username, fullname, description
        FROM account
        WHERE id = ?
    ");

    $stmt->bind_param("i", $user_id);
}

// Execute query
$stmt->execute();

$result = $stmt->get_result();
$profile = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>

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
            width: 75%;
            margin: 40px auto;
        }

        .card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
            color: #2c3e50;
        }

        .profile-info {
            margin-bottom: 25px;
        }

        .profile-info p {
            font-size: 18px;
            margin: 8px 0;
        }

        .description-box {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            min-height: 120px;
            white-space: pre-wrap;
            line-height: 1.6;
        }

        .not-found {
            color: red;
            font-weight: bold;
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

            <?php if ($profile): ?>

                <h2>
                    <?php echo htmlspecialchars($profile['fullname']); ?>'s Profile Page
                </h2>

                <div class="profile-info">
                    <p>
                        <strong>Username:</strong>
                        <?php echo htmlspecialchars($profile['username']); ?>
                    </p>

                    <p>
                        <strong>Owner:</strong>
                        <?php echo htmlspecialchars($profile['fullname']); ?>
                    </p>
                </div>

                <h3>Profile Page Content</h3>

                <div class="description-box">
                    <?php
                        echo nl2br(
                            htmlspecialchars($profile['description'] ?? 'No profile content available.')
                        );
                    ?>
                </div>

            <?php else: ?>

                <p class="not-found">
                    Profile not found.
                </p>

            <?php endif; ?>

        </div>

    </div>

</body>
</html>
