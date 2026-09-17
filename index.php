<?php 
	require("connect.php");
	require("head.php");
	require("menunav.php");
?>

<div class="main-content container d-flex flex-column align-items-center">
  <div class="glass-panel text-center w-100 mb-5" style="max-width: 800px;">
    <h1 class="text-gradient display-4 mb-3">Event Guest Counter</h1>
    <p class="lead text-muted-premium mb-4">Crowd Monitoring and Management</p>
    <div class="badge badge-primary px-3 py-2" style="font-size: 1.1rem; background: var(--accent-color); color: #111;">
      <?php include("time.php");?>
    </div>
  </div>

  <div class="w-100" id="refresh">
    <div class="event-grid">
      <?php
        // Updated to remove unnecessary COALESCE logic inside a string query for better readability
        $sql = "
          SELECT e.*, COALESCE(c.guest_count, 0) AS tguest 
          FROM events e 
          LEFT JOIN (
            SELECT eid, COUNT(*) AS guest_count 
            FROM codes 
            WHERE status != '0' 
            GROUP BY eid
          ) c ON e.id = c.eid
          ORDER BY e.id
        ";
        
        $ex = mysqli_query($conn, $sql);
        
        if ($ex) {
          while($rs = mysqli_fetch_array($ex)){
            $ID = htmlspecialchars($rs["id"]);				
            $tguest = htmlspecialchars($rs["tguest"]);
            $eventName = htmlspecialchars($rs["event"]);
            $venue = htmlspecialchars($rs["venue"]);
            $dateFr = htmlspecialchars($rs["date_fr"]);
            $dateTo = htmlspecialchars($rs["date_to"]);
            $service = htmlspecialchars($rs["service"]);
      ?>
      
      <a href="events.php?events=<?php echo $ID; ?>" class="event-card glass-panel hover-scale">
        <i class="fas fa-calendar-alt fa-3x mb-3" style="color: var(--accent-color);"></i>
        <h5 class="mb-1 text-white text-truncate"><?php echo $eventName; ?></h5>
        <p class="text-muted-premium small mb-2">
          <?php echo $venue; ?><br>
          <?php echo $dateFr; ?> - <?php echo $dateTo; ?>
        </p>
        <div class="counter"><?php echo $tguest; ?></div>
        <div class="service-title">Total <?php echo $service; ?></div>
      </a>	
      
      <?php 
          } 
        } else {
          echo "<p class='text-danger'>Error loading events: " . mysqli_error($conn) . "</p>";
        }
      ?>
    </div>
  </div>
</div>
    
<?php include("footer.php");?>

</body>
</html>

<script>
	$(document).ready(function(){
		setInterval(function(){
			$("#refresh").load(window.location.href + " #refresh" );
		}, 3000);
	});	
</script>