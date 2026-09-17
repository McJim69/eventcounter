<?php 
	require("connect.php");

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
	  
	if($rs = $result->fetch_assoc()){	
		$eveid = $rs["id"];
		$ename = $rs["event"];
		$place = $rs["venue"];
?>
<div class="premium-form p-4 text-center">
	<h3 class="text-gradient mb-1">CODE STATUS LIST</h3>
	<h5 class="text-white mb-1"><?php echo htmlspecialchars($ename);?></h5>
	<h6 class="text-muted-premium mb-4"><?php echo htmlspecialchars($place);?></h6>	
	
	<div class="table-responsive">
		<table class="table table-hover table-borderless" style="color: var(--text-muted);">
			<thead style="border-bottom: 2px solid var(--glass-border); color: #fff;">
				<tr>
					<th class="py-2">#</th>
					<th class="py-2">Status</th>
					<th class="py-2">Type</th>
					<th class="py-2">QR#</th>
					<th class="py-2">Img</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$stmt_codes = $conn->prepare("SELECT * FROM codes WHERE eid = ? ORDER BY cid");
				$stmt_codes->bind_param("i", $eveid);
				$stmt_codes->execute();
				$res_codes = $stmt_codes->get_result();
				$i = 1;
				while($rs1 = $res_codes->fetch_assoc()){
					$cid=$rs1["cid"];
					$sts=$rs1["status"];
					$typ=$rs1["ctype"];
					$image = "".$eveid."".$cid."";
			?>
				<tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
					<td class="py-2 align-middle"><?php echo $i;?></td>
					<td class="py-2 align-middle">
						<?php 
						if(($rs1["status"]) == "0") 
							echo "<span class='badge badge-success' style='background: rgba(16, 185, 129, 0.2); color: #10b981; border: 1px solid #10b981;'>Ready</span>"; 
						else 
							echo "<span class='badge badge-warning' style='background: rgba(245, 158, 11, 0.2); color: #f59e0b; border: 1px solid #f59e0b;'>" . htmlspecialchars($sts) . "</span>";
						?>
					</td>
					<td class="py-2 align-middle"><?php echo htmlspecialchars($typ);?></td>
					<td class="py-2 align-middle">
					<?php 
						$code="".$eveid."".$cid."";
						printf("%04d", $code);		
					?>
					</td>
					<td class="py-2 align-middle">
						<?php echo"<img src='images/qrcodes/".$image.".png' height='28' style='border-radius:4px; background:white; padding:2px;'>";?>
					</td>
				</tr>
			<?php $i++;	} ?>				
			</tbody>
		</table>
	</div>
</div>	
<?php } ?>
