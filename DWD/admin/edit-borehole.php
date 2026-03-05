<?php
session_start();
include("../database.php"); // adjust path if needed

// Only admin can edit
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Get borehole ID
$id = $_GET['id'] ?? 0;

// Fetch current borehole details
$stmt = $conn->prepare("SELECT * FROM boreholes WHERE id = ?");
$stmt->execute([$id]);
$borehole = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$borehole) {
    header("Location: manage-boreholes.php");
    exit();
}

// Handle form submission
if (isset($_POST['update_borehole'])) {
    $name = $_POST['borehole_name'];
    $location = $_POST['location'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE boreholes SET borehole_name = ?, location = ?, status = ? WHERE id = ?");
    $stmt->execute([$name, $location, $status, $id]);

    header("Location: manage-boreholes.php");
    exit();
}
?>

<?php include("../includes/header.php"); ?>


<div class="dashboard-container">
   <?php include("../includes/sidebar.php"); ?>

  <main class="dashboard">
    <h2>Edit Borehole</h2>

    <form method="POST" action="">
        <label>Borehole Name</label><br>
        <input type="text" name="borehole_name" value="<?= htmlspecialchars($borehole['borehole_name']) ?>" required><br><br>

        <label>Location</label><br>
        <input type="text" name="location" value="<?= htmlspecialchars($borehole['location']) ?>" required><br><br>

        <label>Status</label><br>
        <select name="status">
            <option value="Working" <?= $borehole['status'] === 'Working' ? 'selected' : '' ?>>Working</option>
            <option value="Faulty" <?= $borehole['status'] === 'Faulty' ? 'selected' : '' ?>>Faulty</option>
        </select><br><br>

        <button type="submit" name="update_borehole">Update Borehole</button>
    </form>
  </main>
</div>

<?php include("../includes/footer.php"); ?>
