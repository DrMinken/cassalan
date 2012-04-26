<?php

// Inialise session
session_start();

// Delete user session
unset($_SESSION['username']);


// Now Back to login page
header('Location: index.php');

?>