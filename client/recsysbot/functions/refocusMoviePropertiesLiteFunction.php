<?php 
/**
 * @author Francesco Baccaro
 * 
 * Assegna peso minimo ai valori del film scelto
 * PS.. Al momento anche a quelle già indicate dall' utente
 *
 */

function refocusMoviePropertiesLiteFunction($chatId, $movie){

	$pagerankCicle = getNumberPagerankCicle($chatId);
	$rating = 0;
	$lastChange = "refocus";	
	$movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore
	$data = getAllPropertyListFromMovie($movie_name);

   $text = "We continue with Refocus...";

/*   $directors = $starring = $categories = $genres = $writers = $producers = $musicComposers = $cinematographies = $based = $editings = $distributors = array();
   $runtime = $releaseDate = "";*/

    $directors = $starring = $categories = $writers = $producers = $cinematographies = array();


   if ($data !== "null") {
      foreach ($data as $key => $value){
         foreach ($value as $k => $v) {
            $propertyType = str_replace("http://dbpedia.org/ontology/", "", $v[1]);
            $propertyTypeURI = $v[1];
            $propertyURI =  $v[2];

            switch ($propertyType) {
               case "/directors": case "directors": case "director":
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);
                  break;
               case "/starring": case "starring":
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);                  
                  break;
/*               case "/categories": case "categories": case "category": case "http://purl.org/dc/terms/subject":
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);
                  break;*/
/*               case "/genres": case "genres": case "genre":
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);
                  break;*/
/*               case "/runtime": case "runtime": case "runtimeRange":      
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);
                  break;*/
/*               case "/writers": case "writers": case "writer":
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);
                  break;*/
/*               case "/producers": case "producers": case "producer":
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);
                  break;*/
/*               case "/release date": case "release date": case "releaseDate": case "releaseYear":
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);
                  break;*/
/*               case "/music composers": case "music composers": case "music composer": case "musicComposer":
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);
                  break;*/
/*               case "/cinematographies": case "cinematographies": case "cinematography":
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);
                  break;*/
/*               case "/based on": case "based on": case "basedOn":
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);
                  break;*/
/*               case "/editings": case "editings": case "editing":
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);
                  break;*/
/*               case "/distributors": case "distributors": case "distributor":
                  putPropertyUriRating($chatId, $propertyTypeURI, $propertyURI, $rating, $lastChange);
                  break;*/
               default:
                  break;
            }
         }
      }
 	// $pagerankCicle = getNumberPagerankCicle($chatId);
  //  putNumberPagerankCicle($chatId, $pagerankCicle+1);
   }
   else{
      $text = "Problem with refocus function...";
   }

   return $text;
}