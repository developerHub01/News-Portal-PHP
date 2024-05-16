<?php 

include "../constants/config.php";

session_start();


if(!$_SESSION['username'] || !$_SESSION['user_id']|| !$_SESSION['role']) header("Location: {$host_name}/admin");

if($_SESSION['role']=='0') header("Location: {$host_name}/admin/post.php");

$category_id = $_GET['category_id'];

$sql = "DELETE FROM category WHERE category_id = '{$category_id}'";

$result = $conn->query($sql);

if($result) header("Location: {$host_name}/admin/category.php");

?>