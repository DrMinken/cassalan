<!-- //******************************************************

// Name of File: selectclient.php
// Revision: 1.0
// Date: 24/5/12
// Author: Lyndon Smith
// Modified: 

//***********************************************************
//This script works in conjuction with the MANclient.php script.
//it acts as partner script and provides the details of the client
//selected . It returns the data in an AJAX connection.
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

        $clientID= 0;
        $active = 0;
        $clientID = $_POST['clientID'];												// Retrieve the search value.	
	$queryType = $_POST['queryType'];
        $startRow = $_POST['startRow'];
       
        $_SESSION['errMsg'] = "";
         
       
       
        
        
        
//Start checking what action is required and what shall be placed into the div in
// the man participants page.
 
       
 
if($queryType == 0)
            {
                $_SESSION['errMsg'] = "";
               $startRow = $_POST['startRow'];
               if(isset($_POST['surname']))
                    {
                        $surname = $_POST['surname'];
                    }
                else {$surname = "";}
                
                if(!isset($_POST['startRow']) || !is_numeric($startRow)) {$startRow = 0;}
                else
                    {
                    
                    ajax_client_table_basic($db, $startRow, $surname);
                    //ajax_client_Summary_table($db, $startRow, $clientID);
                    
                    }
            }
         
   elseif ($queryType == 1)
    {
       
       ajax_client_Summary_table($db, $startRow, $clientID);
    }
    
     elseif ($queryType == 2)
    {

         $query = "Delete from client WHERE clientID = ";
         $query .= $clientID;
         $result1 = $db->query($query);
         $rowsAffected = $db->affected_rows;
        echo $rowsAffected. ' Record was successfully deleted.';
         $startRow = 0;
         $surname = "";
         ajax_client_table_basic($db, $startRow, $surname);
    }
  elseif ($queryType == 3)
    {

     editClient($db, $clientID);
         
    }
  
    elseif ($queryType == 4)
    {

     
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $active = $_POST['active'];
             
        $postData = array($first_name, $last_name, 
                                $email, $mobile, $active);
        
        $postNames = array("First Name", "Last Name", "Registration Active ?");
        
     chk_editClient($db, $clientID, $postData, $postNames);
         
    }
   
     elseif ($queryType == 5)
    {

     manageClientEvent($db, $startRow, $clientID);
        
         
    }
      elseif ($queryType == 6)
    {
          $eventID = $_POST['eventID'];
          $query = "UPDATE attendee SET eventID =" . $eventID . " WHERE clientID = ";
         $query .= $clientID;
         $result1 = $db->query($query);     
          
          manageClientEvent($db, $startRow, $clientID);
        
         
    }
    
       elseif ($queryType == 7)
    {
          $teamID = $_POST['teamID'];
          $noTeam = $_POST['noTeam'];
          
          if($noTeam == '0')
          {
                $query = "UPDATE team_attendee SET teamID =" . $teamID . " WHERE attendeeID ";
                $query.= " = (SELECT attendeeID from attendee where clientID = " . $clientID .");";
                
                $result1 = $db->query($query);  
          }
          
          elseif ($noTeam == '1')
          {
                 
                $query = "SELECT attendeeID from attendee where clientID = " . $clientID .";";
                $result1 = $db->query($query);
                $row1 = $result1->fetch_array(MYSQLI_BOTH);
                $attendeeID = $row1['attendeeID'];
                
                $query = "INSERT INTO team_attendee (teamID, attendeeID) VALUES (" . $teamID . "," . $attendeeID . ");";
                $result1 = $db->query($query);
                
          }
          
          manageClientEvent($db, $startRow, $clientID);
        
         
    }
    
    
        elseif ($queryType == 8)
    {
          $payStatus= $_POST['payStatus'];
          
          
          if($payStatus == '1')
          {
                $query = "UPDATE attendee SET paid = 1  WHERE clientID = " . $clientID .";";
               
                $result1 = $db->query($query);  
          }
          
          elseif ($payStatus == '0')
          {
                 
                $query = "UPDATE attendee SET paid = 0  WHERE clientID = " . $clientID .";";
                
                $result1 = $db->query($query);
                
          }
          
          manageClientEvent($db, $startRow, $clientID);
        
         
    }
    
    
//********************* Functions Below *************************************************
//
//****************************************************************************************
// Sets up basic table for viewing records. Visible in the top of the MANparticipants page
//****************************************************************************************
    
