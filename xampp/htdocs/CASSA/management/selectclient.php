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

     
        $clientID = $_POST['clientID'];												// Retrieve the search value.	
	$queryType = $_POST['queryType'];
   
        //$_SESSION['errMsg'] = "";
        
//Start checking what action is required and what shall be placed into the div in
// the man event page.
        
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
         $startRow = 0;
         $surname = "";
         ajax_client_table_basic($db, $startRow, $surname);
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
// Retrieve the data for the table. There should only be one row.
        while($row1 = $result->fetch_array(MYSQLI_BOTH))							
        {
            
            echo '<tr id=' . $row1['clientID'] . '">';
            echo '<td id="nameCell">' . $row1['first_name'] . " " . $row1['last_name'] . '</td>';
            echo '<td id="emailCell">' . $row1['email'] . '</td>';
            echo '<td id="phoneCell">' . $row1['mobile'] . '</td>';
            echo '<td id="userName">' . $row1['username'] . '</td>';
            echo '<td id="Buttons"><img align ="left" src="../images/buttons/query.png" width="18" height="18"';
            echo 'alt="Retrieve data for this item" onclick="" />';
            echo '<img align ="left" src="../images/buttons/delete_up.png" width="18" height="18"';
            echo 'alt="Delete This User" onclick="deleteUser(' . $row1['clientID'] .')" />';
            echo '<img align ="left" src="../images/buttons/addto.png" width="18" height="18"';
            echo 'alt="Add this user to a team, tournament or event" onclick="" />';
             echo '<img align ="left" src="../images/buttons/edit_up.png" width="18" height="18"';
            echo 'alt="Edit this users information" onclick="" />';
                

            echo    '</td> ';
            
            echo '</tr>';
        }
//While Loop ends here.


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
function ajax_client_Summary_table($db, $startRow, $clientID)
{
 
    $query = "SELECT * FROM client WHERE clientID =" . $clientID . ";";
    $result1 = $db->query($query);
    $numClients = $result1->num_rows;
    
    $query = "SELECT * FROM client ORDER by last_name ASC LIMIT " . $startRow . ",5;";   //Create the general select query.
    $result = $db->query($query);
   
            echo '<table id= "clientTableList">';
            echo '<tr>';
            echo '<th id="h" >Client Name </th>';
            echo '<th id="h">Client Email </th>';
            echo '<th id="h">Client Phone </th>';
            echo '<th id="h" >Username</th>';
            echo '</tr>';
  	
//While Loop starts here - 
// Retrieve the data for the table. There should only be one row.
        while($row1 = $result->fetch_array(MYSQLI_BOTH))							
        {
            
            echo '<tr id=' . $row1['clientID'] . '">';
            echo '<td id="nameCell">' . $row1['first_name'] . " " . $row1['last_name'] . '</td>';
            echo '<td id="emailCell">' . $row1['email'] . '</td>';
            echo '<td id="phoneCell">' . $row1['mobile'] . '</td>';
            echo '<td id="userName">' . $row1['username'] . '</td>';
            echo '</tr>';
        }
//While Loop ends here.


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
        echo '<a href="#" onclick="getClientNext5(' . $backStartRow . ')">Prev</a> &nbsp&nbsp&nbsp';
        echo '<a href="#" onclick="getClientNext5(0)">Beginning</a> &nbsp&nbsp&nbsp';
        echo '<a href="#" onclick="getClientNext5(' . $startRowF . ')">Next</a>';

 
}


//Return back to the MANclient.php page.
?>