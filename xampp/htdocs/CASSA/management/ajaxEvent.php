<?php 
	session_start();
	include("../includes/conn.php");					// Include the db connection
	include("../includes/functions.php");				// Include general functions

	// PAGE SECURITY
	if (!isset($_SESSION['isAdmin']))
	{
		if ($_SESSION['isAdmin'] == 0)
		{
			echo '<script type="text/javascript">history.back()</script>';
			die();
		}
	}


if (isset($_POST['subject']))
{
	// IF [this] USER BOOKS FOR A TOURNAMENT
	if ($_POST['subject'] == 'book')
	{
		$insert = "INSERT INTO `attendee_tournament` (attendeeID, tournID) VALUES ('".$_POST['attendeeID']."', '".$_POST['tournID']."')";
		$result = $db->query($insert);
		
		$_POST['t'] = 2;

		/*
		*	AT THIS STAGE, THIS USER HAS BOOKED AN EVENT AND A TOURNAMENT
		*	THE USER YET HAS TO:
		*		-BOOK A SEAT
		*		-BOOK PIZZA (optional)
		*/
	}

	// IF [this] USER CANCELS A TOURNAMENT
	else if ($_POST['subject'] == 'cancel')
	{
		$cancel = "DELETE FROM attendee_tournament WHERE attendeeID='".$_POST['attendeeID']."' AND tournID='".$_POST['tournID']."'";
		$result = $db->query($cancel);
		
		$_POST['t'] = 2;

		/*
		*	AT THIS STAGE, THIS USER HAS BOOKED AN EVENT
		*	THE USER YET HAS TO:
		*		-BOOK A TOURNAMENT
		*/
	}
}





if (isset($_POST['t']))
{
// EVENT TRIGGER
	if($_POST['t'] == 1)
	{
		// CHECK IF [this] CLIENT HAS BOOKED A CURRENT EVENT
		$check = "SELECT * FROM attendee WHERE clientID='".$_SESSION['userID']."'";
		$result = $db->query($check);
		$row = $result->fetch_assoc();

		if ($row['eventID'] == NULL)
		{
			// DISPLAY ALL AVAILABLE EVENTS TO USER FOR BOOKING
			display_all_events($db);
		}
		else
		{
			// DISPLAY ALL [this] USERS BOOKED EVENTS
			display_all_booked_events($db);
		}
	}

// TOURNAMENT TRIGGER
	else if ($_POST['t'] == 2)
	{
		// CHECK IF [this] CLIENT HAS BOOKED A TOURNAMENT
		$check = "SELECT `tournID` FROM attendee WHERE clientID='".$_SESSION['userID']."'";
		$result = $db->query($check);

		if ($result == false)
		{
			//$row = $result->fetch_assoc();

			// AT THIS STAGE, A USER HAS BOOKED AN EVENT
			// HOWEVER, HAS NOT BOOKED A TOURNAMENT

			// DISPLAY ALL AVAILABLE EVENT-->TOURNAMENT TO USER FOR BOOKING
			display_all_event_tournaments($db);
		}
		else
		{
			$row = $result->fetch_assoc();

			// DISPLAY ALL [this] USERS BOOKED TOURNAMENTS
			display_all_booked_tournaments($db);
		}
	}

// SEAT TRIGGER
	else if ($_POST['t'] == 3)
	{
		// CHECK IF [this] CLIENT HAS BOOKED A TOURNAMENT
		$check = "SELECT * FROM attendee WHERE clientID='".$_SESSION['userID']."'";
		$result = $db->query($check);

		if ($result->num_rows == 0)
		{
			$row = $result->fetch_assoc();

			// AT THIS STAGE, A USER HAS BOOKED AN EVENT
			// HOWEVER, HAS NOT BOOKED A TOURNAMENT
			echo "<table class='displayTable chair' border='0' style='line-height: 17pt'>";
			echo "<tfoot><tr><td align='center' height='60px'>";
				echo "<font class='error'>You must book an Event before you can reserve a seat</font>"; 
				echo "<br /><br /><a href='eventRegistration.php?t=1'>Click here to book an Event</a>";
			echo "</td></tr></tfoot>";
			echo "</table>";
		}
		else
		{
			// CHECK IF [this] USER HAS BOOKED A SEAT
			$check = "SELECT * FROM attendee WHERE clientID='".$_SESSION['userID']."'";
			$result = $db->query($check);
			$row = $result->fetch_assoc();

			if ($row['seatID'] == NULL)
			{
				// AT THIS STAGE, A USER HAS BOOKED AN EVENT AND A TOURNAMENT
				// HOWEVER, HAS NOT BOOKED A SEAT
				echo "<table class='displayTable chair' border='0' style='line-height: 17pt'>";
				echo "<tr><td align='center'><a href='/cassa/seatMap.php'>Click here to book a seat</a></td></tr>";
				echo "</table>";
			}
			else
			{
				// DISPLAY THE SEAT NUMBER
				echo "<table class='displayTable chair' border='0' style='line-height: 17pt'>";
				echo "<tr><td><b>Your reserved seat number is:</b> ".$row['seatID']."";
				echo '&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '<img class="pointer" src="/cassa/images/buttons/cancel.png" onclick="cancelSeat('.$row['seatID'].', '.$row['attendeeID'].')" alt="Cancel this Seat" /></td></tr>';
				echo "</table>";

				// FORM: CANCEL [this] SEAT
				echo "<form name='cancelThisSeat' method='POST' action='eventRegistration.php'>";
				echo "<input type='hidden' name='seatID' id='seatID' value='' />";
				echo "<input type='hidden' name='attendeeID' id='attendeeID' value='' />";
				echo "</form>";
			}
		}
	}




// PIZZA TRIGGER
	else if ($_POST['t'] == 4)
	{
		// GET ALL OF THIS EVENTS PIZZAS

	}
}







