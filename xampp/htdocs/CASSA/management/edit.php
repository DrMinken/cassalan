
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

    //$username = $_SESSION['username'];
	$id = $_GET["id"];
    $sql = "SELECT * FROM tournament WHERE tournID = $id";
  // $result = mysql_query($sql);

    $result = $db->query($sql);                                             
    $num = $result->fetch_array(MYSQLI_BOTH);
    //$num = $mysql_fetch_array($result);    
     
    
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
         
<h1>Edit Tournament</h1>
<form action="Update.php" method = "POST">
<input type ='hidden' name='id' value="<? echo $num['tournID']?>">
Tournament Name:<input type ="text" name = "name" value ="<?php echo $num['name']?>"><br>
Tournament Date: <input type ="date" name = "date" value ="<?php echo $num['date']?>"><br>
Tournament Start Time: <input type ="time" name = "start_time" value ="<?php echo $num['start_time']?>"><br>
Tournament End Time: <input type ="time" name = "end_time" value ="<?php echo $num['end_time']?>"><br>
Tournament Winner: <input type ="text" name = "winner" value ="<?php echo $num['winner']?>"><br>
Tournament Started: <input type ="text" name = "started" value ="<?php echo $num['started']?>"><br>
Tournament Finished: <input type ="text" name = "finished" value ="<?php echo $num['finished']?>"><br>
<input type = "submit" name = "submit" value ="submit">
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




