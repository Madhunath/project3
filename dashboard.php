<?php
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details from session or database if necessary
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['email']; // Example, you can fetch more details as needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .button-group a {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .button-group a:hover {
            background-color: #0056b3;
        }
        .top-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }
        .top-buttons a {
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .logout-button {
            background-color: #ff0000;
        }
        .logout-button:hover {
            background-color: #cc0000;
        }
        .settings-button {
            background-color: #007bff;
        }
        .settings-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Top Buttons (Logout and Settings) -->
    <div class="top-buttons">
        <a href="settings.php" class="settings-button"><i class="fas fa-cog"></i></a>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <div class="container">
        <h2>Welcome to Your Dashboard</h2>
        <p>Hello, <?php echo $user_email; ?></p>
        
        <!-- Navigation Links -->
	<div class="button-group">
	    <a href="personal_details.php">Personal Details</a>
            <a href="members.php">Members</a>
            <a href="chat.php">Chat</a>
            <a href="events.php">Events</a>
            <a href="birthdays.php">Birthday</a>
        </div>
    </div>
</body>
</html>

