
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

	include("includes/conn.php"); 	


	$query = "SELECT * FROM pizza_type";
	$result = $db->query($query);

echo "<center> Pizzas </center>";

for ($i=0; $i<$result->num_rows; $i++)
  {
$row = $result->fetch_assoc();
  echo "</ br> <img src='images/buttons/add_60.png' alt='Add'/> " . "<img src='images/buttons/edit_60.png' alt='Edit'/> " . "<img src='images/buttons/delete_60.png' alt='Delete'/> " . " " ;
  echo "<b>Pizza ID:</b> " . $pizzaID[] = $row['pizzaID'] . ", ";
  echo "<b>Pizza Name:</b> " . $pizza_name[] = $row['pizza_name'] . ", ";
  echo "<b>Description:</b> " . $description[] = $row['description'] . ", ";
  echo "<b>Price:</b> " . $price[] = $row['price'] . ", ";
  echo "<br /><br />";
  }
  
  echo "<center>Current Pizza Menu </center>";

  $query1 = "SELECT menu_items.pizzaID, pizza_type.pizza_name FROM menu_items INNER JOIN pizza_type ON menu_items.pizzaID = pizza_type.pizzaID WHERE menuID ='1'";
  $result1 = $db->query($query1);
	for ($i=0; $i<$result1->num_rows; $i++)
	{
	$row1 = $result1->fetch_assoc();
	  echo  "<img src='images/buttons/delete_60.png' alt='Delete'/> ";
	  echo $pizzaID1[] = $row1['pizza_name'] . "<br />";
	}

  ?>

</body>
</html> 