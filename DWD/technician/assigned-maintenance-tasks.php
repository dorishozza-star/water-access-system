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
?>


<?php include("../includes/header.php"); ?>

<div class="dashboard-container">
    <?php include("../includes/sidebar.php"); ?>

 <main class="dashboard">
    <h2>Assigned Maintenance Tasks</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Borehole Name</th>
                <th>Issue</th>
                <th>Date Assigned</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Borehole B</td>
                <td>Pump not working</td>
                <td>2026-01-12</td>
                <td>Pending</td>
                <td><a href="#">Mark Complete</a></td>
            </tr>
        </tbody>
    </table>
 </main>
</div>

<?php include("../includes/footer.php"); ?>
