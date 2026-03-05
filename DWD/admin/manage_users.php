<?php
session_start();
include("../database.php");

// Optional: Protect page (only admin allowed)
if($_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

// Delete user
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location: manage_users.php");
    exit();
}

// Fetch all users
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../includes/header.php"); ?>


<div class="dashboard-container">
  <?php include("../includes/sidebar.php"); ?>

     <main class="dashboard">
          <h2>All Users</h2>

                 <table border="1" cellpadding="10">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>

                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['role']; ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> |
                                <a href="manage_users.php?delete=<?php echo $user['id']; ?>"
                                onclick="return confirm('Are you sure you want to delete this user?')">
                                    Delete
                                    </a>
                                </td>
                     </tr>
                           <?php endforeach; ?>
                  </table>
    </main>
</div>
<?php include("../includes/footer.php"); ?>