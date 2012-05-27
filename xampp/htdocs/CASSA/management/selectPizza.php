<?php 
	session_start();
	include("../includes/conn.php");					// Include database connection

	// PAGE SECURITY
	if (!isset($_SESSION['isAdmin']))
	{
		if ($_SESSION['isAdmin'] == 0)
		{
			echo '<script type="text/javascript">history.back()</script>';
			die();
		}
	}


	if (isset($_POST['action']))
	{
		// IF [user] CLICKS TO ADD PIZZA TO 'CURRENT MENU'
		if ($_POST['action'] == 'add')
		{
			$menuID = $_POST['menuID'];
			$pizzaID = $_POST['pizzaID'];

			// CHECK IF THIS ALREADY EXISTS
			$check = "SELECT * FROM menu_items WHERE menuID = '".$menuID."' AND pizzaID = '".$pizzaID."'";
			$result = $db->query($check);

			if ($result->num_rows > 0)
			{
				echo '<script type="text/javascript">alert("This pizza already exists in that menu");</script>';
			}
			else
			{
				// INSERT [this] PIZZA to [that] MENU
				$query = "INSERT INTO menu_items VALUES ('".$menuID."', '".$pizzaID."')";
				$result = $db->query($query);
			}
		}
		// IF [user] CLICKS TO DELETE PIZZA FROM 'CURRENT MENU'
		else if ($_POST['action'] == 'delete')
		{
			// DELETE [this] FROM [that] MENU
			$del = "DELETE FROM menu_items WHERE menuID='".$_POST['menuID']."' AND pizzaID='".$_POST['pizzaID']."'";
			$result = $db->query($del);
		}
		else if ($_POST['action'] == 'deletePizzaType')
		{
			// DELETE [this] PIZZA @ pizza_type
			$del = "DELETE FROM pizza_type WHERE pizzaID='".$_POST['pizzaID']."'";
			$result = $db->query($del);
		}
	}



	include("../includes/conn.php"); 
?>

<table class='pizzaTable' border='0'>
<tr>
	<td class='MANheader' width='80px'>&nbsp;</td>
	<td align='left' class='MANheader' width='200px'>Name</td>
	<td align='left' class='MANheader' width='340px'>Description</td>
	<td align='left' class='MANheader' width='80px'>Price ($)</td>
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
			$onclick = "deletemenuRow('menuID=".$row['menuID']."&pizzaID=".$rowPizza['pizzaID']."&action=delete')";

			echo '<tr>';
			echo '<td><img class="pointer" src="../images/buttons/delete_60.png" alt="Remove this pizza" onclick="'.$onclick.'" />';
			echo '<td>'.$rowPizza['pizza_name'].'</td>';
			echo '<td>'.$rowPizza['description'].'</td>';
			echo '<td>$'.$rowPizza['price'].'</td>';
			echo '</tr>';
		}
	}
?>