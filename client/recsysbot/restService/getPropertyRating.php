<?php
 
use GuzzleHttp\Client;

function getPropertyRating($chatId, $propertyTypeUri, $propertyUri, $lastChange){

	$userID = $chatId;
	//$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest = '/'.getServiceName().'/restService/propertiesRating/getPropertyRating?userID='.$userID.'&propertyTypeUri='.urlencode($propertyTypeUri).'&propertyUri='.urlencode($propertyUri).'&lastChange='.$lastChange;
   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg, true);

   file_put_contents("php://stderr", getServiceBaseURL().$stringGetRequest."/return:".$bodyMsg.PHP_EOL);

   return $data;   
   
}