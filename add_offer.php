<?php
include 'db.php';

$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$category = $_POST['category'];
$image = $_POST['image']; // base64

$sql = "INSERT INTO offers (name, price, description, category, image) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $price, $description, $category, $image);

if ($stmt->execute()) {
    echo "Offer added successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
