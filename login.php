<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airline_db";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a select statement
    $sql = "SELECT id, username, password, is_admin FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Bind result variables
        $stmt->bind_result($id, $username, $hashed_password, $is_admin);
        $stmt->fetch();
        if (!isset($_SESSION['isAdmin'])) {
            header("Location: flights.php");
            exit();
          }
         else {
            // Display an error message if password is not valid
            $login_err = "Invalid username or password.";
        }
    } else {
        // Display an error message if username doesn't exist
        $login_err = "Invalid username or password.";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Airline System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #333;
            margin: 0;
            color: #fff; 
        }

        .login-form {
            padding: 40px;
            background: #222; 
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
            width: 400px;
        }

        h1 {
            color: #ccc; 
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 15px;
            margin-top: 10px;
            margin-bottom: 10px;
            border: 1px solid #444; 
            border-radius: 5px;
            background-color: #333; 
            color: #ddd; 
            font-size: 16px;
        }

        button {
            width: 99%;
            padding: 15px;
            background-color: #0056b3; 
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #00449

        .guest-button {
            margin-top: 20px;
            background-color: #444; 
            color: #ccc; 
        }

        .guest-button:hover {
            background-color: #333; 
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h1>Login to Admin</h1>
        <form action="authenticate.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <div>
                <button class="login" onclick="window.location.href='index_admin';">Log in</button>

            </div>
        </form>
        <button class="guest-button" onclick="window.location.href='index.html';">Continue as Guest</button>
    </div>
</body>
</html>
