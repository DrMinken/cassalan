<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 

<?php 
	session_start();									// Start/resume THIS session
	$_SESSION['title'] = "Manage Details | MegaLAN"; 	// Declare this page's Title
	include("../includes/template.php"); 				// Include the template page
	include("../includes/conn.php"); 					// Include the database connection

	// REGISTRATION FORM SUBMISSION
	if (isset($_POST['submit']))
	{

	// SECURE AND ASSIGN POST VARIABLES 
		// TRIM all posted values
		$_POST = array_map('trim', $_POST);
		
		// REJECT all real escape strings (security)
		$_POST = array_map('mysql_real_escape_string', $_POST);
		

	// SET REGISTRATION VARIABLES
		//print_r($_POST);
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$email = htmlspecialchars($_POST['email']);

		$mobile = $_POST['mobile'];
		$userType = $_POST['userType'];

		$password = $_POST['password'];
		$passwordConfirm = $_POST['passwordConfirm'];


	// CHECK IF ANY INPUT ARE EMPTY OR DO NOT COMPLY
		if ($firstName == '' || $firstName == 'Enter Text')
		{
			$_SESSION['errMsg'][0] = '<font class="error">*</font>';
		}
		if ($lastName == '' || $lastName == 'Enter Text')
		{
			$_SESSION['errMsg'][1] = '<font class="error">*</font>';
		}
		if ($email == '' || $email == 'Enter Text')
		{
			$_SESSION['errMsg'][2] = '<font class="error">*</font>';
		}
		if ($mobile == '' || $mobile == 'Enter Text')
		{
			$_SESSION['errMsg'][3] = '<font class="error">*</font>';
		}
			else if (!is_numeric($mobile))
			{
				$_SESSION['errMsg'][3] = '<font class="error">*</font>';
			}
			else if (strlen($mobile) < 10)
			{
				$_SESSION['errMsg'][3] = '<font class="error">* Must be 10 digits</font>';
			}
		if ($password == '')
		{
			$_SESSION['errMsg'][4] = '<font class="error">*</font>';
		}
			else if (strlen($password) < 8)
			{
				$_SESSION['errMsg'][5] = '<font class="error">Minimum 8 characters</font>';
			}
		if ($passwordConfirm != $password)
		{
			$_SESSION['errMsg'][6] = '<font class="error">Does not match</font>';
		}
	// ^^^ end of empty checking


	// CHECK IF EMAIL EXISTS
		$check = "SELECT * FROM client WHERE email = '".$email."' AND clientID != '".$_SESSION['userID']."'";
		$result = $db->query($check);

		if ($result->num_rows > 0)
		{
			$_SESSION['errMsg'][7] = '<font class="error">Email already exists in our system</font>'; 
		}


	// IF NO ERRORS, ADD TO DATABASE
		if (!isset($_SESSION['errMsg']))
		{
			// UPDATE TO DATABASE
			$update = "UPDATE client SET first_name='".$firstName."', last_name='".$lastName."', email='".$email."', mobile='".$mobile."', password='".$password."' WHERE clientID='".$_SESSION['userID']."'";
			$result = $db->query($update);


			// SEND EMAIL
			$to			= $email;
			$subject	= 'MegaLAN - Registration';
			$message	= '<div class="">';
			$message	.= '';
			
			$headers	= 'MIME-Version: 1.0' . "\r\n";
			$headers	.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers	.= 'From: webmaster@megalan.com' . "\r\n";
			//$mail ($to, $subject, $message, $headers);
		}
	}
?>


<!-- //******************************************************

// Name of File: MANdetails.php
// Revision: 1.0
// Date: 14/05/2012
// Author: Quintin M
// Modified:

//***********************************************************

//************ Start of MANAGE DETAILS PAGE ************* -->

<head>
<script type='text/javascript'>
	var change = 0;

	function regVal()
	{

	}
	function checkPassword(value)
	{
		if (value.length < 8)
		{
			document.getElementById('passError').style.visibility = 'visible';
 			document.getElementById('passError').src = "/cassa/images/layers/cross.png";
		}
		else
		{
			document.getElementById('passError').src = "/cassa/images/layers/tick.png";
		}
	}
	function checkConPassword(confirm)
	{
		if (confirm != document.getElementById('password').value)
		{
			document.getElementById('conPassError').style.visibility = 'visible';		
			document.getElementById('conPassError').src = "/cassa/images/layers/cross.png";
		}
		else if (confirm.length < 1)
		{
			document.getElementById('conPassError').style.visibility = 'visible';
			document.getElementById('conPassError').src = "/cassa/images/layers/cross.png";
		}
		else
		{
			document.getElementById('conPassError').src = "/cassa/images/layers/tick.png";
		}
	}
