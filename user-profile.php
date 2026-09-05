<?php 
	error_reporting(0);
	require("connect.php");

	if(!isset($_SESSION['user'])){
		echo "<div class='text-danger'><b>Please login to view profile.</b></div>";
		exit();
	}

	$username = $_SESSION['user'];
	$ex = $conn->query("SELECT * FROM users WHERE username='$username' LIMIT 1") or die(mysqli_error($conn));

	if($rs = mysqli_fetch_array($ex)){	
		$usrno = $rs['id'];
		$fname = $rs["fullname"];
		$uname = $rs["username"];
		$upass = $rs["password"];
?>

<form action="user-update.php" method="POST">
	<div class="container text-center" style="padding:0;min-width:380px">
		<br><h3>User Profile</h3>
		<div class="forn-group">
			<div style="margin:10px">
				<input type="hidden" class="form-control" name="useridno" value="<?php echo $usrno;?>">
			</div>
			<div style="margin:10px">
				<input type="text" class="form-control" name="fullname" value="<?php echo $fname;?>" placeholder="FullName" required>
			</div>
			<div style="margin:10px">	
				<input type="text" class="form-control" name="username" value="<?php echo $uname;?>" placeholder="UserName" required>
			</div>
			<div style="margin:10px">	
				<input type="text" class="form-control" name="password" value="<?php echo $upass;?>" placeholder="Password" required>
			</div>
			<div style="margin:10px">
				<button type="SUBMIT" class="form-control btn btn-primary" name="upDate">Update</button>
			</div>
		</div>
	</div>
</form>

<?php
	}								
?>