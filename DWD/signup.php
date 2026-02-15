<?php include("includes/header.php"); ?>

<main class="form-container">
    <h2>Sign Up</h2>

    <form method="post" action="">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>

    <p style="margin-top:15px; text-align:center;">
        Already have an account?
        <a href="login.php" style="color:#0a6ebd; font-weight:bold;">
            Login here
        </a>
    </p>
</main>

<?php include("includes/footer.php"); ?>
