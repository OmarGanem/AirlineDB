<?php
session_start();

// Hardcoded credentials
$admin_username = 'admin';
$admin_password = 'admin';

if ($_POST['username'] === $admin_username && $_POST['password'] === $admin_password) {
    $_SESSION['logged_in'] = true;
    header('Location: flights.php');
} else {
    echo 'Incorrect username or password.';
}
exit;
?>
