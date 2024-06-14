<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "Madhunath@007";
$dbname = "apm";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_POST['action'];

if ($action === "register") {
    // Registration logic
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo '<script>alert("Passwords do not match!"); window.location.href = "register.html";</script>';
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_query = "SELECT * FROM vp_boys WHERE email='$email'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo '<script>alert("Email already exists!"); window.location.href = "register.html";</script>';
    } else {
        // Insert new user into the database
        $insert_query = "INSERT INTO vp_boys (email, password) VALUES ('$email', '$hashed_password')";

        if ($conn->query($insert_query) === TRUE) {
            echo '<script>alert("Registration successful!"); window.location.href = "login.html";</script>';
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }
}
elseif ($action === "login") {
    // Login logic
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to retrieve user from database
    $sql = "SELECT * FROM vp_boys WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            echo '<script>alert("Login successful!"); window.location.href = "home.html";</script>';
        } else {
            echo '<script>alert("Incorrect password!"); window.location.href = "login.html";</script>';
        }
    } else {
        echo '<script>alert("User not found!"); window.location.href = "login.html";</script>';
    }
} elseif ($action === "profile") {
    // Profile submission logic
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
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                echo '<script>alert("Personal details submitted successfully!"); window.location.href = "home.html";</script>';
            } else {
                echo '<script>alert("Sorry, there was an error uploading your file."); window.location.href = "profile.html";</script>';
            }
        } else {
            echo '<script>alert("Error: ' . $conn->error . '"); window.location.href = "profile.html";</script>';
        }
    }
}

$conn->close();
?>