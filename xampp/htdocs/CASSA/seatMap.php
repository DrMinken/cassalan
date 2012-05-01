<?php 
	session_start();									// Start/resume THIS session
	$_SESSION['title'] = "Seat Availability | MegaLAN"; // Declare this page's Title
	include("includes/template.php"); 					// Include the template page
	include("includes/conn.php"); 					// Include the database con

?>


<!-- //******************************************************

// Name of File: seatMap.php
// Revision: 1.0
// Date: 15/04/2012
// Author: Quintin M
// Modified: Quintin M 26/04/2012

//***********************************************************

//*************** Start of SEAT AVAILABILITY PAGE ************ -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type='text/javascript'>
	function showName(number)
	{
		// SEAT NUMBER
		document.getElementById('seatNumber').value = number;

		// SEAT NAME
		var name = document.getElementById(number + 'name').value;
		document.getElementById('seatName').value = name;
	}
	function hideName()
	{
		document.getElementById('seatN').value = '';
		document.getElementById('seatName').value = '';
	}
</script>

</head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Seat Availability</h1>

<a href="javascript:void(0)" onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">
		<img src='images/seatPlan/layout.png' border='0' width='571px' height='239px' />
</a>

<div id="light" class="white_content">
	<div id="closeButton">
		<a href="javascript:void(0)" onclick="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><img src='images/layers/cross.png' width='20px' height='20px' border='0' /></a>
	</div>

	<img src='images/seatPlan/layout.png' border='0' />
	

	<div id='legend'>
		<img src='images/seatPlan/seatTop_Y30.png' /> <b>Available</b> 
		<img src='images/seatPlan/seatTop_N30.png' /> <b>Booked</b>
		<img src='images/seatPlan/seatTop_R30.png' /> <b>Reserved</b>
	</div>

	<div id='seatDetails'>
	Seat Number: 
		<input type='text' name='seatNumber' id='seatNumber' value='' size='2' readonly='readonly' />
	
	&nbsp;&nbsp;&nbsp;
	
	Reserved For: 
		<input type='text' name='seatName' id='seatName' value='' size='32' readonly='readonly' />
	</div>


	<!-- GET CURRENT SEAT STATUS -->
	<?php
		$get = "SELECT * FROM seat";
		$result = $db->query($get);
		
		$seatNumber = Array();
		$seatStatus = Array();
		$client = Array();
		for ($i=0; $i<$result->num_rows; $i++)
		{
			$row = $result->fetch_assoc();
			$seatNumber[$i] = $row['seatID'];
			$seatStatus[$i] = $row['status'];

			// DISPLAY ALL SEAT STATUS
			//echo $seatNumber[$i] = $row['seat_number'] . ' | ' .$seatStatus[$i] = $row['status'].'<br/>';

			if ($row['status'] != 'Y')
			{
				// GET [this] CLIENT ID
				$getClient = "SELECT clientID FROM attendee WHERE seatID = '".$seatNumber[$i]."'";
				$resultClient = $db->query($getClient);
				$row = $resultClient->fetch_assoc();
				
				$clientID = $row['clientID'];

				// GET [this] CLIENT DETAILS
				$getName = "SELECT * FROM client WHERE clientID = '".$clientID."'";
				$resultName = $db->query($getName);
				$row = $resultName->fetch_assoc();

				$name = ucwords($row['first_name']. ' ' .$row['last_name']);
				// echo $name.'<br/>';
				$client[$i] = $name;
			}
			else
			{
				$client[$i] = '';
			}
		}

		// SET IMAGE VARIABLE
		$src = 'images/seatPlan/seat';

			// SET TOP/BOTTOM VIEW SEATS
			$top = "Top_";
			$bot = "Bot_";

			// SET EXTENSION
			$ext = ".png' />";

		// SET MOUSE EVENTS
		$mover = " onmouseover='showName(this.id)'";
		$mout = " onmouseout='hideName()'";
	?>


	<table id='S1' class='seat' cellspacing="0" cellpadding="0" border='0'>
		<!-- [this] TABLE TOP ROW -->
		<tr>
		<?php
			for ($i=0; $i<5; $i++)
			{
			// SET HIDDEN FIELD WITH CLIENT NAME
			echo "<input type='hidden' name='".($i+1)."name' id='".($i+1)."name' value='".$client[$i]."' />";

				// [this] SEAT 
				echo "<td id='".($i+1)."' ".$mover.$mout.">";
					
					// [this] SEAT NUMBER
					echo "<div class='seatNumberTop'>".($i+1)."</div>";

					// [this] SEAT IMAGE
					echo "<img class='seat_sm pointer' src='".$src.$top.$seatStatus[$i].$ext;
				echo "</td>";
			}
		?>
		</tr>
		<!-- [this] TABLE BOTTOM ROW -->
		<tr>
		<?php
			for ($i=5; $i<10; $i++)
			{
			// SET HIDDEN FIELD WITH CLIENT NAME
			echo "<input type='hidden' name='".($i+1)."name' id='".($i+1)."name' value='".$client[$i]."' />";

				// [this] SEAT 
				echo "<td id='".($i+1)."' ".$mover.$mout.">";

					// [this] SEAT NUMBER
					echo "<img class='seat_sm pointer' src='".$src.$bot.$seatStatus[$i].$ext;

					// [this] SEAT IMAGE
					echo "<div class='seatNumberBot'>".($i+1)."</div>";
				echo "</td>";
			}
		?>		
		</tr>
	</table>


	<table id='S2' class='seat' cellspacing="0" cellpadding="0">
		<tr>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
		</tr>
		<tr>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
		</tr>
	</table>


	<table id='S3' class='seat' cellspacing="0" cellpadding="0">
		<tr>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
		</tr>
		<tr>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
		</tr>
	</table>


	<table id='S4' class='seat' cellspacing="0" cellpadding="0">
		<tr>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
		</tr>
		<tr>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
		</tr>
	</table>


	<table id='S5' class='seat' cellspacing="0" cellpadding="0">
		<tr>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatTop_green.png' /></td>
		</tr>
		<tr>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
			<td class='pointer'><img class='seat_sm' src='images/seatPlan/seatBot_green.png' /></td>
		</tr>
	</table>


</div>
<div id="fade" class="black_overlay"></div>




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