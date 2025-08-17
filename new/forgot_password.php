<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    // યુઝરનેમ ડેટાબેઝમાં છે કે નહીં તે તપાસો
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // જો યુઝર મળે, તો તેને પાસવર્ડ રિસેટ પેજ પર મોકલો
        $_SESSION['user_to_reset'] = $username;
        header("Location: reset_password.php");
        exit();
    } else {
        $error = "આ યુઝરનેમ મળ્યું નથી!";
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
    <!-- <p>તમારો પાસવર્ડ રિસેટ કરવા માટે તમારું યુઝરનેમ દાખલ કરો.</p> -->
    <form method="post">
        <input type="text" name="username" placeholder="Enter your username" required>
        <button type="submit">Verify Username</button>
    </form>
    
    <?php if (isset($error)) { echo "<p style='color:red; margin-top:10px;'>$error</p>"; } ?>

    <a href="index.php">Back to Login</a>
</div>
</body>
</html>