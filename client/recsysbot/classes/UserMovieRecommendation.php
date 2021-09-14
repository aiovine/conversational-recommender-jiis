<?php 
/**
 * @author Francesco Baccaro
 */
namespace Recsysbot\Classes;

use Telegram\Bot\Api;
use GuzzleHttp\Client;


/*
   Classe che gestisce le raccomandazioni
*/
class userMovieRecommendation
{
   protected $telegram;
   protected $chatId;
   protected $messageId;
   protected $date;
   protected $text;
   protected $page;
   protected $botName;
   
   protected $movieToRecommender;
   protected $movieListTop5;
   protected $recMovieToRating;

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

   public function setPage($page){
      $this->page = filter_var($page, FILTER_SANITIZE_NUMBER_INT);
   } 
   public function getPage(){
      return $this->page;
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

   private function setMovieToRecommender($movieName){
      $this->movieToRecommender = $movieName;
   }
   public function getMovieToRecommender(){
      return $this->movieToRecommender;
   }

   public function setMovieListTop5($movieListTop5){
      $this->movieListTop5 = $movieListTop5;
   }
   public function getMovieListTop5(){
      return $this->movieListTop5;
   }

   public function setUserRecMovieToRating($movie){
      $this->recMovieToRating = $movie;
   }
   public function getUserRecMovieToRating(){
      return $this->recMovieToRating;
   }


   public function handle(){

      $telegram = $this->getTelegram();
      $chatId = $this->getChatId();
      $messageId = $this->getMessageId();    
      $date = $this->getDate();
      $page = $this->getpage();
      $botName = $this->getBotName();
      
      //recupera l'ultima lista di raccomandazione
      $movieListTop5 = $this->getUserMovieListTop5($chatId);

      $this->setMovieListTop5($movieListTop5);

      $sizeMovieList = count($movieListTop5);

      //controllo che non ci siano meno di cinque film nella lista
      if ($sizeMovieList < 5) {
         $movieName = $movieListTop5[$sizeMovieList];
         $page++;
      }
      else{
         $movieName = $movieListTop5[$page];
      }
      
      

      $this->setMovieToRecommender($movieName);  

      //inserisci nella chat il film raccomandato 
      $context = "recMovieSelected";
      $replyText = $page."recMovie,".$movieName;
      $replyFunctionCall = "movieDetailReply"; 
      $pagerankCicle = getNumberPagerankCicle($chatId);
      $responseType = "button";
      $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);

      //salva il film come visualizzato
      $this->putUserRecMovieToRating($chatId, $movieName);

      //mostra i dettagli del film all'utente
      movieDetailReply($telegram, $chatId, $movieName, $page);

      file_put_contents("php://stderr", "userMovieRecommendation handle: page: ".$page." - movieName: ".$movieName.PHP_EOL);

   }

   public function pagerank(){

      $telegram = $this->getTelegram();
      $chatId = $this->getChatId();
      $messageId = $this->getMessageId();    
      $date = $this->getDate();
      $page = $this->getpage();
      $botName = $this->getBotName();      

      //aggiorna il pagerank    
      $pagerankCicle = getNumberPagerankCicle($chatId);
      putNumberPagerankCicle($chatId, $pagerankCicle+1);

      //aggiorna la lista di raccomandazione
      $oldNumber_recommendation_list = getNumberRecommendationList($chatId);
      $newNumber_recommendation_list = putNumberRecommendationList($chatId, $oldNumber_recommendation_list+1);

      //lacia il pagerank e crea la lista
      $movieListTop5 = $this->getPagerankForUserRecMovieListTop5($chatId);
      $this->setMovieListTop5($movieListTop5);
      $movieName = $movieListTop5[$page];

      $this->setMovieToRecommender($movieName);  

      //inserisci nella chat il film raccomandato 
      $context = "recMovieSelected";
      $replyText = $page."recMovie,".$movieName;
      $replyFunctionCall = "movieDetailReply"; 
      $pagerankCicle = getNumberPagerankCicle($chatId);
      $responseType = "button";
      $result = putChatMessage($chatId, $messageId, $context, $replyText, $replyFunctionCall, $pagerankCicle, $botName, $date, $responseType);


      //salva il film come visualizzato
      $this->putUserRecMovieToRating($chatId, $movieName);

      //mostra i dettagli del film all'utente
      movieDetailReply($telegram, $chatId, $movieName, $page);

      file_put_contents("php://stderr", "userMovieRecommendation pagerank: page: ".$page." - movieName: ".$movieName.PHP_EOL);

   }

