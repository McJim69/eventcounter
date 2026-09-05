<?php 
	require("connect.php");
		if(isset($_POST["submit"])){
			$id=$_POST['id'];
			$event=$_POST['event'];
			$venue=$_POST['venue'];
			$date_fr=$_POST['date_fr'];
			$date_to=$_POST['date_to'];
			$service=$_POST['service'];
						
		$insert = $conn->query("INSERT INTO events(id,event,venue,date_fr,date_to,service) VALUES (0,'$event','$venue','$date_fr','$date_to','$service')")or die (mysqli_error($conn));

		if(($insert) == TRUE){
			echo"<script>alert('Congratulations! Event created successfully.');
			window.location.href='index.php';</script>";	
		}else{
			echo"<script>alert('ERROR: Cannot create event. Please correct error and try later.');
			window.location.href='index.php';</script>";	
		}
	}	
?>