
<!-- //******************************************************

// Name of File: createpizza.php
// Revision: 1.0
// Date: 
// Author: Luke Spartalis
// Modified:

//***********************************************************

//*************** Start of CREATE PIZZA ******************* -->


<html>
<head></head>
<body>
<title> Pizza Order </title>

<?php

// Validation

if (isset($_POST['pizza_name'] , $_POST['description'] , $_POST['price']))
{
	$errors = array();


	$pizza_name = $_POST['pizza_name'];
	$description = $_POST['description'];
	$price = $_POST['price'];


	if (empty($pizza_name) || empty($price) || empty($description)) // check if fields are empty
	{
		$errors[] = 'All fields must contain values';
	}

	else
	{


		if (strlen($pizza_name) > 32) // check if pizza_name is over 32 chars
			{
				$errors[] = 'Name is too long, 32 characters only';
			}

		if (!is_numeric($price)) //check if the price is a number
			{
			$errors[] = 'Price must be a number.';
			}

			else
			{
				if ($price <= 0)  // check if it is above 0
				{
				$errors[] = 'Price must be above $0';
				}
			}
	

	if (strlen($description) > 128) // check is description is over 128
		{
		$errors[] = 'Description is too long, 128 characters only';
		}

	}

	if (!empty($errors)) // check for errors and print out message
	{
	foreach ($errors as $error)
		echo '<strong>' , $error,  '</strong><br />';
	}

	else // end of validation - if no errors
	{
		// CONNECT TO THE DATABASE: MegaLAN
	@ $db = new mysqli('localhost', 'root','','cassa_lan');


	// Handle connection error
	if (mysqli_connect_error())
	{
		echo '<p align="center">Error connecting to database.<br /></p>';
		echo '<p align="center">Error Message: '.mysqli_connect_error().'</p>';
		exit;
	}
  
	$query = "INSERT INTO pizza_type (pizza_name, description, price) VALUES ('".$_POST['pizza_name']."', '".$_POST['description']."', '".$_POST['price']."')";
   
	$result = $db->query($query);

	mysql_close($db);
	} 
}
?>


<form action="createpizza.php" method="post">
Pizza Name:<br /> <input type="text" name="pizza_name" /><br />
Pizza Description:<br /> <input type="text" name="description" /><br />
Pizza Price:<br /> <input type="double" name="price" /><br />
<br /> <input type="submit" />
</form> 

</body>
</html>

