<?php 
/**
 * @author Francesco Baccaro
 * 
 * Assegna peso maggiore ai valori del film scelto che l'utente non ha modificato
 *
 */


function refineFunction($chatId){   

	$pagerankCicle = getNumberPagerankCicle($chatId);
	$movie = recMovieToRefineSelected($chatId, $pagerankCicle);
	$movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore
	$data = getAllPropertyListFromMovie($movie_name);

   $text = "We continue with Refine...";

   $directors = $starring = $categories = $genres = $writers = $producers = $musicComposers = $cinematographies = $based = $editings = $distributors = array();
   $runtime = $releaseDate = "";
   if ($data !== "null") {
      foreach ($data as $key => $value){
         foreach ($value as $k => $v) {
            $propertyType = str_replace("http://dbpedia.org/ontology/", "", $v[1]);
            $propertyTypeUri = $v[1];
            $propertyUri =  $v[2];

            switch ($propertyType) {
               case "/directors": case "directors": case "director":
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);
                  break;
               case "/starring": case "starring":
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);
                  break;
               case "/categories": case "categories": case "category": case "http://purl.org/dc/terms/subject":
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);
                  break;
               case "/genres": case "genres": case "genre":
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);                
                  break;
/*               case "/runtime": case "runtime": case "runtimeRange":      
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);
                  break;*/
               case "/writers": case "writers": case "writer":
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);
                  break;
               case "/producers": case "producers": case "producer":
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);
                  break;
/*               case "/release date": case "release date": case "releaseDate": case "releaseYear":
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);
                  break;*/
               case "/music composers": case "music composers": case "music composer": case "musicComposer":
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);
                  break;
               case "/cinematographies": case "cinematographies": case "cinematography":
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);
                  break;
               case "/based on": case "based on": case "basedOn":
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);
                  break;
               case "/editings": case "editings": case "editing":
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);
                  break;
               case "/distributors": case "distributors": case "distributor":
                  refineSubFunction($chatId, $propertyTypeUri, $propertyUri);
                  break;
               default:
                  break;
            }
         }
      }
   $pagerankCicle = getNumberPagerankCicle($chatId);
   putNumberPagerankCicle($chatId, $pagerankCicle+1);
 	}
   else{
      $text = "Problem with refine function...";
   }

   return $text;
}