   //lacia il pagerank e crea la lista
   public function getPagerankForUserRecMovieListTop5($chatId){

      file_put_contents("php://stderr", "userMovieRecommendation->getPagerankForUserRecMovieListTop5: chatId: ".$chatId.PHP_EOL);
      $keyboard = pagerankUserRecMovieListTop5Keyboards($chatId);
      $movieListTop5 = array();
          
      if (sizeof($keyboard) == 1) {
         $movieListTop5 = array();
      } 
      else {
         $i = 1;
         foreach ($keyboard as $key => $property) {
            if (stristr($property[0], '🔙') == false) {
               $movie = $property[0];
               $movie = str_replace('🎥', '', $movie);
               $movie = trim($movie);
               $movieListTop5[$i] = $movie;
               $i++;
            }                
         }
      }
      file_put_contents("php://stderr", "userMovieRecommendation->getPagerankForUserRecMovieListTop5 CREATE chatId: ".$chatId.PHP_EOL);
      return $movieListTop5;
   }

   //recupera l'ultima lista di raccomandazione
   public function getUserMovieListTop5($chatId){

      $keyboard = recommendationMovieListTop5Keyboards($chatId);
      $movieListTop5 = array();
          
      if (sizeof($keyboard) == 1) {
         $movieListTop5 = array();
      } 
      else {
         $i = 1;
         foreach ($keyboard as $key => $property) {
            if (stristr($property[0], '🔙') == false) {
               $movie = $property[0];
               $movie = str_replace('🎥', '', $movie);
               $movie = trim($movie);
               $movieListTop5[$i] = $movie;
               $i++;
            }                
         }
      }

      return $movieListTop5;
   }

   public function getPageFromMovieName($chatId,$movieName){

      $keyboard = recommendationMovieListTop5Keyboards($chatId);
      $movieListTop5 = array();

      $page = null;
          
      if (sizeof($keyboard) == 1) {
         $page = null;
      } 
      else {
         $i = 1;
         foreach ($keyboard as $key => $property) {
            if (stristr($property[0], '🔙') == false) {
               $movie = $property[0];
               $movie = str_replace('🎥', '', $movie);
               $movie = trim($movie);
               $movieListTop5[$i] = $movie;
               $i++;
            }                
         }
         //$i = array_search($movieName,$movieListTop5);
         $i = array_search(strtolower($movieName),array_map('strtolower',$movieListTop5)); 
         $page = $i;
      }
      file_put_contents("php://stderr", "userMovieRecommendation getPageFromMovieName: page: ".$page." - movieListTop5: ".print_r($movieListTop5, true).PHP_EOL);
      
      return $page;
   }




   //Salva il film visualizzato nella lista dei film raccomandati ma da valutare
   public function putUserRecMovieToRating($chatId, $movie){

      if ($movie !== "null"){
         $movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore  
         $movieURI = "http://dbpedia.org/resource/";
         $movieURI .= $movie_name;
         $number_recommendation_list = getNumberRecommendationList($chatId);
         $position = $this->getPageFromMovieName($chatId, $movie);
         $pagerank_cicle = getNumberPagerankCicle($chatId);
         $botName = $this->getBotName();
         $message_id = $this->getMessageId();
         $bot_timestamp = $this->getDate();

         $data = putRecMovieToRating($chatId, $movieURI, $number_recommendation_list, $position, $pagerank_cicle, $botName, $message_id, $bot_timestamp);
      }
      else{
         file_put_contents("php://stderr", "userMovieRecommendation->putUserRecMovieToRating - chatId: ".$chatId." - movieURI: ".$movieURI." - number_recommendation_list:".$number_recommendation_list.PHP_EOL);
         $data = null;
      }

      return $data;
   }

   //inserisce il rating del film raccomandato valutato positivamente = 1
  public function putUserLikeRecMovieRating($chatId, $movie, $rating, $lastChange){

      if ($movie !== "null"){
         $movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore  
         $movieURI = "http://dbpedia.org/resource/";
         $movieURI .= $movie_name;
         $number_recommendation_list = getNumberRecommendationList($chatId);       

         //inserisce il rating del film raccomandato valutato positivamente
         $data = putLikeRecMovieRating($chatId, $movieURI, $number_recommendation_list, $rating);

         //inserisce il film tra quelli valutati dall'utente e lo insirisce nel suo profilo
         $data2 = putMovieRating($chatId, $movieURI, $rating, $lastChange);
      }
      else{
         file_put_contents("php://stderr", "userMovieRecommendation->putUserLikeRecMovieRating - chatId: ".$chatId." - movieURI: ".$movieURI." - number_recommendation_list:".$number_recommendation_list.PHP_EOL);
         $data = null;
      }

      return $data;
   }

   //inserisce il rating del film raccomndato valutato negativamente = 0
  public function putUserDislikeRecMovieRating($chatId, $movie, $rating, $lastChange){

      if ($movie !== "null"){
         $movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore  
         $movieURI = "http://dbpedia.org/resource/";
         $movieURI .= $movie_name;
         $number_recommendation_list = getNumberRecommendationList($chatId);       
   
         //inserisce il rating del film raccomndato valutato negativamente = 0, a 1 sul db
         $dislike = 1;
         $data = putDislikeRecMovieRating($chatId, $movieURI, $number_recommendation_list, $dislike);
         
         //inserisce il film tra quelli valutati dall'utente e lo insirisce nel suo profilo
         $data2 = putMovieRating($chatId, $movieURI, $rating, $lastChange);
      }
      else{
         file_put_contents("php://stderr", "userMovieRecommendation->putUserDislikeRecMovieRating - chatId: ".$chatId." - movieURI: ".$movieURI." - number_recommendation_list:".$number_recommendation_list.PHP_EOL);
         $data = null;
      }

      return $data;
   }

