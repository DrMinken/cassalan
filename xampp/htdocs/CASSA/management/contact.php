<!-- //******************************************************
// Name of File: contact.php
// Revision: 1.0
// Date: 16/04/2012
// Author: Tinashe Masvaure
// Modified: 

//***********************************************************

//********** Start PAGE ************** -->
 <?php
     include("../includes/conn.php");     // Include the db connection
      
       if(isset ($_GET['event'&&'name'&&'date'&&'start'&&'end']))
       {
           
           $eventID=  $_GET['event'];
           $name=  $_GET ['name'];
           $date=  $_GET ['date'];
           $start_time=  $_GET ['start'];
           $end_time=   $_GET  ['end'];
          
          if ($name == '')
        {
            $_SESSION['errMsg'][0] = '<font class="error">*</font>';
        }
        if ($date == '')
        {
            $_SESSION['errMsg'][1] = '<font class="error">*</font>';
        }
            else if (!is_numeric($date))
            {
                $_SESSION['errMsg'][1] = '<font class="error">*</font>';
            }
        if ($start_time == '')
        {
            $_SESSION['errMsg'][2] = '<font class="error">*</font>';
        }
            else if (!is_numeric($start_time))
            {
                $_SESSION['errMsg'][2] = '<font class="error">*</font>';
            }
        if ($end_time == '')
        {
            $_SESSION['errMsg'][3] = '<font class="error">*</font>';
        }
            else if (!is_numeric($end_time))
            {
                $_SESSION['errMsg'][3] = '<font class="error">*</font>';
            }
           
      
     $UpdateDB = "INSERT INTO tournament(eventID, name,date,start_time,end_time) 
     VALUES ('".$eventID."','".$name."', '".$date."','".$start_time."','".$end_time."')";
     $result = $db->query($UpdateDB);
    // header("location:CreateTournament.php");
    
    echo $name;
       
       }
       
       
       else if (isset($_GET['event' && 'name'&& 'date'&&'start'&&'end'&&'winner'&&'started'&&'finished']))
       {
          $eventID=  $_GET['event'];
           $name=  $_GET ['name'];
           $date=  $_GET ['date'];
           $start_time=  $_GET ['start'];
           $end_time=   $_GET  ['end'];
           $winner = $_GET['winner'];
           $started = $_GET['started'];
           $finished = $_GET['finished']; 
           
          $sql = "UPDATE tournament SET name = '$name', date ='$date', start_time = '$start_time', end_time ='$end_time', winner='$winner',
          started = '$started', finished = '$finished'";
       } 
     
         

 //$result = $db->query($sql);                                             
    
  ?>
 