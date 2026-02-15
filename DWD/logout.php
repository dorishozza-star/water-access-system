<?php
session_start();
$_SESSION = array();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logging out...</title>
    <meta http-equiv="refresh" content="2;url=login.php">
    <style>
        body { text-align:center; font-family:sans-serif; margin-top:50px; }
    </style>
</head>
<body>
    <h2>You have been logged out successfully.</h2>
    <p>Redirecting to login page...</p>
</body>
</html>
