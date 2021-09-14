<?php
 
function propertyRuntimeRangeFilterReply($telegram, $chatId, $pagerankCicle){

   $reply =  runtimeRangeFilterSelected($chatId, $pagerankCicle);
   $propertyType = $reply[0];
   $propertyName = $reply[1];

   $text = "Do you want add filter \"".$propertyName."\"?";
   $keyboard = [
                     ["⌛ Add filter \"".$propertyName."\"", "🔶 No Filter"],
                     ["🔙 Return to the list of ".$propertyType]
               ];

   //echo '<pre>'; print_r($keyboard); echo '</pre>';

   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);   

   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);

}