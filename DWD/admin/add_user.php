<?php
session_start();
include("../database.php");

// Only admin can access
if(!isset($_SESSION['role']) || $_SESSION['role']!=='admin'){
    header("Location: ../login.php"); exit();
}

if(isset($_POST['add_user'])){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Check if username exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
    $stmt->execute([$username]);
    if($stmt->rowCount() > 0){
        $error = "Username already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username,password,role) VALUES (?,?,?)");
        $stmt->execute([$username,$password,$role]);
        $success = "User added successfully!";
    }
}
?>


<?php include("../includes/header.php"); ?>
<div class="dashboard-container">
 <?php include("../includes/sidebar.php"); ?>
         
 <main class="dashboard">
       <h2>Add New User</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
       <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

        <div class = "login-box"> 
                <form method="POST" autocomplete="off">
                     <label>Username:</label><br>
                     <input type="text" name="username" autocomplete="off" required><br><br>

                     <label>Password:</label><br>
                     <input type="password" name="password" autocomplete="new-password" required><br><br>

                     <label>Role:</label><br>
                        <select name="role" required>
                             <option value="">-- Select Role --</option>
                             <option value="technician">Technician</option>
                             <option value="admin">Admin</option>
                        </select><br><br>

                           <button type="submit" name="add_user">Add User</button>
                 </form>
       </div>
</main>
</div>

