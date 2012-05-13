<?php 
	session_start();									// Start/resume THIS session
	$_SESSION['title'] = "Seat Availability | MegaLAN"; // Declare this page's Title
	include("includes/template.php"); 					// Include the template page
?>


<!-- //******************************************************

// Name of File: seatMap.php
// Revision: 1.0
// Date: 15/04/2012
// Author: Quintin M
// Modified: Quintin M 26/04/2012

//***********************************************************

//*************** Start of SEAT AVAILABILITY PAGE ************ -->

<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Seat Availability</h1>



<a href="seatMapLayout.php?height=480&width=990&modal=false" 
   class="thickbox" 
   title="">
	<!-- SMALL IMAGE -->
	<img src='images/seatPlan/layout.png' border='0' width='571px' height='239px' />
</a>  



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