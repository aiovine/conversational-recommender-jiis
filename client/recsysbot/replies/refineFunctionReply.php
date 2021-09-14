<?php
use GuzzleHttp\Client;

function refineFunctionReply($telegram, $chatId, $userMovieRecommendation){

   $pagerankCicle = getNumberPagerankCicle($chatId);
   $movie = recMovieToRefineSelected($chatId, $pagerankCicle);
   
   //Chiama prima la funzione di refine e poi fai modicare  una proprietà
   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);  
   $text = refineFunction($chatId);
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);   
   

	$keyboard = refineMoviePropertyKeyboard($chatId, $movie, $userMovieRecommendation);
   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);

   $text = "Which properties of movie you want to change?";
   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);  
   $telegram->sendMessage(['chat_id' => $chatId, 
                           'text' => $text,
                           'reply_markup' => $reply_markup]);
}