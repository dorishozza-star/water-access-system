<?php
session_start();
include("../database.php");

if(!isset($_SESSION['role']) || $_SESSION['role']!=='technician'){
    http_response_code(403);
    exit('Forbidden');
}

if(isset($_POST['task_id'], $_POST['status'])){
    $stmt = $conn->prepare("UPDATE maintenance_tasks SET status = :status WHERE id = :id");
    $stmt->execute([
        ':status' => $_POST['status'],
        ':id' => $_POST['task_id']
    ]);
    echo "Success";
} else {
    http_response_code(400);
    echo "Invalid request";
}
?>