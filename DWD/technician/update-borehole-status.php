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
    <h2>Update Borehole Status</h2>

    <p>List of Boreholes assigned to you (example static data).</p>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Borehole Name</th>
                <th>Current Status</th>
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example data -->
            <tr>
                <td>1</td>
                <td>Borehole A</td>
                <td>Working</td>
                <td>
                    <form method="POST" action="">
                        <select name="status">
                            <option value="Working">Working</option>
                            <option value="Faulty">Faulty</option>
                        </select>
                        <button type="submit" name="update_status">Update</button>
                    </form>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>Borehole B</td>
                <td>Faulty</td>
                <td>
                    <form method="POST" action="">
                        <select name="status">
                            <option value="Working">Working</option>
                            <option value="Faulty">Faulty</option>
                        </select>
                        <button type="submit" name="update_status">Update</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>

    <?php
    // Temporary status update handler (without DB)
    if (isset($_POST['update_status'])) {
        $newStatus = $_POST['status'] ?? '';
        if ($newStatus) {
            echo "<p style='color:green;'>Status updated to: " . htmlspecialchars($newStatus) . "</p>";
        }
    }
    ?>
 </main>
</div>
<?php include("../includes/footer.php"); ?>
