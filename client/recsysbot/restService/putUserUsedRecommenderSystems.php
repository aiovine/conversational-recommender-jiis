<?php

use GuzzleHttp\Client;

function putUserUsedRecommenderSystems($chatId, $usedRecSys){

	$userID = $chatId;
	//$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest = '/'.getServiceName().'/restService/usedRecommenderSystems/putUserUsedRecommenderSystems?userID='.$userID.'&usedRecSys='.$usedRecSys;
   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg);

   file_put_contents("php://stderr", getServiceBaseURL().$stringGetRequest."/return:".$data.PHP_EOL);

   return $data;
   
}