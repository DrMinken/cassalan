<!-- //******************************************************

// Name of File: template.html
// Revision: 1.0
// Date: 29/03/2012
// Author: Quintin M. [demo]
// Modified: L.SMITH 1/4/12
// Modified: Quintin M 07/04/2012
// Modified: Quintin M 09/04/2012
// Modified: Quintin M 15/04/2012
// Modified: Quintin M 16/04/2012

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



	<!-- div class='blueLine940'></div --><!-- DRAW: blue line -->
	<!-- br / -->




<!-- MENU BAR -->
<div class='menuBar'>
	<ul>
		<!-- HOME -->
		<li onmouseover='this.style.backgroundColor="#333333"' 
			onmouseout='this.style.backgroundColor="black"'
			onclick='window.location.href="home.php"'>
			<a href='home.php'>Home</a>
		</li>



		<!-- REGISTER -->
		<li	onmouseover='this.style.backgroundColor="#333333"' 
			onmouseout='this.style.backgroundColor="black"'
			onclick='window.location.href="register.php"'>
			<a href='register.php'>Register</a>
		</li>



		<!-- FAQ -->
		<li onmouseover='this.style.backgroundColor="#333333"; 
						document.getElementById("faq").style.display="block"' 
			onmouseout='this.style.backgroundColor="black";
						document.getElementById("faq").style.display="none"'
			onclick='window.location.href="eventProgram.php"'>
			<a href='faq.php'>FAQ</a>
			
			<!-- CHILD LIST -->
			<ul class='children' id='faq'>
				<!-- LEADER BOARD -->
				<li onclick='window.location.href="askQuestion.php"'>
					<a href='askQuestion.php'>Got A Question?</a>
				</li>
			</ul>
		</li>



		<!-- EVENT -->
		<li	onmouseover='this.style.backgroundColor="#333333"; 
						document.getElementById("event").style.display="block"' 
			onmouseout='this.style.backgroundColor="black";
						document.getElementById("event").style.display="none"'
			onclick='window.location.href="eventProgram.php"'>
			<a href='eventProgram.php'>Event Program</a>
			
			<!-- CHILD LIST -->
			<ul class='children' id='event'>
				<!-- LEADER BOARD -->
				<li onclick='window.location.href="leaderBoard.php"'>
					<a href='leaderBoard.php'>Leader Board</a>
				</li>
				
				<!-- GAME SERVER DETAILS -->
				<li onclick='window.location.href="serverDetails.php"'>
					<a href='serverDetails.php'>Game Server Details</a>
				</li>
			</ul>
		</li>



		<!-- GENERAL LAN NOTICES -->
		<li onmouseover='this.style.backgroundColor="#333333"' 
			onmouseout='this.style.backgroundColor="black"'
			onclick='window.location.href="notices.php"'>
			<a href='notices.php'>General LAN Notices</a>
		</li>



		<!-- SEAT AVAILABILITY -->
		<li onmouseover='this.style.backgroundColor="#333333"' 
			onmouseout='this.style.backgroundColor="black"'
			onclick='window.location.href="seatMap.php"'>
			<a href='seatMap.php'>Seat Availability</a>
		</li>



		<!-- CONTACT -->
		<li	onmouseover='this.style.backgroundColor="#333333"' 
			onmouseout='this.style.backgroundColor="black"'
			onclick='window.location.href="contact.php"'>
			<a href='contact.php'>Contact</a>
		</li>



		<!-- STAFF -->
		<?php 
		if(isset($_SESSION['isStaff']))
		{
			if($_SESSION['isStaff'] == 1)
			{
			?>
				<li onmouseover='this.style.backgroundColor="#333333"; 
								document.getElementById("staff").style.display="block"' 
					onmouseout='this.style.backgroundColor="black";
								document.getElementById("staff").style.display="none"'
					onclick='window.location.href="#.php"'>
					<a href='#.php'><div class='menuUserColor'>Staff</div></a>
				
					<!-- CHILD LIST -->
					<ul class='children' id='staff'>
						<!-- ADD Notices -->
						<li onclick='window.location.href="ADDnotices.php"'>
							<a href='ADDnotices.php'>Add Notices</a>
						</li>
						<!-- MANAGE Participants -->
						<li onclick='window.location.href="MANparticipants.php"'>
							<a href='MANparticipants.php'>Manage Participants</a>
						</li>
						
						<!-- MANAGE FAQ -->
						<li onclick='window.location.href="MANFAQ.php"'>
							<a href='MANFAQ.php'>Manage FAQ</a>
						</li>

						<!-- MANAGE Contacts -->
						<li onclick='window.location.href="MANcontacts.php"'>
							<a href='MANcontacts.php'>Manage Contacts</a>
						</li>

						<!-- MANAGE Servers -->
						<li onclick='window.location.href="MANserverDetails.php"'>
							<a href='MANserverDetails.php'>Manage Server Details</a>
						</li>

						<!-- MANAGE Results -->
						<li onclick='window.location.href="MANresults.php"'>
							<a href='MANresults.php'>Manage Results</a>
						</li>

						<!-- MANAGE Tournaments -->
						<li onclick='window.location.href="MANtournaments.php"'>
							<a href='MANtournaments.php'>Manage Tournaments</a>
						</li>
					</ul>
				</li>
			<?php 
			}
			else if($_SESSION['isStaff'] == 0)
			{
			?>
				<!-- PARTICIPANT -->
				<li onmouseover='this.style.backgroundColor="#333333"; 
								document.getElementById("participant").style.display="block"' 
					onmouseout='this.style.backgroundColor="black";
								document.getElementById("participant").style.display="none"'
					onclick='window.location.href="#.php"'>
					<a href='#.php'><div class='menuUserColor'><?php echo $_SESSION['fullName']; ?></div></a>
					
					<!-- CHILD LIST -->
					<ul class='children' id='participant'>
						<!-- MANAGE Registration -->
						<li onclick='window.location.href="MANregistration.php"'>
							<a href='MANregistration.php'>Manage Registration</a>
						</li>

						<!-- SELECT Tournaments -->
						<li onclick='window.location.href="SELtournament.php"'>
							<a href='SELtournament.php'>Select Tournament</a>
						</li>

						<!-- SELECT Pizza -->
						<li onclick='window.location.href="SELpizza.php"'>
							<a href='SELpizza.php'>Select Pizza</a>
						</li>

						<!-- SELECT Seat -->
						<li onclick='window.location.href="SELseat.php"'>
							<a href='SELseat.php'>Select Seat</a>
						</li>
					</ul>
				</li>
			<?php
			}
		}
		?>
	</ul>
	<br style='clear: left' />
</div><!-- end of: menu Bar -->



<br /><br />



</div>
</center>
</body>
</html>