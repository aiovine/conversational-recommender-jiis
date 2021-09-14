<?php 

function callRefineOrRefocusFunction($telegram, $chatId, $userMovieRecommendation){

	$pagerankCicle = getNumberPagerankCicle($chatId);
   $text = null;

	if ($pagerankCicle == 0) {
		 refineMoviePropertyReply($telegram, $chatId, $userMovieRecommendation);
	}
	else{
		$oldRecMovieToRefineSelected = oldRecMovieToRefineSelected($chatId, $pagerankCicle);
		$lastRecMovieToRefineSelected = recMovieToRefineSelected($chatId, $pagerankCicle);

		$text = "".$pagerankCicle."^ cicle of recommendation...";
       $text .= "\nDuring previous cycle you have chosen:";
       $text .= "\n\"".ucwords($oldRecMovieToRefineSelected)."\"";
       $text .= "\nIn this cycle you have chosen:";
       $text .= "\n\"".ucwords($lastRecMovieToRefineSelected)."\"";

      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);  

   	if (strcasecmp($oldRecMovieToRefineSelected, $lastRecMovieToRefineSelected) == 0){
         $text .= "\nYou have chosen:";
         $text .= "\n\"".ucwords($lastRecMovieToRefineSelected)."\"";
         $text .= "\nWe continue with Refocus";

         $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);

         refocusFunctionReply($telegram, $chatId);
   	}
   	else{
         $text .= "\nYou have chosen:";
         $text .= "\n\"".ucwords($lastRecMovieToRefineSelected)."\"";
         $text .= "\nWe continue with Refine";

         $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);

         refineFunctionReply($telegram, $chatId, $userMovieRecommendation);
   	}
   	
	}

}

