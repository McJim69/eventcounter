<?php 
	include("connect.php");

	if(!empty($_GET["events"])){
		$eveid = intval($_GET["events"]);
		
		// Reset all codes status back to '0'
		$reset = $conn->query("UPDATE codes SET status = '0' WHERE eid = '$eveid' AND (status = 'Checkin' OR status = 'Checkout')") or die(mysqli_error($conn));
		
		if($reset){
			header("location:events.php?events=$eveid");
			exit();
		}
	}
	header("location:index.php");
	exit();
?>

