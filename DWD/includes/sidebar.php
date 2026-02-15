<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<aside class="sidebar">
    <h2>Menu</h2>
    <ul>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <li><a href="admin-dashboard.php">Dashboard</a></li>
            <li><a href="manage-boreholes.php">Manage Boreholes</a></li>
            <li><a href="view-maintenance.php">View Maintenance</a></li>
            <li><a href="reports.php">Reports</a></li>
        <?php elseif ($_SESSION['role'] === 'technician'): ?>
            <li><a href="technician-dashboard.php">Dashboard</a></li>
            <li><a href="assigned-maintenance-tasks.php">Assigned Maintenance</a></li>
            <li><a href="update-borehole-status.php">Update Boreholes</a></li>
        <?php elseif ($_SESSION['role'] === 'community'): ?>
            <li><a href="community-dashboard.php">Dashboard</a></li>
            <li><a href="report-issue.php">Report Issue</a></li>
            <li><a href="view-reports.php ">My Reports </a></li>
        <?php endif; ?>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
</aside>
