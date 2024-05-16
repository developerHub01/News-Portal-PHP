<?php include "header.php"; 
include "../constants/config.php";

if(isset($_POST['submit'])){
    $user_id = $_POST['user_id'];
    $first_name = $_POST['f_name'];
    $last_name = $_POST['l_name'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    $sql = "UPDATE user SET first_name='{$first_name}', last_name='{$last_name}', username='{$username}', role='{$role}' WHERE user_id = {$user_id}";

    echo $sql;
    $result = $conn->query($sql) or die("Query Failed");

    if($result) && header("Location: {$host_name}/admin/users.php");
    
    $conn->close();
}

?>
<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="admin-heading">Modify User Details</h1>
      </div>
      <div class="col-md-offset-4 col-md-4">
        <!-- Form Start -->
        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
          <?php 

        $user_id = $_GET['user_id'];
        $sql = "SELECT * FROM user WHERE user_id = '{$user_id}'";
        $result = $conn->query($sql) or die("Query failed");

        if($result->num_rows){
            while($row = $result->fetch_assoc()){
          ?>
          <div class="form-group">
            <input type="hidden" name="user_id" class="form-control" value="<?php echo $row['user_id'] ?>"
              placeholder="">
          </div>
          <div class="form-group">
            <label>First Name</label>
            <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name']?>" placeholder=""
              required>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name']?>" placeholder=""
              required>
          </div>
          <div class="form-group">
            <label>User Name</label>
            <input type="text" name="username" class="form-control" value="<?php echo $row['username'] ?>"
              placeholder="" required>
          </div>
          <div class="form-group">
            <label>User Role</label>
            <select class="form-control" name="role">
              <option value="0" <?php !!($row['role']=="0")? "selected": "" ?>
              >Normal User</option>
              <option value="1" <?php !!($row['role']=="1")? "selected": "" ?>
              >Admin</option>
            </select>
          </div>
          <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
          <?php 
            }
          }
          ?>
        </form>
        <!-- /Form -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>