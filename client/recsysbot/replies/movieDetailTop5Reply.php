<?php 
 
use GuzzleHttp\Client;
use Telegram\Bot\FileUpload\InputFile;

function movieDetailTop5Reply($telegram, $chatId, $movie){
   
   $movie_name = str_replace(' ', '_', $movie); 

   $data = getAllPropertyListFromMovie($movie_name);

   $result = array();
   $keyboard = array();

   $directors = $starring = $categories = $genres = $writers = $producers = $musicComposers = $cinematographies = $based = $editings = $distributors = array();
   $runtime = $releaseDate = $title = $plot = $language = $country = $awards = $poster = $trailer = "";
   if ($data == "null") {
      $text ="Sorry...😕\nI'm not able to find details 🤔";
      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
      $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);
   } else {
      foreach ($data as $key => $value){
         foreach ($value as $k => $v) {
            $propertyType = str_replace("http://dbpedia.org/ontology/", "", $v[1]);
            $property = str_replace("http://dbpedia.org/resource/", "", $v[2]);
            $property = str_replace('_', ' ', $property); // Replaces all underscore with spaces.

            switch ($propertyType) {
               case "/directors": case "directors": case "director":
                  $directors[] = $property;
                  break;
               case "/starring": case "starring":
                  $starring[] = $property;
                  break;
               case "/categories": case "categories": case "category": case "http://purl.org/dc/terms/subject":
                  $property = str_replace("Category:", "", $property);
                  $categories[] = $property;
                  break;
               case "/genres": case "genres": case "genre":
                   $genres[] = $property;
                  break;
               //Sicuramente va gestita come filtro
               case "/runtime": case "runtime": case "runtimeRange":      
                  $runtime = $property;
                  break;
               case "/writers": case "writers": case "writer":
                   $writers[] = $property;
                  break;
               case "/producers": case "producers": case "producer":
                   $producers[] = $property;
                  break;
               //Sicuramente va gestita come filtro
               case "/release date": case "release date": case "releaseDate": case "releaseYear":
                  $releaseDate = $property;
                  break;
               case "/music composers": case "music composers": case "music composer": case "musicComposer":
                  $musicComposers[] = $property;
                  break;
               case "/cinematographies": case "cinematographies": case "cinematography":
                   $cinematographies[] = $property;
                  break;
               case "/based on": case "based on": case "basedOn":
                  $based[] = $property;
                  break;
               case "/editings": case "editings": case "editing":
                  $editings[] = $property;
                  break;
               case "/distributors": case "distributors": case "distributor":
                  $distributors[] = $property;
                  break;
               case "title":
                  $title = $property;
                  break;
               case "plot":
                  $plot = $property;
                  break;
               case "language":
                  $language = $property;
                  break;
               case "country":
                  $country = $property;
                  break;
               case "awards":
                  $awards = $property;
                  break;
               case "poster":
                  $poster = $property;
                  break;
               case "trailer":
                  $trailer = $property;
                  break;
               default:
                  //test
                  //$telegram->sendMessage(['chat_id' => $chatId, 'text' => $textSorry]);
                  break;
            }
         }
      }
      $director = implode(", ", array_reverse($directors));
      $star = implode(", ", array_reverse($starring));
      $genre = implode(", ", array_reverse($genres));

      $text = "";
      if ($title != '') {$text .= "Title: ".$title;}
      //if ($director != '') {$text .= "\nDirected by ".$director;}
      //if ($star !== '') {$text .= "\nStarring: ".$star;}
      //if ($genre !== '') {$text .= "\nGenre: ".$genre;}
      //if ($runtime !== '') {$text .= "\nRunning time: ".$runtime." minute";}

      if (strlen($text) > 195) {
         $text = substr($text, 0,195);
         $text .= "...";
      }

/*      if ($poster != '' AND $poster != "N/A" ) {   
         $img = './recsysbot/images/poster.jpg';
         copy($poster, $img); //copia nell'immagine l'immagine del poster
         $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'upload_photo']);
         $telegram->sendPhoto(['chat_id' => $chatId,'photo' => $img, 'caption' => $text]);
         copy('./recsysbot/images/default.jpg', './recsysbot/images/poster.jpg'); //copia nel poster l'immagine di default
      }*/

      if ($poster != '' AND $poster != "N/A" ) {            
         //controllo sulla grandezza dell'immagine della locandina
         $img = './recsysbot/images/poster.jpg';
         copy($poster, $img); //copia nell'immagine l'immagine del poster
         $filesize = filesize($img); // bytes
         $filesize = round($filesize / 1024, 2); 
         file_put_contents("php://stderr", "conf2userMovieprofile->movieRating() filesize: ".$filesize.PHP_EOL);
         if ($filesize <= 4900) {
            $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'upload_photo']);
            $telegram->sendPhoto(['chat_id' => $chatId,'photo' => $img, 'caption' => $text]);
         }
         else{
            copy('./recsysbot/images/default.jpg', './recsysbot/images/poster.jpg'); //copia nel poster l'immagine di default
            $img = './recsysbot/images/poster.jpg';
            $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'upload_photo']);
            $telegram->sendPhoto(['chat_id' => $chatId,'photo' => $img, 'caption' => $text]);
         }
         copy('./recsysbot/images/default.jpg', './recsysbot/images/poster.jpg'); //copia nel poster l'immagine di default
      }





   }
}
   
