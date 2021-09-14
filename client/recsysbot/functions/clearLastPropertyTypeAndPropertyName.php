<?php
 
function clearLastPropertyTypeAndPropertyName($fullText){
	$arrayText = explode(" - ", $fullText);
	$text = $arrayText[0];
	$text = trim($text);
	//$text = str_replace('🖊', 'writer,', $text);

	return $text;

}
