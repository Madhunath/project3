<?php
include 'db.php'; // Include your database connection script

session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$name = $phone = $dob = $address = $gender = $qualification = $photo = "";
$uploadOk = true;
$photoErr = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $qualification = $_POST['qualification'];

    // Handle photo upload
    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $temp_name = $_FILES['photo']['tmp_name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is a valid image
        $check = getimagesize($temp_name);
        if ($check === false) {
            $photoErr = "File is not an image.";
            $uploadOk = false;
        }

        // Check file size (max 20MB)
        if ($_FILES['photo']['size'] > 20 * 1024 * 1024) {
            $photoErr = "File size exceeds maximum limit (20MB).";
            $uploadOk = false;
        }

        // Allow only certain file formats
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($imageFileType, $allowed_types)) {
            $photoErr = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            $uploadOk = false;
        }

        // Upload file if everything is ok
        if ($uploadOk) {
            if (move_uploaded_file($temp_name, $target_file)) {
                // File uploaded successfully, proceed with database insertion
                $sql = "INSERT INTO personal_details (user_id, name, phone, dob, address, gender, qualification, photo) 
                        VALUES ('$user_id', '$name', '$phone', '$dob', '$address', '$gender', '$qualification', '$photo')";
                
                if ($conn->query($sql) === TRUE) {
                    echo "Personal details saved successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $photoErr = "Sorry, there was an error uploading your file.";
            }
        } else {
            $photoErr = "File upload failed. " . $photoErr;
        }
    } else {
        $photoErr = "Please select a file.";
    }

    $conn->close(); // Close database connection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Personal Details</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>" required>
            <input type="text" name="phone" placeholder="Phone Number" value="<?php echo $phone; ?>" required>
            <input type="date" name="dob" value="<?php echo $dob; ?>" required>
            <input type="text" name="address" placeholder="Address" value="<?php echo $address; ?>" required>
            <select name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male" <?php if ($gender == "Male") echo "selected"; ?>>Male</option>
                <option value="Female" <?php if ($gender == "Female") echo "selected"; ?>>Female</option>
                <option value="Other" <?php if ($gender == "Other") echo "selected"; ?>>Other</option>
            </select>
            <input type="text" name="qualification" placeholder="Qualification" value="<?php echo $qualification; ?>" required>
            <input type="file" name="photo" required>
            <span class="error"><?php echo $photoErr; ?></span>
            <button type="submit">Save Details</button>
	</form>
	<p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>