/*
 * E V E N T
 */
function display_all_events($db)
{
	// GET ALL CURRENT EVENTS
	$query = "SELECT * FROM event WHERE startDate >= NOW() AND event_completed = 0 ORDER BY 'desc'";
	$result = $db->query($query);
?>
	<table class='displayTable' name='eventRegistration' border='0'>
<?php 
		if(isset($_SESSION['errMsg']))
		{
			echo '<caption>';
				echo $_SESSION['errMsg'];
				unset($_SESSION['errMsg']);
			echo '</caption>';
		}

	if ($result->num_rows == 0)
	{
		echo '<tr><td align="center" style="height: 230px;">';
		echo '<font class="error">MegaLAN has no events running at this time.</font></td></tr>';
	}
	else
	{
		?>
		<tr>
			<th align='left'>Name</th>
			<th align='left'>Location</th>
			<th align='center' width="70px">Date</th>
			<th align='center' width="80px">Start Time</th>
			<th align='center' width="90px">Seat QTY</th>
			<th width="106px">&nbsp;</th>
		</tr>
	<?php
		echo '<tfoot><td align="center" colspan="6" height="80px">';
		echo '<font class="error">You have not booked an Event yet</font></td></tfoot>';

		for ($i=0; $i<$result->num_rows; $i++)
		{
			// SETUP [this] ROW DETAILS
			$row = $result->fetch_assoc();    
			$name = $row['event_name'];
			$location = $row['event_location'];
			$date = dateToScreen($row['startDate']);
			$startTime = removeSeconds($row['startTime']);
			$seatQuantity = $row['seatQuantity'];

			// FIND OUT HOW MANY SEATS HAVE BEEN BOOKED FOR THIS EVENT
			$seatCheck = "SELECT * FROM seat WHERE status=0";
			$seatResult = $db->query($seatCheck);
			$seatCount = $seatResult->num_rows;

			// SETUP ON MOUSE EVENTS
			$on = "this.style.backgroundColor='#E0ECF8'";
			$off = "this.style.backgroundColor='transparent'";
			$onclick = "book(".$row['eventID'].")";

			echo '<tr onmouseover="'.$on.'" onmouseout="'.$off.'">';
				echo '<td>'.$name.'</td>';
				echo '<td>'.$location.'</td>';
				echo '<td>'.$date.'</td>';
				echo '<td align="center">'.$startTime.'</td>';
				echo '<td align="center">'.$seatCount. '/' .$seatQuantity.'</td>';
				echo '<td onclick="'.$onclick.'" class="pointer">';
					echo '<img src="/cassa/images/buttons/book.png" alt="Book this event" /></td>';
			echo '</tr>';
		}
	}
?>
	</table>

	<!-- FORM: BOOK [this] EVENT -->
	<form name='bookEvent' method='POST' action='eventRegistration.php'>
	<input type='hidden' name='bookID' id='bookID' value='' />
	</form>
<?php
}






