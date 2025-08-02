<?php
require 'db.php';

// Check if POST values exist
if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['image'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image']; // base64 format

    // Save to database
    $stmt = $conn->prepare("INSERT INTO movies (name, price, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $price, $image);
    
    if ($stmt->execute()) {
        echo "Movie added successfully";
    } else {
        echo "Database insert failed: " . $stmt->error;
    }
} else {
    echo "Missing fields!";
}
?>
