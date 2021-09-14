<?php

use Recsysbot\Classes\userMovieRecommendation;

function recMovieRatingReply($telegram, $chatId, $rating, $lastChange, $messageId, $text, $botName, $date, $userMovieRecommendation){

   $pagerankCicle = getNumberPagerankCicle($chatId);

   $text = null;

   if ($rating == 1) {
      $reply = likeRecMovieSelected($chatId, $pagerankCicle);
      $movie = $reply[1];
      //poni a uno il like
      $userMovieRecommendation->putUserLikeRecMovieRating($chatId, $movie, $rating, $lastChange);
      //putRecMovieRating($chatId, $movieURI, $rating, $position, $pagerank_cicle, $refineRefocus, $botName, $message_id, $bot_timestamp, $recommendatinsList, $ratingsList, $number_recommendation_list)
      $text = "You Like";
   } elseif ($rating == 0) {
      $reply = dislikeRecMovieSelected($chatId, $pagerankCicle);
      $movie = $reply[1];
      //$userMovieRecommendation->setUserRecMovieToRating($movie);
      $userMovieRecommendation->putUserDislikeRecMovieRating($chatId, $movie, $rating, $lastChange);
      //putRecMovieRating($chatId, $movieURI, $rating, $position, $pagerank_cicle, $refineRefocus, $botName, $message_id, $bot_timestamp, $recommendatinsList, $ratingsList, $number_recommendation_list)
      $text = "You Dislike";
   }
   
   $title = $userMovieRecommendation->getTitleAndPosterRecMovieToRating($movie);

   $text = $text." \"".$title."\" movie 😉";
   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);   
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);

   echo '<pre>'; echo($text); echo '</pre>';
   
   $page = $userMovieRecommendation->getPageFromMovieName($chatId,$movie);
   $page = $page+1;
   $text = $page;
   backNextFunction($telegram, $chatId, $messageId, $text, $botName, $date, $userMovieRecommendation);

   

}