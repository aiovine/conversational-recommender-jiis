<?php
use GuzzleHttp\Client;

function refineMoviePropertyReply($telegram, $chatId, $userMovieRecommendation){

   $pagerankCicle = getNumberPagerankCicle($chatId);
   $movie = recMovieToRefineSelected($chatId, $pagerankCicle);

   //$text = "".$pagerankCicle."^ cicle of recommendation...";
   // $text .= "\nYou have chosen:";
   // $text .= "\n\"".ucwords($movie)."\"";
   // $text .= "\nWe continue with Classic Refine";

   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);  


   //inserisce il rating come refine del film raccomandato
   $userMovieRecommendation->putUserRefineRecMovie($chatId, $movie);

   $text = "Which properties of ".ucwords($movie)."\" you want to change?";
   
  $keyboard = refineMoviePropertyKeyboard($chatId, $movie, $userMovieRecommendation);

   // echo '<pre>'; echo($text); echo '</pre>';
   // echo '<pre>'; print_r($keyboard); echo '</pre>';

   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);

   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);  
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
}