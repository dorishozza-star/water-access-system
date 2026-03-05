
<?php
session_start();

// Only community can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'community') {
    die("Access denied.");
}

include("../database.php");
?>

<?php include("../includes/header.php"); ?>
<div class="dashboard-container">
  <?php include("../includes/sidebar.php"); ?>

  <main class="dashboard">
    <h2>My Submitted Maintenance Reports</h2>

    <table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Borehole</th>
                <th>Reported Issue</th>
                <th>Status</th>
                <th>Date Reported</th>
                <th>Date Completed</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Fetch all tasks submitted by the community
        $stmt = $conn->prepare("
            SELECT mt.id, b.borehole_name, mt.reported_issue, mt.status, mt.date_reported, mt.date_completed
            FROM maintenance_tasks mt
            JOIN boreholes b ON mt.borehole_id = b.id
            ORDER BY mt.date_reported DESC
        ");
        $stmt->execute();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($tasks) {
            foreach ($tasks as $task)
                 {
                echo "<tr>";
                echo "<td>".htmlspecialchars($task['borehole_name'])."</td>";
                echo "<td>".htmlspecialchars($task['reported_issue'])."</td>";
                echo "<td>".htmlspecialchars($task['status'])."</td>";
                echo "<td>".htmlspecialchars($task['date_reported'])."</td>";
                echo "<td>".($task['date_completed'] ? htmlspecialchars($task['date_completed']) : '-') ."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No reports submitted yet.</td></tr>";
        }
        ?>
        </tbody>
    </table>
  </main>
</div>
<?php include("../includes/footer.php"); ?>