
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
//********** Start of Create Tournament script **************--> 
   
   
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
         <p><h2>Create and Edit Tournament</h2></p> 
     
     <form name="Tournament" action = 'contact.php' method='POST'>
     <br>
     <table border="1" width="400">
    <tr>
    <td>Enter Tournament Name:</td>
    <td><input type='text' name='name'></td>
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
            <?php
                  //$username = $_SESSION['username'];
    $query = "SELECT * FROM tournament";
   $result = $db->query($query);
    $row = $result->fetch_array(MYSQLI_BOTH);    
   // $tournID = $row['tournID'];
    
    // check to see if tournament table exists, if not create it
    
  //  $check = mysql_query("SELECT * FROM 'tournament' LIMIT 0,1");
    //if ($check){
        
        
        
    //}
    //else {
        // create the tournament
    //}
    
    // query all the in the tournament table
    
    //$query = "SELECT * FROM tournament";
    //$result = mysql_query($query);
    //mysql_close();
    
    // $query = "SELECT * FROM tournament";// WHERE tournID =" . $tournID;                 //Create the general select query.
      //       $result = $db->query($query);                                             
        //     $row1 = $result->fetch_array(MYSQLI_BOTH);                                //use it first for the title
          //   $result->close();                                                                //then close it ready for the next execution
            // $result = $db->query($query);   
 //  mysql_close();
   // $row = $result->fetch_array(MYSQLI_BOTH);    
    //$tournID = $row['tournID'];
    // first row
    
   echo "<br><h1> Created Tournaments</h1>";
    echo "<table border='1' CELLPADDING = 5 width= '400' STYLE='font-size:13px'>";
    echo "<tr><td><H4> Name</h3></td>";
    echo '<td colspan="2"><H3> Date</h3></td>';
      echo "<td><H4> start time</h3></td>";
       echo "<td><H4> end time</h3></td>";
        echo "<td><H4> winner</h3></td>";
         echo "<td><H4> started</h3></td>";
          echo "<td><H4> finished</h3></td></tr>";
          
    // second row
    while($row = $result->fetch_array(MYSQLI_BOTH)) 
    {
        // Put all the contents of each row into table
        
        echo '<tr><td colspan="1" id="detailCell">';
         echo  $row['name'];
        echo '</td><td>';
        echo $row['date'];
        echo "</td><td>";
        echo $row['start_time'];
        echo "</td><td>";
        echo $row['end_time'];
        echo "</td><td>";
        echo $row['winner'];
        echo "</td><td>";
        echo $row['started'];
        echo "</td><td>";
        echo $row['finished'];
        echo "</td><td>";
        echo '<a href="edit.php?id=' .$row['tournID'].'">Edit</a>';
		 echo "</td><td>";
		 echo '<a href="deleteTournament.php?id=' .$row['tournID'].'">Delete</a>';
        echo "</td></tr>";
    }     
    echo "</table>";

	
    echo '<br><a href = MANtournament.php?> Return To Tournament Management Page</a>';
  
    
      
             ?>
      </div>
<!--**************************************** -->

</div><!-- end of: Content -->
<?php
     
 ?>
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


 



