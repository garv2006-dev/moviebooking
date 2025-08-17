<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

       
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;

           
            if ($username === "garv") {
                echo "<script>
                    alert('Admin Login Successful');
                    window.location.href='http://localhost/garv/admin.php';
                </script>";
            } else {
             
                echo "<script>
                    alert('Login Successful');
                    window.location.href='http://localhost/garv/index.html';
                </script>";
            }
        } else {
           
            echo "<script>
                alert('Invalid Credentials');
                window.location.href='index.php';
            </script>";
        }
    } else {
       
        echo "<script>
            alert('Invalid Credentials');
            window.location.href='index.php';
        </script>";
    }
    $stmt->close();
}
?>