<!-- //******************************************************
// Name of File: user_update.php
// Revision: 1.0
// Date: 29/03/2012
// Author: L.Smith
// Modified:L.SMITH 1/4/12
//******************************************************

//******************** Start of TEMPLATE ******************** -->
<?php
session_start();
if (!isset($_SESSION['username'])) 
	{
		header('Location: index.php');
	}

include('cassa_lan.inc');

$username = $_SESSION['username'];
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
$pnumber = $_POST['mobile'];
$clientID = $_POST['clientID'];





$updated_details = mysql_query("UPDATE client SET first_name ='" . $fname . "' , last_name = '" . $lname . "', 
			mobile = '" . $pnumber . "' WHERE clientID = '" . $clientID . "'") or die(mysql_error());
mysql_close($link);
header('Location: user_details.php');
			
?>
