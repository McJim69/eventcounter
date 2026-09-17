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

	$sql = "SELECT * FROM events WHERE id=id $eventCond $venueCond ORDER BY id LIMIT ?,?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param($types, ...$params);
	$stmt->execute();
	$result = $stmt->get_result();
	  
	if($rs = $result->fetch_assoc()){	
		$eveid = $rs["id"];
		$ename = $rs["event"];
		$place = $rs["venue"];
	}
?>

<div class="premium-form p-4 text-center">
	<i class="fas fa-qrcode fa-3x mb-3" style="color: var(--accent-color);"></i>
	<h3 class="text-gradient mb-1"><?php echo htmlspecialchars($ename); ?></h3>
	<p class="text-muted-premium mb-4"><?php echo htmlspecialchars($place); ?></p>
	
	<div class="alert text-left mb-4" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: var(--text-muted);">
		<strong class="d-block mb-2" style="color: #ef4444;"><i class="fas fa-exclamation-triangle mr-2"></i> Important Note:</strong>
		<p class="mb-0 small text-white">Check the server if correctly set before generating the codes. Verify in Menu: <strong>Settings -> Server Config</strong> or ask your SysAdmin for assistance.</p>
	</div>

	<h5 class="text-white mb-3">Generate Gate Pass Codes</h5>
	
	<form action="generate-codes.php" method="POST">
		<input type="hidden" name="event" class="form-control" value="<?php echo htmlspecialchars($ename); ?>" readonly>
		<input type="hidden" name="eid" class="form-control" value="<?php echo htmlspecialchars($eveid); ?>">
		<input type="hidden" name="ctype" class="form-control" value="Walkin">
		<input type="hidden" name="status" class="form-control" value="0">
		
		<div class="form-group mb-4">
			<label class="text-muted-premium small text-left w-100 d-block mb-1">Quantity (Max 1000 per instance)</label>
			<input type="number" name="quantity" min="1" max="1000" class="form-control text-center" placeholder="100" required>
		</div>
		<div class="form-group mb-0">
			<button type="submit" name="submit" class="btn btn-premium w-100" style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none;">Generate Codes</button>
		</div>
	</form>
</div>