<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Event Guest Counter">
	<meta http-equiv="refresh" content="300">
	<title>Event Guest Counter</title>
	<link rel="shortcut icon" href="images/favicon.png" />
    <link rel="stylesheet" href="nicepage.css" media="screen">
	<link rel="stylesheet" href="home.css" media="screen">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<script src="assets/js/jquery.js"></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">

	<link href="facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
	<script src="facebox/facebox.js" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  $('a[rel*=facebox]').facebox({
			loadingImage : 'facebox/loading.gif',
			closeImage   : 'facebox/closelabel.png'
		  })		  
		})
	</script>	
  </head>

<?php
	function jump($page){
		echo "<script>window.location='$page'</script>";
	}
	function Q($qry){
		global $conn;
		return $conn->query($qry);
	}
	function d($qry){
		global $conn;
		return die(mysqli_error($conn));
	}
	function fetch($qry){
		return mysqli_fetch_array($qry);
	}
?>	

<script>
	if (window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	else
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");				
	function getID(id){
		return document.getElementById(id);
	}
	function conf(){
		return confirm("Are you sure??");
	}
	function jump(page){
		window.location=page;
	}
</script>

<body data-home-page="index.php" data-home-page-title="Home" class="u-body">