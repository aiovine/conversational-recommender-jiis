<?php 
//in disuso
function movieListFromPropertyValueReply($telegram, $chatId, $propertyType, $propertyValue ){

   $name = substr($propertyValue,5);
   //$text = "Let me see if i can recommend a movie about ".$name; //.$name." minutes of runtime";
   //$telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   //$telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);            
   
   $propertyName = str_replace(' ', '_', $name); // Replaces all spaces with underscore.
   if ($propertyType == 'category') {$propertyName = "Category:".$propertyName;}
   $keyboard = movieListFromPropertyValueKeyboard($chatId, $propertyName, $propertyType);

   //if ($keyboard != null) {$reply_markup = $telegram-->inlineKeyboardMarkup(['inline_keyboard' => $keyboard]);          
   if (sizeof($keyboard) == 1) {
      $text = "Unfortunately, i didn’t find movies for you.\nLet me know additional information about you."; //$text = "Amongst the ".$NameRuntime." minutes, i can recommend these films: ";
      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);  
      $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]); 
      //torna al menu...
   } else {
      $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
      
      $text = "I found these movies for you";
      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);  
      $telegram->sendMessage(['chat_id' => $chatId, 
                              'text' => $text,
                              'reply_markup' => $reply_markup]);
      
   } 
}