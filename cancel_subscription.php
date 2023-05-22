<?php

$clientId = "<client-id>";

$clientSecret = "<client-secret>";

$base64EncodedAuth = base64_encode($clientId.':'.$clientSecret);

// Authentication
$authUrl = "https://api-m.sandbox.paypal.com/v1/oauth2/token";

$authHeaders = array (
    'Content-Type' => 'application/x-www-form-urlencoded'
);

$authData = array (
    'grant_type' => 'client_credentials'
);


// Access Token Request
$ch = curl_init($authUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json'));
curl_setopt($ch, CURLOPT_USERPWD, $clientId.':'.$clientSecret);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
$return = curl_exec($ch);
curl_close($ch);
$data = json_decode($return, true);

$accessToken = $data['access_token'];

$appId = $data['app_id'];

$subscription_id = "<subscription-id>";

$cancelData = array (
    'reason' => 'Do not want to continue with the subscription'
);


$cancelRequest = json_encode($cancelData);

$cancelUrl = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/" . $subscription_id . "/cancel";

$headers = array(
    'Authorization: Bearer '. $accessToken,
    'Content-Type: application/json',
    'Accept: application/json'
);


// Subscription Request
$ch = curl_init($cancelUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $cancelRequest);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
$cancelReturn = curl_exec($ch);
curl_close($ch);
echo $cancelReturn; die;
$data = json_decode($cancelReturn, true);