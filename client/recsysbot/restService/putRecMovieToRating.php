<?php
 
use GuzzleHttp\Client;

function putRecMovieToRating($chatId, $movieURI, $numberRecommendationList, $position, $pagerankCicle, $botName, $messageID, $botTimestamp){
	
/*	if (!$position >=0) {
		$position = 1;
	}*/

	$userID = $chatId;
	//$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest ='/'.getServiceName().'/restService/userRecMovieToRating/putRecMovieToRating?userID='.$userID.'&movieURI='.urlencode($movieURI).'&numberRecommendationList='.$numberRecommendationList.'&position='.$position.'&pagerankCicle='.$pagerankCicle.'&botName='.$botName.'&messageID='.$messageID.'&botTimestamp='.$botTimestamp;

   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg);

   file_put_contents("php://stderr", getServiceBaseURL().$stringGetRequest."/return:".$data.PHP_EOL);

   return $data;
   
}