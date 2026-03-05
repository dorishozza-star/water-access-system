<?php
session_start();

// Redirect to login if not logged in
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

// Include PDO database connection
include("../database.php");
?>

<?php include("../includes/header.php"); ?>
<div class="dashboard-container">
  <?php include("../includes/sidebar.php"); ?>

  <main class="dashboard">
    <h2>Report an Issue</h2>

    <form method="POST" action="">
        <label>Borehole:</label><br>
        <select name="borehole_id" required>
            <option value="">-- Select Borehole --</option>
            <?php
            // Fetch boreholes dynamically from database (only 'working')
            $stmt = $conn->prepare("SELECT id, borehole_name FROM boreholes WHERE status='working' ORDER BY borehole_name ASC");
            $stmt->execute();
            $boreholes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($boreholes as $row) {
                echo "<option value='".htmlspecialchars($row['id'])."'>".htmlspecialchars($row['borehole_name'])."</option>";
            }
            ?>
        </select><br><br>

        <label>Issue Description:</label><br>
        <textarea name="issue" rows="4" required></textarea><br><br>

        <button type="submit" name="submit_issue">Submit Report</button>
    </form>

    <?php
    if (isset($_POST['submit_issue'])) {
        // Validate inputs
        if (!empty($_POST['borehole_id']) && !empty($_POST['issue'])) {
            $borehole_id = $_POST['borehole_id'];
            $issue = $_POST['issue'];

            // Insert into maintenance_tasks table
            $insert_stmt = $conn->prepare("
                INSERT INTO maintenance_tasks (borehole_id, reported_issue, date_reported, status)
                VALUES (:borehole_id, :reported_issue, NOW(), 'Pending')
            ");
            $insert_stmt->bindParam(':borehole_id', $borehole_id, PDO::PARAM_INT);
            $insert_stmt->bindParam(':reported_issue', $issue, PDO::PARAM_STR);

            if ($insert_stmt->execute()) {
                echo "<p style='color:green;'>Your report has been submitted successfully.</p>";
            } else {
                echo "<p style='color:red;'>Error submitting report.</p>";
            }

        } else {
            echo "<p style='color:red;'>Please select a borehole and describe the issue.</p>";
        }
    }
    ?>
  </main>
</div>
<?php include("../includes/footer.php"); ?>