<?php

ob_start();

///////////===[IMPORTING RESOURCES]===///////////

include "./Resources/Vars.php";
include "./Resources/Functions.php";
define('API_KEY',$API_KEY);
error_reporting(0);

///////////===[IMPORTING PLUGINS]===///////////

include "./Plugins/bin.php";
include "./Plugins/iban.php";
include "./Plugins/stripekey.php";
include "./Plugins/weather.php";
include "./Plugins/dictionary.php";
include "./Plugins/proxy.php";
include "./Plugins/covid.php";
include "./Plugins/currency.php";

if (empty($username2)) {
	$username2 = '<a href="tg://user?id=$from_id">$from_fname</a>';
}

////////////////=========[START MESSAGE]=========////////////////

if(strpos($text, "/start") === 0){
    bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"<b>Hey $from_fname,

I'm $USERNAMEBOT. I can do several Things! ❤️

Click the Button Below to open help menu!</b>",
	'parse_mode'=>'html',
	'reply_to_message_id'=> $message_id,
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"Help 💬",'callback_data'=>"help"]]
  ],'resize_keyboard'=>true])
	
  ]);

//////////////////////////////////////////////

if (isset($TG_DUMP_CHAT)) {

    bot('sendmessage',[
	'chat_id'=>$TG_DUMP_CHAT,
	'text'=>"<b>User Started Bot</b>

First Name:- $from_fname
User Name:- @$username2
User ID:- <code>$from_id</code>
Current Time:- <code>$date1</code>",
	'parse_mode'=>'html',
	
  ]);
}

}

////////////////=========[HELP MENU]=========////////////////

if($data == "help"){ //Sends Help Menu if Help Button is clicked
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"<b>Hello there! I'm $USERNAMEBOT
I can do Several Things!</b>

Click on the buttons below to get documentation about specific modules!",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"Bin Checker",'callback_data'=>"bin"],['text'=>"Covid-19 Stats",'callback_data'=>"covid"],['text'=>"Currency Converter",'callback_data'=>"monigay"]],[['text'=>"Dictionary",'callback_data'=>"dict"],['text'=>"IBAN Checker",'callback_data'=>"iban"],['text'=>"Proxy Scrapper",'callback_data'=>"proxy"]],[['text'=>"SK Checker",'callback_data'=>"stripe"],['text'=>"Weather",'callback_data'=>"weather"]],
	],'resize_keyboard'=>true])
	]);
}


////////////////=========[HELP MENU]=========////////////////

if(strpos($text, "/help") === 0){ //Sends Help Menu if User sent /help. 
	bot('sendmessage',[    //Can't use "OR" Operator because it edits the Message in Callback Query and Sends Message in /help.
	'chat_id'=>$chat_id,
	'text'=>"<b>Hello there! I'm $USERNAMEBOT
I can do Several Things!</b>

Click on the buttons below to get documentation about specific modules!",
	'parse_mode'=>'html',
	'reply_to_message_id'=> $message_id,
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"Bin Checker",'callback_data'=>"bin"],['text'=>"Covid-19 Stats",'callback_data'=>"covid"],['text'=>"Currency Converter",'callback_data'=>"monigay"]],[['text'=>"Dictionary",'callback_data'=>"dict"],['text'=>"IBAN Checker",'callback_data'=>"iban"],['text'=>"Proxy Scrapper",'callback_data'=>"proxy"]],[['text'=>"SK Checker",'callback_data'=>"stripe"],['text'=>"Weather",'callback_data'=>"weather"]],
	],'resize_keyboard'=>true])
	]);
}

////////////////=========[CC CHECK]=========////////////////

