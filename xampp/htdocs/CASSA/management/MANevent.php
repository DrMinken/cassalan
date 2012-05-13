<?php 
	session_start();													// Start/resume THIS session

	// PAGE SECURITY
	if (!isset($_SESSION['isAdmin']))
	{
		if ($_SESSION['isAdmin'] == 0)
		{
			echo '<script type="text/javascript">history.back()</script>';
			die();
		}
	}

	$_SESSION['title'] = "Event Management | MegaLAN"; 					// Declare this page's Title
	include("../includes/template.php"); 								// Include the template page
	include("../includes/conn.php"); 									// Include the db connection

	$username = $_SESSION['username'];
	$query = "SELECT * FROM event";
	$result = $db->query($query);
	$row = $result->fetch_array(MYSQLI_BOTH);    
	$eventID = $row['eventID'];
?>


<!-- //******************************************************

// Name of File: MANevent.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Lyndon Smith
// Modified: 

//***********************************************************

//********** Start of MANAGE CONTACTS PAGE ************** -->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
//***************************************************************
//
// Ajax Function to create summary table on page.
//
//****************************************************************
function getEvent(eventID)
{
	if (eventID=="")
		
  		{
  			document.getElementById("eventTable").innerHTML="";
  			return;
  		} 
	if (window.XMLHttpRequest)
  				{	// code for mainstream browsers
  					xmlhttp=new XMLHttpRequest();
 				 }
					else
  						{// code for earlier IE versions
  							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  						}
					xmlhttp.onreadystatechange=function()
  						{
  							if (xmlhttp.readyState==4 && xmlhttp.status==200)
  								{
    							document.getElementById("eventTable").innerHTML=xmlhttp.responseText;
   					 		}
   					 }
 //Now we have the xmlhttp object, get the data using AJAX.
		var params = "eventID=" + eventID + "&queryType=0";		
				xmlhttp.open("POST","selectEvent.php",true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xmlhttp.setRequestHeader("Content-length", params.length);
					xmlhttp.setRequestHeader("Connection", "close");
				xmlhttp.send(params);
}

//***************************************************************
//
// Ajax Function to start an event.
//
//****************************************************************
function startEvent(eventID)
{
	var message = "The selected event is about to be ";
	    message += "started. All other started events will";
	    message += " be stopped. Proceed?";
	
	var answer = confirm(message );
	if (answer == true)
	{
		if (eventID=="")
		
  		{
  			document.getElementById("eventTable").innerHTML="";
  			return;
  		} 
	if (window.XMLHttpRequest)
  				{	// code for mainstream browsers
  					xmlhttp=new XMLHttpRequest();
 				 }
					else
  						{// code for earlier IE versions
  							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  						}
							xmlhttp.onreadystatechange=function()
		  						{
		  							if (xmlhttp.readyState==4 && xmlhttp.status==200)
		  								{
		    							document.getElementById("eventTable").innerHTML=xmlhttp.responseText;
		   					 		}
		   					 }
 //Now we have the xmlhttp object, get the data using AJAX.
		var params = "eventID=" + eventID + "&queryType=1";		
				xmlhttp.open("POST","selectEvent.php",true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xmlhttp.setRequestHeader("Content-length", params.length);
					xmlhttp.setRequestHeader("Connection", "close");
				xmlhttp.send(params);
		
	}
	else{ return;}
}
//***************************************************************
//
// Ajax Function to stop / end an event.
//
//****************************************************************
function stopEvent(eventID)
{
	var message = "The selected event is about to be ";
	    message += "stopped. It cannot be re-started. Proceed?";
	
	var answer = confirm(message );
	if (answer == true)
	{
		if (eventID=="")
		
  		{
  			document.getElementById("eventTable").innerHTML="";
  			return;
  		} 
	if (window.XMLHttpRequest)
  				{	// code for mainstream browsers
  					xmlhttp=new XMLHttpRequest();
 				 }
					else
  						{// code for earlier IE versions
  							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  						}
							xmlhttp.onreadystatechange=function()
		  						{
		  							if (xmlhttp.readyState==4 && xmlhttp.status==200)
		  								{
		    							document.getElementById("eventTable").innerHTML=xmlhttp.responseText;
		   					 		}
		   					 }
 //Now we have the xmlhttp object, get the data using AJAX.
		var params = "eventID=" + eventID + "&queryType=2";		
				xmlhttp.open("POST","selectEvent.php",true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xmlhttp.setRequestHeader("Content-length", params.length);
					xmlhttp.setRequestHeader("Connection", "close");
				xmlhttp.send(params);
		
	}
	else{ return;}
}

//***************************************************************
//
// Ajax Function to stop / end an event.
//
//****************************************************************
function editEvent(eventID)
{
	var message = "The selected event is about to be ";
	    message += "edited. Proceed?";
	
	var answer = confirm(message );
	if (answer == true)
	{
		if (eventID=="")
		
  		{
  			document.getElementById("eventTable").innerHTML="";
  			return;
  		} 
	if (window.XMLHttpRequest)
  				{	// code for mainstream browsers
  					xmlhttp=new XMLHttpRequest();
 				 }
					else
  						{// code for earlier IE versions
  							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  						}
							xmlhttp.onreadystatechange=function()
		  						{
		  							if (xmlhttp.readyState==4 && xmlhttp.status==200)
		  								{
		    							document.getElementById("eventTable").innerHTML=xmlhttp.responseText;
		   					 		}
		   					 }
 //Now we have the xmlhttp object, get the data using AJAX.
		var params = "eventID=" + eventID + "&queryType=3";		
				xmlhttp.open("POST","selectEvent.php",true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xmlhttp.setRequestHeader("Content-length", params.length);
					xmlhttp.setRequestHeader("Connection", "close");
				xmlhttp.send(params);
		
	}
	else{ return;}
}

//********************************************************************************************************

</script>
		</head>
		
			<body onload="getEvent( <?php echo $eventID; $result->close();?>  )">
			
		<center>
	<div id='shell'>
<!-- Main Content [left] -->
	<div id="content">
		<h1>Event Management</h1>
<?php
//***********************************************
// Set some variables up for use
//***********************************************


	echo '<hr />';
		echo '<p><h2>Current Events</h2></p>';
			echo '<FORM>';
				echo '<P>';
			echo '<SELECT size="6" name="selectEvent" onchange = getEvent(this.value)>';
	
	
	$result = $db->query($query);
// Now we can output the option fields to populate the list box.
for ($i = 0; $i < $result->num_rows;$i++) 
	{
		$row = $result->fetch_array(MYSQLI_BOTH);    
		
		if ($i==0)
		{
			echo '<OPTION value="'.$row['eventID'].'" selected="selected">' . $row['event_name'] . '</OPTION><br />';			
		}
		else
		{
			echo '<OPTION value="'.$row['eventID'].'">' . $row['event_name'] . '</OPTION><br />';
		}
	}

		echo '</SELECT>';
			echo '<br />';
   			echo '<INPUT type="submit" value="Send"><INPUT type="reset">';
   			echo '</P>';
			echo '</FORM>';
		echo '<hr />';

?>
<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->
<!-- ********************************* -->
<!--This is where the summary table ends up.-->
			<div id="eventTable"></div>
<!--**************************************** -->

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