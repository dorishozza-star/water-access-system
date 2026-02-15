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
    <h2>My Submitted Reports</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Borehole Name</th>
                <th>Issue</th>
                <th>Date Reported</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example static data -->
            <tr>
                <td>1</td>
                <td>Borehole A</td>
                <td>Pump not working</td>
                <td>2026-01-12</td>
                <td>Pending</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Borehole B</td>
                <td>Low water flow</td>
                <td>2026-01-15</td>
                <td>Completed</td>
            </tr>
        </tbody>
    </table>
 </main>
</div>
<?php include("../includes/footer.php"); ?>
