<?php
 
function userGenderReply($telegram, $chatId){

   $text = "Male or Female?";
   $keyboard = [
                     ["Male"],
                     ["Female"]
               ];

   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);   

   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);

}