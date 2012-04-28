<!-- //******************************************************

// Name of File: deletepizza.php
// Revision: 1.0
// Date: 
// Author: Luke Spartalis
// Modified:

//***********************************************************

//*************** Start of DELETE PIZZA ******************* -->


<?php
if (isset($_POST['pizza_name']))
{

	$pizza_name = $_POST['pizza_name'];
	
	include("includes/conn.php"); 

	$query = "DELETE FROM pizza_type WHERE pizza_name='".$_POST['pizza_name']."';





}	

?>




<?php



$result = "SELECT pizza_name FROM pizza_type";

while ($row = mysql_fetch_array($result)) 
	{
	$pizza_name[] = $row['pizza_name']; // loop to run through result
	}


<form action="deletepizza.php" method="post">
<select name="pizza_name" size="1" id="selpizza_name">





$option = "<option value=\"Please select a Pizza\">Please select a Pizza</option> \n";
for ($i = 0; $i < count($pizza_name); $i++) {
$option .= "<option ";
$option .= "value=\"$pizza_name[$i]\">$pizza_name[$i]</option> \n";

}

echo $option;

$db->close();



?>
<br /> <input type="submit" />
</form>

</select>
</body>
</html>
