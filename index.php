<?php 
	error_reporting(0);
	require("connect.php");
	require("head.php");
	require("menunav.php");
?>

<style>
	.divhove :hover{
		background:#545454;
		color:#eee;
	}
</style>

<section style="min-height:700px" class="u-align-center u-clearfix u-image u-shading u-section-1" id="carousel_95fd" data-image-width="1600" data-image-height="900">
	<div class="u-clearfix u-sheet u-sheet-1">
		<div class="u-align-center u-container-style u-expanded-width-sm u-expanded-width-xs u-grey-15 u-group u-opacity u-opacity-70 u-radius-20 u-shape-round u-group-1">
			<div class="u-container-layout u-container-layout-1">
				<h1 class="u-text u-text-custom-color-1 u-text-1">Event Guest Counter</h1>
				<p class="u-text u-text-black u-text-2">
					<span style="font-size: 1.25rem;">Crowd Monitoring and Management</span><br>
				</p>
				<p class="u-text u-text-3">
					<span style="font-size: 20px;">
						<?php include("time.php");?>
					</span>
				</p><p></p>
			</div>
        </div>
        <div class="u-expanded-width u-list u-list-1" id="refresh">
			<div class="u-repeater u-repeater-1">

			<?php
			
				$ex=$conn->query("
					SELECT e.*, COALESCE(c.guest_count, 0) AS tguest 
					FROM events e 
					LEFT JOIN (
						SELECT eid, COUNT(*) AS guest_count 
						FROM codes 
						WHERE status != '0' 
						GROUP BY eid
					) c ON e.id = c.eid
					ORDER BY e.id
				")or die(mysqli_error($conn));

				while($rs=mysqli_fetch_array($ex)){
			
				$ID=$rs["id"];				
				$i=1;	
				$total=0;
				$tguest=$rs["tguest"];
			?>
			
				<?php echo"<a style='text-decoration:none' href='events.php?events=$rs[0]'>";?>

				<div class="divhove u-align-center u-container-style u-custom-color-1 u-list-item u-opacity u-opacity-70 u-radius-50 u-repeater-item u-shape-round u-video-cover">
					<div class="u-container-layout u-similar-container u-container-layout-2">
						<span>
							<img src="images/calendar.png" height="70">
						</span>
					<h4 class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-4">
						<?php echo"".$rs["event"]."";?>
					</h4>
						<?php echo"".$rs["venue"]."";?><br>
						<?php echo"".$rs["date_fr"]."";?> -
						<?php echo"".$rs["date_to"]."";?>
					<p class="u-text u-text-body-alt-color u-text-default u-text-5" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000">
						
						<?php echo "$tguest";?>
						
					</p>
					<h3 class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-6">
						Total <?php echo"".$rs["service"]."";?>
					</h3>
				  </div>
				</div>
				
				</a>	
			
				<?php } ?>
		
			</div>
		</div>
	</div>
</section>
    
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