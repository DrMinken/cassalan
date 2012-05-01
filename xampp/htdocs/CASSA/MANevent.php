<?php 
	session_start();														// Start/resume THIS session
	$_SESSION['title'] = "Event Management | MegaLAN"; 		// Declare this page's Title
	include("includes/template.php"); 								// Include the template page
	include("includes/conn.php"); 					   			// Include the db connection
?>


<!-- //******************************************************

// Name of File: eventManagement.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Lyndon Smith
// Modified: 

//***********************************************************

//********** Start of MANAGE CONTACTS PAGE ************** -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Event Management</h1>
	

<?php
//***********************************************
// Set some variables up for use
//***********************************************

$username = $_SESSION['username'];
	$query = "SELECT * FROM event";
	$result = $db->query($query);

echo '<hr />';
echo '<p><h2>Current Events</h2></p>';
echo '<FORM action="selectEvent.php method="post">';
echo '<P>';
echo '<SELECT size="4" name="selectEvent">';
// Now we can output the option fields to poulate the list box.
for ($i = 0; $i<$result->num_rows;$i++) 
	{
		$row = $result->fetch_array(MYSQLI_BOTH);    
    echo '<OPTION selected value="' . $row[0]. '">' . $row[1] . '</OPTION>';
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