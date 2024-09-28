<?php
require_once 'components/connect.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS cart (
        user_id INT,
        pid INT,
        name VARCHAR(255),
        price DECIMAL(10, 2),
        quantity INT,
        image VARCHAR(255)
    )";
    $conn->exec($sql);
    echo "Table created successfully";
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
