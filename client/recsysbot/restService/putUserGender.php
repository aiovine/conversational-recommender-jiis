<?php

use GuzzleHttp\Client;

function putUserGender($chatId, $gender){

	$userID = $chatId;
	//$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest = '/'.getServiceName().'/restService/gender/putUserGender?userID='.$userID.'&gender='.$gender;
   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg);

   file_put_contents("php://stderr", getServiceBaseURL().$stringGetRequest."/return:".$data.PHP_EOL);

   return $data;
   
}