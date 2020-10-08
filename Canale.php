<?php

$token = '1386263740:AAFVg7_JPkYl7TAIZpaP8uu3iL-bLN5zcnU';

$website = 'https://api.telegram.org/bot'.$token;

$update = file_get_contents('php://input');

$update = json_decode($update, true);

$text = $update['message']['text'];

$id = $update['message']['from']['id'];

$chatid = $update['message']['chat']['id'];

$name = htmlspecialchars($update['message']['from']['first_name']);

$msgid = $update['message']['message_id'];

$group = -1001163914190;

$getme = json_decode(getMe(), true);

$botid = $getme['result']['id'];

if($chatid != $group or $id == $botid) exit();

$member = json_decode(getChatMember('@LoxisNews', $id), true);

if($member['ok'] != true or $member['result']['status'] == 'left' or $member['result']['status'] == 'kicked'){

 kickChatMember($group, $id);

    unbanChatMember($group, $id);

    deleteMessage($group, $msgid);

    deleteMessage($group, $msgid + 1);

    sendMessage($id, "<b>Non puoi entrare nel gruppo, prima iscriviti a</b> @LoxisNews");

    exit();

}

if(isset($update["message"]['new_chat_member'])){

 sendMessage($group, "<b>$name è entrato nel gruppo!</b>");

}

function sendMessage($id, $text){

 $url = $GLOBALS["website"]."/sendMessage?chat_id=$id&parse_mode=HTML&text=".urlencode($text);

    file_get_contents($url);

}

function getChatMember($chatid, $id){

 $url = $GLOBALS["website"]."/getChatMember?chat_id=$chatid&user_id=$id";

    return file_get_contents($url);

}

function deleteMessage($id, $msgid){

 $url = $GLOBALS["website"]."/deleteMessage?chat_id=$id&message_id=$msgid";

    file_get_contents($url);

}

function kickChatMember($chatid, $id){

 $url = $GLOBALS["website"]."/kickChatMember?chat_id=$chatid&user_id=$id";

    file_get_contents($url);

}

function unbanChatMember($chatid, $id){

 $url = $GLOBALS["website"]."/unbanChatMember?chat_id=$chatid&user_id=$id";

    file_get_contents($url);

}

function getMe(){

 $url = $GLOBALS["website"]."/getMe";

    return file_get_contents($url);

}

?>
