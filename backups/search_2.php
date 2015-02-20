<html>
<head>
	<title>WIKI LINKS</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<style>

	#links
	{

		border: 2px dashed grey;
		width: 300px;
		padding:5px;
	}
	#chosen
	{
		border: 2px dashed grey;
		z-index:10;
		width: 300px;
		padding:5px;
	}
	#tablebox
	{
		width:500px;
		border-style: solid;
		border: #e8e8e8;
		height:500px;
		overflow:auto;
	}
	#results
	{
		width:500px;
		height:auto;
		
		border-width:3px;
		overflow:auto;
	}
	#console
	{
		background:#e8e8e8;
		position:absolute;
		width:300px;
		height:auto;
		margin-left:498;
		padding:3px;
		overflow:auto;
	}
	img
	{
		width:40px;
		height:40px;
	}
	tr:nth-child(even) 
	{
		background-color: #ededed;
	}		
	</style>

</head>

<div id="console">Similarities Found...</div>

<body>

	<script>
	$( document ).ready(function() {
		$( "#progress" ).hide();
		$( "#console" ).hide();

	});
	function fadeout(){
		$( "#pageform" ).fadeOut();
		$( "#progress" ).fadeIn();
		$( "#console" ).fadeIn();
	}
	</script>
</div>



<!--<center><div id='progress'>Clicking links...</div></center>-->

<?php

if(isset($_GET['startpage']) && isset($_GET['endpage']))
{
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