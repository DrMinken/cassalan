 <?php
     include("../includes/conn.php");                                     // Include the db connection
     
      // $connect = mysql_connect("localhost","reader","pass123");
                        //select database
        //                 mysql_select_db("cassa_lan");
     $UpdateDB = mysql_query("INSERT INTO tournament(tournament_name,tournament_date,tournament_start_time,tournament_end_time) VALUES
     ('".$_POST['name']."', '".$_POST['date']."','".$_POST['start_time']."','".$_POST['end_time']."',)");
     $results = mysql_query($UpdateDB) or die (mysql_error());
     header("location:CreateTournament.php"); 
  ?>
 