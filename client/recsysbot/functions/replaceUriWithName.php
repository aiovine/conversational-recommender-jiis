<?php
 
function replaceUriWithName($uri){

	$name = $uri;

	if (strpos($uri, "http://dbpedia.org/resource/") !== false) {
		$fullname = str_replace("http://dbpedia.org/resource/", "", $uri);
		$name = str_replace('_', ' ', $fullname); // Replaces all underscore with spaces.
	} elseif (strpos($uri, 'http://dbpedia.org/ontology/') !== false) {
		$fullname = str_replace("http://dbpedia.org/ontology/", "", $uri);
		$name = str_replace('_', ' ', $fullname); // Replaces all underscore with spaces.
	}

	//echo " name:".$name;
   return $name;

}