<?php
// This automatically finds the root of your project
$project_root = dirname($_SERVER['SCRIPT_NAME']);
// Ensure the root ends with a slash, but avoid double slashes
$base_url = rtrim($project_root, '/\\') . '/';?>

<?php
// This finds the folder name 'DWD' automatically
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/DWD/';
?>

<link rel="stylesheet" href="<?php echo $root; ?>assets/css/style.css">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Water Access Borehole System</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?> assets/css/style.css">
</head>




