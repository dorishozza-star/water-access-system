<?php
session_start();

// If user is already logged in, redirect them to their dashboard
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: /DWD/admin/admin-dashboard.php");
        exit();
    } elseif ($_SESSION['role'] === 'technician') {
        header("Location: /DWD/technician/technician-dashboard.php");
        exit();
    } elseif ($_SESSION['role'] === 'community') {
        header("Location: /DWD/community/community-dashboard.php");
        exit();
    } else {
        // Unknown role, redirect to home
        header("Location: /DWD/index.php");
        exit();
    }
}

// Handle login submission
if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if ($username && $password && $role) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Redirect based on role
        if ($role === "admin") {
            header("Location: /DWD/admin/admin-dashboard.php");
        } elseif ($role === "technician") {
            header("Location: /DWD/technician/technician-dashboard.php");
        } elseif ($role === "community") {
            header("Location: /DWD/community/community-dashboard.php");
        } else {
            header("Location: /DWD/index.php");
        }
        exit();
    } else {
        $error = "All fields are required.";
    }
}
?>

<?php include("includes/header.php"); ?>

<main class="form-container">
    <h2>Login</h2>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
 <div class = "login-box">
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <select name="role" required>
            <option value="">-- Select Role --</option>
            <option value="admin">Admin</option>
            <option value="technician">Technician</option>
            <option value="community">Community Representative</option>
        </select>

        <button type="submit" name="login">Login</button>
    </form>

    <!-- Home Button -->
    <p style="text-align:center; margin-top:20px;">
        <a href="/DWD/index.php" class="button">Go to Home Page</a>
    </p>
</div> 
</main>

<?php include("includes/footer.php"); ?>

<!--  CSS for the button -->
<style>
.button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #0077be;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 10px;
}
.button:hover {
    background-color: #005f9e;
}
</style>
