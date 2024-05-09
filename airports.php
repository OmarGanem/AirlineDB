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

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM airports WHERE airport_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: airports.php");
    exit;
}

// Handle new airport insertion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $city = $_POST['city'];
    $country = $_POST['country'];
    $insert_sql = "INSERT INTO airports (city, country) VALUES (?, ?)";
    if ($stmt = $conn->prepare($insert_sql)) {
        $stmt->bind_param("ss", $city, $country);
        $stmt->execute();
        $stmt->close();
        header("Location: airports.php");
        exit;
    }
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
    }

    table {
      width: 50%; 
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
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["airport_id"] . "</td>
                        <td>" . $row["city"] . "</td>
                        <td>" . $row["country"] . "</td>
                        <td>
                            <form method='post'>
                                <input type='hidden' name='delete_id' value='" . $row["airport_id"] . "'>
                                <button type='submit'>Delete</button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No airports found</td></tr>";
        }
        ?>
    </table>
    <!-- Form to add new airport -->
    <form method="post">
        <input type="text" name="city" placeholder="City" required>
        <input type="text" name="country" placeholder="Country" required>
        <button type="submit" name="add">Add Airport</button>
    </form>
</body>
</html>
<?php
$conn->close();
?>
