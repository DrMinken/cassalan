
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
// 2) Check if user credentials indicate the user is registered. If not re-direct to registration page.
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



//********************************Function Event_check *********************************************
// Requires : Nothing
// Returns : 1 if event is started or 0 if not
//
//**************************************************************************************************
// Query Data Base to check if event has started.

function event_check()
{
	$event_check = mysqli_query($dbLink, "SELECT * FROM event WHERE event_started = '1'")or die(mysqli_error($dbLink));
		
	if (mysqli_num_rows($event_check) == 1) 
	{
		return 1;
	}
	else 
	{ 
		return 0;
	}
}
		
// ********************************************end of function event_check **********************************

		
		
//********************************  Function check_IP_address ***********************************************
// Requires : nothing
// Returns : 1 if IP address is within range or 0 if not
//
//**************************************************************************************************
// Query Data Base to get IP Address range.
		
function check_IP_address()
{
	$server_IP = mysqli_query($dbLink, "SELECT server_IP_address FROM event WHERE event_started = '1'")or die(mysqli_error($dbLink));
	
	$address = mysqli_fetch_array($server_IP, MYSQLI_BOTH);
			
	$serverIP = ip2long($address['server_IP_address']);
	
	// Now create the hi and lo values of the server address
	
	$lowIP = $serverIP + 20;
	$highIP = $serverIP - 20;
	
	// Get the IP address of the requesting party
	
	// *******Include after testing ***********	
	
	// $userIP = ip2long($_SERVER['REMOTE_ADDR'])	 
		
	// *******Remove after testing ***********
	
		$userIP = ip2long("192.168.1.001");
	// Check whether the address is within range and return the result
	
	if ( $userIP >= $highIP || $userIP <= $lowIP )
	{
		$_SESSION['errorMSG'] = "You have attempted to login after an event has started and "
								. "from outside the MegaLAN";
		return 0;
	}
	else
	{ 
		return 1;
	}
}			
		
//******************************************end of function check_IP_address ********************************		
		


		
				

//********************************************************************
//Event remote access is closed so check if IP address is within range 
		
	/*
	if ( $userIP == $serverIP )
	{
		$eventStatus = 1;
		$_SESSION['errorMSG'] = "You have attempted to login after an event has started and "
								. "from outside the MegaLAN";
		mysql_close($link);
		header('Location: home.php');
	}
	elseif (mysql_num_rows($event_check) == 0) 
	{
		// Query Data Base to check for a valid user
		login_user();
	}
	//Now we can check if the username exists
	else 
	{ 
		login_user();
    }
	*/

	
//*********************************Function login_user() is used for code re-use only ***************************
	
//function login_user()
//{
	/*$login = mysql_query("SELECT * FROM client WHERE username = '" . mysql_real_escape_string($_POST['username']) . "' AND password = '" . mysql_real_escape_string($_POST['password']) . "'")or die(mysql_error());
	
	// Check username and password match stored record
	if (mysql_num_rows($login) == 1) 
	{
		// Set username session variable
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['err_code'] = 0;
		
		// Check to see if user is a staff member
		$newData = mysql_fetch_array($login, MYSQL_BOTH);

		if ($newData['admin'] == 1)
		{
			// Close database connection and Jump to secure Admin page
			mysql_close($link);
			$_SESSION['isSTAFF'] = 1;
			header('Location: MANparticipants.php?');
		}
		else 
		{			
			// Close database connection and Jump to secured client page
			mysql_close($link);
			$_SESSION['isSTAFF'] = 0;
			header('Location: user_details.php?');
		}
	}
	else 
	{
		// Jump back to login page
		mysql_close($link);
		header('Location: register.php');
	}*/


// VERIFY USER [Quintin M]
	// Assign protected login variables	
	$username = $db->real_escape_string($_POST['username']);
	$password = $db->real_escape_string($_POST['password']);

	// Create query, check result
	$login = "SELECT * FROM client WHERE username = '".$username."' AND password = '".$password."'";
	$result = $db->query($login);
	$row = $result->fetch_assoc();

	if ($result->num_rows == 1)
	{
		$fullName = $row['first_name'] . ' ' . $row['last_name'];

		// Set USERNAME, FULLNAME session variable
		$_SESSION['username'] = $username;
		$_SESSION['fullName'] = $fullName;
		

		// Is user a STAFF member?
		if ($row['admin'] == 1)
		{
			$_SESSION['isStaff'] = 1;
			header('Location: home.php');
		}
		else
		{
			$_SESSION['isStaff'] = 0;
			header('Location: home.php');
		}
	}
	else
	{
		$_SESSION['username'] = '';
		$_SESSION['fullName'] = '';
		$_SESSION['error'] = '<font class="error">Login failed</font>';
		header('Location: home.php');
	}


//}
//*************************************End of Function login_user() ********************************************
?>