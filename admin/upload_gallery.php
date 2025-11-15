<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once("../config/db.php");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
</head>
<body>
</body>
</html>
