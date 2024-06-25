<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php'; // Include your database connection script

// Initialize variables
$email = $password = "";
$emailErr = $passwordErr = "";
$registrationMessage = ""; // To store registration success or failure message

// Process registration form submission
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
    } elseif (strlen($password) < 6) {
        $passwordErr = "Password must be at least 6 characters";
    }

    // If no validation errors, proceed with registration
    if (empty($emailErr) && empty($passwordErr)) {
        // Check if email already exists
        $sql_check_email = "SELECT id FROM users WHERE email = '$email'";
        $result_check_email = $conn->query($sql_check_email);

        if ($result_check_email->num_rows > 0) {
            $emailErr = "Email already exists";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // SQL to insert user into database
            $sql_insert_user = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";

            if ($conn->query($sql_insert_user) === TRUE) {
                // Registration successful message
                $registrationMessage = "Registration successful! Please login with your credentials.";
                // Clear form inputs after successful registration
                $email = $password = "";
            } else {
                $registrationMessage = "Error: " . $sql_insert_user . "<br>" . $conn->error;
            }
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
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        var toggleBtn = document.getElementById("toggleBtn");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleBtn.textContent = "Hide Password";
        } else {
            passwordField.type = "password";
            toggleBtn.textContent = "Show Password";
        }
    }
    </script>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (!empty($registrationMessage)) : ?>
            <div class="registration-message"><?php echo $registrationMessage; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
            <span class="error"><?php echo $emailErr; ?></span><br><br>
            
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="button" id="toggleBtn" onclick="togglePassword()">Show Password</button><br>
            <span class="error"><?php echo $passwordErr; ?></span><br><br>
            
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>

<?php
$conn->close(); // Close database connection
?>

