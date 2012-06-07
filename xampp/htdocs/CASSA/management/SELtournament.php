<!-- //******************************************************

// Name of File: selectTournament.php
// Revision: 1.0
// Date: 05/06/2012
// Author: Tinashe Masvaure
// Modified: Quintin Maseyk 07/06/2012

//***********************************************************
//This script works in conjuction with the MANtournament.php script and contact.php.
//it acts as partner script and provides the details of the tournament
//selected in the list box. It returns the data in an AJAX connection.
//
//It uses $_POST in this instance rather than $_GET as there is
//a need for security. It returns a non-editable HTML table.
//********** Start of select tournament script **************-->
<!--*******************************************************-->


<?php 
    include("../includes/conn.php");            // Include the db connection

	// SECURE AND UNIFORM POST VARIABLE
	$_POST = array_map("trim", $_POST);
	$_POST = array_map("mysql_real_escape_string", $_POST);

	// SETUP LOCAL VARIABLES
	if (isset($_POST['tournID'])){ $tournID = $_POST['tournID']; }
    $queryType = $_POST['queryType'];           // Retrieve the query Identifier.


	// Create the general select query.		
	// DRAW BASIC TOURNAMENT TABLE
    if($queryType == '0')
	{
		$query = "SELECT * FROM tournament WHERE tournID='".$tournID."';";        
		ajax_tournament_table_basic($db, $tournID);
	}

	// Create the general select query.
	// DRAW CREATE TOURNAMENT TABLE
    else if($queryType == '1')
	{
		$query = "SELECT * FROM tournament WHERE tournID='".$tournID."';";        
		ajax_tournament_table_create($db, $tournID);
	}

	// Create the general select query.  
	// DRAW EDIT TOURNAMENT TABLE
    else if($queryType == '2')
	{
		$query = "SELECT * FROM tournament WHERE tournID='".$tournID."';";        
		ajax_tournament_table_edit($db, $tournID);
	}

	// DELETE TOURNAMENT
	else if($queryType == "delete")
	{
		$tournID = $_POST['tournID'];
		$query = "DELETE FROM tournament WHERE tournID='".$tournID."';";
		$result = $db->query($query);
	}

	// INSERT TOURNAMENT
	else if($queryType == "insert")
	{
		// SETUP SUBJECTIVE VARIABLES
		$eventID = $_POST['eventID'];
		$name = $_POST['name'];
		$date = $_POST['date'];
		$startTime = $_POST['startTime'];
		$endTime = $_POST['endTime'];
		$_SESSION['errMsg'] = '';

		// VALIDATE INPUTES
		if ($eventID == '')
		{
			$_SESSION['errMsg'] .= 'No event was selected';
		}
		else if ($name == '')
		{
			$_SESSION['errMsg'] .= 'No event name was entered';
		}
		else if (!is_numeric($startTime) || !is_numeric($endTime))
		{
			$_SESSION['errMsg'] .= 'Start/End times must be digits that are in 24 hour times';
		}
		else if ($startTime == $endTime)
		{
			$_SESSION['errMsg'] .= 'Start time and End time are the same';
		}
	}

// DRAW BASIC TOURNAMENT TABLE
function ajax_tournament_table_basic($db, $tournID)
{
	$query = "SELECT * FROM tournament WHERE tournID=".$tournID;      //Create the general select query.
	$result = $db->query($query);
	$row1 = $result->fetch_array(MYSQLI_BOTH);                        //use it first for the title
	$result->close();                                                 //then close it ready for the next execution
	$result = $db->query($query);     
	
	
	// DECLARE MOUSE EVENTS
	$on = 'this.src="../images/buttons/edit_dwn.png"';
	$off = 'this.src="../images/buttons/edit_up.png"';

?>
	<br /><br />


	<table class="pizzaOrder" id="tableTournamentDetail">


	<tr><td colspan="2" id="headCell_left" >Tournament Details for: 
		<font class='subtitle'><?php echo $row1['name']; ?></font></td>
	
	<td id="headCell_right">
		<img class="pointer" 
			 src="../images/buttons/edit_dwn.png" 
			 width="30" height="30"
			 alt="" 
			 onclick="editTournament(' <?php echo $row1['tournID']; ?> ')" 
			 onmouseover='<?php echo $off; ?>' onmouseout='<?php echo $on; ?>' /></td>
	</tr>
			
<?php 
	//While Loop starts here - 
	// Retrieve the data for the table. There should only be one row.
	while($row = $result->fetch_array(MYSQLI_BOTH))                            
	{
		echo '<tr>';
			echo '<td>Tournament Date: </td>';
			echo '<td>' . $row['date'] . '</td>';
		echo '</tr>';    
		
		echo '<tr>';
			echo '<td>Tournament Start Time: </td>';
			echo '<td>' . $row['start_time'] . '</td>';
		echo '</tr>';    
		
		echo '<tr>';
			echo '<td>Tournament End Time: </td>';
			echo '<td>' . $row['end_time'] . '</td>';
		echo '</tr>';       

		echo '<tr>';
			echo '<td>Tournament Winner: </td>';
			echo '<td>' . $row['winner'] . '</td>';
		echo '</tr>';
													   
	
		// If the tournament has started place the stop event button in the table.
		if($row['started'] == 1)
		{
			$on = 'this.src="../images/buttons/stop_dwn.png"';
			$off = 'this.src="../images/buttons/stop.png"';

			echo '<tr>';
				echo '<td>Tournament Started: </td>';
				echo '<td>Yes</td>';
					echo '<td><img src="../images/buttons/stop_dwn.png" class="pointer"';
						echo 'width="30px" height="30px"'; 
						echo 'alt="" onclick="stopTournament(' . $row['tournID'] . ')" ';
						echo 'onmouseover='.$off.' onmouseout='.$on.' /></td>';
			echo '</tr>';
		}

		// If the tournament has not started place the start event button in the table. 
		elseif ($row['started'] == 0)
		{
			$on = 'this.src="../images/buttons/start_dwn.png"';
			$off = 'this.src="../images/buttons/start.png"';

			echo '<tr>';
				echo '<td>Tournament Started: </td>';
				echo '<td>No</td>';
				echo '<td><img src="../images/buttons/start_dwn.png" class="pointer"';
						echo 'width="30px" height="30px"';
						echo 'alt="" onclick="startTournament(' . $row['tournID'] . ')"';
						echo 'onmouseover='.$off.' onmouseout='.$on.' /></td>';
			echo '</tr>';
		}

		// If the tournament has completed or been stopped. 
		elseif ($row['started'] == 2)
		{
			$on = 'this.src="../images/buttons/start_dwn.png"';
			$off = 'this.src="../images/buttons/start.png"';

			echo '<tr>';
				echo '<td>Tournament Started: </td>';
				echo '<td>Finished</td>';
			echo '</tr>';
		}

	}//While Loop ends here

	echo '</table>';
}





