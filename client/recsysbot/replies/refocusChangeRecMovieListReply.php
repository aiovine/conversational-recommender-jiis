<?php

//Da capire se può essere ancora utile questa funzione
function refocusChangeRecMovieListReply($telegram, $chatId, $userMovieRecommendation){

   $text = "Please wait.. I'm working for you 😉";
   
   echo '<pre>'; print_r($text); echo '</pre>';
   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);

   //Refocus sui film
   //Pone a zero i film valutati se non ci sono valutazioni
   $numberRatedMovies = $userMovieRecommendation->putUserRefocusRecListRating($chatId);

   //Refocus sulle proprietà dei film
   //recupera l'intera lista dei film raccomadnati
 //  $userMovieRecommendation->getUserMovieListTop5($chatId);
//   $movieListTop5 = $userMovieRecommendation->getUserMovieListTop5($chatId);
/* for ($i=1; $i <=5 ; $i+1) { 
      $movie = $movieListTop5[$i];
      //echo '<pre>Refocus proprietà del film:'; print_r($movie); echo '</pre>';
      //poni a zero tutte le proprietà del film per tutti i film
      $textRefocus = refocusMoviePropertiesLiteFunction($chatId, $movie);
      $i++;
   }*/

   //riesegue il pagerank e mostra all'utente una nuova lista da valutare
   $userMovieRecommendation->setPage(1);
   $userMovieRecommendation->pagerank();
}