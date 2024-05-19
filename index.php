<?php 
include 'header.php'; 
?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- post-container -->
                    <?php 

                    $current_page = isset($_GET['page'])? $_GET['page']: 1;
                    $post_per_page = 5;
                    
                    $total_post_sql = "SELECT post_id FROM post";
                    $total_post = $conn->query($total_post_sql) or die("Query Failed");
                    $total_post = $total_post->num_rows; 
                    
                    $total_page = ceil($total_post/$post_per_page);
                    $post_offset = ($current_page-1)*$post_per_page;


                    $post_sql = "SELECT post_id, title, description, post_date, post_img, first_name, last_name, category_id, category_name  FROM post LEFT JOIN user ON post.author = user.user_id LEFT JOIN category ON post.category = category.category_id  ORDER BY post_id DESC LIMIT $post_per_page OFFSET $post_offset";

                    $all_posts = $conn->query($post_sql) or die("Query Failed");
                    if($all_posts->num_rows){
                    ?>
                    <div class="post-container">
                        <?php 
                        while($row = $all_posts->fetch_assoc()){
                            ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href='single.php?id=<?php echo $row['post_id']?>'>
                                            <img src="./admin/upload/<?php echo $row['post_img']?>" alt=""/>
                                        </a>
                                    </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3>
                                            <a href='single.php?id=<?php echo $row['post_id']?>'>
                                                <?php echo ucwords($row['title'])?>
                                            </a>
                                        </h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?id=<?php echo $row['category_id']?>'>
                                                    <?php echo strtoupper($row['category_name'])?>
                                                </a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <?php echo ucwords("{$row['first_name']} {$row['last_name']}")?>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row['post_date']?>
                                            </span>
                                        </div>
                                        <p class="description">
                                            <?php echo(
                                                substr($row['description'], 0, 20) . (strlen($row['description'])>=20?"...": "")
                                            ); ?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']?>'>read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <ul class='pagination'>
                            <?php 
                                if($total_page>1){
                                    for($page = 1; $page<=$total_page; $page++){
                                        $active_class = $current_page==$page? 'active': '';
                                        echo "<li class='{$active_class}'><a href='?page={$page}'>{$page}</a></li>";
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <?php
                    }else echo "<h1>No post available</h1>";
                    ?>
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
