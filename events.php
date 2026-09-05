<?php 
	error_reporting(0);
	require("connect.php");
	require("head.php");
	require("menunav.php");

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
			
	$eve="";
		if($_GET["events"]!="")
		$eve=" and id='".$_GET["events"]."' ";

	$ex=$conn->query("select * from events where 1=1 $eve order by id limit $from,$to ")or die(mysqli_error($conn));
	
	while($rs=mysqli_fetch_array($ex)){
		$eid=$rs[0];
		$eve=$rs["event"];
		$ven=$rs["venue"];
		
		$counts_query = $conn->query("
			SELECT 
				COUNT(*) as total_codes,
				SUM(CASE WHEN status='Checkin' THEN 1 ELSE 0 END) as checkin_count,
				SUM(CASE WHEN status='Checkout' THEN 1 ELSE 0 END) as checkout_count,
				SUM(CASE WHEN status!='0' THEN 1 ELSE 0 END) as active_count
			FROM codes
			WHERE eid = '$eid'
		") or die(mysqli_error($conn));
		
		$counts = mysqli_fetch_assoc($counts_query);
		$totguesto = $counts['total_codes'] ?? 0;
		$tguest = $counts['checkin_count'] ?? 0;
		$tgueste = $counts['checkout_count'] ?? 0;
		$tguests = $counts['active_count'] ?? 0;
?>
    <section id="refresh" style="min-height:700px" class="u-align-center u-clearfix u-image u-shading u-section-3" src="images/world.png">
      <div class="u-clearfix u-sheet u-valign-middle-sm u-valign-middle-xs u-sheet-1">
        <div class="u-align-center u-container-style u-expanded-width-sm u-expanded-width-xs u-grey-10 u-group u-opacity u-opacity-70 u-radius-20 u-shape-round u-group-1">
          <div class="u-container-layout u-container-layout-1">
            <h1 class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-1">
              <span class="u-text-custom-color-1"></span>
              <span class="u-text-custom-color-1">
				<?php echo $eve;?>
			</span>
            </h1>
            <p class="u-text u-text-2">
				<?php echo $ven;?>
			</p>
			<div>
				<?php 
	
					$date1=date_create("".$rs["date_fr"]."");
					$date2=date_create("".$rs["date_to"]."");
			
					if(($date1)==$date2){
						echo date_format($date1,"F d, Y");
					}else{
						echo date_format($date1,"F d, Y");
						echo"<br>";
						echo date_format($date2,"F d, Y");
					}
				?>
			</div>
			<?php if($totguesto > 0){ ?>	<br>
				<a style="width:140px" class="btn btn-danger" href="viewcodes.php?events=<?php echo $eid;?>">View Codes</a> &nbsp;
				<a onclick="clearData()" style="width:140px" class="btn btn-danger">Reset Counter</a>
			<?php } else { ?>
				<b class="text-primary">No QR Codes Generated</b><br>
				<?php if(isset($_SESSION['user'])){ ?>	
				<a style="width:140px" class="btn btn-danger" rel="facebox" href="generate-codes-form.php?events=<?php echo $eid;?>">		Generate Code
				</a> &nbsp;
				<?php } else { ?>
				<a style="width:140px" class="btn btn-danger" href="login.php">		
					Admin Login
				</a> &nbsp;		
				<?php } ?>				
				<a href="index.php" style="width:140px" class="btn btn-danger">Back to Home</a>
			<?php } ?>
			<p> </p>
          </div>
        </div>
        <div class="u-expanded-width-md u-expanded-width-sm u-expanded-width-xs u-list u-list-1">
          <div class="u-repeater u-repeater-1">
            <div class="u-align-center u-container-style u-custom-color-1 u-list-item u-opacity u-opacity-70 u-radius-50 u-repeater-item u-shape-round u-video-cover">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-2">
				<span>
					<img src="images/checkin.png" height="62">
				</span>
                <h4 class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-4">
					<?php echo"".$rs["service"]."";?><br>Check-In
				</h4>
                <p class="u-text u-text-body-alt-color u-text-default u-text-5" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000">
					<?php echo "$tguest";?>
				</p>
              </div>
            </div>
            <div class="u-align-center u-container-style u-custom-color-1 u-list-item u-opacity u-opacity-70 u-radius-50 u-repeater-item u-shape-round u-video-cover">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-3">
				<span>
					<img src="images/checkout.png" height="62">
				</span>
                <h4 class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-6">
					<?php echo"".$rs["service"]."";?><br>Check-Out
				</h4>
                <p class="u-text u-text-body-alt-color u-text-default u-text-7" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000">
					<?php echo "$tgueste";?>
				</p>
              </div>
            </div>
            <div class="u-align-center u-container-style u-custom-color-1 u-list-item u-opacity u-opacity-70 u-radius-50 u-repeater-item u-shape-round u-video-cover">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-4">
				<span>
					<img src="images/guests.png" height="62">
				</span>
                <h4 class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-8">
					<?php echo"Total <br>".$rs["service"]."";?>
				</h4>
                <p class="u-text u-text-body-alt-color u-text-default u-text-9" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000">
					<?php echo "$tguests";?>
				</p>
              </div>
            </div>
            <div class="u-align-center u-container-style u-custom-color-1 u-list-item u-opacity u-opacity-70 u-radius-50 u-repeater-item u-shape-round u-video-cover u-list-item-4">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-5">
				<span>
					<img src="images/qrcode.png" height="62">
				</span>
                <h4 class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-10">
					Pass <br>Available
				</h4>
                <p class="u-text u-text-body-alt-color u-text-default u-text-11" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000">
					<?php echo"$totguesto"-"$tguests";?>
				</p>
              </div>
            </div>
          </div><br><br><br><br><br><br>
        </div>
      </div>
    </section>	
	
	<?php } ?>
	
    <div style="position:fixed;bottom:0;right:0;left:0">
	<?php include("footer.php");?>
	</div>

  </body>
</html>

<script>
	$(document).ready(function(){
		setInterval(function(){
			$("#refresh").load(window.location.href + " #refresh" );
		}, 3000);
	});	
</script>

<script>
	function clearData(){	
		if(confirm("Are you sure you want to reset counter for <?php echo $eve;?> Event?  Counter will be reset to ZERO.")){
			window.location.href = 'reset-codes.php?events=<?php echo $eid;?>';
		}else{
			window.location.href = 'events.php?events=<?php echo $eid;?>';
		}
	}
</script>