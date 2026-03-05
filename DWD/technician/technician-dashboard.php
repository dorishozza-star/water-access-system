<?php
session_start();
include("../database.php");

// Restrict access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'technician') {
    header("Location: ../login.php");
    exit();
}

// Check if logged in
if (!isset($_SESSION['role'])) {
    redirectToLogin();
}

// Role-specific check
if ($_SESSION['role'] !== 'technician') {
    echo "<p style='text-align:center; margin-top:50px; font-family:Arial;'>
            You do not have permission to access this page. <br>
            <a href='/DWD/index.php'>Go to Home Page</a>
          </p>";
    exit();
}

$tech_id = $_SESSION['user_id'];

// Count assigned tasks
$stmt = $conn->prepare("SELECT COUNT(*) FROM maintenance_tasks WHERE assigned_to = ?");
$stmt->execute([$tech_id]);
$assigned_count = $stmt->fetchColumn();

// Count completed tasks
$stmt2 = $conn->prepare("SELECT COUNT(*) FROM maintenance_tasks WHERE assigned_to = ? AND status = 'Completed'");
$stmt2->execute([$tech_id]);
$completed_count = $stmt2->fetchColumn();
?>



<?php include("../includes/header.php");?>

<div class = "dashboard-container"> 

<?php include("../includes/sidebar.php"); // Technician sidebar ?>
 <main class="dashboard">
    <h2>Technician Dashboard</h2>
     <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>


    <div class="cards">
        <div class="card">
            <h4>Assigned Maintenance Tasks</h4>
              <a href="assigned-maintenance-tasks.php">  <?= $assigned_count ?></a>
        </div>

        
        <div class="card">
            <h4>Completed Repairs:</h4>
                    <?= $completed_count ?>
        </div>
    </div>
  </main>
</div>

<?php include("../includes/footer.php"); ?>
