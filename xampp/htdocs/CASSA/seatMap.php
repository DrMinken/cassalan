<?php 
	session_start();									// Start/resume THIS session
	$_SESSION['title'] = "Seat Availability | MegaLAN"; // Declare this page's Title
	include("includes/template.php"); 					// Include the template page
	include("includes/conn.php"); 					// Include the database con


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
?>


<!-- //******************************************************

// Name of File: seatMap.php
// Revision: 1.0
// Date: 15/04/2012
// Author: Quintin M
// Modified: Quintin M 26/04/2012

//***********************************************************

//*************** Start of SEAT AVAILABILITY PAGE ************ -->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

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

</head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Seat Availability</h1>






<!-- FORM IN WHICH GETS POSTED IF A USER CLICKS TO BOOK A SEAT -->
<form name='bookThisSeat' method='POST' action='seatMap.php'>
	<input type='hidden' name='seatID' id='seatID' value='' />
</form>






<!-- SMALL LAYOUT IMAGE 
	 onclick ENLARGE IMAGE WITH EXTRA DETAILS>
<a href="javascript:void(0)" onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">
	<!-- SMALL IMAGE >
	<img src='images/seatPlan/layout.png' border='0' width='571px' height='239px' />
</a -->


<a href="seatMapLayout.php?height=550&width=1189" 
   class="thickbox" 
   title="">
	<!-- SMALL IMAGE -->
	<img src='images/seatPlan/layout.png' border='0' width='571px' height='239px' />
</a>  





















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