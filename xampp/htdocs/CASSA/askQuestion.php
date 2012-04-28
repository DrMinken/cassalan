<?php 
	session_start();									// Start/resume THIS session
	$_SESSION['title'] = "Got A Question? | MegaLAN"; 	// Declare this page's Title
	include("includes/template.php"); 					// Include the template page
?>


<!-- //******************************************************

// Name of File: askQuestion.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Quintin M
// Modified: 

//***********************************************************

//*************** Start of ASK A QUESTION PAGE ******************* -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type='text/javascript'>
	// ENSURE TEXTAREA DOES NOT EXCEED 300 CHARACTERS
	function checkLength()
	{
		var msg = document.getElementById('message').value;
		var msgLength = document.getElementById('message').value.length;

		if (msgLength > 300)
		{
			msg = msg.substring(0, 300);
			document.getElementById('message').value = msg;
		}
		else
		{
			document.getElementById('count').innerHTML = msgLength;
		}
	}

	// VALIDATE FORM: Question
	function questionVal()
	{
		if (document.question['name'].value == '' || document.question['name'].value == 'Enter Text')
		{
			alert('Name not entered');
			document.question['name'].focus();
			return false;
		}
		if (document.question['email'].value == '' || document.question['email'].value == 'Enter Text')
		{
			alert('Email not entered');
			document.question['email'].focus();
			return false;
		}
		if (document.question['subject'].value == '' || document.question['subject'].value == 'Enter Text')
		{
			alert('Subject not entered');
			document.question['subject'].focus();
			return false;
		}
		if (document.question['message'].value == '')
		{
			alert('Message not entered');
			document.question['message'].focus();
			return false;
		}
	}
	</script>
</head>

<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Got A Question?</h1>



<!-- Ask A Question -->
<div id='askQuestionDIV'>
<form name='question' method='POST' onsubmit='return questionVal()' action='askQuestion.php'>
	<div align='left'>
		Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='text' name='name' size='30' maxlength='64' value='Enter Text' 
 				   onclick='this.value=""'/><br />

		Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='text' name='email' size='30' maxlength='128' value='Enter Text' 
				   onclick='this.value=""'/><br />
		
		Subject&nbsp;&nbsp;
			<input type='text' name='subject' size='30' maxlength='64' value='Enter Text' 
				   onclick='this.value=""'/><br /><br />
	</div>
	<textarea class='messageArea' name='message' id='message' wrap='hard' onkeyup='checkLength()' ></textarea>
	
	<table border='0'>
	<tr>
		<td width='570px' align='right'>(<label id='count'>0</label>/300)</td>
		<td width='30px'><input type='submit' name='submit' value='Submit' maxlength='100' /></td>
	</tr>
	</table>
</form>
</div><!-- end of: Ask A Question -->




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