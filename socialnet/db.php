<?php
$conn = new mysqli("localhost", "your-username", "your-password", "socialnet");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
