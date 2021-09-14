<?php

function runtimeRangeFilterReply($telegram, $chatId, $propertyType, $propertyValue, $addFilter){

   if ($propertyType !== "null") {
      if (strcasecmp($addFilter, "yes") == 0) {
         $data = putRuntimeRangeFilter($chatId, $propertyType, $propertyValue);
         $text = "You have added the filter \"".$propertyValue."\"";
      } 
      elseif (strcasecmp($addFilter, "no") == 0) {
         $data = putRuntimeRangeFilter($chatId, $propertyType, $propertyValue);
         $text = "No filter added for runtime range";
      }
      else{
         $text = "Problem with: No filter added for runtime range";
         file_put_contents("php://stderr", "WARNING - runtimeRangeFilterReply - propertyValue: ".$propertyValue.PHP_EOL);   
      }
   }
   else{
      $text = "Problem with: No filter added for runtime range";
   } 

   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);   
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);

   $numberRatedMovies = getNumberRatedMovies($chatId);
   $numberRatedProperties = getNumberRatedProperties($chatId);
   $needNumberOfRatedProperties = 3 - ($numberRatedProperties + $numberRatedMovies);

   $pagerankCicle = getNumberPagerankCicle($chatId);

   if ($needNumberOfRatedProperties <= 0) {      
      $movie = recMovieToRefineSelected($chatId, $pagerankCicle);

      file_put_contents("php://stderr", "runtimeRangeFilterReply - movie:".$movie." - pagerankCicle:".$pagerankCicle.PHP_EOL);  
      
      if (strcasecmp($movie, "null") !== 0 && $pagerankCicle >= 0) {
         $text = "Do you prefer rate other properties of "."\"".ucwords($movie)."\" \nor Back to movies?";
         $keyboard = [
                        ["🔎 Rate other properties of "."\"".ucwords($movie)."\""],
                        ["🔙 Back to Movies"]
                    ];
         $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);

         $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
         $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
      } 
      else {
         //$text = "Do you want tell me something else about you?";
         $text = "Let me recommend a movie 😃";
         $text .= "\nTap on \"🌐 Recommend Movies\" button, otherwise you can enrich your profile by providing further ratings 😉";
         //$text = "\nLet me recommend a movie 😃\n(tap \"🌐 Recommend Movies\")\n\nOr type your preference\n(e.g., Pulp Fiction or Tom Cruise or Thriller) 🙂";
         $keyboard = userPropertyValueKeyboard();
         
         $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
         $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
         $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
      }

   }
   //new user
   else{
      $text = "Do you want tell me something else about you?";
      //$text = "Do you want tell me something else about you?\n\nPlease, type your preference\n(e.g., Pulp Fiction or Tom Cruise or Thriller) 🙂";
      $keyboard = startProfileAcquisitionKeyboard();
      
      $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
      $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);

 
   }

}

