<?php 
	session_start();							// Start/resume THIS session
	$_SESSION['title'] = "Registration | MegaLAN"; 	// Declare this page's Title
	include("includes/template.php"); 			// Include the template page
	include("includes/conn.php"); 				// Include the database connection

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

		$teamName = $_POST['teamName'];
		$teamPassword = $_POST['teamPassword'];

		$selectTeam = $_POST['selectTeam'];
		$selectPassword = $_POST['selectPassword'];

		$username = $email;
		$password = $_POST['password'];
		$passwordConfirm = $_POST['passwordConfirm'];

	// CHECK IF ANY INPUT ARE EMPTY

	// ^^^ end of empty checking


	// CHECK IF EMAIL EXISTS
		$check = "SELECT * FROM client WHERE email = '".$email."'";
		$result = $db->query($check);

		if ($result->num_rows > 0)
		{
			$_SESSION['regError'] = '*Your email already exists in our system!'; 
		}
	
	// CHECK IF NEW TEAM IS [on]
		if (isset($_POST['newTeam']))
		{
			// NEW TEAM [on]
			if ($_POST['newTeam'] == 'on')
			{
				// CHECK IF ENTERED TEAM NAME ALREADY EXISTS
				$check = "SELECT * FROM teams WHERE team_name = '".$teamName."'";
				$result = $db->query($check);

				// IF IT DOES, WRITE ERROR
				if ($result->num_rows > 0)
				{
					if (isset($_SESSION['regError']))
					{
						$_SESSION['regError'] .= '<br />*Your new Team Name already exists in our system!'; 
					}
					else
					{
						$_SESSION['regError'] = '*Your new Team Name already exists in our system!'; 
					}
				}
			}
		}
		// ELSE, CHECK IF USER SELECTED A PREDEFINED TEAM
		// ENSURE TEAM PASSWORD MATCHES
		else
		{
			$check = "SELECT * FROM teams WHERE teamID = '".$selectTeam."' AND team_password = '".$selectPassword."'";
			$result = $db->query($check);

			// IF PASSWORD IS INCORRECT, WRITE ERROR
			if ($result->num_rows != 1)
			{
				if (isset($_SESSION['regError']))
				{
					$_SESSION['regError'] .= '<br />*That Password is incorrect!'; 
				}
				else
				{
					$_SESSION['regError'] = '*That Password is incorrect!'; 
				}
			}
		}
	}

?>


<!-- //******************************************************

// Name of File: registration.php
// Revision: 1.0
// Date: 15/04/2012
// Author: Quintin M
// Modified: Quintin M 26/04/2012

//***********************************************************

//*************** Start of REGISTRATION PAGE ******************* -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type='text/javascript'>
	var change = 0;


	function regVal()
	{

	}
	function revealTeamName()
	{
		if (change == 1)
		{
			// Team Name [on]
			document.getElementById('teamName').style.backgroundColor='white';
			document.getElementById('teamName').readOnly=false;

			// Team Password [on]
			document.getElementById('teamPassword').style.backgroundColor='white';
			document.getElementById('teamPassword').readOnly=false;

			// Select Team [off]
			document.getElementById('selectTeam').selectedIndex = 0;

			// Select Password [off]
			document.getElementById('selectPassword').style.backgroundColor='#F0F0F0';
			document.getElementById('selectPassword').readOnly=true;
			document.getElementById('selectPassword').value = '';

			change = 0;
		}
		else 
		{
			// Team Name [off]
			document.getElementById('teamName').style.backgroundColor='#F0F0F0';
			document.getElementById('teamName').readOnly=true;
			document.getElementById('teamName').value = '';

			// Team Password [off]
			document.getElementById('teamPassword').style.backgroundColor='#F0F0F0';
			document.getElementById('teamPassword').readOnly=true;
			document.getElementById('teamPassword').value = '';
			change = 1;
		}
	}
	function updateUsername(email)
	{
		document.getElementById('username').value = email;
	}
	function closeNewTeam(index)
	{
		if (index > 0)
		{
			// Team Name [off]
			document.getElementById('teamName').style.backgroundColor='#F0F0F0';
			document.getElementById('teamName').readOnly=true;
			document.getElementById('teamName').value = '';

			// Team Password [off]
			document.getElementById('teamPassword').style.backgroundColor='#F0F0F0';
			document.getElementById('teamPassword').readOnly=true;
			document.getElementById('teamPassword').value = '';

			// CHECK THE BOX [off]
			document.getElementById('newTeam').checked = false;

			// Select Password [on]
			document.getElementById('selectPassword').style.backgroundColor='white';
			document.getElementById('selectPassword').readOnly=false;
			document.getElementById('selectPassword').value = '';
		}
		else
		{
			// Team Name
			document.getElementById('teamName').style.backgroundColor='white';
			document.getElementById('teamName').readOnly=false;

			// Team Password
			document.getElementById('teamPassword').style.backgroundColor='white';
			document.getElementById('teamPassword').readOnly=false;

			// CHECK THE BOX
			document.getElementById('newTeam').checked = true;
		}
	}
	function checkPassword(value)
	{
		if (value.length < 8)
		{
			document.getElementById('passError').src = "images/layers/cross.png";
		}
		else
		{
			document.getElementById('passError').src = "images/layers/tick.png";
		}
	}
	function checkConPassword(confirm)
	{
		if (confirm != document.getElementById('password').value)
		{
			document.getElementById('conPassError').src = "images/layers/cross.png";
		}
		else if (confirm.length < 1)
		{
			document.getElementById('conPassError').src = "images/layers/cross.png";
		}
		else
		{
			document.getElementById('conPassError').src = "images/layers/tick.png";
		}
	}
