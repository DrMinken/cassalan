<!-- //******************************************************

// Name of File: template.html
// Revision: 1.0
// Date: 29/03/2012
// Author: Quintin M. [demo]
// Modified: L.SMITH 1/4/12
// Modified: Quintin M 07/04/2012
// Modified: Quintin M 09/04/2012

//***********************************************************
//******************** Start of TEMPLATE PAGE ************** -->



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<!-- H E A D --> <!-- H E A D --> <!-- H E A D -->
<head>
	<title><?php echo $_SESSION['title']; ?></title>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css" />

	<!-- JQuery -->
	<script type='text/javascript' href='js/jquery.js'></script>




	<!-- VALIDATE: login form -->
	<script type='text/javascript'>
	function loginValidate()
	{
		if(document.login['username'].value == '')
		{
			alert('No username was entered');
			document.login['username'].focus();
			return false;
		}
		if(document.login['password'].value == '')
		{
			alert('No password was entered');
			document.login['password'].focus();
			return false;
		}
	}
	</script><!-- end of LOGIN VALIDATION-->
</head>






<!-- **************** B O D Y **************** -->
<body>
<center>


<!-- OVERALL SHELL
	 ~CONTAINS EVERYY OBJECT 
	 ~DIV SHELL CLOSES INSIDE VERY PAGE -->
<div id='shell'>



	<!-- TOP HEADER: [Logo][Title] -->
	<table width="940px" height="100px" border='0'>
	<tr>
		<!-- Logo -->
		<td width="500px">
			<img align="left" src="images/logos/CASSA_Header.png" width="400px" height="80px">
		</td>

		<!-- Title -->
		<td width="440px" align="center" style='vertical-align: bottom;'>
			<h1 align="center">MegaLAN Management System </h1>
		</td>
	</tr>
	</table>



	<div class='blueLine'></div><!-- DRAW: blue line -->



<!-- CONTAINER: CONTAINS ALL INNNER OBJECTS -->
<div id="container" style="WIDTH: 800px">



<br />



<!-- MENU BAR -->
<div class='menuBar'>
	<table class='menuBar' cellpadding='8px'>
		<tr>
			<td>Home</td>
			<td>Register</td>
			<td>FAQ</td>
			<td>Contact</td>
			<td>Game Server Details</td>
			<td>Event Program</td>
			<td>Leader Board</td>
			<td>General LAN Notices</td>
			<td>Music Playlist</td>
			<td>Seat Availability</td>
		</tr>
	</table>
</div><!-- end of: menu Bar -->



<br /><br />



<!--RIGHT PANEL [FLOAT RIGHT] -->
<div id='rightPanel'>

	<!-- Login Box -->
	<div id='loginBox'>

		<!-- Form: for user login -->
		<form name="login" onsubmit="return loginValidate();" method="post" action="server_test.php">
		<p align='left'>
			Username: <br/>
			<input type="text" width="40px" name="username" />
			
			Password: <br/>
			<input type="password" width="40px" name="password" />
			<a href='registration.php'>Not registered?</a>
		</p>
		<p align='right'><input type="submit" value="Submit" /></p>
		</form>

	</div><!-- end of: Login Box -->


	<br />


	<!-- Navigation Panel -->
	<div id='rightPanelNavigation'>
		<b>Recent Posts</b>
		<ul class='rightPanelList'>
			<li>MegaLAN</li>
			<li>Aladin</li>
			<li>I Cyborg</li>
			<li>April Fools</li>
			<li>2010 Best Fails</li>
		</ul>

		<b>Archives</b>
		<ul class='rightPanelList'>
			<li>April 2012</li>
			<li>March 2012</li>
			<li>February 2012</li>
			<li>December 2011</li>
			<li>October 2011</li>
			<li>August 2011</li>
			<li>July 2011</li>
		</ul>

		<b>Site Tools</b>
		<ul class='rightPanelList'>
			<li>Log in</li>
			<li>Entries RSS</li>
			<li>Comments RSS</li>
		</ul>

		<b>Categories</b>
		<ul class='rightPanelList'>
			<li>CASSA News</li>
			<li>Meetings</li>
			<li>MegaLAN</li>
			<li>Other News</li>
			<li>Posts</li>
			<li>Site Updates</li>
			<li>Social Events</li>
			<li>Tech Post</li>
		</ul>
	</div><!-- end of: Navigation Panel -->


</div><!-- end of: Right Panel -->