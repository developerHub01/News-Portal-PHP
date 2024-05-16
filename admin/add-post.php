<?php include "header.php"; 

if(isset($_FILES['fileToUpload'])){
    $error = [];

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_temp_name = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_extension = strtolower(end(explode(".", $file_name)));

    $allowed_extensions = ['jpeg', 'jpg', 'png'];

    if(!in_array($file_extension, $allowed_extensions)){
        $error[] = "Extension not supported.";
    }
    if($file_size > 2*1024*1024){
        $error[] = "Max file size 2MB";
    }

    if(empty($error)){
        move_uploaded_file($file_temp_name, "./upload/" . $file_name);
    }else{
        print_r($error);
        die();
    }
}


if(isset($_POST['submit'])){
    $post_title = $conn->real_escape_string($_POST['post_title']);
    $post_description = $conn->real_escape_string($_POST['postdesc']);
    $post_category = $conn->real_escape_string($_POST['category']);
    $post_date = date("d M, Y");
    $author_id = $_SESSION['user_id'];

    $sql = "INSERT INTO post (title, description, category, post_date, author, post_img) VALUES ('{$post_title}', '{$post_description}', '{$post_category}', '{$post_date}', '{$author_id}', '{$file_name}');";
    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = '{$post_category}';";

    if($conn->multi_query($sql)){
        header("Location: {$host_name}/admin/post.php");
    }else{
        echo "<h1>Query Failed.</h1>";
    }
}

?>
  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form -->
                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="post_title">Title</label>
                          <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="postdesc" class="form-control" rows="5"  required></textarea>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" class="form-control">
                            <?php 
                            $category_sql = "SELECT * FROM category";
                            $category_list = $conn->query($category_sql);

                            if($category_list->num_rows){
                                while($row = $category_list->fetch_assoc()){
                            ?>
                                    <option value="<?php echo $row['category_id']; ?>" >
                                        <?php echo strtoupper($row['category_name']); ?>
                                    </option>                          
                            <?php
                                }
                            }
                            ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label>
                          <input type="file" name="fileToUpload" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                  </form>
                  <!--/Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
