<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
        <?php 
        
        $current_page = $_SERVER['PHP_SELF'];
        $current_page = explode("/", $current_page);
        $current_page = end($current_page);
        $active_blog_id = null;
        if(isset($_GET['id']) && $current_page=="single.php"){
            $active_blog_id = $_GET['id'];
        }

        $recent_posts_sql = "SELECT * FROM post LEFT JOIN category ON post.category = category.category_id ORDER BY post_id DESC LIMIT 5";
        $recent_posts_list = $conn->query($recent_posts_sql) or die("Query Failed");

        if($recent_posts_list->num_rows){
            while($row = $recent_posts_list->fetch_assoc()){ 
                if($row['post_id'] == $active_blog_id) continue;
            ?>
                <div class="recent-post">
                    <a class="post-img" href="single.php?id=<?php echo $row['post_id']?>">
                        <img src="./admin/upload/<?php echo $row['post_img']?>" alt=""/>
                    </a>
                    <div class="post-content">
                        <h5>
                            <a href="single.php?id=<?php echo $row['post_id']?>">
                                <?php echo ucwords($row['title'])?>
                            </a>
                        </h5>
                        <span>
                            <i class="fa fa-tags" aria-hidden="true"></i>
                            <a href="category.php?id=<?php echo $row['category']?>">
                                <?php echo ucwords($row['category_name']) ?>
                            </a>
                        </span>
                        <span>
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <?php echo $row['post_date']?>
                        </span>
                        <a class="read-more" href="single.php?id=<?php echo $row['post_id']?>">read more</a>
                    </div>
                </div>
            <?php
            }
        }
        ?>
    </div>
    <!-- /recent posts box -->
</div>
