<?php
date_default_timezone_set('asia/kolkata');
if($_SERVER["SERVER_NAME"]=="localhost"){
	$db_host = "localhost";
	$db_username = "root";
	$db_password = "";
	$db_name = "votex";
}
else{
	$db_host = "localhost";
	$db_username = "roboca6g_admin";
	$db_password = "admin@123";
	$db_name = "roboca6g_votex";
}
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>