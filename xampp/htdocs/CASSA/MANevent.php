<?php 
	session_start();									// Start/resume THIS session
	$_SESSION['title'] = "Manage Event | MegaLAN";		// Declare this page's Title
	include("includes/template.php"); 					// Include the template page
	include("includes/conn.php"); 						// Include the DB Connection
?>


<!-- //******************************************************

// Name of File: MANevent.php
// Revision: 1.0
// Date: 29/04/2012
// Author: Quintin M
// Modified: 

//***********************************************************

//************* Start of MANAGE EVENT PAGE ************** -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Manage Event</h1>























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