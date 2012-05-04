<!-- //******************************************************

// Name of File: selectEvent.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Lyndon Smith
// Modified: 

//***********************************************************

//********** Start of select even script ************** -->

<?php 
	include("includes/conn.php");	// Include the db connection	
	$eventID = $_GET['eventID'];
		
										

 	$query = "SELECT * FROM event WHERE eventID =" . $eventID;
 	echo $eventID;
	$result = $db->query($query);
	
	
	
	
echo '<br /><br />';


echo '<table border ="1">';

while($row = $result->fetch_array(MYSQLI_BOTH))
{
  echo '<tr><td>Event Location: </td><td>' . $row['event_location'] . '</td></tr>';
  echo '<tr><td>Event Start Time: </td><td>' . $row['startTime'] . '</td></tr>';
  echo '<tr><td>Number of Seats: </td><td>' . $row['seatQuantity'] . '</td></tr>';
  echo '<tr><td>Server IP Address: </td><td>' . $row['server_IP_address'] . '</td></tr>';
  echo '<tr><td>Event Started: </td><td>' . $row['event_started'] . '</td></tr>';

  }
echo '</table>';



	
?>