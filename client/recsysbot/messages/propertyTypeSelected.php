<?php
//praticamente mai usata
function propertyTypeSelected($chatId, $pagerankCicle){

   $context = "propertyTypeSelected";
   $propertyType = null;

   $result = getChatMessage($chatId, $context, $pagerankCicle);
   if ($result !== "null") {
   	$replyText = $result['reply_text'];
   	$reply = $replyText;
    $propertyType = $reply;
   }
   else{
   	$propertyType = "null";
   }   

   file_put_contents("php://stderr", "propertyTypeSelected:".print_r($reply)." - pagerankCicle:".$pagerankCicle.PHP_EOL);
   file_put_contents("php://stderr", "propertyTypeSelected:".$propertyType." - pagerankCicle:".$pagerankCicle.PHP_EOL);

   return $propertyType;
}