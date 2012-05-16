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
	

	print_r($_POST);


	if (isset($_POST['pizza_nameDEL'])) // Delete pizza from database
	{
		echo "done";
		$pizza_name = $_POST['pizza_nameDEL'];
		$query3 = "DELETE FROM pizza_type WHERE pizza_name='".$_POST['pizza_nameDEL']."'";
		$result3 = $db->query($query3);
	}

    if(isset($_POST['pizzaIDADD'])) // add pizza to menu
	{
		echo "done";
		$pizzaID = $_POST['pizzaIDADD'];
		$menuID = $POST_['selectMenu'];
		$query3 = "INSERT INTO menu_items (menuID, pizzaID) VALUES ('".$_POST['selectMenu']."' , '".$_POST['pizzaIDADD']."')"; // still needs doing.

		$result3 = $db->query($query3);
	}

	if (isset($_POST['pizzaIDedit'])) // Update menu
	{
		$pizzaID = $_POST['pizzaIDedit'];
		$pizza_name = $_POST['pizza_name'];
		$description = $_POST['description'];
		$price = $_POST['price'];

		$query4 = "UPDATE pizza_type SET pizza_name='".$_POST['pizza_name']."', description='".$_POST['description']."', price='".$_POST['price']."' WHERE pizzaID='".$_POST['pizzaIDedit']."'";
		$result4 = $db->query($query4);
		echo "update completed.";
	}

	if (isset($_POST['pizzaID1'])) // Delete pizza from menu
	{
		echo "done";
		$pizzaID = $_POST['pizzaID1'];
		$query3 = "DELETE FROM menu_items WHERE pizzaID='".$_POST['pizzaID1']."' AND menuID='".$_POST['menuID']."'  ";
		$result3 = $db->query($query3);
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
		document.forms["f"+x+"_formSR"].submit();
	}
}
function deleteRow(x)
{
	var answer = confirm("Are you sure you want to delete?");
	if (answer == true)
	{
		// SEND [this] FORM TO SERVER
		document.forms[x+"_formDEL"].submit();
	}
}

function deletemenuRow(x)
{
	var answer = confirm("Are you sure you want to delete this item from the menu?");
	if (answer == true)
	{
		// SEND [this] FORM TO SERVER
		document.forms[x+"_formDELmenu"].submit();
	}
}

function addtomenuRow(x)
{
	var answer = confirm("Are you sure you want to add this item from the menu?");
	if (answer == true)
	{
		// SEND [this] FORM TO SERVER
		document.forms["f"+x+"_formADD"].submit();
	}
}

function getMenuID(menuID)
{
if (menuID=="")
  {
  document.getElementById("pizza_menuTable").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("pizza_menuTable").innerHTML=xmlhttp.responseText;
    }
  }


xmlhttp.open("POST","MANpizza.php",true);
xmlhttp.send();
}

</script>

</head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Manage Pizza</h1>







<table rules='rows' cellpadding='5px'>
<caption>Pizza's</caption>
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
		echo "<form name='f".$i."_formADD' method='POST' action='MANpizza.php' >"; // add pizza to menu
		echo "<img class='pointer' src='../images/buttons/add_60.png' alt='Add' onclick='addtomenuRow(".$i.")' />"; 
		echo "<input type='hidden' name='pizzaIDADD' id='pizzaIDADD' value='".$row['pizzaID']."' />";
		echo "</form>";

		echo "<img class='pointer' src='../images/buttons/edit_60.png' alt='Edit' onclick='editRow(".$i.", ".$result->num_rows.")' />"; // unhide rows
		echo "<form name='".$i."_formDEL' method='POST' action='MANpizza.php' >"; // delete pizza from database
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
			echo "<form name='f".$i."_formSR' method='POST' action='MANpizza.php' >";
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


<?php
	$query5 = "SELECT * FROM pizza_menu";
	$result5 = $db->query($query5);

echo '<hr />';
echo '<p><h2>Current Menu</h2></p>';
echo '<FORM>';
echo '<P>';
echo '<SELECT size="6" name="selectMenu" onchange = getMenuID(this.value)>';

// Now we can output the option fields to populate the list box.
for ($i = 0; $i < $result5->num_rows;$i++) 
	{
		$row5 = $result5->fetch_array(MYSQLI_BOTH);    
    echo '<OPTION value="' . $row5['menuID']. '">' . $row5['menu_name'] . '</OPTION><br />';
	}

		echo '</SELECT>';
			echo '<br />';
   		echo '<INPUT type="submit" value="Send">';
   			echo '</P>';
				echo '</FORM>';
						echo '<hr />';
?>

	<?php 
	$query1 = "SELECT * FROM menu_items WHERE menuID='".$_POST['selectMenu']."'";
	$result1 = $db->query($query1);

for ($i=0; $i<$result1->num_rows; $i++) // create a list of all pizza's in the database
{
	$row1 = $result1->fetch_assoc();

			echo "<form name='".$i."_formDELmenu' method='POST' action='MANpizza.php' >";
			echo "<img class='pointer' src='../images/buttons/delete_60.png' alt='Delete' onclick='deletemenuRow(".$i.")' />";
			echo $row1['pizzaID'];
			echo "<input type='hidden' name='pizzaID1' id='pizzaID1' value='".$row1['pizzaID']."' /><br />";
			echo "</form>";
}

$db->close();
?>


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