<?php

// Inialise session
session_start();

// Include database connection settings
include('cassa_lan.inc');

$login = mysql_query("SELECT * FROM client WHERE username = '" . mysql_real_escape_string($_POST['username']) . "' 
			and password = '" . mysql_real_escape_string($_POST['password']) . "'")or die(mysql_error());

// Check username and password match stored record
if (mysql_num_rows($login) == 1) 
{
// Set username session variable
$_SESSION['username'] = $_POST['username'];
// Jump to secured page
mysql_close($link);
header('Location: user_details.php');
}
else {
// Jump to login page

mysql_close($link);

header('Location: index.php');
}

?>

