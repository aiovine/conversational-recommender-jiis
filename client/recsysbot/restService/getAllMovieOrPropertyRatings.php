<?php
 
use GuzzleHttp\Client;

function getAllMovieOrPropertyRatings($chatId){

   $userID = $chatId;
   //$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest = '/'.getServiceName().'/restService/posNegRatings/getAllMovieOrPropertyRatings?userID='.$userID;
   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg);
   
   file_put_contents("php://stdout", getServiceBaseURL().$stringGetRequest.PHP_EOL);

   return $data;

}
