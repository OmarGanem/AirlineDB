<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airline_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT airport_id, city, country FROM airports ORDER BY city";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Airports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333; 
            color: #ccc; 
            margin: 0;
            padding: 20px;
            height: 100vh; 
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        table {
            width: 80%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #555; 
            padding: 10px;
            text-align: left;
            color: #ddd;
        }
        th {
            background-color: #444; 
            color: #fff; 
        }
        tr:nth-child(even) {
            background-color: #393939; 
        }
        form {
            margin-top: 20px;
        }
        input[type="text"], input[type="submit"], button {
            padding: 8px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            background-color: #555; 
            color: #fff; 
            font-size: 16px;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #666;
            cursor: pointer;
        }
        .form-new-airport {
            padding: 15px;
            border-radius: 5px;
            background-color: #404040; 
        }
    </style>
</head>
<body>
    <h1>Airports Information</h1>
    <table>
        <tr>
            <th>Airport ID</th>
            <th>City</th>
            <th>Country</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["airport_id"] . "</td>
                        <td>" . $row["city"] . "</td>
                        <td>" . $row["country"] . "</td>
                        <td>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No airports found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>
