
<?php
use GuzzleHttp\Client;

function putDislikeRecMovieRating($chatId, $movieURI, $numberRecommendationList, $dislike){
	$userID = $chatId;
	//$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest ='/'.getServiceName().'/restService/userDislikeRecMovieRating/putDislikeRecMovieRating?userID='.$userID.'&movieURI='.urlencode($movieURI).'&numberRecommendationList='.$numberRecommendationList.'&dislike='.$dislike;

   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg);

   file_put_contents("php://stderr", getServiceBaseURL().$stringGetRequest."/return:".$data.PHP_EOL);

   return $data;
   
}