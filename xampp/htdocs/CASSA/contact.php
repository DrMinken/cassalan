<?php 
	session_start();							// Start/resume THIS session
	$_SESSION['title'] = "Contact | MegaLAN"; 		// Declare this page's Title
	include("includes/template.php"); 					// Include the template page
	include("includes/conn.php"); 	
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
	<h1>Contact</h1>



<br />



<h3 style='line-height: 20pt;'>Clubroom</h3>

<div style='height: 146px;  border: 0px solid black'>
	<div style='float: left;'>
		<img src='images/layers/clubroom.jpg' width='120px' height='146px' />
		<br />
	</div>
<div style='float: right; width: 500px; margin-left: 15px; word-spacing: 2px; border: 0px solid black'>
<br/>
<br/>
	
<?php

	// FETCH ALL NEWS
	$query = "SELECT * FROM `contact`";
	$result = $db->query($query);

	for ($i=0; $i<$result->num_rows; $i++)
	{
		$row = $result->fetch_assoc();
		$contactID = $row['contactID'];
		$blur = $row['blur'];
		$president = $row['president'];
		$pre_irc = $row['pre_irc'];
		$v_president = $row['v_president'];
		$vpre_irc = $row['vpre_irc'];
		$secretary = $row['secretary'];
		$sec_irc = $row['sec_irc'];
		$treasurer = $row['treasurer'];
		$tre_irc = $row['tre_irc'];
		$tech_admin = $row['tech_admin'];
		$tec_irc = $row['tec_irc'];
		$webmaster = $row['webmaster'];
		$web_irc = $row['web_irc'];
		$social_events = $row['social_events'];
		$soc_irc = $row['soc_irc'];

		echo '<div style="line-height: 18pt;">'.$blur.'<br /></div>';
	}

			?>
		<br />
</div>


<br />
<br />



<div style='line-height: 18pt; word-spacing: 2px; float: left; ' >
	&nbsp;<br />
	<b>Executive Committee</b><br />
	<b><?php echo $president; ?></b> President (IRC: <?php echo $pre_irc; ?>)<br />
	<b><?php echo $v_president; ?></b> Vice-President (IRC: <?php echo $vpre_irc; ?>)<br />
	<b><?php echo $secretary; ?></b> Secretary (IRC: <?php echo $sec_irc; ?>)<br />
	<b><?php echo $treasurer; ?></b> Treasurer (IRC: <?php echo $tre_irc; ?>)<br />
	<b><?php echo $tech_admin; ?></b> Tech-Admin (IRC: <?php echo $tec_irc; ?>)<br />
	<b><?php echo $webmaster; ?></b> Webmaster (IRC: <?php echo $web_irc; ?>)<br />
	<b><?php echo $social_events; ?></b> Social Events Coordinator (IRC: <?php echo $soc_irc; ?>)<br />
</div>
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