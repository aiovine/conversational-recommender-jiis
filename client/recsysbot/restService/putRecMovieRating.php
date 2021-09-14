<?php
 
use GuzzleHttp\Client;

function putRecMovieRating($chatId, $movieURI, $numberRecommendationList, $rating, $position, $pagerankCicle, $refine, $refocus, $botName, $messageID, $botTimestamp, $recommendatinsList, $ratingsList){

	$userID = $chatId;
	//$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest ='/'.getServiceName().'/restService/ratingsRecMovie/putRecMovieRating?userID='.$userID.'&movieURI='.urlencode($movieURI).'&numberRecommendationList='.$numberRecommendationList.'&rating='.$rating.'&position='.$position.'&pagerankCicle='.$pagerankCicle.'&refine='.$refine.'&refocus='.$refocus.'&botName='.$botName.'&messageID='.$messageID.'&botTimestamp='.$botTimestamp.'&recommendatinsList='.$recommendatinsList.'&ratingsList='.$ratingsList;

   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg);

   file_put_contents("php://stderr", getServiceBaseURL().$stringGetRequest."/return:".$data.PHP_EOL);

   return $data;
   
}