if (strpos($text, "/chk") === 0){
$lista = substr($text, 5);
$i     = explode("|", $lista);
$cc    = $i[0];
$mon   = $i[1];
$year  = $i[2];
$year1 = substr($yyyy, 2, 4);
$cvv   = $i[3];
error_reporting(0);
if ($_SERVER['REQUEST_METHOD'] == "POST"){
extract($_POST);
}
elseif ($_SERVER['REQUEST_METHOD'] == "GET"){
extract($_GET);
}
function GetStr($string, $start, $end){
$str = explode($start, $string);
$str = explode($end, $str[1]);  
return $str[0];
};
$separa = explode("|", $lista);
$cc = $separa[0];
$mon = $separa[1];
$year = $separa[2];
$cvv = $separa[3];

$skeys = array(
  1 => 'sk_live_69GKI0saLB8uIEnxzv8VTvRX', // Enter at least one sk key
//2 => 'Enter ur sk keys here',-----------------|
//3 => 'Enter ur sk keys here',                 | Uncomment this, if you want to add more sk keys :)
//4 => 'Enter ur sk keys here',                 |
//5 => 'Enter ur sk keys here',-----------------|
); 
$skey = array_rand($skeys);
$sk = $skeys[$skey];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cc.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$fim = curl_exec($ch);
$bank = GetStr($fim, '"bank":{"name":"', '"');
$name = GetStr($fim, '"name":"', '"');
$brand = GetStr($fim, '"brand":"', '"');
$country = GetStr($fim, '"country":{"name":"', '"');
$scheme = GetStr($fim, '"scheme":"', '"');
$type = GetStr($fim, '"type":"', '"');
if(strpos($fim, '"type":"credit"') !== false){
$bin = 'Credit';
}else{
$bin = 'Debit';
};
curl_close($ch);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-Type: application/x-www-form-urlencoded',));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'name=Alina Rebeckert');
$f = curl_exec($ch);
$info = curl_getinfo($ch);
$time = $info['total_time'];
$httpCode = $info['http_code'];
$time = substr($time, 0, 4);
$id = trim(strip_tags(GetStr($f,'"id": "','"')));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/setup_intents');
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-Type: application/x-www-form-urlencoded',));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'payment_method_data[type]=card&customer='.$id.'&confirm=true&payment_method_data[card][number]='.$cc.'&payment_method_data[card][exp_month]='.$mon.'&payment_method_data[card][exp_year]='.$year.'&payment_method_data[card][cvc]='.$cvv.'');
$result = curl_exec($ch);
$info = curl_getinfo($ch);
$time = $info['total_time'];
$httpCode = $info['http_code'];
$time = substr($time, 0, 4);
$c = json_decode(curl_exec($ch), true);
curl_close($ch);
$pam = trim(strip_tags(GetStr($result,'"payment_method": "','"')));
$cvv = trim(strip_tags(GetStr($result,'"cvc_check": "','"')));
if ($c["status"] == "succeeded"){ 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'.$id.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');  
curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');  
$result = curl_exec($ch);
curl_close($ch);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods/'.$pam.'/attach'); 
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'customer='.$id.'');
$result = curl_exec($ch);
$attachment_to_her = json_decode(curl_exec($ch), true);
curl_close($ch);
$attachment_to_her;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/charges'); 
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, '&amount=100&currency=usd&customer='.$id.'');
$result = curl_exec($ch);
if (!isset($attachment_to_her["error"]) && isset($attachment_to_her["id"]) && $attachment_to_her["card"]["checks"]["cvc_check"] == "pass"){  
$skresult = "APPROVED!";
$skresponse = "CVV MATCHES!";
}else{
$skresult = "UNCHECKED";
$skresponse = "UNAVAILABLE";
}}
elseif(strpos($result, '"cvc_check": "pass"')){
$skresult = "APPROVED!";
$skresponse = "OLD CVV!";
}
elseif(strpos($result, 'security code is incorrect')){
$skresult = "APPROVED!";
$skresponse = "CCN APPROVED!";
}
elseif (isset($c["error"])){
$skresult = "DECLINED!";
$skresponse = ''. $c["error"]["message"] . ' ' . $c["error"]["decline_code"] .'';
}else{
$skresult = "UNCHECKED";
$skresponse = "GATE FUCKED!";
};
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'.$id.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
curl_exec($ch);
curl_close($ch);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'.$id.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
curl_exec($ch);
curl_close($ch);

