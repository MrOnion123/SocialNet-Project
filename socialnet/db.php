<?php
$conn = new mysqli("localhost", "your-username", "your-password", "database-name");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
