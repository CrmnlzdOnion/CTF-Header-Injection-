<?php
$host = 'db';
$user = 'myusername';
$password = 'mypassword';
$database = 'mydatabase';

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
