
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
    include("../includes/conn.php");
      $tournID = $_POST['tournID'];                                                // Retrieve the search value.    
    $queryType = $_POST['queryType'];                                      // Include the db connection

    //$username = $_SESSION['username'];
    // query the tournament table
  //  $query = "SELECT * FROM tournament";
    //$result = $db->query($query);
                                         // Retrieve the query Identifier.
                                                                                    
    //if($queryType == 1)
      //      {
        //        $query = "SELECT * FROM tournament WHERE tournID =" . $tournID;        //Create the general select query.
          //      ajax_tournament_table_edit($db, $tournID);
            //}
            
            
    //function ajax_tournament_table_edit($db, $tournID)
    //{
    
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
         <p><h2>Edit Tournament</h2></p> 
     
 
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