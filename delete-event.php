<?php
	require("connect.php");
	
	if(!empty($_GET["id"])){
		$ID = intval($_GET["id"]);
		
		// Find and unlink all QR code images first
		$ex1 = $conn->query("SELECT cid FROM codes WHERE eid='$ID'") or die(mysqli_error($conn));
		while($row = mysqli_fetch_array($ex1)){
			$file = "images/qrcodes/" . $ID . $row['cid'] . ".png";
			if(file_exists($file)){
				unlink($file);
			}
		}
		
		// Delete the event and codes from database
		$conn->query("DELETE FROM events WHERE id='$ID'") or die(mysqli_error($conn));
		$conn->query("DELETE FROM codes WHERE eid='$ID'") or die(mysqli_error($conn));
	}
	header("location:index.php");
	exit();
?>