<?php 
	error_reporting(0);
	require("connect.php");

	$rec=1;

	$p=$_GET["page"];
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
				
	$srv="";
	if($_GET["servers"]!="")
		$srv=" and sid='".$_GET["servers"]."' ";
												
	$ex = $conn->query("select * from servers where sid=sid $srv order by sid limit $from,$to ");

	while($rs = mysqli_fetch_array($ex)){	

	$ex = $conn->query("select * from servers s where s.sid='$rs[0]' and s.sid=s.sid ");

	while($rs = mysqli_fetch_array($ex)){
			
	$srvno = $rs[0];
	$sname = $rs["server"];		
?>

<form action="server-config-proc.php" method="POST">
	<div class="container text-center" style="padding:0;min-width:400px">
		<br><h3>Server IP Address <br> or Domain Name</h3>
		<div style="margin-left:20px;text-align:left">
			<b>Know your Host:</b>
			<ul style="margin-top:0px">
				<li>IF Hosted Locally Enter IP Address</li>
				<li>IF Hosted Online Enter Domain Name</li>
			</ul>
		</div>
		<div class="forn-group">
			<div style="margin:10px">
				<input type="hidden" class="form-control" name="servidno" value="<?php echo $srvno;?>">
			</div>
			<div style="margin:10px">
				<input type="text" class="form-control" name="servname" value="<?php echo $sname;?>" placeholder="IP Address or Domain Name" required>
			</div>
			</div>
			<div style="margin:10px">
				<button type="SUBMIT" class="form-control btn btn-primary" name="upDate">Update</button>
			</div>
		</div>
	</div>
</form>

<?php
		}		
	}								
?>	