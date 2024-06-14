<?php
// Existing PHP code for database connection and fetching data
$servername = "localhost";
$username = "root";
$password = "Madhunath@007";
$dbname = "apm";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM user_details";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members - Vayathar Pasanga</title>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        /* Container styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Header styles */
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Photo styles */
        .photo {
            max-width: 80px;
            max-height: 80px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Responsive table */
        @media screen and (max-width: 600px) {
            table {
                overflow-x: auto;
            }
        }

        /* Button styles */
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #00796b;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="home.html" class="button">Home</a>
        <h1>Members - Vayathar Pasanga</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Gender</th>
                    <th>Blood Group</th>
                    <th>Date of Birth</th>
                    <th>Qualification</th>
                    <th>Photo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["address"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["gender"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["blood_group"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["dob"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["qualification"]) . "</td>";
                        echo '<td><img src="uploads/' . htmlspecialchars($row["photo"]) . '" alt="Photo" class="photo"></td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No members found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>