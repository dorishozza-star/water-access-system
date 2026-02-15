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


include("../includes/header.php");?>

<div class="dashboard-container">
 <?php include("../includes/sidebar.php"); // Admin sidebar?>


 <main class="dashboard">
    <h2>Maintenance Records</h2>

    <section class="card">
        <h3>Maintenance Requests</h3>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Borehole Name</th>
                    <th>Reported Issue</th>
                    <th>Date Reported</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <!-- Static data example (replace with DB later) -->
                <tr>
                    <td>1</td>
                    <td>Borehole B</td>
                    <td>Pump not working</td>
                    <td>2026-01-12</td>
                    <td>Pending</td>
                    <td>
                        <a href="mark-complete.php?id=1"
                           onclick="return confirm('Mark this maintenance request as complete?');">
                           Mark Complete
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Borehole A</td>
                    <td>Water leakage</td>
                    <td>2026-01-14</td>
                    <td>In Progress</td>
                    <td>
                        <a href="mark-complete.php?id=2"
                           onclick="return confirm('Mark this maintenance request as complete?');">
                           Mark Complete
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
 </main>
</div>
<?php include("../includes/footer.php"); ?>
