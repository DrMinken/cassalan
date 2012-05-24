
 <!-- //******************************************************

// Name of File: CreateTournament.php
// Revision: 1.0
// Date: 13/05/2012
// Author: Tinashe Masvaure
// Modified:

//***********************************************************
//This script works in conjuction with the MANtournament.php script.
//it acts as partner script and provides the details of the event
//selected in the list box. 
//********** Start of select event script **************--> 
 
  <?php 
  //  session_start();                                                    // Start/resume THIS session

    // PAGE SECURITY
    //if (!isset($_SESSION['isAdmin']))
    //{
        //if ($_SESSION['isAdmin'] == 0)
        //{
            //echo '<script type="text/javascript">history.back()</script>';
        //    die();
        //}
//    }

   

    include("../includes/template.php");                                 // Include the template page
  include("../includes/conn.php");                                     // Include the db connection

$id = $_POST["id"];
$name = $_POST["name"];
$date = $_POST["date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$winner = $_POST["winner"];
$started = $_POST["started"];
$finished = $_POST["finished"];

$sql = "UPDATE tournament SET name = '$name', date ='$date', start_time = '$start_time', end_time ='$end_time', winner='$winner',
started = '$started', finished = '$finished' WHERE tournID = $id";


 $result = $db->query($sql);                                             
             

header('refresh:4; url = CreateTournament.php');



?>





<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
//***************************************************************
//


</script>
        </head>
        
            <body 
           
            
            
            >
            
        <center>
    <div id='shell'>
<!-- Main Content [left] -->
    <div id="content">
        <h1>Tournament Management</h1>

<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->
<!-- ********************************* -->
<!--This is where the summary table ends up.-->
            <div 
              <br>
    <br>
     <?php echo"Update Complete...please wait";?>


            
      </div>
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





