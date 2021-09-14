<?php

use Telegram\Bot\Api;
require_once "recsysbot/platforms/Platform.php";

class Telegram implements Platform {
	
	public function getTypingAction() {
		return 'typing';
	}
	
	var $telegram;
	var $config;
	
	public function __construct() {
		$this->config = require 'recsysbot/config/movierecsysbot-config.php';
		$this->telegram = new Api($this->config['telegram_token']);
	}
	
	public function sendMessage($chat_id, $text, $reply_markup) {
		
		$keyboard = $reply_markup['keyboard'];
		$resize_keyboard = $reply_markup['resize_keyboard'] == 1 ? true : false;
		$one_time_keyboard = $reply_markup['one_time_keyboard'] == 1 ? true : false;
		
		$markup = $this->replyKeyboardMarkup([
				'keyboard' => $keyboard,
				'resize_keyboard' => $resize_keyboard,
				'one_time_keyboard' => $one_time_keyboard
		]);
		
		if (isset($reply_markup)) {
			$this->telegram->sendMessage([
					'chat_id' => $chat_id,
					'text' => $text,
					'reply_markup' => $markup,
					'parse_mode' => 'Markdown'
			]);
		} else {
			$this->telegram->sendMessage([
					'chat_id' => $chat_id,
					'text' => $text,
					'parse_mode' => 'Markdown'
			]);
		}
	}
	
	public function sendPhoto($chat_id, $photo, $caption, $reply_markup) {
		
		$keyboard = $reply_markup['keyboard'];
		$resize_keyboard = $reply_markup['resize_keyboard'] == 1 ? true : false;
		$one_time_keyboard = $reply_markup['one_time_keyboard'] == 1 ? true : false;
		
		$markup = $this->replyKeyboardMarkup([
				'keyboard' => $keyboard,
				'resize_keyboard' => $resize_keyboard,
				'one_time_keyboard' => $one_time_keyboard
		]);
		
		if (isset($reply_markup)) {
			$this->telegram->sendPhoto([
					'chat_id' => $chat_id,
					'photo' => $photo,
					'caption' => $caption,
					'reply_markup' => $markup
			]);
		} else {
			$this->telegram->sendPhoto([
					'chat_id' => $chat_id,
					'photo' => $photo,
					'caption' => $caption
			]);
		}
	}
	
	public function sendLink($chat_id, $text, $url, $reply_markup) {
		
		$request_url = "https://api.telegram.org/bot" . $this->config['telegram_token']. "/sendMessage";
		
		$parameters = [
				'chat_id' => $chat_id,
				'text' => $text,
				'reply_markup' => [
						'inline_keyboard' => array(
								array(
										['text' => $text, 'url' => $url]
								)
						)
				]
		];
		$parameters = json_encode($parameters);
		$ch = curl_init($request_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		file_put_contents("php://stderr", "\nResult: " . print_r($result, true) . PHP_EOL);
		
	}
	
	public function sendChatAction($chat_id, $action) {
		
		$chatAction = [
				'chat_id' => $chat_id,
				'action' => $action
		];
		file_put_contents("php://stderr", "Sending chat action: " . print_r($chatAction, true) . PHP_EOL);
		$this->telegram->sendChatAction($chatAction);
	}
	
	private function replyKeyboardMarkup($keyboard) {
		
		$reply_markup = $this->telegram->replyKeyboardMarkup([
				'keyboard' => $keyboard['keyboard'],
				'resize_keyboard' => $keyboard['resize_keyboard'],
				'one_time_keyboard' => $keyboard['one_time_keyboard']
		]);
		
		return $reply_markup;
	}
	
	public function getWebhookUpdates() {
		return $this->telegram->getWebhookUpdates();
	}
	
	public function getMessageInfo($json) {
		
		file_put_contents("php://stderr", "Text:" . $json['message']['text']);
		$message = isset ($json['message']) ? $json['message'] : "";
		
		$info = array(
				'message' => $message,
				'messageId' => isset ($message['message_id']) ? $message['message_id'] : "",
				'chatId' => isset ($message['chat']['id']) ? $message['chat']['id'] : "",
				'firstname' => isset ($message['chat']['first_name']) ? $message['chat']['first_name'] : "",
				'lastname' => isset ($message['chat']['last_name']) ? $message['chat']['last_name'] : "",
				'username' => isset ($message['chat']['username']) ? $message['chat']['username'] : "",
				'date' => isset ($message['date']) ? $message['date'] : "",
				'text' => isset ($message['text']) ? $message['text'] : "",
				'globalDate' => gmdate("Y-m-d\TH:i:s\Z", $date)
		);
		
		return $info;
	}
}

?>
