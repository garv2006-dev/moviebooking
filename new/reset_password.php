<?php
session_start();
include "db.php";

// જો યુઝર સીધો આ પેજ ખોલે, તો તેને પાછો મોકલો
if (!isset($_SESSION['user_to_reset'])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        // નવો પાસવર્ડ હેશ (સુરક્ષિત) કરો
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $username = $_SESSION['user_to_reset'];

        // ડેટાબેઝમાં પાસવર્ડ અપડેટ કરો
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $hashed_password, $username);
        
        if ($stmt->execute()) {
            // સેશનમાંથી યુઝરનેમ કાઢી નાખો
            unset($_SESSION['user_to_reset']);
            $success = "પાસવર્ડ સફળતાપૂર્વક બદલાઈ ગયો છે! હવે તમે લોગિન કરી શકો છો.";
        } else {
            $error = "કંઈક ભૂલ થઈ છે, કૃપા કરીને ફરી પ્રયાસ કરો.";
        }
        $stmt->close();

    } else {
        $error = "બંને પાસવર્ડ મેળ ખાતા નથી!";
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
            <input type="password" name="new_password" placeholder="Enter new password" required>
            <input type="password" name="confirm_password" placeholder="Confirm new password" required>
            <button type="submit">Reset Password</button>
        </form>
        <?php if (isset($error)) { echo "<p style='color:red; margin-top:10px;'>$error</p>"; } ?>
    <?php endif; ?>

</div>
</body>
</html>
