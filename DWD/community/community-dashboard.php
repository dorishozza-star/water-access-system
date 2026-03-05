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

include("../database.php");

// Fetch dynamic counts for the cards
$stmt1 = $conn->prepare("SELECT COUNT(*) as total_issues FROM maintenance_tasks");
$stmt1->execute();
$totalIssues = $stmt1->fetch(PDO::FETCH_ASSOC)['total_issues'];

$stmt2 = $conn->prepare("SELECT COUNT(*) as total_reports FROM maintenance_tasks WHERE status IN ('Pending','In progress','Completed')");
$stmt2->execute();
$totalReports = $stmt2->fetch(PDO::FETCH_ASSOC)['total_reports'];
?>

<?php include("../includes/header.php"); ?>

<div class="dashboard-container">
    <?php include("../includes/sidebar.php"); ?>

    <main class="dashboard">
        <h2>Community Dashboard</h2>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

        <!-- Dynamic Cards Section -->
        <div class="cards" style="margin-top:20px;"  >
            <div class="card">
                <h3>Total Issues Reported</h3>
                <?php echo $totalIssues; ?>
            </div>
            <div class="card">
                <h3>Total Reports Present</h3>
                <?php echo $totalReports; ?>
            </div>
        </div>

        
    </main>
</div>

<?php include("../includes/footer.php"); ?>