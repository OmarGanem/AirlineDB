<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airline_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$updated = false; // Flag to track if the update was successful
$flight = []; // Placeholder to hold flight data

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $flight_id = $_POST['flight_id'] ?? null;
    $airline_id = $_POST['airline_id'] ?? null;
    $departure_time = $_POST['departure_time'] ?? null;
    $arrival_time = $_POST['arrival_time'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($flight_id && $airline_id && $departure_time && $arrival_time && $status) {
        $sql = "UPDATE Flights SET airline_id = ?, departure_time = ?, arrival_time = ?, status = ? WHERE flight_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "Prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param("isssi", $airline_id, $departure_time, $arrival_time, $status, $flight_id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $updated = true;
                echo "Flight details updated successfully.";
            } else {
                echo "No data was updated, or the flight ID does not exist.";
            }
            $stmt->close();
        }
    } else {
        echo "All fields are required.";
    }
} elseif (isset($_GET['flight_id'])) {
    // Fetch the flight data if the flight ID is provided in the query
    $flight_id = $_GET['flight_id'];
    $stmt = $conn->prepare("SELECT * FROM Flights WHERE flight_id = ?");
    if ($stmt === false) {
        echo "Prepare failed: " . $conn->error;
    } else {
        $stmt->bind_param("i", $flight_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $flight = $result->fetch_assoc();
        } else {
            echo "Flight not found.";
        }
        $stmt->close();
    }
} else {
    echo "No flight ID provided.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Flight</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            color: #ffffff;
        }

        form {
            background-color: #1f1f1f;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"], input[type="hidden"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background-color: #2c2c2c;
            color: #ffffff;
        }

        input[type="submit"] {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #2196f3;
            color: #ffffff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #1976d2;
        }
    </style>
</head>
<body>
    <h1>Edit Flight Details</h1>
    <?php if (!empty($flight)): ?>
    <form method="post">
        <input type="hidden" name="flight_id" value="<?php echo htmlspecialchars($flight['flight_id']); ?>" required>

        <label for="airline_id">Airline ID:</label>
        <input type="text" id="airline_id" name="airline_id" value="<?php echo htmlspecialchars($flight['airline_id']); ?>" required>

        <label for="departure_time">Departure Time:</label>
        <input type="text" id="departure_time" name="departure_time" value="<?php echo htmlspecialchars($flight['departure_time']); ?>" required>

        <label for="arrival_time">Arrival Time:</label>
        <input type="text" id="arrival_time" name="arrival_time" value="<?php echo htmlspecialchars($flight['arrival_time']); ?>" required>

        <label for="status">Status:</label>
        <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($flight['status']); ?>" required>

        <input type="submit" name="update" value="Update">
    </form>
    <?php endif; ?>
</body>
</html>
