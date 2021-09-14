<?php 
 
function findPropertyValueOrMovieReply($telegram, $chatId,  $messageId, $date, $name, $userMovieprofile){

   $textSorry ="Sorry...😕\nI'm not be able to finding what you are looking 🤔\nPlease, try again 😉";

   $full_name = str_replace(' ', '_', $name); //tutti gli spazi con undescore
   
   $movieData = getAllPropertyListFromMovie($full_name);

   if ($movieData !== "null") { //se si tratta di un film
         //$replyFunctionCall = "movieToRatingSelected";
         // $text = "movie, ".$name;
         // $pagerankCicle = getNumberPagerankCicle($chatId);
         // $result = putChatMessage($chatId, $messageId, $replyFunctionCall, $text, $pagerankCicle, $date); 

         //propertyValueRatingReply($telegram, $chatId, $pagerankCicle);
         // movieListFromPropertyValueReply($telegram, $chatId, $propertyType, $propertyValue);
         $userMovieprofile->putMovieToRating($name);
         $userMovieprofile->setUserMovieToRating($name);
         $userMovieprofile->handle();
         //$page = 1;
         //movieDetailReply($telegram, $chatId, $name, $page);
   }
   else{  //se si tratta di una proprietà
      $propertyData = getPropertyTypeListFromPropertyValue($full_name);
      if ($propertyData !== "null") {
         $keyboard = propertyTypeListFromPropertyValueKeyboard($propertyData);
         $text = "Did you mean:";
         $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard,'resize_keyboard' => true,'one_time_keyboard' => false]);

         $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
         $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
      }
      else{
         $levDistanceData = levDistanceTop5Keyboards($full_name);
         if ($levDistanceData !== "null") {
            $keyboard = $levDistanceData;
            $text = "Did you mean:";
            $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard,'resize_keyboard' => true,'one_time_keyboard' => false]);

            $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
            $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
         } 
         else {
            $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
            $telegram->sendMessage(['chat_id' => $chatId, 'text' => $textSorry]);
         }
      }
   }
}