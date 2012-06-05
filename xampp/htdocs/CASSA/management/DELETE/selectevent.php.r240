<!-- //******************************************************

// Name of File: selectEvent.php
// Revision: 1.0
// Date: 30/04/2012
// Author: Lyndon Smith
// Modified: 

//***********************************************************
//This script works in conjuction with the MANevent.php script.
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
	
    // SECURE AND ASSIGN POST VARIABLES 
  // TRIM all posted values
  $_POST = array_map('trim', $_POST);
  
  // REJECT all real escape strings (security)
  $_POST = array_map('mysql_real_escape_string', $_POST);

     
        $eventID = $_POST['eventID'];												// Retrieve the search value.	
	$queryType = $_POST['queryType'];
        //$_SESSION['errMsg'] = "";
        
//Start checking what action is required and what shall be placed into the div in
// the man event page.
        
if($queryType == 0)
            {
                $_SESSION['errMsg'] = "";
                $query = "SELECT * FROM event WHERE eventID =" . $eventID . ";";		//Create the general select query.
                ajax_event_table_basic($db, $eventID);
            }
//If querytype = 1 then change the event to started and stop all other
//events.           
   elseif ($queryType == 1)
    {
        $_SESSION['errMsg'] = "";
        $query =    "UPDATE event "; 
        $query.=    "SET event_started = 2 ";
        $query.=    "WHERE event_started =1 ";

        $query2  =  "UPDATE event "; 
        $query2 .=  "SET event_started = 1 ";
        $query2 .=  "WHERE eventID =" . $eventID;
        $result = $db->query($query);					//Execute the first Query then.

        $result = $db->query($query2);                                  //Then Execute the second Query then move on
        ajax_event_table_basic($db, $eventID);
    }
//If querytype = 2 then change the event to finished
  
    
    elseif ($queryType == 2)
    {
        $_SESSION['errMsg'] = "";
        $query2  = "UPDATE event "; 
        $query2 .=	"SET event_started = 2 ";
        $query2 .=	"WHERE eventID =" . $eventID;

        $result = $db->query($query2);
        ajax_event_table_basic($db, $eventID);												//Then Execute the Query then move on

    }
//If querytype = 3 then display the current record in the edit form.
    elseif ($queryType == 3)
    {
      
        ajax_event_table_edit($db, $eventID);												

    }												
//If querytype = 4 then validate changes and save form data.
//When done return to event page and display static table.
elseif ($queryType == 4)
    {
        
        $event_location = $_POST['event_location'];
        $event_name = $_POST['event_name'];
        $startDate = $_POST['startDate'];
        $startTime = $_POST['startTime'];
        $server_IP_address = $_POST['server_IP_address'];
        $seatQuantity = $_POST['seatQuantity'];
    
        
        $postData = array($event_location, $event_name, 
                                $startDate, $startTime, $seatQuantity, $server_IP_address);
        
        $postNames = array("Event Location", "Event Name", 
                                    "Start Date", "Start Time", "Number of Seats", "Server IP Address");
        
        ajax_event_table_save($db, $eventID, $postData, $postNames);												

    }					
elseif ($queryType == 5)
    {
        
        ajax_event_table_Add($db);												

    }    
 	
 elseif ($queryType == 6)
    {
        
       
        $event_location = $_POST['event_location'];
        $event_name = $_POST['event_name'];
        $startDate = $_POST['startDate'];
        $startTime = $_POST['startTime'];
        $server_IP_address = $_POST['server_IP_address'];
        $seatQuantity = $_POST['seatQuantity'];
     $postData = array($event_location, $event_name, 
                                $startDate, $startTime, $seatQuantity, $server_IP_address);
        
        $postNames = array("Event Location", "Event Name", 
                                    "Start Date", "Start Time", "Number of Seats", "Server IP Address");
        
        											
        ajax_event_table_AddNew ($db, $eventID, $postData, $postNames);
    } 
  elseif ($queryType == 7)
     
    {
      $_SESSION['errMsg'] = ""; 
      $query1 = "SELECT * FROM event Where eventID =" . $eventID . ";";
       $result = $db->query($query1);
       $row = $result->fetch_array(MYSQLI_BOTH);
         if($row['event_started']== 1)

         {
             $_SESSION['errMsg'] = "An event that is running cannot be deleted";
             ajax_event_table_basic($db, $eventID);
         }

         else
             {
                    $db->autocommit(TRUE);
                    $query2  = "DELETE from event "; 
                    $query2 .=	"WHERE eventID =" . $eventID . ";";
                    $result = $db->query($query2);

                    $query2 = "SELECT * from event order by eventID DESC";
                    $result = $db->query($query2);
                    $row = $result->fetch_array(MYSQLI_BOTH);
                    $eventID = $row['eventID'];
                    ajax_event_table_basic($db, $eventID);												//Then Execute the Query then move on
             }   
    }	
 	
