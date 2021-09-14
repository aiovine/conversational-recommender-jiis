<?php

use GuzzleHttp\Client;

function putReleaseYearFilter($chatId, $propertyType, $propertyValue){

	$userID = $chatId;
	//$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest = '/'.getServiceName().'/restService/releaseYearFilter/putReleaseYearFilter?userID='.$userID.'&propertyType='.$propertyType.'&propertyValue='.$propertyValue;
   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg);

   file_put_contents("php://stderr", getServiceBaseURL().$stringGetRequest."/return:".$data.PHP_EOL);

   return $data;
   
}