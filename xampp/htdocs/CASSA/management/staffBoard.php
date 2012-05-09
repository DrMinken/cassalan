<?php
	session_start();										// Start/resume THIS session
	$_SESSION['title'] = "Staff Home | MegaLAN"; 			// Declare this page's Title

	// PAGE SECURITY
	if (!isset($_SESSION['isAdmin']))
	{
		if ($_SESSION['isAdmin'] == 0)
		{
			echo '<script type="text/javascript">history.back()</script>';
			die();
		}
	}

	include("../includes/template.php"); 				// Include the template page
	include("../includes/conn.php"); 					// Include the database connection
?>


<!-- //******************************************************

// Name of File: staffBoard.php
// Revision: 1.0
// Date: 29/04/2012
// Author: Quintin M
// Modified: 

//***********************************************************

//******** Start of STAFF BOARD  PAGE ******************* -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<center>
<div id='shell'>



<table class='boardDIV' align='center' border='0'>
<tr>
	<td width='100px;'>&nbsp;</td>
	<td>
		<!-- MANAGE EVENT -->
		<a href='MANevent.php'>
			<img class='boardButton' src='../images/buttons/event.jpg' title='Manage Event' 
				onmouseover='this.src="../images/buttons/eventO.jpg"' 
				onmouseout='this.src="../images/buttons/event.jpg"' />
		</a>
	</td>
	<td>
		<!-- MANAGE TOURNAMENT -->
		<a href='MANtournament.php'>
			<img class='boardButton' src='../images/buttons/tournament.jpg' title='Manage Tournaments'
				onmouseover='this.src="../images/buttons/tournamentO.jpg"' 
				onmouseout='this.src="../images/buttons/tournament.jpg"' />
		</a>
	</td>
	<td>
		<!-- MANAGE PIZZA MENU -->
		<a href='MANpizza.php'>
			<img class='boardButton' src='../images/buttons/pizza.jpg' title='Manage Pizza'
				onmouseover='this.src="../images/buttons/pizzaO.jpg"' 					onmouseout='this.src="../images/buttons/pizza.jpg"' />
		</a>
	</td>
	<td width='100px;'>&nbsp;</td>
</tr>
<tr>
	<td width='100px;'>&nbsp;</td>
	<td>
		<!-- MANAGE USERS -->
		<a href='MANuser.php'>
			<img class='boardButton' src='../images/buttons/user.jpg' title='Manage Users' 
				onmouseover='this.src="../images/buttons/userO.jpg"' 
				onmouseout='this.src="../images/buttons/user.jpg"' />
		</a>
	</td>
	<td>
		<!-- MANAGE PAGES -->
		<a href='MANpages.php'>
			<img class='boardButton' src='../images/buttons/page.jpg' title='Manage Pages'
				onmouseover='this.src="../images/buttons/pageO.jpg"' 
				onmouseout='this.src="../images/buttons/page.jpg"' />
		</a>
	</td>
	<td>
		<!-- SETTINGS -->
		<a href='settings.php'>
			<img class='boardButton' src='../images/buttons/settings.jpg' title='Site Settings'
				onmouseover='this.src="../images/buttons/settingsO.jpg"' 					onmouseout='this.src="../images/buttons/settings.jpg"' />
		</a>
	</td>
	<td width='100px;'>&nbsp;</td>
</tr>	
<tr><td colspan='5' height='40px'>&nbsp</td></tr>
</table>









<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->
<!-- ********************************* -->

<br /><br /><br /><br /><br />


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
