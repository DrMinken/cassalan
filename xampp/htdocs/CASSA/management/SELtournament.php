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
//********** Start of select event script **************-->                     <!-- //******************************************************

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
    
    $tourntID = $_POST['tournID'];                                                // Retrieve the search value.    
    $queryType = $_POST['queryType'];
                                         // Retrieve the query Identifier.
                                                                                    
    if($queryType == 0)
            {
                $query = "SELECT * FROM tournament WHERE tournID =" . $tourntID;        //Create the general select query.
                ajax_tournament_table_basic($db, $tourntID);
            }
      
function ajax_tournament_table_basic($db, $tournID)
{
            
            $query = "SELECT * FROM tournament WHERE tournID =" . $tournID;                 //Create the general select query.
             $result = $db->query($query);                                             
             $row1 = $result->fetch_array(MYSQLI_BOTH);                                //use it first for the title
             $result->close();                                                                //then close it ready for the next execution
             $result = $db->query($query);     
            
        
           // echo '<br /><br />';
            echo '<table  id="tableTournamentDetail">';
            $on = 'this.src="../images/buttons/edit_dwn.png"';
            $off = 'this.src="../images/buttons/edit_up.png"';
            echo '<tr><td  id="headCell_left" > Tournament Details for : ' . $row1['name'].'</td>';
            echo '<td id="headCell_right">';
            echo '<img class="pointer" src="../images/buttons/edit_dwn.png" width="30" height="30"';
            echo 'alt="" onclick="editEvent(' . $row1['tournID'] . ')" ';
          echo 'onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
            
                            
            
//While Loop starts here - 
// Retrieve the data for the table. There should only be one row.
       while($row = $result->fetch_array(MYSQLI_BOTH))                            
        { 
            $date = $row['date'];
            $start_time = $row['start_time'];
            $end_time = $row['end_time'];
         
            echo "
            Tournament Date: $date <br>
            Start time: $start_time<br> 
            End Time $end_time  <br>
            ";
        }
       //While Loop ends here.
         echo '</table>';

}





                                     
?>

 