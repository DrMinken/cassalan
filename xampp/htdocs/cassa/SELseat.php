<?php 
	session_start();								// Start/resume THIS session
	$_SESSION['title'] = "Select Seat | MegaLAN"; 	// Declare this page's Title
	include("includes/template.php"); 				// Include the template page
?>


<!-- //******************************************************

// Name of File: SELseat.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Quintin M
// Modified: 

//***********************************************************

//********** Start of MANAGE REGISTRATION PAGE *********** -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Select Seat</h1>











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