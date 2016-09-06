<?php

$accessToken='';
if(isset($_REQUEST['hub_challenge']))
{{
 $challenge = $_REQUEST['hub_challenge'];
 $token =  $_REQUEST['hub_verify_token'];
}
if( $token == "myCustomToken123" )
{
	echo $challenge;
}}
$input = json_decode(file_get_contents('php://input'),true);

$userID = $input['entry'][0]['messaging'][0]['sender']['id'];

$message = $input['entry'][0]['messaging'][0]['message']['text'];

//echo $userID." and ".$message;

//..............
// send me a joke
//tell me a joke
// text me a good joke

$reply = 'I do not understand. Ask me to tell a Joke';

if(preg_match('/(Send|send|Tell|tell|Text|text)(.*?)joke/', $message)){
	$res = json_decode(file_get_contents('http://api.icndb.com/jokes/random'), true);
    $reply = $res['value']['joke'];
	}


$url = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";

$jsonData = "{
	'recipient': {
		'id':$userID
	},
	'message':{
		'text': '".addslashes($reply)."'
	}
}";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

if(!empty($input['entry'][0]['messaging'][0]['message']))
{
	curl_exec($ch);
}
	
