<?php
include "../database/connect.php";

function parseCategory($int, $endpage, $numLinks, $existingCats, $iterations, $originalCat, $startpage)
{
	$startpage = $startpage;
	$endLink = "/wiki/".ucfirst($endpage);
	$endPage = ucfirst($endpage);
	$catIterations = $iterations;
		//Array of common categories
		//CURRENTLY: Of the brand new categories not visited, only selects first. Better way to choose? Maybe not b/c it will be techinically visited eventually... Queue it up maybe?
	$catPage = reset($int);
	$origin = $originalCat;
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
	$href = $xpath->query('//div[@id="mw-pages"]//a');
	$moreCats = $xpath->query('//a[text()="next 200"]/@href');


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

	if(in_array($endLink,$categoryLinks))
	{

		$numLinks++;
		if($catIterations==0)
		{
			echo "<br />End. <a href='http://en.wikipedia.org/wiki/".$endPage."'>".$endPage."</a> <font color='green'>[from <a href='http://en.wikipedia.org".$origin."'>".substr($origin,15)."</a>]</font> <br />";
			enterRecord($startpage, $endpage, $numLinks);
		}
		else
		{ 
			echo "<br />End. <a href='http://en.wikipedia.org/wiki/".$endPage."'>".$endPage."</a> <font color='green'>[from  <a href='http://en.wikipedia.org".$origin."'>".substr($origin,15)."</a> (page ".$catIterations.")]</font><br />";
			enterRecord($startpage, $endpage, $numLinks);
		}
		echo "<br /><div id='chosen'>Done. Reached '".$endPage."' in ".$numLinks." pages. </div><br />";
	}


			//PUT IN A LOOP THROUGH 'NEXT 200' CATEGORY LISTINGS UNTIL IT'S FOUND. OTHERWISE PICK A RANDOM LINK THEN.
	else if($moreCats->length!=0)
	{

		$numLinks++;
		//$name = $xpath->query('//a[text()="next 200"]/@href'); THIS GETS YOU THE NEXT 200 PAGE
		//If you want to start from a certain subpage from the category:
		// if(($catIterations==0)&&($origin=="/wiki/Category:Living_people"))
		// {
			
		// 	$extension = $origin."?from=".substr($endPage, 0, 2);
		// }
		// else
		// {
		// 	$extension = $moreCats->item(0)->value;
		// }
		$extension = $moreCats->item(0)->value;
		$catIterations++;
		

			// /w/index.php?title=Category:1964_births&pagefrom=Amicarella%2C+Ana%0AAna+Amicarella#mw-pages
		
		$nextPage = array();
		array_push($nextPage, $extension);




					echo "-> <a href='http://en.wikipedia.org".$extension."'>Category Traversal</a> <font color='green'>[from  ".substr($origin,15)." (".$catIterations.")]</font><br />"; //use $cleaned 
					//echo "."; 


					parseCategory($nextPage, $endpage, $numLinks, $followedCats, $catIterations, $origin, $startpage);

				}

				else 
				{
					$lastCatIndex = (count($categoryLinks))-1;
					$numLinks++;
					$randomIndex = rand(0,$lastCatIndex);
					$nextCatIndex = $categoryLinks[$randomIndex];

					$linkFromCat = substr($nextCatIndex,6);


					flush();


					echo $numLinks.". <a href='http://en.wikipedia.org/wiki/".$linkFromCat."'>".$linkFromCat."</a> <font color='green'>[from  ".substr($catPage,15)."]</font><br />"; //use $cleaned 


					flush();


				//If it wasn't visited already, add the category to those used
					if(!in_array($catPage, $followedCats))
					{
						array_push($followedCats, $catPage);
					}
				//Iterate on the new page chosen from category page.
					check($linkFromCat, $endpage, $numLinks, $followedCats, $startpage);


				}





			}
			?>