<?php 
use GuzzleHttp\Client;

function backFunction($telegram, $chatId, $messageId, $text, $botName, $date, $userMovieRecommendation){

   file_put_contents("php://stderr", "backFunction:".$text.PHP_EOL); 
   switch ($text) {
      //ritorna alla film raccomandato
      case stristr($text, 'movies') !== false:
         $context = "backRecMovieSelected";
         $replyText = $text;
         $replyFunctionCall = "userMovieRecommendationInstance"; 
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $responseType = "button";
         $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);      

         //$movie = recMovieToRefineSelected($chatId, $pagerankCicle);
         $movie = recMovieSelected($chatId, $pagerankCicle);
         $page = $userMovieRecommendation->getPageFromMovieName($chatId, $movie);
         $userMovieRecommendation->setPage($page);
         $userMovieRecommendation->handle();
         
         //recommendationMovieListTop5Reply($telegram, $chatId);
         break;
      //ritorna alla home
      case stristr($text, 'home') !== false:    case stristr($text, 'start') !== false:
         $context = "backHomeSelected";
         $replyText = $text;
         $replyFunctionCall = "startProfileAcquisitioReply"; 
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $responseType = "button";
         $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);

         startProfileAcquisitioReply($telegram, $chatId); 
         break;
      //ritorna al full menu delle properties   
      case stristr($text, 'properties') !== false:
         $context = "recMovieToRefineSelected";
         $replyText = $text;
         $replyFunctionCall = "refineMoviePropertyReply"; 
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $responseType = "button";
         $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);

         //allPropertyTypeReply($telegram, $chatId);
         //ritorna alle property del film
         //..forse si può eliminare
         startProfileAcquisitioReply($telegram, $chatId); 
         //conf1refineMoviePropertyReply($telegram, $chatId, $userMovieRecommendation);
         break;
      //ritorna alle proprietà del film raccomandato da riaffinare
      case stristr($text, 'property')  !== false:
         $reply = explode("\"", $text);
         $textRefine = "to \"".$reply[3]."\"";

         $context = "backRecMovieToRefineSelected";
         $replyText = $text;
         $replyFunctionCall = "refineLastMoviePropertyReply"; 
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $responseType = "button";
         $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);

         refineLastMoviePropertyReply($telegram, $chatId, $userMovieRecommendation);
         break;
      //ritorna alla lista dei valori della proprietà considerata
      default:
         $reply = explode(" ", $text);
         $propertyType =$reply[6];
         $textRefine = null;
         $context = "backpropertyTypeSelected";
         $replyText = $propertyType;
         $replyFunctionCall = "propertyValueReply"; 
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $responseType = "button";
         $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);

         propertyValueReply($telegram, $chatId, $propertyType, $textRefine);
         break;
      }

}