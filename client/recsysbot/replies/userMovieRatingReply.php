<?php

function userMovieRatingReply($telegram, $chatId, $rating, $lastChange, $userMovieprofile){

   $pagerankCicle = getNumberPagerankCicle($chatId);
   $movieName = movieToRatingSelected($chatId, $pagerankCicle);
   $userMovieprofile->setUserMovieToRating($movieName);


   if ($movieName !== "null" && $rating !== "null" ) {/**/

      $oldNumberOfRatedMovies = getNumberRatedMovies($chatId);
      $data = $userMovieprofile->putUserMovieRating($chatId, $movieName, $rating, $lastChange);
      
      $numberRatedMovies = getNumberRatedMovies($chatId);
      $numberRatedProperties = getNumberRatedProperties($chatId);

      $needNumberOfRatedMovies = 3 - ($numberRatedProperties + $numberRatedMovies);

      $title = $userMovieprofile->getTitleAndPosterMovieToRating($movieName);
      

      if ($needNumberOfRatedMovies > 0) {

         if ($rating == 2) {
            $text = "You skipped\n \"".$title."\" movie.\nI need ".$needNumberOfRatedMovies." more ratings 😉";
         }
         elseif ($numberRatedMovies > $oldNumberOfRatedMovies) {
            $text = "You have rated \"".$title."\" movie \nI need ".$needNumberOfRatedMovies." more ratings 😉";
         } 
         else {
            $text = "I need ".$needNumberOfRatedMovies." more ratings 😉";
         }

      } 
      else {

         if ($rating == 2) {
            $text = "You skipped\n \"".$title."\" movie.";
         }
         elseif ($numberRatedMovies > $oldNumberOfRatedMovies) {
            $text = "You have rated \"".$title."\" movie \nProfile updated with ".$numberRatedMovies." rated movies";
         } 
         else {
            $text = "You have rated ".$numberRatedMovies." movies";
         }

      }
      
      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);   
      $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);

      $movieName = $userMovieprofile->getAndSetUserMovieToRating($chatId);
      $userMovieprofile->putMovieToRating($movieName);
      $userMovieprofile->handle();

   }
   else{
      //Se non trova il film fa valutare
      $text = "Sorry...😕\nI'm not be able to finding movies right now🤔";


      $keyboard = [
                      ['🔙 Home']
                  ];

      $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);

      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);       
      $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);

   }
   

   

}