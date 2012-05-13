<!-- //******************************************************

// Name of File: CreateTournament.php
// Revision: 1.0
// Date: 13/05/2012
// Author: Tinashe Masvaure
// Modified:

//***********************************************************
//This script works in conjuction with the MANtournament.php script.
//it acts as partner script and provides the details of the event
//selected in the list box. 
//********** Start of select event script **************--> 
<?php

include("../includes/conn.php");
session_start();
  if (!isset($_SESSION['username']))
{
    echo '<script type="text/javascript">history.back()</script>';
    die();
}
//get form data
$tourntID = $_POST['tournID'];                                                // Retrieve the search value.    
    $queryType = $_POST['queryType'];
                                         // Retrieve the query Identifier.
                                                                                    
    if($queryType == 0)
            {
                $query = "SELECT * FROM tournament WHERE tournID =" . $tourntID;        //Create the general select query.
                ajax_tournament_table_basic($db, $tourntID);
            }
$name = strip_tags( $_POST ['name']);
$date = strip_tags( $_POST ['date']);
$start_time = strip_tags ($_POST ['start_time']);
$end_time = strip_tags($_POST ['end_time']);

if ($submit)
{
    
    // check for existance
    if($name&&$date&&$start_time&&$end_time)
        {
   
            if($name == $name)
            {
                // checking for tournament name length 
                if ( strlen($name)>32)
                {
                    echo "Max limit for Tournament Length is 32 characters";
                }
    
                    else
                    {
                        // Create the tournament
                         $queryreg = mysql_query("
                         INSERT INTO tournament VALUES ('','2','$name','$date','$start_time','$end_time','0','0','0')
                         ");
                         die("You have succefully created a tournament");
                          
                         
       
                    }
      $db->close(); //close database 
                }
        
            }    
      else
    echo "Please fill in <b>all</b> fields!";
    }
   ?>