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

// Fetch assigned tasks
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
        

        

        <!-- Tasks Table -->
        <h2>Assigned Maintenance Tasks</h2>
        <?php if(count($tasks) > 0): ?>
            <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Borehole</th>
                        <th>Issue</th>
                        <th>Current Status</th>
                        <th>Update Status</th>
                        <th>Date Reported</th>
                        <th>Date Completed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tasks as $task): 
                        $status = $task['status'] ?? 'Pending';
                        $color = ($status=='Pending')?'orange':(($status=='In progress')?'blue':'green');
                    ?>
                        <tr>
                            <td><?= $task['id']; ?></td>
                            <td><?= htmlspecialchars($task['borehole_name']); ?></td>
                            <td><?= htmlspecialchars($task['reported_issue']); ?></td>

                            <!-- Current Status -->
                            <td class="current-status" data-id="<?= $task['id']; ?>" style="color:<?= $color ?>; font-weight:bold;"><?= htmlspecialchars($status); ?></td>

                            <!-- Update Status Dropdown -->
                            <td>
                                <select class="update-status" data-id="<?= $task['id']; ?>" style="color:<?= $color ?>; font-weight:bold;">
                                    <option value="Pending" <?= $status=='Pending'?'selected':'' ?>>Pending</option>
                                    <option value="In progress" <?= $status=='In progress'?'selected':'' ?>>In progress</option>
                                    <option value="Completed" <?= $status=='Completed'?'selected':'' ?>>Completed</option>
                                </select>
                            </td>

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

<script>
// AJAX status update
document.querySelectorAll('.update-status').forEach(select => {
    select.addEventListener('change', function(){
        const taskId = this.dataset.id;
        const status = this.value;
        const currentCell = document.querySelector(`.current-status[data-id='${taskId}']`);

        fetch('update-status.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: `task_id=${taskId}&status=${encodeURIComponent(status)}`
        })
        .then(res => res.text())
        .then(data => {
            // Update current status cell dynamically
            currentCell.textContent = status;

            // Change color dynamically
            let color = 'black';
            if(status=='Pending') color='orange';
            else if(status=='In progress') color='blue';
            else if(status=='Completed') color='green';
            currentCell.style.color = color;
            this.style.color = color;
        })
        .catch(err => alert('Error updating status'));
    });
});
</script>

<?php include("../includes/footer.php"); ?>