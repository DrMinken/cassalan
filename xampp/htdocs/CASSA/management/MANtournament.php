<?php 
	session_start();									// Start/resume THIS session

	// PAGE SECURITY
	if (!isset($_SESSION['username']))
	{
		echo '<script type="text/javascript">history.back()</script>';
		die();
	}

	$_SESSION['title'] = "Manage Tournament | MegaLAN"; // Declare this page's Title
	include("../includes/template.php"); 					// Include the template page
?>


<!-- //******************************************************

// Name of File: tournaments.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Quintin M
// Modified: 

//***********************************************************

//*************** Start of MANAGE TOURNAMENT PAGE ******************* -->

<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Manage Tournament</h1>











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