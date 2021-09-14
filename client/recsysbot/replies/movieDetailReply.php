<?php 
 
use GuzzleHttp\Client;
use Telegram\Bot\FileUpload\InputFile;

function movieDetailReply($telegram, $chatId, $movie, $page){

    $movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore
   $data = getAllPropertyListFromMovie($movie_name);

   $result = array();
   $keyboard = array();

   $directors = $starring = $genres = $writers = $producers = array();
   $runtimeMinutes = $releaseYear = $title = $imdbRating = $poster = "";
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
               case "poster":
                  $poster = $property;
                  break;
               case "title":
                  $title = $property;
                  break;
               case "runtimeMinutes":      
                  $runtimeMinutes = $property;
                  break;
               case "releaseYear":
                  $releaseYear = $property;
                  break;
               case "imdbRating":
                  $imdbRating = $property;
                  break;
               case "director":
                  $directors[] = $property;
                  break;
               case "starring":
                  $starring[] = $property;
                  break;
               case "genre":
                   $genres[] = $property;
                  break;
               case "producer":
                   $producers[] = $property;
                  break;
               case "writer":
                   $writers[] = $property;
                  break;             
               default:
                  //test
                  //$telegram->sendMessage(['chat_id' => $chatId, 'text' => $textSorry]);
                  break;
            }
         }
      }

      $director = implode(", ", array_slice($directors, 0, 3));
      $star = implode(", ", array_slice($starring, 0, 3));
      $genre = implode(", ", array_slice($genres, 0, 3));

      $producer = implode(", ",array_slice($producers, 0, 3));
      $writer = implode(", ", array_slice($writers, 0, 3));    

/*      if ($poster != '' AND $poster != "N/A" ) {   
         //$img = './../recsysbot/images/poster.jpg'; //in test
         
         $img = './recsysbot/images/poster.jpg';
         copy($poster, $img); //copia nell'immagine l'immagine del poster

         $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'upload_photo']);
         $telegram->sendPhoto(['chat_id' => $chatId,'photo' => $img]);
         copy('./recsysbot/images/default.jpg', './recsysbot/images/poster.jpg'); //copia nel poster l'immagine di default

         //copy('./../recsysbot/images/default.jpg', './../recsysbot/images/poster.jpg'); //in test
      }
*/
      if ($poster != '' AND $poster != "N/A" ) {
         copy('./recsysbot/images/default.jpg', './recsysbot/images/poster.jpg'); //copia nel poster l'immagine di default            
         //controllo sulla grandezza dell'immagine della locandina
         $img = './recsysbot/images/poster.jpg';
         copy($poster, $img); //copia nell'immagine l'immagine del poster
         $filesize = filesize($img); // bytes
         $filesize = round($filesize / 1024, 2); 
         file_put_contents("php://stderr", "userMovieprofile->movieRating() filesize: ".$filesize.PHP_EOL);
         if ($filesize <= 4900) {
            $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'upload_photo']);
            $telegram->sendPhoto(['chat_id' => $chatId,'photo' => $img]);
         }
         else{
            copy('./recsysbot/images/default.jpg', './recsysbot/images/poster.jpg'); //copia nel poster l'immagine di default
            $img = './recsysbot/images/poster.jpg';
            $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'upload_photo']);
            $telegram->sendPhoto(['chat_id' => $chatId,'photo' => $img]);
         }
         copy('./recsysbot/images/default.jpg', './recsysbot/images/poster.jpg'); //copia nel poster l'immagine di default  
      }


      $text = "";
      if ($title !== '') {$text .= "🎥 *".$title."*";}
         if ($releaseYear !== '') {$text .= " *(".$releaseYear.")*";}

      if ($runtimeMinutes !== '') {$text .= "\n_".$runtimeMinutes."min_ "."⭐️*".$imdbRating."*"." @imdb";}
      
      $SizeDirectors = count($directors);
      if ($SizeDirectors <= 3) {
         if ($director !== '') {$text .= "\n*Director: *".$director;}
         elseif($producer !== '') {$text .= "\n*Producers: *".$producer;}
            elseif($writer !== '') {$text .= "\n*Writers: *".$writer;}
      } else {
         if ($director !== '') {$text .= "\n*Director: *".$director."...";}
         elseif($producer !== '') {$text .= "\n*Producers: *".$producer;}
            elseif($writer !== '') {$text .= "\n*Writers: *".$writer;}
      }  
      
      if ($star !== '') {$text .= "\n*Actors: *".$star."...";}
         elseif($director !== '' && $producer !== '') {$text .= "\n*Producers: *".$producer;}
            elseif($director !== '' && $writer !== '') {$text .= "\n*Writers: *".$writer;}      

      if ($genre !== '') {$text .= "\n*Genres: *".$genre;}

      //Crea la tastiera per la valutazione del film raccomandato
      $keyboard = recMovieKeyboard($chatId, $page);
      
      // echo '<pre>'; echo($text); echo '</pre>';
      // echo '<pre>'; print_r($keyboard); echo '</pre>';

      $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);

      $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
      $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup, 'parse_mode' => 'Markdown']);

      //inserisce il testo che consiglia di andare indietro
      $change = setNextOrChangeKeyfunction($chatId);
      if ($page == 5 && (strcasecmp($change, "💢 Change") == 0) ) {
         $text = "If you don’t like this set of movies, please tap \"💢 Change\".\nOtherwise go back in the list 😉";
         
         $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);
         $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text]);
      }

   }
}
