<?php
session_start();
include("../database.php"); // adjust path if needed

// Only admin can delete
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM boreholes WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: manage-boreholes.php"); // redirect back
    exit();
} else {
    header("Location: manage-boreholes.php");
    exit();
}
?>
