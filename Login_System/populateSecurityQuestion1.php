<?php 
//includes database connection
include("../MySQL_Connections/config.php");

session_start();
//sets the username from the session user value
$username = $_SESSION['user'];

//sql to retrieve security question one
$sql = "SELECT `securityQuestion1`FROM `employees`  where `strUsername` = '$username'";
//sql execution
$result = $conn->query($sql) or die("Query fail");

$row = $result->fetch_array(MYSQLI_ASSOC);
$active = $row['securityQuestion1'];
//displays question on page
echo $active;
?>