<?php 
include "../constants/config.php";

if($_SESSION['role']=='0'){
  header("Location: {$host_name}/admin/post.php");
}

$user_id = $_GET['user_id'];

$sql = "DELETE FROM user WHERE user_id = '{$user_id}'" or die("Query failed");


if($conn->query($sql)) header("Location: {$host_name}/admin/users.php");

$conn->close();

?>