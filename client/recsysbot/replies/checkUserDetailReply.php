<?php 

use GuzzleHttp\Client;
use Telegram\Bot\Api;

function checkUserDetailReply($telegram, $chatId, $text){
	
	file_put_contents("php://stderr","checkUserDetailReply- chatId:".$chatId.PHP_EOL);

	$userDetail = getUserDetail($chatId);

	$id = $firstname = $lastname = $username = $botName = $userAge = $userGender = $userEducation = $userInterestInMovies = $userUsedRecommenderSystem = null;

   if ($userDetail != "null") {
      foreach ($userDetail as $key => $value){

      	switch ($key) {
				case "id":
	            $id = $value;
	            break;
				case "firstname":
	            $firstname = $value;
	            break;
				case "lastname": 
	            $lastname = $value;
	            break;
				case "username": 
	            $username = $value;
	            break;
	         case "botName": 
	            $botName = $value;
	            break;
				case "age": 
	             $userAge = $value;
	            break;
				case "gender": 
	            $userGender = $value;
	            break;
				case "education": 
	            $userEducation = $value;
	            break;
				case "interestInMovies": 
	            $userInterestInMovies = $value;
	            break;
	         case "usedRecommenderSystem": 
	            $userUsedRecommenderSystem = $value;
	            break;
	         default:
	            break;
	      }
      }
   }
	
	if ($userAge == null) {
    	userAgeReply($telegram, $chatId);
   }
   elseif ($userGender == null) {
   	userGenderReply($telegram, $chatId);
   }
   elseif ($userEducation == null) {
   	userEducationReply($telegram, $chatId);
   }
   elseif ($userInterestInMovies == null){
   	userInterestInMoviesReply($telegram, $chatId);
   }
   elseif ($userUsedRecommenderSystem == null) {
   	userUsedRecommenderSystemReply($telegram, $chatId);
   }
   elseif (strcasecmp($botName, 'conf1testrecsysbot') == 0){
   	conf1startProfileAcquisitioReply($telegram, $chatId);
   }
   elseif (strcasecmp($botName, 'conf2testrecsysbot') == 0){
  		conf1startProfileAcquisitioReply($telegram, $chatId); //sono uguali, cambiare in conf12
   }
   elseif (strcasecmp($botName, 'conf3testrecsysbot') == 0){
   	conf3startProfileAcquisitioReply($telegram, $chatId);
   	conf3basePropertyTypeReply($telegram, $chatId);
   }
   elseif (strcasecmp($botName, 'conf4testrecsysbot') == 0){
   	conf4startProfileAcquisitioReply($telegram, $chatId);
   }
   else{ //movierecsysbot
   	startProfileAcquisitioReply($telegram, $chatId);
   }
}
