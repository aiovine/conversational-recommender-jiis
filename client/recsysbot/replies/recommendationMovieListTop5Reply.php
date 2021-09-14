<?php 

function recommendationMovieListTop5Reply($telegram, $chatId){

   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);

   $keyboard = recommendationMovieListTop5Keyboards($chatId);
       
   if (sizeof($keyboard) == 1) {

      $text = "Unfortunately, i didn’t find movies for you.\nLet me know additional information about you."; 
      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);  
      $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]); 
      //torna al menu...
   } 
   else {
      $text = "I found this movies for you:";
      $i = 1;
      foreach ($keyboard as $key => $property) {
         //if ($property[0] != "Menu") {
         if (stristr($property[0], '🔙') == false) {
            $movie = $property[0];
            $text .= "\n".$i."^ *".ucwords($movie)."*";
            //$text .= "\n*".ucwords($movie)."*";
            //movieDetailTop5Reply($telegram, $chatId, $movie);
            $i++;
         }                
      }

      $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);

      $text .= "\nPlease, choose the movie you like more";
      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);  
      $telegram->sendMessage(['chat_id' => $chatId, 
                              'text' => $text,
                              'reply_markup' => $reply_markup,
                              'parse_mode' => 'Markdown']);
   } 
}