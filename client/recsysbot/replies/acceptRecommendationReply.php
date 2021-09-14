<?php

//obsoleta
function acceptRecommendationReply($telegram, $chatId, $firstname, $movie_name){

	//Qui chiedere se gli piace il film, se lo ha già visto o non gli piace...stile profilo

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
	$text .= "\nfor a new recommendation 😉";
	$text .= "\n\n         🎉🎊🎊🎊🎊🎊🎊🎉";
	$text .= "\n🍕🍺🍿Enjoy your movie😃  🍿🍺🍕";

   $keyboard = [
                   ['📑 Details','📣 Why?'],
                   ["🔘 List of Recommended Movies"],
                   ['🔙 Home','👤 Profile']
               ];

   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);   

   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   $telegram->sendMessage(['chat_id' => $chatId, 
                           'text' => $text,
                           'reply_markup' => $reply_markup]);


}