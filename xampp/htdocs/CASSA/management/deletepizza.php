<?php
	session_start();									// Start/resume THIS session

	// PAGE SECURITY
	if (!isset($_SESSION['username']))
	{
		echo '<script type="text/javascript">history.back()</script>';
		die();
	}

	$_SESSION['title'] = "Delete Pizza | MegaLAN"; 		// Declare this page's Title
	include("includes/template.php"); 					// Include the template page
	include("includes/conn.php");						// Inlcude DB connection


if (isset($_POST['submit']))
{
	$query = "DELETE FROM pizza_type WHERE pizzaID = '".$_POST['pizza_name']."'";
	$result = $db->query($query) or die(mysql_error());
}
?>



<!-- //******************************************************

// Name of File: deletepizza.php
// Revision: 1.0
// Date: 
// Author: Luke Spartalis
// Modified: Quintin Maseyk 29/04/2012

//***********************************************************

//*************** Start of DELETE PIZZA ******************* -->

<html>
<head></head>
<body>
<center>
<div id='shell'>

<!-- Main Content [left] -->
<div id="content">


<div id='deletePizza'>
	<form name='deletePizza' method='POST' action='deletepizza.php'>
		
	<?php 
		$query = "SELECT * FROM pizza_type";
		$result = $db->query($query);
	 
		echo '<select name="pizza_name">';
		echo '<option value="-" selected="selected">Please select a Pizza</option>';


		for ($i=0; $i<$result->num_rows; $i++) 
		{
			$row = $result->fetch_assoc();
			$pizzaID = $row['pizzaID'];
			$pizza_name = $row['pizza_name'];
			
			// Iterate through and add pizza per line
			echo '<option value="'.$pizzaID.'">'.$pizza_name.'</option>';
		}

		echo '</select>';
	?>

		<input type="submit" name="submit" value="Delete Pizza" />
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