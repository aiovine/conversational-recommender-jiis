<?php
use GuzzleHttp\Client;

function putNumberRecommendationList($chatId, $numberRecommendationList){

   $userID = $chatId;
   //$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest = '/'.getServiceName().'/restService/numbers/putNumberRecommendationList?userID='.$userID.'&numberRecommendationList='.$numberRecommendationList;
   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg);
   
   file_put_contents("php://stderr", getServiceBaseURL().$stringGetRequest."/return:".$data.PHP_EOL);

   return $data;

}