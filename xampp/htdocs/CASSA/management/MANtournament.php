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

    include("../includes/template.php");                                 // Include the template page
    include("../includes/conn.php");                                     // Include the db connection

    $username = $_SESSION['username'];
    $query = "SELECT * FROM tournament";
    $result = $db->query($query);
    $row = $result->fetch_array(MYSQLI_BOTH);    
    $tourID = $row['tournID'];
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

<form action ='CreateTournament.php' method ='POST'>
    <table>
    <tr>
    <td>
Enter Tournament Name:
    </td>
    <td>
    <input type='text' name='name'>
    </td>
    </tr>
    <tr>
    <td>
Enter Tournament Date yyyy/mm/dd:
    </td>
    <td>
    <input type='date' name='date'>
    </td>
    </tr>
    <tr>
    <td>
Enter Start Time hh:mm:ss:
    </td>
    <td>
    <input type='time' name='start_time'>
    </td>
    </tr>
    <tr>
    <td>    
Enter End Time:    
    </td>
    <td>
    <input type='time' name='end_time'>
    </td>
    </tr>
    </table>
<p>
<input type='submit' name='submit' value='Create'>


</form>



<head>
<script type="text/javascript">
//***************************************************************
//
// Ajax Function to create summary table on page.
//
//****************************************************************
function getTournament(tournID)
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
        var params = "tournID=" + tournID + "&queryType=0";        
                xmlhttp.open("POST","SELtournament.php",true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xmlhttp.setRequestHeader("Content-length", params.length);
                    xmlhttp.setRequestHeader("Connection", "close");
                xmlhttp.send(params);
}



//***************************************************************


//********************************************************************************************************

</script>
        </head>
        
            <body onload="getTournament( <?php echo $tourntID; $result->close();?>  )">
            
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
        echo '<p><h2>Current Tournament</h2></p>';
            echo '<FORM>';
                echo '<P>';
            echo '<SELECT size="6" name="selectTournament" onchange = getTournament(this.value)>';
    
    
    $result = $db->query($query);
// Now we can output the option fields to populate the list box.
for ($i = 0; $i < $result->num_rows;$i++) 
    {
        $row = $result->fetch_array(MYSQLI_BOTH);    
        
        if ($i==0)
        {
            echo '<OPTION value="'.$row['tournID'].'" selected="selected">' . $row['name'] . '</OPTION><br />';            
        }
        else
        {
            echo '<OPTION value="'.$row['tournID'].'">' . $row['name'] . '</OPTION><br />';
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