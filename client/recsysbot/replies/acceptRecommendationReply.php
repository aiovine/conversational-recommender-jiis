<?php

//obsoleta
function acceptRecommendationReply($telegram, $chatId, $firstname, $movie_name){

	//Qui chiedere se gli piace il film, se lo ha giΓ  visto o non gli piace...stile profilo

	//inserisci il film tra quelli accettati
	if ($movie_name !== "null"){
         $movieURI = "http://dbpedia.org/resource/";
         $movieURI .= $movie_name;
         $rating = 3;
         $data = putAcceptRecMovieRating($chatId, $movieURI, $rating);
   }

	detailReply($telegram, $chatId, $movie_name);

	//aggiungi alla lista dei film da vedere
	//aggiungi alla lista dei film visti

	/*Perfect Francesco.
	You can read the movie details and watch the trailer
	add movie to your list of films seen or to see
	or tap "Start" to start with a new Recommendation
	Enjoy your movie*/


	$text = "Perfect ".$firstname."!";
	$text .= "\nYou can read the movie details";
	$text .= "\nand watch the trailer or tap \"Home\"";
	//$text .= "\nadd movie to your list of films seen or to see";
	$text .= "\nfor a new recommendation π";
	$text .= "\n\n         ππππππππ";
	$text .= "\nππΊπΏEnjoy your movieπ  πΏπΊπ";

   $keyboard = [
                   ['π Details','π£ Why?'],
                   ["π List of Recommended Movies"],
                   ['π Home','π€ Profile']
               ];

   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);   

   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   $telegram->sendMessage(['chat_id' => $chatId, 
                           'text' => $text,
                           'reply_markup' => $reply_markup]);


}