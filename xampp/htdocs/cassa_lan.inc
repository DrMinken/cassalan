<?php
$hostname   = 'localhost';        // MySQL hostname
$database   = 'cassa_lan'; 	  // database name.
$username   = 'reader';           // Your database username.
$password   = 'pass123';          // User Reader Password

@ $dbLink = new mysqli($hostname, $username, $password, $database);
if (mysqli_connect_error())
	{
		echo '<p align="center">Error connecting to database.<br /></p>';
		echo '<p align="center">Error Message: '.mysqli_connect_error().'</p>';
		exit;
	}

?>



