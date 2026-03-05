<?php
session_start();
include("../database.php");

// -------------------- Access Control --------------------
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
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

