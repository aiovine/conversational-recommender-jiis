<?php 

function explanationMovieReply($telegram, $chatId, $userMovieRecommendation){

   $pagerankCicle = getNumberPagerankCicle($chatId);
   $movie = recMovieSelected($chatId, $pagerankCicle);
   $movie_name = str_replace(' ', '_', $movie);

   //inserisce la richiesta di why? del film raccomandato
   $userMovieRecommendation->putUserWhyRecMovieRequest($chatId, $movie_name);

   $text = getMovieExplanation($chatId, $movie_name);

   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);  
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);   	

}