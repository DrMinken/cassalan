<?php

// CONVERT DATE TO user interface DATE
function dateToScreen($date)
{
	$year = substr($date, 0, 4);
	$month = substr($date, 5, 2);
	$day = substr($date, 8, 2);
	$date = $day.'/'.$month.'/'.$year;

	return $date;
}

// CONVERT DATE TO mySQL DATE
function dateToDatabase($date)
{
	$day = substr($date, 0, 2);
	$month = substr($date, 3, 2);
	$year = substr($date, 6, 4);
	$date = $year.'/'.$month.'/'.$day;

	return $date;
}

// REMOVE 'seconds [:00]' FROM TIME
function removeSeconds($time)
{
	$time = substr($time, 0, 5);
	return $time;
}




// REG EXPRESSION [A-Za-z] STRINGS
function regLetters($input)
{
	if (!preg_match("#^[A-Za-z]+$#", $input)) 
	{ 
		// invalid [letter] input
		return false;
	}
	else
	{
		return true;
	}
}







?>