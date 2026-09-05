<?php 
	error_reporting(0);
	require("connect.php");

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
	  
	while($rs = mysqli_fetch_array($ex)){	
		$eveid = $rs[0];
		$event = $rs["event"];
		$venue = $rs["venue"];
?>
<div class="container" style="margin-top:-30px;margin-bottom:-10px;">
	<div class="col">
		<div style="text-align:center;margin-top:20px"><br>
			<h2>CODE STATUS LIST</h2>
			<h4><?php echo $event;?></h4>
			<h6><?php echo $venue;?></h6>	
		</div>
		<div>
			<table class="table responsive">
				<thead class="text-dark">
					<tr>
						<th style="padding:2px">#</th>
						<th style="padding:2px">Status</th>
						<th style="padding:2px">Type</th>
						<th style="padding:2px">QR#</th>
						<th style="padding:2px">Img</th>
					</tr>
				</thead>
				<tbody class="text-dark">
				<?php
					$ex1 = $conn->query("select * from codes where eid='$eveid' order by cid ");
					while($rs1=mysqli_fetch_array($ex1)){
						$cid=$rs1[0];
						$sts=$rs1["status"];
						$typ=$rs1["ctype"];
						$image = "".$eveid."".$cid."";
				?>
					<tr>
						<td style="padding:2px"><?php echo $i;?></td>
						<td style="padding:2px">
							<?php if(($rs1["status"])=="0") echo"Ready"; else echo $sts;?>
						</td>
						<td style="padding:2px"><?php echo $typ;?></td>
						<td style="padding:2px">
						<?php 
							$code="".$eveid."".$cid."";
							printf("%04d", $code);		
						?>
						</td>
						<td style="padding:2px">
							<?php echo"<img src='images/qrcodes/".$image.".png' height='28'>";?>
						</td>
					</tr>
				<?php $i++;	} ?>				
				</tbody>
			</table>
		</div>
	</div>
</div>	
<?php } ?>
		
