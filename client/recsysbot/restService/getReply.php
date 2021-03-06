<?php
use GuzzleHttp\Client;

/**
 * Manda il messaggio dell'utente al server, in modo stateless.
 * La richiesta è in formato HTTP GET e contiene anche le seguenti informazioni
 * (potrebbero cambiare): 
 * @param chatId ID dell'utente.
 * @param messageId ID del messaggio.
 * @param timeStamp Data del messaggio.
 * @param text Testo del messaggio.
 * @param firstname Nome dell'utente.
 * @param botName Nome del bot.
 * @return Risposta del server già json-decodificata (array); attualmente contiene
 * 			'messages' - Testo di risposta del bot,
 * 			'reply_markup' - (Opzionale) Possibili opzioni di risposta dell'utente.
 * 			'auxAPI' - (Opzionale) Indica l'URL che è necessario chiamare per completare la risposta.
 */
function getReply($chatId, $messageId, $timeStamp, $text, $firstname, $botName) {
	
	$config = require 'recsysbot/config/movierecsysbot-config.php';
	
	$userID = $chatId;
	$base_uri = $config['base_uri'];
	$client = new Client ( [
			'base_uri' => $base_uri
	] );
	$stringGetRequest = $config['application_uri'] . 
	'/restService/getReply?userID=' . $userID . 
	'&messageID=' . $messageId . '&timeStamp=' . $timeStamp . 
	'&text=' . urlencode($text) . '&firstname=' . $firstname . '&botName=' . $botName;
	
	file_put_contents ( "php://stderr", '[sendMessageToServer]' . $base_uri . $stringGetRequest . PHP_EOL );
	
	$response = $client->request ( 'GET', $stringGetRequest );
	$bodyMsg = $response->getBody ()->getContents ();
	$data = json_decode ( $bodyMsg, true );

	return $data;
}
