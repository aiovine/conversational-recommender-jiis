<?php 

function resetProfileReply($telegram, $chatId, $pagerankCicle){

	$reply =  resetCommandSelected($chatId, $pagerankCicle);
	$preference = $reply[1];	

   $text = "...Warning! All your \"".ucwords($preference)."\" will be deleted.\nPlease, confirm the choice.";
   $keyboard = [
      ["✔ Yes","🚫 No"],
      ["⚙️ Profile"]
   ];

   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);   

   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
}