
<html>
<head>
	<title>WIKI LINKS</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="scripts/basic.js"></script>
	<script src="scripts/emptyInput.js"></script>
	<link rel="stylesheet" type="text/css" href="style/index_style.css">
</head>


<body>

</div>

<?php 

include "/database/connect.php";
include "/database/query.php";

if(isset($_GET['not_found']))

{
	
$brokenWord = $_GET['not_found'];

echo "<center><div id='input-error'>Oops! No specific page exists for '".$brokenWord."'</div></center>";

}
 

?>


<center>

	<div id="pageform">
		<form  id="pagesubmit" action="parse/check_page.php" method="post" onsubmit="fadeout()">
			<input type="text" id="startpageid" name="startpage" required></input> &#10142;
			<input type="text" id="endpageid" name="endpage" required></input><br /><br />

			<select>
				<option>General (Wikipedia)</option>
				<option>Game of Thrones (Soon)</option>
				<option>More... (Soon)</option>
			</select>

			<br /><br />

			<input type="submit" value="Find Path" id="Send"></input>
		</form>
		<script>

	
	</script>
	</center>
<br />	

<?php
	
	getRecords();

?>