<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 

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
?>

<!-- //******************************************************

// Name of File: menumanagement.php
// Revision: 1.0
// Date: 
// Author: Luke Spartalis
// Modified: Quintin Maseyk 03/05/2012

//***********************************************************

//*************** Start of CREATE PIZZA ******************* -->

<head>

<script type='text/javascript'>
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
function updateRow(index, message)
{
	var answer = confirm(message);
	if (answer == true)
	{
		// SETUP FORM WITH INPUTS TO SEND TO SERVER
		var id = document.getElementById('pizzaID_'+index).value;
		var name = document.getElementById('pizza_name_'+index).value;
		var description = document.getElementById('description_'+index).value;
		var price = document.getElementById('price_'+index).value;
		var params = "i="+id+"&name="+name+"&description="+description+"&price="+price+"&action=updateRow";

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
function makeRequest(params, message)
{
	var answer = confirm(message);
	if (answer == true)
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


function createPizza()
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

	// GET FORM OBJECTS
	var name = document.getElementById('new_pizza_name').value;
	var description = document.getElementById('new_description').value;
	var price = document.getElementById('new_price').value;


	//Now we have the xmlhttp object, get the data using AJAX.
	params = "name=" + name + "&description=" + description + "&price=" + price + "&action=createPizza";		
	xmlhttp.open("POST","selectPizza.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(params);
	parent.jQuery.colorbox.close();
}
$(document).ajaxStop(function(){
	window.location.reload();
});

$(document).ready(function(){
	$(".inline").colorbox({inline:true, width:"300px", height:"350px"});
	$(".inlineB").colorbox({inline:true, width:"700px", height:"900px"});
});
</script>

</head>
<body onload="getRequest(document.getElementById('currentMenu').value)">
<center>
<div id='shell'>





<!-- Main Content [left] -->
<div id="content">





<!-- Check for errors and print out message -->
<?php	
	if (isset($_SESSION['errMsg']))
	{
		echo $_SESSION['errMsg'];
		unset($_SESSION['errMsg']);
	}
?>





<!-- HREF : OPENS INLINE 'CREATE NEW PIZZA' FORM -->
<a class='inline' href='#createPizza'>Create new pizza</a>





<!-- DISPLAY CURRENT MENU -->
<?php
	// GET EVENT WHERE EVENT IS NEXT TO START
	$get = "SELECT * FROM event WHERE event_completed=0 ORDER BY startDate ASC";
	$result = $db->query($get);
	$row = $result->fetch_assoc();
	$eventID = $row['eventID'];

	// GET [this] EVENTS MENU
	$query = "SELECT * FROM pizza_menu WHERE eventID='".$eventID."'";
	$result = $db->query($query);
	$row = $result->fetch_assoc();

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





<!-- CREATE A NEW PIZZA FORM -->
<div style='display: none;'>
	<div id='createPizza'>
	<h3>Create a new pizza</h3>


	<br /><br />


		Pizza Name:<br />
		<input type="text" name="new_pizza_name" id="new_pizza_name" maxlength="32" size="32" />
		<br /><br />
		
		Description:<br />
		<input type="text" name="new_description" id="new_description" maxlength="128" size="32" />
		<br /><br />
		
		Price $:<br />
		<input type="text" name="new_price" id="new_price" maxlength="5" size="5" />
		<br /><br />
	
		<input type="button" name="submit" value="Add Pizza" onclick="createPizza()" />
	</div>
</div>





<br /><br/><hr /><br /><br />





<div id='orderSummaryDIV'>
<a class='inlineB' href='#summaryPizza'>
<img class='pointer' border='0'
	 src='../images/layers/form.png' alt='Click here to see pizza order summary' 
	 onclick='window.location.href="pizzaSummary.php"' />
	 
	 Click here to view this events order summary</a>
</div>





<div style='display: none;'>
	<div id='summaryPizza'>
	<br />
	<?php 
		// GET EVENT WHERE EVENT IS NEXT TO START
		$get = "SELECT * FROM event WHERE event_completed=0 ORDER BY startDate ASC";
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
		<td class='MANheader' width='300px'>Name</td>
		<td class='MANheader' width='120px'>QTY</td>
		<td class='MANheader' width='120px'>Price ($)</td>
		<td class='MANheader' width='140px'>Total ($)</td>
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
		echo '<tr><td colspan="4" align="right">GRAND TOTAL: $'.$grandTotal.'</td></tr>';
	?>
	</table>
	</div>
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