<!-- //******************************************************

// Name of File: MANtournament.php
// Revision: 1.0
// Date: 28/05/2012
// Author: Tinashe Masvaure
// Modified: 

//***********************************************************

//********** Start PAGE ************** -->

<?php 
    
                                                        
    include("../includes/conn.php");                                            // Include the db connection
    
    $tournID = $_POST['tournID'];                                                // Retrieve the search value.    
    $queryType = $_POST['queryType'];                                        // Retrieve the query Identifier.
                                                                                    
    if($queryType == 0)
            {
            
                $query = "SELECT * FROM tournament WHERE eventID =" . $tournID;        //Create the general select query.
                ajax_tournament_table_basic($db, $tournID);
            }
               
function ajax_tournament_table_basic($db, $tournID)
{
    
             $query = "SELECT * FROM event WHERE eventID =" . $tournID;                 //Create the general select query.
             $result = $db->query($query);                                             
             $row1 = $result->fetch_array(MYSQLI_BOTH);                                //use it first for the title
             $result->close();                                                                //then close it ready for the next execution
             $result = $db->query($query);     
            
             echo '<br /><br />';
            echo '<table  id="tableTournamentDetail">';
             $on = 'this.src="../images/buttons/edit_dwn.png"';
             $off = 'this.src="../images/buttons/edit_up.png"';
            echo '<tr><td  colspan="2" id="headCell_left" > Event Details for CASSALAN</td>';
            echo '<td id="headCell_right">';
            echo '<img class="pointer" src="../images/buttons/edit_dwn.png" width="30" height="30"';
            echo 'alt="" onclick="editTournament(' . $row1['eventID'] . ')" ';
              echo 'onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
                                       
//While Loop starts here - 
// Retrieve the data for the table. There should only be one row.
            while($row = $result->fetch_array(MYSQLI_BOTH))                            
            {
                      echo '<tr><td id="titleCell">Event Start Time: </td><td id="detailCell">' .         
                      $row['startTime'] .'</td><td id ="pad">&nbsp;</td></tr>';                                                                                      
                      echo '<tr><td id="titleCell">Sever IP: </td><td id="detailCell">' .     
                      $row['server_IP_address'] .     '</td><td id ="pad"></td></tr>';
         
             }
    
            $query = "SELECT * FROM tournament WHERE eventID =" . $tournID;                 //Create the general select query.
             $result = $db->query($query);                                             
             $row1 = $result->fetch_array(MYSQLI_BOTH);                                //use it first for the title
             $result->close();                                                                //then close it ready for the next execution
             $result = $db->query($query);     
    
            echo '<br /><br />';
            echo '<table  id="tableTournamentDetail">';
            $on = 'this.src="../images/buttons/edit_dwn.png"';
             $off = 'this.src="../images/buttons/edit_up.png"';
             echo '<tr><td  colspan="2" id="headCell_left" > Tournaments Started for CASSALAN</td>';
             echo '<td id="headCell_right">';
             echo '<img class="pointer" src="../images/buttons/edit_dwn.png" width="30" height="30"';
             echo 'alt="" onclick="editTournament(' . $row1['tournID'] . ')" ';
             echo 'onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
                            
                            
            
//While Loop starts here - 
// Retrieve the data for the table. There should only be one row.
            while($row = $result->fetch_array(MYSQLI_BOTH))                            
            {
                      echo '<tr><td id="titleCell">Tournament Name: </td><td id="detailCell">' .         
                      $row['name'] .         '</td><td id ="pad">&nbsp;</td></tr>';                                                                                   
                      echo '<tr><td id="titleCell">Tournament Winner: </td><td id="detailCell">' .     
                      $row['winner'] .     '</td><td id ="pad"></td></tr>';                                                                                   
             }
            //While Loop ends here.
            
}
            echo '</table>';
//Return back to the MANevent.php page.

?>
  <html>
  
  <body>
  </body>
  </html>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
 


   