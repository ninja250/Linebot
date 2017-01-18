<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mainController extends Controller
{
    public function index(Request$request){

      $request = file_get_contents("php://input");
$json = json_decode($request);
$content = $json->result[0]->content;

$header = array(
    'Content-Type: application/json; charser=UTF-8',
    'X-Line-ChannelID: 【Channel　IDを指定】',  // Channel ID
    'X-Line-ChannelSecret: 【ChannelID　Secretを指定】',  // ChannelID Secret
    'X-Line-Trusted-User-With-ACL: 【MIDを指定】',  // MID
);
$post = array(
    'to' => array($content->from),
    'toChannel' => 1383378250,  // Fixed value.
    'eventType' => '138311608800106203',  // Fixed value.
    'content' => array(
        'contentType' => 1,
        'toType' => 1,
    ),
);

// ボットが返答する内容。ここでは送られた内容を復唱するだけ
$post['content']['text'] = $content->text.' ですね';

$post = json_encode($post);

$ch = curl_init("https://linebot-system.herokuapp.com/");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

    }
}
