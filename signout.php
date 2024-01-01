<?php
session_start(); // Make sure to start the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or any other page after logout
header("Location: signup-signin.php");
exit();
?>