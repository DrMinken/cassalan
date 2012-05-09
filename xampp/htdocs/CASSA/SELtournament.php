<!-- //******************************************************

// Name of File: selectEvent.php
// Revision: 1.0
// Date: 07/05/2012
// Author: Lyndon Smith
// Modified: Tinashe Masvaure 

//***********************************************************
//This script works in conjuction with the MANtournament.php script.
//it acts as partner script and provides the details of the event
//selected in the list box. It returns the data in an AJAX connection.
//
//It uses $_POST in this instance rather than $_GET as there is
//a need for security. It returns a non-editable
//HTML table.
//********** Start of select event script **************-->

<!--*******************************************************-->
<?php 

    // PAGE SECURITY
 //   if (!isset($_SESSION['isAdmin']))
   // {
     //   if ($_SESSION['isAdmin'] == 0)
       // {
         //   echo '<script type="text/javascript">history.back()</script>';
           // die();
        //}
    //}    
    
    include("./includes/conn.php");                                                // Include the db connection    


    $tournID = $_POST['tournID'];                                                // Retrieve the search value.    
    $queryType = $_POST['queryType'];
                                            // Retrieve the query Identifier.                                        
    if($queryType == 0)
            {
                $query = "SELECT * FROM tournament WHERE tournID =" . $tournID;         //Create the general select query.
            }
    
    //if ( ($queryType == 1)
      //       {
        //        $query = "SELECT * FROM tournament WHERE tournID =" . $tournID;
          //   }
 
    $tournID = $_POST['tournID'];                                                // Retrieve the search value.
    $query = "SELECT * FROM tournament WHERE tournID =" . $tournID;         //Create the query

     $result = $db->query($query);                                             //and execute it.
     $row1 = $result->fetch_array(MYSQLI_BOTH);                            //use it first for the title
     $result =$db->close();                                                                //then close it ready for the next execution
     $result = $db->query($query);                                             //re-execute the query to populate the table
     
//****************************************************************//Some HTML to format the table    
echo '<br /><br />';

        echo '<table  id="tableTournamentDetail">';

        
                echo '<tr><td  id="headCell_left" > Tournament Details for : ' . $row1['event_name'].'</td>';
                echo '<td id="headCell_middle"></td>';
                echo '<td id="headCell_right">';
                echo '<img class="pointer" src="../images/buttons/edit_LSM.png" width="30" height="30" alt="" />';
                echo '<img class="pointer" src="./images/buttons/save.png" width="30" height="30" alt="" /><td></tr>';

//While Loop starts here - 
// Retrieve the data for the table. There should only be one row.
while($row = $result->fetch_array(MYSQLI_BOTH))                            
{
          echo '<tr><td id="titleCell">Tournament Date: </td><td id="detailCell">' .         $row['date'] .         '</td><td id ="pad">&nbsp;</td></tr>';
              echo '<tr><td id="titleCell">Tournament Start Time: </td><td id="detailCell">' .     $row['start_time'] .                 '</td><td id ="pad"></td></tr>';
              echo '<tr><td id="titleCell">Tournament End Time: </td><td id="detailCell">' .         $row['end_time'] .            '</td><td id ="pad"></td></tr>';
        //  echo '<tr><td id="titleCell">Server IP Address: </td><td id="detailCell">' .     $row['server_IP_address'] .     '</td><td id ="pad"></td></tr>';

// If the event has started place the stop event button in the table.
if($row['started'] == 1) 
          {
              $on = 'this.src="./images/buttons/stop_dwn.png"';
              $off = 'this.src="./images/buttons/stop.png"';
              
              echo '<tr><td id="titleCell">Tournament Started: </td><td id="detailCell">Yes</td>
              <td id ="pad"><img src="./images/buttons/stop_dwn.png" class="pointer" width="30" height="30"'; 
              echo 'alt="" onclick="stopEvent(' . $row['tournID'] . ')" ';
              echo 'onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
          }
 else 
// If the event has not started place the start event button in the table. 
          {
              $on = 'this.src="./images/buttons/start_dwn.png"';
              $off = 'this.src="./images/buttons/start.png"';
              
              echo '<tr><td id="titleCell">Tournament Started: </td><td id="detailCell">No</td>';
              echo '<td id ="pad"><img src="./images/buttons/start_dwn.png" class="pointer"
              width="30" height="30" alt="" onclick="startTournament(' . $row['tournID'] . ')" 
              onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
          }
 }
//While Loop ends here.


echo '</table>';






//Return back to the MANevent.php page.
?>