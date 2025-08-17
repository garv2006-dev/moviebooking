<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    // Check if the username exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If user is found, redirect to reset password page
        $_SESSION['user_to_reset'] = $username;
        header("Location: reset_password.php");
        exit();
    } else {
        $error = "This username was not found!";
    }
    $stmt->close();
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
    <!-- <p>Enter your username to reset your password.</p> -->
    <form method="post">
        <input type="text" name="username" placeholder="Enter your username" required>
        <button type="submit">Verify Username</button>
    </form>
    
    <?php if (isset($error)) { echo "<p style='color:red; margin-top:10px;'>$error</p>"; } ?>

    <a href="index.php">Back to Login</a>
</div>
</body>
</html>
