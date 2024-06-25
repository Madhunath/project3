<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT users.email, events.event_date, events.event_title, events.event_description 
        FROM events 
        JOIN users ON events.user_id = users.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Events</h2>
        <table>
            <tr>
                <th>Organized By</th>
                <th>Event Date</th>
                <th>Event Title</th>
                <th>Event Description</th>
            </tr>
            <?php while ($event = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $event['email']; ?></td>
                <td><?php echo $event['event_date']; ?></td>
                <td><?php echo $event['event_title']; ?></td>
                <td><?php echo $event['event_description']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
<?php
$conn->close();
?>

