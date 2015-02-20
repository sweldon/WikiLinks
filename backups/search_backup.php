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




	function check($page, $endpage, $numLinks, $categories)
	{
		//print_r($categories);
		//echo "<br /><br /><br />";
		//Have used categories
		$usedCats = $categories;
		while (@ob_end_flush());
		ini_set('implicit_flush', true);
		ob_implicit_flush(true);
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '-1');

		// Turn off output buffering
		ini_set('output_buffering', 'off');

		//destination link
		$endPage = '/wiki/'.ucfirst($endpage);
		//destination categories array
		$endCats = getCats($endpage);
		//current links, are they destination?
		$currentLinks = getLinks($page);
		//current categories
		$currentCats = getCats($page);
		//Common categories?

		$intersection = array_intersect($endCats, $currentCats);
		
		$categoryClash = array();

		foreach($intersection as $item)
		{
			if(!in_array($item, $usedCats))
			{
				array_push($categoryClash, $item);
			}
		}

		//print_r($categoryClash);
		//echo "<br /><br /><br />";

		//LINK FOUND
		if(in_array($endPage,$currentLinks))
		{
			
			echo "<tr><td><font color='red'>End</td><td><a href='http://en.wikipedia.org/wiki/".$endpage."'>".$endpage."</a></b></td></font></tr>";
			echo "<br /><div id='chosen'>Done: ".$page."(<- change to first page) -----> ".$endPage." in ".$numLinks." pages. </div><br />";
		}
		//NO LINK, CATEGORY?
		else if((!empty($intersection))&&(!empty($categoryClash)))
		{
			
				parseCategory($categoryClash,$endpage, $numLinks, $usedCats);
			
		}
		//NEITHER, PICK RANDOM LINK, LOOP WITH THAT LINK, BASICALLY OLD TRAIL FUNCTION
		else 
		{
			$lastLinkIndex = (count($currentLinks))-1;
			$numLinks++;
			$randomIndex = rand(0,$lastLinkIndex);
			if(empty($currentLinks)==false)
			{
				$nextLinkIndex = $currentLinks[$randomIndex];
			}
			else
			{
				$nextLinkIndex = "nothing!";
			}
	//echo "<div id='chosen'>".$nextLinkIndex."</div><br />";
			$newEndWord = substr($nextLinkIndex,6);


			flush();
			echo "<tr>";
			if($newEndWord!="")
			{
				echo "<td>".$numLinks."</td><td><a href='http://en.wikipedia.org/wiki/".$newEndWord."'>".$newEndWord."</a></tr>"; //use $cleaned 
			}
			else
			{
				echo "<td>".$numLinks."</td><td>Worthless Wiki Page ".$nextLinkIndex."</tr>"; //use $cleaned 
			}
			flush();

			check($newEndWord, $endpage, $numLinks, $categories);


		}





	}


	function parseCategory($int, $endpage, $numLinks, $existingCats)
	{


		//Array of common categories
		//CURRENTLY: Of the brand new categories not visited, only selects first. Better way to choose? Maybe not b/c it will be techinically visited eventually... Queue it up maybe?
		$catPage = reset($int);
		//$catPage = $int;
		$categoryLinks = array();
		$followedCats = $existingCats;

		$url = 'http://en.wikipedia.org'.$catPage;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);

		$html = curl_exec($ch);
		curl_close($ch);
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);
		$href = $xpath->query('//div[@class="mw-content-ltr"]//a');
	
		//GET MAIN CATEGORY PAGE
			for ($i = 0; $i < $href->length; $i++) 
			{
				$data = $href->item($i);
				$url = $data->getAttribute('href');
				if((substr($url, 0, 6)=='/wiki/')&&(strpos($url,':') === false))
				{
					array_push($categoryLinks, $url);

				}
			}
	
			if(in_array($endpage,$categoryLinks))
			{
				
				echo "<tr><td><font color='red'>End</td><td><a href='http://en.wikipedia.org/wiki/".$endpage."'>".$endpage."</a></b></td></font></tr>";
				echo "<br /><div id='chosen'>Done. Reached '".$endPage."' in ".$numLinks." pages. </div><br />";
			}
			//PUT IN A LOOP THROUGH 'NEXT 200' CATEGORY LISTINGS UNTIL IT'S FOUND. OTHERWISE PICK A RANDOM LINK THEN.
			else 
			{
				$lastCatIndex = (count($categoryLinks))-1;
				$numLinks++;
				$randomIndex = rand(0,$lastCatIndex);
				$nextCatIndex = $categoryLinks[$randomIndex];
				
				$linkFromCat = substr($nextCatIndex,6);


				flush();
		

					echo "<tr><td>".$numLinks."</td><td><a href='http://en.wikipedia.org/wiki/".$linkFromCat."'>".$linkFromCat."</a> <font color='green'>[from  ".substr($catPage,15)."]</font></tr>"; //use $cleaned 

		
				flush();
				
			
				//If it wasn't visited already, add the category to those used
				if(!in_array($catPage, $followedCats))
				{
				array_push($followedCats, $catPage);
				}
				//Iterate on the new page chosen from category page.
				check($linkFromCat, $endpage, $numLinks, $followedCats);


			}



		

    

	}

	function getLinks($page)
	{

		$links 		= array();


		$url		= 'http://en.wikipedia.org/wiki/'.$page;


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
		//print_r($url); echo"<br />";
				array_push($links, $url);	
			}

		}

		return $links;

	}

	function getCats($page)
	{


		$cats 		= array();

		$url		= 'http://en.wikipedia.org/wiki/'.$page;


		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);

		$html = curl_exec($ch);
		curl_close($ch);
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);
		$href = $xpath->evaluate("//div[@class='mw-normal-catlinks']//a");

	//get /wiki/ links only (regular pages)
		for ($i = 0; $i < $href->length; $i++) 
		{
			$data = $href->item($i);
			$url = $data->getAttribute('href');
		//GET CATEGORIES
			if((substr($url, 0, 15)=='/wiki/Category:'))
			{
		//print_r($url); echo" (CATEGORY) <br />";
				array_push($cats, $url);	
		//you now have an array of links and categories of the page
			}
		}
		return $cats;
	}



	?>

</table></div>

	<?php if(isset($_GET['startpage']) && isset($_GET['endpage']))
	{
	echo "<center><a href='http://localhost/wikilinks/search.php'>Again!</a></center>";
	}


	?>