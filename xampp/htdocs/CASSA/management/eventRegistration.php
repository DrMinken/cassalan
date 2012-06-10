<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 

<?php 
	session_start();										// Start/resume THIS session

	// PAGE SECURITY
	if (!isset($_SESSION['isAdmin']))
	{
		if ($_SESSION['isAdmin'] != 0)
		{
			echo '<script type="text/javascript">history.back()</script>';
			die();
		}
	}

	$_SESSION['title'] = "Event Registration | MegaLAN"; 	// Declare this page's Title
	include("../includes/template.php"); 					// Include the template page
	include("../includes/conn.php"); 						// Include the db connection


// IF [this] USER BOOKS FOR AN EVENT
	if (isset($_POST['bookID']))
	{
	// CHECK IF USER HAS BOOKED THIS EVENT
		$check = "SELECT * FROM attendee WHERE clientID='".$_SESSION['userID']."'";
		$result = $db->query($check);

		// IF THEY HAVE BOOKED 'an' EVENT
		if ($result->lengths != NULL)
		{
			// SEE IF THEY HAVE BOOKED 'this' EVENT
			$row = $result->fetch_assoc();
			if ($row['eventID'] == $_POST['bookID'])
			{
				$_SESSION['errMsg'] == '<font class="error">Sorry you have already booked this event</font>';
			}
		}
		// BOOK [this] EVENT
		else
		{
			$book = "INSERT INTO attendee (eventID, clientID) VALUES ('".$_POST['bookID']."', '".$_SESSION['userID']."')";
			$result = $db->query($book);

			/*
			*	AT THIS STAGE, THIS USER HAS BOOKED AN EVENT
			*	THE USER YET HAS TO:
			*		-BOOK A TOURNAMENT
			*		-BOOK A SEAT
			*		-BOOK PIZZA (optional)
			*/
		}
	}

// IF [this] USER CANCELS A SEAT
	if (isset($_POST['seatID']))
	{
		$cancel = "UPDATE attendee SET seatID=NULL WHERE attendeeID='".$_POST['attendeeID']."' AND clientID='".$_SESSION['userID']."'";
		$result = $db->query($cancel);

		$cancel = "UPDATE seat SET status='1' WHERE seatID='".$_POST['seatID']."'";
		$result = $db->query($cancel);

		/*
		*	AT THIS STAGE, THIS USER HAS BOOKED AN EVENT
		*	THE USER YET HAS TO:
		*		-BOOK A TOURNAMENT
		*		-BOOK A SEAT
		*		-BOOK PIZZA (optional)
		*/
	}
?>


<!-- //******************************************************

// Name of File: eventRegister.php
// Revision: 1.0
// Date: 14/05/2012
// Author: Quintin
// Modified: 

//***********************************************************

//********** Start of EVENT REGISTRATION PAGE ************** -->

<head>

<script type='text/javascript'>

// DISPLAY EVENT DETAILS FIRST
function getEvent(params)
{
	if (window.XMLHttpRequest)
	{	
		// code for mainstream browsers
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		// code for earlier IE versions
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("ajaxDIV").innerHTML=xmlhttp.responseText;
		}
	}

	//Now we have the xmlhttp object, get the data using AJAX.
	xmlhttp.open("POST","ajaxEvent.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(params);
}

// BOOK EVENT
function book(id)
{
	var answer = confirm("Please confirm to book this Event");

	if (answer == true)
	{
		document.getElementById('bookID').value = id;
		document.bookEvent.submit();
	}
}
// BOOK TOURNAMENT
function bookTournament(tournID, attendeeID)
{
	var answer = confirm("Please confirm to book this Tournament");

	if (answer == true)
	{
		var params = "tournID=" + tournID + "&attendeeID=" + attendeeID + "&subject=book";
		getEvent(params);
	}
}
// CANCEL TOURNAMENT
function cancelTournament(tournID, attendeeID)
{
	var answer = confirm("Please confirm to cancel this Tournament");

	if (answer == true)
	{
		var params = "tournID=" + tournID + "&attendeeID=" + attendeeID + "&subject=cancel";
		getEvent(params);
	}
}
// CANCEL SEAT
function cancelSeat(seatID, attendeeID)
{
	var answer = confirm("Please confirm to cancel this Seat");

	if (answer == true)
	{
		document.getElementById('seatID').value = seatID;
		document.getElementById('attendeeID').value = attendeeID;
		document.cancelThisSeat.submit();
	}
}
</script>

</head>

<body onload='getEvent("t=<?php if(isset($_GET['t'])){echo $_GET['t'];}else{echo "1";}?>");'>	
<center>

<div id='shell'>
<!-- Main Content [left] -->

<div id="content">
<h2>
	Event Registration For: 
	<font size="4" style='font-family: Segoe Print;'><?php echo $_SESSION['fullName']; ?></font>
</h2>






<br />






