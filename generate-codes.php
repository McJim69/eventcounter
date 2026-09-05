<?php 
	require("connect.php");
	
	ini_set('max_execution_time', '30');

	if(isset($_POST["submit"])){

		$eid=$_POST['eid'];
		$event=$_POST['event'];
		$ctype=$_POST['ctype'];
		$status=$_POST['status'];
		$quantity=intval($_POST['quantity']);
	
		$arraySize = $quantity;
		for ( $i = 0; $i < $arraySize; $i+=1000 ){
			$thisChunk = min(1000, $arraySize-$i);
			$insert = $conn->query("INSERT INTO codes (cid, eid, event, ctype, status, quantity) VALUES ".implode(', ', array_fill(0, $thisChunk, "(0, '$eid', '$event', '$ctype', '$status', '$quantity')"))) or die(mysqli_error($conn));
		}
		
		header("location: viewcodes.php?events=$eid");
		exit();
	}	
?>