sendMessage($chat_id, '<u>CARD:</u> <code>'.$lista.'</code>%0A<u>STATUS:</u> <b>'.$skresult.'</b>%0A<u>RESPONSE:</u> <b>'.$skresponse.'</b>%0A%0A----- BinData -----%0A<b>Bank:</b> '.$bank.'%0A<b>Country:</b> '.$name.'%0A<b>Brand:</b> '.$brand.'%0A<b>Card:</b> '.$scheme.'%0A<b>Type:</b> '.$type.'%0A--------------------<u>%0A%0AChecked By:</u> @'.$username2.'<u>%0ATime Taken:</u> <b>'.$time.'s</b>%0A%0A<b>Bot Made by: @IndianBinner</b>', $message_id);
}

////////////////=========[BIN INFO]=========////////////////

if($data == "bin"){
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"<b>🌀 Bin Checker 🌀

Command:</b>

/bin <code>&lt;bin&gt;</code> - Checks the Bin and Provides Information",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"Return",'callback_data'=>"help"]],
	],'resize_keyboard'=>true])
	]);
}


////////////////=========[COVID-19 STATS]=========////////////////

if($data == "covid"){
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"<b>🌀 Covid-19 Stats 🌀

Command:</b>

/covid - Provides Worldwide Covid-19 Stats
/covid <code>&lt;country&gt;</code> - Provides Covid-19 Stats for the Given Country",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"Return",'callback_data'=>"help"]],
	],'resize_keyboard'=>true])
	]);
}


////////////////=========[CURRENCY CONVERTER]=========////////////////

if($data == "monigay"){
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"<b>🌀 Currency Converter 🌀

Command:</b>

/cash <code>&lt;Value&gt;&lt;from&gt;&lt;to&gt;</code> - Converts the Currency

<b>Example:- /cash 20 USD INR - Converts 20 USD to INR</b>",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"Return",'callback_data'=>"help"]],
	],'resize_keyboard'=>true])
	]);
}


////////////////=========[DICTIONARY]=========////////////////

if($data == "dict"){
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"<b>🌀 Dictionary 🌀

Command:</b>

/dict <code>&lt;word&gt;</code> - Provides the Meaning of the Given Word.",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"Return",'callback_data'=>"help"]],
	],'resize_keyboard'=>true])
	]);
}


////////////////=========[IBAN CHECKER]=========////////////////

if($data == "iban"){
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"<b>🌀 IBAN Checker 🌀

Command:</b>

/iban <code>&lt;iban&gt;</code> - Checks if the Provided IBAN is Valid or Invalid.",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"Return",'callback_data'=>"help"]],
	],'resize_keyboard'=>true])
	]);
}


////////////////=========[STRIPE KEY CHECKER]=========////////////////

if($data == "stripe"){
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"<b>🌀 SK Key Checker 🌀

Command:</b>

/sk <code>&lt;sk_live_xxxx&gt;</code> - Checks if the Provided Stripe API Key is Valid or Invalid.",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"Return",'callback_data'=>"help"]],
	],'resize_keyboard'=>true])
	]);
}


////////////////=========[PROXY]=========////////////////

if($data == "proxy"){
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"<b>🌀 Proxy Scrapper 🌀

Command:</b>

/http - Sends Fresh HTTPs Proxies
/socks4 - Sends Fresh Socks4 Proxies
/socks5 - Sends Fresh Socks5 Proxies",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"Return",'callback_data'=>"help"]],
	],'resize_keyboard'=>true])
	]);
}


////////////////=========[WEATHER INFO]=========////////////////

if($data == "weather"){
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"<b>🌀 Weather Info 🌀

Command:</b>

/weather <code>&lt;Name of City&gt;</code> - Provides the Current Weather of the Provided City.

<b>Note:-</b> <code>It only Supports Cities.</code>",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"Return",'callback_data'=>"help"]],
	],'resize_keyboard'=>true])
	]);
}


?>