</script>

</head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>Manage Details</h1>



	<br />


	<!-- GET [this] USERS CURRENT INFORMATION -->
	<?php
		$get = "SELECT * FROM client WHERE clientID = '".$_SESSION['userID']."'";
		$result = $db->query($get);
		$row = $result->fetch_assoc();
	?>



	<!-- FORM: Registration -->
	<table id='registrationTable' border='0' width='630px' cellspacing='3px'>
	<form name='registration' method='POST' onsubmit='return regVal()' action='/cassa/management/MANdetails.php'>

	<?php if (isset($_SESSION['regError']))
	{?>
		<tr>
			<td colspan='2' align='left'>
				<font class='error'><?php echo $_SESSION['regError']; unset($_SESSION['regError']); ?></font>
			</td>
		</tr>
		<?php 
	}?>

	<tr><td colspan='2' align='left'><b>Participant Details</b></td></tr>
	<tr>
		<td width='150px' align='right'><?php if (isset($_SESSION['errMsg'][0])) echo $_SESSION['errMsg'][0]; ?> First Name</td>
		<td><input type='text' name='firstName' value='<?php echo $row['first_name']; ?>' size='30' maxlength='32' /></td>
	</tr>

	<tr>
		<td width='150px' align='right'><?php if (isset($_SESSION['errMsg'][1])) echo $_SESSION['errMsg'][1]; ?> Last Name</td>
		<td><input type='text' name='lastName' value='<?php echo $row['last_name']; ?>' size='30' maxlength='32' /></td>
	</tr>

	<tr>
		<td width='150px' align='right'><?php if (isset($_SESSION['errMsg'][2]))  echo $_SESSION['errMsg'][2]; ?> Email</td>
		<td><input type='text' name='email' value='<?php echo $row['email']; ?>' size='30' maxlength='256' />
				   <?php if (isset($_SESSION['errMsg'][7]))  echo $_SESSION['errMsg'][7]; ?>
		</td>
	</tr>

	<tr>
		<td width='150px' align='right'><?php if (isset($_SESSION['errMsg'][3])) echo $_SESSION['errMsg'][3]; ?> Mobile</td>
		<td><input type='text' name='mobile' value='<?php echo $row['mobile']; ?>' size='30' maxlength='128' /></td>
	</tr>

	<tr>
		<td width='150px' align='right'>Select Type</td>
		<td>
			<select name='userType'>
				<option value='0' selected='selected'>Non Member</option>
				<option value='1'>CASSA Member</option>		
			</select> <font size='1'><a href='http://www.cassa.org.au/payments/membership/'>(CASSA member?)</a></font>
		</td>
	</tr>

	<tr>
		<td width='150px' align='right'>Username</td>
		<td><input type='text' class='readonly' name='username' id='username' size='30' maxlength='256' readonly='readonly' value='<?php echo $row['username']; ?>' /></td>
	</tr>

	<tr>
		<td width='150px' align='right'><?php if (isset($_SESSION['errMsg'][4])) echo $_SESSION['errMsg'][4]; ?> Password</td>
		<td><input type='password' name='password' id='password' size='30' maxlength='30' 
			value='<?php echo $row['password']; ?>' onkeyup='checkPassword(this.value)' />
			<?php if (isset($_SESSION['errMsg'][5])) echo $_SESSION['errMsg'][5]; ?> 
			<img id='passError' src='/cassa/images/layers/tick.png' border='0' style='visibility: visible;' />
		</td>
	</tr>

	<tr>
		<td width='150px' align='right'>Re-enter Password</td>
		<td><input type='password' name='passwordConfirm' id='passwordConfirm' size='30' 
			value='<?php echo $row['password']; ?>' maxlength='30' onkeyup='checkConPassword(this.value)' /> 
			<?php if (isset($_SESSION['errMsg'][6])) echo $_SESSION['errMsg'][6]; ?> 
			<img id='conPassError' src='/cassa/images/layers/tick.png' border='0' style='visibility: visible;' />
		</td>
	</tr>
	

	<?php if (isset($_SESSION['errMsg'])) unset($_SESSION['errMsg']); ?>

	<tr><td colspan='2' align='center'><br />
		<input type='submit' name='submit' value='Submit' />
	</td></tr>



	</form>
	</table><!-- end of: FORM Registration -->






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