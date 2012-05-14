<!-- //******************************************************

// Name of File: selectEvent.php
// Revision: 1.0
// Date: 30/04/2012
// Author: Lyndon Smith
// Modified: 

//***********************************************************
//This script works in conjuction with the MANeven.php script.
//it acts as partner script and provides the details of the event
//selected in the list box. It returns the data in an AJAX connection.
//
//It uses $_POST in this instance rather than $_GET as there is
//a need for security. It returns a non-editable
//HTML table.
//********** Start of select event script **************-->

<!--*******************************************************-->
<?php 
	
														
	include("../includes/conn.php");											// Include the db connection
	
	$eventID = $_POST['eventID'];												// Retrieve the search value.	
	$queryType = $_POST['queryType'];										// Retrieve the query Identifier.
																					
	if($queryType == 0)
			{
				$query = "SELECT * FROM event WHERE eventID =" . $eventID;		//Create the general select query.
				ajax_event_table_basic($db, $eventID);
			}
	elseif ($queryType == 1)
			{
				
				$query = "UPDATE event "; 
				$query.=	"SET event_started = 2 ";
				$query.=	"WHERE event_started =1 ";
				
				$query2  = "UPDATE event "; 
				$query2 .=	"SET event_started = 1 ";
				$query2 .=	"WHERE eventID =" . $eventID;
				$result = $db->query($query);					//Execute the first Query then.
				
																						
 				$result = $db->query($query2);				//Then Execute the second Query then move on
 				ajax_event_table_basic($db, $eventID);
			}
 elseif ($queryType == 2)
			{
				
				$query2  = "UPDATE event "; 
				$query2 .=	"SET event_started = 2 ";
				$query2 .=	"WHERE eventID =" . $eventID;

 				$result = $db->query($query2);
 				ajax_event_table_basic($db, $eventID);												//Then Execute the Query then move on
 					
			}
elseif ($queryType == 3)
			{
				
 				ajax_event_table_edit($db, $eventID);												
 					
			}												
elseif ($queryType == 4)
			{
				
 				ajax_event_table_save($db, $eventID);												
 				
			}																								
 	
 
 	
 	
//********************* Functions Below *************************************************
function ajax_event_table_save ($db, $eventID) 
{
		echo 'YOU ARE THROUGH';
		die();
}

	
function ajax_event_table_basic($db, $eventID)
{
			
			$query = "SELECT * FROM event WHERE eventID =" . $eventID; 				//Create the general select query.
 			$result = $db->query($query); 											
 			$row1 = $result->fetch_array(MYSQLI_BOTH);								//use it first for the title
 			$result->close();																//then close it ready for the next execution
 			$result = $db->query($query); 	
			
		
			echo '<br /><br />';
			
					echo '<table  id="tableEventDetail">';
							$on = 'this.src="../images/buttons/edit_dwn.png"';
			  				$off = 'this.src="../images/buttons/edit_up.png"';
					
							echo '<tr><td  colspan="2" id="headCell_left" > Event Details for : ' . $row1['event_name'].'</td>';
							
							echo '<td id="headCell_right">';
							echo '<img class="pointer" src="../images/buttons/edit_dwn.png" width="30" height="30"';
							echo 'alt="" onclick="editEvent(' . $row1['eventID'] . ')" ';
			  			echo 'onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
							
							
			
//While Loop starts here - 
// Retrieve the data for the table. There should only be one row.
			while($row = $result->fetch_array(MYSQLI_BOTH))							
			{
			  		echo '<tr><td id="titleCell">Event Location: </td><td id="detailCell">' . 		
			  					$row['event_location'] . 		'</td><td id ="pad">&nbsp;</td></tr>';
			  					
			  		echo '<tr><td id="titleCell">Event Start Time: </td><td id="detailCell">' .
			  					$row['startTime'] . 				'</td><td id ="pad"></td></tr>';
			  					
			  		echo '<tr><td id="titleCell">Number of Seats: </td><td id="detailCell">' . 
			  					$row['seatQuantity'] .			'</td><td id ="pad"></td></tr>';
			  					
			  		echo '<tr><td id="titleCell">Server IP Address: </td><td id="detailCell">' . 	
			  					$row['server_IP_address'] . 	'</td><td id ="pad"></td></tr>';
			
			// If the event has started place the stop event button in the table.
			if($row['event_started'] == 1) 
			  		{
			  			$on = 'this.src="../images/buttons/stop_dwn.png"';
			  			$off = 'this.src="../images/buttons/stop.png"';
			  			
			  			echo '<tr><td id="titleCell">Event Started: </td><td id="detailCell">Yes</td>
			  			<td id ="pad"><img src="../images/buttons/stop_dwn.png" class="pointer" width="30" height="30"'; 
			  			echo 'alt="" onclick="stopEvent(' . $row['eventID'] . ')" ';
			  			echo 'onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
			  		}
			 elseif ($row['event_started'] == 0)
			// If the event has not started place the start event button in the table. 
			  		{
			  			$on = 'this.src="../images/buttons/start_dwn.png"';
			  			$off = 'this.src="../images/buttons/start.png"';
			  			
			  			echo '<tr><td id="titleCell">Event Started: </td><td id="detailCell">No</td>';
			  			echo '<td id ="pad"><img src="../images/buttons/start_dwn.png" class="pointer"
			  			width="30" height="30" alt="" onclick="startEvent(' . $row['eventID'] . ')" 
			  			onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
			  		}
			 elseif ($row['event_started'] == 2)
			// If the event has completed or been stopped. 
			  		{
			  				
			  			echo '<tr><td id="titleCell">Event Started: </td><td id="detailCell">Finished</td>';
			  			echo '<td id ="pad"></td></tr>';
			  		} 	
			 
			 }
			//While Loop ends here.
			
			
			echo '</table>';

}

