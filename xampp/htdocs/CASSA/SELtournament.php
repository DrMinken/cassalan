<!-- //******************************************************

// Name of File: SELtournament.php
// Revision: 1.0
// Date: 08/05/2012
// Author: Tinashe Masvaure
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

<?php 

    include("includes/conn.php");                                                // Include the db connection    
    $eventID = $_POST['tournID'];                                                // Retrieve the search value.
    $query = "SELECT * FROM event WHERE tournID =" . $tournID;         //Create the query
     $result = $db->query($query);                                             //and execute it.
     $row1 = $result->fetch_array(MYSQLI_BOTH);                            //use it first for the title
     $result->close();                                                                //then close it ready for the next execution
     $result = $db->query($query);                                             //re-execute the query to populate the table
     
//****************************************************************//Some HTML to format the table    
echo '<br /><br />';
        echo '<table id="tournamentDetail">';
                echo '<tr><td  id="headCell_left" > Tournament Details for : ' . $row1['name'].'</td><td id="headCell_middle" ></td><td id="headCell_right">
                        <img  src="images/buttons/edit_LSM.png" width="30" height="30" alt="" />
                        <img src="images/buttons/save.png" width="30" height="30" alt="" /><td></tr>';

//While Loop starts here - 
// Retrieve the data for the table. There should only be one row.
while($row = $result->fetch_array(MYSQLI_BOTH))                            
{
          echo '<tr><td id="titleCell">Tournament Date: </td><td id="detailCell">' .         $row['date'] .         '</td><td id ="pad"></td></tr>';
              echo '<tr><td id="titleCell">Tournament Start Time: </td><td id="detailCell">' .     $row['start_time'] .                 '</td><td id ="pad"></td></tr>';
              echo '<tr><td id="titleCell">Tournament End Time: </td><td id="detailCell">' .         $row['end_time'] .            '</td><td id ="pad"></td></tr>';
        //  echo '<tr><td id="titleCell">Server IP Address: </td><td id="detailCell">' .     $row['server_IP_address'] .     '</td><td id ="pad"></td></tr>';

// If the event has started place the stop event button in the table.
if($row['started'] == 1) 
          {
              echo '<tr><td id="titleCell">Tournament Started: </td><td id="detailCell">Yes</td>
              <td id ="pad"><img src="images/buttons/stop.png" width="30" height="30" alt="" onclick="stopEvent(' . $row['eventID'] . ')"/></td></tr>';
          }
 else 
// If the event has not started place the start event button in the table. 
          {
              echo '<tr><td id="titleCell">Tournament Started: </td><td id="detailCell">No</td><td id ="pad"><img src="images/buttons/start.png" 
                      
              width="30" height="30" alt="" onclick="startTournament(' . $row['tournID'] . ')" /></td></tr>';
          }
 }
//While Loop ends here.


echo '</table>';






//Return back to the MANevent.php page.
?>