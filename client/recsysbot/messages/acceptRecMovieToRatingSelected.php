<?php
 
function acceptRecMovieToRatingSelected($chatId, $pagerankCicle){

   $context = "acceptRecMovieToRatingSelected";
   $result = getChatMessage($chatId, $context, $pagerankCicle);
   if ($result !== "null") {
      $replyText = $result['reply_text'];
      $reply = explode(",", $replyText);
      //$reply[1] = substr($reply[1],1);
   }
   else{
      $reply = "null";
   } 

   file_put_contents("php://stderr", "acceptRecMovieToRatingSelected 0:".$reply[0]." - pagerankCicle:".$pagerankCicle.PHP_EOL);
   file_put_contents("php://stderr", "acceptRecMovieToRatingSelected 1:".$reply[1]." - pagerankCicle:".$pagerankCicle.PHP_EOL);

   return $reply;
}