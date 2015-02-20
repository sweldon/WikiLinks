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
			width:900px;
			border-style: solid;
			border: #e8e8e8;
			height:500px;
			overflow:auto;
		}
		#results
		{
			width:900px;
			height:auto;
		
		border-width:3px;
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
	<body>

	<script>
	$( document ).ready(function() {$( "#progress" ).hide();});
	function fadeout(){
	$( "#pageform" ).fadeOut();
	$( "#progress" ).fadeIn();
	}
	</script>
	</div>

	

<center><div id='progress'>Clicking links...</div></center>
	
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


echo "<tr><td><font color='red'>Start</td><td><a href='http://en.wikipedia.org/wiki/".$startpage."'>".ucfirst($startpage)."</a></td></font></tr>";
trail($startpage,$startpage,$endpage,0);

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
function trail($start,$newEnd,$end,$numLinks) //endcats
{
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');

// Turn off output buffering
ini_set('output_buffering', 'off');


while (@ob_end_flush());
ini_set('implicit_flush', true);
ob_implicit_flush(true);



//Var initiation
$linksFollowed = $numLinks;
$startWord		= ucfirst($start);
$endWord		= ucfirst($end);
$url			= 'http://en.wikipedia.org/wiki/'.$newEnd;
$endURL			= 'http://en.wikipedia.org/wiki/'.$end;
$startLink		= '/wiki/'.ucfirst($start);
$endLink		= '/wiki/'.ucfirst($end);

//delete old collect

$collect = array();

if($linksFollowed<100000)
{

//$endCatList 	= endCats

//PROXY STUFF
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);


$html = curl_exec($ch);
curl_close($ch);
$dom = new DOMDocument();
@$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
$href = $xpath->evaluate("/html/body//a");


//get /wiki/ links only (regular pages)
for ($i = 0; $i < $href->length; $i++) 
{
	$data = $href->item($i);
	$url = $data->getAttribute('href');
	if((substr($url, 0, 6)=='/wiki/')&&(strpos($url,':') === false)&&(substr($url, 6)!="Main_Page"))
	{
		#print_r($url); echo"<br />";
	array_push($collect, $url);	

	//echo $url."<br />";
	}

}

unset($html);
unset($xpath);
unset($href);


	// $image = $xpath->evaluate("/html/body//img"); //[contains(@src,'".$newEnd."')]
	// $data1 = $image->item(0);
	// $pic = $data1->getAttribute('src');

	// echo "<td><img src=".$pic." /></td>";
	//echo $url."<br />";





//echo "</div><br />";
$lastLinkIndex = (count($collect))-1;
$fullLink = $endLink;

if(!(in_array($fullLink,$collect)))
{
	$linksFollowed++;
	$randomIndex = rand(0,$lastLinkIndex);
	if(empty($collect)==false){
	$nextLinkIndex = $collect[$randomIndex];
	}
	else
	{
		$nextLinkIndex = "nothing!";
	}
	//echo "<div id='chosen'>".$nextLinkIndex."</div><br />";
	$newEndWord = substr($nextLinkIndex,6);
	/////////////////////////////
	//$cleaned = str_replace(array('%', ' '), array('_', ' '),array('%', ' '), $newEndWord);

flush();
	echo "<tr>";
	if($newEndWord!="")
	{
		echo "<td>".$linksFollowed."</td><td><a href='http://en.wikipedia.org/wiki/".$newEndWord."'>".$newEndWord."</a></tr>"; //use $cleaned 
	}
	else
	{
		echo "<td>".$linksFollowed."</td><td>Worthless Wiki Page ".$nextLinkIndex."</tr>"; //use $cleaned 
	}
flush();

	//echo memory_get_usage();
	#array_push($finalPages, $newEndWord);	
	/////////////////////////////
if (($newEndWord != $endWord))
{
	 	
		trail($startWord, $newEndWord, $endWord, $linksFollowed);

}

}
else
{
	echo "<tr><td><font color='red'>End</td><td><a href='http://en.wikipedia.org/wiki/".$endWord."'>".$endWord."</a></b></td></font></tr>";
	echo "<br /><div id='chosen'>Done: ".$startWord." -----> ".$endWord." in ".$linksFollowed." pages. </div><br />";
	$linksFollowed++;
}
}
else
{
echo "***This route is too difficult at the moment***<br />";
}
}

//echo "</tr>";
?>
</table></div>
<?php if(isset($_GET['startpage']) && isset($_GET['endpage']))
{
echo "<center><a href='http://localhost/wikilinks/index.php'>Again!</a></center>";
}


?>

</center>
	</body>
</html>