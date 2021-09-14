<?php
use GuzzleHttp\Client;

function conf1helpReply($telegram, $chatId, $help){

   switch ($help) {
     	case stristr($help, 'rateMovieSelected') !== false:
     		$text = "📋 Details: tap if you want to view the movie details";
			$text .= "\n👍: tap if you like the movie";
			$text .= "\n👎: tap if you don’t like the movie";
			$text .= "\n➡ Skip: tap for skipping to the next movie";
			$text .= "\n👤 Profile: tap if you can view your preferences and change them";

			$keyboard = [
		                   ["🔵 Rate movies"]
		               ];

		   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
			$telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   		$telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
     		break;
     	case stristr($help, 'recMovieSelected') !== false:
     		$text = "😃 Like: tap if you like the movie";
			$text .= "\n🙁 Dislike: tap if you don't like the movie";
			$text .= "\n🌀 Like, but...: tap if you like the movie, but you don’t like some of its properties (eg., actors, director, etc.)";
			$text .= "\n📑 Details: tap if you want to view the movie details";
			$text .= "\n📣 Why?:	tap for viewing the motivations behind the recommendations";
			$text .= "\n👤 Profile: by tapping this button you can view your preferences and change them";
			$text .= "\n💢 Change: tap for receiving a new set of recommendations";

			$keyboard = [
			                ["🔙 Back to Movies"]
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