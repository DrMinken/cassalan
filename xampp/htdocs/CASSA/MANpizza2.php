<?php 
	session_start();
	//$_SESSION['pizzaID'];
	//$_SESSION['prevPage'];
	

	print_r($_POST);
	

if (isset($_POST['pizza_nameA'])) // Delete pizza from database
{
echo "good work pizza delete";
}

if (isset($_POST['pizza_nameSR'])) // Delete pizza from menu
{
echo "good work update completed";
}

if (isset($_POST['pizzaID1'])) // Delete pizza from menu
{
	include("includes/conn.php"); 
	echo "done";
	$pizzaID = $_POST['pizzaID1'];
	$query3 = "DELETE FROM menu_items WHERE pizzaID='".$_POST['pizzaID1']."'";
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
		document.forms[x+"_formSR"].submit();
	}
}
function deleteRow(x)
{
	var answer = confirm("Are you sure you want to delete?");
	if (answer == true)
	{
		// SEND [this] FORM TO SERVER
		document.forms[x+"_formA"].submit();
	}
}
function deletemenuRow(x)
{
	var answer = confirm("Are you sure you want to delete this item from the menu?");
	if (answer == true)
	{
		// SEND [this] FORM TO SERVER
		document.forms[x+"_form1"].submit();
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


for ($i=0; $i<$result->num_rows; $i++) // create a list of all pizza's in the database
{
	$row = $result->fetch_assoc();



	// [this] NORMAL ROW
	echo "<tr id='".$i."_normal'>";

		echo "<td>";
			echo "<img class='pointer' src='images/buttons/add_60.png' alt='Add' onclick='addtomenuRow(".$i.")' />";
			echo "<img class='pointer' src='images/buttons/edit_60.png' alt='Edit' onclick='editRow(".$i.", ".$result->num_rows.")' />";

		echo "</td>";


		echo "<td>" . $row['pizzaID'] . "</td>";
		echo "<td>"	. $row['pizza_name']."</td>";
		echo "<td>" . $row['description'] . "</td>";
		echo "<td>" . $row['price'] . "</td>";


	echo "</tr>";

	// [this] EDITABLE ROW
	// CREATE FORM FOR SUBMISSION
	echo "<tr id='".$i."_edit' style='display: none;'>";
		
		echo "<td>";
			echo "<form name='".$i."_formSR' method='POST' action='MANpizza2.php' >";
			echo "&nbsp;&nbsp;&nbsp;<img src='images/layers/tick.png' alt='Save' onclick='saveRow(".$i.")' />";
			echo "<td><input type='text' name='pizza_nameSR' id='pizza_nameSR' value='".$row['pizza_name']."' /></td>";
			echo "</form>";

			echo "<form name='".$i."_formA' method='POST' action='MANpizza2.php' >";
			echo "<img src='images/buttons/delete_60.png' alt='Delete' onclick='deleteRow(".$i.")' />";
			echo "<td><input type='text' name='pizza_nameA' id='pizza_nameA' value='".$row['pizza_name']."' /></td>";
			echo "</form>";


		echo "</td>";

		echo "<td>" . $row['pizzaID'] . "</td>";
		echo "<td><input type='text' name='pizza_name' id='pizza_name' value='".$row['pizza_name']."' /></td>";
		echo "<td><input type='text' name='description' id='description' value='".$row['description']."' /></td>";
		echo "<td><input type='text' name='price' id='price' value='".$row['price']."' size='5' maxlength='5' /></td>";
	echo "</tr>";
}
	$db->close();
?>

<?php
	echo "<center>Current Pizza Menu </center>";
include("includes/conn.php"); 
	$query1 = "SELECT * FROM menu_items";
	$result1 = $db->query($query1);


for ($i=0; $i<$result1->num_rows; $i++) // create a list of all pizza's in the database
{
	$row1 = $result1->fetch_assoc();




			echo "<form name='".$i."_form1' method='POST' action='MANpizza2.php' >";
			echo "<img class='pointer' src='images/buttons/delete_60.png' alt='Delete' onclick='deletemenuRow(".$i.")' />";
			echo $row1['pizzaID'];
			echo "<input type='hidden' name='pizzaID1' id='pizzaID1' value='".$row1['pizzaID']."' /><br />";
			echo "</form>";

	


}

	$db->close();
?>

</body>
</html>

