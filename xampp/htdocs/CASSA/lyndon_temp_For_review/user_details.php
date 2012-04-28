<!-- //******************************************************
// Name of File: user_details.html
// Revision: 1.0
// Date: 29/03/2012
// Author: L.Smith
// Modified:L.SMITH 1/4/12
//******************************************************

//******************** Start of TEMPLATE ******************** -->
<?php
session_start();
if (!isset($_SESSION['username'])) 
	{
		header('Location: index.php');
	}

include('cassa_lan.inc');
?>

<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http:
	//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="CSSsoFar_revised_revb.css" />
</head>


<body>

<div class="top_header">
	<p class="solid">
	<table class = "top" width = "800" height = "80">
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

<div style="PADDING-BOTTOM: 8px; BACKGROUND-COLOR: #000099; PADDING-LEFT: 8px; WIDTH: 800px; PADDING-RIGHT: 8px; HEIGHT: 10px; PADDING-TOP: 8px; align: left">
		<hr style="WIDTH: 800px">
</div>
			<div id="container" style="WIDTH: 800px">

			<div style="BACKGROUND-COLOR: #000099; WIDTH: 816px">
				<h1 id="h1w">MegaLAN Management System</h1>
			</div>
			<br />
		
<?php 	
			echo '<div id="menu" style=" border:1px solid blue; margin:0px; padding:5px; 
						BACKGROUND-COLOR: #ffffff; WIDTH: 160px; FLOAT: right; HEIGHT: 100px" >';
			
			echo '<h5>You are logged in as -<br>' . $_SESSION['username']. '</h5><br/>';
			echo '<form name="input" action="logout.php" method="post">';
			echo '<input  type="submit" value="Logout" >';
			echo '</form>';
			echo '</div>';
	$details = mysql_query("SELECT * FROM client WHERE username = '" . 
		mysql_real_escape_string($_SESSION['username']) . "'")or die(mysql_error());		
		echo '<div id="content" style="border:1px solid blue; margin:0px; padding:10px;
				BACKGROUND-COLOR: #ffffff; WIDTH: 597px; FLOAT: left; HEIGHT: 200px">';
		echo '<h1>User Details</h1>';
		echo '<table width= "400" cellpadding = "5px">';
		echo '<form name="update" action="user_update.php" method="post">';
	while($row =mysql_fetch_array($details, MYSQL_BOTH))
		{
			echo '<tr><td><t8>Name: </t8></td><td><input type="text" name="first_name" value="' . $row['first_name'] . '"/></td></tr>';
			
			echo '<tr><td><t8>Surname: </t8></td><td><input  type="text" name="last_name" value="' . $row['last_name'] .'"/></td></tr>';
			
			echo '<tr><td><t8>Mobile #: </t8></td><td><input  type="text" name="mobile" value="' . $row['mobile'] .'"/></td></tr>'; 
			
			echo '<tr><td><t8>Email: </t8></td><td><input  type="text" name="email" value="' . $row['email'] .'"/></td></tr>'; 
			echo '<input type ="hidden" name= "clientID" value = "' . $row['clientID'] . '"/>';
		} 
			echo '</table>';
			
			echo' <input  type="submit" value="Update" >';
			echo '</form>';
			echo '</div>';
			echo '<div id="footer" style="TEXT-ALIGN: center; BACKGROUND-COLOR: #000099; CLEAR: both">';
			echo '</div>';
			echo '</body>';
			echo '</html>';
			mysql_close($link);
?> 
		
<!--************************* END OF FILE ********************************-->






