<?php
include 'db.php';

$sql = "SELECT name, dob FROM personal_details WHERE MONTH(dob) = MONTH(CURDATE()) AND DAY(dob) = DAY(CURDATE())";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Today's Birthdays</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Today's Birthdays</h2>
        <ul>
            <?php while($row = $result->fetch_assoc()): ?>
            <li><?php echo $row['name']; ?> - <?php echo $row['dob']; ?></li>
            <?php endwhile; ?>
        </ul>
	<p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>

