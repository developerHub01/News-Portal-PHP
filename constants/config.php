<?php
include "constants.php";

$conn = new mysqli(SERVER, SERVER_USERNAME, SERVER_PASSWORD, DATABASE_NAME);

if($conn->connect_error) die("Connection faild" . $conn->connect_error);

?>