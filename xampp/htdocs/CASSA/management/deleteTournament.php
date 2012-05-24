 <?php
     //include("../includes/conn.php");                                     // Include the db connection
     
       $connect = mysql_connect("localhost","reader","pass123");
                        //select database
                         mysql_select_db("cassa_lan");
    $id = $_GET["id"];
    $DeleteDB = "DELETE FROM tournament  WHERE tournID = $id";
	 $results = mysql_query($DeleteDB) or die (mysql_error());
     header("location:CreateTournament.php"); 
  ?>
 