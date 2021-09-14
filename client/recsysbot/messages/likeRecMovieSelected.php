<?php

function likeRecMovieSelected($chatId, $pagerankCicle){

   $context = "likeRecMovieSelected";
   $result = getChatMessage($chatId, $context, $pagerankCicle);
   if ($result !== "null") {
      $replyText = $result['reply_text'];
      $reply = explode(",", $replyText);
      //$reply[1] = substr($reply[1],1);
   }
   else{
      $reply = "null";
   } 

   file_put_contents("php://stderr", "likeRecMovieSelected:".$reply[1]." - pagerankCicle:".$pagerankCicle.PHP_EOL);

   return $reply;
}