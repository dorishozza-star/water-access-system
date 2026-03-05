<?php
session_start();
include("../database.php"); // adjust path if needed

// Restrict access to admin only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle form submission for adding a new borehole
if (isset($_POST['add_borehole'])) {
    $name = $_POST['borehole_name'] ?? '';
    $location = $_POST['location'] ?? '';
    $status = $_POST['status'] ?? 'Working';

    if ($name && $location) {
        $stmt = $conn->prepare("INSERT INTO boreholes (borehole_name, location, status) VALUES (?, ?, ?)");
        $stmt->execute([$name, $location, $status]);
        $success = "Borehole added successfully!";
    } else {
        $error = "All fields are required!";
    }
}

// Fetch all boreholes from the database
$stmt = $conn->query("SELECT * FROM boreholes ORDER BY id DESC");
$boreholes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("../includes/header.php"); ?>


<div class="dashboard-container">
<?php include("../includes/sidebar.php"); ?>
  
  <main class="dashboard">
    <h2>Manage Boreholes</h2>

    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <!-- Add Borehole Form -->
    <section>
        <h3>Add New Borehole</h3>
        <form method="POST" action="">
            <label>Borehole Name</label><br>
            <input type="text" name="borehole_name" required><br><br>

            <label>Location</label><br>
            <input type="text" name="location" required><br><br>

            <label>Status</label><br>
            <select name="status">
                <option value="Working">Working</option>
                <option value="Faulty">Faulty</option>
                <option value="Faulty">Pending</option>
            </select><br><br>

            <button type="submit" name="add_borehole">Add Borehole</button>
        </form>
    </section>

    <hr>

    <!-- Borehole Table -->
    <section>
        <h3>Existing Boreholes</h3>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($boreholes as $b) : ?>
                <tr>
                    <td><?= htmlspecialchars($b['id']) ?></td>
                    <td><?= htmlspecialchars($b['borehole_name']) ?></td>
                    <td><?= htmlspecialchars($b['location']) ?></td>
                    <td><?= htmlspecialchars($b['status']) ?></td>
                   <td>
                       <a href="edit-borehole.php?id=<?= $b['id'] ?>">Edit</a> |
                       <a href="delete-borehole.php?id=<?= $b['id'] ?>"
                         onclick="return confirm('Are you sure you want to delete this borehole?');">
                          Delete
                       </a>
                   </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

 </main>
</div>

<?php include("../includes/footer.php"); ?>
