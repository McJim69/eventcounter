<?php 
	include("connect.php");

	if(!empty($_GET["events"])){
		$eveid = intval($_GET["events"]);
		
		// Find and unlink all QR code images first
		$ex1 = $conn->query("SELECT cid FROM codes WHERE eid='$eveid'") or die(mysqli_error($conn));
		while($row = mysqli_fetch_array($ex1)){
			$file = "images/qrcodes/" . $eveid . $row['cid'] . ".png";
			if(file_exists($file)){
				unlink($file);
			}
		}
		
		// Delete all codes in a single query
		$delete = $conn->query("DELETE FROM codes WHERE eid = '$eveid'") or die(mysqli_error($conn));
		
		if($delete){
			header("location:events.php?events=$eveid");
			exit();
		}
	}
	header("location:index.php");
	exit();
?>

