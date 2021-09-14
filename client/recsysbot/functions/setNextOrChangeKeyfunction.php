<?php

function setNextOrChangeKeyfunction($chatId){
	$numberRatedRecMovieList = getNumberRatedRecMovieList($chatId);

	if ($numberRatedRecMovieList > 0) {
		$key = "Next 👉";
	}
	else{
		$key = "💢 Change";
	}

	return $key;
}