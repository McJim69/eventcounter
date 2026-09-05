<?php 
	error_reporting(0);
	require("connect.php");

	if(isset($_POST['upDate'])){	
		$uidn = intval($_POST['useridno']);
		$name = $_POST['fullname'];
		$user = $_POST['username'];
		$pass = $_POST['password'];

		$update = $conn->query("UPDATE users set
			fullname = '$name',
			username = '$user',
			password = '$pass'
			where id = '$uidn'") or die(mysqli_error($conn));

		if($update){
			// Update session variables to match the new profile data
			$_SESSION["name"] = $name;
			$_SESSION["user"] = $user;
			$_SESSION["pass"] = $pass;

			echo"<script>window.location = 'index.php';</script>";
			exit();
		}
	}	
?>
