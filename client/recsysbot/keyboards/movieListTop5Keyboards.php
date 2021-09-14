<?php 

use GuzzleHttp\Client;

function movieListTop5Keyboards($chatId){

   $propertyType = 'movie';
   //chiama il pagerank
   $data = getPropertyValueListFromPropertyType($chatId, $propertyType);
  
   $result = array();
   $keyboard = array();
   if ($data !== "null") {
      foreach ($data as $key => $value){
         foreach ($value as $k => $v) {
            $propertyStr = str_replace("http://dbpedia.org/resource/", "", $v);
            $propertyStr = str_replace('_', ' ', $propertyStr); // Replaces all underscore with spaces.
            list($score, $nodo) = explode(',', $propertyStr);
            $propertyArray[$score] = $nodo;
            krsort($propertyArray);
         }
      }

      if ($propertyType == 'movie') {
         foreach ($propertyArray as $key => $property) {
            $result[] = array("".$property);
         }
      }
   } 

   $keyboard = array_slice($result, 0, 5);
   $propertyType = "Properties";
   $keyboard[] = array("🔙 Return to the list of \"".$propertyType."\"");

   //file_put_contents("php://stderr", "movieListTop5Keyboards return:".$keyboard.PHP_EOL);
   return $keyboard;
}