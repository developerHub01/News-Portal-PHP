<?php include "header.php"; 

if($_SESSION['role']=='0') header("Location: {$host_name}/admin/post.php");

$category_id = $_GET['category_id'];

if(isset($_POST['sumbit'])){
  $category_name = $conn->real_escape_string($_POST['cat_name']);

  $update_category_sql = "UPDATE category SET category_name='{$category_name}' WHERE category_id = '{$category_id}'";

  $category_update_result = $conn->query($update_category_sql);

  if($category_update_result) header("Location: {$host_name}/admin/category.php");
}

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
                      <div class="form-group">
                        <label>Category Name</label>
                        <?php 
                          $sql = "SELECT * FROM category WHERE category_id = '{$category_id}'";

                          $cat_name = $conn->query($sql);

                          if($cat_name->num_rows){
                            while($row = $cat_name->fetch_assoc()){
                              ?>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name']?>"  placeholder="" required>
                        <?php
                            }
                          }
                        ?>
                      </div>
                      <input type="submit" name="sumbit" class="btn btn-primary" value="Update" required />
                  </form>
                </div>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>
