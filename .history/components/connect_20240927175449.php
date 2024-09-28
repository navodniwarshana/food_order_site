<?php

require_once __DIR__ . '/vendor/autoload.php';

$connectionString = 'mongodb://localhost:27017';
$databaseName = 'food_db';

$conn = new MongoDB\Driver\Manager($connectionString);

?>