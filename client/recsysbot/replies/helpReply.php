<?php
use GuzzleHttp\Client;

function helpReply($telegram, $chatId, $help){

   switch ($help) {
     	case stristr($help, 'rateMovieSelected') !== false:
     		$text = "π Details: tap if you want to view the movie details";
			$text .= "\nπ: tap if you like the movie";
			$text .= "\nπ: tap if you donβt like the movie";
			$text .= "\nβ‘ Skip: tap for skipping to the next movie";
			$text .= "\nπ€ Profile: tap if you can view your preferences and change them";

			$keyboard = [
		                   ["π΅ Rate movies"]
		               ];

		   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
			$telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   		$telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
     		break;
     	case stristr($help, 'recMovieSelected') !== false:
     		$text = "π Like: tap if you like the movie";
			$text .= "\nπ Dislike: tap if you don't like the movie";
			$text .= "\nπ Like, but...: tap if you like the movie, but you donβt like some of its properties (eg., actors, director, etc.)";
			$text .= "\nπ Details: tap if you want to view the movie details";
			$text .= "\nπ£ Why?:	tap for viewing the motivations behind the recommendations";
			$text .= "\nπ€ Profile: by tapping this button you can view your preferences and change them";
			$text .= "\nπ’ Change: tap for receiving a new set of recommendations";

			$keyboard = [
			                ["π Back to Movies"]
			            ];

		   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
			$telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   		$telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
     		break;
     	case stristr($help, 'profileSelected') !== false:
     		$text = "Here you can view and change your preference by tapping on it.\nYou rated:";

     		$telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   		$telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);
     		break;
     	default:
     		break;
   }

}