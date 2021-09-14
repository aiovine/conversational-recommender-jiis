<?php
use GuzzleHttp\Client;

function checkUserAndBotNameFunction($chatId, $firstname, $lastname, $username, $date){

	$userDetail = getUserDetail($chatId);

	$id = $botName = null;

   if ($userDetail != "null") {
      foreach ($userDetail as $key => $value){

      	switch ($key) {
				case "id":
	            $id = $value;
	            break;
				case "botName":
	            $botName = $value;
	            break;
	         default:
	            break;
	      }

      }
   }
   if ($botName == null) {
   	$botName = "movierecsysbot";
   	putUserBotName($chatId, $botName);

   	//movierec
   	$botName = getOrSetUserBotName($chatId);
		putUserDetail($chatId, $firstname, $lastname, $username);

		//Conserva la configurazione assegnata all'utente
		putUserBotConfiguration($chatId, $botName, $date);
	}

	return $botName;

}