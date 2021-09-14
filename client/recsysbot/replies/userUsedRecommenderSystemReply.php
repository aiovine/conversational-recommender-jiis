<?php
 
function userUsedRecommenderSystemReply($telegram, $chatId){

   $text = "Have you ever used recommender systems (like Amazon)?";
   $keyboard = [
                     ["Yes"],
                     ["No"]
               ];

   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);   

   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);

}