<?php 
	error_reporting(0);
	include("connect.php");
	
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
	
	$ex = $conn->query("select * from events where id=id $event $venue order by id limit $from,$to ");
	  
	while($rs = mysqli_fetch_array($ex)){	

	$ex = $conn->query("select * from events where events.id='$rs[0]' and events.id=events.id ");

		while($rs = mysqli_fetch_array($ex)){
			
			$eveid = $rs[0];
			$ename = $rs["event"];
			$place = $rs["venue"];
		}
	}
?>

<div class="generate" style="padding:10px;width:380px;text-align:center">	
	<div style="margin-top:30px">
		<h3 class="text-danger"><?php echo $ename; ?></h3>
		<h5 class="text-dark"><?php echo $place; ?></h5>
		<h2 class="text-primary">GATE PASS CODE</h2>
		<form action="generate-codes.php" method="POST">
			<div style="text-align:left;line-height: 1;">
				<b class="text-danger">Note:</b><br>
				<div style="margin-left:20px;text-align:justify">
					<small>
					Check the server if correctly set before generating the codes. 
					Verify to Menu: <b>Settings-> Server Config</b> or ask your SysAdmin for assistance.
					</small>
				</div>
			</div>
			<div class="form-group">
				<input type="hidden" name="event" class="form-control" value="<?php echo $ename; ?>" readonly >
			</div>			
			<div class="form-group">
				<input type="hidden" name="eid" class="form-control" value="<?php echo $eveid; ?>" >
			</div>				
			<div class="form-group">
				<input type="hidden" name="ctype" class="form-control" value="Walkin" >
			</div>		
			<div class="form-group">
				<input type="hidden" name="status" class="form-control" value="0" >
			</div>
			<div class="form-group">
				<input type="number" name="quantity" min="1" max="1000" class="form-control" placeholder="Quantity (1000 Max per Instance) " required >
			</div>
			<div class="form-group">
				<input type="SUBMIT" name="submit" value="Generate" class="btn btn-danger text-white btn-user btn-block" >
			</div>
		</form>
	</div>
</div>