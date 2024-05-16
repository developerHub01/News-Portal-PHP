<?php
include "../constants/config.php";

session_start();

session_unset();

session_destroy();

header("Location: {$host_name}/admin");

?>
