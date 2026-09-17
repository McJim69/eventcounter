<?php 
	require("connect.php");
	require("head.php");
	require("menunav.php");
	include_once('qrlib/qrlib.php');

	$rec=1;

	$p = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	if($p>1){
		$to=$rec;
		$from=($p*$rec)-$rec;
	}else{
		$to=$rec;
		$from=0;
	}			
						
	$eventId = isset($_GET["events"]) ? (int)$_GET["events"] : 0;
	$venue = isset($_GET["venues"]) ? $_GET["venues"] : "";

	$eventCond = "";
	$venueCond = "";
	$params = [];
	$types = "";

	if ($eventId > 0) {
		$eventCond = " AND id = ? ";
		$params[] = $eventId;
		$types .= "i";
	}
	if ($venue !== "") {
		$venueCond = " AND venue = ? ";
		$params[] = $venue;
		$types .= "s";
	}

	$params[] = $from;
	$params[] = $to;
	$types .= "ii";

	$sql = "SELECT * FROM events WHERE 1=1 $eventCond $venueCond ORDER BY id LIMIT ?,?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param($types, ...$params);
	$stmt->execute();
	$result = $stmt->get_result();
	
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
	  
	while($rs = $result->fetch_assoc()){	
		$eveid = $rs["id"];
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
		@page {
			size: auto;
			margin: 5mm; /* Minimal physical page margins */
		}
		body {
			margin: 0;
			padding: 0;
		}
		.pass-container {
			display: flex !important;
			flex-wrap: wrap !important;
			justify-content: center !important;
			margin: 0 !important;
			padding: 0 !important;
			width: 100% !important;
			max-width: 100% !important;
		}
		.tombid2 {
			display: inline-block !important;
			margin: 4px !important; /* Slightly tighter margin to fit more */
			page-break-inside: avoid;
		}
		.hid, .navbar, footer {
			display: none !important;
		}
	}
</style>

<div class="hid container mt-5 mb-4">
	<div class="glass-panel text-center p-4">
		<h1 class="text-gradient mb-3">
			<i class="fas fa-ticket-alt mr-2"></i> <?php echo htmlspecialchars($ename); ?>
		</h1>
		
		<?php if ($has_codes) { ?>
		<div class="row justify-content-center mt-4">
			<?php if(isset($_SESSION['user'])){ ?>
			<div class="col-auto mb-2">	
				<button onclick="codeDelete('<?php echo $eveid; ?>')" class="btn btn-premium" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
					<i class="fas fa-trash-alt mr-1"></i> Delete Codes
				</button>
			</div>	
			<?php } ?>			
			<div class="col-auto mb-2">
				<a class="btn btn-premium" style="background: linear-gradient(135deg, #f59e0b, #d97706);" rel="facebox" href="generate-codes-form.php?events=<?php echo $eveid;?>">
					<i class="fas fa-plus-circle mr-1"></i> Add Codes
				</a>
			</div>
			<div class="col-auto mb-2">	
				<button onclick="printF()" class="btn btn-premium" style="background: linear-gradient(135deg, #10b981, #059669);">
					<i class="fas fa-print mr-1"></i> Print Codes
				</button>
			</div>
			<div class="col-auto mb-2">	
				<a class="btn btn-premium" style="background: linear-gradient(135deg, #3b82f6, #2563eb);" rel="facebox" href="status-list.php?events=<?php echo $eveid;?>">
					<i class="fas fa-chart-bar mr-1"></i> Stats List
				</a>
			</div>
			<?php if(isset($_SESSION['user'])){ ?>	
			<div class="col-auto mb-2">
				<button onclick="eventDelete('<?php echo $eveid; ?>')" class="btn btn-premium" style="background: linear-gradient(135deg, #6b7280, #4b5563);">
					<i class="fas fa-folder-minus mr-1"></i> Delete Event
				</button>
			</div>
			<?php } ?>				
		</div>
		<?php } else {?>
			<div class="alert mt-4" style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); display: inline-block;">
				<h4 class="text-white mb-3"><i class="fas fa-exclamation-triangle text-warning mr-2"></i> NO ADMISSION CODES GENERATED</h4>
				<?php if(isset($_SESSION['user'])){ ?>
					<button onclick="eventDelete('<?php echo $eveid; ?>')" class="btn btn-premium mr-2" style="background: linear-gradient(135deg, #ef4444, #dc2626);">Delete Event</button>
					<a class="btn btn-premium" style="background: linear-gradient(135deg, #10b981, #059669);" rel="facebox" href="generate-codes-form.php?events=<?php echo $eveid;?>">Generate Codes</a>
				<?php } else {?>
					<h5 class="text-muted-premium mb-3">Login as Admin to Generate Codes</h5>
					<a class="btn btn-premium" href="login.php">Login</a> 
				<?php }  ?>
			</div>
		<?php }  ?>
	</div>
</div>

<script>
	function printF(){
		window.print(); 
	}
</script>

<div class="pass-container">

<?php 
	if ($has_codes) {
		$ex2 = $conn->query("select * from codes where eid='$eveid' order by cid");
		$i = 1; 
		while($rs2=mysqli_fetch_array($ex2)){	
			$cid2 = $rs2['cid'];
			echo"
				<div class='tombid2' style='padding:1px'>
					<div style='position:relative;height:400px;width:285px;background:url(images/gate_pass.webp); background-size:100%'>
						<div style='width:195px;position:absolute;right:0;top:0;z-index:2'>
							<h1 style='padding:5px;font-size:20px;color:#fff'>" . htmlspecialchars($ename) . "</h1>
						</div>
						<div style='position:absolute;left:174px;top:93px;z-index:2'>
							<img src='images/qrcodes/".$eveid."".$cid2.".png' style='padding:5px' height='105' />
						</div>
						<div style='width:265px;position:absolute;left:15px;top:220px;z-index:2'>
							<h2 style='font-size:20px;color:darkblue'>" . htmlspecialchars($place) . "</h2>
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
		if(confirm("Are you sure you want to reset counter for <?php echo addslashes($ename);?> Event?  Counter will be reset to ZERO.")){
			window.location.href = 'reset-codes.php?events=<?php echo $eveid;?>';
		}else{
			window.location.href = 'viewcodes.php?events=<?php echo $eveid;?>';
		}
	}

	function codeDelete(cid){	
		if(confirm("Are you sure you want to delete ALL codes for <?php echo addslashes($ename);?> Event?")){
			window.location.href = 'delete-codes.php?events=<?php echo $eveid;?>';
		}else{
			window.location.href = 'viewcodes.php?events=<?php echo $eveid;?>';
		}
	}
	
	function eventDelete(id){	
		if(confirm("Are you sure you want to delete the <?php echo addslashes($ename);?> event?")){
			window.location.href = 'delete-event.php?id=<?php echo $eveid;?>';
		}else{
			window.location.href = 'viewcodes.php?events=<?php echo $eveid;?>';
		}
	}
</script>