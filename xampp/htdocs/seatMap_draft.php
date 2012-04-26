<?php

// DUMMY ARRAY CONTAINING BOOKED SEATS
$seat = array(
	array('number' => 1, 'status' => 'free',	  'name' => ''),
	array('number' => 2, 'status' => 'free',	  'name' => ''),
	array('number' => 3, 'status' => 'booked',	  'name' => 'Trever Clever'),
	array('number' => 4, 'status' => 'reserved',  'name' => 'Team: Shoot'),
	array('number' => 5, 'status' => 'reserved',  'name' => 'Team: Shoot'),
	array('number' => 6, 'status' => 'free',	  'name' => ''),
	array('number' => 7, 'status' => 'booked',    'name' => 'Ben Chen'),
	array('number' => 8, 'status' => 'free',	  'name' => ''),
	array('number' => 9, 'status' => 'free',	  'name' => ''),
	array('number' => 10, 'status' => 'booked',   'name' => 'Glen Hen'),
	array('number' => 11, 'status' => 'free',	  'name' => ''),
	array('number' => 12, 'status' => 'free',	  'name' => ''),
	array('number' => 12, 'status' => 'reserved', 'name' => 'Team: Loke')
);


if (isset($_GET['s']))
{
	$seat[$_GET['s']]['status'] = 'booked';
	$seat[$_GET['s']]['name'] = $_GET['n'];
}

?>


<html>
<head>
	<title>Seat Map</title>

<style type='text/css'>
.cursor
{
	cursor: pointer;
}


#legend
{
	position: relative;
	left: 400px;
	top: 200px;
}
.seatNumberTop
{
	font-family: arial;
	font-size: 20pt;
	position: relative;
	z-index: 1;
	top: -10px;
}
.seatNumberBot
{
	font-family: arial;
	font-size: 20pt;
	position: relative;
	z-index: 1;
	top: 10px;
}

</style>

<script type='text/javascript'>
function bookSeat(x)
{
	var answer = confirm('Please confirm to book SEAT# ' + x)
	if (answer == true)
	{
		var name = prompt("Please enter your booking name");
		
		window.location.href='seatMap.php?s='+x+'&n='+name;
	}
}
</script>

</head>
<body>
<center>


<table id='legend' border='0' style='border-collapse: collapse' rules='rows' cellspacing='3px'>
	<tr><td width='20px' style='background-color: red'>&nbsp;</td><td width='90px'>Booked</td></tr>
	<tr><td width='20px' style='background-color: green'>&nbsp;</td><td width='90px'>Free</td></tr>
	<tr><td width='20px' style='background-color: brown'>&nbsp;</td><td width='90px'>Reserved</td></tr>
</table>




<table id='seatArray' border='0'>
<tr>
<?php 
/*
 *
	POPULATE SEATING PLAN (6x2)
 *
*/

$row = 0; // 0 = top row / 1 = bottom row
for ($i=1; $i<13; $i++)
{

	// POPULATE TOP ROW
	if ($row == 0)
	{
		// IF COLUMN IS 6
		if ($i == 6)
		{?>
			<td class='tdOneSeat' align='center' id='<?php echo $i; ?>'>

				<!-- SEAT SHELL [contains: Seat Number + Image] -->
				<div id='divOneSeat'>
					<!-- SEAT NUMBER -->
					<div class='seatNumberTop'><?php echo $i; ?></div>

					<!-- SEAT IMAGE -->	
					<?php 
					if ($seat[$i]['status'] == 'booked')
					{
						?><img src='image/oneSeatTop_red.png' 
							onmouseover='document.getElementById("bookedName").value="<?php echo $seat[$i]['name']; ?>"'
							onmouseout='document.getElementById("bookedName").value=""'
							/>
						<?php 
					}
					else if ($seat[$i]['status'] == 'reserved')
					{
						?><img src='image/oneSeatTop_brown.png' 
							onmouseover='document.getElementById("bookedName").value="<?php echo $seat[$i]['name']; ?>"'
							onmouseout='document.getElementById("bookedName").value=""'
						/><?php 
					}
					else
					{
						?><img class='cursor' src='image/oneSeatTop_green.png' 
							onclick="bookSeat(<?php echo $i; ?>)" /><?php 
					}
					?>
				</div>
			</td></tr><tr>

		<?php $row = 1; // CLOSE THIS ROW AND OPEN THE BOTTOM ROW
		}


		// TOP ROW [COLUMNS 1-5]
		else
		{?>
			<td class='tdOneSeat' align='center' id='<?php echo $i; ?>'>

				<!-- SEAT SHELL [contains: Seat Number + Image] -->
				<div id='divOneSeat'>
					<!-- SEAT NUMBER -->
					<div class='seatNumberTop'><?php echo $i; ?></div>

					<!-- SEAT IMAGE -->	
					<?php 
					if ($seat[$i]['status'] == 'booked')
					{
						?><img src='image/oneSeatTop_red.png' 
							onmouseover='document.getElementById("bookedName").value="<?php echo $seat[$i]['name']; ?>"'
							onmouseout='document.getElementById("bookedName").value=""'
							/><?php 
					}
					else if ($seat[$i]['status'] == 'reserved')
					{
						?><img src='image/oneSeatTop_brown.png' 
							onmouseover='document.getElementById("bookedName").value="<?php echo $seat[$i]['name']; ?>"'
							onmouseout='document.getElementById("bookedName").value=""'/>
						<?php 
					}
					else
					{
						?><img class='cursor' src='image/oneSeatTop_green.png' 
							   onclick="bookSeat(<?php echo $i; ?>)" /><?php 
					}
					?>
				</div>
			</td>
		<?php
		}
	}

	// BOTTOM ROW [ALL COLUMNS]
	else
	{?>
			<td class='tdOneSeat' align='center' id='<?php echo $i; ?>'>

				<!-- SEAT SHELL [contains: Seat Number + Image] -->
				<div id='divOneSeat'>
					<!-- SEAT IMAGE -->	
					<?php 
					if ($seat[$i]['status'] == 'booked')
					{
						?><img src='image/oneSeatBot_red.png' 
							onmouseover='document.getElementById("bookedName").value="<?php echo $seat[$i]['name']; ?>"'
							onmouseout='document.getElementById("bookedName").value=""'
						/><?php 
					}
					else if ($seat[$i]['status'] == 'reserved')
					{
						?><img src='image/oneSeatBot_brown.png' 
							onmouseover='document.getElementById("bookedName").value="<?php echo $seat[$i]['name']; ?>"'
							onmouseout='document.getElementById("bookedName").value=""'
						/><?php 
					}
					else
					{
						?><img class='cursor' src='image/oneSeatBot_green.png' 
							   onclick="bookSeat(<?php echo $i; ?>)" /><?php 
					}
					?>
					<!-- SEAT NUMBER -->
					<div class='seatNumberBot'><?php echo $i; ?></div>
				</div>
	<?php
	}
}
?>
</tr>
</table>


<br /><br />



<table>
	<tr><td>Booked For </td><td><input type='text' id='bookedName' value='' /></td>
</table>





</center>
</body></html>