<?php 

use GuzzleHttp\Client;

function recommendationMovieListTop5Keyboards($chatId){

   $propertyType = 'movie';   
      
   $data = null;
   $data = getUserRecMovieList($chatId);
   //chiama il pagerank
   //$data = getPropertyValueListFromPropertyType($chatId, $propertyType);
  
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

   //file_put_contents("php://stderr", "recommendationMovieListTop5Keyboards return:".$keyboard.PHP_EOL);
   return $keyboard;
}

/*function recommendationMovieListTop5Keyboards($chatId){

   $propertyType = 'movie';
   
      
   //chiama il pagerank
   $data = null;
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
   $keyboard[] = array("🔙 Return to the list of Properties");

   //file_put_contents("php://stderr", "recommendationMovieListTop5Keyboards return:".$keyboard.PHP_EOL);
   return $keyboard;
}*/