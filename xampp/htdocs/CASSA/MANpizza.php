<!-- //******************************************************

// Name of File: menumanagement.php
// Revision: 1.0
// Date: 
// Author: Luke Spartalis
// Modified:

//***********************************************************

//*************** Start of CREATE PIZZA ******************* -->



<html>
<body>

<?php 
	session_start();
	//$_SESSION['pizzaID'];
	//$_SESSION['prevPage'];
	
?>

<?php
if (isset($_POST['pizzaID'])) // Delete pizza from menu
{
	include("includes/conn.php"); 
	$pizzaID = $_POST['pizzaID'];
	$query3 = "DELETE FROM menu_items WHERE pizzaID='".$_POST['pizzaID']."'";
	$result3 = $db->query($query3);
	$db->close();
	echo "Thanks";
}
?>



<?php 
	include("includes/conn.php"); 
	$query = "SELECT * FROM pizza_type";
	$result = $db->query($query);

echo "<center> Pizzas </center>";

for ($i=0; $i<$result->num_rows; $i++) // create a list of all pizza's in the database
  {
$row = $result->fetch_assoc();
  echo "</ br> <img src='images/buttons/add_60.png' alt='Add'/>" . " ";
  echo "<img src='images/buttons/edit_60.png' alt='Edit'/> </a>" . " " ;
  echo "<b>Pizza ID:</b> " . $pizzaID[] = $row['pizzaID'] . ", ";
  echo "<b>Pizza Name:</b> " . $pizza_name[] = $row['pizza_name'] . ", ";
  echo "<b>Description:</b> " . $description[] = $row['description'] . ", ";
  echo "<b>Price:</b> " . $price[] = $row['price'] . ", ";
  echo "<br /><br />";
  }

 ?>
  

  <?php
  echo "<center>Current Pizza Menu </center>";

  $query1 = "SELECT menu_items.pizzaID, pizza_type.pizza_name FROM menu_items INNER JOIN pizza_type ON menu_items.pizzaID = pizza_type.pizzaID WHERE menuID ='1'";
  $result1 = $db->query($query1);
	for ($i=0; $i<$result1->num_rows; $i++) //create a list of pizza's currently on menu
	{
	$row1 = $result1->fetch_assoc();
	  echo  "<head> <img src='images/buttons/delete_60.png' alt='Delete' onclick='del(document.getElementById('rowID').value)' /> </head>";
	  echo	" " . $pizzaID[] = $row1['pizzaID'] ;
	  echo	" " . $pizza_name[] = $row1['pizza_name'] . "<br />";

	}

	$db->close();
?>


<form action="menumanagement.php" method="post">
Pizza ID:<br /> <input type="text" name="pizzaID" /><br />
<br /> <input type="submit" />
</form> 



</body>
</html>