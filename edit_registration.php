<?php
include 'db.php';

session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET email=?, password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $email, $hashed_password, $user_id);

        if ($stmt->execute()) {
            echo "<script>alert('Registration details updated successfully');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        // Start a transaction
        $conn->begin_transaction();

        try {
            // Delete user details from personal_details table
            $sql1 = "DELETE FROM personal_details WHERE user_id=?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("i", $user_id);
            if (!$stmt1->execute()) {
                throw new Exception("Error: " . $stmt1->error);
            }
            $stmt1->close();
            
            // Delete user account from users table
            $sql2 = "DELETE FROM users WHERE id=?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $user_id);
            if (!$stmt2->execute()) {
                throw new Exception("Error: " . $stmt2->error);
            }
            $stmt2->close();

            // Commit transaction
            $conn->commit();
            echo "<script>alert('Registration details deleted successfully');</script>";
            session_destroy();
            header("Location: login.php");
            exit();
        } catch (Exception $e) {
            // Rollback transaction
            $conn->rollback();
            echo $e->getMessage();
        }
    }
}

// Fetch user data
$sql = "SELECT * FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Registration Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Registration Details</h2>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="update">Update Details</button>
            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">Delete Account</button>
        </form>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>

