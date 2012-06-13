<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- //******************************************************

// Name of File: MANtournament.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Tinashe Masvaure
// Modified: Luke Spartalis

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


	// AVAILABLE EVENTS
	$query = "SELECT * FROM event WHERE startDate >= CURDATE() AND event_completed=0 ORDER BY startDate ASC";
	$result = $db->query($query);
	$row = $result->fetch_assoc();

	if ($result->num_rows == 0)
	{
		$_SESSION['errMsg'] = '<div class="emptyServer" align="center">';
		$_SESSION['errMsg'] .= 'A current event must be inserted before you can create a new tournament';
		$_SESSION['errMsg'] .= '<br /><br />';
		$_SESSION['errMsg'] .= '<a href="/cassa/management/MANevent.php">Click here to create a new event</a>';
		$_SESSION['errMsg'] .= '</div>';
	}
	else
	{
		// TOURNAMENT
		$query = "SELECT * FROM tournament WHERE eventID=".$row['eventID']."";
		$result = $db->query($query);
		$row = $result->fetch_array(MYSQLI_BOTH);
		$tournID = $row['tournID'];
	}
?>


<head>
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
	var params = "tournID=" + tournID + "&queryType=0";
	createRequest(params);
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
	var startTime = document.getElementById('start_time').value;
	var endTime = document.getElementById('end_time').value;

	var params = "eventID=" + eventID + "&name=" + name + 
				 "&startTime=" + startTime + "&endTime=" + endTime + 
				 "&queryType=insert";
	
	createRequest(params);
}
//***************************************************************
//
// Function Edit Tournament
//
//***************************************************************
function editTournament(tournID)
{
	var params = "tournID=" + tournID + "&queryType=2";      
	createRequest(params);
}

function updateTourn(tournID)
{
	var name = document.getElementById('E_name').value;
	var startTime = document.getElementById('E_start_time').value;
	var endTime = document.getElementById('E_end_time').value;

	var params = "tournID=" + tournID + "&name=" + name + "&startTime= " + 
				 startTime + "&endTime=" + endTime + "&queryType=update";

	createRequest(params);
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
//***************************************************************
//
// PREPARE ColorBox
//
//****************************************************************
$(document).ajaxStop(function(){
	window.location.reload();
});

$(document).ready(function(){
	// COLORBOX
	$(".inline").colorbox({inline:true, width:"550px", height:"380px"});
});

//***************************************************************
//
// Ajax Function to start an tournament.
//
//****************************************************************
function startTournament(tournID)
{

	
	var message = "The tournament about to be ";
	message += "started. Proceed?";
	
	var answer = confirm(message);
	if (answer == true)
	{
		var params = "tournID=" + tournID + "&queryType=start";		
		createRequest(params);
	}
	else
	{ 
		return;
	}
}

//***************************************************************
//
// Ajax Function to stop / end an tournament.
//
//****************************************************************
function stopTournament(tournID)
{

	var message = "The tournament is about to be ";
	message += "stopped. It cannot be re-started. Proceed?";
	
	var answer = confirm(message );
	if (answer == true)
	{
		var params = "tournID=" + tournID + "&queryType=stop";		
		createRequest(params);
	}
	else
	{ 
		return;
	}
}




</script>
</head>


<body onload="getTournament( <?php echo $tournID; ?> );">          
<center>
<div id='shell'>

<!-- Main Content [left] -->
<div id="content">





<?php 
if (isset($_SESSION['errMsg']))
{
	echo $_SESSION['errMsg'];
	unset($_SESSION['errMsg']);
}
else
{
?>
	<!-- HREF : OPENS INLINE 'CREATE NEW PIZZA' FORM -->
	<a class='inline' href='#createTourn'>Create new Tournament</a>
<?php
}
?>




<br /><br /><br />





<!-- 'ADD NEW TOURNAMENT' @ colorbox -->
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
				$get = "SELECT * FROM event WHERE event_completed=0 AND startDate >= CURDATE()";
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