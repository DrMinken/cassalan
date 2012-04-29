<!-- //******************************************************

// Name of File: deletepizza.php
// Revision: 1.0
// Date: 
// Author: Luke Spartalis
// Modified:

//***********************************************************

//*************** Start of DELETE PIZZA ******************* -->
<?php
include("includes/conn.php");


if (isset($_POST['pizza_name']))
{
	$pizza_name = $_POST['pizza_name'];
	$query2 = "DELETE FROM pizza_type WHERE pizza_name='".$_POST['pizza_name']."'";
	$result2 = $db->query($query2);
	$db->close();
}
?>



<?php 
$query1 = "SELECT pizza_name FROM pizza_type";

$result = $db->query($query1);

for ($i=0; $i<$result->num_rows; $i++) 
	{
		$row = $result->fetch_assoc();
		$pizza_name[] = $row['pizza_name']; // loop to run through result
	}


echo "<form action='deletepizza.php' method='post'>";
echo "<select name='pizza_name' size='1' id='selpizza_name'>";


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
