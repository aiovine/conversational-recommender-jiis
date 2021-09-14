<?php 

use GuzzleHttp\Client;

function pagerankUserRecMovieListTop5Keyboards($chatId){

   $propertyType = 'movie';   
      
   $data = null;

   //chiama il pagerank
   $data = getPropertyValueListFromPropertyType($chatId, $propertyType);
  
   $result = array();
   $keyboard = array();
   if ($data !== "null") {
         foreach ($data as $score => $value) {
            $propertyStr = str_replace("http://dbpedia.org/resource/", "", $value);
            $propertyStr = str_replace('_', ' ', $propertyStr); // Replaces all underscore with spaces.
            $propertyArray[$score] = $propertyStr;
            krsort($propertyArray);
         }
      $i = 1;
      if ($propertyType == 'movie') {
         foreach ($propertyArray as $key => $property) {
            //$result[] = array("".$i."^ "."🎥"." ".ucwords($property));
            $result[] = array("🎥"." ".$property);
            $i++;
         }
      }
   } 

   $keyboard = array_slice($result, 0, 5);
   $keyboard[] = array("🔙 Home","⚙️ Profile");

   file_put_contents("php://stderr", "pagerankUserRecMovieListTop5Keyboards return:".$keyboard.PHP_EOL);
   return $keyboard;
}
