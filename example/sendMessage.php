<?php

require '../vendor/autoload.php';

use Nilsonpessim\ApiConnect\WhatsApp;

$url   = "https://your-url";
$token = "your-token";

$body  = [
    "number" => "to-number",
    "body"   => "your-message"
];

$whatsApp = (new WhatsApp($url, $token))->sendMessage($body);