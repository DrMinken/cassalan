<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 

<?php 
	session_start();									// Start/resume THIS session
	
	// PAGE SECURITY
	if (!isset($_SESSION['isAdmin']))
	{
		if ($_SESSION['isAdmin'] == 0)
		{
			echo '<script type="text/javascript">history.back()</script>';
			die();
		}
	}

	$_SESSION['title'] = "Manage Notices | MegaLAN"; 	// Declare this page's Title
	include("includes/template.php"); 					// Include the template page
?>


<!-- //******************************************************

// Name of File: notices.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Quintin M
// Modified: 

//***********************************************************

//*********** Start of MANAGE NOTICES PAGE *************** -->

<head></head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Manage Notices</h1>











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