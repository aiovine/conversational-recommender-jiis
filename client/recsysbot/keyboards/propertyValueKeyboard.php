<?php 
use GuzzleHttp\Client;

function propertyValueKeyboard($chatId, $propertyType, $text){   

   $reply = explode("\"", $text);
   $movieName = isset($reply[1])? $reply[1] : null;

   $keyboard = array();

   if ($movieName == null) {  
      $keyboard = propertyValueFromPropertyTypeKeyboard($chatId, $propertyType);
   }      
   else{
      $keyboard = propertyValueFromPropertyTypeAndMovieKeyboard($chatId, $propertyType, $text);
   }

   //Crezione delle tastiere per i filtrirelease year e runtime range
   if ( (strcasecmp($propertyType, "releaseYear") == 0) ) {
      $keyboard = releaseYearFilterKeyboard();

      if ($movieName == null) {  
         $keyboard[] = array("ðŸ”™ Return to the list of Properties");
      }      
      else{
         $keyboard[] = array("ðŸ”™ Return to the list of \"property\" of \"".$movieName."\"");
      }

   }

   if ( (strcasecmp($propertyType, "runtimeRange") == 0) ) {
      $keyboard = runtimeRangeFilterKeyboard();

      if ($movieName == null) {  
         $keyboard[] = array("ðŸ”™ Return to the list of Properties");
      }      
      else{
         $keyboard[] = array("ðŸ”™ Return to the list of \"property\" of \"".$movieName."\"");
      }

   }


   echo '<pre>'; echo("propertyValueKeyboard - propertyType:".$propertyType." - text:".$text." - movieName:".$movieName); echo '</pre>';
   echo '<pre>'; print_r($keyboard);echo '</pre>';
   return $keyboard;
}