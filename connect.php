<?php
	session_start();	
	
	require("config.php");
	
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 
	if($conn === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
?>