function ajax_client_table_basic($db, $startRow,$surname)
{
 
     
    if(!isset($_POST['surname']))
    {
        $query = "SELECT * FROM client ORDER by last_name ASC;";
        $result1 = $db->query($query);
        $numClients = $result1->num_rows;

        $query = "SELECT * FROM client ORDER by last_name ASC LIMIT " . $startRow . ",5;";   //Create the general select query.
        $result = $db->query($query);
      
    }
    
    else
    {
        $query = 'SELECT * FROM client WHERE  last_name LIKE "%'. $surname;
        $query .= '%" ORDER by last_name ASC LIMIT ' . $startRow . ',5;';
        
        $result1 = $db->query($query);
        $numClients = $result1->num_rows;

        //$query = "SELECT * FROM client ORDER by last_name ASC LIMIT " . $startRow . ",5;";   //Create the general select query.
        $result = $db->query($query);
    }
    
    
    

            echo '<table id= "clientTableList">';
            echo '<tr>';
            echo '<th id="h" >Client Name </th>';
            echo '<th id="h">Client Email </th>';
            echo '<th id="h">Client Phone </th>';
            echo '<th id="h" >Username</th>';
            echo '<th id ="h"></th>';
            echo '</tr>';
  	
//While Loop starts here - 
// Retrieve the data for the table. 
        
            
       while($row1 = $result->fetch_array(MYSQLI_BOTH))
        
        {
           
            
            echo '<tr id="row' . $row1['clientID']. '">';
            echo '<td id="nameCell">' . $row1['first_name'] . " " . $row1['last_name'] . '</td>';
            echo '<td id="emailCell">' . $row1['email'] . '</td>';
            echo '<td id="phoneCell">' . $row1['mobile'] . '</td>';
            echo '<td id="userName">' . $row1['username'] . '</td>';
            echo '<td id="Buttons"><img class="button" align ="left" src="../images/buttons/query.png"';
            echo 'alt="Retrieve data for this item" onclick="getClientInfo(' . $row1['clientID']. ')" />';
            echo '<img class="button" align ="left" src="../images/buttons/delete_up.png"';
            echo 'alt="Delete This User" onclick="deleteUser(' . $row1['clientID'] .')" />';
            echo '<img class="button" align ="left" src="../images/buttons/modify.png"';
            echo 'alt="Add this user to a team, tournament or event" onclick="manageClientEvent(' . $row1['clientID'] . ')" />';
             echo '<img class="button" align ="left" src="../images/buttons/edit_up.png"';
            echo 'alt="Edit this users information" onclick="editClientData('. $row1['clientID'] . ')" />';
                

            echo    '</td> ';
            
            echo '</tr>';
        }



        echo '</table>';
        echo '<br />';
        
        
        $startRowF = $startRow + 5;
        $backStartRow = $startRow - 5;
        
        if($startRowF >= $numClients)
        {
            $startRowF = $numClients - 1;
        }
        
        if ($backStartRow < 0)
        {
            $backStartRow = 0;
        }
         
        
         if(!isset($_POST['surname']))
            {
                echo '<a href="#" onclick="getClientNext5(' . $backStartRow . ')">Prev</a> &nbsp&nbsp&nbsp';
                echo '<a href="#" onclick="getClientNext5(0)">Beginning</a> &nbsp&nbsp&nbsp';
                echo '<a href="#" onclick="getClientNext5(' . $startRowF . ')">Next</a><br /><br />';
            
        
                echo '<form name="search">';
                echo 'Surname Search: <input id="searchTerm" type="text" name="surname" value="" />';
                echo '<input type="button" value="Search" onclick="(searchFunction())"/>';
                echo '</form>';   
             }
     else 
            {
            
                echo '<a href="#" onclick="getClientNext5(' . $backStartRow . ')">Prev</a> &nbsp&nbsp&nbsp';
                echo '<a href="#" onclick="getClientNext5(0)">Beginning</a> &nbsp&nbsp&nbsp';
                echo '<a href="#" onclick="getClientNext5(' . $startRowF . ')">Next</a><br /><br />';
            
        
                echo '<form name="search">';
                echo 'Surname Search: <input id="searchTerm" type="text" name="surname" value="'. $_POST['surname'] .'" />';
                echo '<input type="button" value="Search" onclick="(searchFunction())"/>';
                echo '</form>';   
         
            }
     
   
 
}
//***************************************************************************************
//Table to display summary information
//***************************************************************************************

