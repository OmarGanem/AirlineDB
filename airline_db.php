<?php
// Database configuration settings
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

// Handling ticket booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bookTicket'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $card_number = $_POST['credit_card_number'];
    $exp_date = $_POST['exp_date'];
    $card_name = $_POST['card_name'];
    $flight_id = $_POST['flightId'];
    $date = $_POST['date'];
    $seat_category = $_POST['seatCategory'];

    // Transaction Start
    $conn->begin_transaction();

    try {
        // Add new user
        $insertUserSql = "INSERT INTO Users (name, email, pw, phone) VALUES (?, ?, 'defaultpassword', '000-000-0000')";
        $userStmt = $conn->prepare($insertUserSql);
        $userStmt->bind_param("ss", $name, $email);
        $userStmt->execute();
        $user_id = $conn->insert_id;  // Get the auto-generated user_id
        $userStmt->close();

        // Add credit card information
        $cardSql = "INSERT INTO Credit_Card (user_id, card_number, expDate, name) VALUES (?, ?, ?, ?)";
        $cardStmt = $conn->prepare($cardSql);
        $cardStmt->bind_param("isss", $user_id, $card_number, $exp_date, $card_name);
        $cardStmt->execute();
        $cardStmt->close();

        // Insert the ticket
        $insertTicketSql = "INSERT INTO Ticket (user_id, flight_id, reservation_date, seat_categoryId) VALUES (?, ?, ?, ?)";
        $ticketStmt = $conn->prepare($insertTicketSql);
        $ticketStmt->bind_param("iisi", $user_id, $flight_id, $date, $seat_category);
        if (!$ticketStmt->execute()) {
            throw new Exception("Error booking ticket: " . $ticketStmt->error);
        }
        $ticketStmt->close();

        // Commit Transaction
        $conn->commit();
        echo "Ticket booked successfully!";
    } catch (Exception $e) {
        $conn->rollback(); // Rollback transaction on error
        echo "Transaction failed: " . $e->getMessage();
    }

    $conn->close();
}