<?php

// Include the database connection
include 'connect.php';

// Start the session
session_start();

// Remove all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user to the admin login page
header('location:../admin/admin_login.php');

?>