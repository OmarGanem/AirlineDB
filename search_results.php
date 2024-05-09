<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airline_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = $_GET['search'] ?? '';
echo "Search term: " . htmlspecialchars($search);  // Debugging output

$noResultsMsg = '';
$reservation = null;

if (!empty($search)) {
    $sql = "SELECT Ticket.*, Users.name, Users.email FROM Ticket JOIN Users ON Ticket.user_id = Users.user_id WHERE Ticket.ticket_id = ? OR Users.email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $search, $search);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $reservation = $result->fetch_assoc();
            } else {
                $noResultsMsg = "No results found for the provided search criteria.";
            }
        } else {
            echo "SQL Error: " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . htmlspecialchars($conn->error);
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Reservation Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://images.unsplash.com/photo-1507812984078-917a274065be?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8YWlycGxhbmV8ZW58MHx8MHx8fDA%3D') no-repeat center center fixed; /* Replace with your desired image URL */
            background-size: cover;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .navbar {
            width: 100%;
            background-color: #333;
            padding: 10px 0;
            text-align: center; 
            position: absolute;
            top: 0;
        }

        .navbar a {
            color: #f2f2f2;
            padding: 12px 20px;
            text-decoration: none;
            margin: 0 10px;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.5); 
            padding: 40px;
            width: 50%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            text-align: center; 
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input[type="text"],
        .input-group input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
        }

        .input-group input[type="submit"] {
            background-color: #0066cc;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .input-group input[type="submit"]:hover {
            background-color: #00488e;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index_admin.html">Home</a>
        <a href="flights.php">See Flights</a>
        <a href="destinations.php">Explore Destinations</a>
    </div>

   
<div class="form-container">
        <h1>Search for a Reservation</h1>
        <form method="get" action="edit_details.php">
            <div class="input-group">
            <input type="text" name="ticket_id" required>
            </div>
            <div class="input-group">
                <input type="submit" value="Edit Reservation">
            </div>
        </form>

        
        <?php if ($reservation): ?>
            <div id="results">
                <h2>Reservation Details:</h2>
                <p><strong>Ticket ID:</strong> <?php echo htmlspecialchars($reservation['ticket_id']); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($reservation['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($reservation['email']); ?></p>
                
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $noResultsMsg): ?>
            <p><?php echo htmlspecialchars($noResultsMsg); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
