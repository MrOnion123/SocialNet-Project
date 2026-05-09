<?php
session_start();
require_once '../socialnet/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Basic validation
    if ($password !== $confirm) {
        $message = "Passwords do not match.";
    } else {
        // Check if username exists
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "Username already taken.";
        } else {
            // Hash password
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed);

            if ($stmt->execute()) {
                header("Location: ../socialnet/signin.php");
                exit();
            } else {
                $message = "Error creating account.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body { font-family: Arial; }
        .container {
            width: 300px;
            margin: 50px auto;
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Sign Up</h2>

    <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <input type="submit" value="Register">
    </form>

    <p>Already have an account? <a href="../socialnet/signin.php">Login here</a></p>
</div>

</body>
</html>
