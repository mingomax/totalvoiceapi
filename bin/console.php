#!/usr/bin/env php
<?php

if ($argc < 3) {

    echo "Send single SMS Message.\n
        Usage:
        send \"TO\"  \"MESSAGE\"
    ";
    die(1);
}

$showerror = function() {
    echo "Missing parameter";
    exit(1);
};

$to = isset($argv[1])? $argv[1] : $showerror();
$message = isset($argv[2])? $argv[2] : $showerror();

require __DIR__ . "/../vendor/autoload.php";
defined('API_KEY') || define('API_KEY', (getenv('TOTALVOICE_ACCESS_TOKEN') ?: 'apikey'));

$client = new \Dteruel\Clients\TotalVoice(API_KEY);

$client->sendSms($message, $to);

echo "Sua mensagem para {$to} foi enviada." . PHP_EOL;