<?php

function messageDispatcherUserDetail($telegram, $chatId, $messageId, $date, $text, $firstname, $botName){

   file_put_contents("php://stderr","messageDispatcherUserDetail - chatId:".$chatId." - text:".$text.PHP_EOL);

   switch ($text) {
      case strpos($text, '/start'): case strpos($text, 'start'): case strpos($text, 'home'):
         $context = "userDetailSelected";
         $replyText = $text;
         $replyFunctionCall = "checkUserDetailReply"; 
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $responseType = "button";
         $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);

         checkUserDetailWelcomeReply($telegram, $chatId, $text);
      break;
      case strcasecmp($text, '<18') == 0: case strcasecmp($text, '19-25') == 0: case strcasecmp($text, '26-35') == 0: case strcasecmp($text, '36-50') == 0:  case strcasecmp($text, '>50') == 0:
         $context = "userDetailSelected";
         $replyText = "age,".$text;
         $replyFunctionCall = "checkUserDetailReply"; 
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $responseType = "button";
         $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);

         putUserAge($chatId, $text);
         checkUserDetailReply($telegram, $chatId, $text);
         break;
      case strcasecmp($text, 'male') == 0: case strcasecmp($text, 'female') == 0:
         $context = "userDetailSelected";
         $replyText = "gender,".$text;
         $replyFunctionCall = "checkUserDetailReply"; 
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $responseType = "button";
         $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);

         putUserGender($chatId, $text);
         checkUserDetailReply($telegram, $chatId, $text);
         break;
      case strcasecmp($text, 'high school') == 0: case strcasecmp($text, 'bachelor degree') == 0: case strcasecmp($text, 'master degree') == 0: case strcasecmp($text, 'phd') == 0:  case strcasecmp($text, 'Other') == 0:
         $context = "userDetailSelected";
         $replyText = "education,".$text;
         $replyFunctionCall = "checkUserDetailReply"; 
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $responseType = "button";
         $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);

         putUserEducation($chatId, $text);
         checkUserDetailReply($telegram, $chatId, $text);
         break;
      case strcasecmp($text, 'low') == 0: case strcasecmp($text, 'medium') == 0: case strcasecmp($text, 'high') == 0:
         $context = "userDetailSelected";
         $replyText = "InterestInMovies,".$text;
         $replyFunctionCall = "checkUserDetailReply"; 
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $responseType = "button";
         $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);

         putUserInterestInMovies($chatId, $text);
         checkUserDetailReply($telegram, $chatId, $text);
         break;
      case strcasecmp($text, 'yes') == 0: case strcasecmp($text, 'no') == 0:
         $context = "userDetailSelected";
         $replyText = "InterestInMovies,".$text;
         $replyFunctionCall = "checkUserDetailReply"; 
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $responseType = "button";
         $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);

         putUserUsedRecommenderSystems($chatId, $text);
         checkUserDetailReply($telegram, $chatId, $text);
         break;       
      default:
         $context = "userDetailSelected";
         $replyText = $text;
         $replyFunctionCall = "checkUserDetailReply"; 
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $responseType = "button";
         $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);
         
         checkUserDetailWelcomeReply($telegram, $chatId, $text);
         break;
   }
}
