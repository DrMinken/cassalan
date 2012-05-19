
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

   

    include("../includes/template.php");                                 // Include the template page
    include("../includes/conn.php");                                     // Include the db connection

   // $username = $_SESSION['username'];
  //  $query = "SELECT * FROM tournament";
   // $result = $db->query($query);
   // $row = $result->fetch_array(MYSQLI_BOTH);    
    //$tournID = $row['tournID'];
?>


<!
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
         <p><h2>Create Tournament</h2></p> 
     
   <form name="Tournament" action = 'contact.php' method='POST'>
     <br>
     <table border="1" width="400">
    <tr>
    <td>Enter Tournament Name:</td>
    <td><input type='text' name='name' size='64'></td>
    </tr>
    <tr>
    <td>Enter Tournament Date:</td>
    <td><input type='text' name='date'></td>
    </tr>
    <tr>
    <td>Enter Start Time:</td>
    <td><input type='time' name='start_time'></td>
    </tr>
    <tr>
    <td>Enter End Time:</td>
    <td><input type='time' name='end_time'></td>
    </tr>
    </table>
<p><input type='submit' name='submit' value='Create Tournament'>
  </form>
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