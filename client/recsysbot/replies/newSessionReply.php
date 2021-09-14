<?php
use GuzzleHttp\Client;

function newSessionReply($telegram, $chatId, $firstname, $date){

   //prende l'attuale configurazione
   //ricerca la nuova configurazione
   //se la trova azzera i film e le properties
   $botName = getBotNameOrSetNewSession($chatId);

   //salva la nuova configurazione, controllo sulla presenza fatto sul server
   putUserBotConfiguration($chatId, $botName, $date);

   //associa la nuova configurazione all'utente
   putUserBotName($chatId, $botName);
	
   $text = "Hello ".$firstname." 😃";
   $text .= "\nIn this experiment you will receive some recommendations about MOVIES.
In the following, we will ask you some information about you and your preferences in the movie domain.
Next, you will receive a list of recommended movies and you will be asked to evaluate the goodness of the recommendations.
You can improve the recommendations by telling me what you like and what you dislike in the recommended movies.
You can also ask why a movie has been recommended by tapping the “Why?” button.
The whole experiment will take less than five minutes.";

   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);

   //inserire il put configuration
   startProfileAcquisitioReply($telegram, $chatId);
   
/*   if (strcasecmp($botName, 'conf1testrecsysbot') == 0){
         conf1startProfileAcquisitioReply($telegram, $chatId);
      }
      elseif (strcasecmp($botName, 'conf2testrecsysbot') == 0){
         conf1startProfileAcquisitioReply($telegram, $chatId);    //sono uguali, cambiare in conf12
      }
      elseif (strcasecmp($botName, 'conf3testrecsysbot') == 0){
         conf3startProfileAcquisitioReply($telegram, $chatId);
         conf3basePropertyTypeReply($telegram, $chatId);          //carica subito la tastiera base delle proprietà
      }
      elseif (strcasecmp($botName, 'conf4testrecsysbot') == 0){
         conf4startProfileAcquisitioReply($telegram, $chatId);
      }
      else{ //movierecsysbot
         startProfileAcquisitioReply($telegram, $chatId);
      }  */  
                           
}