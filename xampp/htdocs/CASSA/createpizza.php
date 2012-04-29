<?php 
	session_start();									// Start/resume THIS session
	$_SESSION['title'] = "Create Pizza | MegaLAN"; 		// Declare this page's Title
	include("includes/template.php"); 					// Include the template page


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


<html>
<head></head>
<body>

<center>

<div id='shell'>

<!-- Main Content [left] -->
<div id="content">


<div id='createPizza'>
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

	<form action="createpizza.php" method="post">
		Pizza Name:<br />
		<input type="text" name="pizza_name" maxlength="32" size="32" /><br /><br />
		
		Pizza Description:<br />
		<input type="text" name="description" maxlength="128" size="32" /><br /><br />
		
		Pizza Price:<br />
		<input type="text" name="price" maxlength="4" size="4" /><br /><br />
	
		<input type="submit" name="submit" value="Add Pizza" />
	</form> 
</div>





<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->
<!-- ********************************* -->

</div><!-- end of: Content -->


<!-- INSERT: rightPanel -->
<?php include('includes/rightPanel.html'); ?>


<!-- INSERT: footer -->
<div id="footer">
	<?php include('includes/footer.html'); ?>
</div>


</div><!-- end of: Shell -->

</center>
</body>
</html>

<!-- ********************************* -->
<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->