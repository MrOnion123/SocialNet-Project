<?php
session_start();

// Redirect to signin page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Include database connection
require_once 'db.php';

$user_id = $_SESSION['user_id'];

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $description = trim($_POST['description']);

    $stmt = $conn->prepare("UPDATE account SET description = ? WHERE id = ?");
    $stmt->bind_param("si", $description, $user_id);

    if ($stmt->execute()) {
        $message = "Profile content updated successfully.";
    } else {
        $message = "Failed to update profile content.";
    }
}

// Get current description
$stmt2 = $conn->prepare("SELECT description FROM account WHERE id = ?");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();

$result = $stmt2->get_result();
$user = $result->fetch_assoc();

$currentDescription = $user['description'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>

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

        /* Main Container */
        .container {
            width: 70%;
            margin: 40px auto;
        }

        .card {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
        }

        textarea {
            width: 100%;
            min-height: 200px;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            resize: vertical;
            box-sizing: border-box;
        }

        button {
            margin-top: 15px;
            background-color: #2980b9;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #1f6692;
        }

        .message {
            margin-bottom: 15px;
            color: green;
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

            <h2>Edit Profile Page Content</h2>

            <?php if (!empty($message)): ?>
                <div class="message">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <label for="description">
                    Profile Page Content:
                </label>
                <br><br>

                <textarea
                    name="description"
                    id="description"
                    required
                ><?php echo htmlspecialchars($currentDescription); ?></textarea>

                <br>

                <button type="submit">
                    Save Changes
                </button>

            </form>

        </div>
    </div>

</body>
</html>
