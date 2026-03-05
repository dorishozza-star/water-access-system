<?php
session_start();
include("../database.php");

// Restrict access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'technician') {
    header("Location: ../login.php");
    exit();
}

$tech_id = $_SESSION['user_id'];

// Fetch counts for dashboard cards
$stmtTotal = $conn->prepare("SELECT COUNT(*) as total FROM maintenance_tasks WHERE assigned_to = ?");
$stmtTotal->execute([$tech_id]);
$totalTasks = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

$stmtInProgress = $conn->prepare("SELECT COUNT(*) as in_progress FROM maintenance_tasks WHERE assigned_to = ? AND status='In progress'");
$stmtInProgress->execute([$tech_id]);
$inProgress = $stmtInProgress->fetch(PDO::FETCH_ASSOC)['in_progress'];

$stmtCompleted = $conn->prepare("SELECT COUNT(*) as completed FROM maintenance_tasks WHERE assigned_to = ? AND status='Completed'");
$stmtCompleted->execute([$tech_id]);
$completed = $stmtCompleted->fetch(PDO::FETCH_ASSOC)['completed'];

// Fetch assigned tasks for table
$stmt = $conn->prepare("
    SELECT mt.id, mt.reported_issue, mt.status, mt.date_reported, mt.date_completed,
           b.borehole_name
    FROM maintenance_tasks mt
    JOIN boreholes b ON mt.borehole_id = b.id
    WHERE mt.assigned_to = ?
    ORDER BY mt.date_reported DESC
");
$stmt->execute([$tech_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../includes/header.php"); ?>

<div class="dashboard-container">
    <?php include("../includes/sidebar.php"); ?>

    <main class="dashboard">
       

        <!-- Assigned Tasks Table -->
        <h2>Assigned Maintenance Tasks</h2>
        <?php if(count($tasks) > 0): ?>
            <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Borehole</th>
                        <th>Issue</th>
                        <th>Status</th>
                        <th>Date Reported</th>
                        <th>Date Completed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tasks as $task): 
                        $status = $task['status'] ?? 'Pending';
                        $color = 'black';
                        if ($status === 'Pending') $color = 'orange';
                        elseif ($status === 'In progress') $color = 'blue';
                        elseif ($status === 'Completed') $color = 'green';
                    ?>
                        <tr>
                            <td><?= $task['id']; ?></td>
                            <td><?= htmlspecialchars($task['borehole_name']); ?></td>
                            <td><?= htmlspecialchars($task['reported_issue']); ?></td>
                            <td style="color: <?= $color; ?>; font-weight:bold;"><?= htmlspecialchars($status); ?></td>
                            <td><?= $task['date_reported']; ?></td>
                            <td><?= $task['date_completed'] ?? '—'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No assigned tasks yet.</p>
        <?php endif; ?>

    </main>
</div>

<?php include("../includes/footer.php"); ?>