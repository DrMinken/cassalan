<!-- //******************************************************

// Name of File: Event_Tournament_Details.php
// Revision: 1.0
// Date: 28/05/2012
// Author: Tinashe Masvaure
// Modified: 

//***********************************************************

//********** Start PAGE ************** -->
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

   // $username = $_SESSION['username'];
    $query = "SELECT * FROM tournament";
    $result = $db->query($query);
    $row = $result->fetch_array(MYSQLI_BOTH);    
    $tournID = $row['tournID'];
?>

<html xmlns="http://www.w3.org/1999/xhtml">
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
                xmlhttp.open("POST","SELDetails.php",true);
                  
                
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xmlhttp.setRequestHeader("Content-length", params.length);
                    xmlhttp.setRequestHeader("Connection", "close");
                xmlhttp.send(params);
                
                
}

//***************************************************************


//***************************************************************

//********************************************************************************************************

</script>
        </head>
        
            <body onload="getTournament( <?php echo $tournID;?>  )"> 
            
        <center>
    <div id='shell'>
<!-- Main Content [left] -->
    <div id="content">
        <h1>Event Details</h1>    
<?php
//***********************************************
// Set some variables up for use
//***********************************************


    echo '<hr />';
        echo '<p><h2>Started Events</h2></p>';
              echo '<br />';
            echo '<FORM>';
                echo '<P>';
            echo '<SELECT name="selectTournament" onchange = getTournament(this.value)>';
          
    
    
    $result = $db->query($query);
// Now we can output the option fields to populate the list box.
for ($i = 0; $i < $result->num_rows;$i++) 
    {
        $row = $result->fetch_array(MYSQLI_BOTH);    
        
        if ($i==0)
        {
             
        $get = "SELECT * FROM event WHERE event_completed=0";
        $result = $db->query($get);
        
        for ($i=0; $i<$result->num_rows; $i++)
        {
            $row = $result->fetch_assoc();
            
            echo '<option value="'.$row['eventID'].'">'.$row['event_name'].'</option>';
            
           
        } 
            
        }
        else
        {
             
        $get = "SELECT * FROM event WHERE event_completed=0";
        $result = $db->query($get);
        
        for ($i=0; $i<$result->num_rows; $i++)
        {
            $row = $result->fetch_assoc();
            
            echo '<option value="'.$row['eventID'].'">'.$row['event_name'].'</option>';
        }
    
        }
    }

        echo '</SELECT>';
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