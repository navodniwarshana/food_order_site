<?php

require_once __DIR__ . '/vendor/autoload.php';

$connectionString = 'mongodb://localhost:27017';
$databaseName = 'food_db';

$conn = new MongoDB\Driver\Manager($connectionString);

// Create a new query to fetch data from a collection
$query = new MongoDB\Driver\Query([]); // Empty query to fetch all documents
$cursor = $conn->executeQuery("$databaseName.collection_name", $query); // Replace 'collection_name' with your actual collection name

foreach ($cursor as $document) {
    print_r($document); // Output each document
}

?>