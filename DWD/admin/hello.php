
<?php
echo "HELLO ADMIN";
<?php
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if ($username && $password && $role) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        if ($role === "admin") {
            header("Location: admin/admin-dashboard.php");
        } elseif ($role === "technician") {
            header("Location: technician/technician-dashboard.php");
        } elseif ($role === "community") {
            header("Location: community/community-dashboard.php");
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
    
<div class="login-box">
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
</div>
</main>

<?php include("includes/footer.php"); ?>
