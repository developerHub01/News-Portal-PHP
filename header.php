<?php 
include "./constants/config.php";

$main_title = "News Portal";

$category_sql = "SELECT category_id, category_name FROM category";
$category_list = $conn->query($category_sql) or die("Query Failed");

$page_name = basename($_SERVER['PHP_SELF']);

switch($page_name){
  case "category.php":
    if(isset($_GET['id'])){
      $sql = "SELECT category_name FROM category WHERE category_id = {$_GET['id']}";
      $result = $conn->query($sql);
      $result = $result->fetch_assoc()['category_name'];
      $main_title = strtoupper($result) . " Category";
    }else $main_title = "Category";
    break;
  case "single.php":
    if(isset($_GET['id'])){
      $sql = "SELECT title FROM post WHERE post_id = {$_GET['id']}";
      $result = $conn->query($sql);
      $result = $result->fetch_assoc()['title'];
      $main_title = ucwords($result);
    }else $main_title = "Post page";
    break;
  case "search.php":
    if(isset($_GET['search'])){
      $main_title = ucwords($_GET['search']) . "-Search";
    }else $main_title = "Search Page";
    break;
  case "author.php":
    if(isset($_GET['username'])) $main_title = $_GET['username'] . "'s post";
    else $main_title = "Author";
    break;
  default:
    $main_title = "News Portal";
    break;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title><?php echo $main_title ?></title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <!-- Font Awesome Icon -->
  <link rel="stylesheet" href="css/font-awesome.css">
  <!-- Custom stlylesheet -->
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- HEADER -->
  <div id="header">
    <!-- container -->
    <div class="container">
      <!-- row -->
      <div class="row">
        <!-- LOGO -->
        <div class="col-md-offset-4 col-md-4">
          <a href="index.php" id="logo"><img src="images/news.jpg"></a>
        </div>
        <!-- /LOGO -->
      </div>
    </div>
  </div>
  <!-- /HEADER -->
  <!-- Menu Bar -->
  <div id="menu-bar">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <ul class='menu'>
            <?php 
            $is_category = $_SERVER['PHP_SELF'];
            $is_category = explode('/', $_SERVER['PHP_SELF']);
            $is_category = end($is_category);
            $active_category_id = null;
            if(isset($_GET['id']) && $is_category=="category.php") $active_category_id = $_GET['id'];

            while($row = $category_list->fetch_assoc()){
              $active_class = $active_category_id==$row['category_id']? "active": "";
              ?>
                <li>
                  <a href='category.php?id=<?php echo $row['category_id']; ?>' class="<?php echo $active_class; ?>" >
                    <?php echo $row['category_name']; ?>
                  </a>
                </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- /Menu Bar -->