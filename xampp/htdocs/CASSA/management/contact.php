
 <?php
     //include("../includes/conn.php");                                     // Include the db connection
     
       $connect = mysql_connect("localhost","reader","pass123");
                        //select database
                         mysql_select_db("cassa_lan");
     
	  
	 $UpdateDB = "INSERT INTO tournament(name,date,start_time,end_time) 
	 VALUES ('".$_POST['name']."', '".$_POST['date']."','".$_POST['start_time']."','".$_POST['end_time']."')";
     $results = mysql_query($UpdateDB) or die (mysql_error());
     header("location:CreateTournament.php"); 
  ?>
 