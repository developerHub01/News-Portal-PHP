<?php
include "../constants/config.php";

$post_id = $_GET['post_id'];

$sql = "DELETE FROM post WHERE post_id = {$post_id};";

$result = $conn->query($sql) or die("Query failed");

if($result) header("Location: {$host_name}/admin/post.php");

?>