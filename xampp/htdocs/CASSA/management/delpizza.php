<?php

	// PAGE SECURITY
	if (!isset($_SESSION['username']))
	{
		echo '<script type="text/javascript">history.back()</script>';
		die();
	}

if (isset($_POST['pizza_name'])) // Delete pizza from menu
{
	include("includes/conn.php"); 
	$pizza_name = $_POST['pizza_name'];
	$query3 = "DELETE FROM pizza_type WHERE pizza_name='".$_POST['pizza_name']."'";
	$result3 = $db->query($query3);
	$db->close();
	echo "Thanks";
	 header( 'Location: MANpizza.php' ) ;
}
?>