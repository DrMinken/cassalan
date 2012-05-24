<?php

$hostname = 'localhost';        // MySQL hostname
$dbname   = 'cassa_lan'; 		  // database name.
$username = 'reader';           // Database username.
$password = 'pass123';          // Reader Password

//Connect to host to read records

$link = mysql_connect($hostname, $username, $password) or DIE('Connection to host is failed, perhaps the service is down!');
// Select the database
mysql_select_db($dbname) or DIE('Database name is not available!');

?>

