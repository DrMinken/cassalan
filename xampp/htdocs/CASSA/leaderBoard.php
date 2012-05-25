<?php 
	session_start();								// Start/resume THIS session
	$_SESSION['title'] = "Leader Board | MegaLAN"; 	// Declare this page's Title
	include("includes/template.php"); 				// Include the template page
	include("includes/conn.php");
?>


<!-- //******************************************************

// Name of File: leaderBoard.php
// Revision: 1.0
// Date: 15/04/2012
// Author: Quintin M
// Modified: 

//***********************************************************

//*************** Start of LEADER BOARD PAGE ************ -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Leader Board</h1><br />





<?php
	// GET ALL CURRENT ACTIVE TOURNAMENTS
	$get = "SELECT * FROM tournament WHERE started=1 AND finished=0 ORDER BY date DESC, start_time ASC";
	$result = $db->query($get);
	
	for ($i=0; $i<$result->num_rows; $i++)
	{
		$row = $result->fetch_assoc();

		echo '<div class="tournDIV"';
			echo '<b><h2>'.$row['name'].'</h2></b>';
			echo 'Run Time: '.$row['start_time'].' - '.$row['end_time'].'<br />';
			echo 'Winner: '.$row['winner'].'<br />';
		echo '</div>';

		echo '<br /><br />';
	}

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