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

// Check if schedule ID is provided
if (isset($_POST['schedule_id'])) {
  $schedule_id = intval($_POST['schedule_id']);

  // Prepare delete query
  $sql = "DELETE FROM flight_schedules WHERE schedule_id = ?";
  $stmt = $conn->prepare($sql);

  // Bind parameters
  $stmt->bind_param("i", $schedule_id);

  // Execute query
  $stmt->execute();

  // Check deletion status
  if ($stmt->affected_rows > 0) {
    echo "Schedule deleted successfully!";
  } else {
    echo "Failed to delete schedule.";
  }

  // Close statement
  $stmt->close();
} else {
  echo "Invalid request.";
}

// Close connection
$conn->close();