//********************* Functions Below *************************************************
//
//
//
//***************************************************************************************
//Function to update record in event table
//***************************************************************************************
    
function ajax_event_table_save($db, $eventID, $postData, $postNames) 
 {
        
        $_SESSION['errMsg'] = "";
        $errCount = 0;
        
//Validate the fields - first check to see if they are empty
       
    for($i = 0; $i < sizeof($postData); ++$i)
        {
            if ($postData[$i] == '')
                {
                    $_SESSION['errMsg'] .= $postNames[$i] . ' is empty.' . '<br />';
                    $errCount ++;
                }      
        }
     if (chkDate($postData[2]) == false)
            {
                $_SESSION['errMsg'] .= 'Date format is not valid' . '<br />';
                $errCount ++; 
            }
     if (validateIpAddress($postData[5])== false)
            {
              $_SESSION['errMsg'] .= 'Server I.P Address is not valid' . '<br />';
                $errCount ++;  
            }
     if (check_time_format($postData[3])== false)
            {
              $_SESSION['errMsg'] .= 'Start Time is not Valid' . '<br />';
                $errCount ++;
            }
     if (!is_numeric($postData[4]))
     {
         $_SESSION['errMsg'] .= 'Seat Quantity Should be a number' . '<br />';
                $errCount ++;
     }
     
    if ($errCount > 0)
         
            {
                 $errCount = 0;
                 ajax_event_table_edit($db, $eventID);
            }
     elseif($errCount <= 0)
         {
            
            $event_location = $_POST['event_location'];
            $event_name = $_POST['event_name'];
            $startDate = $_POST['startDate'];
            $startTime = $_POST['startTime'];
            $server_IP_address = $_POST['server_IP_address'];
            $seatQuantity = $_POST['seatQuantity'];
         


            $query  =  "UPDATE event "; 
            $query .=  "SET event_location ='" . $event_location;
            $query .= "', event_name ='" . $event_name;
            $query .= "', startTime ='" . $startTime ;
            $query .= "', seatQuantity ='" . $seatQuantity;
            $query .= "', server_IP_Address='" . $server_IP_address;
            $query .= "', startDate='" . $startDate;
            $query .= "' WHERE eventID=".$eventID;
          
           $db->autocommit(FALSE); 
            $db->query($query);
            
            if($db->error)
               { 
                    
                   $_SESSION['errMsg'] .= 'Transaction aborted:<br/>';
                   printf("Error Message:", $db->error);
                   $db->rollback();

                    ajax_event_table_edit($db, $eventID);
                }
                             
            else
                {  
                        
                        
                        $db->commit();
                        
                        $db->autocommit(TRUE);
                                            
                        ajax_event_table_basic($db, $eventID);
                            
                } 
        
         }
 }


