<?php

$accessToken='EAAIbTA14U5IBAPZBcCM7Bh3nYZB3EZALpk2W27N7EUIXwYO3ZC2POZCM2HZCuNhkzvAcz0mQAs1MriuySZBmpVQ447z82c1ZBZAJsYuAFy6usCuwEEydgsA8iWGAwNTMq3VEqkslnlW8EA6ZCveHu6Ruk2Gj6ksTYGKZBxE9f0rY71ZC5QZDZD';
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

echo $userID." and ".$message;

//..............

$url = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";

$jsonData = "{
	'recipient': {
		'id':$userID
	},
	'message':{
		'text': 'hello bro'
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
	