<?php 
/**
 * @author Francesco Baccaro
 */
namespace Recsysbot\Classes;

use Telegram\Bot\Api;
use GuzzleHttp\Client;

/*
   Classe che gestisce la creazione del profilo utente attraverso i film
*/
class userProfileAcquisitionByMovie
{
   protected $telegram;
   protected $chatId;
   protected $messageId;
   protected $date;
   protected $text;
   protected $botName;

   protected $movieToRating;

   public function __construct($telegram, $chatId, $messageId, $date, $text, $botName){
      $this->setTelegram($telegram);     
      $this->setChatId($chatId);
      $this->setMessageId($messageId);
      $this->setDate($date);
      $this->setText($text);
      $this->setBotName($botName);
    }

   private function setTelegram($telegram){
      $this->telegram = $telegram;
   } 
   public function getTelegram(){
      return $this->telegram;
   }

   public function setChatId($chatId){
      $this->chatId = $chatId;
   }
   public function getChatId(){
      return $this->chatId;
   }

   public function setMessageId($messageId){
      $this->messageId = $messageId;
   } 
   public function getMessageId(){
      return $this->messageId;
   }

   public function setText($text){
      $this->text = $text;
   } 
   public function getText(){
      return $this->text;
   }

   public function setDate($date){
      $this->date = $date;
   } 
   public function getDate(){
      return $this->date;
   }

   public function setBotName($botName){
      $this->botName = $botName;
   } 
   public function getBotName(){
      return $this->botName;
   }

   public function setUserMovieToRating($movie){
      $this->movieToRating = $movie;
   }
   public function getUserMovieToRating(){
      return $this->movieToRating;
   }

   public function handle(){

      //prendi il film da valutare
      $movie = $this->getUserMovieToRating($chatId);

      //valuta il film
      $this->movieRatingReply($movie);    
   }


