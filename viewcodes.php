<?php 
	error_reporting(0);
	require("connect.php");
	require("head.php");
	require("menunav.php");
	include_once('qrlib/qrlib.php');

	$rec=1;

	$p=$_GET['page'];
		if($p>1){
			$to=$rec;
			$from=($p*$rec)-$rec;
			$i=(($p-1)*$rec)+1;
		}else{
			$to=$rec;
			$from=0;
			$i=1;
			$p=1;
		}			
						
	$event="";
	if($_GET["events"]!="")
		$event=" and id='".$_GET["events"]."' ";

	$venue="";
	if($_GET["venues"]!="")
		$venue=" and venue='".$_GET["venues"]."' ";
	
	$ex = $conn->query("select * from events where 1=1 $event $venue order by id limit $from,$to ");
	
	// Fetch configured server domain/IP once, fallback to dynamic URL
	$server_query = $conn->query("SELECT server FROM servers LIMIT 1");
	$server_row = mysqli_fetch_assoc($server_query);
	$configured_host = $server_row ? trim($server_row['server']) : '';

	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	if (!empty($configured_host)) {
		if (strpos($configured_host, 'http://') !== 0 && strpos($configured_host, 'https://') !== 0) {
			$folder_path = dirname($_SERVER['REQUEST_URI']);
			$folder_url = $protocol . $configured_host . $folder_path;
		} else {
			$folder_url = $configured_host;
		}
	} else {
		$host = $_SERVER['HTTP_HOST'];
		$folder_path = dirname($_SERVER['REQUEST_URI']);
		$folder_url = $protocol . $host . $folder_path;
	}
	  
	while($rs = mysqli_fetch_array($ex)){	
		$eveid = $rs[0];
		$ename = $rs["event"];
		$place = $rs["venue"];
		
		$ex1 = $conn->query("select * from codes where eid='$eveid' order by cid");
		$has_codes = ($ex1 && $ex1->num_rows > 0);
	
		if ($has_codes) {
			foreach($ex1 as $row){		
				$eid = "".$row["eid"]."";
				$cid = "".$row["cid"]."";
				$ecd = "".$row["event"]."";	
				$tcd = "".$row["ctype"]."";
				$scd = "".$row["status"]."";	
				$qcd = "".$row["quantity"]."";	
		
				//Generate QR Codes		
				if(!file_exists("images/qrcodes/".$eid.$cid.".png")){
					$data = "$folder_url/update-code.php?codes=$cid";	
					$tempDir = "images/qrcodes/";
					$codeContents =  "".$data."";
					$fileName = "".$eid."".$cid.".png";
					$pngAbsoluteFilePath = $tempDir.$fileName;
					QRcode::png($codeContents, $pngAbsoluteFilePath); 		
				}
			}
		}
?>

<style>
	.tombid2 {
		display: inline-block;
		position: relative;
		vertical-align: top;
		padding: 0px;
		margin: 8px;
	}
	.pass-container {
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		margin-top: 10px;
	}
	@media print {
		.pass-container {
			display: block !important;
			text-align: center;
		}
		.tombid2 {
			display: inline-block !important;
			margin: 8px;
			page-break-inside: avoid;
		}
	}
</style>

<div style="background:#dee1e6">

<div align='center' class="hid u-container-layout u-container-layout-1" style='background:#bbb;padding:1px'>
	<h1 class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-1">
		<span class="u-text-custom-color-1">
			<?php echo"".$rs["event"]."";?>
		</span>
	</h1>
	
	<?php if ($has_codes) { ?>

	<div class="container u-text u-text-3">
		<div class="row justify-content-center">
			<?php if(isset($_SESSION['user'])){ ?>
			<div class="col-lg-2">	
				<div style="margin:5px">	
					<input style="width:140px" onclick="codeDelete('$cid')" type="button" value="Delete Codes" class="btn btn-danger text-white btn-user" >
				</div>
			</div>	
			<?php } ?>			
			<div class="col-lg-2">
				<div style="margin:5px">
					<a style="width:140px" class="btn btn-warning text-light" rel="facebox" href="generate-codes-form.php?events=<?php echo $eveid;?>">
						Add Codes
					</a>
				</div>
			</div>
			<div class="col-lg-2">	
				<div style="margin:5px">
					<input style="width:140px" onclick="printF()" type='button' value='Print Codes' class="btn btn-success text-white btn-user" >
				</div>
			</div>
			<div class="col-lg-2">	
				<div style="margin:5px">
					<a style="width:140px" class="btn btn-primary text-light" rel="facebox" href="status-list.php?events=<?php echo $eveid;?>">Code Stats List</a>
				</div>
			</div>
			<?php if(isset($_SESSION['user'])){ ?>	
			<div class="col-lg-2">
				<div style="margin:5px">					
					<input style="width:140px" onclick="eventDelete('$eveid')" type="button" value="Delete Event" class="btn btn-secondary text-white btn-user">
				</div>
			</div>
			<?php } ?>				
		</div>
	</div>
	<?php } else {?>
		<h4>NO ADMISION CODE GENERATED</h4>
		<?php if(isset($_SESSION['user'])){ ?>
		<h5>Action:</h5>
		<input style="width:140px" onclick="eventDelete('$eveid')" type="button" value="Delete Event" class="btn btn-danger text-white btn-user"> &nbsp; 
		<a style="width:140px" class="btn btn-success" rel="facebox" href="generate-codes-form.php?events=<?php echo $eveid;?>">Generate Code</a> &nbsp; 
		<?php } else {?>
		<h5>Login as Admin to Generate Codes</h5>
		<a class="btn btn-primary" href="login.php">Login</a> 
		<?php }  ?>
	<?php }  ?>
    <p class="u-text u-text-1"></p>
</div>

<script>
	function printF(){
		$(".hid").css("display","none");
		$(".hidin").css("display","none");
	window.print(); 
		$(".hid").css("display","block");
		$(".hidin").css("display","table-cell");
	}
</script>

<div class="pass-container">

<?php 
	if ($has_codes) {
		$ex2 = $conn->query("select * from codes where eid='$eveid' order by cid");
		while($rs2=mysqli_fetch_array($ex2)){	
			$cid2 = $rs2['cid'];
			echo"
				<div class='tombid2' style='padding:1px'>
					<div style='position:relative;height:400px;width:285px;background:url(images/gate_pass.webp); background-size:100%'>
						<div style='width:195px;position:absolute;right:0;top:0;z-index:2'>
							<h1 style='padding:5px;font-size:20px;color:#fff'>$ename</h1>
						</div>
						<div style='position:absolute;left:174px;top:93px;z-index:2'>
							<img src='images/qrcodes/".$eveid."".$cid2.".png' style='padding:5px' height='105' />
						</div>
						<div style='width:265px;position:absolute;left:15px;top:220px;z-index:2'>
							<h2 style='font-size:20px;color:darkblue'>$place</h2>
						</div>					
						<div style='text-decoration:dotted;color:darkblue;font-size:40px;position:absolute;left:25px;top:280px;z-index:2'>";
							$code="".$eveid."".$cid2."";
							printf("%04d", $code);					
						echo"
						</div>
					</div>
				</div>";
			if($i%5==0)
			echo"<div style='width: 100%; height: 0;'></div>";
			$i++;

			}
		}
	} 	
?>

<br>

</div>

</body>

</html>

<script>
	function clearData(cid){	
		if(confirm("Are you sure you want to reset counter for <?php echo $ename;?> Event?  Counter will be reset to ZERO.")){
			window.location.href = 'reset-codes.php?events=<?php echo $eveid;?>';
		}else{
			window.location.href = 'viewcodes.php?events=<?php echo $eveid;?>';
		}
	}

	function codeDelete(cid){	
		if(confirm("Are you sure you want to delete the codes for <?php echo $ename;?> Event?")){
			window.location.href = 'delete-codes.php?events=<?php echo $eveid;?>';
		}else{
			window.location.href = 'viewcodes.php?events=<?php echo $eveid;?>';
		}
	}
	
	function eventDelete(id){	
		if(confirm("Are you sure you want to delete <?php echo $ename;?> event?")){
			window.location.href = 'delete-event.php?id=<?php echo $eveid;?>';
		}else{
			window.location.href = 'viewcodes.php?events=<?php echo $eveid;?>';
		}
	}
</script>