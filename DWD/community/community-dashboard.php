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
if ($_SESSION['role'] !== 'community') {
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
    <h2>Community Dashboard</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

    <div class="cards">
        <div class="card">Report an Issue</a
        ></div>
        <div class="card">View My Reports</a></div>
    </div>
</main>
</div>
<?php include("../includes/footer.php"); ?>