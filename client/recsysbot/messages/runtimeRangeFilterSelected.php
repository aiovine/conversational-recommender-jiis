<?php

function runtimeRangeFilterSelected($chatId, $pagerankCicle){

   $context = "runtimeRangeFilterSelected";

   $result = getChatMessage($chatId, $context, $pagerankCicle);
   if ($result !== "null") {
      $replyText = $result['reply_text'];
      $reply = explode(",", $replyText);
      //$propertyType = $reply[0];
      //$propertyName = $reply[1];
      $reply[1] = substr($reply[1],1);
   }
   else{
      $reply = "null";
   }   

   file_put_contents("php://stderr", "runtimeRangeFilterSelected:".print_r($reply,true)." - pagerankCicle:".$pagerankCicle.PHP_EOL);
   file_put_contents("php://stderr", "runtimeRangeFilterSelected:".$reply." - pagerankCicle:".$pagerankCicle.PHP_EOL);
   
   return $reply;
}