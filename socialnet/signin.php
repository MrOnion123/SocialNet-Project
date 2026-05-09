<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
        }

        .login-container {
            background: white;
            padding: 40px;
            width: 350px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: #333;
        }

        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 6px;
            font-weight: bold;
            color: #444;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        .login-container input[type="text"]:focus,
        .login-container input[type="password"]:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 5px rgba(124, 58, 237, 0.5);
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #7c3aed;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .login-btn:hover {
            background: #5b21b6;
            transform: scale(1.03);
        }

        .signup-text {
            margin-top: 20px;
            color: #555;
        }

        .signup-text a {
            color: #7c3aed;
            text-decoration: none;
            font-weight: bold;
        }

        .signup-text a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>

<body>

<div class="login-container">

    <h2>Sign In</h2>

    <form action="authenticate.php" method="post">

        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <input type="submit" value="Login" class="login-btn">

    </form>

    <p class="signup-text">
        Don't have an account?
        <a href="../admin/newuser.php">Sign up here</a>
    </p>

    <?php
    if (isset($_GET['error'])) {
        echo "<p class='error-message'>Invalid username or password</p>";
    }
    ?>

</div>

</body>
</html>
