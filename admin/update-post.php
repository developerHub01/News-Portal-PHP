<?php include "header.php"; 
include "../utils/upload_image.php";

$file_name = upload_image("new-image");

$post_id = $_GET['post_id'];
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];


if(isset($_POST['submit'])){
    $post_previous_image = $conn->real_escape_string($_POST['post_previous_image']);
    $post_title = $conn->real_escape_string($_POST['post_title']);
    $post_description = $conn->real_escape_string($_POST['postdesc']);
    $post_category = $conn->real_escape_string($_POST['category']);

    $is_post_image = $file_name? ", post_img="."'{$file_name}'" : "";

    if($file_name) if(file_exists("upload/{$post_previous_image}")) unlink("upload/{$post_previous_image}");

    $sql = "UPDATE post SET title='{$post_title}', description='{$post_description}', category='{$post_category}' {$is_post_image} WHERE post_id = {$post_id}";

    $result = $conn->query($sql);

    if($result) header("Location: {$host_name}/admin/post.php");
}

?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data" autocomplete="off">

        <?php
            if($user_role) $post_sql = "SELECT * FROM post WHERE post_id = {$post_id};";
            else $post_sql = "SELECT * FROM post WHERE post_id = {$post_id} AND author='{$user_id}'";

            $post_result = $conn->query($post_sql) or die("Query failed");
            
            if(!$post_result->num_rows) {
                header("Location: {$host_name}/admin/post.php");
                exit("");
            }else {
                while($row = $post_result->fetch_assoc()){
                    ?>
                    <div class="form-group">
                        <label for="exampleInputTile">Title</label>
                        <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row['title']?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Description</label>
                        <textarea name="postdesc" class="form-control"  required rows="5">
                            <?php echo $row['description']?>
                        </textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputCategory">Category</label>
                        <select class="form-control" name="category">

                        <?php   
                        $category_sql = "SELECT * FROM category";

                        $category_result = $conn->query($category_sql) or die("Query failed");
                        
                        if($category_result->num_rows){
                            while($category_item = $category_result->fetch_assoc()){
                                $is_selected = $row['category'] == $category_item['category_id'] ? "selected" : "";
                                ?>
                                <option value="<?php echo $category_item['category_id']?>"
                                <?php echo $is_selected?>>
                                    <?php echo strtoupper($category_item['category_name'])?>
                                </option>
                                
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </div>
                    <input type="hidden" hidden name="post_previous_image" value="<?php echo $row['post_img']?>">
                    <div class="form-group">
                        <label for="">Post image</label>
                        <input type="file" name="new-image">
                        <img  src="<?php echo  $host_name."/admin/upload/".$row['post_img']?>" height="150px">
                        <input type="hidden" name="old-image" value="">
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                    <?php
                }
            }
        ?>
        </form>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
