<!-- ******************************************************

// Name of File: login.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Lyndon Smith
// Modified: Lyndon Smith 16/04/2012

//***********************************************************

//*************** Start of login script ******************* -->
<!-- Steps:

// 1) Check to see if event has started and if so, only progress if I.P address Range is correct or user is an admin.
// 2) Check if user credentials indicate the user is registered. If not re-direct back to home page.
// 3) If user is registered are they a staff member or a non-staff member. Set Session Flag $_SESSION['isSTAFF'] to "1".
// 4) Set Session variable $_SESSION['username'] to the $_POST['username'].
// 5) If all successful, re-direct to user / staff home page.
// 6) Create $_SESSION variables for 'fullName' & 'errMsg'

-->

<?php

// Inialise session
session_start(); // Start/resume THIS session


// Include database connection settings
include('includes/conn.php');





// First check if user exists
$thisLogin = login_user($db);
if ($thisLogin == 1)
	{
		$eventStatus = event_check($db);		
		if ($eventStatus == 1)
			{
				$adminStatus = isStaff($db);
				if($adminStatus == 1)
					{
						//close connection
						$db->close();
						$_SESSION['errMsg'] = "";
						header('Location: MANparticipants.php');
					}
				else 
					{
						$ipStatus = check_IP_address($db);
						if ($ipStatus == 1)
							{
								//close connection
								$db->close();
								$_SESSION['errMsg'] = "";
								header('Location: participant.php');
							}
						else
							{
								//close connection
								$db->close();
								$_SESSION['errMsg'] = "You cannot login after an event is started from a remote location.";
								header('Location: home.php');
							}
					}
			}
		
			else 
				{
					$adminStatus = isStaff($db);
					
					if($adminStatus == 1)
						{
							//close connection
							$db->close();
							$_SESSION['errMsg'] = "";
							header('Location: MANparticipants.php');
						}
					else
							{
								//close connection
								$db->close();
								$_SESSION['errMsg'] = "";
								header('Location: participant.php');
							}
				}

	}
else
	{
		//close connection
		$db->close();
		$_SESSION['errMsg'] = "Login Failed, please try again.";
				header('Location: home.php');
	}



//********************************Function Event_check *********************************************
// Requires : Database connection
// Returns : 1 if event is started or 0 if not
//
//**************************************************************************************************
// Query Data Base to check if event has started.

function event_check($db)
{

	$query = "SELECT * FROM event WHERE event_started = '1'";
	$result = $db->query($query) or die(mysqli_error());
	$row = $result->fetch_array();
	$row_cnt = $result->num_rows;


if ($row_cnt == 1) 
	{
		 // close result set
    	$result->close();
		return 1;
	}
	
	else 
		{ 
		 // close result set
    	$result->close();
		return 0;
		}
	
}	
		
// ********************************************end of function event_check **********************************

		
		
//********************************  Function check_IP_address ***********************************************
// Requires : Database connection
// Returns : 1 if IP address is within range or 0 if not
//
//**************************************************************************************************
// Query Data Base to get IP Address range.
		
function check_IP_address($db)
{
	
	$query = "SELECT server_IP_address FROM event WHERE event_started = '1'";
	$result = $db->query($query) or die(mysqli_error());
	$row = $result->fetch_array();	
		
		
				
	$serverIP = ip2long($row['server_IP_address']);
	
	// Now create the hi and lo values of the server address
	
	$lowIP = abs($serverIP + 20);
	$highIP = abs($serverIP - 20);
	
	// Get the IP address of the requesting party
	
	// *******Include after testing ***********	
	
	// $userIP = ip2long($_SERVER['REMOTE_ADDR'])	 
		
	// *******Remove after testing ***********
	
		$userIP = abs(ip2long("192.168.1.033"));
	// Check whether the address is within range and return the result
	
	if ( $userIP <= $lowIP || $userIP >= $highIP )
				{
					
					$_SESSION['errorMSG'] = "You have attempted to login after an event has started and"
													. "from outside the MegaLAN";
					 // close result set
    				$result->close();
					return 0;
				}
		
	else	
			{  
			// close result set
    		$result->close();
    		return 1;
    		}
	
}			
		
//******************************************end of function check_IP_address ********************************		
	
//****************************************Function isStaff () *****************************************************
// Requires= Database Connection
// Returns 1 if user is an admin returns 0 if not
//*****************************************************************************************************************

function isStaff($db)
{
	$query = "SELECT * FROM client WHERE username = '" . mysql_real_escape_string($_POST['username']) . "' 
				and password = '" . mysql_real_escape_string($_POST['password']) . "'";
	$result = $db->query($query) or die(mysqli_error());
	$row = $result->fetch_array();
		
		// Check to see if user is a staff member
							
			if ($row['admin'] == 1)
				{
					 // close result set
    				$result->close();					
					return 1;
				}
				else 
					{ 
					 // close result set
	    			$result->close();
					return 0;
					}
		
}
//	***************************************End of isStaff Function ***********************************************		

//*********************************Function login_user() is used for code re-use only ***************************
// Requires= Database Connection
// Returns 1 if user exists returns 0 if not
//*****************************************************************************************************************	
function login_user($db)
	{
	
	$query = "SELECT * FROM client WHERE username = '" . mysql_real_escape_string($_POST['username']) . "' 
				and password = '" . mysql_real_escape_string($_POST['password']) . "'";
				
	$result = $db->query($query)or die(mysqli_error());
	$row = $result->fetch_array();
	$row_cnt = $result->num_rows;
	
		
		// Check username and password match stored record
		if ($row_cnt == 1) 
			{
				// Set username session variable
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['err_code'] = 0;
						
				// create session vars if ok
				$_SESSION['fullName'] = $row['first_name']. " " . $row['last_name'];
			 	
			 	// close result set
   				$result->close();			
					return 1;
				
			}
		else 
			{
				 // close result set
    			$result->close();				
				return 0;
			}
	} 
	
	


//*************************************End of Function login_user() ********************************************