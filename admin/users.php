<?php 
include "header.php"; 

if($_SESSION['role']=='0'){
  header("Location: {$host_name}/admin/post.php");
}
$row_per_page = 5;
$current_page = isset($_GET['page'])? $_GET['page']: 1;

$offset = ($current_page-1) * $row_per_page;

?>
<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-10">
        <h1 class="admin-heading">All Users</h1>
      </div>
      <div class="col-md-2">
        <a class="add-new" href="add-user.php">add user</a>
      </div>
      <div class="col-md-12">
        <?php
            $active_page = isset($_GET['page'])? $_GET['page']: 1;

            $data_per_page = 5;

            $offset = ($active_page-1) * $data_per_page;

            $sql = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$data_per_page} OFFSET {$offset}";
            
            $result = $conn->query($sql) or die("Query not successfull");
            
            if($result->num_rows){
        ?>
        <table class="content-table">
          <thead>
            <th>S.No.</th>
            <th>Full Name</th>
            <th>User Name</th>
            <th>Role</th>
            <th>Edit</th>
            <th>Delete</th>
          </thead>
          <tbody>
            <?php 
            $serial = (($current_page-1) * $row_per_page) + 1;
            while($row = $result->fetch_assoc()){
            ?>
            <tr>
              <td class='id'>
                <?php echo $serial++; ?>
              </td>
              <td>
                <?php echo ucwords($row['first_name'] . " ". $row['last_name']); ?>
              </td>
              <td><?php echo $row['username']; ?></td>
              <td><?php echo ucwords($row['role']=="1"? "admin": "user"); ?></td>
              <td class='edit'><a href="update-user.php?user_id=<?php echo $row['user_id'] ?>"><i
                    class=' fa fa-edit'></i></a>
              </td>
              <td class='delete'><a href="delete-user.php?user_id=<?php echo $row['user_id'] ?>"><i
                    class=' fa fa-trash-o'></i></a></td>
            </tr>
            <?php }?>
          </tbody>
        </table>
        <?php      
            }
        ?>
        <ul class='pagination admin-pagination'>
        <?php 
        $pagination_sql = "SELECT COUNT(user_id) as total_page FROM user";

        $total_user = $conn->query($pagination_sql) or die("Query not successfull");

        $total_user = $total_user->fetch_assoc();

        $total_user = $total_user['total_page'];
        
        $total_page = ceil($total_user/$data_per_page); 

        if($total_page>1){
            for($page_num = 1; $page_num<=$total_page; $page_num++){
                $active_class = $active_page==$page_num? 'active': '';
                echo "<li class='{$active_class}'>
                    <a href='users.php?page={$page_num}'>
                        {$page_num}
                    </a>
                </li>";
            }
        }
        ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php
$conn->close();
?>