<!-- GET [this] USERS BOOKED EVENTS -->
<?php
	// GET ATTENDEE EVENT DETAILS
	$get = "SELECT * FROM attendee WHERE clientID = '".$_SESSION['userID']."'";
	$result = $db->query($get);

	if ($result->num_rows == 0)
	{
		$rowEvent = 'No';
		$tournID = 'No';
		$seatID = 'No';
		$pizzaID = 'No';
	}
	else
	{
		for($i=0; $i<$result->num_rows; $i++)
		{
			$row = $result->fetch_assoc();

		// GET ATTENDEE TOURNAMENT DETAILS
			$getT = "SELECT * FROM attendee_tournament WHERE attendeeID = '".$row['attendeeID']."'";
			$resultT = $db->query($getT);

			if ($resultT->num_rows == 0)
			{
				// Tournament == FALSE
				$rowEvent = 'Yes';
				$tournID = 'No';
			}
			else
			{
				// Tournament == TRUE
				$rowT = $resultT->fetch_assoc();
				$tournID = $rowT['tournID'];
				if ($rowT['tournID'] == ''){$tournID = 'No';}else{$tournID = 'Yes';}
			}

		// GET EVENT DETAILS
				$get = "SELECT * FROM event WHERE eventID='".$row['eventID']."'";
				$result = $db->query($get);
				$rowEvent = $result->fetch_assoc();

		// GET SEAT DETAILS
				if ($row['seatID'] == ''){$seatID = 'No';}else{$seatID = 'Yes';}

		// GET PIZZA DETAILS
				$get = "SELECT * FROM pizza_order WHERE attendeeID = '".$row['attendeeID']."'";
				$result = $db->query($get);
				if ($result->lengths == NULL){$pizzaID = 'No';}else{$pizzaID = 'Yes';}
		}
	}
?>






<div class='eventSlider' align='center'>

	<!-- AJAX DYNAMIC DIV -->
	<div class='event'><div id='ajaxDIV'></div></div>


	<?php 
		// SETUP MOUSE CLICK CLASSES
		$onclick = 
		'document.getElementById("eventBUT").className="eBAR pointer"; 		document.getElementById("tournBUT").className="eBAR pointer"; document.getElementById("seatBUT").className="eBAR pointer"; document.getElementById("pizzaBUT").className="eBAR pointer"; this.className="eBAR_ON pointer";';

		// CHECK IF OUTSIDE PAGE IS TRYING TO ACCESS A CERTAIN MENU BAR 
		// 1 = EVENT
		// 2 = TOURNAMENT
		// 3 = SEAT
		// 4 = PIZZA
		// DEFAULT = 1
		$eBAR1 = 'eBAR_ON'; $eBAR2 = 'eBAR'; $eBAR3 = 'eBAR'; $eBAR4 = 'eBAR';
		if(isset($_GET['t']))
		{
			if ($_GET['t'] == 1){$eBAR1 = 'eBAR_ON';}else{$eBAR1 = 'eBAR';}
			if ($_GET['t'] == 2){$eBAR2 = 'eBAR_ON';}else{$eBAR2 = 'eBAR';}
			if ($_GET['t'] == 3){$eBAR3 = 'eBAR_ON';}else{$eBAR3 = 'eBAR';}
			if ($_GET['t'] == 4){$eBAR4 = 'eBAR_ON';}else{$eBAR4 = 'eBAR';}
		}
	?>


	<!-- LEFT CONTROL PANEL -->
	<div class='eventBAR'>
		<div id='eventBUT' class='pointer; <?php echo $eBAR1; ?>' 
			 onclick='getEvent("t=1"); <?php echo $onclick; ?>'>
			<div class='eFONT'><font size='2'>1-</font> EVENT</div>
			<?php
			if ($rowEvent['event_name'] == '' || $rowEvent == 'No'){
				echo "<div class='eSTATUS'><img src='/cassa/images/layers/cross.png' /></div>";
			} else {
				echo "<div class='eSTATUS'><img src='/cassa/images/layers/tick.png' /></div>";
			}
			?>
		</div>

		<div id='tournBUT' class='pointer; <?php echo $eBAR2; ?>' 
			 onclick='getEvent("t=2"); <?php echo $onclick; ?>'>
			<div class='eFONT'><font size='2'>2-</font> TOURNAMENT</div>
			<?php
			if ($tournID == 'No'){
				echo "<div class='eSTATUS'><img src='/cassa/images/layers/cross.png' /></div>";
			} else {
				echo "<div class='eSTATUS'><img src='/cassa/images/layers/tick.png' /></div>";
			}
			?>
		</div>

		<div id='seatBUT' class='pointer; <?php echo $eBAR3; ?>' 
			 onclick='getEvent("t=3"); <?php echo $onclick; ?>'>
			<div class='eFONT'><font size='2'>3-</font> SEAT</div>
			<?php
			if ($seatID == 'No') {
				echo "<div class='eSTATUS'><img src='/cassa/images/layers/cross.png' /></div>";
			} else {
				echo "<div class='eSTATUS'><img src='/cassa/images/layers/tick.png' /></div>";
			}
			?>
		</div>

		<div id='pizzaBUT' class='pointer; <?php echo $eBAR4; ?>' 
			 onclick='getEvent("t=4"); <?php echo $onclick; ?>'>
			<div class='eFONT'><font size='2'>4-</font> PIZZA</div>
			<?php
			if ($pizzaID == 'No') {
				echo "<div class='eSTATUS'><img src='/cassa/images/layers/cross.png' /></div>";
			} else {
				echo "<div class='eSTATUS'><img src='/cassa/images/layers/tick.png' /></div>";
			}
			?>
		</div>
	</div>
</div>






<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->
<!--**************************************** -->
<br /><br /><br /><br />

</div><!-- end of: Content -->


<!-- INSERT: footer -->
<div id="footer">
	<?php include('../includes/footer.html'); ?>
</div>

</div><!-- end of: Shell -->

</center>
</body>
</html>

<!-- ********************************* -->
<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->