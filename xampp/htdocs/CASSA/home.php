<?php
	session_start();									// Start/resume THIS session
	$_SESSION['title'] = "MegaLAN Management System"; 	// Declare this page's Title
	include("includes/template.php"); 					// Include the template page
	include("includes/conn.php"); 						// Include the database connection
?>


<!-- //******************************************************

// Name of File: home.php
// Revision: 1.0
// Date: 07/04/2012
// Author: Quintin M
// Modified: Quintin M 09/04/2012

//***********************************************************

//*************** Start of HOME PAGE ******************* -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type='text/javascript'>
function editArticle(x)
{
	document.getElementById('editNewsID').value=x;
	document.forms['editArticle'].submit();
}
function deleteArticle(x)
{
	var answer = confirm("Are you sure you want to delete this article?");
	if (answer == true)
	{
		// Delete [x]

	}
}
</script>

</head>
<body>
<center>
<div id='shell'>



<!-- Main Content [left] -->
<div id="content">


<!-- FETCH RECENT NEWS FROM DATABASE -->
<?php

echo '<div id="article">';
	// FETCH ALL NEWS
	$query = "SELECT * FROM news ORDER BY `newsID` DESC";
	$result = $db->query($query);

	for ($i=0; $i<$result->num_rows; $i++)
	{
		$row = $result->fetch_assoc();
		$newsID = $row['newsID'];
		$subject = $row['subject'];
		$date = $row['date'];
		$author = $row['author'];
		$message = $row['message'];
		$imageDir = $row['image'];
		$tag = $row['tag'];


	// DISPLAY [THIS] ARTICLE
		// TITLE
		echo '<div class="articleTitle">'.$subject.'<br /></div>';

		// DATE - AUTHOR
		echo '<div class="articleSubTitle">Posted on <u>'.$date.'</u> by <u>'.$author.'</u>';

			// IF USER = STAFF, ADD TOOLBOX [EDIT/DELETE]
			if (isset($_SESSION['isAdmin']))
			{
				if ($_SESSION['isAdmin'] == 1)
				{
					// TOOLBOX
					echo '<div class="articleToolBox">';
						// EDIT [this]
						echo '<img class="pointer" src="images/buttons/edit_60.png" title="Edit" onclick="editArticle('.$newsID.')" />';

						// DELETE [this]
						echo '<img class="pointer" src="images/buttons/delete_60.png" title="Delete" onclick="deleteArticle('.$newsID.')"/>';
					echo '</div>';
					echo '<br /><br />';
				}
			}
		echo '</div><br/>';

		// MESSAGE
		echo '<div class="articleMessage">'.$message.'<br /><br /></div>';

		// IMAGE
		if (!empty($imageDir))
		{
			echo '<div class="articleImage"><img src="NewsArticle/uploads/'.$imageDir.'" title="'.$subject.'" /></div>';
		}

		// TAGS
		echo '<div class="articleTag">Tagged <u>'.$tag.'</u><br /><br /></div>';


		// IF THERE IS ANOTHER ARTICLE -add a blue line spacer
		if ($i+1 < $result->num_rows)
		{
			// ADD BLUE LINE
			echo '<br /><br />';
			echo '<div class="blueLine700"></div>';
			echo '<br /><br />';
		}
		// ELSE -add blank space
		else
		{
			// ADD BLANK SPACES
			echo '<br /><br />';
		}
	}
echo '</div>';
?>
<!-- end of: RECENT NEWS -->



<!-- FORM - for posting [this] article to be edited -->
<form name='editArticle' method='POST' action='editNotices.php'>
<input type='text' name='editNewsID' id='editNewsID' value='' />
</form>









<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->
<!-- ********************************* -->

</div><!-- end of: Content -->


<!-- INSERT: rightPanel -->
<?php include('includes/rightPanel.html'); ?>


<!-- INSERT: footer -->
<div id="footer">
	<?php include('includes/footer.html'); ?>
</div>


</div><!-- end of: Shell -->

</center>
</body>
</html>

<!-- ********************************* -->
<!-- INCLUDE THIS AFTER 'MAIN CONTENT' -->
