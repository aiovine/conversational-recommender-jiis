
<?php
use GuzzleHttp\Client;

function putLikeRecMovieRating($chatId, $movieURI, $numberRecommendationList, $like){
	$userID = $chatId;
	//$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest ='/'.getServiceName().'/restService/userLikeRecMovieRating/putLikeRecMovieRating?userID='.$userID.'&movieURI='.urlencode($movieURI).'&numberRecommendationList='.$numberRecommendationList.'&like='.$like;

   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg);

   file_put_contents("php://stderr", getServiceBaseURL().$stringGetRequest."/return:".$data.PHP_EOL);

   return $data;
   
}