function ajax_client_Summary_table($db, $startRow, $clientID)
{
 
    $query = "SELECT * FROM client WHERE clientID =" . $clientID . ";";
    $result1 = $db->query($query);
    $numClient = $result1->num_rows;
    
     $query2 = "SELECT e.event_name, a.paid FROM (event e INNER JOIN attendee a ON e.eventID = a.eventID)"; 
     $query2 .= "WHERE a.clientID = '".$clientID."'";
	$result2 = $db->query($query2);
	$row2 = $result2->fetch_array(MYSQLI_BOTH);
        
      $query3 = "SELECT name from tournament WHERE ";
         $query3 .=   "tournID = any (Select tournID from attendee_tournament where attendeeID";
               $query3 .= " = (SELECT attendeeID from attendee where clientID = " . $clientID ."));";
            $result3 = $db->query($query3);
        
         $query4 = "SELECT team_name from teams WHERE ";
         $query4 .=   "teamID = (Select teamID from team_attendee where attendeeID";
               $query4 .= " = (SELECT attendeeID from attendee where clientID = " . $clientID ."));";
            $result4 = $db->query($query4);
            
         $query5 = "SELECT pizza_name from pizza_type WHERE ";
         $query5 .=   "pizzaID = any (Select pizzaID from pizza_order where attendeeID";
               $query5 .= " = (SELECT attendeeID from attendee where clientID = " . $clientID ."));";
            $result5 = $db->query($query5);
            echo '<p><h2>Client Details</h2></p>';
            echo '<br />';
    if($numClient == 1)
        {
            $row1 = $result1->fetch_array(MYSQLI_BOTH);
            echo '<table id= "clientTableData">';
            echo '<tr><th colspan="2">Client Data Summary</th></tr>';
            echo '<tr id="' . $row1['clientID'] . '">';
            echo '<td id="td1" >Client ID Number </td>';
            echo '<td id="td2">' . $row1['clientID'] .'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1" >First Name </td>';
            echo '<td id="td2">' . $row1['first_name'] .'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1" >Last Name </td>';
            echo '<td id="td2">'. $row1['last_name'] . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1">Client Email </td>';
            echo '<td id="td2">' . $row1['email'] . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1">Client Phone </td>';
            echo '<td id="td2">' . $row1['mobile'] . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1" >Username</td>';
            echo '<td id="td2">' . $row1['username'] . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1" >Active</td>';
            if ($row1['active']== 1)
                {
                  echo '<td id="td2">Yes</td>';
                }
            else {echo '<td id="td2">No</td>';}
            echo '</tr>';
            echo '<tr><th colspan="2">Client Participation Summary</th></tr>';
            echo '<tr>';
            echo '<td id="td1">Events Registered For</td>';
            echo '<td id="td2">' . $row2['event_name'] . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1">Registration Fee Paid:</td>';
            
            if($row2['paid'] == 1)
            {
                echo '<td id="td2">Yes</td>';
            }
            else
                {
                    echo '<td id="td2">No</td>';
                }
            echo '</tr>';
            echo '<tr>';
            if(!$result3)
                {
                    echo '<td id="td1">Tournaments In:</td>';
                    echo '<td id="td2">None</td>';
                }
            else
                {
                    
                     $tournName = "";
                    echo '<td id="td1">Tournaments In:</td>';
                    while ($row3 = $result3->fetch_array(MYSQLI_BOTH))
                    {
                        $tournName .= ucwords($row3['name']) . "<br />";
                    }
                        
                    echo '<td id="td2">' . $tournName . '</td>';
                }
                echo '</tr>';
                
                echo '<tr>';
             if(!$result4)
                {
                    echo '<td id="td1" >Team Member of</td>';
                    echo '<td id="td2">None</td>';
                    echo '</tr>';

                }
             else
                {
                    $row4 = $result4->fetch_array(MYSQLI_BOTH);
                    echo '<td id="td1" >Team Member of</td>';
                    echo '<td id="td2">' . ucwords($row4['team_name']) . '</td>';
                    echo '</tr>';
                }
            if(!$result5)
                {
                    echo '<td id="td1" >Pizza Ordered</td>';
                    echo '<td id="td2">None</td>';
                    //echo '</tr>';

                }
             else
                {
                        $pizzaName = "";
                        echo '<td id="td1" >Pizza Ordered: </td>';
                        while($row5 = $result5->fetch_array(MYSQLI_BOTH))
                        {
                            $pizzaName .= ucwords($row5['pizza_name']) . "<br />";
                            
                        }
                        echo '<td id="td2">' . $pizzaName . '</td>';
                            echo '</tr>';
                    }
                
            echo '</table>';
            echo '<br />';
        }
        else {echo 'No data available';}
        
}

