<?php 
    session_start();                                                        // Start/resume THIS session
    $_SESSION['title'] = "Event Management | MegaLAN";         // Declare this page's Title
    include("includes/template.php");                                 // Include the template page
    include("includes/conn.php");                                     // Include the db connection
?>


<!-- //******************************************************

// Name of File: MANtournament.php
// Revision: 1.0
// Date: 07/05/2012
// Author: Tinashe Masvaure
// Modified: 

//***********************************************************

//********** Start of MANAGE CONTACTS PAGE ************** -->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
//***************************************************************
//
// Ajax Function to create summary table on page.
//
//****************************************************************
function getEvent(tournID)
{
    if (tournID=="")
        
          {
              document.getElementById("tournamentTable").innerHTML="";
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
                                document.getElementById("tournamentTable").innerHTML=xmlhttp.responseText;
                                }
                        }
 //Now we have the xmlhttp object, get the data using AJAX.
        var params = "tournID=" + tournID;        
                xmlhttp.open("POST","SELtournament.php",true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xmlhttp.setRequestHeader("Content-length", params.length);
                    xmlhttp.setRequestHeader("Connection", "close");
                xmlhttp.send(params);
}


</script>
        </head>
            <body>
        <center>
    <div id='shell'>
<!-- Main Content [left] -->
    <div id="content">
        <h1>Tournament Management</h1>
<?php
//***********************************************
// Set some variables up for use
//***********************************************

$username = $_SESSION['username'];
$query = "SELECT * FROM tournament";
$result = $db->query($query);

    echo '<hr />';
        echo '<p><h2>Current Tournaments</h2></p>';
            echo '<FORM>';
                echo '<P>';
            echo '<SELECT size="6" name="selectTournament" onchange = getTournament(this.value)>';

// Now we can output the option fields to populate the list box.
for ($i = 0; $i < $result->num_rows;$i++) 
    {
        $row = $result->fetch_array(MYSQLI_BOTH);    
    echo '<OPTION value="' . $row['tournID']. '">' . $row['name'] . '</OPTION><br />';
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