<?php
// સેશન શરૂ કરો જેથી તેને એક્સેસ કરી શકાય
session_start();

// સેશનના બધા વેરિએબલ્સને અનસેટ કરો
$_SESSION = array();

// સેશનનો નાશ કરો
session_destroy();

// યુઝરને સાચા index.html પેજ પર પાછા મોકલો (એક ડિરેક્ટરી બહાર)
header("Location: ../index.html");
exit();
?>