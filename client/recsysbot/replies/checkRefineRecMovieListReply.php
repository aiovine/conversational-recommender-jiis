<?php

function checkRefineRecMovieListReply($telegram, $chatId, $userMovieRecommendation){
	$numberRefineRecMovieList = getNumberRefineFromRecMovieList($chatId);

   file_put_contents("php://stderr", "heckRefineRecMovieListReply numberRefineRecMovieList:".$numberRefineRecMovieList." - chatId: ".$chatId.PHP_EOL);


	if ($numberRefineRecMovieList > 0) {
		$text = "Thanks for your feedback,\nI’m trying to improve the recommendations.\nPlease wait for a new set of movies.😉";
	
		// echo '<pre>'; print_r($text); echo '</pre>';
		$telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
	   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);

		//riesegue il pagerank e mostra all'utente una nuova lista da valutare
		$userMovieRecommendation->setPage(1);
	   $userMovieRecommendation->pagerank();
	}
	else{
		$text = "What is your overall evaluation on the experience with this bot (myself 😃)?";

		$keyboard = [
                     ['🌟 🌟 🌟 🌟 🌟'],
                     ['🌟 🌟 🌟 🌟','🌟 🌟 🌟'],
                     ['🌟 🌟','🌟']
                  ];

      $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);

      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
      $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
	}

}