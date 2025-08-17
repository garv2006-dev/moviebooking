<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // પાસવર્ડને હેશ કરો (સુરક્ષા માટે)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // યુઝર અસ્તિત્વમાં છે કે નહીં તે તપાસો
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('આ યુઝરનેમ પહેલેથી જ અસ્તિત્વમાં છે!'); window.location.href='register.php';</script>";
    } else {
        // નવો યુઝર ઉમેરો
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            echo "<script>alert('તમારું રજીસ્ટ્રેશન સફળ થયું! હવે લોગિન કરો.'); window.location.href='index.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
<div class="container">
    <h2>Register</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
    <a href="index.php">Already have an account? Login</a>
</div>
</body>
</html>