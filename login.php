<?php 
	error_reporting(0);
	require("connect.php");
	require("head.php");
	require("menunav.php");
	
	if(isset($_POST["login"])){
		$ex=$conn->query("select * from users 
			where username='".$_POST["user"]."' 
			and password='".$_POST["pass"]."'")or die(mysqli_error($conn));
			
		if($rs=mysqli_fetch_array($ex)){
			$exx=$conn->query("select * from validity where validity>'".date("Y-m-d")."'") or die(mysqli_error($conn));
			
			if($rs1=mysqli_fetch_array($exx)){
				$_SESSION["name"]=$rs["fullname"];
				$_SESSION["user"]=$rs["username"];
				$_SESSION["pass"]=$rs["password"];
				$_SESSION["type"]=$rs["usertype"];
				
				echo"<script>window.location = 'index.php';</script>";
			}else
			$m="<div class='text-danger'><b>ACCESS DENIED! Your access validity has expired. Contact your system administrator.</b></div><br>";
		}		
		else
			$m="<div class='text-danger'><b>ACCESS DENIED! Either username or password is invalid.</b></div><br>";
		$err=1;
	}	
?>

	<section style="min-height:700px;background:#eee url(images/world.png);background-size:cover">
		<div class="container">
			<div class="row justify-content-center text-center">
				<div class="col-lg-4">
					<div style="margin-top:50px;padding:20px;background:rgb(255, 255, 255, 0.5);border-radius:20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3)">
						<h2 style="margin-top:10px" class="u-text u-text-custom-color-1 u-text-1">Admin Login</h2>
						<div>
							<?php echo $m ;?> 
							<form action='login.php' method='POST' enctype='multipart/form-data'>		
								<div class='form-group'> 
									<input class="form-control" type="text" name="user" placeholder="UserName" required ><br>
									<input type='password' class='form-control' name="pass" placeholder='Password' required ><br>
									<input type='submit' class='btn btn-primary form-control' name='login' value='Log In' >
								</div>
							</form>
						</div>	
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


