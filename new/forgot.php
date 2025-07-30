<?php
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $sql = "SELECT password FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<script>alert('Your password is: " . $row['password'] . "');</script>";
    } else {
        echo "<script>alert('Username not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Forgot Password</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Enter your username" required>
        <button type="submit">Retrieve Password</button>
    </form>
    <a href="index.php">Back to Login</a>
</div>
</body>
</html>
r