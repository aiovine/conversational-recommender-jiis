<?php
 
function addmovieOrPropertyRating($propertyValue, $propertyType, $rating){

   $movieOrPropertyRating = $propertyValue;
   switch ($propertyType) {
      case "movie":
         if ($rating == 1) {
            $movieOrPropertyRating = ucwords($propertyValue)." - "."👍 liked movie";
         } 
         elseif ($rating == 0){
            $movieOrPropertyRating = ucwords($propertyValue)." - "."👎 disliked movie";
         }
         break;
      case strcasecmp($propertyType, "http://purl.org/dc/terms/subject") == 0: 
         if ($rating == 1) {
            $movieOrPropertyRating = ucwords($propertyValue)." - "."🙂 liked category";
         } 
         elseif ($rating == 0){
            $movieOrPropertyRating = ucwords($propertyValue)." - "."😑 disliked category";
         }
         break;
      case ($propertyType !== 'movie'):
         if ($rating == 1) {
            $movieOrPropertyRating = ucwords($propertyValue)." - "."🙂 liked ".$propertyType;
         } 
         elseif ($rating == 0){
            $movieOrPropertyRating = ucwords($propertyValue)." - "."😑 disliked ".$propertyType;
         }
         break;
      default:
         break;
   }
   return $movieOrPropertyRating;
}