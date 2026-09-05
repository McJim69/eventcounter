<?php 
	error_reporting(0);
	include("connect.php");

	if (!empty($_GET['codes'])) {
		$qrCode = intval($_GET['codes']);
		
		// Use a proper prepared statement to avoid SQL errors and SQL injection
		$stmt = $conn->prepare("SELECT * FROM codes WHERE cid = ?");
		$stmt->bind_param("i", $qrCode);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result && $result->num_rows > 0) {
			$rs = $result->fetch_assoc();
			$cid = $rs['cid'];
			$eid = $rs['eid'];
			$status = $rs['status'];
			
			$in = false;
			$out = false;
			$fin = false;

			if ($status == "0") {
				$in = $conn->query("UPDATE codes SET status = 'Checkin' WHERE cid = '$cid'") or die(mysqli_error($conn));
			} elseif ($status == "Checkin") {
				$out = $conn->query("UPDATE codes SET status = 'Checkout' WHERE cid = '$cid'") or die(mysqli_error($conn));
			} elseif ($status == "Checkout") {
				$fin = $conn->query("DELETE FROM codes WHERE cid = '$cid'") or die(mysqli_error($conn));
				$file = "images/qrcodes/$eid$cid.png";
				if (file_exists($file)) {
					unlink($file);
				}
			}

			// Get event details for the alert
			$ex1 = $conn->query("SELECT event FROM events WHERE id = '$eid'") or die(mysqli_error($conn));
			$rs1 = mysqli_fetch_assoc($ex1);
			$event_name = $rs1 ? $rs1['event'] : '';

			if ($in) {				
				echo "<script>alert('QR Code " . $cid . " for " . $event_name . " Checking-In. VALID FOR ADMISSION.');
				window.location.href = 'index.php';</script>";
				exit();
			} elseif ($out) {				
				echo "<script>alert('QR Code " . $cid . " for " . $event_name . " Checking-Out. MARKED AS CONSUMED.');
				window.location.href = 'index.php';</script>";
				exit();
			} elseif ($fin) {				
				echo "<script>alert('QR Code " . $cid . " for " . $event_name . " already consumed. NOT VALID FOR ADMISSION.');
				window.location.href = 'index.php';</script>";
				exit();
			}
		} else {
			echo "<script>alert('QR Code NOT Recognized. NOT VALID FOR ADMISSION.');
			window.location.href = 'index.php';</script>";
			exit();
		}
	} else {
		echo "<script>alert('No QR Code provided.');
		window.location.href = 'index.php';</script>";
		exit();
	}
?>