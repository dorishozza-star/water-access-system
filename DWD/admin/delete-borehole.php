<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

/* Later:
include database
$id = $_GET['id'];
DELETE FROM boreholes WHERE id = $id;
*/

header("Location: manage-boreholes.php");
exit();
