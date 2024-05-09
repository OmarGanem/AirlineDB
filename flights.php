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

// Ensure the SQL query correctly aliases the airline's name as 'airline'
$sql = "SELECT Flights.flight_id, Airlines.name AS airline, Flights.departure_time, Flights.arrival_time, Flights.status 
        FROM Flights 
        JOIN Airlines ON Flights.airline_id = Airlines.airline_id"; 
$result = $conn->query($sql);
if ($result === false) {
    die("SQL Error: " . $conn->error);
}
?>
<!DOCTYPE html>     
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Flights</title>
    <style>
        body {
    background: url('https://images.unsplash.com/photo-1561131668-f63504fc549d?q=80&w=1157&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center fixed; 
    background-size: cover;
    color: #fff;
    font-family: 'Lucida Console', Monaco, monospace;
    margin: 0;
    padding: 20px;
    height: 100vh;  
    display: flex;
    justify-content: center;
    align-items: center;
    text-shadow: 1px 1px 0 #000; 
    
    }
    body {
        padding-top: 50px; 
    }
    .navbar {
    display: flex; 
    justify-content: center;
    align-items: center; 
    width: 100%; 
    position: fixed; 
    top: 0;
    left: 0;
    z-index: 1000; 
    background-color: #333; 
    overflow: hidden;
    font-family: Arial, sans-serif;
    height: 50px; 
}


.navbar a {
    display: block;
    color: #f2f2f2; 
    text-align: center;
    padding: 14px 20px;
    text-decoration: none;
}


.navbar a:hover {
    background-color: #ddd;
    color: black;
}

   
    .navbar::after {
        content: "";
        clear: both;
        display: table;
    }
    .hero {
        height: 300px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #007BFF;
        text-shadow: 1px 1px 0 #000;
    }

    /* Testimonial Slider */
    .testimonial-slider {
        background: white;
        padding: 20px;
        margin-top: 20px;
    }

    .testimonial-slider p {
        font-style: italic;
    }

    table {
        width: 100%;
        border-collapse: collapse;  
        background-color: #007BFF;  
        color: #ffffff; 
        margin: 20px 0;  
    }

    th, td {
        padding: 15px;  
        border: 1px solid #0056b3;  
        text-align: left;  
    }

    th {
        background-color: #0056b3;  
        color: #ffffff;  
    }

    tbody tr:nth-child(odd) {
        background-color: #009BFF;  
    }
    </style>
</head>   
<body>
<div class="navbar">
        <a href="index_admin.html">Home</a>
        <a href="destinations.php">Explore Destinations</a>
        <a href="airports.php">Logout</a>
    </div>
    <div class="hero">
        <h1>Departure Times</h1>
    </div>
    <table id="departureBoard">
    <table>
        <thead>
            <tr>
                <th>Flight ID</th>
                <th>Airline</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Status</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['flight_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['airline']); ?></td>
                    <td><?php echo htmlspecialchars($row['departure_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['arrival_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><a href="edit_flight.php?flight_id=<?php echo $row['flight_id']; ?>">Edit</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php $conn->close(); ?>
