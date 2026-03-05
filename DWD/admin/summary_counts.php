<?php
session_start();
include("../database.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode([]);
    exit();
}

$counts_stmt = $conn->query("
    SELECT
        (SELECT COUNT(*) FROM boreholes) AS total,
        (SELECT COUNT(*) FROM boreholes WHERE status='working') AS active,
        (SELECT COUNT(*) FROM boreholes WHERE status='faulty') AS faulty,
        (SELECT COUNT(*) FROM maintenance_tasks WHERE status='Pending') AS pending
");
$counts = $counts_stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($counts);