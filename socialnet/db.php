<?php
$conn = new mysqli("localhost", "huy", "Quanghuy031105@", "socialnet");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
