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

$subscriber_email = "<buyer-email-id>";

$request = array(
    "plan_id" => "<plan-id>",
    "start_time" => date('Y-m-d', time() + 86400) . "T00:00:00Z",
    "shipping_amount" => array(
        "currency_code" => "<currency-code>",
        "value" => "20.00"
    ),
    "subscriber" => array(
        "name" => array(
            "given_name" => "John",
            "surname" => "Doe"
        ),
        "email_address" => $subscriber_email,
        "shipping_address" => array(
            "name" => array(
                "full_name" => "John Doe"
            ),
            "address" => array(
                "address_line_1" => "2211 N First Street",
                "address_line_2" => "Building 17",
                "admin_area_2" => "San Jose",
                "admin_area_1" => "CA",
                "postal_code" => "95131",
                "country_code" => "US"
            )
        )
    ),
    "application_context" => array(
        "brand_name" => "Website Subscription",
        "locale" => "en-US",
        "shipping_preference" => "SET_PROVIDED_ADDRESS",
        "user_action" => "SUBSCRIBE_NOW",
        "payment_method" => array(
            "payer_selected" => "PAYPAL",
            "payee_preferred" => "IMMEDIATE_PAYMENT_REQUIRED"
        ),
        "return_url" => "https://example.com/returnUrl",
        "cancel_url" => "https://example.com/cancelUrl"
    )
);

$subsciptionRequest = json_encode($request);

$subscripitonUrl = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions";

$headers = array(
    'Authorization: Bearer '. $accessToken,
    'Content-Type: application/json',
    'Accept: application/json'
);


// Subscription Request
$ch = curl_init($subscripitonUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $subsciptionRequest);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
$subsciptionReturn = curl_exec($ch);
curl_close($ch);
echo $subsciptionReturn; die;
$data = json_decode($subsciptionReturn, true);