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
    <h2>Report an Issue</h2>

    <form method="POST" action="">
        <label>Borehole Name:</label><br>
        <input type="text" name="borehole_name" required><br><br>

        <label>Issue Description:</label><br>
        <textarea name="issue" rows="4" required></textarea><br><br>

        <button type="submit" name="submit_issue">Submit Report</button>
    </form>

    <?php
    if (isset($_POST['submit_issue'])) {
        $borehole = $_POST['borehole_name'];
        $issue = $_POST['issue'];
        echo "<p style='color:green;'>Your report for <strong>".htmlspecialchars($borehole)."</strong> has been submitted.</p>";
    }
    ?>
 </main>
</div>
<?php include("../includes/footer.php"); ?>
