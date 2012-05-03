<!-- //******************************************************

// Name of File: selectEvent.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Lyndon Smith
// Modified: 

//***********************************************************

//********** Start of select even script ************** -->

<?php 
	session_start();														// Start/resume THIS session
	$_SESSION['title'] = "Event Management | MegaLAN"; 		// Declare this page's Title
	include("includes/conn.php");										// Include the db connection
	$eventID = $_GET['eventID'];
 	$query = "SELECT * FROM event WHERE eventID = '" . $eventID . "'";
	$result = $db->query($query);
echo '<table border="1">';
echo '<tr>';
echo '<th>Event Name</th>';
echo '<th>Location</th>';
echo '<th>Date & Time</th>';
echo '<th>Number of Seats</th>';
echo '<th>Server IP Address</th>';
echo '<th>Event Started</th>';
echo '</tr>';
while($row = $result->fetch_array(MYSQLI_BOTH))
{
  echo '<tr>';
  echo '<td>' . $row['event_name'] . '</td>';
  echo '<td>' . $row['event_location'] . '</td>';
  echo '<td>' . $row['startTime'] . '</td>';
  echo '<td>' . $row['seatQuantity'] . '</td>';
  echo '<td>' . $row['server_IP_address'] . '</td>';
  echo '<td>' . $row['event_started'] . '</td>';
  echo '</tr>';
  }
echo '</table>';

mysql_close($con);

	
?>