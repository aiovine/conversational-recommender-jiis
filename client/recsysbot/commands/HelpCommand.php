<?php

namespace Recsysbot\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

/**
 * @author Francesco Baccaro
 */
class HelpCommand extends Command
{
    protected $name = "help"; //this is the string the user write
    protected $description = "Help - Info & commands";

    public function handle($arguments)
    {
        
        $firstname = $this->getTelegram()->getWebhookUpdates()->getMessage()->getChat()->getFirstName();
        
        $text = "Hi ".$firstname." 😃";
        $text .= "\nDo you like Movies?🍿🍿🍿🍿🍿 \nI can find the perfect 🎬 #movie for you, based on your tastes 😉
In the following, we will ask you some information about you and your preferences in the movie domain.
Next, you will receive a list of recommended movies and you will be asked to evaluate the goodness of the recommendations.
You can improve the recommendations by telling me what you like and what you dislike in the recommended movies.
You can also ask why a movie has been recommended by tapping the “Why?” button.";
        $this->replyWithMessage(['text' => $text]);

        $text = "Here you find the available commands";

        $this->replyWithMessage([
            'text' => $text
            ]);
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        // This will prepare a list of available commands and send the user.
        // First, Get an array of all registered commands
        // They'll be in 'command-name' => 'Command Handler Class' format.
        $commands = $this->getTelegram()->getCommands();
        // Build the list
        $response = '';
        foreach ($commands as $name => $command) {
            $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
        }
        $this->replyWithMessage([
            'text' => $response
            ]);

        // Trigger another command dynamically from within this command
        // When you want to chain multiple commands within one or process the request further.
        // The method supports second parameter arguments which you can optionally pass, By default
        // it'll pass the same arguments that are received for this command originally.
        //$this->triggerCommand('subscribe');
    }
}