   //inserisce il rating come refine del film raccomandato
   public function putUserRefineRecMovie($chatId, $movie){
      if ($movie !== "null"){
         $movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore  
         $movieURI = "http://dbpedia.org/resource/";
         $movieURI .= $movie_name;
         $number_recommendation_list = getNumberRecommendationList($chatId); 
         $refine = "refine";

         $data = putRefineRecMovieRating($chatId, $movieURI, $number_recommendation_list, $refine);
      }
      else{
         file_put_contents("php://stderr", "userMovieRecommendation->putUserRefineRecMovie - chatId: ".$chatId." - movieURI: ".$movieURI." - number_recommendation_list:".$number_recommendation_list.PHP_EOL);
         $data = null;
      }

      return $data;
   }

   //inserisce la richiesta di details sul film raccomandato
   public function putUserDetailsRecMovieRequest($chatId, $movie_name){
      if ($movie !== "null"){
         $movieURI = "http://dbpedia.org/resource/";
         $movieURI .= $movie_name;
         $number_recommendation_list = getNumberRecommendationList($chatId); 
         $details = "details";

         $data = putDetailsRecMovieRequest($chatId, $movieURI, $number_recommendation_list, $details);
      }
      else{
         file_put_contents("php://stderr", "userMovieRecommendation->putUserDetailsRecMovieRequest - chatId: ".$chatId." - movieURI: ".$movieURI." - number_recommendation_list:".$number_recommendation_list.PHP_EOL);
         $data = null;
      }

      return $data;
   }

   //inserisce la richiesta di why? del film raccomandato
   public function putUserWhyRecMovieRequest($chatId, $movie_name){
      if ($movie !== "null"){
         $movieURI = "http://dbpedia.org/resource/";
         $movieURI .= $movie_name;
         $number_recommendation_list = getNumberRecommendationList($chatId); 
         $why = "why";

         $data = putWhyRecMovieRequest($chatId, $movieURI, $number_recommendation_list, $why);
      }
      else{
         file_put_contents("php://stderr", "userMovieRecommendation->putUserWhyRecMovieRequest - chatId: ".$chatId." - movieURI: ".$movieURI." - number_recommendation_list:".$number_recommendation_list.PHP_EOL);
         $data = null;
      }

      return $data;
   }


   //inserisce il rating come refocus del film raccomandato
   //al momento in disuso fa tutto putUserRefocusRecListRating
   public function putUserRefocusRecMovie($chatId, $movie){
      if ($movie !== "null"){
         $movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore  
         $movieURI = "http://dbpedia.org/resource/";
         $movieURI .= $movie_name;
         $number_recommendation_list = getNumberRecommendationList($chatId); 
         $refocus = "refocus";

         $data = putRefocusRecMovieRating($chatId, $movieURI, $number_recommendation_list, $refocus);
      }
      else{
         file_put_contents("php://stderr", "userMovieRecommendation->putUserRefocusRecMovie - chatId: ".$chatId." - movieURI: ".$movieURI." - number_recommendation_list:".$number_recommendation_list.PHP_EOL);
         $data = null;
      }

      return $data;
   }
   
   //se il numero di film raccomandati valutati è zero puoi avviare il refocus su tutta la lista dei film raccomandati
   public function putUserRefocusRecListRating($chatId){
      $numberRatedRecMovieList = getNumberRatedRecMovieList($chatId);

      if (!$numberRatedRecMovieList > 0) {
         $numberRatedMovies = putRefocusRecListRating($chatId);
      }
      return $numberRatedMovies;
   }

   public function getTitleAndPosterRecMovieToRating($movie){

      $movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore   

      copy('./recsysbot/images/default.jpg', './recsysbot/images/poster.jpg'); //copia nel poster l'immagine di default
      //copy('./../recsysbot/images/default.jpg', './../recsysbot/images/poster.jpg'); //in test

      $data = getAllPropertyListFromMovie($movie_name);

      if ($data == "null") {
         $chatId = $this->getChatId();
         $pagerankCicle = getNumberPagerankCicle($chatId);
         $movie = movieToRatingSelected($chatId, $pagerankCicle);
         $movie_name = str_replace(' ', '_', $movie); //tutti gli spazi con undescore  
         $data = getAllPropertyListFromMovie($movie_name);
         file_put_contents("php://stderr", "ERROR - userMovieRecommendation->getTitleAndPosterMovieToRating - movie_name: ".$movie_name."/return title:".$title.PHP_EOL);
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
         //$img = './../recsysbot/images/poster.jpg'; //in test
         copy($poster, $img); //copia nell'immagine l'immagine del poster
      }

      return $title;
   }

}