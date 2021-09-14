<?php

function recMovieToRefineSelected($chatId, $pagerankCicle){

   $context = "recMovieToRefineSelected";
   $movie = null;

   $result = getChatMessage($chatId, $context, $pagerankCicle);
   if ($result !== "null") {
      $replyText = $result['reply_text'];
      $reply = explode(",", $replyText);
      //$reply[1] = substr($reply[1],1);
      $movie = $reply[1];
   }
   else{
      $movie = "null";
   }   

   file_put_contents("php://stderr", "recMovieToRefineSelected:".print_r($reply)." - pagerankCicle:".$pagerankCicle.PHP_EOL);
   file_put_contents("php://stderr", "recMovieToRefineSelected:".$movie." - pagerankCicle:".$pagerankCicle.PHP_EOL);
   
   return $movie;
}