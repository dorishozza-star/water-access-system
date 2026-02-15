<?php
session_start();

function redirectToLogin() {
    echo "<p style='text-align:center; margin-top:50px; font-family:Arial;'>
            You must log in to access this page. <br>
            <a href='/DWD/index.php'>Go to Home Page</a> or 
            <a href='/DWD/login.php'>Login</a>
          </p>";
    exit();
}

// Check if logged in
if (!isset($_SESSION['role'])) {
    redirectToLogin();
}

// Role-specific check
if ($_SESSION['role'] !== 'admin') {
    echo "<p style='text-align:center; margin-top:50px; font-family:Arial;'>
            You do not have permission to access this page. <br>
            <a href='/DWD/index.php'>Go to Home Page</a>
          </p>";
    exit();
}


include("../includes/header.php");?>

<div class="dashboard-container">
  <?php include("../includes/sidebar.php"); // Admin sidebar?>

<main class="dashboard">
    <h2>Manage Boreholes</h2>

    <!-- ADD BOREHOLE FORM -->
    <section class="card">
        <h3>Add New Borehole</h3>

        <form method="POST" action="">
            <label for="borehole_name">Borehole Name</label><br>
            <input type="text" id="borehole_name" name="borehole_name" required><br><br>

            <label for="location">Location</label><br>
            <input type="text" id="location" name="location" required><br><br>

            <label for="status">Status</label><br>
            <select id="status" name="status" required>
                <option value="Working">Working</option>
                <option value="Faulty">Faulty</option>
            </select><br><br>

            <button type="submit" name="add_borehole">Add Borehole</button>
        </form>
    </section>

    <hr>

    <!-- BOREHOLE TABLE -->
    <section class="card">
        <h3>Borehole Records</h3>

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
                <!-- Example static data; later pull from DB -->
                <tr>
                    <td>1</td>
                    <td>Borehole A</td>
                    <td>Village X</td>
                    <td>Working</td>
                    <td>
                        <a href="edit-borehole.php?id=1">Edit</a> |
                        <a href="delete-borehole.php?id=1"
                           onclick="return confirm('Are you sure you want to delete this borehole?');">
                           Delete
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Borehole B</td>
                    <td>Village Y</td>
                    <td>Faulty</td>
                    <td>
                        <a href="edit-borehole.php?id=2">Edit</a> |
                        <a href="delete-borehole.php?id=2"
                           onclick="return confirm('Are you sure you want to delete this borehole?');">
                           Delete
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
</main>
</div>
<?php include("../includes/footer.php"); ?>
