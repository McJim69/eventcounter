<?php 
	require("connect.php");
	require("head.php");
	require("menunav.php");

	$rec=1;
	$p=isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
	$to=$rec;
	$from=($p*$rec)-$rec;
	
	// Secure the parameter
	$eventId = isset($_GET['events']) ? intval($_GET['events']) : 0;

	// Use prepared statements for security
	$stmt = $conn->prepare("SELECT * FROM events WHERE id = ? LIMIT ?, ?");
	$stmt->bind_param("iii", $eventId, $from, $to);
	$stmt->execute();
	$ex = $stmt->get_result();
	
	if($rs = $ex->fetch_assoc()){
		$eid = htmlspecialchars($rs["id"]);
		$eve = htmlspecialchars($rs["event"]);
		$ven = htmlspecialchars($rs["venue"]);
		$date_fr = htmlspecialchars($rs["date_fr"]);
		$date_to = htmlspecialchars($rs["date_to"]);
		$service = htmlspecialchars($rs["service"]);
		
		// Secure counts query
		$counts_stmt = $conn->prepare("
			SELECT 
				COUNT(*) as total_codes,
				SUM(CASE WHEN status='Checkin' THEN 1 ELSE 0 END) as checkin_count,
				SUM(CASE WHEN status='Checkout' THEN 1 ELSE 0 END) as checkout_count,
				SUM(CASE WHEN status!='0' THEN 1 ELSE 0 END) as active_count
			FROM codes
			WHERE eid = ?
		");
		$counts_stmt->bind_param("i", $eid);
		$counts_stmt->execute();
		$counts_result = $counts_stmt->get_result();
		
		$counts = $counts_result->fetch_assoc();
		$totguesto = $counts['total_codes'] ?? 0;
		$tguest = $counts['checkin_count'] ?? 0;
		$tgueste = $counts['checkout_count'] ?? 0;
		$tguests = $counts['active_count'] ?? 0;
?>

<div class="main-content container d-flex flex-column align-items-center" id="refresh">
  
  <div class="glass-panel text-center w-100 mb-5" style="max-width: 800px; background: rgba(11, 15, 25, 0.7);">
    <h1 class="text-gradient display-4 mb-3"><?php echo $eve; ?></h1>
    <p class="lead text-muted-premium mb-3">
      <i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i><?php echo $ven; ?>
    </p>
    <div class="text-white mb-4">
      <?php 
        $date1=date_create($date_fr);
        $date2=date_create($date_to);
        if($date1 == $date2){
          echo date_format($date1, "F d, Y");
        } else {
          echo date_format($date1, "F d, Y") . " - " . date_format($date2, "F d, Y");
        }
      ?>
    </div>

    <div class="mt-4">
      <?php if($totguesto > 0){ ?>
        <a class="btn btn-premium mx-2 my-1" href="viewcodes.php?events=<?php echo $eid; ?>">View Codes</a>
        <button onclick="clearData()" class="btn btn-danger-premium mx-2 my-1">Reset Counter</button>
      <?php } else { ?>
        <div class="alert" style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5;">
          <strong>Notice:</strong> No QR Codes Generated yet.
        </div>
        <?php if(isset($_SESSION['user'])){ ?>	
          <a class="btn btn-premium mx-2 my-1" rel="facebox" href="generate-codes-form.php?events=<?php echo $eid; ?>">Generate Codes</a>
        <?php } else { ?>
          <a class="btn btn-premium mx-2 my-1" href="login.php">Admin Login</a>
        <?php } ?>				
        <a href="index.php" class="btn btn-glass mx-2 my-1">Back to Home</a>
      <?php } ?>
    </div>
  </div>

  <div class="stats-grid w-100">
    <div class="event-card glass-panel hover-scale" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3);">
      <i class="fas fa-sign-in-alt fa-3x mb-3" style="color: #10b981;"></i>
      <h4 class="mb-1 text-white"><?php echo $service; ?><br><small class="text-muted-premium">Check-In</small></h4>
      <div class="counter" style="color: #10b981;"><?php echo $tguest; ?></div>
    </div>
    
    <div class="event-card glass-panel hover-scale" style="background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.3);">
      <i class="fas fa-sign-out-alt fa-3x mb-3" style="color: #ef4444;"></i>
      <h4 class="mb-1 text-white"><?php echo $service; ?><br><small class="text-muted-premium">Check-Out</small></h4>
      <div class="counter" style="color: #ef4444;"><?php echo $tgueste; ?></div>
    </div>

    <div class="event-card glass-panel hover-scale" style="background: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.3);">
      <i class="fas fa-users fa-3x mb-3" style="color: #60a5fa;"></i>
      <h4 class="mb-1 text-white">Total<br><small class="text-muted-premium"><?php echo $service; ?></small></h4>
      <div class="counter" style="color: #60a5fa;"><?php echo $tguests; ?></div>
    </div>

    <div class="event-card glass-panel hover-scale">
      <i class="fas fa-qrcode fa-3x mb-3" style="color: var(--text-main);"></i>
      <h4 class="mb-1 text-white">Pass<br><small class="text-muted-premium">Available</small></h4>
      <div class="counter"><?php echo ($totguesto - $tguests); ?></div>
    </div>
  </div>

</div>
	
<?php } else { ?>
  <div class="main-content container text-center">
    <div class="glass-panel d-inline-block">
      <h2 class="text-white mb-3">Event Not Found</h2>
      <p class="text-muted-premium">The event you are looking for does not exist or has been removed.</p>
      <a href="index.php" class="btn btn-premium mt-3">Back to Home</a>
    </div>
  </div>
<?php } ?>

<?php include("footer.php"); ?>

<script>
	$(document).ready(function(){
		setInterval(function(){
			$("#refresh").load(window.location.href + " #refresh" );
		}, 3000);
	});	

	function clearData(){	
		if(confirm("Are you sure you want to reset the counter for this event? All data will be reset to ZERO.")){
			window.location.href = 'reset-codes.php?events=<?php echo isset($eid) ? $eid : 0; ?>';
		}
	}
</script>
</body>
</html>