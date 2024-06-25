<?php
include 'db.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle update personal details
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $qualification = $_POST['qualification'];
    
    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $target = "uploads/" . basename($photo);
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
            echo "Failed to upload photo";
            exit();
        }
    } else {
        // Use existing photo if a new one is not uploaded
        $photo = $_POST['existing_photo'];
    }

    $sql = "UPDATE personal_details SET name=?, phone=?, dob=?, address=?, gender=?, qualification=?, photo=? WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $name, $phone, $dob, $address, $gender, $qualification, $photo, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Personal details updated successfully');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle delete personal details
if (isset($_POST['delete'])) {
    $sql_delete = "DELETE FROM personal_details WHERE user_id=?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $user_id);
    
    if ($stmt_delete->execute()) {
        echo "<script>alert('Personal details deleted successfully');</script>";
        header("Location: dashboard.php"); // Redirect to dashboard after deletion
        exit();
    } else {
        echo "Error: " . $stmt_delete->error;
    }
    $stmt_delete->close();
}

// Fetch personal details
$sql_select = "SELECT * FROM personal_details WHERE user_id=?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $user_id);
$stmt_select->execute();
$result = $stmt_select->get_result();
$user = $result->fetch_assoc();
$stmt_select->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Personal Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Personal Details</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <input type="text" name="phone" placeholder="Phone Number" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            <input type="date" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>" required>
            <input type="text" name="address" placeholder="Address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            <select name="gender" required>
                <option value="" disabled>Select Gender</option>
                <option value="Male" <?php if ($user['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($user['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if ($user['gender'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>
            <input type="text" name="qualification" placeholder="Qualification" value="<?php echo htmlspecialchars($user['qualification']); ?>" required>
            <input type="file" name="photo">
            <input type="hidden" name="existing_photo" value="<?php echo htmlspecialchars($user['photo']); ?>">
            <button type="submit" name="update">Update Details</button>
            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete your personal details? This action cannot be undone.');">Delete Personal Details</button>
        </form>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>

