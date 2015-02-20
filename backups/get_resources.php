<?php



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

