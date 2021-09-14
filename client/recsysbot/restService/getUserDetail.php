// <?php
 
use GuzzleHttp\Client;

function getUserDetail($chatId){

	$userID = $chatId;
		//$client = new Client(['base_uri'=>'http://localhost:8080']);
   $client = new Client(['base_uri'=>getServiceBaseURL()]);
   $stringGetRequest = '/'.getServiceName().'/restService/users/getUserDetail?userID='.$userID;
   $response = $client->request('GET', $stringGetRequest);
   $bodyMsg = $response->getBody()->getContents();
   $data = json_decode($bodyMsg, true);

   file_put_contents("php://stderr", getServiceBaseURL().$stringGetRequest."/return:".$bodyMsg.PHP_EOL);

   return $data;
   
}
