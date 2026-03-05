<?php
session_start();
include("database.php");   

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

    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($username && $password && $role) {

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
        $stmt->execute([$username, $role]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['password'] === $password) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($role === "admin") {
                header("Location: /DWD/admin/admin-dashboard.php");
            } elseif ($role === "technician") {
                header("Location: /DWD/technician/technician-dashboard.php");
            } elseif ($role === "community") {
                header("Location: /DWD/community/community-dashboard.php");
            }

            exit();

        } else {
            $error = "Invalid username, password, or role.";
        }

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
    <form method="POST" action="" autocomplete="off" >
        <input type="text" name="username" placeholder="Username" autocomplete="off" required>
        <input type="password" name="password" placeholder="Password" autocomplete="new-password" required>

        <select name="role" required>
            <option value="">-- Select Role --</option>
            <option value="admin">Admin</option>
            <option value="technician">Technician</option>
            <option value="community">Community Representative</option>
        </select>

        <button type="submit" name="login">Login</button>
        <p>
            New Community Representative?
        <a href="signup.php">Sign up Here </a></p>
    </form>

    <!-- Home Button -->
    <p style="text-align:center; margin-top:20px;">
        <a href="/DWD/index.php" class="button">Go to Home Page</a>
        
    </p>
</div> 
</main>

<?php include("includes/footer.php"); ?>

<!--  CSS for button -->
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