//***************************************************************************************
//Dsiplay a form to edit a clients details.
//***************************************************************************************

function editClient($db, $clientID)
{
    echo '<p><h2>Edit Client Details</h2></p>';
    echo '<br />';
    echo '<p class="redAstrix">' . $_SESSION['errMsg'] . '</p>';
    
     
    if (isset ($_SESSION['postData']))
       
        {
            
            $query = "SELECT * FROM client WHERE clientID =" . $clientID . ";";
            $result1 = $db->query($query);
            $row1 = $result1->fetch_array(MYSQLI_BOTH);
            $postData = $_SESSION['postData'];
            $first_name = $postData[0];
            $last_name = $postData[1];
            $email = $postData[2];
            $mobile = $postData[3];
            $active = $postData[4];
        }   
    
    
    
    
        else 
            
            {
            
             
                $query = "SELECT * FROM client WHERE clientID =" . $clientID . ";";
                $result1 = $db->query($query);
                $row1 = $result1->fetch_array(MYSQLI_BOTH);
                $clientID = $row1['clientID'];
                $first_name = $row1['first_name'];
                $last_name = $row1['last_name'];
                $email = $row1['email'];
                $mobile = $row1['mobile'];
                $active = $row1['active'];
               
             
            }
        
        
       
     
     
            echo '<form id="editClient">';
            echo '<table id= "clientTableData">';
            echo '<tr><th colspan="2">Edit Client Details</th></tr>';
            echo '<tr id="' . $row1['clientID'] . '">';
            echo '<td id="td1" >Client ID Number </td>';
            echo '<td id="td2">' . $row1['clientID'] .'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1" >First Name </td>';
            echo '<td id="td2"><input size="50" id="first_name" type="text" width="100" name="first_name" value="'. $first_name . '"</input></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1" >Last Name </td>';
            echo '<td id="td2"><input size="50" id="last_name" type="text" name="last_name" value="'. $last_name . '"</input></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1">Client Email </td>';
            echo '<td id="td2"><input size="50" id="email" type="text" name="email" value="'. $email . '"</input></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1">Client Phone </td>';
            echo '<td id="td2"><input size="50" id="mobile" type="text" name="mobile" value="'. $mobile . '"</input></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1" >Username</td>';
            echo '<td id="td2">' . $row1['username'] . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td id="td1" >Active Client</td>';
  
           if ($active == 1)
                {
                    
                    echo '<td id="td2"><input id="active" type="checkbox" name="active" value="1" checked </input></td>';                 
                }
            else
                {
                     echo '<td id="td2"><input id="active"  type="checkbox" name="active" value="0" </input></td>';
                }
          

           
            
            echo '</tr>';
            echo '<tr><td id="td3" colspan="2">';
            echo '<img class="button" align="right" src="../images/buttons/save_up.png"';
            echo 'alt="Save edits for this client" onclick="saveEdits(' . $row1['clientID'] . ')" />';
            echo '<img class="button" align="right" src="../images/buttons/delete_up.png"';
            echo 'alt="Cancel edits for this client" onclick="getClientData()" /></td>';
            echo '</tr>';
            echo '</table>';
            echo '</form>';
            echo '<br />';
            
}  

