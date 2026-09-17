<?php 
	require("connect.php");
	require("head.php");
	require("menunav.php");
	
	$m = "";
	if(isset($_POST["login"])){
		$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
		$stmt->bind_param("ss", $_POST["user"], $_POST["pass"]);
		$stmt->execute();
		$result = $stmt->get_result();
			
		if($rs = $result->fetch_assoc()){
			$stmt2 = $conn->prepare("SELECT * FROM validity WHERE validity > ?");
			$today = date("Y-m-d");
			$stmt2->bind_param("s", $today);
			$stmt2->execute();
			$result2 = $stmt2->get_result();
			
			if($rs1 = $result2->fetch_assoc()){
				$_SESSION["name"] = $rs["fullname"];
				$_SESSION["user"] = $rs["username"];
				$_SESSION["pass"] = $rs["password"];
				$_SESSION["type"] = $rs["usertype"];
				
				echo "<script>window.location = 'index.php';</script>";
			} else {
				$m = "<div class='alert alert-danger' style='background: rgba(239, 68, 68, 0.2); color: #fff; border: 1px solid #ef4444;'><b>ACCESS DENIED!</b> Your access validity has expired. Contact your system administrator.</div>";
			}
		} else {
			$m = "<div class='alert alert-danger' style='background: rgba(239, 68, 68, 0.2); color: #fff; border: 1px solid #ef4444;'><b>ACCESS DENIED!</b> Either username or password is invalid.</div>";
		}
	}	
?>

	<section class="d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 200px); padding: 2rem 0;">
		<div class="container">
			<div class="row justify-content-center text-center">
				<div class="col-md-6 col-lg-5">
					<div class="glass-panel premium-form p-5">
						<i class="fas fa-user-circle fa-4x mb-3" style="color: var(--accent-color);"></i>
						<h2 class="text-gradient mb-4">Admin Login</h2>
						
						<?php echo $m ;?> 
						
						<form action='login.php' method='POST' enctype='multipart/form-data'>		
							<div class='form-group mb-3'> 
								<input class="form-control" type="text" name="user" placeholder="Username" required>
							</div>
							<div class='form-group mb-4'> 
								<input type='password' class='form-control' name="pass" placeholder='Password' required>
							</div>
							<div class='form-group mb-0'> 
								<input type='submit' class='btn btn-premium w-100' name='login' value='Secure Login'>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
    <div style="position:fixed;bottom:0;right:0;left:0">
	<?php include("footer.php");?>
	</div>
	</body>
</html>


