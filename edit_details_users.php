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

// Define the seat categories with their IDs
$seatCategories = [
    1 => 'Economy',
    2 => 'Premium Economy',
    3 => 'Business Class',
    4 => 'First Class'
];

$ticket_id = isset($_GET['ticket_id']) ? intval($_GET['ticket_id']) : 0;
$reservationData = null;
$errorMessage = null;

// If a valid ticket ID is provided, fetch the reservation data
if ($ticket_id > 0) {
    $query = "SELECT Ticket.*, Users.name, Users.email FROM Ticket JOIN Users ON Ticket.user_id = Users.user_id WHERE ticket_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        $errorMessage = "Prepare failed: " . $conn->error;
    } else {
        $stmt->bind_param("i", $ticket_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $reservationData = $result->fetch_assoc();
        } else {
            $errorMessage = "No reservation found with ticket ID: $ticket_id";
        }

        $stmt->close();
    }
}
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Reservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; 
            color: #e0e0e0; 
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .navbar {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .navbar a {
            margin: 0 10px;
            text-decoration: none;
            color: #fff;
        }

        .form-container {
            background-color: #333; 
            padding: 40px;
            width: 50%; 
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); 
            border-radius: 8px;
            color: #fff;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px; 
            color: #ccc; 
            font-size: 18px; 
        }

        .input-group input, .input-group select {
            width: 100%;
            padding: 8px;
            background-color: #222; 
            color: #ddd; 
            border: 1px solid #444; 
            border-radius: 4px;
        }

        .submit-button {
            background-color: #0066cc;
            color: white;
            border: none;
            cursor: pointer;
            padding: 15px 30px;
            font-size: 18px; 
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .submit-button:hover {
            background-color: #00488e; 
            box-shadow: 0 2px 5px 0 rgba(0,0,0,0.3); 
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
        <h1>Edit Reservation</h1>
        <?php if ($errorMessage): ?>
            <p><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php elseif ($reservationData): ?>
        <form action="update_reservations.php" method="post">
            <input type="hidden" name="ticket_id" value="<?php echo htmlspecialchars($reservationData['ticket_id']); ?>">
            <div class="input-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($reservationData['name']); ?>" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($reservationData['email']); ?>" required>
            </div>
            <div class="input-group">
                <label for="flightId">Flight ID:</label>
                <input type="number" id="flightId" name="flightId" value="<?php echo htmlspecialchars($reservationData['flight_id']); ?>" required>
            </div>
            <div class="input-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?php echo isset($reservationData['date']) ? htmlspecialchars($reservationData['date']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <label for="seatCategory">Seat Category:</label>
                <select id="seatCategory" name="seatCategory" required>
                    <option value="">Select Seat Category</option>
                    <?php foreach ($seatCategories as $id => $name): ?>
                        <option value="<?php echo $id; ?>" <?php echo (isset($reservationData['seat_category_id']) && $reservationData['seat_category_id'] == $id) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <form action="update_reservations.php" method="post">
  <input class="submit-button" type="submit" value="Update Reservation">
</form>

        </form>
        <?php else: ?>
            <p>Reservation data is not available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
