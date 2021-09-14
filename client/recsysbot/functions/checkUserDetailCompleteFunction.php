<?php 
use GuzzleHttp\Client;

function checkUserDetailCompleteFunction($chatId){

	$userDetail = getUserDetail($chatId);

	$id = $firstname = $lastname = $username = $userAge = $userGender = $userEducation = $userInterestInMovies = $userUsedRecommenderSystem = null;

   if ($userDetail != "null") {
      foreach ($userDetail as $key => $value){

      	switch ($key) {
				case "id":
	            $id = $value;
	            break;
				case "firstname":
	            $firstname = $value;
	            break;
				case "lastname": 
	            $lastname = $value;
	            break;
				case "username": 
	            $username = $value;
	            break;
				case "age": 
	             $userAge = $value;
	            break;
				case "gender": 
	            $userGender = $value;
	            break;
				case "education": 
	            $userEducation = $value;
	            break;
				case "interestInMovies": 
	            $userInterestInMovies = $value;
	            break;
	         case "usedRecommenderSystem": 
	            $userUsedRecommenderSystem = $value;
	            break;
	         default:
	            break;
	      }
      }
   }	
	if ($userAge == null) {
		return false;
   }
   elseif ($userGender == null) {
		return false;
   }
   elseif ($userEducation == null) {
   	return false;
   }
   elseif ($userInterestInMovies == null){
   	return false;
   }
   elseif ($userUsedRecommenderSystem == null) {
   	return false;
   }
   else{
   	return true;
   }
   
}