//************************************************************************************
//Function to add new record to event table  
//**************************************************************************************   
function ajax_event_table_AddNew ($db, $eventID, $postData, $postNames) 
 {
        
        $_SESSION['errMsg'] = "";
        $errCount = 0;
        
                


//Validate the fields - first check to see if they are empty
       
    for($i = 0; $i < sizeof($postData); ++$i)
        {
            if ($postData[$i] == '')
                {
                    $_SESSION['errMsg'] .= $postNames[$i] . ' is empty.' . '<br />';
                    $errCount ++;
                }      
        }
     
      //Check if event exists -
      if(!$postData[1]=='')
      {
            $query = "SELECT * FROM event WHERE event_name='" . $postData[1]. "'";
            
            $result = $db->query($query);
            $count = $result->num_rows;
     
        if ($count > 0)
                  
            {
                $_SESSION['errMsg'] .= 'Event Name Exists, Please choose another' . '<br />';
                $errCount ++;
            }  
        }
        
     if (chkDate($postData[2]) == false)
            {
                $_SESSION['errMsg'] .= 'Date format is not valid' . '<br />';
                $errCount ++; 
            }
     if (validateIpAddress($postData[5])== false)
            {
              $_SESSION['errMsg'] .= 'Server I.P Address is not valid' . '<br />';
                $errCount ++;  
            }
     if (check_time_format($postData[3])== false)
            {
              $_SESSION['errMsg'] .= 'Start Time is not Valid' . '<br />';
                $errCount ++;
            }
     if (!is_numeric($postData[4]))
     {
         $_SESSION['errMsg'] .= 'Seat Quantity Should be a number' . '<br />';
                $errCount ++;
     }
     
    
     if ($errCount > 0)
         
            {
                 $errCount = 0;
                 ajax_event_table_Add($db);
            }
     elseif($errCount <= 0)
         {
            
            $event_location = $_POST['event_location'];
            $event_name = $_POST['event_name'];
            $startDate = $_POST['startDate'];
            $startTime = $_POST['startTime'];
            $server_IP_address = $_POST['server_IP_address'];
            $seatQuantity = $_POST['seatQuantity'];
  
//INSERT INTO `cassa_lan`.`event` (`eventID`, `event_name`, `event_location`, `startDate`, `startTime`, `seatQuantity`, `server_IP_address`, `event_started`, `event_completed`)
//VALUES (NULL,'Cassa Royal 3','Joondalup','2012-05-12', '09:00:00',56,'192.168.1.45',0,0);
            
            
            
  $query = "INSERT INTO `cassa_lan`.`event` (`eventID`, `event_name`, `event_location`, `startDate`, `startTime`, `seatQuantity`, `server_IP_address`, `event_started`, `event_completed`)"; 
   $query .= "VALUES (NULL,'$event_name','$event_location','$startDate',";
   $query .= "'$startTime',$seatQuantity,'$server_IP_address',0,0);";      

            $db->autocommit(FALSE); 
            $db->query($query);
            
            if($db->error)
               { 
                    
                   $_SESSION['errMsg'] .= 'Transaction aborted:<br/>';
                   printf("Error Message:", $db->error);
                   
                   $db->rollback();

                    ajax_event_table_Add($db);
                }
                             
            else{  
                        
                        mysqli_commit($db);
                        $db->autocommit(TRUE);
                        $query = "SELECT * FROM event WHERE event_name='" . $_POST['event_name'] . "';";
                        $result = $db->query($query);
                       
                        $row = $result->fetch_array(MYSQLI_BOTH);
                        $eventID = $row['eventID'];      
                        ajax_event_table_basic($db,$eventID);
                            
                } 
        
         }
 }

//*************************************************************************************
//Check if time field is correct
//**************************************************************************************
function check_time_format($time) 
  {     $valid = false;     
        if (preg_match('/(\d\d):(\d\d):(\d\d)/', $time))     
            {         
                $valid = true;     
                
             }       
             return $valid; 
             
  } 

//*************************************************************************************
//Validate IP address
//************************************************************************************
function validateIpAddress($ip_addr)
{
    if(filter_var($ip_addr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === FALSE) // displays IP is not valid

        {

            return false;;

        }

    else

        {

            return true;

        }
}

//*************************************************************************************
// Check date is ok
//*************************************************************************************
 function chkDate($date)
  {
    $converted=str_replace('/','-',$date);

    if(preg_match("/^((((19|20)(([02468][048])|([13579][26]))-02-29))|((20[0-9][0-9])|(19[0-9][0-9]))-((((0[1-9])|
(1[0-2]))-((0[1-9])|(1\d)|(2[0-8])))|((((0[13578])|(1[02]))-31)|(((0[1,3-9])|
(1[0-2]))-(29|30)))))$/",$converted)===1)
    {
      return TRUE;
    }

    return FALSE;
  } 
//****************************************************************************************
// Sets up basic table for viewing records.
//****************************************************************************************
    
