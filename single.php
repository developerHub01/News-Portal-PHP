<?php include 'header.php'; 

if(!isset($_GET['id'])) return header("Location: {$host_name}");
$post_id = $_GET['id'];

$post_sql = "SELECT post_id, author, title, description, category_name, post_date, post_img, username
        FROM post 
        LEFT JOIN category ON post.category = category.category_id
        LEFT JOIN user ON post.author = user.user_id
        WHERE post_id = {$post_id}";
    
$post_result = $conn->query($post_sql) or die("Query Failed");

if(!$post_result || !$post_result->num_rows) return header("Location: {$host_name}");
?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <!-- post-container -->
                  <?php
                  while($row = $post_result->fetch_assoc()){
                  ?>
                    <div class="post-container">
                        <div class="post-content single-post">
                            <h3>
                                <?php echo ucwords($row['title'])?>
                            </h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    <?php echo $row['category_name']?>
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <a href='author.php?username=<?php echo $row['username']?>'>
                                        <?php echo $row['username'] ?>
                                    </a>
                                </span>
                                <span>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <?php echo $row['post_date'] ?>
                                </span>
                            </div>
                            <img class="single-feature-image" src="admin/upload/<?php echo $row['post_img']; ?>" alt=""/>
                            <p class="description">
                                <?php echo $row['description'] ?>
                            </p>
                        </div>
                    </div>
                  <?php 
                  }
                  ?>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
