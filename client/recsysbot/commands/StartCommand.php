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
         $text = "Hi ".$firstname." π\n";
         $text .= "\nI am now able to recommend you some movies π";
         $text .= "\nTap on \"π Recommend Movies\" button, otherwise you can enrich your profile by providing further ratings π";
         
         $this->replyWithMessage(['text' => $text, 'reply_markup' => $reply_markup]);      
      }
      else{
            $keyboard = startProfileAcquisitionKeyboard();
            $reply_markup = $this->getTelegram()->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
            $text = "Hi ".$firstname." π\n";
            $text .= "Do you like Movies?πΏπΏπΏπΏπΏ\nI can find the perfect π¬ #movie for you, based on your tastes π";
            $text .= "\nI need at least 3 preferences for generating recommendations π";
            $this->replyWithMessage(['text' => $text, 'reply_markup' => $reply_markup]); 

            $text = "Let me recommend a movie \nPlease, tell me something about you \nor type your preference π";
            $this->replyWithMessage(['text' => $text]); 
      }        
   }
}


