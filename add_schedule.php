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

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $flight_id = intval($_POST['flight_id']);
  $date = $_POST['date'];
  $fare = floatval($_POST['fare']);
  $available_seats = intval($_POST['available_seats']);

  // Prepare insert query
  $sql = "INSERT INTO flight_schedules (flight_id, date, fare, available_seats) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  // Bind parameters
  $stmt->bind_param("ssss", $flight_id, $date, $fare, $available_seats);

  // Execute query
  if ($stmt->execute()) {
    echo "New schedule added successfully!";
  } else {
    echo "Failed to add schedule. Error: " . $conn->error;
  }

  // Close statement
  $stmt->close();
} else {
  echo "Invalid request.";
}

// Close connection
$conn->close();
