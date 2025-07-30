<?php
session_start();
include "db.php";

$username = $_POST['username'];
$password = $_POST['password'];

// Use prepared statements for security (prevents SQL Injection)
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['username'] = $username;

    // Check if admin
    if ($username === "garv") {
        echo "<script>
            alert('Admin Login Successful');
            window.location.href='http://localhost/garv/admin.php';  // change to PHP for server access
        </script>";
    } else {
        echo "<script>
            alert('Login Successful');
            window.location.href='welcome.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Invalid Credentials');
        window.location.href='index.php';
    </script>";
}
?>
