<!-- //******************************************************

// Name of File: index.php
// Revision: 1.0
// Date: 30/04/2012
// Author: Tinashe
// Modified: 5/05/2012

//************************************************************ -->
<html>
<h1>Registration</h1>

<?php 
    session_start();                                                    // Start/resume THIS session

    // PAGE SECURITY
    //if (!isset($_SESSION['isAdmin']))
    //{
        //if ($_SESSION['isAdmin'] == 0)
        //{
            //echo '<script type="text/javascript">history.back()</script>';
        //    die();
        //}
//    }

    $_SESSION['title'] = "Tournament Management | MegaLAN";                     // Declare this page's Title

    include("./includes/template.php");                                 // Include the template page
    include("./includes/conn.php");                                     // Include the db connection

  //  $username = $_SESSION['username'];
    $query = "SELECT * FROM client";
    $result = $db->query($query);
    $row = $result->fetch_array(MYSQLI_BOTH);    
    $clientID = $row['clientID'];
?>


<!-- //******************************************************

// Name of File: MANevent.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Lyndon Smith
// Modified: 

//***********************************************************

//********** Start of MANAGE CONTACTS PAGE ************** -->

<html xmlns="http://www.w3.org/1999/xhtml">
<!-- //******************************************************

// Name of File: index.php
// Revision: 1.0
// Date: 30/04/2012
// Author: Tinashe
// Modified: 5/05/2012

//************************************************************ -->

<h1>Create New Tournament</h1>

<form action ='registrationB.php' method ='POST'>
    <table>
    <tr>
    <td>
Enter a password:
    </td>
    <td>
    <input type='password' name='password'>
    </td>
    </tr>
    <tr>
    <td>
Repeat Your Password:
    </td>
    <td>
    <input type='password' name='repeatpassword'>
    </td>
    </tr>
    <tr>
    <td>
Enter Your First Name:
    </td>
    <td>
    <input type='text' name='first_name'>
    </td>
    </tr>
    <tr>
    <td>    
Enter Your Last Name:    
    </td>
    <td>
    <input type='text' name='last_name'>
    </td>
    </tr>
    <tr>
    <td>
Enter Your Mobile Number:
    </td>
    <td>
    <input type='text' name='mobile'>
    </td>
    </tr>
    <tr>
    <td>
Enter Your Email:
    </td>
    <td>
    <input type='text' name='email'>
    </td>
    </tr>
    </table>
<p>
<input type='submit' name='submit' value='Register'>


</form>





<head>
<script type="text/javascript">
//***************************************************************
//
// Ajax Function to create summary table on page.
//
//****************************************************************

 ////////////////////////////////////////////////////////////////
function createTournament(clientID)
{
    if (clientID=="")
        
          {
              document.getElementById("clientTable").innerHTML="";
              return;
          } 
    if (window.XMLHttpRequest)
                  {    // code for mainstream browsers
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
                                document.getElementById("clientTable").innerHTML=xmlhttp.responseText;
                                }
                        }
 //Now we have the xmlhttp object, get the data using AJAX.
        var params = "clientID=" + clientID + "&queryType=1";        
                xmlhttp.open("POST","registrationB.php",true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xmlhttp.setRequestHeader("Content-length", params.length);
                    xmlhttp.setRequestHeader("Connection", "close");
                xmlhttp.send(params);
}



//***************************************************************


//********************************************************************************************************

</script>
        </head>
        
            <body onload="createTournament( <?php echo $clientID; $result->close();?>  )">
            
        <center>
    <div id='shell'>
<!-- Main Content [left] -->
    <div id="content">
        <h1>Tournament Management</h1>
<?php
//***********************************************
// Set some variables up for use
//***********************************************


    echo '<hr />';
        echo '<p><h2>Current Registered</h2></p>';
            echo '<FORM>';
                echo '<P>';
            echo '<SELECT size="6" name="selectTournament" onchange = createTournament(this.value)>';
    
    
    $result = $db->query($query);
// Now we can output the option fields to populate the list box.
for ($i = 0; $i < $result->num_rows;$i++) 
    {
        $row = $result->fetch_array(MYSQLI_BOTH);    
        
        if ($i==0)
        {
            echo '<OPTION value="'.$row['clientID'].'" selected="selected">' . $row['first_name'] . '</OPTION><br />';            
        }
        else
        {
            echo '<OPTION value="'.$row['clientID'].'">' . $row['first_name'] . '</OPTION><br />';
        }
    }

        echo '</SELECT>';
            echo '<br />';
               echo '<INPUT type="submit" value="Send"><INPUT type="reset">';
               echo '</P>';
            echo '</FORM>';
        echo '<hr />';

?>
<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->
<!-- ********************************* -->
<!--This is where the summary table ends up.-->
            <div id="tournamentTable"></div>
<!--**************************************** -->

</div><!-- end of: Content -->
<!-- INSERT: rightPanel -->
<?php include('./includes/rightPanel.html'); ?>
<!-- INSERT: footer -->
<div id="footer">
    <?php include('./includes/footer.html'); ?>
</div>


</div><!-- end of: Shell -->

</center>
</body>
</html>

<!-- ********************************* -->
<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->

