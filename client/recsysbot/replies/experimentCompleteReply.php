<?php

//lavora per conf1-conf2-conf3-conf4
function experimentCompleteReply($telegram, $chatId, $text){

   $stars = explode(" ", $text);

   $numberStars = count($stars);
   $number_recommendation_list = getNumberRecommendationList($chatId);
   
   putExperimentalSessionRating($chatId, $number_recommendation_list, $numberStars);

   file_put_contents("php://stderr", "experimentCompleteReply :".$text." - chatId: ".$chatId." - star:".$numberStars.PHP_EOL);

	$text = " π¨βπ¬ The recommendation session is completed.";
   $text .= "\n\nπ If you enjoyed π you can start a new session by tapping\n\"π€ New Session\"";
   $text .= "\n\nπββοΈ See you soon, and donβt forget πΏ popcorn! π";

   $keyboard = [
                  ['π€ New Session']
               ];

   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);

}