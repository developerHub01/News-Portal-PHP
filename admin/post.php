<?php include "header.php"; 

$row_per_page = 5;

$current_page = isset($_GET['page'])? $_GET['page']: 1;

$offset = ($current_page-1) * $row_per_page;
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                    <?php 
                      $sql = "SELECT post_id, author, title, category_name, post_date, first_name, last_name FROM post 
                      JOIN category ON post.category = category.category_id
                      JOIN user ON post.author = user.user_id
                      ORDER BY post_id LIMIT $row_per_page OFFSET $offset";

                      $result = $conn->query($sql) or die("Faild Query");

                      if($result->num_rows){?>
                        <tbody>
                        <?php 
                        $serial = (($current_page-1) * $row_per_page) + 1;
                        while($row = $result->fetch_assoc()){ ?>
                        <tr>
                            <td class='id'>
                                <?php echo $serial++ ?>
                            </td>
                            <td>
                                <?php echo ucwords($row['title'])?>
                            </td>
                            <td>
                                <?php echo ucwords($row['category_name'])?>
                            </td>
                            <td>
                                <?php echo $row['post_date']?>
                            </td>
                            <td>
                                <?php echo ucwords($row['first_name'] . " " . $row['last_name'])?>
                            </td>
                            <?php
                            if($_SESSION['user_id']==$row['author'] || $_SESSION['role']==1){
                            ?>                         
                            <td class='edit'>
                                <a href='update-post.php?post_id=<?php echo $row['post_id']?>'><i class='fa fa-edit'></i>
                                </a>
                            </td>
                            <td class='delete'>
                                <a href='delete-post.php?post_id=<?php echo $row['post_id']?>'><i class='fa fa-trash-o'></i>
                                </a>
                            </td>
                            <?php
                            }else{
                            ?>
                            <td class='edit'>
                            </td>
                            <td class='delete'>
                            </td>
                            <?php 
                            }
                            ?>
 
                          </tr>
                        <?php } ?>
                        </tbody>
                    <?php } ?>   
                  </table>

                  <ul class='pagination admin-pagination'>
                    <?php 
                    $total_post_sql = "SELECT COUNT(post_id) as total_post FROM post;";
                        
                    $total_post_number = $conn->query($total_post_sql) or die("Query failed");
                    $total_post_number = ($total_post_number->fetch_assoc())['total_post'];

                    $total_page = ceil($total_post_number/$row_per_page);
                    if($total_page>1){
                        for($page=1; $page<=$total_page; $page++){
                            $active_class = $page == $current_page? 'active': '';
                            ?>
                                <li class="<?php echo $active_class?>">
                                    <a href="post.php?page=<?php echo $page ?>">
                                        <?php echo $page?>
                                    </a>
                                </li>
                            <?php
                        }
                    }
                    ?>
                        
                  </ul>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
