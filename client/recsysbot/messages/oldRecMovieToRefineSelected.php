<?php

function oldRecMovieToRefineSelected($chatId, $pagerankCicle){
   //valutare che il pagerank non deve andare in neativo
   
   $oldPagerankCicle = $pagerankCicle-1;

   if ($oldPagerankCicle < 0) {
      $oldPagerankCicle = 0;
   }

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
   
   file_put_contents("php://stderr", "oldRecMovieToRefineSelected:".print_r($reply)." - oldPagerankCicle:".$oldPagerankCicle.PHP_EOL);
   file_put_contents("php://stderr", "oldRecMovieToRefineSelected:".$movie." - oldPagerankCicle:".$oldPagerankCicle.PHP_EOL);

   return $movie;
}