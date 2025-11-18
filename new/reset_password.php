<?php
session_start();
include "db.php";

// If user directly opens this page, redirect back
if (!isset($_SESSION['user_to_reset'])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        // Hash the new password (secure)
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $username = $_SESSION['user_to_reset'];

        // Update password in database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $hashed_password, $username);
        
        if ($stmt->execute()) {
            // Remove username from session
            unset($_SESSION['user_to_reset']);
            $success = "Password successfully changed! You can now login.";
        } else {
            $error = "Something went wrong, please try again.";
        }
        $stmt->close();

    } else {
        $error = "Both passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Reset Your Password</h2>
    
    <?php if (isset($success)): ?>
        <p style="color:green;"><?php echo $success; ?></p>
        <a href="index.php">Go to Login</a>
    <?php else: ?>
        <form method="post">
            <input type="password" name="new_password" placeholder="Enter new password" maxlength="8" minlength="6" required>
            <input type="password" name="confirm_password" placeholder="Confirm new password" maxlength="8" minlength="6" required>
            <button type="submit">Reset Password</button>
        </form>
        <?php if (isset($error)) { echo "<p style='color:red; margin-top:10px;'>$error</p>"; } ?>
    <?php endif; ?>

</div>
</body>
</html>
