<?php
 
use GuzzleHttp\Client;

function getPropertyValueListFromPropertyType($chatId, $propertyType){

	$userID = $chatId;
	//$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest = '/'.getServiceName().'/restService/propertyValueList/getPropertyValueListFromPropertyType?userID='.$userID.'&propertyType='.urlencode($propertyType);
   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg);

   file_put_contents("php://stderr", getServiceBaseURL().$stringGetRequest.PHP_EOL);

   return $data;
   
}