function ajax_event_table_edit($db, $eventID)
{
			
			$query = "SELECT * FROM event WHERE eventID =" . $eventID; 				//Create the general select query.
 			$result = $db->query($query); 											
 			$row1 = $result->fetch_array(MYSQLI_BOTH);								//use it first for the title
 			
 			$eName= $row1['event_name'];
 			$eLocation = $row1['event_location'];
 			$eStartTime = $row1['startTime'];
 			$eEventDate = $row1['startDate'];
 			$eServerIP = $row1['server_IP_address'];
 			$eSeatNum = $row1['seatQuantity'];
 			 	


echo '<br />';
echo '<form name="eventEdit" method="POST" onsubmit="updateEvent(this.form)" action="">';
						
echo' <table cellspacing="0" class="editTable" width="650">';
echo' <tr>';
	echo' <th class="headText" colspan=3>Event Details</th>';
echo' </tr>';
echo' <tr>';
	echo' <td class="labelText" >Event Name:</td>';
	echo'	<td class="detailPad"></td>';
	echo' <td class="detailText" ><input type="textarea" rows="4" cols="40" cellpadding ="10" id="event_name" name="event_name" value="' . $eName . ' "size="50" maxlength="100" /></td>';
echo' </tr>';
echo' <tr>';
	echo' <td class="labelText" >Event Location: </td>';
	echo'	<td class="detailPad"></td>';
	echo' <td class="detailText" ><input type="text" name="event_location" id="event_location" value="' . $eLocation . '" size="50" maxlength="100" /></td>';
echo' </tr>';
echo' <tr>';
	echo' <td class="labelText" >Event Date:</td>';
	echo'	<td class="detailPad"></td>';
	echo' <td class="detailText" ><input type="text" name="startDate" id="startDate" value="' . $eEventDate . '" size="50" maxlength="30" /></td>';
echo' </tr>';
echo' <tr>';
	echo' <td class="labelText" >Event Time:</td>';
	echo'	<td class="detailPad"></td>';
	echo' <td class="detailText" ><input type="text" name="startTime" id="startTime" value="' . $eStartTime . '" size="50" maxlength="30" /></td>';
echo' </tr>';
echo' <tr>';
	echo' <td class="labelText" >Server IP Address: </td>';
	echo'	<td class="detailPad"></td>';
	echo' <td class="detailText" ><input type="text" name="server_IP_address" id="server_IP_address" value="' .$eServerIP . '" size="50" maxlength="40" /></td>';
echo' </tr>';
echo' <tr>';
	echo' <td class="labelText" >Seat Quantity: </td>';
	echo'	<td class="detailPad"></td>';
	echo' <td class="detailText" ><input type="text" name="seatQuantity" id="seatQuantity" value="' .$eSeatNum . '" size="50" maxlength="2" /></td>';
echo' </tr>';
echo' <tr bgcolor="#3300CC">';	
	echo' <td align="right" height="40" colspan="3">';
			echo' <div align="right">';
						
			  			$on = 'this.src="../images/buttons/save_dwn.png"';
			  			$off = 'this.src="../images/buttons/save_up.png"';
			  			
			  			$cancelDwn = 'this.src="../images/buttons/delete_dwn.png"';
			  			$cancelUp = 'this.src="../images/buttons/delete_up.png"';
			  			
				echo '<img src="../images/buttons/save_dwn.png" width="30" height="30"';
				echo 'alt="" onclick="document.eventEdit.submit()"';
				echo 'onmouseover='.$off.' onmouseout='.$on.' />';
			  	
				echo' <img src="../images/buttons/delete_dwn.png" width="30" height="30"';
				echo' alt="" onclick="getEvent(' . $row1['eventID'] . ')" ';
			  	echo 'onmouseover='.$cancelUp.' onmouseout='.$cancelDwn.' />';
			echo' </div>';
	echo' </td>';
echo' </tr>';
echo'<input type="hidden" name="eventID" id="eventID" value="' .$row1['eventID'] . '"/>';



echo' </form>';

}



//Return back to the MANevent.php page.
?>


