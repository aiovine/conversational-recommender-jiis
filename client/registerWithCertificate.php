<?php

// PARAMETRI DA MODIFICARE
$WEBHOOK_URL = '<Put client path here>/execute.php';
$BOT_TOKEN = '<Insert Telegram token here>';
$CERTIFICATE_PATH = '<Put SSL certificate path here>';
// NOTA: Il certificato scadrà il 21/02/2019!

// NON APPORTARE MODIFICHE NEL CODICE SEGUENTE
$API_URL = 'https://api.telegram.org/bot' . $BOT_TOKEN .'/';
$method = 'setWebhook';
$parameters = array(
      'url' => $WEBHOOK_URL,
      'certificate' => '@'.realpath($CERTIFICATE_PATH)
    );
$url = $API_URL . $method;
$handle = curl_init($url);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $parameters);
curl_setopt($handle, CURLOPT_SAFE_UPLOAD, false);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true); //true
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5); //5
curl_setopt($handle, CURLOPT_TIMEOUT, 60); //60
print_r($parameters);
$result = curl_exec($handle);
print_r($result);
