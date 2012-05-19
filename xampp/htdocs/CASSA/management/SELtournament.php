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
   /* elseif ($queryType == 1)
            {
                
              //  $query = "UPDATE tournament "; 
               // $query.=    "SET event_started = 2 ";
               // $query.=    "WHERE event_started =1 ";
                
               // $query2  = "UPDATE event "; 
               // $query2 .=    "SET event_started = 1 ";
               // $query2 .=    "WHERE tournID =" . $tournID;
               // $result = $db->query($query);                    //Execute the first Query then.
                
                                                                                        
                 //$result = $db->query($query2);                //Then Execute the second Query then move on
                 ajax_tournament_table_basic($db, $tournID);
            }
 elseif ($queryType == 2)
            {
                
              //  $query2  = "UPDATE event "; 
               // $query2 .=    "SET event_started = 2 ";
               // $query2 .=    "WHERE tournID =" . $tournID;

                // $result = $db->query($query2);
                 ajax_tournament_table_basic($db, $tournID);                                                //Then Execute the Query then move on
                     
            }
elseif ($queryType == 3)
            {
                
                 ajax_tournament_table_edit($db, $tournID);                                                //Then Execute the Query then move on
                     
            } */                                               
                                                //re-execute the query to populate the table
     
//****************************************************************//Some HTML to format the table    
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

/*function ajax_tournament_table_edit($db, $tournID)
{
   
   */     /*    
            $query = "SELECT * FROM tournament WHERE tournID =" . $tournID;                 //Create the general select query.
             $result = $db->query($query);                                             
             $row1 = $result->fetch_array(MYSQLI_BOTH);                                //use it first for the title
                  

echo' <br />';
echo' <form name="tournamentEdit" method="POST" onsubmit="return eventValidate()" action="/CASSA/selectEvent.php">';
echo'    <div style="text-align: left">';
echo'    <table border="0" cellpadding="5" cellspacing="0" bordercolor="#000000" id="eventBox">';
echo' <tr bordercolor="#FFFFFF">';
echo'    <td height="42" colspan="2" bgcolor="#000000" ><div align="center">';
echo'    <span class="headText">Event Details </span></div>';
echo'    </td></tr><tr><td  width="200" height="34" valign="top" bgcolor="#000066"><div align="right">';
echo'    <span class="labelText">Event Name: </span></div></td>';
echo'    <td  width="326" bgcolor="#999999"><div align="right">';

echo'    <textarea name="eventName" cols="50">' . $row1['event_name'] . '</textarea></div></td>';
echo' </tr><tr><td  width="200" height="33" bgcolor="#000066"><div align="right"><span class="labelText">Event Location: </span>
          </div></td><td bgcolor="#999999"><div align="left"><input name="eventLocation" 
                  type="text" size="50" maxlength="64" value="' .$row1['event_location'] .'" ></div></td>';
echo'</tr><tr><td  width="200" height="33" bgcolor="#000066"><div align="right"><span class="labelText">Event Date: </span>
          </div></td><td bgcolor="#999999"><div align="left">'; 

echo'<input name="eventDate" type="text" size="30" maxlength="12" value="' . $row1['startDate'] .'">';

echo '</div></td></tr><tr><td  width="200" height="32" bgcolor="#000066"><div align="right"><span class="labelText">Event Start Time</span>: 
                    </span></div></td><td bgcolor="#999999"><div align="left">';
                    
echo'<input name="startTime" type="text" size="30" maxlength="12"value="' . $row1['startTime'] . '"></div></td>';

echo'</tr><tr><td  width="200" height="30" bgcolor="#000066"><div align="right"><span class="labelText">Server IP Address: 
                  </span></div></td><td bgcolor="#999999"><div align="left">';
                  
echo'<input name="serverIPaddress" type="text" size="30" maxlength="15" value="'. $row1['server_IP_address']. '">';
echo'</div></td></tr><tr><td  width="200" height="35" bgcolor="#000066"><div align="right">
                <span class="labelText">Number of Seats: </span></div></td><td bgcolor="#999999">';
                
echo'<div align="left">';
echo'<input name="numberOFseats" type="text" size="20" maxlength="2" value="'. $row1['seatQuantity']. '">';
                    
echo'</div></td></tr>';
        
echo'<tr bgcolor="#333333">    <td height="38" colspan="2"><div align="right">
                <img src="../images/buttons/edit_dwn.png" width="30" height="30">';
echo'<img src="../images/buttons/delete_dwn.png" width="30" height="30">';
echo'</div></td>';
echo'</tr>';

        
echo'</table>';
echo'</div>';
echo'</form>';  */

//} 

//Return back to the MANevent.php page.



?>
  <html>
  
  <body>
  <ul>
  <li><a href = CreateTournament.php?> Creat New Tournament</a></li>
   <li><a href = Edit_Delete_Tournament.php?> Edit Tournament</a></li>
    <li><a href = Edit_Delete_Tournament.php?> Delete Tournament</a></li>
  </ul>
  </body>
  </html>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
 


   