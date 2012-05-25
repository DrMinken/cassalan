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
    
                                                        
    include("../includes/conn.php");                                            // Include the db connection
    
    $tournID = $_POST['tournID'];                                                // Retrieve the search value.    
    $queryType = $_POST['queryType'];                                        // Retrieve the query Identifier.
                                                                                    
    if($queryType == 0)
            {
                $query = "SELECT * FROM tournament WHERE tournID =" . $tournID;        //Create the general select query.
                ajax_tournament_table_basic($db, $tournID);
            }
   
function ajax_tournament_table_basic($db, $tournID)
{
            
            $query = "SELECT * FROM tournament WHERE tournID =" . $tournID;                 //Create the general select query.
             $result = $db->query($query);                                             
             $row1 = $result->fetch_array(MYSQLI_BOTH);                                //use it first for the title
             $result->close();                                                                //then close it ready for the next execution
             $result = $db->query($query);     
            
        
            echo '<br /><br />';
            
                    echo '<table  id="tableTournamentDetail">';
                           $on = 'this.src="../images/buttons/edit_dwn.png"';
                             $off = 'this.src="../images/buttons/edit_up.png"';
                    
                            echo '<tr><td  colspan="2" id="headCell_left" > Tournament Details for : ' . $row1['name'].'</td>';
                            
                            echo '<td id="headCell_right">';
                            echo '<img class="pointer" src="../images/buttons/edit_dwn.png" width="30" height="30"';
                            echo 'alt="" onclick="editTournament(' . $row1['tournID'] . ')" ';
                          echo 'onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
                            
                            
            
//While Loop starts here - 
// Retrieve the data for the table. There should only be one row.
            while($row = $result->fetch_array(MYSQLI_BOTH))                            
            {
                      echo '<tr><td id="titleCell">Tournament Date: </td><td id="detailCell">' .         
                                  $row['date'] .         '</td><td id ="pad">&nbsp;</td></tr>';
                                  
                      echo '<tr><td id="titleCell">Tournament Start Time: </td><td id="detailCell">' .
                                  $row['start_time'] .                 '</td><td id ="pad"></td></tr>';
                                  
                      echo '<tr><td id="titleCell">Tournament End Time: </td><td id="detailCell">' . 
                                  $row['end_time'] .            '</td><td id ="pad"></td></tr>';
                                  
                      echo '<tr><td id="titleCell">Tournament Winner: </td><td id="detailCell">' .     
                                  $row['winner'] .     '</td><td id ="pad"></td></tr>';
                                 
                                
            
            // If the event has started place the stop event button in the table.
            if($row['started'] == 1) 
                      {
                          $on = 'this.src="../images/buttons/stop_dwn.png"';
                          $off = 'this.src="../images/buttons/stop.png"';
                          
                          echo '<tr><td id="titleCell">Tournament Started: </td><td id="detailCell">Yes</td>
                          <td id ="pad"><img src="../images/buttons/stop_dwn.png" class="pointer" width="30" height="30"'; 
                          echo 'alt="" onclick="stopTournament(' . $row['tournID'] . ')" ';
                          echo 'onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
                      }
             elseif ($row['started'] == 0)
            // If the event has not started place the start event button in the table. 
                      {
                          $on = 'this.src="../images/buttons/start_dwn.png"';
                          $off = 'this.src="../images/buttons/start.png"';
                          
                          echo '<tr><td id="titleCell">Tournament Started: </td><td id="detailCell">No</td>';
                          echo '<td id ="pad"><img src="../images/buttons/start_dwn.png" class="pointer"
                          width="30" height="30" alt="" onclick="startTournament(' . $row['tournID'] . ')" 
                          onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
                      }
             elseif ($row['started'] == 2)
            // If the event has completed or been stopped. 
                      {
                          $on = 'this.src="../images/buttons/start_dwn.png"';
                          $off = 'this.src="../images/buttons/start.png"';
                          
                          echo '<tr><td id="titleCell">Tournament Started: </td><td id="detailCell">Finished</td>';
                          echo '<td id ="pad"></td></tr>';
                      }     
             
             }
            //While Loop ends here.
            
            
            echo '</table>';

}

//Return back to the MANevent.php page.



?>
  <html>
  
  <body>
  <ul>
    <li><a href = CreateTournament.php?> Manage Tournaments</a></li>
  </ul>
  </body>
  </html>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
 


   