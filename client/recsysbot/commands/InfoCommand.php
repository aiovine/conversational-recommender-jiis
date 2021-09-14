<?php 

namespace Recsysbot\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

/**
 * @author Francesco Baccaro
 */
class InfoCommand extends Command
{
    protected $name = "info";
    protected $description = "Information about the Bot";

    public function handle($arguments)
    {
        //$telegram->sendMessage(['chat_id' => $chatId, 'text' => 'info...']);
        $text = <<<BOT
@MovieRecSysBot

A movie recommender system, disigned and developed by the 
SWAP (Semantic Web Access and Personalization) Research Group - University of Bari "Aldo Moro"

Developer: 
Francesco Baccaro
eMail: baccaro.f@gmail.com

Info: 
Fedelucio Narducci
eMail: fedelucio.narducci@uniba.it 

Francesco Baccaro
eMail: baccaro.f@gmail.com


BOT;

        $this->replyWithMessage(['text' => $text]);
        $this->triggerCommand('start');
   }
}
?>