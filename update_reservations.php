<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airline_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data by using the element's name attributes value as key
    $ticket_id = $_POST['ticket_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $flightId = $_POST['flightId'];
    $date = $_POST['date'];
    $seatCategory = $_POST['seatCategory'];

    // Clean the data
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $flightId = $conn->real_escape_string($flightId);
    $date = $conn->real_escape_string($date);
    $seatCategory = $conn->real_escape_string($seatCategory);

    // Update statement
    $query = "UPDATE Ticket JOIN Users ON Ticket.user_id = Users.user_id SET
              Users.name = ?, 
              Users.email = ?, 
              Ticket.flight_id = ?, 
              Ticket.reservation_date = ?, 
              Ticket.seat_categoryId = ?
              WHERE Ticket.ticket_id = ?";

    // Prepare statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisis", $name, $email, $flightId, $date, $seatCategory, $ticket_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Reservation updated successfully.";
        exit();
    } else {
        echo "Error updating reservation: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "No data submitted";
}
?>
