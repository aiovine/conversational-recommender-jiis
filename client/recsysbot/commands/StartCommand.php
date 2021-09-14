<?php 

namespace Recsysbot\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

/**
 * @author Francesco Baccaro
 */
class StartCommand extends Command
{
    protected $name = "start";
    protected $description = "Bot Start";

    public function handle($arguments)
    {

      $chatId = $this->getTelegram()->getWebhookUpdates()->getMessage()->getChat()->getId();
      $firstname = $this->getTelegram()->getWebhookUpdates()->getMessage()->getChat()->getFirstName();
      $lastname = $this->getTelegram()->getWebhookUpdates()->getMessage()->getChat()->getLastName();
      $username = $this->getTelegram()->getWebhookUpdates()->getMessage()->getChat()->getUserName();
      $date = $this->getTelegram()->getWebhookUpdates()->getMessage()->getdate();

      $this->replyWithChatAction(['action' => Actions::TYPING]);

      $numberRatedMovies = getNumberRatedMovies($chatId);
      $numberRatedProperties = getNumberRatedProperties($chatId);
      $needNumberOfRatedProperties = 3 - ($numberRatedProperties + $numberRatedMovies);

      if ($needNumberOfRatedProperties <= 0){
         $keyboard = userPropertyValueKeyboard();
         $reply_markup = $this->getTelegram()->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
         $text = "Hi ".$firstname." 😃\n";
         $text .= "\nI am now able to recommend you some movies 😃";
         $text .= "\nTap on \"🌐 Recommend Movies\" button, otherwise you can enrich your profile by providing further ratings 😉";
         
         $this->replyWithMessage(['text' => $text, 'reply_markup' => $reply_markup]);      
      }
      else{
            $keyboard = startProfileAcquisitionKeyboard();
            $reply_markup = $this->getTelegram()->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
            $text = "Hi ".$firstname." 😃\n";
            $text .= "Do you like Movies?🍿🍿🍿🍿🍿\nI can find the perfect 🎬 #movie for you, based on your tastes 😉";
            $text .= "\nI need at least 3 preferences for generating recommendations 😉";
            $this->replyWithMessage(['text' => $text, 'reply_markup' => $reply_markup]); 

            $text = "Let me recommend a movie \nPlease, tell me something about you \nor type your preference 🙂";
            $this->replyWithMessage(['text' => $text]); 
      }        
   }
}


