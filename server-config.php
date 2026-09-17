<?php 
	require("connect.php");

	$rec=1;

	$p = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
	if($p>1){
		$to=$rec;
		$from=($p*$rec)-$rec;
	}else{
		$to=$rec;
		$from=0;
	}			
				
	$sid = isset($_GET["servers"]) ? (int)$_GET["servers"] : 0;

	if ($sid > 0) {
		$stmt = $conn->prepare("SELECT * FROM servers WHERE sid = ? ORDER BY sid LIMIT ?,?");
		$stmt->bind_param("iii", $sid, $from, $to);
	} else {
		$stmt = $conn->prepare("SELECT * FROM servers ORDER BY sid LIMIT ?,?");
		$stmt->bind_param("ii", $from, $to);
	}
	
	$stmt->execute();
	$result = $stmt->get_result();

	if($rs = $result->fetch_assoc()){	
		$srvno = $rs["sid"];
		$sname = $rs["server"];		
?>

<div class="premium-form p-4 text-center">
	<i class="fas fa-server fa-3x mb-3" style="color: var(--accent-color);"></i>
	<h3 class="text-gradient mb-4">Server Configuration</h3>
	
	<div class="alert text-left mb-4" style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: var(--text-muted);">
		<strong class="d-block mb-2 text-white"><i class="fas fa-info-circle mr-2"></i> Know your Host:</strong>
		<ul class="mb-0 pl-3">
			<li>If hosted locally, enter the IP Address.</li>
			<li>If hosted online, enter the Domain Name.</li>
		</ul>
	</div>

	<form action="server-config-proc.php" method="POST">
		<input type="hidden" name="servidno" value="<?php echo htmlspecialchars($srvno);?>">
		<div class="form-group mb-4">
			<label class="text-muted-premium small text-left w-100 d-block mb-1">IP Address or Domain Name</label>
			<input type="text" class="form-control text-center" name="servname" value="<?php echo htmlspecialchars($sname);?>" placeholder="e.g. 192.168.1.100" required>
		</div>
		<div class="form-group mb-0">
			<button type="submit" class="btn btn-premium w-100" name="upDate">Update Server</button>
		</div>
	</form>
</div>

<?php
	}								
?>