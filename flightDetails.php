<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flight Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212; /* Dark background */
            margin: 0;
            padding: 20px;
            color: #ccc; 
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
        .container {
            background-color: #1e1e1e; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); 
            padding: 20px;
            margin: auto;
            width: 80%;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            color: #00bfff; 
        }
        .section {
            margin-top: 20px;
        }
        .section h2 {
            color: #add8e6; 
            border-bottom: 1px solid #add8e6;
            padding-bottom: 10px;
        }
        .details {
            margin-top: 10px;
            background-color: #252526; 
            padding: 15px;
            border-radius: 8px;
        }
        .details p {
            font-size: 16px;
            line-height: 1.6;
            color: #dcdcdc; 
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="index.html">Home</a>
    <a href="flights.php">See Flights</a>
    <a href="destinations.php">Explore Destinations</a>
</div>
    <div class="container">
        <h1>Flight Details</h1>
        <?php
        if (isset($_GET['flight_id'])) {
            $conn = new mysqli('localhost', 'root', '', 'airline_db');
            if ($conn->connect_error) {
                die('Failed to connect to MySQL: ' . $conn->connect_error);
            }
            $stmt = $conn->prepare("SELECT Airlines.name as airline_name, Departure.city as departure_city, Arrival.city as destination_city, Flights.departure_time, Flights.arrival_time
                                    FROM Flights
                                    JOIN Airlines ON Flights.airline_id = Airlines.airline_id
                                    JOIN Airports AS Departure ON Flights.origin_airport_id = Departure.airport_id
                                    JOIN Airports AS Arrival ON Flights.arrival_airport_id = Arrival.airport_id
                                    WHERE flight_id = ?");
            $stmt->bind_param("i", $_GET['flight_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($flight = $result->fetch_assoc()) {
                echo "<div class='section'><h2>General Information</h2>";
                echo "<div class='details'>";
                echo "<p><strong>Airline:</strong> " . htmlspecialchars($flight['airline_name']) . "</p>";
                echo "<p><strong>Departure City:</strong> " . htmlspecialchars($flight['departure_city']) . "</p>";
                echo "<p><strong>Destination City:</strong> " . htmlspecialchars($flight['destination_city']) . "</p>";
                echo "<p><strong>Departure Time:</strong> " . $flight['departure_time'] . "</p>";
                echo "<p><strong>Arrival Time:</strong> " . $flight['arrival_time'] . "</p>";
                echo "</div></div>";
            } else {
                echo "<p>Flight details not available.</p>";
            }
            $stmt->close();
            $conn->close();
        } else {
            echo "<p>No flight selected.</p>";
        }
        ?>
    </div>
</body>
</html>
