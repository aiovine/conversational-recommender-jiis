<?php

function profileInRecConxetReply($telegram, $chatId){

	$telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']); 

	$context = "recContext";
	$keyboard = movieOrPropertyToRatingKeyboard($chatId, $context);
	$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard,'resize_keyboard' => true,'one_time_keyboard' => false]);

	if (sizeof($keyboard) == 1) {
		$text = "Your profile is empty";
	} else {
		$text = "You have rated:";
	}	
	
	$telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);   
	$telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]); 

}