function ajax_tournament_table_create($db, $tournID)
{
?>
    <br>
    <br>
    <p><h2>Create Tournament</h2></p> 
     <br>
     <table border="1" width="400">
    <tr> 
    <td>Select Event:</td>
    <td>
    <select name="events">
    <?php
        $get = "SELECT * FROM event WHERE event_completed=0";
        $result = $db->query($get);
        
        for ($i=0; $i<$result->num_rows; $i++)
        {
            $row = $result->fetch_assoc();
            
            echo '<option value="'.$row['eventID'].'">'.$row['event_name'].'</option>';
        }
    ?>
    </select></td>
    </tr>
    <tr>
    <td>Enter Tournament Name:</td>
    <td><input type='text' name='name' mexlength='64'> </td>
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
<p><input type='submit'  value='Create Tournament' onclick='getInfo();'>
     <?php
     
   
    //$username = $_SESSION['username'];
    $query = "SELECT * FROM tournament";
   $result = $db->query($query);
    $row = $result->fetch_array(MYSQLI_BOTH);    

   echo "<br><h1> Created Tournaments</h1>";
    echo "<table border='1' CELLPADDING = 5 width= '400px' STYLE='font-size:13px'>";
    echo "<tr><td><H4> Name</h3></td>";
    echo "<td width = '100px'><H3> Date</h3></td>";
     echo "<td><H4> start time </h3></td>";
    echo "<td><H4> end time</h3></td>";
    echo "<td><H4> winner</h3></td>";
    echo "<td><H4> started</h3></td>";
    echo "<td><H4> finished</h3></td>";
    
    
          
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
        echo "</td></tr>";
    }
        echo "</table>"; 
        function deleteTournament()
        {
              $id = $_GET["id"];
              $DeleteDB = "DELETE FROM tournament  WHERE tournID = $id";
              $result = $db->query($DeleteDB);
        }
        ?>
        <button type="button" onclick="deleteTournament()">Delete Tournament</button>
<?php 
}




function ajax_tournament_table_edit($db, $tournID)
{
//$id = $_GET['name'];   
 //$tournID = $_POST['tournID'];                                                // Retrieve the search value.   
    $sql = "SELECT * FROM tournament";
  // $result = mysql_query($sql);
    $result = $db->query($sql);                                             
    $num = $result->fetch_array(MYSQLI_BOTH);
    //$num = $mysql_fetch_array($result);      
     
   ?>
     <br>
    <br>
         
<h1>Edit Tournament</h1>
<input type ='hidden' name='id' value="<?php echo $num['tournID']; ?>" />
Tournament Name:<input type ="text" name = "name" value ="<?php echo $num['name']?>" /><br>
Tournament Date: <input type ="date" name = "date" value ="<?php echo $num['date']?>" /><br>
Tournament Start Time: <input type ="time" name = "start_time" value ="<?php echo $num['start_time']?>" /><br>
Tournament End Time: <input type ="time" name = "end_time" value ="<?php echo $num['end_time']?>" /><br>
Tournament Winner: <input type ="text" name = "winner" value ="<?php echo $num['winner']?>" /><br>
Tournament Started: <input type ="text" name = "started" value ="<?php echo $num['started']?>" /><br>
Tournament Finished: <input type ="text" name = "finished" value ="<?php echo $num['finished']?>" /><br>
<input type='submit'  value='submit' onclick='editInfo();' />   
<?php                 
}
//Return back to the MANevent.php page.
?>