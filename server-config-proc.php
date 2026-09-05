<?php 
	error_reporting(0);
	require("connect.php");

	if(isset($_POST['upDate'])){	
		$servid = intval($_POST['servidno']);
		$server = $_POST['servname'];

		$update = $conn->query("UPDATE servers set server = '$server' where sid = '$servid'") or die(mysqli_error($conn));

		if($update){
			echo"<script>window.location = 'index.php';</script>";
			exit();
		}
	}	
?>
