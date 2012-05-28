<?php
	session_start(); // Start/resume THIS session

	// PAGE SECURITY
	if (!isset($_SESSION['isAdmin']))
	{
		if ($_SESSION['isAdmin'] == 0)
		{
			echo '<script type="text/javascript">history.back()</script>';
			die();
		}
	}

	$_SESSION['title'] = "Manage Participants | MegaLAN";   // Declare this page's Title
	include("../includes/template.php");                        // Include the template page
        include("../includes/conn.php");

        unset($_SESSION['errMsg']);

	$username = $_SESSION['username'];
	$query = "SELECT * FROM client order by last_name DESC";
	$result = $db->query($query);
	$row = $result->fetch_array(MYSQLI_BOTH);
	$clientID = $row['clientID'];
        ?>


<!-- //******************************************************

// Name of File: participants.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Lyndon Smith
// Modified:

//***********************************************************

//******** Start of MANAGE PARTICIPANTS PAGE ************ -->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript">
//***************************************************************
//
// Calling this function creates a http request object and response
//
//****************************************************************
function createRequest (clientID, params, divName)
{


    if (clientID=="")

            {

                divName.innerHTML="";
                return;
            }
	if (window.XMLHttpRequest)
            {	// code for mainstream browsers
                    xmlhttp=new XMLHttpRequest();
                }
                else
                    {// code for earlier IE versions
                        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange=function()
                        {
                            if (xmlhttp.readyState==4 && xmlhttp.status==200)
                                {
                                    // The returned html gets placed in the location specified here
                                    divName.innerHTML=xmlhttp.responseText;


                                }
                        }
                        //Now we have the xmlhttp object, get the data using AJAX.

			xmlhttp.open("POST","selectclient.php",true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.setRequestHeader("Content-length", params.length);
			xmlhttp.setRequestHeader("Connection", "close");
			xmlhttp.send(params);



}

//************************************************************************************************
// Function to get initial data on load up
//
//************************************************************************************************
function getClientData()
{
    var clientID ="0";
    var divID = document.getElementById("clientTable");
    var params = "clientID=" + clientID + "&queryType=0&startRow=0";

		createRequest(clientID , params, divID);
}

//*************************************************************************************************
//************************************************************************************************
// Function to get next 5 records
//
//************************************************************************************************
function getClientNext5(startRow)
{
    var clientID ="0";
    var divID = document.getElementById("clientTable");
    var params = "clientID=" + clientID + "&queryType=0&startRow=" + startRow;

		createRequest(clientID , params, divID);
}

//*************************************************************************************************
//************************************************************************************************
// Function to find a client
//
//************************************************************************************************
function searchFunction()
{
    var surname = document.getElementById('searchTerm').value;
    var clientID ="0";
    var divID = document.getElementById("clientTable");
    var params = "clientID=" + clientID + "&queryType=0&startRow=0&surname=" + surname;

		createRequest(clientID , params, divID);
}

//*************************************************************************************************
//************************************************************************************************
// Function to find a client
//
//************************************************************************************************
function deleteUser(clientID)
{
  
   
    var divID = document.getElementById("clientTable");
    var params = "clientID=" + clientID + "&queryType=2&startRow=0";
    var message = "About to delete one user record. Proceed?"
    test = confirm(message);
    if (test == false)
        {
            return 0;
        }
     else{
         createRequest(clientID , params, divID);
        }
}

//*************************************************************************************************
</script>
</head>
<body onload="getClientData()">
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">
<h1>Client Management</h1>
<?php
echo '<hr />';
echo '<p><h2>Client List</h2></p>';
echo '<br />';
?>
<div id="clientTable"></div>
<?php
echo '<hr />';
echo '<p><h2>Client Details</h2></p>';
echo '<br />';
?>
<div id="clientDetails"></div>





<div id="eventTable"></div>
<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->
<!-- ********************************* -->

</div><!-- end of: Content -->


<!-- INSERT: rightPanel -->
<?php include('../includes/rightPanel.html'); ?>


<!-- INSERT: footer -->
<div id="footer">
	<?php include('..//includes/footer.html'); ?>
</div>

</div><!-- end of: Shell -->

</center>
</body>
</html>

<!-- ********************************* -->
<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->