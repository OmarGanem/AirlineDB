<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Flight Schedules</title>
    <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #222; 
      color: #ddd;
      margin: 0;
      padding: 20px;
    }
    
    h1 {
      color: #fff; 
      margin-bottom: 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #333; 
      color: #eee; 
    }

    th, td {
      border: 1px solid #444; 
      text-align: left;
      padding: 8px;
    }

    th {
      background-color: #111; 
    }

    tr:nth-child(even) {
      background-color: #292929; /
    }
  </style>
</head>
<body>
    <h1>Available Flight Schedules</h1>
    <table>
        <tr>
            <th>Schedule ID</th>
            <th>Flight ID</th>
            <th>Date</th>
            <th>Fare</th>
            <th>Available Seats</th>
        </tr>
        <?php
        // Database connection variables
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "airline_db";

        // Create database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch flight schedules from the database
        $sql = "SELECT schedule_id, flight_id, date, fare, available_seats FROM flight_schedules";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["schedule_id"] . "</td><td>" . $row["flight_id"] . "</td><td>" . $row["date"] . "</td><td>$" . $row["fare"] . "</td><td>" . $row["available_seats"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No available schedules</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
