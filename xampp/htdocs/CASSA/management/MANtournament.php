<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- //******************************************************

// Name of File: MANtournament.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Tinashe Masvaure
// Modified: 

//***********************************************************

//********** Start PAGE ************** -->
<?php 
    session_start();		// Start/resume THIS session

    // PAGE SECURITY
    if (!isset($_SESSION['isAdmin']))
    {
        if ($_SESSION['isAdmin'] == 0)
        {
            echo '<script type="text/javascript">history.back()</script>';
            die();
        }
    }

    $_SESSION['title'] = "Tournament Management | MegaLAN";     // Declare this page's Title

    include("../includes/template.php");                        // Include the template page
    include("../includes/conn.php");                            // Include the db connection

    $query = "SELECT * FROM tournament";
    $result = $db->query($query);
    $row = $result->fetch_array(MYSQLI_BOTH);
    $tournID = $row['tournID'];
?>


<head>
	<link rel="stylesheet" href="../js/datepicker/css/datepicker.css" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="../js/datepicker/css/layout.css" />
	<script type="text/javascript" src="../js/datepicker/js/datepicker.js"></script>
    <script type="text/javascript" src="../js/datepicker/js/eye.js"></script>
    <script type="text/javascript" src="../js/datepicker/js/utils.js"></script>
    <script type="text/javascript" src="../js/datepicker/js/layout.js"></script>

<script type="text/javascript">
//***************************************************************
//
// GENERAL AJAX REQUEST FUNCTION
//
//***************************************************************
function createRequest(params)
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
alert(params);
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("tournamentTable").innerHTML=xmlhttp.responseText;
		}
	}
	//Now we have the xmlhttp object, get the data using AJAX.
	xmlhttp.open("POST","SELtournament.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(params);
}
//***************************************************************
//
// Ajax Function to create summary table on page.
//
//****************************************************************
function getTournament(tournID)
{
    if (window.XMLHttpRequest)
	{   
		// code for mainstream browsers
		xmlhttp = new XMLHttpRequest();
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
			document.getElementById("tournamentTable").innerHTML=xmlhttp.responseText;
		}
	}

	//Now we have the xmlhttp object, get the data using AJAX.
	var params = "tournID=" + tournID + "&queryType=0";        
	xmlhttp.open("POST","SELtournament.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(params);      
}
//***************************************************************
//
// Function Create Tournament
//
//***************************************************************
function createTourn()
{
	var eventID = document.getElementById('selectedEvent').value;
	var name = document.getElementById('name').value;
	var date = document.getElementById('inputDate').value;
	var startTime = document.getElementById('start_time').value;
	var endTime = document.getElementById('end_time').value;

	var params = "eventID=" + eventID + "&name=" + name + "&date=" + date +
				 "&startTime=" + startTime + "&endTime=" + endTime + 
				 "&queryType=insert";
	
	createRequest(params);
}

function getInfo()
{
	createTournament();
	var eventinfo = document.getElementById("events").value;
	var nameinfo = document.getElementById("name").value;
	var dateinfo = document.getElementById("date").value;
	var startinfo = document.getElementById("start_time").value;
	var endinfo = document.getElementById("end_time").value;

	function stateChanged()
	{
		if(xmlhttp.readyState==4)
		{
			document.getElementById("tournamentTable").innerHTML=xmlhttp.responseText; 
		}
	}

	var event = "contact.php?event="+ eventinfo;
	var name = "contact.php?name="+ nameinfo;
	var date = "contact.php?date="+ dateinfo;
	var start = "contact.php?start_time="+ startinfo;
	var end = "contact.php?end_time="+ endinfo;

	//  xmlhttp.onreadystatechange= stateChanged;
	xmlhttp.open("GET",event &&name&&date&&start&&end,true);
	xmlhttp.send(null);                  
}

//***************************************************************
//
// Function Edit Tournament
//
//***************************************************************
function editTournament(tournID)
{
	if (tournID=="")
	{
		document.getElementById("tournamentTable").onclick.innerHTML="";
		return;
	} 
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
			document.getElementById("tournamentTable").innerHTML=xmlhttp.responseText;
		}
	}

	//Now we have the xmlhttp object, get the data using AJAX.
	var params = "tournID=" + tournID + "&queryType=2";        
	xmlhttp.open("POST","SELtournament.php",true);

	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(params);       
}

