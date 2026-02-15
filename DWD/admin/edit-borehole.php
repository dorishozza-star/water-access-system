<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit();
}
?>

<?php
include("../includes/header.php");
include("../includes/sidebar.php");

/* Later:
$id = $_GET['id'];
Fetch borehole from DB using ID
*/
?>

<main class="dashboard">
    <h2>Edit Borehole</h2>

    <section class="card">
        <form method="POST" action="">
            <label>Borehole Name</label>
            <input type="text" name="borehole_name" value="Borehole A" required>

            <label>Location</label>
            <input type="text" name="location" value="Village X" required>

            <label>Status</label>
            <select name="status">
                <option value="Working" selected>Working</option>
                <option value="Faulty">Faulty</option>
            </select>

            <button type="submit" name="update_borehole">
                Update Borehole
            </button>
        </form>
    </section>
</main>

<?php include("../includes/footer.php"); ?>