function ajax_event_table_basic($db, $eventID)
{
			
    $query = "SELECT * FROM event WHERE eventID =" . $eventID; 		//Create the general select query.
    $result = $db->query($query); 											
    $row1 = $result->fetch_array(MYSQLI_BOTH);		//use it first for the title
    $result->close();					//then close it ready for the next execution
    $result = $db->query($query); 	

    if(isset($_SESSION['errMsg']));
    {
       echo "<br /><p class='redAstrix'>" . $_SESSION['errMsg'] . "</p>";
    }
    echo '<br /><br />';

    echo '<table  id="tableEventDetail">';
    $on = 'this.src="../images/buttons/edit_dwn.png"';
    $off = 'this.src="../images/buttons/edit_up.png"';

    echo '<tr><td  colspan="2" id="headCell_left" > Event Details for : ' . $row1['event_name'].'</td>';

    echo '<td id="headCell_right">';
    echo '<img class="pointer" src="../images/buttons/edit_dwn.png" width="30" height="30"';
    echo 'alt="Edit The Selected Event" onclick="editEvent(' . $row1['eventID'] . ')" ';
    echo 'onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
							
							
			
//While Loop starts here - 
// Retrieve the data for the table. There should only be one row.
        while($row = $result->fetch_array(MYSQLI_BOTH))							
        {
            echo '<tr><td id="titleCell">Event Location: </td><td id="detailCell">' . 		
                                    $row['event_location'] . '</td><td id ="pad">&nbsp;</td></tr>';

            echo '<tr><td id="titleCell">Event Start Time: </td><td id="detailCell">' .
                                    $row['startTime'] . '</td><td id ="pad"></td></tr>';

            echo '<tr><td id="titleCell">Event Start Date: </td><td id="detailCell">' .
                                    $row['startDate'] . '</td><td id ="pad"></td></tr>';
            
            echo '<tr><td id="titleCell">Number of Seats: </td><td id="detailCell">' . 
                                    $row['seatQuantity'] .'</td><td id ="pad"></td></tr>';

            echo '<tr><td id="titleCell">Server IP Address: </td><td id="detailCell">' . 	
                                    $row['server_IP_address'] .'</td><td id ="pad"></td></tr>';

// If the event has started place the stop event button in the table.
if($row['event_started'] == 1) 
        {
        $on = 'this.src="../images/buttons/stop_dwn.png"';
        $off = 'this.src="../images/buttons/stop.png"';

        echo '<tr><td id="titleCell">Event Started: </td><td id="detailCell">Yes</td>';
        echo '<td id ="pad"><img src="../images/buttons/stop_dwn.png" class="pointer" width="30" height="30"'; 
        echo 'alt="Stop the current event." onclick="stopEvent(' . $row['eventID'] . ')" ';
        echo 'onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
        }
elseif ($row['event_started'] == 0)
// If the event has not started place the start event button in the table. 
    {
        $on = 'this.src="../images/buttons/start_dwn.png"';
        $off = 'this.src="../images/buttons/start.png"';

        echo '<tr><td id="titleCell">Event Started: </td><td id="detailCell">No</td>';
        echo '<td id ="pad"><img src="../images/buttons/start_dwn.png" class="pointer"';
        echo 'width="30" height="30" alt="Start the selected event. Stops all others." onclick="startEvent(' . $row['eventID'] . ')"'; 
        echo 'onmouseover='.$off.' onmouseout='.$on.' /></td></tr>';
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
//****************************************************************************************
// Sets up edit table for editing records.
//****************************************************************************************
function ajax_event_table_edit($db, $eventID)
{
    if(!isset($_SESSION['errMsg']))
    {
        $query = "SELECT * FROM event WHERE eventID =" . $eventID; //Create the general select query.
        $result = $db->query($query); 											
        $row1 = $result->fetch_array(MYSQLI_BOTH);                  //use it first for the title
           
        $eName= $row1['event_name'];
        $eLocation = $row1['event_location'];
        $eStartTime = $row1['startTime'];
        $eEventDate = $row1['startDate'];
        $eServerIP = $row1['server_IP_address'];
        $eSeatNum = $row1['seatQuantity'];
    }
 			 	

    if(isset($_SESSION['errMsg']))
        {
            echo "<br /><p class='redAstrix'>" . $_SESSION['errMsg'] . "</p>";
            $eName= $_POST['event_name'];
            $eLocation = $_POST['event_location'];
            $eStartTime = $_POST['startTime'];
            $eEventDate = $_POST['startDate'];
            $eServerIP = $_POST['server_IP_address'];
            $eSeatNum = $_POST['seatQuantity'];
            $eventID = $_POST['eventID'];
        }
        echo '<br />';
        echo '<form  name="eventEdit">';
        echo' <table cellspacing="0" class="editTable" width="650">';
        echo' <tr>';
        echo' <th class="headText" colspan=3>Event Details</th>';
        echo' </tr>';
        echo' <tr>';
        echo' <td class="labelText" >Event Name:</td>';
        echo' <td class="detailPad"></td>';
        echo' <td class="detailText" ><input type="textarea" rows="4" cols="40" cellpadding ="10" id="event_name" name="event_name" value="' . $eName . ' "size="50" maxlength="100" /></td>';
        echo' </tr>';
        echo' <tr>';
	echo' <td class="labelText" >Event Location: </td>';
	echo' <td class="detailPad"></td>';
	echo' <td class="detailText" ><input type="text" name="event_location" id="event_location" value="' . $eLocation		. '" size="50" maxlength="100" /></td>';
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
			  			
        echo ' <img src="../images/buttons/save_dwn.png" width="30" height="30"';
        echo ' alt="Update the current event" onclick="updateEvent()" ';
        //
        echo 'onmouseover='.$off.' onmouseout='.$on.' />';

        echo' <img src="../images/buttons/delete_dwn.png" width="30" height="30"';
        echo' alt="Cancel Current Update" onclick="getEvent(' . $eventID . ')" ';
        echo 'onmouseover='.$cancelUp.' onmouseout='.$cancelDwn.' />';
        echo' </div>';
	echo' </td>';
        echo' </tr>';
        echo'<input type="hidden" name="eventID" id="eventID" value="' . $eventID . '"/>';
        echo' </form>';

}


//****************************************************************************************
// Sets up table for adding records.
//****************************************************************************************
function ajax_event_table_Add($db)
{
        
    if(isset($_SESSION['errMsg']))
        {
            echo "<br /><p class='redAstrix'>" . $_SESSION['errMsg'] . "</p>";
            $eName= $_POST['event_name'];
            $eLocation = $_POST['event_location'];
            $eStartTime = $_POST['startTime'];
            $eEventDate = $_POST['startDate'];
            $eServerIP = $_POST['server_IP_address'];
            $eSeatNum = $_POST['seatQuantity'];
        }
        
         else
        {
            
            $eName= "";
            $eLocation = "";
            $eStartTime = "";
            $eEventDate = "";
            $eServerIP = "";
            $eSeatNum = "";
        }
        echo '<br />';
        echo '<form  name="eventADD">';
        echo' <table cellspacing="0" class="editTable" width="650">';
        echo' <tr>';
        echo' <th class="headText" colspan=3>Event Details</th>';
        echo' </tr>';
        echo' <tr>';
        echo' <td class="labelText" >Event Name:</td>';
        echo' <td class="detailPad"></td>';
        echo' <td class="detailText" ><input type="textarea" rows="4" cols="40" cellpadding ="10" id="event_name" name="event_name" value="' . $eName . ' "size="50" maxlength="100" /></td>';
        echo' </tr>';
        echo' <tr>';
	echo' <td class="labelText" >Event Location: </td>';
	echo' <td class="detailPad"></td>';
	echo' <td class="detailText" ><input type="text" name="event_location" id="event_location" value="' . $eLocation		. '" size="50" maxlength="100" /></td>';
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
			  			
        echo ' <img src="../images/buttons/save_dwn.png" width="30" height="30"';
        echo ' alt="Save the current Event" onclick= "checkaddEvent()" ';
        //
        echo 'onmouseover='.$off.' onmouseout='.$on.' />';

        echo' <img src="../images/buttons/delete_dwn.png" width="30" height="30"';
        echo' alt="Cancel Current Update" onclick="getEvent()" ';
        echo 'onmouseover='.$cancelUp.' onmouseout='.$cancelDwn.' />';
        echo' </div>';
	echo' </td>';
        echo' </tr>';
        //echo'<input type="hidden" name="eventID" id="eventID" value="' .$row1['eventID'] . '"/>';
        echo' </form>';
        

}


//Return back to the MANevent.php page.
?>