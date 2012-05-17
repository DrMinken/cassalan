<?php 
	session_start();										// Start/resume THIS session
	$_SESSION['title'] = "Game Server Details | MegaLAN"; 	// Declare this page's Title
	include("includes/template.php"); 						// Include the template page
	include("includes/conn.php");
?>


<!-- //******************************************************

// Name of File: serverDetails.php
// Revision: 1.0
// Date: 17/05/2012
// Author: Quintin M
// Modified: 

//***********************************************************

//*************** Start of SERVER DETAILS PAGE ********** -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Game Server Details</h1><br />



<?php
	// GET ALL CURRENT (NON-FNISHED) EVENTS 
	$select = "SELECT * FROM event WHERE event_completed=0 AND event_started=1 ORDER BY eventDate DESC, startTime DESC";
	$result = $db->query($select);

	for ($i=0; $i<$result->num_rows; $i++)
	{
		$row = $result->fetch_assoc();

		// CHECK HOW MANY SEATS ARE BOOKED FOR [this] EVENT @ attendee
		$check = "SELECT * FROM attendee WHERE eventID='".$row['eventID']."'";
		$resultSeat = $db->query($check);
		$seatCount = $resultSeat->num_rows;


		// DISPLAY ALL OF THIS EVENTS INFORMATION
		echo '<div class="serverDIV">';
			echo '<b><h2>'.$row['event_name'].'</h2></b>';
			echo 'Event Location: '.$row['event_location'].'<br />';
			echo 'Event Room: '.$row['eventRoom'].'<br />';
			echo 'Date: '.$row['eventDate'].'<br />';
			echo 'Start Time: '.$row['startTime'].'<br />';
			echo 'Seat Status: '.$seatCount.' / '.$row['seatQuantity'].'<br />';
			echo 'Server IP Address: '.$row['server_IP_address'].'<br />';
		echo '</div>';

		echo '<br /><br />';
	}
?>





<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->
<!-- ********************************* -->

</div><!-- end of: Content -->


<!-- INSERT: rightPanel -->
<?php include('includes/rightPanel.html'); ?>


<!-- INSERT: footer -->
<div id="footer">
	<?php include('includes/footer.html'); ?>
</div>


</div><!-- end of: Shell -->

</center>
</body>
</html>

<!-- ********************************* -->
<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->