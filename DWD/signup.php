<?php
include("database.php");

if(isset($_POST['signup'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = "community";

    if(!empty($username) && !empty($password)){

        // Check if username already exists
        $check = $conn->prepare("SELECT id FROM users WHERE username = :username");
        $check->bindParam(":username", $username);
        $check->execute();

        if($check->rowCount() > 0){

            $error = "Username already exists.";

        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, password, role) 
                                    VALUES (:username, :password, :role)");

            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $hashed_password);
            $stmt->bindParam(":role", $role);

            $stmt->execute();

            // Redirect to login page with success message
            header("Location: login.php?registered=success");
            exit();
        }

    } else {
        $error = "All fields are required.";
    }
}
?>




<?php include("includes/header.php"); ?>

       <main class="form-container">
                 <h2>Community Registration</h2>
              <?php 
                if(isset($error)){
                     echo "<p style='color:red;'>$error</p>";
                             }
                             ?>
             <div class = "login-box">
                      <form method="POST" autocomplete="off" >
                        <input type="text" name="username" placeholder="Enter Username" autocomplete="off" required><br><br>
                        <input type="password" name="password" placeholder="Enter Password" autocomplete="new-password" required><br><br>
                        <button type="submit" name="signup">Sign Up</button>

                        <br><br>
                       <a href="login.php">Already have an account? Login</a>
                      </form>
             </div>      
        </main>

<?php include("includes/footer.php"); ?>