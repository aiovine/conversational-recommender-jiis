<?php 
use GuzzleHttp\Client;

function propertyValueFromPropertyTypeAndMovieKeyboard($chatId, $propertyType, $movieName){   
   
   file_put_contents("php://stderr", "propertyValueFromPropertyTypeAndMovieKeyboard - propertyType:".$propertyType." - movieName".$movieName.PHP_EOL);

   $data = getPropertyValueAndScoreListByRecMovieFromUserAndPropertyType($chatId, $propertyType);

   $keyboard = array();
   $propertyArray = array();
   $scoreUpdate = 0.0000000000001;
   $returnType = "Properties";
   if ($data !== "null" && $movieName !== "null" ) {

      $returnType = "\"property\" of \"".$movieName."\"";

      foreach ($data as $movie => $propertiesValue){
         $movie_name = str_replace(' ', '_', $movieName); // Replaces all spaces with underscore.
         if (strpos(strtolower($movie),strtolower($movie_name))) {

            foreach ($propertiesValue as $propertyScore => $propertyValue) {
               $propertyName = str_replace("http://dbpedia.org/resource/", "", $propertyValue);
               $propertyName = str_replace('_', ' ', $propertyName); // Replaces all underscore with spaces.
               list($score, $property) = explode(',', $propertyName);
               if( isset( $propertyArray[$score])) {
                  //aggiorna lo score per avere chiavi diverse
                  $score = floatval($score) + $scoreUpdate;
                  $scoreUpdate = $scoreUpdate + 0.0000000000001;                     
                  
                  $propertyArray[sprintf($score)] = $property;
               }
               else{
                  $propertyArray[$score] = $property;
               }                  
               krsort($propertyArray);                  
            }

         }            
      }         
      
   }

   $keyboard = createKeaboardFromPropertyArrayAsScoreToPropertyValueForMovieFunction($propertyArray, $propertyType);
   $keyboard[] = array("🔙 Return to the list of \"property\" of \"".$movieName."\"");

   //Crezione delle tastiere per i filtrirelease year e runtime range
   if ( (strcasecmp($propertyType, "releaseYear") == 0) ) {
      $keyboard = releaseYearFilterKeyboard();
      $keyboard[] = array("🔙 Return to the list of \"property\" of \"".$movieName."\"");  
   }
   if ( (strcasecmp($propertyType, "runtimeRange") == 0) ) {
      $keyboard = runtimeRangeFilterKeyboard();
      $keyboard[] = array("🔙 Return to the list of \"property\" of \"".$movieName."\"");
   }

   return $keyboard;
}
