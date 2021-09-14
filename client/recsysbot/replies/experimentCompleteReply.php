<?php

//lavora per conf1-conf2-conf3-conf4
function experimentCompleteReply($telegram, $chatId, $text){

   $stars = explode(" ", $text);

   $numberStars = count($stars);
   $number_recommendation_list = getNumberRecommendationList($chatId);
   
   putExperimentalSessionRating($chatId, $number_recommendation_list, $numberStars);

   file_put_contents("php://stderr", "experimentCompleteReply :".$text." - chatId: ".$chatId." - star:".$numberStars.PHP_EOL);

	$text = " 👨‍🔬 The recommendation session is completed.";
   $text .= "\n\n😊 If you enjoyed 😁 you can start a new session by tapping\n\"🤖 New Session\"";
   $text .= "\n\n🙋‍♂️ See you soon, and don’t forget 🍿 popcorn! 😃";

   $keyboard = [
                  ['🤖 New Session']
               ];

   $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
   $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
   $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);

}