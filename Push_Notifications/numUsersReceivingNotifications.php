<?php 
include("../MySQL_Connections/config.php");

$sql = "SELECT * FROM `users` WHERE `bitReceiveNotifications` = 1";

$result = $conn->query($sql) or die("Query fail");
    
$row = $result->fetch_array(MYSQLI_ASSOC);
$active = $row['active'];

$count =  $result->num_rows;
echo $count;
?>