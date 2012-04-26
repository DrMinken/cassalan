<?php 
	session_start();							// Start/resume THIS session
	$_SESSION['title'] = "Registration | MegaLAN"; 	// Declare this page's Title
	include("includes/template.php"); 			// Include the template page
	include("includes/conn.php"); 				// Include the database connection

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
	var change = 1;


	function regVal()
	{

	}
	function revealTeamName()
	{
		if (change == 1)
		{
			// Team Name
			document.getElementById('teamName').style.backgroundColor='white';
			document.getElementById('teamName').readOnly=false;

			// Team Password
			document.getElementById('teamPassword').style.backgroundColor='white';
			document.getElementById('teamPassword').readOnly=false;

			// CHANGE 'Select Team' back to none
			document.getElementById('userTeam').selectedIndex = 0;
			change = 0;
		}
		else 
		{
			// Team Name
			document.getElementById('teamName').style.backgroundColor='#F0F0F0';
			document.getElementById('teamName').readOnly=true;
			document.getElementById('teamName').value = '';

			// Team Password
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
			// Team Name
			document.getElementById('teamName').style.backgroundColor='#F0F0F0';
			document.getElementById('teamName').readOnly=true;
			document.getElementById('teamName').value = '';

			// Team Password
			document.getElementById('teamPassword').style.backgroundColor='#F0F0F0';
			document.getElementById('teamPassword').readOnly=true;
			document.getElementById('teamPassword').value = '';

			// UN-CHECK THE BOX
			document.getElementById('newTeam').checked = false;
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
		<td width='150px' align='right'>Select Team</td>
		<td>
			<select name='userTeam' id='userTeam' onclick='closeNewTeam(selectedIndex)'>
				<option value='0' selected='selected'>No Team</option>
				
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
		<td width='150px' align='right'>New Team</td>
		<td><input type='checkbox' name='newTeam' id='newTeam' onclick='revealTeamName()'></td>
	</tr>

	<tr>
		<td width='150px' align='right'>Enter Team Name</td>
		<td><input type='text' name='teamName' id='teamName' value='' size='30' maxlength='32' 
				   readonly='readonly' class='muteInput' /></td>
	</tr>

	<tr>
		<td width='150px' align='right'>Team Password</td>
		<td><input type='text' name='teamPassword' id='teamPassword' value='' size='30' maxlength='32' 
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
	

	<tr><td colspan='2' align='center'><br /><br />
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