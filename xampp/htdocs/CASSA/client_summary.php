<?php 
	session_start();									// Start/resume THIS session
	$_SESSION['title'] = "User Summary | MegaLAN"; // Declare this page's Title
	include("includes/template.php"); 					// Include the template page
	include("includes/conn.php"); 	
?>


<!-- //******************************************************

// Name of File: client_summary.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Quintin M
// Modified: L.Smith.

//***********************************************************

//******** Start of Client Summary PAGE ************ -->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Registration Summary</h1><br />
<?php
if (!isset($_SESSION['username'])) 
	{
		header('Location: index.php');
	}

		$query = "SELECT * FROM client WHERE clientID = '" . mysql_real_escape_string($_SESSION['userID']). "'";
		$result = $db->query($query);
		
		
		echo '<table width= "400" cellpadding = "5px">';
		echo '<form name="update" action="user_update.php" method="post">';
	while($row = $result->fetch_array(MYSQLI_BOTH))
		{
			echo '<tr><td>Username: </td><td><input type="text" name="username" value="' . $row['username'] . '"/></td></tr>';
						
			echo '<tr><td>Name: </td><td><input type="text" name="first_name" value="' . $row['first_name'] . '"/></td></tr>';
			
			echo '<tr><td>Surname: </td><td><input  type="text" name="last_name" value="' . $row['last_name'] .'"/></td></tr>';
			
			echo '<tr><td>Mobile #: </td><td><input  type="text" name="mobile" value="' . $row['mobile'] .'"/></td></tr>'; 
			
			echo '<tr><td>Email: </td><td><input  type="text" name="email" value="' . $row['email'] .'"/></td></tr>'; 
			echo '<input type ="hidden" name= "clientID" value = "' . $row['clientID'] . '"/>';
		} 
			echo '</table>';
			
			echo' <input  type="submit" value="Update" >';
			echo '</form>';
			echo '<br /><hr/>';
			$_SESSION['clientID'] = $row['clientID'];
			$result->close();
			
			
$query = "SELECT e.event_name, a.paid_Admission FROM (event e INNER JOIN attendee a ON e.eventID = a.eventID)
							WHERE a.clientID = '" . mysql_real_escape_string($_SESSION['clientID']). "'";
			
			$result = $db->query($query);
			$row = $result->fetch_array(MYSQLI_BOTH);
			echo '<br />';
			echo '<table width ="200px">';
			echo '<tr><td>Event Registrations Active:</td><td>' . $row['event_name'] . '</td>
									<td> Paid Y/N ?</td><td>' . $row['paid_admission'] . '</td></tr>';
			echo '<br />';
			$result->close();
			
?>

<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->
<!-- ********************************* -->

</div><!-- end of: Content -->


<!-- INSERT: rightPanel -->
<?php include('includes/rightPanel.html'); ?>


<!-- INSERT: footer -->
<div id="footer">
	<?php include('includes/footer.html'); ?>
</div>


</div><!-- end of: Shell -->

</center>
</body>
</html>

<!-- ********************************* -->
<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->