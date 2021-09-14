<?php

function sendMessageURI() {
	return 'https://graph.facebook.com/v2.6/me/messages?access_token=' . token();
}
	
function token() {
	return '<hidden>';
}