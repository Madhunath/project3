<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $event_title = $_POST['event_title'];
        $event_date = $_POST['event_date'];
        $event_description = $_POST['event_description'];
        $sql = "INSERT INTO events (user_id, event_date, event_title, event_description) 
                VALUES ('$user_id', '$event_date', '$event_title', '$event_description')";
    } elseif (isset($_POST['edit'])) {
        $event_id = $_POST['event_id'];
        $event_title = $_POST['event_title'];
        $event_date = $_POST['event_date'];
        $event_description = $_POST['event_description'];
        $sql = "UPDATE events SET event_title='$event_title', event_date='$event_date', event_description='$event_description' 
                WHERE id='$event_id' AND user_id='$user_id'";
    } elseif (isset($_POST['delete'])) {
        $event_id = $_POST['event_id'];
        $sql = "DELETE FROM events WHERE id='$event_id' AND user_id='$user_id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Operation successful";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM events WHERE user_id='$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Manage Events</h2>
        <form method="post" action="">
            <input type="text" name="event_title" placeholder="Event Title" required>
            <input type="date" name="event_date" required>
            <textarea name="event_description" placeholder="Event Description" required></textarea>
            <button type="submit" name="add">Add Event</button>
        </form>
        <table>
            <tr>
                <th>Event Title</th>
                <th>Event Date</th>
                <th>Event Description</th>
                <th>Actions</th>
            </tr>
            <?php while ($event = $result->fetch_assoc()): ?>
            <tr>
                <form method="post" action="">
                    <td><input type="text" name="event_title" value="<?php echo $event['event_title']; ?>"></td>
                    <td><input type="date" name="event_date" value="<?php echo $event['event_date']; ?>"></td>
                    <td><textarea name="event_description"><?php echo $event['event_description']; ?></textarea></td>
                    <td>
                        <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                        <button type="submit" name="edit">Edit</button>
                        <button type="submit" name="delete">Delete</button>
                    </td>
                </form>
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

