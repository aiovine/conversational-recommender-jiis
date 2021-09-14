<?php

function refineLastMoviePropertyReply($telegram, $chatId, $userMovieRecommendation){

   $pagerankCicle = getNumberPagerankCicle($chatId);
   $movie = oldRecMovieToRefineSelected($chatId, $pagerankCicle);
   
   $text = "Refine additional properties of ";
   $text .= "\n\"".ucwords($movie)."\"";


   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);  
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);
   

	$keyboard = refineMoviePropertyKeyboard($chatId, $movie, $userMovieRecommendation);
   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);

   $text = "Which properties of movie you want to change?";
   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);  
   $telegram->sendMessage(['chat_id' => $chatId, 
                           'text' => $text,
                           'reply_markup' => $reply_markup]);
}