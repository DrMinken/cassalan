<?php 
	session_start();
	//$_SESSION['pizzaID'];
	//$_SESSION['prevPage'];
	

	print_r($_POST);
	

if (isset($_POST['pizza_name'])) // Delete pizza from database
{
	include("includes/conn.php"); 
	$pizza_name = $_POST['pizza_name'];
	$query3 = "DELETE FROM pizza_type WHERE pizza_name='".$_POST['pizza_name']."'";
	$result3 = $db->query($query3);
	$db->close();
}

if (isset($_POST['pizza_menu_name'])) // Delete pizza from menu
{
	include("includes/conn.php"); 
	$pizzaID = $_POST['pizza_menu_name'];
	$query3 = "DELETE FROM menu_items WHERE pizzaID='".$_POST['pizza_menu_name']."'";
	$result3 = $db->query($query3);
	$db->close();
}





?>

<!-- //******************************************************

// Name of File: menumanagement.php
// Revision: 1.0
// Date: 
// Author: Luke Spartalis
// Modified: Quintin Maseyk 03/05/2012

//***********************************************************

//*************** Start of CREATE PIZZA ******************* -->

<html>
<head>

<script type='text/javascript'>

function editRow(x, totalRows)
{
	// DISPLAY [this] ROW FROM TEXT -> EDITABLE
	document.getElementById(x+"_normal").style.display = 'none';
	document.getElementById(x+"_edit").style.display = 'block';
}
function saveRow(x)
{
	var answer = confirm("Please confirm new details");
	if (answer == true)
	{
		// SEND [this] FORM TO SERVER
		document.forms[x+"_form"].submit();
	}
}

function deleteRow(x)
{
	var answer = confirm("Are you sure you want to delete this row?");
	if (answer == true)
	{
		// SEND [this] FORM TO SERVER
		document.forms[x+"_form"].submit();
	}
}

function addtomenuRow(x)
{
	var answer = confirm("Are you sure you want add this row to the current menu?");
	if (answer == true)
	{
		// SEND [this] FORM TO SERVER
		document.forms[x+"_form"].submit();
	}
}

function deletefrommenuRow(x)
{
	var answer = confirm("Are you sure you want to delete this from the menu?");
	if (answer == true)
	{
		// SEND [this] FORM TO SERVER
		document.forms[x+"_form"].submit();
	}
}

</script>

</head>
<body>


<table rules='rows' cellpadding='5px'>
<caption>Pizza's</caption>
<th>
	<td>ID</td>
	<td>Pizza Name</td>
	<td>Description</td>
	<td>Price</td>
</th>



<?php 
	include("includes/conn.php"); 
	$query = "SELECT * FROM pizza_type";
	$result = $db->query($query);


/*for ($i=0; $i<$result->num_rows; $i++) // create a list of all pizza's in the database
{
	$row = $result->fetch_assoc();

	echo "</ br> <img src='images/buttons/add_60.png' alt='Add'/>" . " ";
	echo "<img src='images/buttons/edit_60.png' alt='Edit'/> </a>" . " " ;
	echo "<b>Pizza ID:</b> " . $pizzaID[] = $row['pizzaID'] . ", ";
	echo "<b>Pizza Name:</b> " . $pizza_name[] = $row['pizza_name'] . ", ";
	echo "<b>Description:</b> " . $description[] = $row['description'] . ", ";
	echo "<b>Price:</b> " . $price[] = $row['price'] . ", ";
	echo "<br /><br />";
}*/



for ($i=0; $i<$result->num_rows; $i++) // create a list of all pizza's in the database
{
	$row = $result->fetch_assoc();

	// [this] NORMAL ROW
	echo "<tr id='".$i."_normal'>";

		echo "<td>";
			echo "<img class='pointer' src='images/buttons/add_60.png' alt='Add' onclick='addtomenuRow(".$i.")' />";
			echo "<img class='pointer' src='images/buttons/edit_60.png' alt='Edit' onclick='editRow(".$i.", ".$result->num_rows.")' />";
			echo "<img src='images/buttons/delete_60.png' alt='Delete' onclick='deleteRow(".$i.")' />";
		echo "</td>";

		echo "<td>" . $row['pizzaID'] . "</td>";

		echo "<td>" . $row['pizza_name'] . "</td>";

		echo "<td>" . $row['description'] . "</td>";

		echo "<td>" . $row['price'] . "</td>";

	echo "</tr>";

	// [this] EDITABLE ROW
	// CREATE FORM FOR SUBMISSION
	echo "<form name='".$i."_form' method='POST' action='MANpizza.php' >";
	echo "<tr id='".$i."_edit' style='display: none;'>";
		
		echo "<td>";
			echo "<img src='images/buttons/add_60.png' alt='Add' />";
			echo "&nbsp;&nbsp;&nbsp;<img src='images/layers/tick.png' alt='Save' onclick='saveRow(".$i.")' />";
		echo "</td>";

		echo "<td>" . $row['pizzaID'] . "</td>";

		echo "<td><input type='text' name='pizza_name' id='pizza_name' value='".$row['pizza_name']."' /></td>";

		echo "<td><input type='text' name='description' id='description' value='".$row['description']."' /></td>";

		echo "<td><input type='text' name='price' id='price' value='".$row['price']."' size='5' maxlength='5' /></td>";
	echo "</tr>";
	echo "</form>";
}




?>
  

  <?php
	echo "<center>Current Pizza Menu </center>";

	$query1 = "SELECT menu_items.pizzaID, pizza_type.pizza_name FROM menu_items INNER JOIN pizza_type ON menu_items.pizzaID = pizza_type.pizzaID WHERE menuID = '1'";
	$result1 = $db->query($query1);
	
	for ($i=0; $i<$result1->num_rows; $i++) //create a list of pizza's currently on menu
	{
		$row1 = $result1->fetch_assoc();

		echo "<form name='".$i."_form' method='POST' action='MANpizza.php' >";
		echo "<tr id='".$i."_menu' style='display: none;'>";

		echo "<img src='images/buttons/delete_60.png' alt='Delete' onclick='deletefrommenuRow(".$i.")'/>";
		echo "<input type = 'hidden' name='pizza_menu_name' value='".$row1['pizzaID']."'/>";
		echo	" " . $pizzaID[] = $row1['pizzaID'] ;
		echo	" " . $pizza_name[] = $row1['pizza_name'] . "<br />";
		echo "</form>";
	}

	$db->close();
?>



</body>
</html>