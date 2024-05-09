<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Flight Schedules</title>
    <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #222; /* Dark background */
      color: #ddd; /* Light grey text for better readability */
      margin: 0;
      padding: 20px;
    }

    h1, h2 {
      color: #fff; /* White headings */
      margin-bottom: 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #333; /* Darker background for tables */
      color: #eee; /* Light grey text for tables */
    }

    th, td {
      border: 1px solid #444; /* Darker border for tables */
      text-align: left;
      padding: 8px;
    }

    th {
      background-color: #111; /* Slightly darker background for table headers */
    }

    tr:nth-child(even) {
      background-color: #292929; /* Even row background color */
    }

    form {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #ccc; /* Lighter text for labels */
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"] {
      width: 100%;
      padding: 8px;
      background-color: #222; /* Dark input fields */
      color: #ddd; /* Light text inside inputs */
      border: 1px solid #444; /* Darker border for inputs */
      border-radius: 4px;
    }

    button {
      background-color: #0066cc;
      color: white;
      border: none;
      cursor: pointer;
      padding: 10px 20px;
      font-size: 16px;
      transition: background-color 0.3s, box-shadow 0.3s;
      border-radius: 4px;
      margin-top: 5px;
    }

    button:hover {
      background-color: #00488e; /* Slightly darker blue on hover */
      box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.3); /* Shadow effect on hover */
    }

    .error {
      color: red;
      font-weight: bold;
      margin-bottom: 10px;
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
    <th>Action</th>
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
                echo "<tr>
                  <td>" . $row["schedule_id"] . "</td>
                  <td>" . $row["flight_id"] . "</td>
                  <td>" . $row["date"] . "</td>
                  <td>$" . $row["fare"] . "</td>
                  <td>" . $row["available_seats"] . "</td>
                  <td>
                    <form action='delete_schedule.php' method='post'>
                      <input type='hidden' name='schedule_id' value='" . $row["schedule_id"] . "'>
                      <button type='submit'>Delete</button>
                    </form>
                  </td>
                </tr>";
              }
        } else {
            echo "<tr><td colspan='6'>No available schedules</td></tr>";
        }
        $conn->close();
        ?>
        <h2>Add New Schedule</h2>
<form action="add_schedule.php" method="post">
  <label for="flight_id">Flight ID:</label>
  <input type="number" id="flight_id" name="flight_id" required>
  <br>
  <label for="date">Date:</label>
  <input type="date" id="date" name="date" required>
  <br>
  <label for="fare">Fare:</label>
  <input type="number" id="fare" name="fare" required>
  <br>
  <label for="available_seats">Available Seats:</label>
  <input type="number" id="available_seats" name="available_seats" required>
  <br>
  <button type="submit">Add Schedule</button>
</form>
    </table>
</body>
</html>
