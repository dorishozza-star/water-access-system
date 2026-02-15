<?php
session_start();

function redirectToLogin() {
    echo "<p style='text-align:center; margin-top:50px; font-family:Arial;'>
            You must log in to access this page. <br>
            <a href='/DWD/index.php'>Go to Home Page</a> or 
            <a href='/DWD/login.php'>Login</a>
          </p>";
    exit();
}

// Check if logged in
if (!isset($_SESSION['role'])) {
    redirectToLogin();
}

// Role-specific check
if ($_SESSION['role'] !== 'admin') {
    echo "<p style='text-align:center; margin-top:50px; font-family:Arial;'>
            You do not have permission to access this page. <br>
            <a href='/DWD/index.php'>Go to Home Page</a>
          </p>";
    exit();
}
?>


<?php include("../includes/header.php"); ?>
<div class="dashboard-container">

<?php include("../includes/sidebar.php"); ?>



 <main class="dashboard">
    
    <h2>Admin Dashboard</h2>

    <div class="cards">
        <div class="card">Total Boreholes</div>
        <div class="card">Active Boreholes</div>
        <div class="card">Faulty Boreholes</div>
        <div class="card"> Pending Maintenance</div>
    </div>
 </main>
</div>
<?php include("../includes/footer.php"); ?>
