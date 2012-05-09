<?php 
	session_start();							// Start/resume THIS session
	$_SESSION['title'] = "Contact | MegaLAN"; 		// Declare this page's Title
	include("includes/template.php"); 					// Include the template page
?>


<!-- //******************************************************

// Name of File: contact.php
// Revision: 1.0
// Date: 15/04/2012
// Author: Quintin M
// Modified: 

//***********************************************************

//*************** Start of CONTACT PAGE ******************* -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>MegaLAN Contact Details</h1>


<h3>Clubroom</h3>

<div style='height: 146px'>
	<div style='float: left'>
		<img src='images/layers/clubroom.jpg' width='120px' height='146px' />
		<br />
	</div>
	<div style='float: right; margin-left: 20px; word-spacing: 2px;'>
		We are located on ECU Mt. Lawley campus, room 03.202 (upstairs next to the lecture theatre). We have the screen on top of our door so you won’t miss us.<br /><br />
		 
		We aim to be open most of the day during university hours. You can buy drinks and candy from us here.
		<br />
	</div>
</div>




<div style='line-height: 18pt; word-spacing: 2px;'>
	&nbsp;<br />
	<b>Executive Committee for 2012</b><br />
	<b>Rob McKnight</b> President (IRC: Funkballs)<br />
	<b>Simon Vin</b> Vice-President (IRC: rith)<br />
	<b>Luke Spartalis</b> Secretary (IRC: Radx)<br />
	<b>Joshua Norris</b> Treasurer (IRC: falcon)<br />
	<b>Michael Alderman</b> Tech-Admin (IRC: Cake_Man)<br />
	<b>Jason Baseley</b> Webmaster (IRC: Spartan101)<br />
	<b>Alexandra Helens</b> Social Events Coordinator (IRC: Eskilla)<br />
</div>







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