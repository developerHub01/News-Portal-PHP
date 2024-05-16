<?php 
include "header.php"; 

if(isset($_POST['save'])){
  include "../constants/config.php"; 
  
    $f_name = $conn->real_escape_string($_POST['fname']);
    $l_name = $conn->real_escape_string($_POST['lname']);
    $user_name = $conn->real_escape_string($_POST['user']);
    $password = $conn->real_escape_string(md5($_POST['password'], TRUE));
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "SELECT username FROM user WHERE username = '{$user_name}'";
    
    $is_successfull = FALSE;

    $result = $conn->query($sql) or die("Query Faild");

    print_r($result);
    if($result->num_rows){
        echo "<h2>Username already exist</h2>";
    }else{
        $sql = "INSERT INTO user (first_name, last_name, username, password, role) VALUES ('{$f_name}', '{$l_name}', '{$user_name}', '{$password}', '{$role}')";

        $result = $conn->query($sql) or die("Query Faild");
        
        if($result) header("Location: http://localhost/web/news-portal/admin/users.php") ;
    }
}

?>
<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="admin-heading">Add User</h1>
      </div>
      <div class="col-md-offset-3 col-md-6">
        <!-- Form Start -->
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" autocomplete="off">
          <div class="form-group">
            <label>First Name</label>
            <input type="text" name="fname" class="form-control" placeholder="First Name" required>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
          </div>
          <div class="form-group">
            <label>User Name</label>
            <input type="text" name="user" class="form-control" placeholder="Username" required>
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>
          <div class="form-group">
            <label>User Role</label>
            <select class="form-control" name="role">
              <option value="0">Normal User</option>
              <option value="1">Admin</option>
            </select>
          </div>
          <input type="submit" name="save" class="btn btn-primary" value="Save" required />
        </form>
        <!-- Form End-->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>