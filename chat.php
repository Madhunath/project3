<?php
session_start();

include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];

    $sql = "INSERT INTO chat (user_id, message) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $message);

    if ($stmt->execute()) {
        echo "Message sent!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch chat messages
$sql = "SELECT c.message, u.email, c.sent_at FROM chat c JOIN users u ON c.user_id = u.id ORDER BY c.sent_at DESC";
$result = $conn->query($sql);

$messages = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .messages {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        .message {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .message p {
            margin: 0;
        }
        .back-button {
            display: block;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chat Room</h1>
        <div class="messages">
            <?php foreach ($messages as $msg): ?>
                <div class="message">
                    <p><strong><?php echo htmlspecialchars($msg['email']); ?>:</strong> <?php echo htmlspecialchars($msg['message']); ?></p>
                    <p><small><?php echo $msg['sent_at']; ?></small></p>
                </div>
            <?php endforeach; ?>
        </div>
        <form method="post" action="">
            <textarea name="message" rows="4" cols="50" placeholder="Type your message here..." required></textarea><br>
            <button type="submit">Send</button>
	</form>
	<p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>