</script>

</head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
	<h1>MegaLAN Registration</h1>



	<!-- FORM: Registration -->
	<table id='registrationTable' border='0' width='500px' cellspacing='3px'>
	<form name='registration' method='POST' onsubmit='return regVal()' action='register.php'>

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
		<td width='150px' align='right'>First Name</td>
		<td><input type='text' name='firstName' value='Enter Text' size='30' maxlength='32' 
				   onclick='this.value=""' /></td>
	</tr>
	<tr>
		<td width='150px' align='right'>Last Name</td>
		<td><input type='text' name='lastName' value='Enter Text' size='30' maxlength='32' 
				   onclick='this.value=""' /></td>
	</tr>
	<tr>
		<td width='150px' align='right'>Email</td>
		<td><input type='text' name='email' value='Enter Text' size='30' maxlength='256' 
				   onclick='this.value=""' onkeyup='updateUsername(this.value)' /></td>
	</tr>
	<tr>
		<td width='150px' align='right'>Mobile</td>
		<td><input type='text' name='mobile' value='Enter Text' size='30' maxlength='128' 
				   onclick='this.value=""' /></td>
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



	<tr><td colspan='2'><hr /></td></tr>



	<tr>
		<td width='150px' align='right'>New Team</td>
		<td><input type='checkbox' name='newTeam' id='newTeam' checked='checked' onclick='revealTeamName()'></td>
	</tr>

	<tr>
		<td width='150px' align='right'>Team Name</td>
		<td><input type='text' name='teamName' id='teamName' value='' size='30' maxlength='32' 
				    /></td>
	</tr>

	<tr>
		<td width='150px' align='right'>Team Password</td>
		<td><input type='text' name='teamPassword' id='teamPassword' value='' size='30' maxlength='32' 
				   /></td>
	</tr>



	<tr><td colspan='2'><hr /></td></tr>



	<tr>
		<td width='150px' align='right'>Select Team</td>
		<td>
			<select name='selectTeam' id='selectTeam' onclick='closeNewTeam(selectedIndex)'>
				<option value='0' selected='selected'>-- NO TEAM --</option>
				
				<!-- GET ALL TEAMS FROM DATABASE -->
				<?php
					$get = "SELECT * FROM teams";
					$result = $db->query($get);
					
					for ($i=0; $i<$result->num_rows; $i++)
					{
						$row = $result->fetch_assoc();
						$teamID = $row['teamID'];
						$team_name = $row['team_name'];

						echo '<option value='.$teamID.'>'.$team_name.'</option>';
					}
				?>
			</select>
		</td>
	</tr>

	<tr>
		<td width='150px' align='right'>Password</td>
		<td><input type='text' name='selectPassword' id='selectPassword' value='' size='30' maxlength='32'
					readonly='readonly' class='muteInput' /></td>
	</tr>



	<tr><td colspan='2'><hr /></td></tr>



	<tr>
		<td width='150px' align='right'>Username</td>
		<td><input type='text' class='readonly' name='username' id='username' size='30' maxlength='256' readonly='readonly' /></td>
	</tr>

	<tr>
		<td width='150px' align='right'>Password</td>
		<td><input type='password' name='password' id='password' size='30' maxlength='30' onkeyup='checkPassword(this.value)' /> <img id='passError' src='' border='0' /></td>
	</tr>

	<tr>
		<td width='150px' align='right'>Re-enter Password</td>
		<td><input type='password' name='passwordConfirm' id='passwordConfirm' size='30' maxlength='30' onkeyup='checkConPassword(this.value)' /> <img id='conPassError' src='' border='0' /></td>
	</tr>
	

	<tr><td colspan='2' align='center'><br />
		<input type='submit' name='submit' value='Submit' />
	</td></tr>



	</form>
	</table><!-- end of: FORM Registration -->






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