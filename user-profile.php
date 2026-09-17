<?php 
	require("connect.php");

	if(!isset($_SESSION['user'])){
		echo "<div class='alert alert-danger m-3'><b>Please login to view profile.</b></div>";
		exit();
	}

	$username = $_SESSION['user'];
	$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();

	if($rs = $result->fetch_assoc()){	
		$usrno = $rs['id'];
		$fname = $rs["fullname"];
		$uname = $rs["username"];
		$upass = $rs["password"];
?>

<div class="premium-form p-4 text-center">
	<i class="fas fa-user-edit fa-3x mb-3" style="color: var(--accent-color);"></i>
	<h3 class="text-gradient mb-4">User Profile</h3>
	<form action="user-update.php" method="POST">
		<input type="hidden" name="useridno" value="<?php echo htmlspecialchars($usrno);?>">
		<div class="form-group mb-3">
			<input type="text" class="form-control" name="fullname" value="<?php echo htmlspecialchars($fname);?>" placeholder="Full Name" required>
		</div>
		<div class="form-group mb-3">	
			<input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($uname);?>" placeholder="Username" required>
		</div>
		<div class="form-group mb-4">	
			<input type="text" class="form-control" name="password" value="<?php echo htmlspecialchars($upass);?>" placeholder="Password" required>
		</div>
		<div class="form-group mb-0">
			<button type="submit" class="btn btn-premium w-100" name="upDate">Update Profile</button>
		</div>
	</form>
</div>

<?php
	}								
?>