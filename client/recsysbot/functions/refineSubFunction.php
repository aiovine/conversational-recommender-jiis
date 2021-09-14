<?php

use GuzzleHttp\Client;

function refineSubFunction($chatId, $propertyTypeUri, $propertyUri){
	$userChange = "user";
	$lastChange = "refine";
	$rating = 1;
   $foundPropertyRating = getPropertyRating($chatId, $propertyTypeUri, $propertyUri, $userChange);
   if ($foundPropertyRating == "null") {
      putPropertyUriRating($chatId, $propertyTypeUri, $propertyUri, $rating, $lastChange);
      echo '<pre>'; print_r("chatId:".$chatId." - ".$propertyTypeUri." - ".$propertyUri); echo '</pre>';
      file_put_contents("php://stderr", "chatId:".$chatId." - ".$propertyTypeUri." - ".$propertyUri.PHP_EOL);
   }
   
}