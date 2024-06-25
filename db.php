<?php
$servername = "localhost";
$username = "root";
$password = "Madhunath@007";
$dbname = "vayathar_pasanga";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