   public function putMovieToRating($movie){
      $chatId = $this->getChatId();
      $messageId = $this->getMessageId();
      $botName = $this->getBotName();
      $context = "movieToRatingSelected";
      $replyText = "rateMovie, ".$movie;
      $replyFunctionCall = "userMovieprofileInstance"; 
      $pagerankCicle = getNumberPagerankCicle($chatId);
      $date = $this->getDate();
      $responseType = "button";
      $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);
   }


   public function getAndSetUserMovieToRating($chatId){
      //prendi il film da valutare
      //$data = getMovieToRating($chatId);  //popolartity
      $data = getMovieToRatingByDiversity($chatId); //diversity
      $movieURI = $data;
      $movie_name = str_replace("http://dbpedia.org/resource/", "", $movieURI);
      $movie = str_replace('_', ' ', $movie_name); // Replaces all underscore with spaces.

      $this->setUserMovieToRating($movie);
      
      file_put_contents("php://stderr", "userMovieprofile->getAndSetUserMovieToRating - chatId: ".$chatId."/return movie:".$movie.PHP_EOL);

      return $movie;
   }



   public function movieRatingReply($movie){

      $telegram = $this->getTelegram();
      $chatId = $this->getChatId();      
      if ($movie !== "null") {
         $movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore
         
         file_put_contents("php://stderr", "userMovieprofile->movieRating() - chatId: ".$chatId." - movie: ".$movie.PHP_EOL);
         
         $title = $this->getTitleAndPosterMovieToRating($movie_name);

         $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'upload_photo']);

         //controllo sulla grandezza dell'immagine della locandina
         $img = './recsysbot/images/poster.jpg';
         $filesize = filesize($img); // bytes
         $filesize = round($filesize / 1024, 2); 
         file_put_contents("php://stderr", "userMovieprofile->movieRating() filesize: ".$filesize.PHP_EOL);
         if ($filesize <= 4900) {
            $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'upload_photo']);
            $telegram->sendPhoto(['chat_id' => $chatId,'photo' => $img, 'caption' => $title]);
         }
         else{
            copy('./recsysbot/images/default.jpg', './recsysbot/images/poster.jpg'); //copia nel poster l'immagine di default
            $img = './recsysbot/images/poster.jpg';
            $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'upload_photo']);
            $telegram->sendPhoto(['chat_id' => $chatId,'photo' => $img, 'caption' => $title]);
         }
         copy('./recsysbot/images/default.jpg', './recsysbot/images/poster.jpg'); //copia nel poster l'immagine di default


         $keyboard = $this->getUserRatedMovieKeyboard($chatId);
         $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);

         $text = "Do you 👍 like or 👎 dislike this movie?\nOtherwise, tap ➡skip";
         $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);       
         $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);

         $numberRatedMovies = getNumberRatedMovies($chatId);
         $numberRatedProperties = getNumberRatedProperties($chatId);
         $needNumberOfRatedProperties = 3 - ($numberRatedProperties + $numberRatedMovies);

         if ($needNumberOfRatedProperties == 0){
            $text = "\n\nI am now able to recommend you some movies 😃";
            $text .= "\nTap on \"🌐 Recommend Movies\" button, otherwise you can enrich your profile by rating this movie 🙂";

            $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);       
            $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
         }
      }
      else{
         //Se sono stati valutati tutti i film o ci sono problemi
         $text = "Sorry...😕\nI'm not be able to finding other movies right now🤔\n";
         $text .= "\nTap on \"🌐 Recommend Movies\" button 😉";

         $keyboard =    $keyboard = [
                                        ['🌐 Recommend Movies'],
                                        ['📘 Help','⚙️ Profile']
                                    ];

         $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);

         $telegram->sendChatAction(['chat_id' => $chatId, 'action' => 'typing']);       
         $telegram->sendMessage(['chat_id' => $chatId, 'text' => $text, 'reply_markup' => $reply_markup]);
      }   

   }


  private function getUserRatedMovieKeyboard($chatId){
      $numberRatedMovies = getNumberRatedMovies($chatId);
      $numberRatedProperties = getNumberRatedProperties($chatId);
      $needNumberOfRatedProperties = 3 - ($numberRatedProperties + $numberRatedMovies);
         
      if ($needNumberOfRatedProperties <= 0)
         $keyboard = ratedMovieOldUserKeyboard();
      else
         $keyboard = ratedMovieNewUserKeyboard();

      return $keyboard;
   }

  public function putUserMovieRating($chatId, $movie, $rating, $lastChange){

      if ($movie !== "null"){
         $movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore  
         $movieURI = "http://dbpedia.org/resource/";
         $movieURI .= $movie_name;

         $data = putMovieRating($chatId, $movieURI, $rating, $lastChange);
         
      }
      else{
         $data = null;
      }
      file_put_contents("php://stderr", "userMovieprofile->putUserMovieRating - chatId: ".$chatId." - movieURI: "." - rating:".$rating.PHP_EOL);

      return $data;
   }

   //inserisce la richiesta di details sul film
   public function putUserDetailsMovieRequest($chatId, $movie_name){
      if ($movie !== "null"){
         $movieURI = "http://dbpedia.org/resource/";
         $movieURI .= $movie_name;
         $number_recommendation_list = getNumberRecommendationList($chatId); 
         $details = "details";

         $data = putDetailsMovieRequest($chatId, $movieURI, $number_recommendation_list, $details);
      }
      else{
         file_put_contents("php://stderr", "userMovieprofile->putUserDetailsMovieRequest - chatId: ".$chatId." - movieURI: ".$movieURI." - number_recommendation_list:".$number_recommendation_list.PHP_EOL);
         $data = null;
      }

      return $data;
   }

   public function getTitleAndPosterMovieToRating($movie){

      $movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore 

      copy('./recsysbot/images/default.jpg', './recsysbot/images/poster.jpg'); //copia nel poster l'immagine di default

      $data = getAllPropertyListFromMovie($movie_name);

      if ($data == "null") {
         $chatId = $this->getChatId();
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $movie = movieToRatingSelected($chatId, $pagerankCicle);
         $movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore  
         $data = getAllPropertyListFromMovie($movie_name);
         file_put_contents("php://stderr", "warning - userMovieprofile->getTitleAndPosterMovieToRating - movie_name: ".$movie_name."/return title:".$title.PHP_EOL);
      }       

      $poster = $title = "";

      foreach ((array)$data as $key => $value){
         foreach ((array)$value as $k => $v) {
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
               default:
                  break;
            }
         }
      }

      if ($poster != '' AND $poster != "N/A" ) {   
         $img = './recsysbot/images/poster.jpg';
         copy($poster, $img); //copia nell'immagine l'immagine del poster
      }
      file_put_contents("php://stderr", "userMovieprofile->getTitleAndPosterMovieToRating - movie_name: ".$movie_name."/return title:".$title.PHP_EOL);

      return $title;
   }

}

