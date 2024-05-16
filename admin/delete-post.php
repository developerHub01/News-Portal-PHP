<?php
include "../constants/config.php";

session_start();
$post_id = $_GET['post_id'];
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

$sql = "SELECT post_img FROM post WHERE post_id = '{$post_id}' AND author = '{$user_id}'";

if(!$sql){
  echo "<h1>This is not your post.</h1>";
  exit();
}

$result = $conn->query($sql);
$result = $result->fetch_assoc();

if($result['post_img']) unlink("upload/{$result['post_img']}");

if($user_role) $sql = "DELETE FROM post WHERE post_id = {$post_id};";
else $sql = "DELETE FROM post WHERE post_id = {$post_id} AND author = '{$user_id}';";

$result = $conn->query($sql) or die("Query failed");

if($result) header("Location: {$host_name}/admin/post.php");
else echo "<h1>This is not your post.</h1>";

?>