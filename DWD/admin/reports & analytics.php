<?php
session_start();
include("../database.php");

// -------------------- Access Control --------------------
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// -------------------- Borehole Health --------------------
$health_stmt = $conn->query("
    SELECT b.id, b.borehole_name,
           COALESCE(mt.status, 'No Reports') AS status
    FROM boreholes b
    LEFT JOIN (
        SELECT borehole_id, status
        FROM maintenance_tasks
        WHERE date_reported = (
            SELECT MAX(date_reported)
            FROM maintenance_tasks mt2
            WHERE mt2.borehole_id = maintenance_tasks.borehole_id
        )
    ) mt ON b.id = mt.borehole_id
");
$boreholes = $health_stmt->fetchAll(PDO::FETCH_ASSOC);

// -------------------- Maintenance History --------------------
$history_stmt = $conn->query("
    SELECT mt.id, mt.reported_issue, mt.status, mt.date_reported, mt.date_completed,
           b.borehole_name,
           COALESCE(u.username,'Not Assigned') AS technician
    FROM maintenance_tasks mt
    JOIN boreholes b ON mt.borehole_id = b.id
    LEFT JOIN users u ON mt.assigned_to = u.id
    ORDER BY mt.date_reported DESC
");
$history = $history_stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("../includes/header.php"); ?>
<div class="dashboard-container">
    <?php include("../includes/sidebar.php"); ?>

    <main class="dashboard">
        <h2>Admin Dashboard</h2>

        <!-- ================= Summary Cards ================= -->
        <div class="cards" style="display:flex; gap:15px; margin-bottom:20px;">
            <div class="card" id="totalBoreholes">Total Boreholes: 0</div>
            <div class="card" id="activeBoreholes" style="color:green;">Active Boreholes: 0</div>
            <div class="card" id="faultyBoreholes" style="color:red;">Faulty Boreholes: 0</div>
            <div class="card" id="pendingMaintenance" style="color:orange;">Pending Maintenance: 0</div>
        </div>

        <!-- ================= Borehole Health ================= -->
        <h3>Borehole Health</h3>
        <table border="1" cellpadding="10" cellspacing="0" style="margin-bottom:30px;">
            <thead>
                <tr>
                    <th>Borehole</th>
                    <th>Current Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($boreholes as $b): 
                    $color = 'black';
                    if($b['status']=='Pending') $color='orange';
                    elseif($b['status']=='In progress') $color='blue';
                    elseif($b['status']=='Completed') $color='green';
                ?>
                <tr>
                    <td><?= htmlspecialchars($b['borehole_name']); ?></td>
                    <td style="color:<?= $color ?>; font-weight:bold;"><?= $b['status']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- ================= Maintenance History ================= -->
        <h3>Maintenance History</h3>
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
                </tr>
            </thead>
            <tbody>
                <?php foreach($history as $h): 
                    $color = 'black';
                    if($h['status']=='Pending') $color='orange';
                    elseif($h['status']=='In progress') $color='blue';
                    elseif($h['status']=='Completed') $color='green';
                ?>
                <tr>
                    <td><?= $h['id']; ?></td>
                    <td><?= htmlspecialchars($h['borehole_name']); ?></td>
                    <td><?= htmlspecialchars($h['reported_issue']); ?></td>
                    <td><?= htmlspecialchars($h['technician']); ?></td>
                    <td style="color:<?= $color ?>; font-weight:bold;"><?= $h['status']; ?></td>
                    <td><?= $h['date_reported']; ?></td>
                    <td><?= $h['date_completed'] ?? '—'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </main>
</div>
<?php include("../includes/footer.php"); ?>

<!-- ================= AJAX for Dynamic Cards ================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateCards() {
    $.getJSON('summary_counts.php', function(data) {
        $('#totalBoreholes').text('Total Boreholes: ' + data.total);
        $('#activeBoreholes').text('Active Boreholes: ' + data.active);
        $('#faultyBoreholes').text('Faulty Boreholes: ' + data.faulty);
        $('#pendingMaintenance').text('Pending Maintenance: ' + data.pending);
    });
}

// Initial load
updateCards();

// Refresh every 5 seconds
setInterval(updateCards, 5000);
</script>