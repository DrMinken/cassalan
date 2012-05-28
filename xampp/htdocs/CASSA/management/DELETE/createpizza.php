<?php 
	session_start();									// Start/resume THIS session

	// PAGE SECURITY
	if (!isset($_SESSION['isAdmin']))
	{
		if ($_SESSION['isAdmin'] == 0)
		{
			echo '<script type="text/javascript">history.back()</script>';
			die();
		}
	}


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
			// check if pizza_name is over 32 chars
			if (strlen($pizza_name) > 32)
			{
				$errors[] = 'Name is too long, 32 characters only';
			}
	
			//check if the price is a number
			if (!is_numeric($price))
			{
				$errors[] = 'Price must be a number.';
			}
			else
			{
				// check if it is above 0
				if ($price <= 0) 
				{
					$errors[] = 'Price must be above $0';
				}
			}

			// check is description is over 128
			if (strlen($description) > 128) 
			{
				$errors[] = 'Description is too long, 128 characters only';
			}
		}
		// end of validation - if no errors
		if (empty($errors)) 
		{
			// OPEN DATABASE CONNECTION
			include("includes/conn.php"); 	

			// INSERT NEW PIZZA
			$query = "INSERT INTO pizza_type (pizza_name, description, price) VALUES ('".$_POST['pizza_name']."', '".$_POST['description']."', '".$_POST['price']."')";
			$result = $db->query($query);
			$db->close();
		}
	}

?>


<!-- //******************************************************

// Name of File: createpizza.php
// Revision: 1.0
// Date: 
// Author: Luke Spartalis
// Modified: Quintin Maseyk 29/04/2012

//***********************************************************

//*************** Start of CREATE PIZZA ******************* -->


<div id='createPizza'>
<h3 align='center'>Create a new pizza</h3><br />

	<!-- Check for errors and print out message -->
	<?php	
		if (!empty($errors)) 
		{	
			foreach ($errors as $error)
			{
				echo '<div class="error">';
				echo '<strong>*' . $error .  '</strong><br />';
				echo '</div>';
			}
		}
	?>
	<form name="CreatePizzaForm" action="MANpizza.php" method="post">
		Pizza Name:<br />
		<input type="text" name="new_pizza_name" id="new_pizza_name" maxlength="32" size="32" /><br /><br />
		
		Description:<br />
		<input type="text" name="new_description" id="new_description" maxlength="128" size="32" /><br /><br />
		
		Price $:<br />
		<input type="text" name="new_price" id="new_price" maxlength="5" size="5" /><br /><br />
	
		<input type="button" name="submit" value="Add Pizza" onclick="createPizza()" />
	</form>
</div>