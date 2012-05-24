<?php 
	session_start();

	// PAGE SECURITY
	if (!isset($_SESSION['isAdmin']))
	{
		if ($_SESSION['isAdmin'] == 0)
		{
			echo '<script type="text/javascript">history.back()</script>';
			die();
		}
	}

	include("../includes/conn.php"); 
	
	print_r($_POST);

?>

<table cellspacing='20px'>
<tr>
	<th align='left'>Name</th>
	<th align='left' width='200px'>Description</th>
	<th align='left'>Price</th>
	<th>&nbsp;</th>
</tr>

<?php
	// IF 'current menu' IS TRIGGERED
	// DISPLAY [this] MENU ITEMS
	if (isset($_POST['menuID']))
	{
		// [this] MENU 
		$menuID = $_POST['menuID'];

		// GET ALL PIZZA ITEMS IN THIS MENU
		$select = "SELECT * FROM menu_items WHERE menuID='".$menuID."'";
		$result = $db->query($select);

		for ($i=0; $i<$result->num_rows; $i++)
		{
			$row = $result->fetch_assoc();

			// GET [this] MENUS PIZZA
			$pizzaID = $row['pizzaID'];

			// GET [this] PIZZA's DESCRIPTION
			$get = "SELECT * FROM pizza_type WHERE pizzaID='".$pizzaID."'";
			$resultPizza = $db->query($get);
			$rowPizza = $resultPizza->fetch_assoc();

			// SETUP DELETE BUTTON
			$onclick = "deletemenuRow(".$row['menuID'].", ".$rowPizza['pizzaID'].")";

			echo '<tr>';
			echo '<td>'.$rowPizza['pizza_name'].'</td>';
			echo '<td>'.$rowPizza['description'].'</td>';
			echo '<td>$'.$rowPizza['price'].'</td>';
			echo '<td><img class="pointer" src="../images/buttons/delete_60.png" alt="Remove this pizza" onclick="'.$onclick.'" />';
			echo '</tr>';
		}
	}
?>