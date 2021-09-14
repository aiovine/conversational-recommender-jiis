<?php 

use GuzzleHttp\Client;

function propertyTypeListFromPropertyValueKeyboard($propertyData){  

   file_put_contents("php://stderr", "propertyTypeListFromPropertyValueKeyboard - propertyData".PHP_EOL);
  
   $keyboard = array();
   $propertyArray = array();
   if ($propertyData !== "null") {
      foreach ($propertyData as $propertyValueUri => $propertyTypeArray) {
         $propertyValue = replaceUriWithName($propertyValueUri);
         foreach ($propertyTypeArray as $key => $propertyTypeUri){             
            $propertyType = replaceUriWithName($propertyTypeUri);         
            $propertyArray[$propertyType] = $propertyValue;
         }
      }   
   }  

   $keyboard = createKeaboardFromPropertyArrayAsPropertyTypeToPropertyValueFunction($propertyArray);
   $keyboard[] = array("🔙 Go to the list of Properties");

   return $keyboard;
}