function display_all_booked_events($db)
{
	// GET ALL OF [this] USERS CURRENTLY BOOKED EVENTS @ ATTENDEE
	$query = "SELECT * FROM attendee WHERE clientID='".$_SESSION['userID']."' ORDER BY 'desc'";
	$result = $db->query($query);
?>
	<table class='displayTable' name='eventRegistration'>
	<caption><?php if(isset($_SESSION['errMsg'])){echo $_SESSION['errMsg'];unset($_SESSION['errMsg']);}?></caption>
<?php
	for ($i=0; $i<$result->num_rows; $i++)
	{
		// GET ASSOCIATED ROW @ ATTENDEE
		$row = $result->fetch_assoc();

		// GET ASSOCIATED ROW @ EVENT
		$get = "SELECT * FROM event WHERE eventID = '".$row['eventID']."'";
		$result = $db->query($get);
		$rowEvent = $result->fetch_assoc();

		// SETUP [this] ROW DETAILS
		$name = $rowEvent['event_name'];
		$location = $rowEvent['event_location'];
		$date = $rowEvent['startDate'];
		$startTime = $rowEvent['startTime'];
		$seatQuantity = $rowEvent['seatQuantity'];
		
		// SETUP MOUSE EVENTS
		$onclick = "book(".$row['eventID'].")";

		echo '<tr><td class="displayRow">Event Name</td><td>'.$name.'</td></tr>';
		echo '<tr><td class="displayRow">Location</td><td>'.$location.'</td></tr>';
		echo '<tr><td class="displayRow">Event Date</td><td>'.$date.'</td></tr>';
		echo '<tr><td class="displayRow">Start Time</td><td>'.$startTime.'</td></tr>';
		echo '<tr><td class="displayRow">Seat Quantity</td><td>'.$seatQuantity.'</td></tr>';
	}
?>
	</table>
<?php
}





/*
 * T O U R N A M E N T 
 */
// DISPLAY ALL TOURNAMENTS FOR [this] USER TO BOOK
function display_all_event_tournaments($db)
{
	// GET ALL OF [this] USERS CURRENTLY BOOKED EVENTS @ ATTENDEE
	$query = "SELECT * FROM attendee WHERE clientID='".$_SESSION['userID']."' ORDER BY 'desc'";
	$result = $db->query($query);
?>

<table class='displayTable' border='0' style='line-height: 17pt;'>
<?php 
	if(isset($_SESSION['errMsg']))
	{
		echo "<tfoot><tr><td colspan='5' align='center' height='60px'>";
			echo $_SESSION['errMsg'];
			unset($_SESSION['errMsg']);
		echo "</td></tr></tfoot>";
	}

	if ($result->num_rows == 0)
	{
		echo "<tr><td align='center' style='height: 230px;'>";
			echo "<font class='error'>You must book an Event before you can book a tournament</font>"; 
			echo "<br /><br /><a href='eventRegistration.php?t=1'>Click here to book an Event</a>";
		echo "</td></tr>";
	}
	else
	{
		for ($i=0; $i<$result->num_rows; $i++)
		{
			// GET ASSOCIATED ROW @ ATTENDEE
			$row = $result->fetch_assoc();

			// GET ASSOCIATED ROW @ EVENT
			$get = "SELECT * FROM event WHERE eventID = '".$row['eventID']."'";
			$result = $db->query($get);
			$rowEvent = $result->fetch_assoc();

			// SETUP [this] ROW DETAILS
			$name = $rowEvent['event_name'];
				/*$location = $rowEvent['event_location'];
				$date = $rowEvent['startDate'];
				$startTime = $rowEvent['startTime'];
				$seatQuantity = $rowEvent['seatQuantity'];*/

			echo '<tr><td colspan="5"><b>'.$name.'</b> Tournament List:</td></tr>';
			echo '<tr><td colspan="5"><br /></td></tr>';
		}
	?>

	<tr>
		<td><b>Tournament Name</b></td>
		<td><b>Date</b></td>
		<td><b>Start Time</b></td>
		<td><b>End Time</b></td>
		<td>&nbsp;</td>
	</tr>

	<?php
		// GET ALL RELATED TOURNAMENTS TO [this] EVENT
		$get = "SELECT * FROM tournament WHERE eventID='".$row['eventID']."' ORDER BY 'desc'";
		$result = $db->query($get);

		for ($i=0; $i<$result->num_rows; $i++)
		{
			$rowTourn = $result->fetch_assoc();

			// CHECK IF USER HAS BOOKED [this] TOURNAMENT
			$check = "SELECT * FROM attendee_tournament WHERE attendeeID='".$row['attendeeID']."' AND tournID='".$rowTourn['tournID']."'";
			$resultCheck = $db->query($check);
			$rowAttendee = $resultCheck->fetch_assoc();

			echo '<tr>';
				echo '<td>'.$rowTourn['name'].'</td>';
				echo '<td>'.dateToScreen($rowEvent['startDate']).'</td>';
				echo '<td>'.removeSeconds($rowTourn['start_time']).'</td>';
				echo '<td>'.removeSeconds($rowTourn['end_time']).'</td>';
				
				if (empty($rowAttendee))
				{
					echo '<td><img class="pointer" src="/cassa/images/buttons/book.png"  onclick="bookTournament('.$rowTourn['tournID'].', '.$row['attendeeID'].')" alt="Book this tournament" /></td>';
				}
				else
				{
					echo '<td><img class="pointer" src="/cassa/images/buttons/cancel.png"  onclick="cancelTournament('.$rowTourn['tournID'].', '.$row['attendeeID'].')" alt="Cancel this tournament" /></td>';
				}
			echo '</tr>';
		}
	}
	?>
</table>
	<!-- FORM: BOOK [this] TOURNAMENT -->
	<form name='bookTourn' method='POST' action='eventRegistration.php'>
	<input type='hidden' name='bookTournamentID' id='bookTournamentID' value='' />
	<input type='hidden' name='attendeeID' id='attendeeID' value='' />
	</form>
<?php
}









