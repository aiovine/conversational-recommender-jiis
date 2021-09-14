<?php
use GuzzleHttp\Client;

function userPropertyValueRatingReply($telegram, $chatId, $propertyType, $propertyName, $rating, $lastChange){  

   if ($propertyType !== "null" && $propertyName !== "null" ) {

      $oldNumberOfRatedProperties = getNumberRatedProperties($chatId);
      $data = putPropertyRating($chatId, $propertyType, $propertyName, $rating, $lastChange);
      
      $numberRatedMovies = getNumberRatedMovies($chatId);
      $numberRatedProperties = getNumberRatedProperties($chatId); 
      $needNumberOfRatedProperties = 3 - ($numberRatedProperties + $numberRatedMovies);

      file_put_contents("php://stderr", "needNumberOfRatedProperties:".$needNumberOfRatedProperties.PHP_EOL);      

      if ($needNumberOfRatedProperties > 0 ) {  

         if ($rating == 2) {
            $text = "You have rated Indifferent \"".ucwords($propertyName)."\"\nI need ".$needNumberOfRatedProperties." more ratings 😉";
         } 
         elseif ($numberRatedProperties > $oldNumberOfRatedProperties) {
            $text = "You have rated \"".ucwords($propertyName)."\"\nI need ".$needNumberOfRatedProperties." more ratings 😉"; 
         } 
         else{
            //Fare un controllo se si è aggiornato il rating della property
            $text = "I need ".$needNumberOfRatedProperties." more ratings 😉";
         }

      }
      else{

         if ($rating == 2) {
            $text = "You have rated Indifferent \"".ucwords($propertyName)."\"";
         } 
         elseif ($numberRatedProperties > $oldNumberOfRatedProperties) {
            $text = "You have rated \"".ucwords($propertyName)."\"\nProfile updated with ".$numberRatedProperties." rated properties";
         } 
         else{
            //Fare un controllo se si è aggiornato il rating della property
            $text = "You have rated ".$numberRatedProperties." properties";
         }

      }

      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);   
      $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]); 
   }

      $numberRatedMovies = getNumberRatedMovies($chatId);
      $numberRatedProperties = getNumberRatedProperties($chatId); 

      $needNumberOfRatedProperties = 3 - ($numberRatedProperties + $numberRatedMovies);

      $pagerankCicle = getNumberPagerankCicle($chatId);

   if ($needNumberOfRatedProperties <= 0) {

      $movie = recMovieToRefineSelected($chatId, $pagerankCicle);

      file_put_contents("php://stderr", "conf3userPropertyValueRatingReply - movie:".$movie." - pagerankCicle:".$pagerankCicle.PHP_EOL);   

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
   else{
      $text = "Do you want tell me something else about you?";
      $keyboard = startProfileAcquisitionKeyboard();
      
      $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
      $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
   }


}

