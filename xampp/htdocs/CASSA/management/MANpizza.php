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
	include("../includes/template.php"); 				// Include the template page
	include("../includes/conn.php");					// Include database connection
	


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
		}

		if (($errors))
		{
			echo "<script type='text/javascript'> var answer = confirm('$errors')</script>"; 
		}
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

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type='text/javascript'>

function showCreate()
{
	// DISPLAY CREATE PIZZA FORM
	document.getElementById("createPizza").style.display = 'block';
}
function editRow(x)
{
	// DISPLAY [this] ROW FROM TEXT -> EDITABLE
	document.getElementById(x+"_normal").style.display = 'none';
	document.getElementById(x+"_edit").style.display = 'block';
}
function closeRow(x)
{
	// DISPLAY [this] ROW FROM TEXT -> EDITABLE
	document.getElementById(x+"_normal").style.display = 'block';
	document.getElementById(x+"_edit").style.display = 'none';
}
function saveRow(x)
{	
	var answer = confirm("Please confirm new details");
	if (answer == true)
	{
		// SEND [this] FORM TO SERVER
		document.forms["formSR_" + x].submit();
	}
}
function deleteRow(x)
{
	var answer = confirm("Are you sure you want to delete?");
	if (answer == true)
	{
		// SEND [this] FORM TO SERVER
		document.forms["formDEL_" + x].submit();
	}
}

function deletemenuRow(params)
{
	var answer = confirm("Are you sure you want to delete this item from the menu?");
	if (answer == true)
	{
		// SETUP FORM WITH INPUTS TO SEND TO SERVER

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
		xmlhttp.open("POST","selectPizza.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.setRequestHeader("Content-length", params.length);
		xmlhttp.setRequestHeader("Connection", "close");
		xmlhttp.send(params);
	}
}

function getRequest(params, action)
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

	var menuID = document.getElementById('currentMenu').value;

	//Now we have the xmlhttp object, get the data using AJAX.
	params = "menuID=" + menuID + "&pizzaID=" + params + "&action=" + action;		
	//alert(params);
	xmlhttp.open("POST","selectPizza.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(params);
}

</script>

</head>
<body onload="getRequest(document.getElementById('currentMenu').value)">
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Manage Pizza</h1><br /><br />







<table class='pizzaTable' border='0'>
<caption align='left'>Pizza List</caption>
<tr>
	<td width='140px' class='MANheader'>&nbsp;</td>
	<td width='200px' class='MANheader'>Pizza Name</td>
	<td width='300px' class='MANheader'>Description</td>
	<td width='80px' class='MANheader'>Price ($)</td>
</tr>


<?php 
	$query = "SELECT * FROM pizza_type";
	$result = $db->query($query);


for ($i=0; $i<$result->num_rows; $i++) // create a list of all pizza's in the database
{
	$row = $result->fetch_assoc();

	echo "<tr id='".$i."_normal'>";
		echo "<td>";
?>
		<!-- ADD PIZZA TO 'current menu' -->
		<img class="pointer button" 
			 src="../images/buttons/add.png" 
			 alt="Add" 
			 onclick="getRequest('<?php echo $row['pizzaID']; ?>', 'add')" />

		<!-- CLICK TO MAKE THIS ROW EDITABLE -->
		<img class='pointer button' 
			 src='../images/buttons/edit_LSM.png' 
			 alt='Edit' 
			 onclick='editRow("<?php echo $i; ?>")' />
		
		<!-- DELETE PIZZA ENTIRELY -->
		<img class='pointer button'
			 src='../images/buttons/delete.png' 
			 alt='Delete' 
			 onclick='deletemenuRow("pizzaID=<?php echo $row['pizzaID']; ?>&action=deletePizzaType")' />
<?php
		echo "</td>";
		echo "<td>"	. $row['pizza_name']."</td>";
		echo "<td>" . $row['description'] . "</td>";
		echo "<td>" . $row['price'] . "</td>";
	echo "</tr>";



	// [this] EDITABLE ROW
	// CREATE FORM FOR SUBMISSION
	echo "<tr id='".$i."_edit' style='display: none;'>";
		echo "<form name='formSR_".$i."' method='POST' action='MANpizza.php' >";
		echo "<td>";
?>
		<img class='pointer button'
			 src='../images/buttons/save.png' 
			 alt='Save' 
			 onclick='saveRow("<?php echo $i; ?>")' />

		<img class='pointer button'
			 src='../images/buttons/cross.png' 
			 alt='Cancel' 
			 onclick='closeRow("<?php echo $i; ?>")' />

<?php
		echo "<input type='hidden' name='pizzaIDedit' id='pizzaIDedit' value='".$row['pizzaID']."' />";
		echo "</td>";

		echo "<td><input type='text' name='pizza_name' id='pizza_name' value='".$row['pizza_name']."' size='28' /></td>";
		echo "<td><input type='text' name='description' id='description' value='".$row['description']."' size='45' /></td>";
		echo "<td><input type='text' name='price' id='price' value='".$row['price']."' size='5' maxlength='5' /></td>";
	echo "</tr>";
	echo "</form>";
}
?>
</table>

<!-- img class='pointer button'
	 src='../images/buttons/save.png' 
	 alt='Create a new pizza' 
	 onclick='showCreate()' / -->





<br/><hr /><br />






<!-- DISPLAY CURRENT MENU -->
<?php
	// GET EVENT WHERE EVENT IS NEXT TO START
	$get = "SELECT * FROM event WHERE event_completed=0 ORDER BY eventDate ASC";
	$result = $db->query($get);
	$row = $result->fetch_assoc();
	$eventID = $row['eventID'];

	// GET [this] EVENTS MENU
	$query = "SELECT * FROM pizza_menu WHERE eventID='".$eventID."'";
	$result = $db->query($query);
	$row = $result->fetch_assoc();

	echo "<h2 align='center'>Current Menu: <font size='2'>".$row['menu_name']."</font></h2>";
	echo "<input type='hidden' name='currentMenu' id='currentMenu' value='".$row['menuID']."' />";
	/*
	<select name="currentMenu" id="currentMenu" onchange="getRequest(this.value)">
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
	<select>
	*/
?>






<!-- DISPLAY AJAX: [this] PIZZA MENU -->
<div id='pizza_menuTable' style='clear: right;'></div>









<?php

// Validation
	if (isset($_POST['pizza_nameC'] , $_POST['descriptionC'] , $_POST['priceC']))
	{
		$errors = array();

		$pizza_name = $_POST['pizza_nameC'];
		$description = $_POST['descriptionC'];
		$price = $_POST['priceC'];


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
	

			// INSERT NEW PIZZA
			$query = "INSERT INTO pizza_type (pizza_name, description, price) VALUES ('".$_POST['pizza_nameC']."', '".$_POST['descriptionC']."', '".$_POST['priceC']."')";
			$result = $db->query($query);
			$db->close();
		}
	}

?>





<div id='createPizza' style='display: none;' >
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
		<input type="text" name="pizza_nameC" maxlength="32" size="32" /><br /><br />
		
		Pizza Description:<br />
		<input type="text" name="descriptionC" maxlength="128" size="32" /><br /><br />
		
		Pizza Price:<br />
		<input type="text" name="priceC" maxlength="4" size="4" /><br /><br />
	
		<input type="submit" name="submit" value="Add Pizza" />
	</form> 
</div>





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