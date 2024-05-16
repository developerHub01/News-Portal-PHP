<?php include "header.php"; 

$row_per_page = 5;

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = $row_per_page*($current_page-1);

$sql_category = "SELECT * FROM category ORDER BY category_id DESC LIMIT {$row_per_page} OFFSET {$offset}";

$category_result = $conn->query($sql_category) or die("Query Failed");

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                    <?php 
                        if($category_result->num_rows){
                            while($row = $category_result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td class='id'>
                                        <?php echo $row['category_id'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['category_name'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['post'] ?>
                                    </td>
                                    <td class='edit'>
                                        <a href='update-category.php?category_id=<?php echo $row['category_id'] ?>'>
                                            <i class='fa fa-edit'></i>
                                        </a>
                                    </td>
                                    <td class='delete'>
                                        <a href='delete-category.php?category_id=<?php echo $row['category_id'] ?>'>
                                            <i class='fa fa-trash-o'></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                    ?>
                    </tbody>
                </table>
                <ul class='pagination admin-pagination'>

                <?php 
                    $sql_count = "SELECT COUNT(category_id) as total_pages FROM category";
                    
                    $count_result = $conn->query($sql_count) or die("Query Failed");

                    $count_result = $count_result->fetch_assoc();

                    $count_result = $count_result['total_pages'];

                    $number_of_page = ceil($count_result / $row_per_page);


                    for($page=1; $page<=$number_of_page; $page++){
                        $active_class = $page==$current_page? "active": "";
                        echo "<li class='$active_class'>
                                <a href='{$host_name}/admin/category.php?page={$page}'>
                                {$page}
                                </a>
                            </li>";
                    }
                ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
