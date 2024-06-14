<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "Madhunath@007";
$dbname = "apm";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$blood_group = $_POST['blood_group'];
$dob = $_POST['dob'];
$qualification = $_POST['qualification'];
$photo = $_FILES['photo']['name'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["photo"]["name"]);

// Check if user already submitted details
$check_query = "SELECT * FROM user_details WHERE user_id='$user_id'";
$check_result = $conn->query($check_query);

if ($check_result->num_rows > 0) {
    echo '<script>alert("You have already submitted your details!"); window.location.href = "home.html";</script>';
} else {
    // Insert details into database
    $insert_query = "INSERT INTO user_details (user_id, name, phone, address, gender, blood_group, dob, qualification, photo) VALUES ('$user_id', '$name', '$phone', '$address', '$gender', '$blood_group', '$dob', '$qualification', '$photo')";

    if ($conn->query($insert_query) === TRUE) {
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        echo '<script>alert("Personal details submitted successfully!"); window.location.href = "home.html";</script>';
    } else {
        echo '<script>alert("Error: ' . $conn->error . '"); window.location.href = "profile.html";</script>';
    }
}

$conn->close();
?>