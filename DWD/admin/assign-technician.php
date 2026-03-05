<?php
session_start();
include("../database.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];

// Fetch technicians only
$stmt = $conn->prepare("SELECT id, username FROM users WHERE role = 'technician'");
$stmt->execute();
$technicians = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['assign'])) {

    $technician_id = $_POST['technician'];

    $update = $conn->prepare("
        UPDATE maintenance_tasks
        SET assigned_to = ?, status = 'Assigned'
        WHERE id = ?
    ");
    $update->execute([$technician_id, $id]);

    header("Location: view-maintenance.php");
    exit();
}
?>


<?php include("../includes/header.php"); ?>
<div class="dashboard-container">
    <?php include("../includes/sidebar.php"); ?>

 <main class="dashboard">
      <h2>Assign Technician</h2>
     
    
      <div class = "login-box"> 
        <form method="POST">
          <select name="technician" required>
              <option value="">Select Technician</option>
                  <?php foreach ($technicians as $tech): ?>
                     <option value="<?= $tech['id']; ?>">
                  <?= htmlspecialchars($tech['username']); ?>
               </option>
                <?php endforeach; ?>
           </select>

             <br><br>

             <button type="submit" name="assign">Assign</button>
       </form>
      
      </div>
 </main>
</div>
