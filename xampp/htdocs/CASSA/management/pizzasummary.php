<?php
	session_start();									// Start/resume THIS session
	$_SESSION['title'] = "Pizza Summary | MegaLAN"; 	// Declare this page's Title
	include("../includes/template.php"); 				// Include the template page
	include("../includes/conn.php");					// Inlcude DB connection
?>


<!-- //******************************************************

// Name of File:
// Revision: 1.0
// Date: 
// Author: 
// Modified: 

//***********************************************************
//*************** Start of PIZZA SUMMARY ******************* -->


<html>
<head></head>
<body>
<center>
<div id='shell'>


<!-- Main Content [left] -->
<div id="content">


<div id='summaryPizza'>
<?php 
	// GET EVENT WHERE EVENT IS NEXT TO START
	$get = "SELECT * FROM event WHERE event_completed=0 ORDER BY eventDate ASC";
	$result = $db->query($get);
	$row = $result->fetch_assoc();
	$eventID = $row['eventID'];


	// GET [this] EVENTS MENU
	$getmenuID = "SELECT * FROM pizza_menu WHERE eventID='".$eventID."'";
	$result = $db->query($getmenuID);
	$row = $result->fetch_assoc();
	$menuID = $row['menuID'];


	// GET [this] EVENTS MENU PIZZA ORDER SUMMARY
	$getpizzaID = "SELECT DISTINCT pizzaID FROM pizza_order WHERE menuID='".$menuID."' ORDER BY pizzaID ASC";
	$result = $db->query($getpizzaID);


	// FOR EVERY 'DISTINCT' PIZZA TYPE, FETCH THE SUM OF EACH
	for ($i=0; $i<$result->num_rows; $i++) 
	{
		$row = $result->fetch_assoc();
		$thisPizza = $row['pizzaID'];
		
		// GET THE SUM OF [this] PIZZA TYPE
		$sum = "SELECT sum(quantity) as pizzaSum FROM pizza_order WHERE pizzaID='".$thisPizza."'";
		$resultSum = $db->query($sum);
		$rowSum = $resultSum->fetch_assoc();

		// [this] PIZZA TYPE
		$pizzaID[$i] = $thisPizza;

		// [this] PIZZA TYPE's QUANTITY
		$pizzaSum[$i] = $rowSum['pizzaSum'];
	}
?>

<table class='pizzaOrder'>
<tr>
	<td class='MANheader'>Name</td>
	<td class='MANheader'>QTY</td>
	<td class='MANheader'>Price ($)</td>
	<td class='MANheader'>Total</td>
</tr>
<?php
	$grandTotal = 0;
	// DISPLAY SUM FOR THIS ORDER
	for ($i=0 ; $i<sizeof($pizzaID); $i++)
	{
		// GET [this] PIZZA's NAME
		$get = "SELECT `pizza_name` FROM pizza_type WHERE pizzaID='".$pizzaID[$i]."'";
		$result = $db->query($get);
		$row = $result->fetch_assoc();
		$pizzaName = $row['pizza_name'];
		
		
		// GET [this] PIZZA's PRICE
		$get = "SELECT `price` FROM pizza_type WHERE pizzaID='".$pizzaID[$i]."'";
		$result = $db->query($get);
		$row = $result->fetch_assoc();
		$price = $row['price'];
		$total = $pizzaSum[$i] * $price;
		$grandTotal = $grandTotal + $total;

		echo '<tr>';
		echo '<td>'.ucwords($pizzaName).'</td>';
		echo '<td>'.$pizzaSum[$i].'</td>';
		echo '<td>'.$price.'</td>';
		echo '<td>'.$total.'</td>';
		echo '</tr>';
	}
	echo '<tr><td colspan="4"><hr /></td></tr>';
	echo '<tr><td colspan="4">Grand Total: $'.$grandTotal.'</td></tr>';
?>
</table>
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