function editInfo()
{
	editTournament();

	var eventinfo = document.getElementById("events").value;
	var nameinfo = document.getElementById("name").value;
	var dateinfo = document.getElementById("date").value;
	var startinfo = document.getElementById("start_time").value;
	var endinfo = document.getElementById("end_time").value;
	var winnerinfo = document.getElementById("winner").value;
	var startedinfo = document.getElementById("started").value;
	var finishedinfo = document.getElementById("finished").value;

	function stateChanged()
	{
		if(xmlhttp.readyState == 4)
		{
			document.getElementById("tournamentTable").innerHTML=xmlhttp.responseText;
		}
	}

	var event = "contact.php?event="+ eventinfo;
	var name = "contact.php?name="+ nameinfo;
	var date = "contact.php?date="+ dateinfo;
	var start = "contact.php?start_time="+ startinfo;
	var end = "contact.php?end_time="+ endinfo;
	var winner = "contact.php?winner="+ winnerinfo;
	var started = "contact.php?started="+ startedinfo;
	var finished = "contact.php?finished="+ finishedinfo;

	//  xmlhttp.onreadystatechange= stateChanged;
	xmlhttp.open("GET",event && name&& date&&start&&end&&winner&&started&&finished, true);
	xmlhttp.send(null);
}
//***************************************************************
//
// Delete a Tournament @ AJAX
//
//****************************************************************
function deleteTournament(tournID, tournName)
{
	message = "Please confirm to delete '" + tournName + "'";

	var answer = confirm(message);
	if (answer == true)
	{
		var params = "tournID=" + tournID + "&queryType=delete";		
		createRequest(params);
	}
	else
	{
		return;
	}
}



// 'Current Events' @ ROW SELECT 
function selectRow(row, count)
{
	for (var i = 0 ; i < count ; i++)
	{
		if (i == row)
		{
			document.getElementById("tournRow_"+i).style.backgroundColor = "#EDFFFE";
		}
		else
		{
			document.getElementById("tournRow_"+i).style.backgroundColor = "white";
		}
	}
}



function setDate()
{
	// GET TODAYS DATE
	var fullDate = new Date(); // full date
	var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1); // 2 Digit month
	var currentDate = fullDate.getDate() + "/" + twoDigitMonth + "/" + fullDate.getFullYear(); // Absolute date nn/nn/nnnn

	// SET TODAYS DATE
	document.getElementById('inputDate').value = currentDate;
}

$(document).ready(function(){
	// COLORBOX
	$(".inline").colorbox({inline:true, width:"550px", height:"380px"});

	// DATE PICKER:
	$('.inputDate').DatePicker();
});
</script>
</head>
<body onload="getTournament( <?php echo $tournID; ?> ); setDate();">          
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
<a class='inline' href='#createTourn'>Create new Tournament</a>





<br /><br /><br />





<table class='pizzaOrder'>
<tr>
	<td class='MANheader' width='600px' colspan='2'>
	&nbsp;&nbsp;Current Tournaments: 
	<font size="2" class="subtitle">Click on a tournament to see more information below</font></td>
</tr>

<?php
//$query = "SELECT * FROM event order by startDate ASC";
$result = $db->query($query);

// Now we can output the option fields to populate the list box.
for ($i=0; $i<$result->num_rows; $i++) 
{
	$row = $result->fetch_assoc();    

	echo '<tr>';
		echo '<td width="70px">';
			echo '<div style="position: relative; top: 5px;">';
		?>
			<!-- // DELETE EVENT BUTTON -->
			<img class="pointer"
				src="../images/buttons/delete_60.png"';
				alt="Delete this tournament" 
				onclick="deleteTournament(<?php echo $row["tournID"]; ?>, '<?php echo $row["name"]; ?>')" />
		<?php
			echo '</div>';
		echo '</td>';
		echo '<td class="pointer" id="tournRow_'.$i.'" onclick="selectRow('.$i.', '.$result->num_rows.'); getTournament('.$row["tournID"].')">';
			echo $row['name'];
			echo '&nbsp;-&nbsp;<font size="1">['.$row['date'].']</font>';
		echo '</td>';
	echo '</tr>';
}
echo '</table>';
?>









<div style='display: none'>
<div id="createTourn" align='center'>
	<br />

	<h2>Create Tournament</h2>

	<br /><br />

	<table border="0" width="400px" style='text-align: left; line-height: 23pt;'>
		<tr> 
			<td>Select Event:</td>
			<td>
				<select name="selectedEvent" id="selectedEvent">
				<?php
				$get = "SELECT * FROM event WHERE event_completed=0 AND startDate >= NOW()";
				$result = $db->query($get);

				for ($i=0; $i<$result->num_rows; $i++)
				{
					$row = $result->fetch_assoc();
					echo '<option value="'.$row['eventID'].'">'.$row['event_name'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>

		<tr>
			<td>Tournament Name:</td>
			<td><input type='text' name='name' id='name' maxlength='64' /></td>
		</tr>

		<tr>
			<td>Tournament Date:</td>
			<td><input class="inputDate pointer" type='text' 
					   name='inputDate' id="inputDate" readonly='readonly' />
				<label id='closeOnSelect'>
					<input type='checkbox' checked='true' style='visibility: hidden' />
				</label>
			</td>
		</tr>

		<tr>
			<td>Start Time: <font size='1'>(24 hour)</font></td>
			<td><input type='time' name='start_time' id='start_time' value='00:00' size='5' maxlength='5' /></td>
		</tr>

		<tr>
			<td>End Time: <font size='1'>(24 hour)</font></td>
			<td><input type='time' name='end_time' id='end_time' value='00:00' size='5' maxlength='5' /></td>
		</tr>

		<tr><td colspan='2' align='center'><br />
			<input type='submit' value='Create Tournament' onclick='createTourn()'>
		</td></tr>
	</table>

</div>
</div>









<!--This is where the summary table ends up -->
<div id="tournamentTable"></div>









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