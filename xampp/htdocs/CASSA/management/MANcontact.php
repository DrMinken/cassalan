<?php 
	session_start();								// Start/resume THIS session

	// PAGE SECURITY
	if (!isset($_SESSION['isAdmin']))
	{
		if ($_SESSION['isAdmin'] == 0)
		{
			echo '<script type="text/javascript">history.back()</script>';
			die();
		}
	}

	$_SESSION['title'] = "Manage Contact | MegaLAN";	// Declare this page's Title
	include("../includes/template.php"); 			// Include the template page
	include("../includes/conn.php"); 				// Include the database connection






?>



<!-- //******************************************************

// Name of File: editNotices.php
// Revision: 1.0
// Date: 09/05/2012
// Author: Quintin M
// Modified: Luke Spartalis

//***********************************************************

//*********** Start of EDIT NOTICES PAGE *************** -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type='text/javascript'>
	
	function faqVal()
	{
		var title = (document.addFAQ['question'].value).replace(/^\s*|\s*$/g,'');
		var message = (document.addFAQ['answer'].value).replace(/^\s*|\s*$/g,'');

		if (title == '')
		{
			alert('No question have been entered');
			document.addFAQ['question'].focus();
			return false;
		}
		if (message == '')
		{
			alert('No answer has been entered');
			document.addFAQ['answer'].focus();
			return false;
		}

		else
		{

				document.getElementById("question").value = question;
				document.getElementById("answer").value = answer;
				document.forms['addFAQ'].submit();
		}
	}


</script>
</head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Manage Contact Page</h1>




<!-- Interface Box -->
<div id='newsBox' align='center'>
<form name='MANcontact' enctype="multipart/form-data" method='POST' 
	  onsubmit='return faqVal()' action='MANFAQ.php'>
<br />

	<table cellpadding='5px' border='0'>

	<tr>
		<td align='right' style='vertical-align: top; color: #888888;'>
			Blur: <br /><br />
		</td>
<td>
			<textarea class='addNoticeBackColor addNoticeTextArea' 
			name='blur' rows='10' maxlength='1024' /></textarea>
		</td>
	</tr>




	<table border="1" bordercolor="#000000" style="background-color:#FFFFFF" width="400" cellpadding="3" cellspacing="3">
	<tr>
		<td>President:				<input type='text' name='president' maxlength='64' value=''/></td>
		<td>President IRC:			<input type='text' name='pre_irc' maxlength='64' value=''/></td>
	</tr>
	<tr>
		<td>Vice President:			<input type='text' name='v_president' maxlength='64' value=''/></td>
		<td>Vice President IRC:		<input type='text' name='vpre_irc' maxlength='64' value=''/></td>
	</tr>
	<tr>
		<td>Secretary:				<input type='text' name='secretary' maxlength='64' value=''/></td>
		<td>Secretary IRC:			<input type='text' name='sec_irc' maxlength='64' value=''/></td>
	</tr>
	<tr>
		<td>Treasurer:				<input type='text' name='treasurer' maxlength='64' value=''/></td>
		<td>Treasurer IRC:			<input type='text' name='tre_irc' maxlength='64' value=''/></td>
	</tr>
	<tr>
		<td>Tech Admin:				<input type='text' name='tech_admin' maxlength='64' value=''/></td>
		<td>Tech Admin IRC:			<input type='text' name='tec_irc' maxlength='64' value=''/></td>
	</tr>
	<tr>
		<td>Webmaster:				<input type='text' name='webmaster' maxlength='64' value=''/></td>
		<td>Webmaster IRC:			<input type='text' name='web_irc' maxlength='64' value=''/></td>
	</tr>
	<tr>
		<td>Social Coordinator:		<input type='text' name='soical_events' maxlength='64' value=''/></td>
		<td>Social Coordinator IRC:	<input type='text' name='soc_irc' maxlength='64' value=''/></td>
	</tr>
</table>








	<tr>
		<td colspan="2" align="center"><br /><input type="submit" name="submit" value="Update Contact Page" /></td>
	</tr>

	<tr><td colspan="2">&nbsp;</td></tr>

	<!-- ENSURES TO THE SERVER THERE EITHER IS OR IS NOT A FILE TO BE SAVED-->
	<input type='hidden' name='contactID' value='' />

	</table>
</form>
</div>






<br />







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