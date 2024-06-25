<?php
include 'db.php';

$sql = "SELECT * FROM personal_details";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Members Details</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Qualification</th>
                <th>Photo</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['dob']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['qualification']; ?></td>
                <td><img src="uploads/<?php echo $row['photo']; ?>" alt="Photo" width="100"></td>
            </tr>
            <?php endwhile; ?>
        </table>
	<p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>

