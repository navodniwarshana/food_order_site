<?php

// Include the database connection file
include 'connect.php';

// Start the session
session_start();

// Remove all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user to the home page
header('location:../home.php');

?>