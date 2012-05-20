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

	$_SESSION['title'] = "Manage Pizzas | MegaLAN";		// Declare this page's Title
	include("../includes/template.php"); 					// Include the template page
	include("../includes/conn.php"); 
	

	if (isset($_POST['pizza_nameDEL'])) // Delete pizza from database
	{
		echo "done";
		$pizza_name = $_POST['pizza_nameDEL'];
		$query3 = "DELETE FROM pizza_type WHERE pizza_name='".$_POST['pizza_nameDEL']."'";
		$result3 = $db->query($query3);
	}

    if(isset($_POST['pizzaIDADD'])  && isset($_POST['menuID']) ) // add pizza to menu
	{
		echo "done";
		$pizzaID = $_POST['pizzaIDADD'];
		$menuID = $_POST['menuID'];
		$query3 = "INSERT INTO menu_items (menuID, pizzaID) VALUES ('".$_POST['menuID']."' , '".$_POST['pizzaIDADD']."')"; // still needs doing.

		$result3 = $db->query($query3);
	}

	if (isset($_POST['pizzaIDedit'])) // Update menu
	{
		$pizzaID = $_POST['pizzaIDedit'];
		$pizza_name = $_POST['pizza_name'];
		$description = $_POST['description'];
		$price = $_POST['price'];

		$errors = array();


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
		$query4 = "UPDATE pizza_type SET pizza_name='".$_POST['pizza_name']."', description='".$_POST['description']."', price='".$_POST['price']."' WHERE pizzaID='".$_POST['pizzaIDedit']."'";
		$result4 = $db->query($query4);
		echo "update completed.";
		}

		if (($errors))
		{
			echo "<script type='text/javascript'> var answer = confirm('$errors')</script>"; 
		}




	}

	if (isset($_POST['menuID']) && isset($_POST['pizzaID'])) // Delete pizza from menu
	{
		$query = "DELETE FROM menu_items WHERE pizzaID='".$_POST['pizzaID']."' AND menuID='".$_POST['menuID']."'";
		$result = $db->query($query);
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
		document.forms["formSR"].submit();
	}
}
function deleteRow(x)
{
	var answer = confirm("Are you sure you want to delete?");
	if (answer == true)
	{
		// SEND [this] FORM TO SERVER
		document.forms["formDEL"].submit();
	}
}

function deletemenuRow(menuID, pizzaID)
{
	var answer = confirm("Are you sure you want to delete this item from the menu?");
	if (answer == true)
	{
		// SETUP FORM WITH INPUTS TO SEND TO SERVER
		document.deletePizzaFromMenu['menuID'].value = menuID;
		document.deletePizzaFromMenu['pizzaID'].value = pizzaID;

		// SEND [this] FORM TO SERVER
		document.forms['deletePizzaFromMenu'].submit();
	}
}

function addtomenuRow(x)
{
	var answer = confirm("Are you sure you want to add this item from the menu?");
	if (answer == true)
	{
		// SETUP FORM WITH INPUTS TO SEND TO SERVER
		document.formADD['menuID'].value = menuID;
		document.formADD['pizzaID'].value = pizzaID;

		// SEND [this] FORM TO SERVER
		document.forms['fromADD'].submit();
	}
}

function getMenuID(menuID)
{
	if (window.XMLHttpRequest)
	{	
		// code for mainstream browsers
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		// code for earlier IE versions
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("pizza_menuTable").innerHTML=xmlhttp.responseText;
		}
	}
	//Now we have the xmlhttp object, get the data using AJAX.
	var params = "menuID=" + menuID;		
	xmlhttp.open("POST","selectPizza.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(params);
}

</script>

</head>
<body onload="getMenuID(document.getElementById('currentMenu').value)">
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Manage Pizza</h1><br /><br />







<table rules='rows' cellpadding='5px'>
<caption align='left'>Pizza's</caption>
<th>
	<td>ID</td>
	<td>Pizza Name</td>
	<td>Description</td>
	<td>Price</td>
