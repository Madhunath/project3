<?php
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="styles.css">
    <style>
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Settings</h2>
        <div class="button-group">
            <a href="edit_personal_data.php">Edit Personal Data</a>
            <a href="edit_registration.php">Edit Registration Details</a>
            <a href="manage_events.php">Manage Events</a>
        </div>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>

