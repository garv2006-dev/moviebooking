<?php
session_start();
// જો યુઝર લોગિન ન હોય, તો તેને લોગિન પેજ પર મોકલો
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
        <p>તમે <strong><?php echo htmlspecialchars($username); ?></strong> તરીકે લોગિન છો.</p>
        
        <p>શું તમે ખરેખર લોગઆઉટ કરવા માંગો છો?</p>
        
        <a href="logout.php" class="logout-button">હા, લોગઆઉટ કરો</a>
        <a href="index.html" style="margin-top: 15px;">ના, પાછા જાઓ</a>

        <div class="security-warning">
            <strong>મહત્વપૂર્ણ સુરક્ષા નોંધ:</strong> તમારી સુરક્ષા માટે, અમે અહીં તમારો પાસવર્ડ બતાવી શકતા નથી. કોઈપણ સિસ્ટમ જે લોગિન પછી તમારો પાસવર્ડ બતાવે તે સુરક્ષિત નથી.
        </div>
    </div>
</body>
</html>