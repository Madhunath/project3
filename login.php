<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php'; // Include your database connection script

// Initialize variables
$email = $password = "";
$emailErr = $passwordErr = "";
$loginMessage = ""; // To store login status message

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $email = test_input($_POST['email']);
    $password = $_POST['password'];

    // Validate email
    if (empty($email)) {
        $emailErr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    // Validate password
    if (empty($password)) {
        $passwordErr = "Password is required";
    }

    // If no validation errors, proceed with login
    if (empty($emailErr) && empty($passwordErr)) {
        // SQL to fetch user from database based on email
        $sql_fetch_user = "SELECT id, email, password FROM users WHERE email = '$email'";
        $result_fetch_user = $conn->query($sql_fetch_user);

        if ($result_fetch_user->num_rows == 1) {
            $row = $result_fetch_user->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Password is correct, set session variables
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                // Redirect to dashboard or another page after successful login
                header("Location: dashboard.php");
                exit();
            } else {
                $loginMessage = "Incorrect password";
            }
        } else {
            $loginMessage = "Email not found";
        }
    }
}

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($loginMessage)) : ?>
            <div class="login-message"><?php echo $loginMessage; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
            <span class="error"><?php echo $emailErr; ?></span><br><br>
            
            <input type="password" name="password" placeholder="Password" required>
            <span class="error"><?php echo $passwordErr; ?></span><br><br>
            
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>

<?php
$conn->close(); // Close database connection
?>

