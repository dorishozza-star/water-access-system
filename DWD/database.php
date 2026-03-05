<?php
$host = "localhost";
$dbname = "WABMS";  // Make sure this matches your DB name
$user = "root";                   // Your MySQL username
$pass = "";                        // Your MySQL password (often empty for XAMPP)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // optional for testing
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
