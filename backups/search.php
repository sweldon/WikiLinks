<html>
<head>
	<title>WIKI LINKS</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="scripts/basic.js"></script>
	<link rel="stylesheet" type="text/css" href="style/index_style.css">

</head>

<div id="console">Similarities Found...</div>

<body>

</div>



<!--<center><div id='progress'>Clicking links...</div></center>-->

<?php

include "parse/check_page.php";
include "parse/get_resources.php";
include "parse/check_category.php";


if(isset($_GET['startpage']) && isset($_GET['endpage']))
{
	// "Titles on Wikipedia are case sensitive except for the first character. Preceding char's arent cap. unless proper noun" 
	echo "<div id='tablebox'>";
	echo "<center><table id='results'>";
	echo "<tr><td>Link #</td><td>URL</td></tr>";
	$startEntry 			= $_GET['startpage'];;
	$endEntry 				= $_GET['endpage'];
	$startpage = str_replace(" ","_",$startEntry);
	$endpage = str_replace(" ","_",$endEntry);
	$numLinks = 0;
	$cats = array();


	echo "<tr><td><font color='red'>Start</td><td><a href='http://en.wikipedia.org/wiki/".$startpage."'>".ucfirst($startpage)."</a></td></font></tr>";
//CALL A FUNCTION
	check($startpage, $endpage, 0, $cats);


	echo "Start Page: <b>".ucfirst($startpage)."</b><br />";
	echo "End Page: <b>".ucfirst($endpage)."</b><br /><br />";
}
else
	{?>
<center>

	<div id="pageform">
		<form  id="pagesubmit" action="" method="get" onsubmit="fadeout()">
			Start Page: <br />
			<input type="text" id="startpageid" name="startpage"></input><br />
			End Page: <br />
			<input type="text" id="endpageid" name="endpage"></input><br />
			<input type="submit" value="Submit"></input>
		</form></center>
		<?php
	}



		?>

		</table></div>

<?php if(isset($_GET['startpage']) && isset($_GET['endpage']))
{
	echo "<center><a href='http://localhost/wikilinks/search.php'>Again!</a></center>";
}

		?>