<?php
include 'db.php';
// header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM offers");
$offers = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($offers);
?>