<?php 
	session_start();									// Start/resume THIS session
	include("includes/conn.php"); 						// Include the database con


	// IF SOMEONE CLICKED TO BOOK A SEAT
	if (isset($_POST['seatID']))
	{
		// CHECK IF USER IS LOGGED ON
		if (!isset($_SESSION['isAdmin']))
		{
			// Ask user to login
			echo '<script type="text/javascript">';
			echo 'alert("You must be logged in to book a seat");';
			echo 'window.location.href="seatMap.php"';
			echo '</script>';
		}
		else
		{
			// GET [this] USERS CLIENT DETAILS
			/*$get = "SELECT `clientID` FROM client WHERE username='".$_SESSION['username']."'";
			$result = $db->query($get);
			$row = $result->fetch_assoc();
			$clientID = $row['clientID'];*/


			// CHECK IF USER HAS ALREADY RESERVED A SEAT
			$check = "SELECT * FROM attendee WHERE clientID='".$_SESSION['userID']."'";
			$result = $db->query($check);
			$row = $result->fetch_assoc();


			// USER HAS NOT BOOKED A SEAT YET
			if (empty($row['seatID']))
			{
				// BOOK SEAT
				$update = "UPDATE attendee SET seatID='".$_POST['seatID']."' WHERE clientID='".$_SESSION['userID']."'";
				$result = $db->query($update);

				// UPDATE SEAT STATUS
				$update = "UPDATE seat SET status='N' WHERE seatID='".$_POST['seatID']."'";
				$result = $db->query($update);

				// DISPLAY CONFIRMATION 
				echo '<script type="text/javascript">';
				echo 'alert("Your seat booking has been made\nThank you");';
				echo 'window.location.href="client_summary.php"';
				echo '</script>';

				// SEND EMAIL CONFIRMATION
				/*
				*
				*
				*/
			}
			// USER HAS ALREADY BOOKED A SEAT
			else
			{
				echo '<script type="text/javascript">alert("You have already booked a seat");</script>';
			}
		}
	}


	// GET CURRENT SEAT STATUS
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
		$src = '/cassa/images/seatPlan/seat';

			// SET TOP/BOTTOM VIEW SEATS
			$top = "Top_";
			$bot = "Bot_";

			// SET EXTENSION
			$ext = ".png' />";

		// SET MOUSE EVENTS
		$mover = " onmouseover='showName(this.id)'";
		$mout = " onmouseout='hideName()'";
		$onclick = " onclick='bookSeat(this.id)'";
?>


<script type='text/javascript'>
	function showName(seat)
	{
		// SEAT NUMBER
		document.getElementById('seatNumber').value = seat;

		// SEAT NAME
		var name = document.getElementById(seat + 'name').value;
		document.getElementById('seatName').value = name;
	}
	function hideName()
	{
		document.getElementById('seatNumber').value = '';
		document.getElementById('seatName').value = '';
	}
	function bookSeat(seat)
	{
		if (document.getElementById(seat + 'name').value.length <= 2)
		{
			document.getElementById('seatReady').value = 'YES';
			var answer = confirm("Please confirm to book seat number "+seat);

			if (answer == true)
			{
				document.bookThisSeat['seatID'].value = seat;
				document.bookThisSeat.submit();
			}
		}
		else
		{
			document.getElementById('seatReady').value = 'NO';
		}
	}
</script>






<!-- FORM IN WHICH GETS POSTED IF A USER CLICKS TO BOOK A SEAT -->
<form name='bookThisSeat' method='POST' action='seatMapLayout.php'>
	<input type='hidden' name='seatID' id='seatID' value='' />
</form>






<!-- SEAT PLAN LAYOUT -->
<img src='/cassa/images/seatPlan/layout.png' border='0' />






<!-- B O T T O M   D E T A I L S -->
	<!-- BOTTOM RIGHT LEGEND -->
	<div id='legend' style='float: right'>	
	<br />
		<img src='/cassa/images/seatPlan/seatTop_Y30.png' /> <b>Available</b> 
		<img src='/cassa/images/seatPlan/seatTop_N30.png' /> <b>Booked</b>
		<img src='/cassa/images/seatPlan/seatTop_R30.png' /> <b>Reserved</b>
	</div><!-- end of: LEGEND -->


	<!-- BOTTOM SEAT DETAIL -->
	<div id='seatDetails'>
	<br />
	Seat Number: 
		<input type='text' name='seatNumber' id='seatNumber' value='' size='2' readonly='readonly' />
	
	&nbsp;&nbsp;&nbsp;
	
	Reserved For: 
		<input type='text' name='seatName' id='seatName' value='' size='32' readonly='readonly' />

	&nbsp;&nbsp;&nbsp;
	
	Good to book?: 
		<input type='text' name='seatReady' id='seatReady' value='' size='3' readonly='readonly' />
	</div><!-- end of: SEAT DETAIL -->






<!-- L A Y O U T   T A B L E -->
	<!-- TABLE SECTION 1 [TOP LEFT] -->
	<table id='S1' class='seat' cellspacing="0" cellpadding="0" border='0'>
		<!-- [this] TABLE TOP ROW -->
		<tr>
		<?php
			for ($i=0; $i<5; $i++)
			{
			// SET HIDDEN FIELD WITH CLIENT NAME
			echo "<input type='hidden' name='".($i+1)."name' id='".($i+1)."name' value='".$client[$i]."' />";

				// [this] SEAT 
				echo "<td id='".($i+1)."' ".$mover.$mout.$onclick.">";
					
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
				echo "<td id='".($i+1)."' ".$mover.$mout.$onclick.">";

					// [this] SEAT NUMBER
					echo "<img class='seat_sm pointer' src='".$src.$bot.$seatStatus[$i].$ext;

					// [this] SEAT IMAGE
					echo "<div class='seatNumberBot'>".($i+1)."</div>";
				echo "</td>";
			}
		?>		
		</tr>
	</table>



	<!-- TABLE SECTION 2 [TOP RIGHT] -->
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




	<!-- TABLE SECTION 3 [MIDDLE TOP] -->
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




	<!-- TABLE SECTION 4 [MIDDLE BOTTOM] -->
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



	<!-- TABLE SECTION 5 [BOTTOM RIGHT] -->
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