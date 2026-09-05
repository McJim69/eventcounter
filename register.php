<?php 
	require("connect.php");

	if(isset($_POST["bSave"])){
		$fullname = $conn->real_escape_string($_POST["fname"] . " " . $_POST["lname"]);
		$username = $conn->real_escape_string($_POST["username"]);
		$password = $conn->real_escape_string($_POST["password"]);
		$usertype = !empty($_POST["account"]) ? $conn->real_escape_string($_POST["account"]) : "Users";

		$insert = $conn->query("INSERT INTO users (fullname, username, password, usertype) 
			VALUES ('$fullname', '$username', '$password', '$usertype')") or die(mysqli_error($conn));	

		if($insert == TRUE){
			header("location:index.php");
			exit();
		}
	}
?>

<div class="container" style="border:1px solid #bbb;width:400px;align:center;padding:20px;border-radius:5px;background:#eee">
	<div style="text-align:center;margin-top:-10px"><br>
		<img src="assets/img/logo_2.png?<?php date("h:i:s")?>" height="150">
	</div>
	<div class="section-title" style="margin:10px">
		<h3 class="text-primary">Register User Account</h3><br>
	</div>
	<div class="row" style="margin-top:-70px">
		<div class="mt-5 mt-lg-0" style="padding:15px;align:center">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6 form-group mt-3 mt-md-0">
						<input style="margin:5px 0 5px 0" class="form-control" type="text" name="fname" placeholder="First Name" required >
						<input style="margin:5px 0 5px 0" class="form-control" type="hidden" name="mname" placeholder="Middle Name" >
					</div>
					<div class="col-md-6 form-group mt-3 mt-md-0">
						<input style="margin:5px 0 5px 0" class="form-control" type="text" name="lname" placeholder="Family Name" required >
					</div>	
				</div>	
				<div class="row">
					<div class="col-md-6 form-group mt-3 mt-md-0">
						<input style="margin:5px 0 5px 0" class="form-control" type="email" name="email" placeholder="Email Address" required >
					</div>
					<div class="col-md-6 form-group mt-3 mt-md-0">
						<input style="margin:5px 0 5px 0" class="form-control" type="text" name="phone" placeholder="Phone Number" required >
					</div>
				</div>
				<div class="row"> 
					<div class="col-md-6 form-group mt-3 mt-md-0">
						<input style="margin:5px 0 5px 0" class="form-control" type="text" name="username" placeholder="Username"  required >				
					</div>
					<div class="col-md-6 form-group mt-3 mt-md-0">
						<input style="margin:5px 0 5px 0" class="form-control" type="password" name="password" placeholder="Password"  required >
					</div>
				</div>
				<div class="row" style="display:none"> 
					<div class="col-md-6 form-group mt-3 mt-md-0">
						<select style="margin:5px 0 5px 0" class="form-control" name="account" >
							<option value="">Account Type</option>
							<option value="Users">Users</option>
							<option value="Admin">Admin</option>
							<option value="Leader">Leader</option>
						</select>
					</div>
				</div>	
				<div class="row text-center">
					<div class="col-md-6 form-group mt-3 mt-md-0">
						<input style="margin:5px 0 5px 0" class="form-control btn btn-primary" type="submit" name="bSave" value="Submit" >
					</div>
					<div class="col-md-6 form-group mt-3 mt-md-0">
						<input style="margin:5px 0 5px 0" class="form-control btn btn-danger" onclick="jump('index.php')" value="Cancel" >
					</div>
				</div>	
			</form>
		</div>
	</div>
</div>