<?php

function recommendationBackNextMovieReply($telegram, $chatId, $userMovieRecommendation){

	$text = "Please wait. I'm working for you 😉";
	
	echo '<pre>'; print_r($text); echo '</pre>';
	$telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);

	$userMovieRecommendation->setPage(1);
   $userMovieRecommendation->pagerank();
}