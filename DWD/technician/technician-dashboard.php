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
if ($_SESSION['role'] !== 'technician') {
    echo "<p style='text-align:center; margin-top:50px; font-family:Arial;'>
            You do not have permission to access this page. <br>
            <a href='/DWD/index.php'>Go to Home Page</a>
          </p>";
    exit();
}


include("../includes/header.php");

?>

<div class = "dashboard-container"> 

<?php include("../includes/sidebar.php"); // Technician sidebar ?>
 <main class="dashboard">
    <h2>Technician Dashboard</h2>
     <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>


    <div class="cards">
        <div class="card">
            <h4>Assigned Maintenance Tasks</h4>
             <p>
            <?php 
            // Temporary count (later from DB)
            $assignedTasks = 5;
            echo $assignedTasks;
            ?>
        </p>
        </div>

        <div class="card">
            <h4>Update Borehole Status</h4>
             <p>
            <?php 
            // Temporary count
            $pendingUpdates = 3;
            echo $pendingUpdates;
            ?>
        </p>
        </div>
        <div class="card">
            <h4>Completed Repairs</h4>
              <p>
            <?php 
            // Temporary count
            $completedRepairs = 2;
            echo $completedRepairs;
            ?>
        </p>
        </div>
    </div>
  </main>
</div>

<?php include("../includes/footer.php"); ?>
