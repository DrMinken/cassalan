<!-- //******************************************************
// Name of File: user_details.html
// Revision: 1.0
// Date: 29/03/2012
// Author: L.Smith
// Modified:L.SMITH 1/4/12
//******************************************************

//******************** Start of TEMPLATE ******************** -->
<?php

// Inialise session
session_start();

// Check, if user is already login, then jump to secured page
if (isset($_SESSION['username'])) 
{
header('Location: user_details.php');
}

?>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="CSSsoFar_revised_revb.css" />
</head>



<body>

	<div class="top_header">
	<p class="solid">
	<table width = "800" height = "80">
	<tr>
		<td width = "500">
		<img align ="left" src="http://cassa.org.au/wp-content/uploads/2011/07/CASSA-Header-32.png" width="400" height="80">
		</td>
		<td width = "300" align ="middle">
		<h1> MegaLAN Management System </h1>
		</td>
	</tr>
	</table>
	</p>
	</div>

	<div style="PADDING-BOTTOM: 8px; BACKGROUND-COLOR: #000099; PADDING-LEFT: 8px; 
		WIDTH: 800px; PADDING-RIGHT: 8px; HEIGHT: 10px; PADDING-TOP: 8px; align: left">
		<hr style="WIDTH: 800px">
	</div>
	<!--*********************************************************-->

<div id="container" style="WIDTH: 800px">

<div style="BACKGROUND-COLOR: #000099; WIDTH: 816px">
<h1 id="h1w">MegaLAN Management System</h1>
</div><br>

	<div id="content" style="border:1px solid blue; margin:0px; padding:10px;
				BACKGROUND-COLOR: #ffffff; WIDTH: 597px; FLOAT: left; HEIGHT: 200px">
		<h1>Latest MegaLAN</h1>
	</div>

<div id="menu" style=" border:1px solid blue; margin:0px; padding:5px; 
						BACKGROUND-COLOR: #ffffff; WIDTH: 160px; FLOAT: right; HEIGHT: 100px">

	<form name="input" action="process_login.php" method="post">
		<t8>Username:</t8><input  name="username" >
		<t8>Password:</t8><input  type="password" name="password" >
		<input type="submit" value="Login" >
	</form>
	<a href="register.html">Register</a>


</div>

	<div id="footer" style="TEXT-ALIGN: center; BACKGROUND-COLOR: #000099; CLEAR: both">
	</div>

</div>







</body>
</html>
