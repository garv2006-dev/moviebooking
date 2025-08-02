<?php
require 'db.php';

$result = $conn->query("SELECT * FROM movies");
$movies = [];

while ($row = $result->fetch_assoc()) {
    $movies[] = $row;
}

echo json_encode($movies);
?>
