<?php
session_start();
session_unset();       
session_destroy();      

header("Location: login.php");   //take user to login page
exit;                  
?>