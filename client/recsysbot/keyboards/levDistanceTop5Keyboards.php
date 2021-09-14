<?php 

use GuzzleHttp\Client;

function levDistanceTop5Keyboards($text){
	
	//credo dia un errore su uno inserisce un film con l'apostrofo
   $data = getLevDistanceFromAllVertexUriByName($text);
   echo "Data:<br>";
	echo '<pre>'; print_r($data); echo '</pre>';
  
   $result = array();
   $keyboard = array();
   if ($data != "null") {
      foreach ($data as $key => $value){
         $propertyStr = str_replace("http://dbpedia.org/resource/", "", $key);
         $propertyStr = str_replace('_', ' ', $propertyStr); // Replaces all underscore with spaces.
         $propertyArray[$key] = $propertyStr;
      }
   }

   foreach ($propertyArray as $key => $property) {
      $result[] = array("".$property);
   }
   
   $keyboard = $result;
   $propertyType = "Properties";
   $keyboard[] = array("🔙 Go to the list of \"".$propertyType."\"");

   file_put_contents("php://stderr", "levDistanceTop5Keyboards - text:".$text.PHP_EOL);
   return $keyboard;
}