</th>



<?php 
	$query = "SELECT * FROM pizza_type";
	$result = $db->query($query);


for ($i=0; $i<$result->num_rows; $i++) // create a list of all pizza's in the database
{
	$row = $result->fetch_assoc();


	// [this] NORMAL ROW
	echo "<tr id='".$i."_normal'>";

		echo "<td>";
		echo "<form name='formADD' method='POST' action='MANpizza.php' >"; // add pizza to menu
		echo "<img class='pointer' src='../images/buttons/add_60.png' alt='Add' onclick='addtomenuRow(".$i.")' />"; 
		echo "<input type='hidden' name='pizzaIDADD' id='pizzaIDADD' value='' />";
		echo "<input type='hidden' name='menuID' id='menuID' value='' />";
		echo "</form>";

		echo "<img class='pointer' src='../images/buttons/edit_60.png' alt='Edit' onclick='editRow(".$i.", ".$result->num_rows.")' />"; // unhide rows
		echo "<form name='formDEL' method='POST' action='MANpizza.php' >"; // delete pizza from database
		echo "<img src='../images/buttons/delete_60.png' alt='Delete' onclick='deleteRow(".$i.")' />";
		echo "<input type='hidden' name='pizza_nameDEL' id='pizza_nameDEL' value='".$row['pizza_name']."' />";
		echo "</form>";

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
			echo "<form name='formSR' method='POST' action='MANpizza.php' >";
			echo "&nbsp;&nbsp;&nbsp;<img src='../images/layers/tick.png' alt='Save' onclick='saveRow(".$i.")' />";
			echo "<td><input type='hidden' name='pizzaIDedit' id='pizzaIDedit' value='".$row['pizzaID']."' /></td>";
			echo "</td>";

			echo "<td>" . $row['pizzaID'] . "</td>";
			echo "<td><input type='text' name='pizza_name' id='pizza_name' value='".$row['pizza_name']."' /></td>";
			echo "<td><input type='text' name='description' id='description' value='".$row['description']."' /></td>";
			echo "<td><input type='text' name='price' id='price' value='".$row['price']."' size='5' maxlength='5' /></td>";
			echo "</tr>";
			echo "</form>";
}
?>
</table>




<br/><hr /><br />




<!-- DISPLAY CURRENT MENU -->
<div>
<h2>Current Menu</h2>
<br />

	<div style='float: left;'>
		<select size="6" name="currentMenu" id="currentMenu" onchange="getMenuID(this.value)">
		<?php
			$query = "SELECT * FROM pizza_menu";
			$result = $db->query($query);

			for ($i=0; $i<$result->num_rows; $i++) 
			{	
				// Now we can output the option fields to populate the list box
				$row = $result->fetch_assoc();
				
				if ($i==0)
				{
					echo '<option value="'.$row['menuID'].'" selected="selected">' .$row['menu_name']. '</option>';
				}
				else
				{
					echo '<option value="'.$row['menuID'].'">' .$row['menu_name']. '</option>';
				}
			}
		?>
		<select>
	</div>

	<!-- DISPLAY AJAX: [this] PIZZA MENU -->
	<div id='pizza_menuTable' style='clear: right;'></div>
</div>


<form name='deletePizzaFromMenu' method='POST' action='MANpizza.php'>
<input type='hidden' name='menuID' id='menuID' value='' />
<input type='hidden' name='pizzaID' id='pizzaID' value='' />
</form>









<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->
<!-- ********************************* -->

</div><!-- end of: Content -->


<!-- INSERT: rightPanel -->
<?php include('../includes/rightPanel.html'); ?>


<!-- INSERT: footer -->
<div id="footer">
	<?php include('../includes/footer.html'); ?>
</div>


</div><!-- end of: Shell -->

</center>
</body>
</html>

<!-- ********************************* -->
<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->