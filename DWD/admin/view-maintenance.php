<?php
session_start();
include("../database.php");

// Restrict access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch maintenance tasks
$stmt = $conn->query("
    SELECT maintenance_tasks.id,
           maintenance_tasks.reported_issue,
           maintenance_tasks.status,
           maintenance_tasks.date_reported,
           maintenance_tasks.date_completed,
           boreholes.borehole_name,
           users.username AS technician_name
    FROM maintenance_tasks
    JOIN boreholes ON maintenance_tasks.borehole_id = boreholes.id
    LEFT JOIN users ON maintenance_tasks.assigned_to = users.id
    ORDER BY maintenance_tasks.date_reported DESC
");

$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../includes/header.php"); ?>



<div class="dashboard-container">
  <?php include("../includes/sidebar.php"); ?>

 <main class="dashboard">
    <h2>Maintenance Tasks</h2>

    <?php if (count($tasks) > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Borehole</th>
                    <th>Issue</th>
                    <th>Technician</th>
                    <th>Status</th>
                    <th>Date Reported</th>
                    <th>Date Completed</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): 
                    $color = ($task['status']=='Pending')?'orange':(($task['status']=='Inprogress')?'blue':'green');
                    ?>
                    <tr>
                        <td><?= $task['id']; ?></td>
                        <td><?= htmlspecialchars($task['borehole_name']); ?></td>
                        <td><?= htmlspecialchars($task['reported_issue']); ?></td>
                        <td>
                            <?= $task['technician_name'] ? htmlspecialchars($task['technician_name']) : 'Not Assigned'; ?>
                        </td>
                        <td><?= $task['status']; ?></td>
                        <td><?= $task['date_reported']; ?></td>
                        <td><?= $task['date_completed'] ?? '—'; ?></td>
                        <td>
                          <?php if (!$task['technician_name']) : ?>
                          <a href="assign-technician.php?id=<?= $task['id']; ?>">
                           Assign Technician
                             </a>
                          <?php else: ?>
                              Assigned
                          <?php endif; ?>
                       </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No maintenance tasks found.</p>
    <?php endif; ?>
 </main>
</div>
<?php include("../includes/footer.php"); ?>
