<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;


$account_sid = "AC489b1ba5f8de3366d43be2308a4a39cc";
$auth_token = "0d0337410de1fcc99534979eea54c43c";
$endpoint = "https://api.twilio.com/2010-04-01/Accounts/$account_sid/Balance.json";

// Define the Guzzle Client
$client = new Client();

$response = $client->get($endpoint, [
   'auth' => [
       $account_sid,
       $auth_token
   ]
]);

$body = $response->getBody()->getContents();

// echo $body;

$data = json_decode($body, true);
?>