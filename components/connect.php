<?php

// Define the database name with its host and database name
$db_name = 'mysql:host=localhost;dbname=food_db';
// Define the username for the database connection
$user_name = 'root';
// Define the password for the database connection
$user_password = '';

// Create a new PDO instance to connect to the database
$conn = new PDO($db_name, $user_name, $user_password);

?>