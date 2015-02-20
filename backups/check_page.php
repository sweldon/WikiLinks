<?php

	//Instead of flush, echo to page and retrieve with JQUERY.
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

		//LINK FOUND
		if(in_array($endPage,$currentLinks))
		{
			
			echo "<tr><td><font color='red'>End</td><td><a href='http://en.wikipedia.org/wiki/".$endpage."'>".$endpage."</a></b></td></font></tr>";
			echo "<br /><div id='chosen'>Done: ".$page."(<- change to first page) -----> ".$endPage." in ".$numLinks." pages. </div><br />";
		}
		//NO LINK, CATEGORY?
		else if((!empty($intersection))&&(!empty($categoryClash)))
		{
			$iterations = 0;
			$origin = reset($categoryClash);
			parseCategory($categoryClash,$endpage, $numLinks, $usedCats, $iterations, $origin);
			
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

			$newEndWord = substr($nextLinkIndex,6);
			
			
			if($newEndWord!="")
			{
				echo "<tr><td>".$numLinks."</td><td><a href='http://en.wikipedia.org/wiki/".$newEndWord."'>".$newEndWord."</a></tr>"; //use $cleaned 
			}
			else
			{
				echo "<td>".$numLinks."</td><td>Worthless Wiki Page ".$nextLinkIndex."</tr>"; //use $cleaned 
			}
	

			check($newEndWord, $endpage, $numLinks, $categories);

		}

	}


		?>