//***************************************************************************************
//Check form submission
//***************************************************************************************
function chk_editClient($db, $clientID, $postData, $postNames)
{
    $_SESSION['errMsg'] = "";
    $errCount=0;
    $first_name = $postData[0];
    $last_name =  $postData[1];
    $email =  $postData[2];
    $mobile = $postData[3];
    $active = $postData[4];
   
    $mobileLen = 0;
    
// Check for empty fields first
    
 
  // exclude $active field from this test     
   for($i = 0; $i < ( sizeof($postData) - 1); ++$i)
        {
            
                if ($postData[$i] == '')
                {
                    $_SESSION['errMsg'] .= $postNames[$i] . ' is empty.' . '<br />';
                    $errCount ++;
                    
                }      
        }
 // Now check if phone number is all numeric   
     if (is_numeric($postData[3]))
        { 
         $mobileLen = strlen($postData[3]);
 // Check if it is 10 numbers in length       
             if(!$mobileLen == 10)
                {
                    $_SESSION['errMsg'] .= 'Phone Number is not valid.' . '<br />';
                    $errCount++;
                }       
                
         }
    else 
            {
                $_SESSION['errMsg'] .= 'Phone Number is not valid.' . '<br />';
                    $errCount++;
            }
  // Check email address is of a valid type
            
      if (!filter_var($postData[2], FILTER_VALIDATE_EMAIL)) 
                {
                   $_SESSION['errMsg'] .= ' Email Address is not valid.' . '<br />';
                    $errCount++; 
                }
 // If there are no errors proceed with update.   
    
    if ($errCount == 0)
      {
                       
                $query = "UPDATE client SET ";
                $query .= "first_name = '" . $first_name . "' ,";
                $query .= "last_name = '" . $last_name . "' ,";
                $query .= "email = '" . $email . "' ,";
                $query .= "mobile = '" . $mobile . "' ,";
                $query .= "active =" . $active;
                $query .= " WHERE clientID = " . $clientID .";";
             
                $result1 = $db->query($query);
                 $rowsAffected = $db->affected_rows;
            if ($rowsAffected == 0)
                {
                $_SESSION['postData'] = $postData;    
                $_SESSION['errMsg'] .= ' Update Failed.' . '<br />';
                    $errCount++;
                    editClient($db, $clientID);
                    
                }
           else
           
               {
                    $startRow=0;
                    ajax_client_Summary_table($db, $startRow, $clientID);   
                }        
       
       }
    else
        {
            $_SESSION['postData'] = $postData;    
            editClient($db, $clientID);

        }
                
                
      
      
          
          
          
}



  
    



//***************************************************************************************
//Display form so a client can be added or removed from an event, team or tournament.
//***************************************************************************************

