	<?php

	function isBroken($url)
	{

	$urlStart	= "http://en.wikipedia.org/wiki/".$url;
	$ch = curl_init($urlStart);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);

	$html = curl_exec($ch);
	curl_close($ch);
	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$xpath = new DOMXPath($dom);
	$checkSyntax = $xpath->query('//b[text()="Wikipedia does not have an article with this exact name."]');
	$checkDisambiguation = $xpath->query('//p[text()=" may refer to:"]');

	if(($checkSyntax->length!=0) || ($checkDisambiguation->length!=0))
	{
		return true;

	}
	else
	{
		return false;
	}

	}


	?>