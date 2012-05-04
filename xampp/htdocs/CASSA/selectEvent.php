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
 	$result = $db->query($query);
 	$row1 = $result->fetch_array(MYSQLI_BOTH);
 	$result->close();
 	$result = $db->query($query); 
	
echo '<br /><br />';
echo '<table id="eventDetail">';
echo '<tr><td  align: "center" colspan="2" id="headCell"> Event Details for : ' . $row1['event_name'].'</td></tr>';

while($row = $result->fetch_array(MYSQLI_BOTH))
{
  echo '<tr><td id="titleCell">Event Location: </td><td id="detailCell">' . $row['event_location'] . '</td></tr>';
  echo '<tr><td id="titleCell">Event Start Time: </td><td id="detailCell">' . $row['startTime'] . '</td></tr>';
  echo '<tr><td id="titleCell">Number of Seats: </td><td id="detailCell">' . $row['seatQuantity'] . '</td></tr>';
  echo '<tr><td id="titleCell">Server IP Address: </td><td id="detailCell">' . $row['server_IP_address'] . '</td></tr>';
  echo '<tr><td id="titleCell">Event Started: </td><td id="detailCell">' . $row['event_started'] . '</td></tr>';
  }
echo '</table>';

?>