function manageClientEvent($db, $startRow, $clientID)
{

    echo '<p><h2>Edit Client Event Details</h2></p>';
    echo '<br />';
    echo '<p class="redAstrix">' . $_SESSION['errMsg'] . '</p>';
    
     $query = "SELECT * FROM client WHERE clientID =" . $clientID . ";";
            $result1 = $db->query($query);
            $row1 = $result1->fetch_array(MYSQLI_BOTH);
            
        $query2 = "SELECT e.event_name, e.eventID, a.paid FROM (event e INNER JOIN attendee a ON e.eventID = a.eventID)"; 
        $query2 .= "WHERE a.clientID = '".$clientID."'";
	$result2 = $db->query($query2);
	$row2 = $result2->fetch_array(MYSQLI_BOTH);
        
            $query3= "SELECT event_name,eventID FROM event ";
            $query3 .= "WHERE event_started != 2;";
            $result3 = $db->query($query3);
            
         $query4 = "SELECT team_name from teams WHERE ";
         $query4 .=   "teamID = (Select teamID from team_attendee where attendeeID";
               $query4 .= " = (SELECT attendeeID from attendee where clientID = " . $clientID ."));";
            $result4 = $db->query($query4);
                
	 $query5 = "SELECT team_name, teamID from teams";
             $result5 = $db->query($query5);
             
             if($row2['paid'] == '1')
             {
                 $eventPaid = "Paid : Yes";
                 $buttonStyle = '<td colspan="1" id="td14"><img class="button" align="right" src="../images/buttons/delPay.png"';
                 $buttonStyle .= 'alt="Delete Payment for This Event" onclick="payEvent(0,' . $row1['clientID'] . ')" /></td>';
             }
             else 
                 {
                    $eventPaid = "Paid : No";
                    
                    $buttonStyle = '<td colspan="1" id="td14"><img class="button" align="right" src="../images/buttons/pay.png"';
                    $buttonStyle .= 'alt="Accept Payment for This Event" onclick="payEvent(1,' . $row1['clientID'] . ')" /></td>';
                 
                    
                 }
                 
        
            echo '<form id="editClientEvent">';
            
            echo '<table id= "clientEventTableData">';
            echo '<tr><th colspan="4">Client Details</th></tr>';
            
            echo '<tr id="' . $row1['clientID'] . '">';
            echo '<td id="td11" >Client ID Number </td>';
            echo '<td id="td12">' . $row1['clientID'] .'</td>';
            echo '<td id="td13" style ="font-weight:bold">Client Name:</td>';
            echo '<td id="td14">' . ucwords($row1['first_name'] . ' ' . $row1['last_name']) . '</td>';
            echo '</tr>';
            
            echo '<tr>';
            echo '<td id="td11" ></td>';
            echo '<td id="td12"></td>';
            echo '<td id="td13"></td>';
            echo '<td id="td14"></td>';
            echo '</tr>';
            
            echo '<form id="eventForm">';
            echo '<tr><th colspan="4">Client Event Details</th></tr>';
            echo '<tr>';
            echo '<td id="td11" >Current Event:</td>';
            echo '<td colspan="1" id="td12">' . $row2['event_name']. '</td>';
            echo '<td colspan="1" id="td13">' . $eventPaid . '</td>';
            
            if(!$row2['event_name'] == "")
                { 
                    echo $buttonStyle;
                    
                }
            else {echo '<td id="td14"></td>';}
            
            echo '</tr>';
            
            echo '<tr>';
            echo '<td id="td11" >Change Events To:</td>';
            echo '<td colspan="2" id="td2">';
            
            echo '<select id= "eventSelect" name="eventSelect">';
                
             
                for ($i = 0; $i < $result3->num_rows;$i++) 
                        {
                            $row3 = $result3->fetch_array(MYSQLI_BOTH);    

                                if ($i==0)
                                    {
                                        echo '<OPTION id="option' . $row3['eventID']. '" value="'.$row3['eventID'].'" selected="selected">' . $row3['event_name'] . '</OPTION><br />';			
                                    }
                                else
                                    {
                                        echo '<OPTION id="option' . $row3['eventID']. '" value="'.$row3['eventID'].'">' . $row3['event_name'] . '</OPTION><br />';
                                    }
                        }

            echo '</select>';
          
            echo '</td>';
            echo '<td id="td14"><img class="button" align="right" src="../images/buttons/join.png"';
            echo 'alt="Change Events for this client" onclick="joinEvent(' . $row1['clientID'] . ')" /></td>';
            echo '</tr>';
            echo '</form>';
 //Get Data for team name         
            $row4 = $result4->fetch_array(MYSQLI_BOTH);
            echo '<form id="editClientTeam">';
            echo '<tr><th colspan="4">Client Team Details</th></tr>';
            
            echo '<tr>';
            echo '<td id="td11" >Current Team:</td>';
            echo '<td colspan="3" id="td12">' . $row4['team_name']. '</td>';
            if($row4['team_name']== "")
            {
                $noTeam = 1;
            }
            else {$noTeam = 0;}
            
            echo '</tr>';
            $row5 = $result5->fetch_array(MYSQLI_BOTH);
            echo '<tr>';
            echo '<td id="td11" >Change Team To:</td>';
            echo '<td colspan="2" id="td2">';
            
            echo '<select id= "teamSelect" name="teamSelect">';
                
             
                for ($i = 0; $i < $result5->num_rows;$i++) 
                        {
                            $row5 = $result5->fetch_array(MYSQLI_BOTH);    

                                if ($i==0)
                                    {
                                        echo '<OPTION id="option' . $row5['teamID']. '" value="'.$row5['teamID'].'" selected="selected">' . $row5['team_name'] . '</OPTION><br />';			
                                    }
                                else
                                    {
                                        echo '<OPTION id="option' . $row5['teamID']. '" value="'.$row5['teamID'].'">' . $row5['team_name'] . '</OPTION><br />';
                                    }
                        }

            echo '</select>';
          
            echo '</td>';
            echo '<td id="td14"><img class="button" align="right" src="../images/buttons/join.png"';
            echo 'alt="Change Teams for this client" onclick="joinTeam('. $noTeam .','. $row1['clientID'] . ')" /></td>';
            echo '</tr>';
            echo '</form>';
            
            
            
            
            echo '</table>';
            echo '</form>';
            echo '<br />';
            
 
            
            
}    
    
//Return back to the MANclient.php page.
?>