// DISPLAY ALL BOOKED TOURNAMENTS [this] USER HAS BOOKED
function display_all_booked_tournaments($db)
{
?>
<table class='displayTable' border='0' style='line-height: 17pt'>
<tfoot><tr><td colspan='5' align='center' height='60px'><?php if(isset($_SESSION['errMsg'])){echo $_SESSION['errMsg'];unset($_SESSION['errMsg']);}?></td></tr></tfoot>
	<tr>
		<td><b>Tournament Name</b></td>
		<td><b>Date</b></td>
		<td><b>Start Time</b></td>
		<td><b>End Time</b></td>
		<td>&nbsp;</td>
	</tr>

<?php
	// GET ALL OF [this] USERS CURRENTLY BOOKED TOURNAMENTS @ ATTENDEE
	$query = "SELECT * FROM attendee WHERE clientID='".$_SESSION['userID']."'";
	$result = $db->query($query);

	for($i=0; $i<$result->num_rows; $i++)
	{
		// [this] SINGLE TOURNAMENT
		$row = $result->fetch_assoc();

		// GET [this] TOURNAMENT DETAILS
		$get = "SELECT * FROM attendee_tournament WHERE attendeeID='".$row['attendeeID']."' ORDER BY 'desc'";
		$resultDetails = $db->query($get);
	
		for ($i=0; $i<$resultDetails->num_rows; $i++)
		{
			$rowTourn = $resultDetails->fetch_assoc();

			echo '<tr>';
				echo '<td>'.$rowTourn['name'].'</td>';
				echo '<td>'.$rowTourn['date'].'</td>';
				echo '<td>'.$rowTourn['start_time'].'</td>';
				echo '<td>'.$rowTourn['end_time'].'</td>';
				echo '<td><img class="pointer" src="/cassa/images/buttons/cancel.png" onclick="cancelTournament('.$rowTourn['tournID'].', '.$row['attendeeID'].')" alt="Cancel this tournament" /></td>';
			echo '</tr>';
		}
	}
	?>
</table>
	<!-- FORM: CANCEL [this] TOURNAMENT -->
	<form name='cancelTourn' method='POST' action='eventRegistration.php'>
	<input type='hidden' name='cancelTournID' id='cancelTournID' value='' />
	<input type='hidden' name='attendeeID' id='attendeeID' value='' />
	</form>
<?php
}