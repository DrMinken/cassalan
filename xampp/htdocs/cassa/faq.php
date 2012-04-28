<?php 
	session_start();							// Start/resume THIS session
	$_SESSION['title'] = "FAQ | MegaLAN"; 		// Declare this page's Title
	include("includes/template.php"); 			// Include the template page
?>


<!-- //******************************************************

// Name of File: faq.php
// Revision: 1.0
// Date: 15/04/2012
// Author: Quintin M
// Modified: 

//***********************************************************

//*************** Start of FAQ PAGE ******************* -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Frequently Asked Questions</h1>


<!-- FAQ -->
<div id='faqDIV'>
	<b>Can I bring my own lunch of Dinner?</b><br />
	Yes you can bring any food and drinks you wish to the event.<br /><br />

	<b>Do I need to bring a sleeping bag?</b><br />
	You can bring a sleeping bag, however the purpose of the MegaLAN is to stay up past your parents enforces bed time, so no sleeping!<br /><br />

	<b><u>More questions to be asked here</u></b><br />


</div><!-- end of: FAQ -->





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