<?php
session_start();
// If the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        .logout-container {
            text-align: center;
        }
        .logout-container h2 {
            margin-bottom: 20px;
        }
        .logout-container p {
            margin-bottom: 20px;
            font-size: 18px;
        }
        .logout-button {
            display: inline-block;
            width: 80%;
            padding: 12px;
            background: #d9534f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            margin-top: 15px;
        }
        .logout-button:hover {
            background: #c9302c;
        }
        .security-warning {
            color: red;
            font-weight: bold;
            margin-top: 25px;
            border: 1px solid red;
            padding: 10px;
            border-radius: 5px;
            background-color: #fdd;
        }
    </style>
</head>
<body>
    <div class="container logout-container">
        <h2>Logout Confirmation</h2>
        <p>You are logged in as <strong><?php echo htmlspecialchars($username); ?></strong>.</p>
        
        <p>Are you sure you want to log out?</p>
        
        <a href="logout.php" class="logout-button">Yes, Logout</a>
        <a href="../index.html" style="margin-top: 15px;">No, Go Back</a>

        <div class="security-warning">
            <strong>Important Security Note:</strong> For your safety, we cannot display your password here. 
            Any system that shows your password after login is not secure.
        </div>
    </div>
</body>
</html>
