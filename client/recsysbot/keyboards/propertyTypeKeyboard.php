<?php
 
use GuzzleHttp\Client;


function propertyTypeKeyboard($chatId){

	$userID = $chatId;

	$text = "null";
		
	$director = propertyValueKeyboard($userID, "director", $text); 
	$starring = propertyValueKeyboard($userID, "starring", $text);
	$category = propertyValueKeyboard($userID, "category", $text);
	$genre = propertyValueKeyboard($userID, "genre", $text);
	$writer = propertyValueKeyboard($userID, "writer", $text);
	$producer = propertyValueKeyboard($userID, "producer", $text);
	$releaseYear = propertyValueKeyboard($userID, "releaseYear", $text);
	$musicComposer = propertyValueKeyboard($userID, "musicComposer", $text);
	$runtimeRange = propertyValueKeyboard($userID, "runtimeRange", $text);
	$cinematography = propertyValueKeyboard($userID, "cinematography", $text);
	$basedOn = propertyValueKeyboard($userID, "basedOn", $text);
	$editing = propertyValueKeyboard($userID, "editing", $text);
	$distributor = propertyValueKeyboard($userID, "distributor", $text);

	$size_director = count($director);
	$size_starring = count($starring);
	$size_category = count($category);
	$size_genre = count($genre);
	$size_writer = count($writer);
	$size_producer = count($producer);
	$size_releaseYear = count($releaseYear);
	$size_musicComposer = count($musicComposer);
	$size_runtimeRange = count($runtimeRange);
	$size_cinematography = count($cinematography);
	$size_basedOn = count($basedOn);
	$size_editing = count($editing);
	$size_distributor = count($distributor);

	$fullMenuArray = array();

	if ($size_director > 0) {$fullMenuArray[10+$size_director."director"] = "Director";}
	if ($size_starring > 0) {$fullMenuArray[10+$size_starring."starring"] = "Actor";}
	if ($size_category > 0) {$fullMenuArray[10+$size_category."category"] = "Category";}
	if ($size_genre > 0) {$fullMenuArray[10+$size_genre."genre"] = "Genre";}
	if ($size_writer > 0) {$fullMenuArray[10+$size_writer."writer"] = "Writer";}
	if ($size_producer > 0) {$fullMenuArray[10+$size_producer."producer"] = "Producer";}
	if ($size_releaseYear > 0) {$fullMenuArray[10+$size_releaseYear."releaseYear"] = "Release year";}
	if ($size_musicComposer > 0) {$fullMenuArray[10+$size_musicComposer."musicComposer"] = "Music";}
	if ($size_runtimeRange > 0) {$fullMenuArray[10+$size_runtimeRange."runtimeRange"] = "Runtime";}
	if ($size_cinematography > 0) {$fullMenuArray[10+$size_cinematography."cinematography"] = "Cinematography";}
	if ($size_basedOn > 0) {$fullMenuArray[10+$size_basedOn."basedOn"] = "Based on";}
	if ($size_editing > 0) {$fullMenuArray[10+$size_editing."editing"] = "Editor";}
	if ($size_distributor > 0) {$fullMenuArray[10+$size_distributor."distributor"] = "Distributor";}

	krsort($fullMenuArray);

   return $fullMenuArray;

}