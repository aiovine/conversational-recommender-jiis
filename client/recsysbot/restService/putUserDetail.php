<?php
 
use GuzzleHttp\Client;

function putUserDetail($chatId, $firstname, $lastname, $username){

	$userID = $chatId;
	//$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest ='/'.getServiceName().'/restService/detail/putUserDetail?userID='.$userID.'&firstname='.$firstname.'&lastname='.$lastname.'&username='.$username;
   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg);

   file_put_contents("php://stderr", getServiceBaseURL().$stringGetRequest."/return:".$data.PHP_EOL);

   return $data;
   
}
