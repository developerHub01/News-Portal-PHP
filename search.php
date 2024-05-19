<?php include 'header.php'; 

$search_term = $conn->real_escape_string($_GET['search']);
$current_page = isset($_GET['page'])? $_GET['page']: 1;

?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <h2 class="page-heading">Search : <?php echo $search_term?></h2>
                    <?php

                    $post_per_page = 5;

                    $total_post_sql = "SELECT post_id FROM post WHERE title LIKE '%{$search_term}%'";

                    $total_post = $conn->query($total_post_sql) or die("Query Failed");
                    $total_post = $total_post->num_rows; 
                    
                    $total_page = ceil($total_post/$post_per_page);
                    $post_offset = ($current_page-1)*$post_per_page;

                    $category_post_sql = "SELECT post_id, title, description, post_date, post_img, username, category_id, category_name FROM post 
                    LEFT JOIN category ON post.category=category.category_id 
                    LEFT JOIN user ON post.author = user.user_id
                    WHERE title LIKE '%{$search_term}%' OR description LIKE '%{$search_term}%'
                    ORDER BY post_id DESC LIMIT $post_per_page OFFSET $post_offset";

                    $category_posts = $conn->query($category_post_sql) or die("Query Failed");
                    if($category_posts->num_rows){
                        while($row = $category_posts->fetch_assoc()){?>
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
                                            <a href='author.php?username=<?php echo $row['username']?>'>
                                                <?php echo $row['username']?>
                                            </a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date']?>
                                        </span>
                                    </div>
                                    <p class="description">
                                        <?php echo(
                                            substr($row['description'], 0, 100) . (strlen($row['description'])>=100?"...": "")
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
                                            echo "<li class='{$active_class}'><a href='?search={$search_term}&page={$page}'>{$page}</a></li>";
                                        }
                                    }
                                ?>
                            </ul>
                        <?php
                    }else echo "<h1>No post available</h1>";
                    ?>
                </div>
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
