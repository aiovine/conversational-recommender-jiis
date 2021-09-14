<?php 

namespace Recsysbot\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

/**
 * @author Francesco Baccaro
 */
class ResetCommand extends Command
{
    protected $name = "reset";
    protected $description = "Reset all rated movie or property";

    public function handle($arguments){
        $chatId = $this->getTelegram()->getWebhookUpdates()->getMessage()->getChat()->getId();
        $firstname = $this->getTelegram()->getWebhookUpdates()->getMessage()->getChat()->getFirstName();
        //file_put_contents("php://stderr", '/reset - chatId:'.$chatId.PHP_EOL);

        $argumentArray = explode (' ', $arguments);
/*        foreach ($argumentArray as $key => $value) {
             file_put_contents("php://stderr", 'Argument['. $key. ']: '. $value.PHP_EOL);
         }*/

        $resetArguments = $argumentArray[0];
        $resetArguments = strtolower($resetArguments);
         if (strpos($resetArguments, 'properties') !== false) {
            $text = $this->resetAllPropertyRated($chatId, $firstname);

            $keyboard = startProfileAcquisitionKeyboard();
            $reply_markup = $this->getTelegram()->replyKeyboardMarkup(['keyboard' => $keyboard,  'resize_keyboard' => true, 'one_time_keyboard' => false]);

            $this->replyWithChatAction(['action' => Actions::TYPING]);
            $this->replyWithMessage(['text' => $text, 'reply_markup' => $reply_markup]);
            $this->triggerCommand('start');
         }
         elseif (strpos($resetArguments, 'movies') !== false) {
            $text = $this->resetAllMovieRated($chatId, $firstname);

            $keyboard = startProfileAcquisitionKeyboard();
            $reply_markup = $this->getTelegram()->replyKeyboardMarkup(['keyboard' => $keyboard,  'resize_keyboard' => true, 'one_time_keyboard' => false]);

            $this->replyWithChatAction(['action' => Actions::TYPING]);
            $this->replyWithMessage(['text' => $text, 'reply_markup' => $reply_markup]);
            $this->triggerCommand('start');
         }
         elseif (strpos($resetArguments, 'all') !== false) {
            $text = $this->resetAllProfile($chatId, $firstname);

            $keyboard = startProfileAcquisitionKeyboard();
            $reply_markup = $this->getTelegram()->replyKeyboardMarkup(['keyboard' => $keyboard,  'resize_keyboard' => true, 'one_time_keyboard' => false]);

            $this->replyWithChatAction(['action' => Actions::TYPING]);
            $this->replyWithMessage(['text' => $text, 'reply_markup' => $reply_markup]);
            $this->triggerCommand('start');
         }
         elseif (strpos($resetArguments, 'chat') !== false) {
            $text = $this->resetAllChatMessage($chatId, $firstname);

            $keyboard = startProfileAcquisitionKeyboard();
            $reply_markup = $this->getTelegram()->replyKeyboardMarkup(['keyboard' => $keyboard,  'resize_keyboard' => true, 'one_time_keyboard' => false]);

            $this->replyWithChatAction(['action' => Actions::TYPING]);
            $this->replyWithMessage(['text' => $text, 'reply_markup' => $reply_markup]);
            $this->triggerCommand('start');
         }
         elseif (strpos($resetArguments, 'rec') !== false) {
            $text = $this->resetAllRecMovies($chatId, $firstname);

            $keyboard = startProfileAcquisitionKeyboard();
            $reply_markup = $this->getTelegram()->replyKeyboardMarkup(['keyboard' => $keyboard,  'resize_keyboard' => true, 'one_time_keyboard' => false]);

            $this->replyWithChatAction(['action' => Actions::TYPING]);
            $this->replyWithMessage(['text' => $text, 'reply_markup' => $reply_markup]);
            $this->triggerCommand('start');
         }
         else{
            $this->replyWithChatAction(['action' => Actions::TYPING]);
            $this->replyWithMessage(['text' => '😕 Reset format is incorrect', 'reply_markup' => $reply_markup]);
            $text = "You can use the following format:\n- /reset movies\n- /reset properties\n- /reset all";

            $keyboard = startProfileAcquisitionKeyboard();

            $reply_markup = $this->getTelegram()->replyKeyboardMarkup(['keyboard' => $keyboard,  'resize_keyboard' => true, 'one_time_keyboard' => false]);

            $this->replyWithChatAction(['action' => Actions::TYPING]);
            $this->replyWithMessage(['text' => $text, 'reply_markup' => $reply_markup]);
         }        
    }

   private function resetAllPropertyRated($chatId, $firstname){
      $data = deleteAllPropertyRated($chatId);        
      $newNumberOfRatedProperties = $data;

      if ($newNumberOfRatedProperties == 0) {
         $text = "All right ".$firstname.", I deleted all your preferences";
      } else{
         $text = "Sorry ".$firstname.", there is a problem to reset all properties that you have evaluated";
      }
      return $text;
    }

   private function resetAllMovieRated($chatId, $firstname){
      $data = deleteAllMovieRated($chatId);          
      $newNumberOfRatedMovies = $data;

      if ($newNumberOfRatedMovies == 0 ) {
         $text = "All right ".$firstname.", I deleted all your movie preferences";
      } else{
         $text = "Sorry ".$firstname.", there is a problem to delete your movie preferences";
      }
      return $text;
   }

   private function resetAllProfile($chatId, $firstname){
      $data = deleteAllProfile($chatId);          
      $newNumberPagerankCicle = $data;

      if ($newNumberPagerankCicle == 0 ) {
         $text = "All right ".$firstname.", I deleted all your preferences";
      } else{
         $text = "Sorry ".$firstname.", there is a problem to delete your movie preferences";
      }
      return $text;

   }

   private function resetAllChatMessage($chatId, $firstname){
      $data = deleteAllChatMessage($chatId);      
      $newNumberPagerankCicle = $data;

      if ($newNumberPagerankCicle == 0) {
         $text = "All right ".$firstname.", I deleted all your chat messages ";
      } else{
         $text = "Sorry ".$firstname.", there is a problem to delete your chat messages";
      }
      return $text;
    }

   private function resetAllRecMovies($chatId, $firstname){
      deleteAllRecMovies($chatId);
      $text = "All right ".$firstname.", I deleted all your recommended movies";

      return $text;
   }


}
